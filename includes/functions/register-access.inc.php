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
		if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["allow_subscribers_in"])
			{
				return apply_filters ("s2member_check_register_access", ($users_can_register = "1"));
			}
		else if ($pagenow !== "options-general.php" && $_COOKIE["s2member_subscr_id"] && $_COOKIE["s2member_custom"] && preg_match ("/^[1-4](\:|$)/", $_COOKIE["s2member_level"]))
			{
				global $wpdb; /* Global database object reference. */
				/**/
				if (!$usermeta = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($_COOKIE["s2member_subscr_id"]) . "' LIMIT 1"))
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
				$notice = "<em>* Note: The s2Member plugin has control over two options on this page. <code>Anyone Can Register = " . esc_html (get_option ("users_can_register")) . "</code>, and <code>Default Role = " . esc_html (get_option ("default_role")) . "</code>.";
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
						echo '<input aria-required="true" type="password" maxlength="100" name="ws_plugin__s2member_custom_reg_field_user_pass" id="ws-plugin--s2member-custom-reg-field-user-pass" class="ws-plugin--s2member-custom-reg-field input" size="25" tabindex="' . esc_attr (($tabindex = $tabindex + 1)) . '" value="' . format_to_edit (trim (stripslashes ($_REQUEST["ws_plugin__s2member_custom_reg_field_user_pass"]))) . '" />' . "\n";
						echo '</label>' . "\n";
						echo '</p>';
					}
				/**/
				echo '<p>' . "\n";
				echo '<label>' . "\n";
				echo 'First Name *' . "\n";
				echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_first_name" id="ws-plugin--s2member-custom-reg-field-first-name" class="ws-plugin--s2member-custom-reg-field input" size="25" tabindex="' . esc_attr (($tabindex = $tabindex + 1)) . '" value="' . format_to_edit (trim (stripslashes ($_REQUEST["ws_plugin__s2member_custom_reg_field_first_name"]))) . '" />' . "\n";
				echo '</label>' . "\n";
				echo '</p>';
				/**/
				echo '<p>' . "\n";
				echo '<label>' . "\n";
				echo 'Last Name *' . "\n";
				echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_last_name" id="ws-plugin--s2member-custom-reg-field-last-name" class="ws-plugin--s2member-custom-reg-field input" size="25" tabindex="' . esc_attr (($tabindex = $tabindex + 1)) . '" value="' . format_to_edit (trim (stripslashes ($_REQUEST["ws_plugin__s2member_custom_reg_field_last_name"]))) . '" />' . "\n";
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
								echo '<input' . $req . ' type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_' . esc_attr ($field) . '" id="ws-plugin--s2member-custom-reg-field-' . esc_attr (preg_replace ("/_/", "-", $field)) . '" class="ws-plugin--s2member-custom-reg-field input" size="25" tabindex="' . esc_attr (($tabindex = $tabindex + 1)) . '" value="' . format_to_edit (trim (stripslashes ($_REQUEST["ws_plugin__s2member_custom_reg_field_" . $field]))) . '" />' . "\n";
								echo '</label>' . "\n";
								echo '</p>';
							}
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
Generates registration links.
*/
function ws_plugin__s2member_register_link_gen ($subscr_id = FALSE, $custom = FALSE, $item_number = FALSE, $shrink = TRUE)
	{
		do_action ("s2member_before_register_link_gen");
		/**/
		if ($subscr_id && $custom && $item_number) /* Must have all of these. */
			{
				$register = ws_plugin__s2member_encrypt ("subscr_id_custom_item_number:.:|:.:" . $subscr_id . ":.:|:.:" . $custom . ":.:|:.:" . $item_number);
				$register_link = ws_plugin__s2member_append_query_var (get_bloginfo ("url") . "/", "s2member_register=" . urlencode ($register));
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
$_GET["s2member_paypal_register"] deprecated in v2.8.6.
*/
function ws_plugin__s2member_register ()
	{
		do_action ("s2member_before_register");
		/**/
		if ($_GET["s2member_register"] || ($_GET["s2member_register"] = $_GET["s2member_paypal_register"]))
			{
				if (is_array ($register = preg_split ("/\:\.\:\|\:\.\:/", ws_plugin__s2member_decrypt ($_GET["s2member_register"]))))
					{
						if (count ($register) === 4 && $register[0] === "subscr_id_custom_item_number" && $register[1] && $register[2] && $register[3])
							{
								setcookie ("s2member_subscr_id", $register[1], time () + 31556926, "/");
								setcookie ("s2member_custom", $register[2], time () + 31556926, "/");
								setcookie ("s2member_level", $register[3], time () + 31556926, "/");
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
Attach to: add_action("bp_core_signup_user");
*/
function ws_plugin__s2member_configure_user_registration ($user_id = FALSE)
	{
		global $wpdb; /* Global database object may be required for this routine. */
		static $processed; /* Prevents duplicate processing when attached to multiple hooks in support of plugins like BuddyPress. */
		/**/
		do_action ("s2member_before_configure_user_registration");
		/**/
		if (!$processed && $user_id && is_array ($_POST = stripslashes_deep ($_POST)) && is_object ($user = new WP_User ($user_id)) && ($processed = true))
			{
				ws_plugin__s2member_email_config (); /* Configures From: header that will be used in new user notifications. */
				/**/
				if (!is_admin () /* Only run this particular routine whenever a Member is registering themselves. */
				&& $_COOKIE["s2member_subscr_id"] && $_COOKIE["s2member_custom"] && preg_match ("/^[1-4](\:|$)/", $_COOKIE["s2member_level"]))
					{
						list ($level, $ccaps) = preg_split ("/\:/", $_COOKIE["s2member_level"], 2); /* Supports colon separated level:custom_capability,custom_capability. */
						/**/
						if (!$usermeta = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($_COOKIE["s2member_subscr_id"]) . "' LIMIT 1"))
							{
								$user->set_role ("s2member_level" . $level);
								/**/
								if ($ccaps) /* Add custom capabilities. */
									foreach (preg_split ("/[\r\n\t\s;,]+/", $ccaps) as $ccap)
										if (strlen ($ccap)) /* Don't add empty capabilities. */
											$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
								/**/
								update_usermeta ($user_id, "s2member_subscr_id", $_COOKIE["s2member_subscr_id"]);
								update_usermeta ($user_id, "s2member_custom", $_COOKIE["s2member_custom"]);
								/**/
								if (($mailchimp_api_key = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mailchimp_api_key"]) && ($mailchimp_list_ids = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_mailchimp_list_ids"]))
									{
										if (!class_exists ("NC_MCAPI"))
											include_once dirname (dirname (__FILE__)) . "/mailchimp/nc-mcapi.inc.php";
										/**/
										$MCAPI = new NC_MCAPI ($mailchimp_api_key); /* MailChimp® API class. */
										/**/
										$email = $user->user_email;
										$login = $user->user_login;
										$fname = ($user->first_name) ? $user->first_name : trim ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]);
										$lname = ($user->last_name) ? $user->last_name : trim ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]);
										/**/
										foreach (preg_split ("/[\r\n\t\s;,]+/", $mailchimp_list_ids) as $mailchimp_list_id)
											$MCAPI->listSubscribe ($mailchimp_list_id, $email, array ("FNAME" => $fname, "LNAME" => $lname, "OPTINIP" => $_SERVER["REMOTE_ADDR"]));
									}
								/**/
								if ($aweber_list_ids = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_aweber_list_ids"])
									{
										$email = $user->user_email;
										$login = $user->user_login;
										$fname = ($user->first_name) ? $user->first_name : trim ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]);
										$lname = ($user->last_name) ? $user->last_name : trim ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]);
										/**/
										foreach (preg_split ("/[\r\n\t\s;,]+/", $aweber_list_ids) as $aweber_list_id)
											@mail ($aweber_list_id . "@aweber.com", "s2Member Subscription Request",/**/
											"s2Member Subscription Request\ns2Member w/ PayPal Email ID\nBuyer: " . $fname . " " . $lname . "\n - end.",/**/
											"From: \"" . preg_replace ("/\"/", "", $fname . " " . $lname) . "\" <" . $email . ">\r\nContent-Type: text/plain; charset=utf-8");
									}
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["registration_notification_urls"])
									{
										$email = $user->user_email;
										$login = $user->user_login;
										$fname = ($user->first_name) ? $user->first_name : trim ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]);
										$lname = ($user->last_name) ? $user->last_name : trim ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]);
										/**/
										if (function_exists ("ws_plugin__s2member_generate_password"))
											if (!defined ("BP_VERSION") && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"])
												if (wp_verify_nonce (trim (stripslashes ($_POST["ws_plugin__s2member_registration"])), "ws-plugin--s2member-registration"))
													if ($pass = trim (stripslashes ($_POST["ws_plugin__s2member_custom_reg_field_user_pass"])))
														$pass = $pass;
										/**/
										if (is_array ($cv = preg_split ("/\|/", $_COOKIE["s2member_custom"])))
											foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["registration_notification_urls"]) as $url)
												if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)))
													if (($url = preg_replace ("/%%level%%/i", urlencode ($level), $url)))
														if (($url = preg_replace ("/%%user_first_name%%/i", urlencode ($fname), $url)))
															if (($url = preg_replace ("/%%user_last_name%%/i", urlencode ($lname), $url)))
																if (($url = preg_replace ("/%%user_full_name%%/i", urlencode (trim ($fname . " " . $lname)), $url)))
																	if (($url = preg_replace ("/%%user_email%%/i", urlencode ($email), $url)))
																		if (($url = preg_replace ("/%%user_login%%/i", urlencode ($login), $url)))
																			if (($url = preg_replace ("/%%user_pass%%/i", urlencode ($pass), $url)))
																				if (($url = trim ($url))) /* Make sure it is not empty. */
																					ws_plugin__s2member_curlpsr ($url, "s2member=1");
									}
								/**/
								do_action ("s2member_during_configure_user_registration_front_side");
							}
						/**/
						setcookie ("s2member_subscr_id", "", time () + 31556926, "/");
						setcookie ("s2member_custom", "", time () + 31556926, "/");
						setcookie ("s2member_level", "", time () + 31556926, "/");
					}
				/**/
				else if (is_admin () && preg_match ("/wp-admin\/user-new\.php/", $_POST["_wp_http_referer"]) && preg_match ("/^(subscriber|s2member_level[1-4])$/", $_POST["role"]))
					{
						if ($_POST["role"] === "subscriber" && ($mailchimp_api_key = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mailchimp_api_key"]) && ($mailchimp_list_ids = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_mailchimp_list_ids"]))
							{
								if (!class_exists ("NC_MCAPI"))
									include_once dirname (dirname (__FILE__)) . "/mailchimp/nc-mcapi.inc.php";
								/**/
								$MCAPI = new NC_MCAPI ($mailchimp_api_key); /* MailChimp® API class. */
								/**/
								$email = $user->user_email;
								$login = $user->user_login;
								$fname = ($user->first_name) ? $user->first_name : trim ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]);
								$lname = ($user->last_name) ? $user->last_name : trim ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]);
								/**/
								foreach (preg_split ("/[\r\n\t\s;,]+/", $mailchimp_list_ids) as $mailchimp_list_id)
									$MCAPI->listSubscribe ($mailchimp_list_id, $email, array ("FNAME" => $fname, "LNAME" => $lname, "OPTINIP" => ""));
							}
						/**/
						else if (($level = preg_replace ("/[^1-4]/", "", $_POST["role"])) && ($mailchimp_api_key = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mailchimp_api_key"]) && ($mailchimp_list_ids = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_mailchimp_list_ids"]))
							{
								if (!class_exists ("NC_MCAPI"))
									include_once dirname (dirname (__FILE__)) . "/mailchimp/nc-mcapi.inc.php";
								/**/
								$MCAPI = new NC_MCAPI ($mailchimp_api_key); /* MailChimp® API class. */
								/**/
								$email = $user->user_email;
								$login = $user->user_login;
								$fname = ($user->first_name) ? $user->first_name : trim ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]);
								$lname = ($user->last_name) ? $user->last_name : trim ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]);
								/**/
								foreach (preg_split ("/[\r\n\t\s;,]+/", $mailchimp_list_ids) as $mailchimp_list_id)
									$MCAPI->listSubscribe ($mailchimp_list_id, $email, array ("FNAME" => $fname, "LNAME" => $lname, "OPTINIP" => ""));
							}
						/**/
						if ($_POST["role"] === "subscriber" && ($aweber_list_ids = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_aweber_list_ids"]))
							{
								$email = $user->user_email;
								$login = $user->user_login;
								$fname = ($user->first_name) ? $user->first_name : trim ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]);
								$lname = ($user->last_name) ? $user->last_name : trim ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]);
								/**/
								foreach (preg_split ("/[\r\n\t\s;,]+/", $aweber_list_ids) as $aweber_list_id)
									@mail ($aweber_list_id . "@aweber.com", "s2Member Subscription Request",/**/
									"s2Member Subscription Request\ns2Member w/ PayPal Email ID\nBuyer: " . $fname . " " . $lname . "\n - end.",/**/
									"From: \"" . preg_replace ("/\"/", "", $fname . " " . $lname) . "\" <" . $email . ">\r\nContent-Type: text/plain; charset=utf-8");
							}
						/**/
						else if (($level = preg_replace ("/[^1-4]/", "", $_POST["role"])) && ($aweber_list_ids = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_aweber_list_ids"]))
							{
								$email = $user->user_email;
								$login = $user->user_login;
								$fname = ($user->first_name) ? $user->first_name : trim ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]);
								$lname = ($user->last_name) ? $user->last_name : trim ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]);
								/**/
								foreach (preg_split ("/[\r\n\t\s;,]+/", $aweber_list_ids) as $aweber_list_id)
									@mail ($aweber_list_id . "@aweber.com", "s2Member Subscription Request",/**/
									"s2Member Subscription Request\ns2Member w/ PayPal Email ID\nBuyer: " . $fname . " " . $lname . "\n - end.",/**/
									"From: \"" . preg_replace ("/\"/", "", $fname . " " . $lname) . "\" <" . $email . ">\r\nContent-Type: text/plain; charset=utf-8");
							}
						/**/
						if (($_POST["role"] === "subscriber" || ($level = preg_replace ("/[^1-4]/", "", $_POST["role"])))/**/
						&& $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["registration_notification_urls"])
							{
								$email = $user->user_email;
								$login = $user->user_login;
								$level = ($_POST["role"] === "subscriber") ? "0" : $level;
								$fname = ($user->first_name) ? $user->first_name : trim ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]);
								$lname = ($user->last_name) ? $user->last_name : trim ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]);
								/**/
								if ($pass = trim (stripslashes ($_POST["pass1"])))
									$pass = $pass; /* From the `Users -> Add New` form.
								/**/
								if (is_array ($cv = preg_split ("/\|/", $_COOKIE["s2member_custom"])))
									foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["registration_notification_urls"]) as $url)
										if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)))
											if (($url = preg_replace ("/%%level%%/i", urlencode ($level), $url)))
												if (($url = preg_replace ("/%%user_first_name%%/i", urlencode ($fname), $url)))
													if (($url = preg_replace ("/%%user_last_name%%/i", urlencode ($lname), $url)))
														if (($url = preg_replace ("/%%user_full_name%%/i", urlencode (trim ($fname . " " . $lname)), $url)))
															if (($url = preg_replace ("/%%user_email%%/i", urlencode ($email), $url)))
																if (($url = preg_replace ("/%%user_login%%/i", urlencode ($login), $url)))
																	if (($url = preg_replace ("/%%user_pass%%/i", urlencode ($pass), $url)))
																		if (($url = trim ($url))) /* Make sure it is not empty. */
																			ws_plugin__s2member_curlpsr ($url, "s2member=1");
							}
						/**/
						do_action ("s2member_during_configure_user_registration_admin_side");
					}
				/**/
				if (!is_admin () && !defined ("BP_VERSION")) /* This processes Custom Fields. */
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
					}
				/**/
				do_action ("s2member_during_configure_user_registration");
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
				do_action ("s2member_before_s2member_generate_password");
				/**/
				$password = ws_plugin__s2member_random_str_gen ($length, $special_chars);
				/**/
				if (!defined ("BP_VERSION") && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"])
					if (wp_verify_nonce (trim (stripslashes ($_POST["ws_plugin__s2member_registration"])), "ws-plugin--s2member-registration"))
						if ($custom = trim (stripslashes ($_POST["ws_plugin__s2member_custom_reg_field_user_pass"])))
							$password = $custom;
				/**/
				return $password; /* No filter here for security purposes. */
			}
	}
?>