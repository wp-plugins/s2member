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
Forces a default Role for new registrations not tied to an incoming payment.
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
Function for allowing access to the register form.
Attach to: add_filter("pre_option_users_can_register");
*/
if (!function_exists ("ws_plugin__s2member_check_register_access"))
	{
		function ws_plugin__s2member_check_register_access ($users_can_register = FALSE)
			{
				global $wpdb, $pagenow; /* So we can see if we're on the options page. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_check_register_access", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$users_can_register = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["allow_subscribers_in"];
				/**/
				if ($pagenow !== "options-general.php") /* Do NOT run these particular security checks on the options page; it becomes confusing to a site owner. */
					{
						if ($users_can_register || current_user_can ("create_users") || (($subscr_id = ws_plugin__s2member_decrypt ($_COOKIE["s2member_subscr_id"])) && ($custom = ws_plugin__s2member_decrypt ($_COOKIE["s2member_custom"])) && preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", ($level = ws_plugin__s2member_decrypt ($_COOKIE["s2member_level"]))) && !($exists = $wpdb->get_var ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1"))))
							{
								return apply_filters ("ws_plugin__s2member_check_register_access", ($users_can_register = "1"), get_defined_vars ());
							}
					}
				/**/
				return apply_filters ("ws_plugin__s2member_check_register_access", $users_can_register, get_defined_vars ());
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
				if ($pagenow === "options-general.php" && !isset ($_GET["page"]))
					{
						$notice = "<em>* Note: The s2Member plugin has control over two options on this page. <code>Anyone Can Register = " . esc_html (get_option ("users_can_register")) . "</code>, and <code>Default Role = " . esc_html (get_option ("default_role")) . "</code>. For further details, see: <code>s2Member -> General Options -> Open Registration</code>.";
						/**/
						do_action ("ws_plugin__s2member_during_general_ops_notice", get_defined_vars ());
						/**/
						ws_plugin__s2member_enqueue_admin_notice ($notice, $pagenow);
					}
				/**/
				do_action ("ws_plugin__s2member_after_general_ops_notice", get_defined_vars ());
				/**/
				return;
			}
	}
/*
This adds custom fields to the registration form.
Attach to: add_action("register_form");
*/
if (!function_exists ("ws_plugin__s2member_custom_registration_fields"))
	{
		function ws_plugin__s2member_custom_registration_fields ()
			{
				do_action ("ws_plugin__s2member_before_custom_registration_fields", get_defined_vars ());
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
						echo '<input aria-required="true" type="password" maxlength="100" autocomplete="off" name="ws_plugin__s2member_custom_reg_field_user_pass" id="ws-plugin--s2member-custom-reg-field-user-pass" class="ws-plugin--s2member-custom-reg-field input" size="25" value="' . format_to_edit (trim (stripslashes ($_POST["ws_plugin__s2member_custom_reg_field_user_pass"]))) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
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
				echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_first_name" id="ws-plugin--s2member-custom-reg-field-first-name" class="ws-plugin--s2member-custom-reg-field input" size="25" value="' . format_to_edit (trim (stripslashes ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]))) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
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
				echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_last_name" id="ws-plugin--s2member-custom-reg-field-last-name" class="ws-plugin--s2member-custom-reg-field input" size="25" value="' . format_to_edit (trim (stripslashes ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]))) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
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
						if ($field = trim ($field, "* \t\n\r\0\x0B")) /* Don't process empty fields. */
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
								echo '<input' . $req . ' type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_' . $field_var . '" id="ws-plugin--s2member-custom-reg-field-' . $field_id_class . '" class="ws-plugin--s2member-custom-reg-field input" size="25" value="' . format_to_edit (trim (stripslashes ($_POST["ws_plugin__s2member_custom_reg_field_" . $field_var]))) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
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
						$register_link = add_query_arg ("s2member_register", $register, get_bloginfo ("url") . "/");
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
												echo '<script type="text/javascript">' . "\n";
												echo "window.location = '" . esc_js (add_query_arg ("action", "register", wp_login_url ())) . "';";
												echo '</script>' . "\n";
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
Function for configuring new users.
Attach to: add_action("user_register");
*/
if (!function_exists ("ws_plugin__s2member_configure_user_registration"))
	{
		function ws_plugin__s2member_configure_user_registration ($user_id = FALSE)
			{
				global $wpdb; /* Global database object may be required for this routine. */
				static $processed; /* Prevents duplicate processing. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_configure_user_registration", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (!$processed && is_array ($_POST = stripslashes_deep ($_POST)) && $user_id && is_object ($user = new WP_User ($user_id)) && $user->ID && ($processed = true))
					{
						ws_plugin__s2member_email_config (); /* Configures From: header that will be used in new user notifications. */
						/**/
						if (!is_admin () /* Only run this particular routine whenever a Member [1-4] is registering themselves with cookies. */
						&& ($subscr_id = ws_plugin__s2member_decrypt ($_COOKIE["s2member_subscr_id"])) && ($custom = ws_plugin__s2member_decrypt ($_COOKIE["s2member_custom"])) && preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", ($level = ws_plugin__s2member_decrypt ($_COOKIE["s2member_level"])))/**/
						&& (!$usermeta = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1")))
							/* ^ This is for security ^ It checks the database to make sure the User/Member has not already registered in the past, with the same PayPal Subscr. ID. */
							{
								$processed = "yes"; /* Mark this as yes, to indicate that a routine was successfully processed. */
								/**/
								list ($level, $ccaps, $eotper) = preg_split ("/\:/", $level, 3);
								$role = "s2member_level" . $level; /* Level 1-4. */
								/**/
								$email = $user->user_email;
								$login = $user->user_login;
								$ip = $_SERVER["REMOTE_ADDR"];
								$cv = preg_split ("/\|/", $custom);
								$fname = (!$user->first_name) ? trim ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]) : $user->first_name;
								$lname = (!$user->last_name) ? trim ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]) : $user->last_name;
								$name = trim ($fname . " " . $lname);
								/**/
								if (!$pass) /* s2Member password? */
									if ($GLOBALS["ws_plugin__s2member_generate_password_return"])
										$pass = $GLOBALS["ws_plugin__s2member_generate_password_return"];
								/**/
								if (!$pass) /* Also try to get the password from BuddyPress. */
									if ($_POST["signup_password"]) /* Field used by BuddyPress. */
										$pass = trim (stripslashes ($_POST["signup_password"]));
								/**/
								$opt_in = (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] || $_POST["ws_plugin__s2member_custom_reg_field_opt_in"]) ? true : false;
								/**/
								$user->set_role ($role); /* s2Member Role. */
								/**/
								update_usermeta ($user_id, "s2member_subscr_id", $subscr_id);
								update_usermeta ($user_id, "s2member_custom", $custom);
								/**/
								if ($ccaps) /* Add custom capabilities. */
									foreach (preg_split ("/[\r\n\t\s;,]+/", $ccaps) as $ccap)
										if (strlen ($ccap)) /* Don't add empty capabilities. */
											$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
								/**/
								if ($eotper) /* If a specific EOT Period has been attached; we need to calculate that now. */
									update_usermeta ($user_id, "s2member_auto_eot_time", ws_plugin__s2member_paypal_auto_eot_time (0, 0, 0, $eotper));
								/**/
								if (($transient = md5 ("s2member_transient_ipn_subscr_payment_" . $subscr_id)) && is_array ($subscr_payment = get_transient ($transient)))
									{
										$proxy = array ("s2member_paypal_notify" => "1", "s2member_paypal_proxy" => "s2member_transient_ipn_subscr_payment");
										ws_plugin__s2member_remote (add_query_arg ($proxy, get_bloginfo ("url")), stripslashes_deep ($subscr_payment), array ("timeout" => 20));
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
						else if (!is_admin () && preg_match ("/^(subscriber|s2member_level[1-4])$/", ($role = $user->roles[0])))
							{
								$processed = "yes"; /* Mark this as yes, to indicate that a routine was successfully processed. */
								/**/
								$level = ($role === "subscriber") ? "0" : preg_replace ("/^s2member_level/", "", $role);
								$ccaps = ""; /* Custom Capabilities are not applicable here. */
								/**/
								$email = $user->user_email;
								$login = $user->user_login;
								$ip = $_SERVER["REMOTE_ADDR"];
								$cv = preg_split ("/\|/", ""); /* Not applicable here. */
								$fname = (!$user->first_name) ? trim ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]) : $user->first_name;
								$lname = (!$user->last_name) ? trim ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]) : $user->last_name;
								$name = trim ($fname . " " . $lname);
								/**/
								if (!$pass) /* s2Member password? */
									if ($GLOBALS["ws_plugin__s2member_generate_password_return"])
										$pass = $GLOBALS["ws_plugin__s2member_generate_password_return"];
								/**/
								if (!$pass) /* Also try to get the password from BuddyPress. */
									if ($_POST["signup_password"]) /* Field used by BuddyPress. */
										$pass = trim (stripslashes ($_POST["signup_password"]));
								/**/
								$opt_in = (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] || $_POST["ws_plugin__s2member_custom_reg_field_opt_in"]) ? true : false;
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_configure_user_registration_front_side", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						else if (is_admin () && preg_match ("/wp-admin\/user-new\.php/", $_POST["_wp_http_referer"]) && preg_match ("/^(subscriber|s2member_level[1-4])$/", ($role = $user->roles[0])))
							{
								$processed = "yes"; /* Mark this as yes, to indicate that a routine was successfully processed. */
								/**/
								$level = ($role === "subscriber") ? "0" : preg_replace ("/^s2member_level/", "", $role);
								$ccaps = ""; /* Custom Capabilities are not applicable here. */
								/**/
								$email = $user->user_email;
								$login = $user->user_login;
								$ip = ""; /* N/Applicable. */
								$cv = preg_split ("/\|/", "");
								$fname = (!$user->first_name) ? trim ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]) : $user->first_name;
								$lname = (!$user->last_name) ? trim ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]) : $user->last_name;
								$name = trim ($fname . " " . $lname);
								/**/
								if (!$pass) /* s2Member password? */
									if ($GLOBALS["ws_plugin__s2member_generate_password_return"])
										$pass = $GLOBALS["ws_plugin__s2member_generate_password_return"];
								/**/
								if (!$pass) /* Also try the `Users -> Add New` form. */
									if ($_POST["pass1"]) /* Field used by admin form. */
										$pass = trim (stripslashes ($_POST["pass1"]));
								/**/
								$opt_in = (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] || $_POST["ws_plugin__s2member_custom_reg_field_opt_in"]) ? true : false;
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_configure_user_registration_admin_side", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						if ($processed === "yes") /* If registration was processed by one of the routines above. */
							{
								if (!$user->first_name && ($first_name = trim ($_POST["ws_plugin__s2member_custom_reg_field_first_name"])))
									update_usermeta ($user_id, "first_name", $first_name) . /* And display name. */
									wp_update_user (array ("ID" => $user_id, "display_name" => $first_name));
								/**/
								if (!$user->last_name && ($last_name = trim ($_POST["ws_plugin__s2member_custom_reg_field_last_name"])))
									update_usermeta ($user_id, "last_name", $last_name);
								/**/
								foreach (preg_split ("/[\r\n\t;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
									{
										if ($field = trim ($field, "* \t\n\r\0\x0B")) /* Don't process empty fields. */
											{
												$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
												$field_id_class = preg_replace ("/_/", "-", $field_var);
												/**/
												if (strlen ($_POST["ws_plugin__s2member_custom_reg_field_" . $field_var]))
													$fields[$field_var] = trim ($_POST["ws_plugin__s2member_custom_reg_field_" . $field_var]);
											}
									}
								/**/
								update_usermeta ($user_id, "s2member_custom_fields", $fields);
								/**/
								ws_plugin__s2member_process_list_servers ($level, $email, $fname, $lname, $ip, $opt_in);
								/**/
								if ($urls = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["registration_notification_urls"])
									foreach (preg_split ("/[\r\n\t]+/", $urls) as $url) /* Notify each of the urls. */
										if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)))
											if (($url = preg_replace ("/%%level%%/i", ws_plugin__s2member_esc_ds (urlencode ($level)), $url)))
												if (($url = preg_replace ("/%%user_first_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($fname)), $url)))
													if (($url = preg_replace ("/%%user_last_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($lname)), $url)))
														if (($url = preg_replace ("/%%user_full_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($name)), $url)))
															if (($url = preg_replace ("/%%user_email%%/i", ws_plugin__s2member_esc_ds (urlencode ($email)), $url)))
																if (($url = preg_replace ("/%%user_login%%/i", ws_plugin__s2member_esc_ds (urlencode ($login)), $url)))
																	if (($url = preg_replace ("/%%user_pass%%/i", ws_plugin__s2member_esc_ds (urlencode ($pass)), $url)))
																		if (($url = trim ($url))) /* Empty? */
																			ws_plugin__s2member_remote ($url);
								/**/
								if ($url = $GLOBALS["ws_plugin__s2member_registration_return_url"])
									if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)))
										if (($url = preg_replace ("/%%level%%/i", ws_plugin__s2member_esc_ds (urlencode ($level)), $url)))
											if (($url = preg_replace ("/%%user_first_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($fname)), $url)))
												if (($url = preg_replace ("/%%user_last_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($lname)), $url)))
													if (($url = preg_replace ("/%%user_full_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($name)), $url)))
														if (($url = preg_replace ("/%%user_email%%/i", ws_plugin__s2member_esc_ds (urlencode ($email)), $url)))
															if (($url = preg_replace ("/%%user_login%%/i", ws_plugin__s2member_esc_ds (urlencode ($login)), $url)))
																if (($url = preg_replace ("/%%user_pass%%/i", ws_plugin__s2member_esc_ds (urlencode ($pass)), $url)))
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
									$password = $custom; /* Use custom password and filter login messages. */
									add_filter ("login_messages", "_ws_plugin__s2member_registration_login_message");
								}
						/**/
						return ($GLOBALS["ws_plugin__s2member_generate_password_return"] = $password);
					}
				/**/
				function _ws_plugin__s2member_registration_login_message ($message = FALSE)
					{
						if ($message === "Registration complete. Please check your e-mail.")
							return apply_filters ("_ws_plugin__s2member_registration_login_message", "Registration complete. Please log in.", get_defined_vars ());
						/**/
						return $message;
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
?>