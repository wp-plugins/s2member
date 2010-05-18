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
	exit;
/*
Function that forces a default Subscriber Role.
Attach to: add_filter("pre_option_default_role");
*/
function ws_plugin__s2member_force_default_role ($default_role = FALSE)
	{
		do_action ("s2member_before_force_default_role");
		/**/
		return apply_filters ("s2member_force_default_role", ($default_role = "subscriber"));
	}
/*
Function for allowing access to the register form.
Attach to: add_filter("pre_option_users_can_register");
*/
function ws_plugin__s2member_check_register_access ($users_can_register = FALSE)
	{
		global $pagenow; /* Check if we are on the General Options page. */
		/**/
		do_action ("s2member_before_check_register_access");
		/**/
		if (current_user_can ("create_users") || $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["allow_subscribers_in"])
			{
				return apply_filters ("s2member_check_register_access", ($users_can_register = "1"));
			}
		else if ($pagenow !== "options-general.php" && ($subscr_id = ws_plugin__s2member_decrypt ($_COOKIE["s2member_subscr_id"])) && ($custom = ws_plugin__s2member_decrypt ($_COOKIE["s2member_custom"])) && preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9] [A-Z])?$/", ($level = ws_plugin__s2member_decrypt ($_COOKIE["s2member_level"]))))
			{
				global $wpdb; /* Global database object reference. */
				/**/
				if (!$usermeta = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1"))
					{
						return apply_filters ("s2member_check_register_access", ($users_can_register = "1"));
					}
			}
		/**/
		return apply_filters ("s2member_check_register_access", ($users_can_register = "0"));
	}
/*
Function that describes the General Option overrides for clarity.
Attach to: add_action("admin_init");
*/
function ws_plugin__s2member_general_ops_notice ()
	{
		global $pagenow; /* Need this. */
		/**/
		do_action ("s2member_before_general_ops_notice");
		/**/
		if ($pagenow === "options-general.php" && !isset ($_GET["page"]))
			{
				$notice = "<em>* Note: The s2Member plugin has control over two options on this page. <code>Anyone Can Register = " . esc_html (get_option ("users_can_register")) . "</code>, and <code>Default Role = " . esc_html (get_option ("default_role")) . "</code>. For further details, see: <code>s2Member -> General Options -> Login Welcome Page -> Allow Free Subscribers</code>.";
				/**/
				do_action ("s2member_during_general_ops_notice");
				/**/
				ws_plugin__s2member_enqueue_admin_notice ($notice, $pagenow);
			}
		/**/
		do_action ("s2member_after_general_ops_notice");
		/**/
		return;
	}
/*
This adds custom fields to the registration form.
Attach to: add_action("register_form");
*/
function ws_plugin__s2member_custom_registration_fields ()
	{
		do_action ("s2member_before_custom_registration_fields");
		/**/
		if (!defined ("BP_VERSION")) /* Not compatible with BuddyPress. */
			{
				echo '<input type="hidden" name="ws_plugin__s2member_registration" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-registration")) . '" />' . "\n";
				/**/
				$tabindex = 20; /* Incremented tabindex starting with 20. */
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"] && function_exists ("ws_plugin__s2member_generate_password"))
					{
						echo '<p>' . "\n";
						echo '<label>' . "\n";
						echo 'Password *' . "\n";
						echo '<input aria-required="true" type="password" maxlength="100" name="ws_plugin__s2member_custom_reg_field_user_pass" id="ws-plugin--s2member-custom-reg-field-user-pass" class="ws-plugin--s2member-custom-reg-field input" size="25" tabindex="' . esc_attr (($tabindex = $tabindex + 1)) . '" value="' . format_to_edit (trim (stripslashes ($_POST["ws_plugin__s2member_custom_reg_field_user_pass"]))) . '" />' . "\n";
						echo '</label>' . "\n";
						echo '</p>';
					}
				/**/
				echo '<p>' . "\n";
				echo '<label>' . "\n";
				echo 'First Name *' . "\n";
				echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_first_name" id="ws-plugin--s2member-custom-reg-field-first-name" class="ws-plugin--s2member-custom-reg-field input" size="25" tabindex="' . esc_attr (($tabindex = $tabindex + 1)) . '" value="' . format_to_edit (trim (stripslashes ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]))) . '" />' . "\n";
				echo '</label>' . "\n";
				echo '</p>';
				/**/
				echo '<p>' . "\n";
				echo '<label>' . "\n";
				echo 'Last Name *' . "\n";
				echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_last_name" id="ws-plugin--s2member-custom-reg-field-last-name" class="ws-plugin--s2member-custom-reg-field input" size="25" tabindex="' . esc_attr (($tabindex = $tabindex + 1)) . '" value="' . format_to_edit (trim (stripslashes ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]))) . '" />' . "\n";
				echo '</label>' . "\n";
				echo '</p>';
				/**/
				foreach (preg_split ("/[\r\n\t;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
					{
						$req = preg_match ("/\*/", $field); /* Required fields should be wrapped inside asterisks. */
						$req = ($req) ? ' aria-required="true"' : ''; /* Has JavaScript validation applied. */
						/**/
						if ($field = trim ($field, "* \t\n\r\0\x0B")) /* Don't process empty fields. */
							{
								echo '<p>' . "\n";
								echo '<label>' . "\n";
								echo esc_html ($field) . (($req) ? " *" : "") . "\n";
								$field = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
								echo '<input' . $req . ' type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_' . esc_attr ($field) . '" id="ws-plugin--s2member-custom-reg-field-' . esc_attr (preg_replace ("/_/", "-", $field)) . '" class="ws-plugin--s2member-custom-reg-field input" size="25" tabindex="' . esc_attr (($tabindex = $tabindex + 1)) . '" value="' . format_to_edit (trim (stripslashes ($_POST["ws_plugin__s2member_custom_reg_field_" . $field]))) . '" />' . "\n";
								echo '</label>' . "\n";
								echo '</p>';
							}
					}
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] && ws_plugin__s2member_list_servers_integrated ())
					{
						echo '<p>' . "\n";
						echo '<label>' . "\n";
						echo '<input type="checkbox" name="ws_plugin__s2member_custom_reg_field_opt_in" id="ws-plugin--s2member-custom-reg-field-opt-in" tabindex="' . esc_attr (($tabindex = $tabindex + 1)) . '" value="1"' . (((empty ($_POST) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] == 1) || $_POST["ws_plugin__s2member_custom_reg_field_opt_in"]) ? ' checked="checked"' : '') . ' />' . "\n";
						echo $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in_label"] . "\n";
						echo '</label>' . "\n";
						echo '</p>';
					}
				/**/
				do_action ("s2member_during_custom_registration_fields");
			}
		/**/
		do_action ("s2member_after_custom_registration_fields");
		/**/
		return;
	}
/*
This adds an opt-in checkbox to the BuddyPress signup form.
Attach to: add_action("bp_before_registration_submit_buttons");
*/
function ws_plugin__s2member_opt_in_4bp ()
	{
		do_action ("s2member_before_opt_in_4bp");
		/**/
		if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] && ws_plugin__s2member_list_servers_integrated ())
			{
				echo '<div class="s2member-opt-in-4bp" style="' . apply_filters ("s2member_opt_in_4bp_styles", "clear:both; padding-top:10px; margin-left:-3px;") . '">' . "\n";
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
				do_action ("s2member_during_opt_in_4bp");
			}
		/**/
		do_action ("s2member_after_opt_in_4bp");
		/**/
		return;
	}
/*
Generates registration links.
*/
function ws_plugin__s2member_register_link_gen ($subscr_id = FALSE, $custom = FALSE, $item_number = FALSE, $shrink = TRUE)
	{
		do_action ("s2member_before_register_link_gen");
		/**/
		if ($subscr_id && $custom && $item_number) /* Must have all of these. */
			{
				$register = ws_plugin__s2member_encrypt ("subscr_id_custom_item_number:.:|:.:" . $subscr_id . ":.:|:.:" . $custom . ":.:|:.:" . $item_number);
				$register_link = add_query_arg ("s2member_register", $register, get_bloginfo ("url") . "/");
				/**/
				if ($shrink && ($tinyurl = @file_get_contents ("http://tinyurl.com/api-create.php?url=" . rawurlencode ($register_link))))
					return apply_filters ("s2member_register_link_gen", $tinyurl); /* tinyURL is easier to work with. */
				else /* Else use the long one; tinyURL fails if allow_url_fopen = no. */
					return apply_filters ("s2member_register_link_gen", $register_link);
			}
		/**/
		return false;
	}
/*
Handles registration links.
Attach to: add_action("init");
*/
function ws_plugin__s2member_register ()
	{
		do_action ("s2member_before_register");
		/**/
		if ($_GET["s2member_register"]) /* If they're attempting to access the registration system. */
			{
				if (is_array ($register = preg_split ("/\:\.\:\|\:\.\:/", ws_plugin__s2member_decrypt ($_GET["s2member_register"]))))
					{
						if (count ($register) === 4 && $register[0] === "subscr_id_custom_item_number" && $register[1] && $register[2] && $register[3])
							{
								setcookie ("s2member_subscr_id", ws_plugin__s2member_encrypt ($register[1]), time () + 31556926, "/");
								setcookie ("s2member_custom", ws_plugin__s2member_encrypt ($register[2]), time () + 31556926, "/");
								setcookie ("s2member_level", ws_plugin__s2member_encrypt ($register[3]), time () + 31556926, "/");
								/**/
								do_action ("s2member_during_register");
								/**/
								echo '<script type="text/javascript">' . "\n";
								echo "window.location = '" . esc_js (add_query_arg ("action", "register", wp_login_url ())) . "';";
								echo '</script>' . "\n";
							}
					}
				exit;
			}
		/**/
		do_action ("s2member_after_register");
	}
/*
Function for configuring new users.
Attach to: add_action("user_register");
*/
function ws_plugin__s2member_configure_user_registration ($user_id = FALSE)
	{
		global $wpdb; /* Global database object may be required for this routine. */
		static $processed; /* Prevents duplicate processing. */
		/**/
		do_action ("s2member_before_configure_user_registration");
		/**/
		if (!$processed && $user_id && is_array ($_POST = stripslashes_deep ($_POST)) && is_object ($user = new WP_User ($user_id)) && ($processed = true))
			{
				ws_plugin__s2member_email_config (); /* Configures From: header that will be used in new user notifications. */
				/**/
				if (!is_admin () /* Only run this particular routine whenever a Member [1-4] is registering themselves with cookies. */
				&& ($subscr_id = ws_plugin__s2member_decrypt ($_COOKIE["s2member_subscr_id"])) && ($custom = ws_plugin__s2member_decrypt ($_COOKIE["s2member_custom"])) && preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9] [A-Z])?$/", ($level = ws_plugin__s2member_decrypt ($_COOKIE["s2member_level"])))/**/
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
							if ($GLOBALS["s2member_password"])
								$pass = $GLOBALS["s2member_password"];
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
								ws_plugin__s2member_curlpsr (add_query_arg ($proxy, get_bloginfo ("url")), $subscr_payment);
								delete_transient ($transient);
							}
						/**/
						setcookie ("s2member_signup_tracking", ws_plugin__s2member_encrypt ($subscr_id), time () + 31556926, "/");
						/**/
						do_action ("s2member_during_configure_user_registration_front_side");
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
							if ($GLOBALS["s2member_password"])
								$pass = $GLOBALS["s2member_password"];
						/**/
						if (!$pass) /* Also try to get the password from BuddyPress. */
							if ($_POST["signup_password"]) /* Field used by BuddyPress. */
								$pass = trim (stripslashes ($_POST["signup_password"]));
						/**/
						$opt_in = (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] || $_POST["ws_plugin__s2member_custom_reg_field_opt_in"]) ? true : false;
						/**/
						do_action ("s2member_during_configure_user_registration_front_side");
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
							if ($GLOBALS["s2member_password"])
								$pass = $GLOBALS["s2member_password"];
						/**/
						if (!$pass) /* Also try the `Users -> Add New` form. */
							if ($_POST["pass1"]) /* Field used by admin form. */
								$pass = trim (stripslashes ($_POST["pass1"]));
						/**/
						$opt_in = (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] || $_POST["ws_plugin__s2member_custom_reg_field_opt_in"]) ? true : false;
						/**/
						do_action ("s2member_during_configure_user_registration_admin_side");
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
										$field = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
										if (strlen ($_POST["ws_plugin__s2member_custom_reg_field_" . $field]))
											$fields[$field] = trim ($_POST["ws_plugin__s2member_custom_reg_field_" . $field]);
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
									if (($url = preg_replace ("/%%level%%/i", urlencode ($level), $url)))
										if (($url = preg_replace ("/%%user_first_name%%/i", urlencode ($fname), $url)))
											if (($url = preg_replace ("/%%user_last_name%%/i", urlencode ($lname), $url)))
												if (($url = preg_replace ("/%%user_full_name%%/i", urlencode ($name), $url)))
													if (($url = preg_replace ("/%%user_email%%/i", urlencode ($email), $url)))
														if (($url = preg_replace ("/%%user_login%%/i", urlencode ($login), $url)))
															if (($url = preg_replace ("/%%user_pass%%/i", urlencode ($pass), $url)))
																if (($url = trim ($url))) /* Make sure it is not empty. */
																	ws_plugin__s2member_curlpsr ($url, "s2member=1");
						/**/
						setcookie ("s2member_subscr_id", "", time () + 31556926, "/");
						setcookie ("s2member_custom", "", time () + 31556926, "/");
						setcookie ("s2member_level", "", time () + 31556926, "/");
						/**/
						do_action ("s2member_during_configure_user_registration");
					}
			}
		/**/
		do_action ("s2member_after_configure_user_registration");
		/**/
		return;
	}
/*
Pluggable function that handles password generation.
Taken from: /wp-includes/pluggable.php
*/
if (!function_exists ("wp_generate_password"))
	{
		function wp_generate_password ($length = 12, $special_chars = TRUE)
			{
				return ws_plugin__s2member_generate_password ($length, $special_chars);
			}
		/**/
		function ws_plugin__s2member_generate_password ($length = 12, $special_chars = TRUE)
			{
				do_action ("s2member_before_generate_password");
				/**/
				$password = ws_plugin__s2member_random_str_gen ($length, $special_chars);
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"])
					if (wp_verify_nonce (trim (stripslashes ($_POST["ws_plugin__s2member_registration"])), "ws-plugin--s2member-registration"))
						if ($custom = trim (stripslashes ($_POST["ws_plugin__s2member_custom_reg_field_user_pass"])))
							$password = $custom;
				/**/
				return ($GLOBALS["s2member_password"] = $password);
			}
	}
?>