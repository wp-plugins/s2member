<?php
/*
Copyright: © 2009 WebSharks, Inc. ( coded in the USA )
<mailto:support@websharks-inc.com> <http://www.websharks-inc.com/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/
/*
Direct access denial.
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/*
Forces a default Role for new registrations, NOT tied to an incoming payment.
Attach to: add_filter("pre_option_default_role");
*/
if (!function_exists ("ws_plugin__s2member_force_default_role"))
	{
		function ws_plugin__s2member_force_default_role ($default_role = FALSE)
			{
				do_action ("ws_plugin__s2member_before_force_default_role", get_defined_vars ());
				/**/
				return apply_filters ("ws_plugin__s2member_force_default_role", ($default_role = "subscriber"), get_defined_vars ());
			}
	}
/*
Forces a default Role for new Multisite registrations ( on the Main Site ) NOT tied to an incoming payment.
Attach to: add_filter("pre_site_option_default_user_role");
*/
if (!function_exists ("ws_plugin__s2member_force_mms_default_role"))
	{
		function ws_plugin__s2member_force_mms_default_role ($default_role = FALSE)
			{
				do_action ("ws_plugin__s2member_before_force_mms_default_role", get_defined_vars ());
				/**/
				return apply_filters ("ws_plugin__s2member_force_mms_default_role", ($default_role = "subscriber"), get_defined_vars ());
			}
	}
/*
Allows new Users to be created on a Multisite Network.
Attach to: add_filter("pre_site_option_add_new_users");
*/
if (!function_exists ("ws_plugin__s2member_mms_allow_new_users"))
	{
		function ws_plugin__s2member_mms_allow_new_users ($allow = FALSE)
			{
				do_action ("ws_plugin__s2member_before_mms_allow_new_users", get_defined_vars ());
				/**/
				return apply_filters ("ws_plugin__s2member_mms_allow_new_users", ($allow = "1"), get_defined_vars ());
			}
	}
/*
Forces a Multisite Dashboard Blog to be the Main Site.
Attach to: add_filter("pre_site_option_dashboard_blog");
*/
if (!function_exists ("ws_plugin__s2member_mms_dashboard_blog"))
	{
		function ws_plugin__s2member_mms_dashboard_blog ($dashboard_blog = FALSE)
			{
				global $current_site, $current_blog; /* For Multisite support. */
				/**/
				do_action ("ws_plugin__s2member_before_mms_dashboard_blog", get_defined_vars ());
				/**/
				$main_site = ((is_multisite ()) ? $current_site->blog_id : "1"); /* Forces the Main Site. */
				/**/
				return apply_filters ("ws_plugin__s2member_mms_dashboard_blog", ($dashboard_blog = $main_site), get_defined_vars ());
			}
	}
/*
Function for allowing access to the Registration Form.
This function has been further optimized to reduce DB queries.
Attach to: add_filter("pre_option_users_can_register");
*/
if (!function_exists ("ws_plugin__s2member_check_register_access"))
	{
		function ws_plugin__s2member_check_register_access ($users_can_register = FALSE)
			{
				global $wpdb; /* Global database object reference */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_check_register_access", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$by_default = $users_can_register = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["allow_subscribers_in"];
				/**/
				if (is_multisite () && ws_plugin__s2member_is_multisite_farm () && is_main_site ())
					return apply_filters ("ws_plugin__s2member_check_register_access", ($users_can_register = "0"), get_defined_vars ());
				/**/
				else if (!is_admin () && !$users_can_register) /* Do NOT run these security checks on option pages; it's confusing to a site owner. */
					if (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || !is_main_site () || is_super_admin () || current_user_can ("create_users"))
						{
							if ((is_multisite () && is_super_admin ()) || current_user_can ("create_users") || (($subscr_id = ws_plugin__s2member_decrypt ($_COOKIE["s2member_subscr_id"])) && preg_match ("/^" . preg_quote (preg_replace ("/\:([0-9]+)$/", "", $_SERVER["HTTP_HOST"]), "/") . "/i", ($custom = ws_plugin__s2member_decrypt ($_COOKIE["s2member_custom"]))) && preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", ($level = ws_plugin__s2member_decrypt ($_COOKIE["s2member_level"]))) && !($exists = $wpdb->get_var ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1"))))
								{
									return apply_filters ("ws_plugin__s2member_check_register_access", ($users_can_register = "1"), get_defined_vars ());
								}
						}
				/**/
				return apply_filters ("ws_plugin__s2member_check_register_access", $users_can_register, get_defined_vars ());
			}
	}
/*
Function for allowing access to the main Multisite Registration Form.
This function has been further optimized to reduce DB queries.
Attach to: add_filter("pre_site_option_registration");
*/
if (!function_exists ("ws_plugin__s2member_check_mms_register_access"))
	{
		function ws_plugin__s2member_check_mms_register_access ($users_can_register = FALSE)
			{
				global $wpdb; /* Global database object reference */
				global $current_site, $current_blog; /* For Multisite support. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_check_register_access", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$by_default = $users_can_register = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_grants"];
				/**/
				if (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || !is_main_site ()) /* NOT a Blog Farm. */
					return apply_filters ("ws_plugin__s2member_check_mms_register_access", ($users_can_register = "none"), get_defined_vars ());
				/**/
				else if (!is_admin () && $users_can_register !== "all") /* Do NOT run these security checks on option pages; it's confusing to a site owner. */
					{
						if (is_super_admin () || current_user_can ("create_users") || (($subscr_id = ws_plugin__s2member_decrypt ($_COOKIE["s2member_subscr_id"])) && preg_match ("/^" . preg_quote (preg_replace ("/\:([0-9]+)$/", "", $_SERVER["HTTP_HOST"]), "/") . "/i", ($custom = ws_plugin__s2member_decrypt ($_COOKIE["s2member_custom"]))) && preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", ($level = ws_plugin__s2member_decrypt ($_COOKIE["s2member_level"]))) && !($exists = $wpdb->get_var ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1"))))
							{
								if (is_super_admin () || current_user_can ("create_users"))
									{
										return apply_filters ("ws_plugin__s2member_check_mms_register_access", ($users_can_register = "all"), get_defined_vars ());
									}
								else if ($subscr_id && $custom && $level) /* A paying Customer? Cookies have already been authenticated above. */
									{
										list ($level) = preg_split ("/\:/", $level, 1); /* Parse out the level now. */
										/**/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_blogs_level" . $level])
											{
												return apply_filters ("ws_plugin__s2member_check_mms_register_access", ($users_can_register = "all"), get_defined_vars ());
											}
										else /* Otherwise, we MUST allow them to create an account; they paid for it! */
											{
												return apply_filters ("ws_plugin__s2member_check_mms_register_access", ($users_can_register = "user"), get_defined_vars ());
											}
									}
							}
						/* --------------------> $users_can_register !== "all", so exclude Level #0. */
						else if (is_user_logged_in () && current_user_can ("access_s2member_level1") && is_object ($current_user = wp_get_current_user ()))
							{
								$blogs_allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_blogs_level" . ws_plugin__s2member_user_access_level ()];
								$current_user_blogs = (is_array ($blogs = get_blogs_of_user ($current_user->ID))) ? count ($blogs) - 1 : 0;
								$current_user_blogs = ($current_user_blogs >= 0) ? $current_user_blogs : 0;
								$blogs_allowed = ($blogs_allowed >= 0) ? $blogs_allowed : 0;
								/**/
								if ($current_user_blogs < $blogs_allowed) /* Are they within their limit? */
									{
										return apply_filters ("ws_plugin__s2member_check_mms_register_access", ($users_can_register = "all"), get_defined_vars ());
									}
							}
					}
				/**/
				else if (!is_admin () && $users_can_register === "all") /* Do NOT run these security checks on option pages; it's confusing to a site owner. */
					{
						if (is_user_logged_in () && is_object ($current_user = wp_get_current_user ()))
							{
								$blogs_allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_blogs_level" . ws_plugin__s2member_user_access_level ()];
								$current_user_blogs = (is_array ($blogs = get_blogs_of_user ($current_user->ID))) ? count ($blogs) - 1 : 0;
								$current_user_blogs = ($current_user_blogs >= 0) ? $current_user_blogs : 0;
								$blogs_allowed = ($blogs_allowed >= 0) ? $blogs_allowed : 0;
								/**/
								if ($current_user_blogs >= $blogs_allowed) /* Are they at their limit? */
									{
										return apply_filters ("ws_plugin__s2member_check_mms_register_access", ($users_can_register = "none"), get_defined_vars ());
									}
							}
					}
				/**/
				return apply_filters ("ws_plugin__s2member_check_mms_register_access", $users_can_register, get_defined_vars ());
			}
	}
/*
Function that describes the General Option overrides for clarity.
Attach to: add_action("admin_init");
*/
if (!function_exists ("ws_plugin__s2member_general_ops_notice"))
	{
		function ws_plugin__s2member_general_ops_notice ()
			{
				global $pagenow; /* Need this. */
				/**/
				do_action ("ws_plugin__s2member_before_general_ops_notice", get_defined_vars ());
				/**/
				if (is_admin () && $pagenow === "options-general.php" && !isset ($_GET["page"]) && !is_multisite ()) /* Multisite does NOT provide these options. */
					{
						$notice = "<em>* Note: The s2Member plugin has control over two options on this page.<br /><code>Allow Open Registration = " . esc_html (get_option ("users_can_register")) . "</code>, and <code>Default Role = " . esc_html (get_option ("default_role")) . "</code>.<br />For further details, see: <code>s2Member -> General Options -> Open Registration</code>.";
						/**/
						$js = '<script type="text/javascript">';
						$js .= "jQuery('input#users_can_register, select#default_role').attr('disabled', 'disabled');";
						$js .= '</script>';
						/**/
						do_action ("ws_plugin__s2member_during_general_ops_notice", get_defined_vars ());
						/**/
						ws_plugin__s2member_enqueue_admin_notice ($notice . $js, $pagenow);
					}
				/**/
				do_action ("ws_plugin__s2member_after_general_ops_notice", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function that describes the Multisite Option overrides for clarity.
Attach to: add_action("admin_init");
*/
if (!function_exists ("ws_plugin__s2member_multisite_ops_notice"))
	{
		function ws_plugin__s2member_multisite_ops_notice ()
			{
				global $pagenow; /* Need this. */
				/**/
				do_action ("ws_plugin__s2member_before_multisite_ops_notice", get_defined_vars ());
				/**/
				if (is_admin () && $pagenow === "ms-options.php" && !isset ($_GET["page"]) && is_multisite ()) /* Only with Multisite Networking enabled. */
					{
						$notice = "<em>* Note: The s2Member plugin has control over four options on this page.<br /><code>Dashboard Blog = " . esc_html (get_site_option ("dashboard_blog")) . " / Main Site</code>, <code>Default Role = " . esc_html (get_site_option ("default_user_role")) . "</code>, <code>Allow Open Registration = " . esc_html (get_site_option ("registration")) . "</code>, and <code>Add New Users = " . esc_html (get_site_option ("add_new_users")) . "</code>.<br />In your Dashboard ( on the Main Site ), see: <code>s2Member -> Multisite ( Config )</code>.";
						/**/
						$js = '<script type="text/javascript">';
						$js .= "jQuery('input#dashboard_blog, select#default_user_role, input[name=registration], input#add_new_users').attr('disabled', 'disabled');";
						$js .= '</script>';
						/**/
						do_action ("ws_plugin__s2member_during_multisite_ops_notice", get_defined_vars ());
						/**/
						ws_plugin__s2member_enqueue_admin_notice ($notice . $js, $pagenow);
					}
				/**/
				do_action ("ws_plugin__s2member_after_multisite_ops_notice", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function that adds custom fields to `/wp-admin/user-new.php`.
We have to buffer output because `/user-new.php` has NO Hooks.
Attach to: add_action("admin_init");
*/
if (!function_exists ("ws_plugin__s2member_admin_user_new_fields"))
	{
		function ws_plugin__s2member_admin_user_new_fields ()
			{
				global $pagenow; /* The current admin page file name. */
				/**/
				do_action ("ws_plugin__s2member_before_admin_user_new_fields", get_defined_vars ());
				/**/
				if (is_admin () && $pagenow === "user-new.php" && current_user_can ("create_users"))
					{
						ob_start ("_ws_plugin__s2member_admin_user_new_fields"); /* No Hooks, so we buffer. */
						/**/
						do_action ("ws_plugin__s2member_during_admin_user_new_fields", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_admin_user_new_fields", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Callback that adds custom fields to `/wp-admin/user-new.php`.
We have to buffer output because `/user-new.php` has NO Hooks.
Attach to: ob_start("_ws_plugin__s2member_admin_user_new_fields");
*/
if (!function_exists ("_ws_plugin__s2member_admin_user_new_fields"))
	{
		function _ws_plugin__s2member_admin_user_new_fields ($buffer = FALSE)
			{
				global $pagenow; /* The current admin page file name. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("_ws_plugin__s2member_before_admin_user_new_fields", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_admin () && $pagenow === "user-new.php" && current_user_can ("create_users"))
					{
						$_POST = ws_plugin__s2member_trim_deep (stripslashes_deep ($_POST));
						/**/
						$unfs = '<div style="margin:25px 0 25px 0; height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
						/**/
						$unfs .= '<h3 style="position:relative;"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/large-icon.png" title="s2Member ( a Membership management system for WordPress® )" alt="" style="position:absolute; top:-15px; right:0; border:0;" />s2Member Configuration &amp; Profile Fields' . ((is_multisite ()) ? ' ( for this Blog )' : '') . '</h3>' . "\n";
						/**/
						$unfs .= '<table class="form-table">' . "\n";
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_multisite ()) /* Multisite Networking is currently lacking these fields; we pop them in. */
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_first_name", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								$unfs .= '<tr>' . "\n";
								$unfs .= '<th><label>First Name:</label></th>' . "\n";
								$unfs .= '<td><input type="text" name="ws_plugin__s2member_user_new_first_name" value="' . format_to_edit ($_POST["ws_plugin__s2member_user_new_first_name"]) . '" class="regular-text" /></td>' . "\n";
								$unfs .= '</tr>' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_first_name", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_last_name", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								$unfs .= '<tr>' . "\n";
								$unfs .= '<th><label>Last Name:</label></th>' . "\n";
								$unfs .= '<td><input type="text" name="ws_plugin__s2member_user_new_last_name" value="' . format_to_edit ($_POST["ws_plugin__s2member_user_new_last_name"]) . '" class="regular-text" /></td>' . "\n";
								$unfs .= '</tr>' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_last_name", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_subscr_id", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$unfs .= '<tr>' . "\n";
						$unfs .= '<th><label>Paid Subscr. ID:</label> <a href="#" onclick="alert(\'A Paid Subscr. ID is only valid for paid Members. Under normal circumstances, this is filled automatically by s2Member. This field is ONLY here for Customer Service purposes; just in case you ever need to enter a Paid Subscr. ID manually.\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
						$unfs .= '<td><input type="text" name="ws_plugin__s2member_user_new_s2member_subscr_id" value="' . format_to_edit ($_POST["ws_plugin__s2member_user_new_s2member_subscr_id"]) . '" class="regular-text" /></td>' . "\n";
						$unfs .= '</tr>' . "\n";
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_subscr_id", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_custom", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$unfs .= '<tr>' . "\n";
						$unfs .= '<th><label>Custom Value:</label> <a href="#" onclick="alert(\'A Paid Subscription is always associated with a Custom String that is passed through the custom=\\\'\\\'' . ws_plugin__s2member_esc_sq ($_SERVER["HTTP_HOST"]) . '\\\'\\\' attribute of your Shortcode. This Custom Value, MUST always start with your domain name. However, you can also pipe delimit additional values after your domain, if you need to.\\n\\nFor example:\n' . ws_plugin__s2member_esc_sq ($_SERVER["HTTP_HOST"]) . '|cv1|cv2|cv3\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
						$unfs .= '<td><input type="text" name="ws_plugin__s2member_user_new_s2member_custom" value="' . format_to_edit ($_POST["ws_plugin__s2member_user_new_s2member_custom"]) . '" class="regular-text" /></td>' . "\n";
						$unfs .= '</tr>' . "\n";
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_custom", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site ())
							/* ^ Will change once Custom Capabilities are compatible with a Blog Farm. */
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_ccaps", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								$unfs .= '<tr>' . "\n";
								$unfs .= '<th><label>Custom Capabilities:</label> <a href="#" onclick="alert(\'Optional. This is VERY advanced. For full details, see:\\ns2Member -> API Scripting -> Custom Capabilities.' . ((is_multisite ()) ? '\\n\\nCustom Capabilities are assigned on a per-Blog basis. So having a set of Custom Capabilities for one Blog, and having NO Custom Capabilities on another Blog - is very common. This is how permissions are designed to work.' : '') . '\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
								$unfs .= '<td><input type="text" name="ws_plugin__s2member_user_new_s2member_ccaps" value="' . format_to_edit ($_POST["ws_plugin__s2member_user_new_s2member_ccaps"]) . '" class="regular-text" onkeyup="if(this.value.match(/[^a-z_0-9,]/)) this.value = jQuery.trim (jQuery.trim (this.value).replace (/[ \-]/g, \'_\').replace (/[^A-Z_0-9,]/gi, \'\').toLowerCase ());" /></td>' . "\n";
								$unfs .= '</tr>' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_ccaps", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_auto_eot_time", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$unfs .= '<tr>' . "\n";
						$unfs .= '<th><label>Automatic EOT Time:</label> <a href="#" onclick="alert(\'EOT = End Of Term. ( i.e. Account Expiration / Termination. ).\\n\\nIf you leave this empty, s2Member will configure an EOT Time automatically, based on the paid Subscription associated with this account. In other words, if a paid Subscription expires, is cancelled, terminated, refunded, reversed, or charged back to you; s2Member will deal with the EOT automatically.\\n\\nThat being said, if you would rather take control over this, you can. If you type in a date manually, s2Member will obey the Auto-EOT Time that you\\\'ve given, no matter what. In other words, you can force certain Members to expire automatically, at a time that you specify. s2Member will obey.\\n\\nValid formats for Automatic EOT Time:\\n\\nmm/dd/yyyy\\nyyyy-mm-dd\\n+1 year\\n+2 weeks\\n+2 months\\n+10 minutes\\nnext thursday\\ntomorrow\\ntoday\\n\\n* anything compatible with PHP\\\'s strtotime() function.\'); return false;" tabindex="-1">[?]</a>' . (($auto_eot_time) ? '<br /><small>( based on server time )</small>' : '') . '</th>' . "\n";
						$unfs .= '<td><input type="text" name="ws_plugin__s2member_user_new_s2member_auto_eot_time" value="' . format_to_edit ($_POST["ws_plugin__s2member_user_new_s2member_auto_eot_time"]) . '" class="regular-text" /></td>' . "\n";
						$unfs .= '</tr>' . "\n";
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_auto_eot_time", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (ws_plugin__s2member_list_servers_integrated ()) /* Only if integrated with s2Member. */
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_opt_in", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								$unfs .= '<tr>' . "\n";
								$unfs .= '<th><label>Process List Servers:</label> <a href="#" onclick="alert(\'You have at least one List Server integrated with s2Member. Would you like to process a confirmation request for this new User? If not, just leave the box un-checked.\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
								$unfs .= '<td><label><input type="checkbox" name="ws_plugin__s2member_user_new_opt_in" value="1"' . (($_POST["ws_plugin__s2member_user_new_opt_in"]) ? ' checked="checked"' : '') . ' /> Yes, send a mailing list confirmation email to this new User.</label></td>' . "\n";
								$unfs .= '</tr>' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_opt_in", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) /* Only if configured. */
							{
								$unfs .= '<tr>' . "\n";
								$unfs .= '<td colspan="2">' . "\n";
								$unfs .= '<div style="height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
								$unfs .= '</td>' . "\n";
								$unfs .= '</tr>' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_custom_fields", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								foreach (preg_split ("/[\r\n\t;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
									{
										if ($field = trim ($field, "^* \t\n\r\0\x0B")) /* Don't process empty fields. */
											{
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("_ws_plugin__s2member_during_admin_user_new_fields_during_custom_fields_before", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
												/**/
												$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
												$field_id_class = preg_replace ("/_/", "-", $field_var);
												/**/
												$unfs .= '<tr>' . "\n";
												$unfs .= '<th><label>' . esc_html ($field) . ':</label></th>' . "\n";
												$unfs .= '<td><input type="text" name="ws_plugin__s2member_user_new_' . $field_var . '" value="' . format_to_edit ($_POST["ws_plugin__s2member_user_new_" . $field_var]) . '" class="regular-text" /></td>' . "\n";
												$unfs .= '</tr>' . "\n";
												/**/
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("_ws_plugin__s2member_during_admin_user_new_fields_during_custom_fields_after", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
											}
									}
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_custom_fields", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								$unfs .= '<tr>' . "\n";
								$unfs .= '<td colspan="2">' . "\n";
								$unfs .= '<div style="height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
								$unfs .= '</td>' . "\n";
								$unfs .= '</tr>' . "\n";
							}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_notes", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$unfs .= '<tr>' . "\n";
						$unfs .= '<th><label>Administrative<br />Notations:</label> <a href="#" onclick="alert(\'This is for Administrative purposes. You can keep a list of Notations about this account. These Notations are private; Users/Members will never see these.\\n\\n*Note* The s2Member software may `append` Notes to this field occassionaly, under special circumstances. For example, when/if s2Member demotes a paid Member to a Free Subscriber, s2Member will leave a Note in this field.\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
						$unfs .= '<td><textarea name="ws_plugin__s2member_user_new_s2member_notes" rows="5" wrap="off" spellcheck="false" style="width:99%;">' . format_to_edit ($_POST["ws_plugin__s2member_user_new_s2member_notes"]) . '</textarea></td>' . "\n";
						$unfs .= '</tr>' . "\n";
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_notes", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$unfs .= '</table>' . "\n";
						/**/
						$unfs .= '<div style="margin:25px 0 25px 0; height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
						/**/
						$buffer = preg_replace ("/(\<\/table\>)([\r\n\t\s ]*)(\<p class\=\"submit\"\>)/", "$1$2" . $unfs . "$3", $buffer);
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("_ws_plugin__s2member_after_admin_user_new_fields", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return apply_filters ("_ws_plugin__s2member_admin_user_new_fields", $buffer, get_defined_vars ());
			}
	}
/*
This adds custom fields to `wp-signup.php`.
Attach to: add_action("signup_extra_fields");
~ For Multisite Blog Farms.
*/
if (!function_exists ("ws_plugin__s2member_ms_custom_registration_fields"))
	{
		function ws_plugin__s2member_ms_custom_registration_fields ()
			{
				do_action ("ws_plugin__s2member_before_ms_custom_registration_fields", get_defined_vars ());
				/**/
				if (is_multisite () && is_main_site ()) /* Must be Multisite / Main Site. */
					{
						$_POST = ws_plugin__s2member_trim_deep (stripslashes_deep ($_POST));
						/**/
						echo '<input type="hidden" name="ws_plugin__s2member_registration" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-registration")) . '" />' . "\n";
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_before", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_before_first_name", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						echo '<label for="ws-plugin--s2member-custom-reg-field-first-name">First Name *</label>' . "\n";
						echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_first_name" id="ws-plugin--s2member-custom-reg-field-first-name" class="ws-plugin--s2member-custom-reg-field input" size="25" value="' . format_to_edit ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]) . '" />' . "\n";
						echo '<br />' . "\n";
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_after_first_name", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_before_last_name", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						echo '<label for="ws-plugin--s2member-custom-reg-field-last-name">Last Name *</label>' . "\n";
						echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_last_name" id="ws-plugin--s2member-custom-reg-field-last-name" class="ws-plugin--s2member-custom-reg-field input" size="25" value="' . format_to_edit ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]) . '" />' . "\n";
						echo '<br />' . "\n";
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_after_last_name", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						foreach (preg_split ("/[\r\n\t;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
							{
								$req = preg_match ("/\*/", $field); /* Required fields should be wrapped inside asterisks. */
								$req = ($req) ? ' aria-required="true"' : ''; /* Has JavaScript validation applied. */
								/**/
								if ($field = trim ($field, "^* \t\n\r\0\x0B")) /* Don't process empty fields. */
									{
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_before_custom_fields", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
										$field_id_class = preg_replace ("/_/", "-", $field_var);
										/**/
										echo '<label for="ws-plugin--s2member-custom-reg-field-' . $field_id_class . '">' . esc_html ($field) . (($req) ? " *" : "") . '</label>' . "\n";
										echo '<input' . $req . ' type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_' . $field_var . '" id="ws-plugin--s2member-custom-reg-field-' . $field_id_class . '" class="ws-plugin--s2member-custom-reg-field input" size="25" value="' . format_to_edit ($_POST["ws_plugin__s2member_custom_reg_field_" . $field_var]) . '" />' . "\n";
										echo '<br />' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_after_custom_fields", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
							}
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] && ws_plugin__s2member_list_servers_integrated ())
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_before_opt_in", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								echo '<label for="ws-plugin--s2member-custom-reg-field-opt-in">' . "\n";
								echo '<input type="checkbox" name="ws_plugin__s2member_custom_reg_field_opt_in" id="ws-plugin--s2member-custom-reg-field-opt-in" value="1"' . (((empty ($_POST) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] == 1) || $_POST["ws_plugin__s2member_custom_reg_field_opt_in"]) ? ' checked="checked"' : '') . ' />' . "\n";
								echo $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in_label"] . "\n";
								echo '</label>' . "\n";
								echo '<br />' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_after_opt_in", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						echo '<br />' . "\n"; /* Toss in one extra line break ( extra margin ). */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_after", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_ms_custom_registration_fields", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return;
			}
	}
/*
This adds custom fields to `wp-login.php?action=register`.
Attach to: add_action("register_form");
*/
if (!function_exists ("ws_plugin__s2member_custom_registration_fields"))
	{
		function ws_plugin__s2member_custom_registration_fields ()
			{
				do_action ("ws_plugin__s2member_before_custom_registration_fields", get_defined_vars ());
				/**/
				$_POST = ws_plugin__s2member_trim_deep (stripslashes_deep ($_POST));
				/**/
				echo '<input type="hidden" name="ws_plugin__s2member_registration" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-registration")) . '" />' . "\n";
				/**/
				$tabindex = 20; /* Incremented tabindex starting with 20. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_custom_registration_fields_before", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"] && function_exists ("ws_plugin__s2member_generate_password"))
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_custom_registration_fields_before_user_pass", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						echo '<p>' . "\n";
						echo '<label>' . "\n";
						echo 'Password *' . "\n";
						echo '<input aria-required="true" type="password" maxlength="100" autocomplete="off" name="ws_plugin__s2member_custom_reg_field_user_pass" id="ws-plugin--s2member-custom-reg-field-user-pass" class="ws-plugin--s2member-custom-reg-field input" size="25" value="' . format_to_edit ($_POST["ws_plugin__s2member_custom_reg_field_user_pass"]) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
						echo '</label>' . "\n";
						echo '</p>';
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_custom_registration_fields_after_user_pass", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_custom_registration_fields_before_first_name", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				echo '<p>' . "\n";
				echo '<label>' . "\n";
				echo 'First Name *' . "\n";
				echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_first_name" id="ws-plugin--s2member-custom-reg-field-first-name" class="ws-plugin--s2member-custom-reg-field input" size="25" value="' . format_to_edit ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
				echo '</label>' . "\n";
				echo '</p>';
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_custom_registration_fields_after_first_name", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_custom_registration_fields_before_last_name", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				echo '<p>' . "\n";
				echo '<label>' . "\n";
				echo 'Last Name *' . "\n";
				echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_last_name" id="ws-plugin--s2member-custom-reg-field-last-name" class="ws-plugin--s2member-custom-reg-field input" size="25" value="' . format_to_edit ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
				echo '</label>' . "\n";
				echo '</p>';
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_custom_registration_fields_after_last_name", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				foreach (preg_split ("/[\r\n\t;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
					{
						$req = preg_match ("/\*/", $field); /* Required fields should be wrapped inside asterisks. */
						$req = ($req) ? ' aria-required="true"' : ''; /* Has JavaScript validation applied. */
						/**/
						if ($field = trim ($field, "^* \t\n\r\0\x0B")) /* Don't process empty fields. */
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_custom_registration_fields_before_custom_fields", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
								$field_id_class = preg_replace ("/_/", "-", $field_var);
								/**/
								echo '<p>' . "\n";
								echo '<label>' . "\n";
								echo esc_html ($field) . (($req) ? " *" : "") . "\n";
								echo '<input' . $req . ' type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_' . $field_var . '" id="ws-plugin--s2member-custom-reg-field-' . $field_id_class . '" class="ws-plugin--s2member-custom-reg-field input" size="25" value="' . format_to_edit ($_POST["ws_plugin__s2member_custom_reg_field_" . $field_var]) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
								echo '</label>' . "\n";
								echo '</p>';
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_custom_registration_fields_after_custom_fields", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
					}
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] && ws_plugin__s2member_list_servers_integrated ())
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_custom_registration_fields_before_opt_in", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						echo '<p>' . "\n";
						echo '<label>' . "\n";
						echo '<input type="checkbox" name="ws_plugin__s2member_custom_reg_field_opt_in" id="ws-plugin--s2member-custom-reg-field-opt-in" value="1"' . (((empty ($_POST) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] == 1) || $_POST["ws_plugin__s2member_custom_reg_field_opt_in"]) ? ' checked="checked"' : '') . ' tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
						echo $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in_label"] . "\n";
						echo '</label>' . "\n";
						echo '</p>';
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_custom_registration_fields_after_opt_in", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_custom_registration_fields_after", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_custom_registration_fields", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return;
			}
	}
/*
This adds an opt-in checkbox to the BuddyPress signup form.
Attach to: add_action("bp_before_registration_submit_buttons");
*/
if (!function_exists ("ws_plugin__s2member_opt_in_4bp"))
	{
		function ws_plugin__s2member_opt_in_4bp ()
			{
				do_action ("ws_plugin__s2member_before_opt_in_4bp", get_defined_vars ());
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] && ws_plugin__s2member_list_servers_integrated ())
					{
						do_action ("ws_plugin__s2member_during_opt_in_4bp_before", get_defined_vars ());
						/**/
						echo '<div class="s2member-opt-in-4bp" style="' . apply_filters ("ws_plugin__s2member_opt_in_4bp_styles", "clear:both; padding-top:10px; margin-left:-3px;", get_defined_vars ()) . '">' . "\n";
						/**/
						echo '<p>' . "\n";
						echo '<label>' . "\n";
						echo '<input type="checkbox" name="ws_plugin__s2member_custom_reg_field_opt_in" id="ws-plugin--s2member-custom-reg-field-opt-in" value="1"' . (((empty ($_POST) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] == 1) || $_POST["ws_plugin__s2member_custom_reg_field_opt_in"]) ? ' checked="checked"' : '') . ' />' . "\n";
						echo $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in_label"] . "\n";
						echo '</label>' . "\n";
						echo '</p>';
						/**/
						echo '</div>' . "\n";
						/**/
						do_action ("ws_plugin__s2member_during_opt_in_4bp_after", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_opt_in_4bp", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Generates registration links.
*/
if (!function_exists ("ws_plugin__s2member_register_link_gen"))
	{
		function ws_plugin__s2member_register_link_gen ($subscr_id = FALSE, $custom = FALSE, $item_number = FALSE, $shrink = TRUE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_register_link_gen", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($subscr_id && $custom && $item_number) /* Must have all of these. */
					{
						$register = ws_plugin__s2member_encrypt ("subscr_id_custom_item_number_time:.:|:.:" . $subscr_id . ":.:|:.:" . $custom . ":.:|:.:" . $item_number . ":.:|:.:" . strtotime ("now"));
						$register_link = add_query_arg ("s2member_register", $register, get_bloginfo ("wpurl") . "/");
						/**/
						if ($shrink && ($tinyurl = ws_plugin__s2member_remote ("http://tinyurl.com/api-create.php?url=" . rawurlencode ($register_link))))
							return apply_filters ("ws_plugin__s2member_register_link_gen", $tinyurl, get_defined_vars ()); /* tinyURL is easier to work with. */
						else /* Else use the long one; tinyURL will fail when/if their server is down periodically. */
							return apply_filters ("ws_plugin__s2member_register_link_gen", $register_link, get_defined_vars ());
					}
				/**/
				return false;
			}
	}
/*
Handles registration links.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_register"))
	{
		function ws_plugin__s2member_register ()
			{
				do_action ("ws_plugin__s2member_before_register", get_defined_vars ());
				/**/
				if ($_GET["s2member_register"]) /* If they're attempting to access the registration system. */
					{
						if (is_array ($register = preg_split ("/\:\.\:\|\:\.\:/", ws_plugin__s2member_decrypt ($_GET["s2member_register"]))))
							{
								if (count ($register) === 5 && $register[0] === "subscr_id_custom_item_number_time" && $register[1] && $register[2] && $register[3] && $register[4])
									{
										if ($register[4] <= strtotime ("now") && $register[4] >= strtotime ("-2 days")) /* Customers have 2 days to register. */
											{
												setcookie ("s2member_subscr_id", ws_plugin__s2member_encrypt ($register[1]), time () + 31556926, "/");
												setcookie ("s2member_custom", ws_plugin__s2member_encrypt ($register[2]), time () + 31556926, "/");
												setcookie ("s2member_level", ws_plugin__s2member_encrypt ($register[3]), time () + 31556926, "/");
												/**/
												do_action ("ws_plugin__s2member_during_register", get_defined_vars ());
												/**/
												if (is_multisite () && ws_plugin__s2member_is_multisite_farm () && is_main_site ())
													{
														echo '<script type="text/javascript">' . "\n";
														echo "window.location = '" . esc_js (apply_filters ("wp_signup_location", get_bloginfo ("wpurl") . "/wp-signup.php")) . "';";
														echo '</script>' . "\n";
													}
												else /* Otherwise, this is NOT a Multisite install. Or it is, but the Super Administrator is NOT selling Blog creation. */
													{
														echo '<script type="text/javascript">' . "\n";
														echo "window.location = '" . esc_js (add_query_arg ("action", "register", wp_login_url ())) . "';";
														echo '</script>' . "\n";
													}
											}
									}
							}
						/**/
						echo '<strong>Your Link Expired:</strong><br />Please contact Support if you need assistance.';
						/**/
						exit (); /* $_GET["s2member_register"] has expired. Or it is simply invalid. */
					}
				/**/
				do_action ("ws_plugin__s2member_after_register", get_defined_vars ());
			}
	}
/*
Function that adds customs fields to $meta on signup.
Attach to: add_filter("add_signup_meta");

This can be fired through wp-signup.php on the front-side,
	or possibly through user-new.php in the admin.
*/
if (!function_exists ("ws_plugin__s2member_ms_process_signup_meta"))
	{
		function ws_plugin__s2member_ms_process_signup_meta ($meta = FALSE)
			{
				global $pagenow; /* Need this to detect the current admin page. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_ms_process_signup_meta", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_multisite ()) /* This event should ONLY be processed with Multisite Networking. */
					if ((is_admin () && $pagenow === "user-new.php") || (ws_plugin__s2member_is_multisite_farm () && is_main_site () && preg_match ("/\/wp-signup\.php/", $_SERVER["REQUEST_URI"]) && $_POST["stage"] === "validate-user-signup"))
						{
							ws_plugin__s2member_email_config (); /* Configures From: header that will be used in notifications. */
							/**/
							foreach ((array)ws_plugin__s2member_trim_deep (stripslashes_deep ($_POST)) as $key => $value)
								if (preg_match ("/^ws_plugin__s2member_(custom_reg_field|user_new)_/", $key))
									if ($key = preg_replace ("/_user_new_/", "_custom_reg_field_", $key))
										$meta["s2member_ms_signup_meta"][$key] = $value;
						}
				/**/
				return apply_filters ("ws_plugin__s2member_ms_process_signup_meta", $meta, get_defined_vars ());
			}
	}
/*
Function for configuring new users.
Attach to: add_action("wpmu_activate_user");

This does NOT fire for a Super Admin managing Network Users.
Which is good. A Super Admin will NOT trigger this event.
~ They fire wpmu_create_user(), bypassing activation.
	- through ms-edit.php.

However, a Super Admin CAN trigger this event by adding a new User through the Users -> Add New menu.
~ If they choose to bypass activation; an activation IS fired immediately. Otherwise, it's delayed.
	- via user-new.php.

So this function may get fired inside the admin panel ( user-new.php ).
Or also during an actual activation; through wp-activate.php.
*/
if (!function_exists ("ws_plugin__s2member_configure_user_on_ms_user_activation"))
	{
		function ws_plugin__s2member_configure_user_on_ms_user_activation ($user_id = FALSE, $password = FALSE, $meta = FALSE)
			{
				global $pagenow; /* Need this to detect the current admin page. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_configure_user_on_ms_user_activation", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_multisite ()) /* This event should ONLY be processed with Multisite Networking. */
					if ((is_admin () && $pagenow === "user-new.php") || (!is_admin () && preg_match ("/\/wp-activate\.php/", $_SERVER["REQUEST_URI"])))
						{
							ws_plugin__s2member_configure_user_registration ($user_id, $password, $meta["s2member_ms_signup_meta"]);
							delete_user_meta ($user_id, "s2member_ms_signup_meta");
						}
				/**/
				do_action ("ws_plugin__s2member_after_configure_user_on_ms_user_activation", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for configuring new users.
Attach to: add_action("wpmu_activate_blog");

This does NOT fire for a Super Admin managing Network Blogs.
~ Actually they do; BUT it's blocked by the routine below.
Which is good. A Super Admin should NOT trigger this event.

This function should ONLY be fired through wp-activate.php.
*/
if (!function_exists ("ws_plugin__s2member_configure_user_on_ms_blog_activation"))
	{
		function ws_plugin__s2member_configure_user_on_ms_blog_activation ($blog_id = FALSE, $user_id = FALSE, $password = FALSE, $title = FALSE, $meta = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_configure_user_on_ms_blog_activation", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_multisite ()) /* This event should ONLY be processed with Multisite Networking. */
					if (!is_admin () && preg_match ("/\/wp-activate\.php/", $_SERVER["REQUEST_URI"])) /* ONLY `wp-activate.php`. */
						{
							ws_plugin__s2member_configure_user_registration ($user_id, $password, $meta["s2member_ms_signup_meta"]);
							delete_user_meta ($user_id, "s2member_ms_signup_meta");
						}
				/**/
				do_action ("ws_plugin__s2member_after_configure_user_on_ms_blog_activation", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for configuring new users.
Attach to: add_action("user_register");

This also receives Multisite events.
Attach to: add_action("wpmu_activate_user");
Attach to: add_action("wpmu_activate_blog");

The Hook `user_register` is also fired by calling:
		wpmu_create_user()

This function also receives simulated events from s2Member Pro.
*/
if (!function_exists ("ws_plugin__s2member_configure_user_registration"))
	{
		function ws_plugin__s2member_configure_user_registration ($user_id = FALSE, $password = FALSE, $meta = FALSE)
			{
				global $wpdb; /* Global database object may be required for this routine. */
				global $pagenow; /* Need this to detect the current admin page. */
				global $current_site, $current_blog; /* Multisite Networking. */
				static $email_config, $processed; /* No duplicate processing. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_configure_user_registration", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				/* With Multisite Networking, we need this to run on `user_register` ahead of `wpmu_activate_user|blog`. */
				if (!$email_config && ($email_config = true)) /* Anytime this routine is fired; we config email; no exceptions. */
					ws_plugin__s2member_email_config (); /* Configures From: header that will be used in new user notifications. */
				/**/
				if (!$processed /* Process only once. Safeguard this routine against duplicate processing via plugins ( or even WordPress® itself ). */
				&& (is_array ($_POST = ws_plugin__s2member_trim_deep (stripslashes_deep ($_POST))) || is_array (ws_plugin__s2member_trim_deep (stripslashes_deep ($meta))))/**/
				/**/
				/* These negative matches are designed to prevent this routine from running under certain conditions; where we need to wait for `wpmu_activate_user|blog` instead. */
				&& !(is_admin () && is_multisite () && $pagenow === "user-new.php" && isset ($_POST["noconfirmation"]) && is_super_admin () && empty ($meta))/**/
				&& !(preg_match ("/\/wp-activate\.php/", $_SERVER["REQUEST_URI"]) && empty ($meta)) /* If activating; we MUST have a meta array. */
				/* The $meta array is ONLY filled by hand-offs from `wpmu_activate_user|blog`. So this is how we check for these events. */
				/**/
				&& $user_id && is_object ($user = new WP_User ($user_id)) && $user->ID && ($processed = true)) /* Process only once. */
					{
						if (!is_admin () && ($_POST["ws_plugin__s2member_custom_reg_field_s2member_custom"] || $_POST["ws_plugin__s2member_custom_reg_field_s2member_subscr_id"] || $_POST["ws_plugin__s2member_custom_reg_field_s2member_ccaps"] || $_POST["ws_plugin__s2member_custom_reg_field_s2member_auto_eot_time"] || $_POST["ws_plugin__s2member_custom_reg_field_s2member_notes"]))
							exit ("s2Member security violation. You attempted to POST variables that will NOT be trusted!");
						/**/
						$_pm = array_merge ((array)$_POST, (array)$meta); /* Merge these two data sources together. */
						/**/
						if (!is_admin () /* Only run this particular routine whenever a Member [1-4] is registering themselves with cookies. */
						&& ($subscr_id = ws_plugin__s2member_decrypt ($_COOKIE["s2member_subscr_id"])) && preg_match ("/^" . preg_quote (preg_replace ("/\:([0-9]+)$/", "", $_SERVER["HTTP_HOST"]), "/") . "/i", ($custom = ws_plugin__s2member_decrypt ($_COOKIE["s2member_custom"]))) && preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", ($level = ws_plugin__s2member_decrypt ($_COOKIE["s2member_level"])))/**/
						&& (!$usermeta = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1")))
							/* ^ This is for security ^ It checks the database to make sure the User/Member has not already registered in the past, with the same Paid Subscr. ID. */
							{ /*
								This routine could be processed through `wp-login.php?action=register` - OR - through `wp-activate.php`.
								If processed through `wp-activate.php`, it could've originated inside the admin, via `user-new.php`.
								This may also be processed through BuddyPress, or another plugin calling `user_register`.
								*/
								$processed = "yes"; /* Mark this as yes, to indicate that a routine was processed. */
								/**/
								list ($level, $ccaps, $eotper) = preg_split ("/\:/", $level, 3);
								$role = "s2member_level" . $level; /* Level 1-4. */
								/**/
								$email = $user->user_email;
								$login = $user->user_login;
								$ip = $_SERVER["REMOTE_ADDR"];
								$cv = preg_split ("/\|/", $custom);
								/**/
								if ($eotper) /* If a specific EOT Period has been attached; we need to calculate that now. */
									$auto_eot_time = ws_plugin__s2member_paypal_auto_eot_time (0, 0, 0, $eotper);
								/**/
								$notes = $_pm["ws_plugin__s2member_custom_reg_field_s2member_notes"];
								/**/
								$opt_in = (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"]) ? true : false;
								$opt_in = (!$opt_in && $_pm["ws_plugin__s2member_custom_reg_field_opt_in"]) ? true : $opt_in;
								/**/
								if (!($fname = $user->first_name))
									if ($_pm["ws_plugin__s2member_custom_reg_field_first_name"])
										$fname = $_pm["ws_plugin__s2member_custom_reg_field_first_name"];
								/**/
								if (!$fname) /* Also try BuddyPress. */
									if ($_pm["field_1"]) /* BuddyPress. */
										$fname = trim (preg_replace ("/ (.*)$/", "", $_pm["field_1"]));
								/**/
								if (!($lname = $user->last_name))
									if ($_pm["ws_plugin__s2member_custom_reg_field_last_name"])
										$lname = $_pm["ws_plugin__s2member_custom_reg_field_last_name"];
								/**/
								if (!$lname) /* Also try BuddyPress. */
									if ($_pm["field_1"] && preg_match ("/^(.+?) (.+)$/", $_pm["field_1"]))
										$lname = trim (preg_replace ("/^(.+?) (.+)$/", "$2", $_pm["field_1"]));
								/**/
								$name = trim ($fname . " " . $lname); /* Both names. */
								/**/
								if (!($pass = $password)) /* Try s2Member's generator. */
									if ($GLOBALS["ws_plugin__s2member_generate_password_return"])
										$pass = $GLOBALS["ws_plugin__s2member_generate_password_return"];
								/**/
								if (!$pass) /* Also try BuddyPress password. */
									if ($_pm["signup_password"]) /* BuddyPress. */
										$pass = $_pm["signup_password"];
								/**/
								if ($pass) /* No password nag. Update this globally. */
									{
										delete_user_setting ("default_password_nag"); /* setcookie() */
										update_user_option ($user_id, "default_password_nag", false, true);
									}
								/**/
								update_user_option ($user_id, "s2member_auto_eot_time", $auto_eot_time);
								update_user_option ($user_id, "s2member_subscr_id", $subscr_id);
								update_user_option ($user_id, "s2member_custom", $custom);
								update_user_option ($user_id, "s2member_notes", $notes);
								/**/
								if (!$user->first_name && $fname)
									update_user_meta ($user_id, "first_name", $fname) ./**/
									wp_update_user (array ("ID" => $user_id, "display_name" => $fname));
								/**/
								if (!$user->last_name && $lname)
									update_user_meta ($user_id, "last_name", $lname);
								/**/
								if (is_multisite ()) /* Originating Blog ID#, and adjust Main Site permissions. */
									{
										(!is_main_site ()) ? remove_user_from_blog ($user_id, $current_site->blog_id) : null;
										update_user_meta ($user_id, "s2member_originating_blog", $current_blog->blog_id);
									}
								/**/
								$user->set_role ($role); /* s2Member. */
								/**/
								if ($ccaps) /* Add Custom Capabilities. */
									foreach (preg_split ("/[\r\n\t\s;,]+/", $ccaps) as $ccap)
										if (strlen ($ccap)) /* Don't add empty capabilities. */
											$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
								/**/
								foreach (preg_split ("/[\r\n\t;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
									{
										if ($field = trim ($field, "^* \t\n\r\0\x0B")) /* Don't process empty fields. */
											{
												$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
												$field_id_class = preg_replace ("/_/", "-", $field_var);
												/**/
												if (strlen ($_pm["ws_plugin__s2member_custom_reg_field_" . $field_var]))
													$fields[$field_var] = $_pm["ws_plugin__s2member_custom_reg_field_" . $field_var];
											}
									}
								/**/
								update_user_option ($user_id, "s2member_custom_fields", $fields);
								/**/
								if (($transient = md5 ("s2member_transient_ipn_subscr_payment_" . $subscr_id)) && is_array ($subscr_payment = get_transient ($transient)))
									{
										$proxy = array ("s2member_paypal_notify" => "1", "s2member_paypal_proxy" => "s2member_transient_ipn_subscr_payment");
										ws_plugin__s2member_remote (add_query_arg ($proxy, get_bloginfo ("wpurl")), stripslashes_deep ($subscr_payment), array ("timeout" => 20));
										delete_transient ($transient);
									}
								/**/
								setcookie ("s2member_signup_tracking", ws_plugin__s2member_encrypt ($subscr_id), time () + 31556926, "/");
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_configure_user_registration_front_side", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						else if (!is_admin ()) /* Otherwise, if we are NOT inside the Dashboard during the creation of this account. */
							{ /*
								This routine could be processed through `wp-login.php?action=register` - OR - through `wp-activate.php`.
								If processed through `wp-activate.php`, it could've originated inside the admin, via `user-new.php`.
								This may also be processed through BuddyPress, or another plugin calling `user_register`.
								*/
								$processed = "yes"; /* Mark this as yes, to indicate that a routine was processed. */
								/**/
								$role = $role = $user->roles[0]; /* If they already have a Role, we can use it. */
								$role = (!$role && is_multisite () && is_main_site ()) ? get_site_option ("default_user_role") : $role;
								$role = (!$role) ? get_option ("default_role") : $role; /* Otherwise, the default role. */
								/**/
								$level = (preg_match ("/^(administrator|editor|author|contributor)$/i", $role)) ? "4" : $level;
								$level = (!$level && preg_match ("/^s2member_level[1-4]$/i", $role)) ? preg_replace ("/^s2member_level/", "", $role) : $level;
								$level = (!$level && preg_match ("/^subscriber$/i", $role)) ? "0" : $level;
								$level = (!$level) ? "0" : $level;
								/**/
								$ccaps = $_pm["ws_plugin__s2member_custom_reg_field_s2member_ccaps"];
								/**/
								$email = $user->user_email;
								$login = $user->user_login;
								$ip = $_SERVER["REMOTE_ADDR"];
								$custom = $_pm["ws_plugin__s2member_custom_reg_field_s2member_custom"];
								$subscr_id = $_pm["ws_plugin__s2member_custom_reg_field_s2member_subscr_id"];
								$cv = preg_split ("/\|/", $_pm["ws_plugin__s2member_custom_reg_field_s2member_custom"]);
								/**/
								$auto_eot_time = ($eot = $_pm["ws_plugin__s2member_custom_reg_field_s2member_auto_eot_time"]) ? strtotime ($eot) : "";
								$notes = $_pm["ws_plugin__s2member_custom_reg_field_s2member_notes"];
								/**/
								$opt_in = (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"]) ? true : false;
								$opt_in = (!$opt_in && $_pm["ws_plugin__s2member_custom_reg_field_opt_in"]) ? true : $opt_in;
								/**/
								if (!($fname = $user->first_name))
									if ($_pm["ws_plugin__s2member_custom_reg_field_first_name"])
										$fname = $_pm["ws_plugin__s2member_custom_reg_field_first_name"];
								/**/
								if (!$fname) /* Also try BuddyPress. */
									if ($_pm["field_1"]) /* BuddyPress. */
										$fname = trim (preg_replace ("/ (.*)$/", "", $_pm["field_1"]));
								/**/
								if (!($lname = $user->last_name))
									if ($_pm["ws_plugin__s2member_custom_reg_field_last_name"])
										$lname = $_pm["ws_plugin__s2member_custom_reg_field_last_name"];
								/**/
								if (!$lname) /* Also try BuddyPress. */
									if ($_pm["field_1"] && preg_match ("/^(.+?) (.+)$/", $_pm["field_1"]))
										$lname = trim (preg_replace ("/^(.+?) (.+)$/", "$2", $_pm["field_1"]));
								/**/
								$name = trim ($fname . " " . $lname); /* Both names. */
								/**/
								if (!($pass = $password)) /* Try s2Member's generator. */
									if ($GLOBALS["ws_plugin__s2member_generate_password_return"])
										$pass = $GLOBALS["ws_plugin__s2member_generate_password_return"];
								/**/
								if (!$pass) /* Also try BuddyPress password. */
									if ($_pm["signup_password"]) /* BuddyPress. */
										$pass = $_pm["signup_password"];
								/**/
								if ($pass) /* No password nag. Update this globally. */
									{
										delete_user_setting ("default_password_nag"); /* setcookie() */
										update_user_option ($user_id, "default_password_nag", false, true);
									}
								/**/
								update_user_option ($user_id, "s2member_auto_eot_time", $auto_eot_time);
								update_user_option ($user_id, "s2member_subscr_id", $subscr_id);
								update_user_option ($user_id, "s2member_custom", $custom);
								update_user_option ($user_id, "s2member_notes", $notes);
								/**/
								if (!$user->first_name && $fname)
									update_user_meta ($user_id, "first_name", $fname) ./**/
									wp_update_user (array ("ID" => $user_id, "display_name" => $fname));
								/**/
								if (!$user->last_name && $lname)
									update_user_meta ($user_id, "last_name", $lname);
								/**/
								if (is_multisite ()) /* Originating Blog ID#, and adjust Main Site permissions. */
									{
										(!is_main_site ()) ? remove_user_from_blog ($user_id, $current_site->blog_id) : null;
										update_user_meta ($user_id, "s2member_originating_blog", $current_blog->blog_id);
									}
								/**/
								$user->set_role ($role); /* s2Member. */
								/**/
								if ($ccaps) /* Add Custom Capabilities. */
									foreach (preg_split ("/[\r\n\t\s;,]+/", $ccaps) as $ccap)
										if (strlen ($ccap)) /* Don't add empty capabilities. */
											$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
								/**/
								foreach (preg_split ("/[\r\n\t;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
									{
										if ($field = trim ($field, "^* \t\n\r\0\x0B")) /* Don't process empty fields. */
											{
												$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
												$field_id_class = preg_replace ("/_/", "-", $field_var);
												/**/
												if (strlen ($_pm["ws_plugin__s2member_custom_reg_field_" . $field_var]))
													$fields[$field_var] = $_pm["ws_plugin__s2member_custom_reg_field_" . $field_var];
											}
									}
								/**/
								update_user_option ($user_id, "s2member_custom_fields", $fields);
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_configure_user_registration_front_side", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						else if (is_admin () && $pagenow === "user-new.php") /* Else, if we're on this admin page. */
							{ /*
								This routine can ONLY be processed through `user-new.php` inside the Dashboard.
								*/
								$processed = "yes"; /* Mark this as yes, to indicate that a routine was processed. */
								/**/
								$role = $role = $user->roles[0]; /* If they already have a Role, we can use it. */
								$role = (!$role && is_multisite () && is_main_site ()) ? get_site_option ("default_user_role") : $role;
								$role = (!$role) ? get_option ("default_role") : $role; /* Otherwise, the default role. */
								/**/
								$level = (preg_match ("/^(administrator|editor|author|contributor)$/i", $role)) ? "4" : $level;
								$level = (!$level && preg_match ("/^s2member_level[1-4]$/i", $role)) ? preg_replace ("/^s2member_level/", "", $role) : $level;
								$level = (!$level && preg_match ("/^subscriber$/i", $role)) ? "0" : $level;
								$level = (!$level) ? "0" : $level;
								/**/
								$ccaps = $_pm["ws_plugin__s2member_custom_reg_field_s2member_ccaps"];
								/**/
								$email = $user->user_email;
								$login = $user->user_login;
								$ip = ""; /* N/Applicable. */
								$custom = $_pm["ws_plugin__s2member_custom_reg_field_s2member_custom"];
								$subscr_id = $_pm["ws_plugin__s2member_custom_reg_field_s2member_subscr_id"];
								$cv = preg_split ("/\|/", $_pm["ws_plugin__s2member_custom_reg_field_s2member_custom"]);
								/**/
								$auto_eot_time = ($eot = $_pm["ws_plugin__s2member_custom_reg_field_s2member_auto_eot_time"]) ? strtotime ($eot) : "";
								$notes = $_pm["ws_plugin__s2member_custom_reg_field_s2member_notes"];
								/**/
								$opt_in = (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"]) ? true : false;
								$opt_in = (!$opt_in && $_pm["ws_plugin__s2member_custom_reg_field_opt_in"]) ? true : $opt_in;
								/**/
								if (!($fname = $user->first_name)) /* `Users -> Add New`. */
									if ($_pm["ws_plugin__s2member_custom_reg_field_first_name"])
										$fname = $_pm["ws_plugin__s2member_custom_reg_field_first_name"];
								/**/
								if (!($lname = $user->last_name)) /* `Users -> Add New`. */
									if ($_pm["ws_plugin__s2member_custom_reg_field_last_name"])
										$lname = $_pm["ws_plugin__s2member_custom_reg_field_last_name"];
								/**/
								$name = trim ($fname . " " . $lname); /* Both names. */
								/**/
								if (!($pass = $password)) /* Try s2Member's generator. */
									if ($GLOBALS["ws_plugin__s2member_generate_password_return"])
										$pass = $GLOBALS["ws_plugin__s2member_generate_password_return"];
								/**/
								if (!$pass) /* Also try the `Users -> Add New` form. */
									if ($_pm["pass1"]) /* Field in user-new.php. */
										$pass = $_pm["pass1"];
								/**/
								if ($pass) /* No password nag. Update this globally. */
									{
										delete_user_setting ("default_password_nag"); /* setcookie() */
										update_user_option ($user_id, "default_password_nag", false, true);
									}
								/**/
								update_user_option ($user_id, "s2member_auto_eot_time", $auto_eot_time);
								update_user_option ($user_id, "s2member_subscr_id", $subscr_id);
								update_user_option ($user_id, "s2member_custom", $custom);
								update_user_option ($user_id, "s2member_notes", $notes);
								/**/
								if (!$user->first_name && $fname)
									update_user_meta ($user_id, "first_name", $fname) ./**/
									wp_update_user (array ("ID" => $user_id, "display_name" => $fname));
								/**/
								if (!$user->last_name && $lname)
									update_user_meta ($user_id, "last_name", $lname);
								/**/
								if (is_multisite ()) /* Originating Blog ID#, and adjust Main Site permissions. */
									{
										(!is_main_site ()) ? remove_user_from_blog ($user_id, $current_site->blog_id) : null;
										update_user_meta ($user_id, "s2member_originating_blog", $current_blog->blog_id);
									}
								/**/
								$user->set_role ($role); /* s2Member. */
								/**/
								foreach (preg_split ("/[\r\n\t\s;,]+/", $ccaps) as $ccap)
									if (strlen ($ccap)) /* Don't add empty capabilities. */
										$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
								/**/
								foreach (preg_split ("/[\r\n\t;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
									{
										if ($field = trim ($field, "^* \t\n\r\0\x0B")) /* Don't process empty fields. */
											{
												$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
												$field_id_class = preg_replace ("/_/", "-", $field_var);
												/**/
												$fields[$field_var] = $_pm["ws_plugin__s2member_custom_reg_field_" . $field_var];
											}
									}
								/**/
								update_user_option ($user_id, "s2member_custom_fields", $fields);
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_configure_user_registration_admin_side", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						if ($processed === "yes") /* If registration was processed by one of the routines above. */
							{
								ws_plugin__s2member_process_list_servers ($level, $email, $fname, $lname, $ip, $opt_in);
								/**/
								if ($urls = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["registration_notification_urls"])
									foreach (preg_split ("/[\r\n\t]+/", $urls) as $url) /* Notify each of the urls. */
										if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)))
											if (($url = preg_replace ("/%%role%%/i", ws_plugin__s2member_esc_ds (urlencode ($role)), $url)))
												if (($url = preg_replace ("/%%level%%/i", ws_plugin__s2member_esc_ds (urlencode ($level)), $url)))
													if (($url = preg_replace ("/%%user_first_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($fname)), $url)))
														if (($url = preg_replace ("/%%user_last_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($lname)), $url)))
															if (($url = preg_replace ("/%%user_full_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($name)), $url)))
																if (($url = preg_replace ("/%%user_email%%/i", ws_plugin__s2member_esc_ds (urlencode ($email)), $url)))
																	if (($url = preg_replace ("/%%user_login%%/i", ws_plugin__s2member_esc_ds (urlencode ($login)), $url)))
																		if (($url = preg_replace ("/%%user_pass%%/i", ws_plugin__s2member_esc_ds (urlencode ($pass)), $url)))
																			if (($url = preg_replace ("/%%user_id%%/i", ws_plugin__s2member_esc_ds (urlencode ($user_id)), $url)))
																				if (($url = trim ($url))) /* Empty? */
																					ws_plugin__s2member_remote ($url);
								/**/
								if ($url = $GLOBALS["ws_plugin__s2member_registration_return_url"])
									if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)))
										if (($url = preg_replace ("/%%role%%/i", ws_plugin__s2member_esc_ds (urlencode ($role)), $url)))
											if (($url = preg_replace ("/%%level%%/i", ws_plugin__s2member_esc_ds (urlencode ($level)), $url)))
												if (($url = preg_replace ("/%%user_first_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($fname)), $url)))
													if (($url = preg_replace ("/%%user_last_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($lname)), $url)))
														if (($url = preg_replace ("/%%user_full_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($name)), $url)))
															if (($url = preg_replace ("/%%user_email%%/i", ws_plugin__s2member_esc_ds (urlencode ($email)), $url)))
																if (($url = preg_replace ("/%%user_login%%/i", ws_plugin__s2member_esc_ds (urlencode ($login)), $url)))
																	if (($url = preg_replace ("/%%user_pass%%/i", ws_plugin__s2member_esc_ds (urlencode ($pass)), $url)))
																		if (($url = preg_replace ("/%%user_id%%/i", ws_plugin__s2member_esc_ds (urlencode ($user_id)), $url)))
																			if (($url = trim ($url))) /* Empty? ... Otherwise, re-fill. */
																				$GLOBALS["ws_plugin__s2member_registration_return_url"] = $url;
								/**/
								setcookie ("s2member_subscr_id", "", time () + 31556926, "/");
								setcookie ("s2member_custom", "", time () + 31556926, "/");
								setcookie ("s2member_level", "", time () + 31556926, "/");
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_configure_user_registration", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_configure_user_registration", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return;
			}
	}
/*
Pluggable function that handles password generation.
Taken from: /wp-includes/pluggable.php
*/
if (!function_exists ("wp_generate_password"))
	{
		if (!function_exists ("ws_plugin__s2member_generate_password"))
			{
				function wp_generate_password ($length = 12, $special_chars = TRUE)
					{
						return ws_plugin__s2member_generate_password ($length, $special_chars);
					}
				/**/
				function ws_plugin__s2member_generate_password ($length = 12, $special_chars = TRUE)
					{
						$password = ws_plugin__s2member_random_str_gen ($length, $special_chars);
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_generate_password", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"])
							if ($custom = trim (stripslashes ($_POST["ws_plugin__s2member_custom_reg_field_user_pass"])))
								{
									$password = $custom; /* Use custom password. */
								}
						/**/
						return ($GLOBALS["ws_plugin__s2member_generate_password_return"] = $password);
					}
			}
	}
/*
Function hides password fields for demo users.

Demo accounts ( where the Username MUST be "demo" ), will NOT be allowed to change their password.
Any other restrictions you need to impose must be done through custom programming, using s2Member's Advanced Conditionals.
See `s2Member -> API Scripting -> Advanced Conditionals`.

Attach to: add_filter("show_password_fields");
*/
if (!function_exists ("ws_plugin__s2member_demo_hide_password_fields"))
	{
		function ws_plugin__s2member_demo_hide_password_fields ($show = TRUE, $profileuser = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_demo_hide_password_fields", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($profileuser->user_login === "demo")
					return ($show = false);
				/**/
				return $show;
			}
	}
/*
Convert primitive Role names in emails sent by WordPress®.
Attach to: add_filter("wpmu_signup_user_notification_email");
	~ Only necessary with this particular email.
*/
if (!function_exists ("ws_plugin__s2member_ms_nice_email_roles"))
	{
		function ws_plugin__s2member_ms_nice_email_roles ($message = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_ms_nice_email_roles", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$message = preg_replace ("/ as a (subscriber|s2member_level[1-4])/i", " as a Member", $message);
				/**/
				return apply_filters ("ws_plugin__s2member_ms_nice_email_roles", $message, get_defined_vars ());
			}
	}
?>