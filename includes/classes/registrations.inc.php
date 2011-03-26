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
/**/
if (!class_exists ("c_ws_plugin__s2member_registrations"))
	{
		class c_ws_plugin__s2member_registrations
			{
				/*
				This function filters WordPress® generated Passwords.
				Attach to: add_filter("random_password");
				*/
				public static function generate_password ($password = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_generate_password", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"])
							if ($custom = trim (stripslashes ($_POST["ws_plugin__s2member_custom_reg_field_user_pass"])))
								{
									$password = $custom; /* Yes, use s2Member custom Password supplied by User. */
								}
						/**/
						$GLOBALS["ws_plugin__s2member_generate_password_return"] = $password; /* Global reference. */
						/**/
						return apply_filters ("ws_plugin__s2member_generate_password", $password, get_defined_vars ());
					}
				/*
				Function that filters Multisite User validation.
				Attach to: add_filter("wpmu_validate_user_signup");
				
				This can ONLY be fired through `/wp-signup.php` on the front-side.
					Or through `/register` via BuddyPress.
				*/
				public static function ms_validate_user_signup ($result = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_ms_validate_user_signup", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_multisite ()) /* This event should ONLY be processed with Multisite Networking. */
							if (!is_admin () && ( (preg_match ("/\/wp-signup\.php/", $_SERVER["REQUEST_URI"]) && preg_match ("/^validate-(user|blog)-signup$/", $_POST["stage"])) || (defined ("BP_VERSION") && preg_match ("/\/" . preg_quote (BP_REGISTER_SLUG, "/") . "/", $_SERVER["REQUEST_URI"]))))
								{
									if (c_ws_plugin__s2member_utils_users::ms_user_login_email_exists_but_not_on_blog ($result["user_name"], $result["user_email"]))
										$result["errors"] = new WP_Error ();
									/**/
									eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
									do_action ("ws_plugin__s2member_during_ms_validate_user_signup", get_defined_vars ());
									unset ($__refs, $__v); /* Unset defined __refs, __v. */
								}
						/**/
						return apply_filters ("ws_plugin__s2member_ms_validate_user_signup", $result, get_defined_vars ());
					}
				/*
				Function that adds hidden fields to POST vars on signup.
				Attach to: add_filter("signup_hidden_fields");
				
				This can ONLY be fired through `/wp-signup.php` on the front-side.
					Or through `/register` via BuddyPress.
				*/
				public static function ms_process_signup_hidden_fields ()
					{
						do_action ("ws_plugin__s2member_before_ms_process_signup_hidden_fields", get_defined_vars ());
						/**/
						if (is_multisite ()) /* This event should ONLY be processed with Multisite Networking. */
							if (!is_admin () && ( (preg_match ("/\/wp-signup\.php/", $_SERVER["REQUEST_URI"]) && preg_match ("/^validate-(user|blog)-signup$/", $_POST["stage"])) || (defined ("BP_VERSION") && preg_match ("/\/" . preg_quote (BP_REGISTER_SLUG, "/") . "/", $_SERVER["REQUEST_URI"]))))
								{
									foreach ((array)c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($_POST)) as $key => $value)
										if (preg_match ("/^ws_plugin__s2member_(custom_reg_field|user_new)_/", $key))
											if ($key = preg_replace ("/_user_new_/", "_custom_reg_field_", $key))
												echo '<input type="hidden" name="' . esc_attr ($key) . '" value="' . esc_attr (maybe_serialize ($value)) . '" />' . "\n";
									/**/
									do_action ("ws_plugin__s2member_during_ms_process_signup_hidden_fields", get_defined_vars ());
								}
						/**/
						do_action ("ws_plugin__s2member_after_ms_process_signup_hidden_fields", get_defined_vars ());
					}
				/*
				Function that adds customs fields to $meta on signup.
				Attach to: add_filter("add_signup_meta");
				Attach to: add_filter("bp_signup_usermeta");
				
				This can ONLY be fired through `/wp-signup.php` on the front-side.
					Or possibly through `/user-new.php` in the admin.
					Or through `/register` via BuddyPress.
				*/
				public static function ms_process_signup_meta ($meta = FALSE)
					{
						global $pagenow; /* Need this to detect the current admin page. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_ms_process_signup_meta", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_multisite ()) /* This event should ONLY be processed with Multisite Networking. */
							if ((c_ws_plugin__s2member_utils_conds::is_blog_admin () && $pagenow === "user-new.php") || (!is_admin () && ( (preg_match ("/\/wp-signup\.php/", $_SERVER["REQUEST_URI"]) && preg_match ("/^validate-(user|blog)-signup$/", $_POST["stage"])) || (defined ("BP_VERSION") && preg_match ("/\/" . preg_quote (BP_REGISTER_SLUG, "/") . "/", $_SERVER["REQUEST_URI"])))))
								{
									c_ws_plugin__s2member_email_configs::email_config (); /* Configures From: header used in notifications. */
									/**/
									foreach ((array)c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($_POST)) as $key => $value)
										if (preg_match ("/^ws_plugin__s2member_(custom_reg_field|user_new)_/", $key))
											if ($key = preg_replace ("/_user_new_/", "_custom_reg_field_", $key))
												$meta["s2member_ms_signup_meta"][$key] = maybe_unserialize ($value);
								}
						/**/
						return apply_filters ("ws_plugin__s2member_ms_process_signup_meta", $meta, get_defined_vars ());
					}
				/*
				This routine intersects with `wpmu_activate_signup()` through s2Member's Multisite Networking patch.
				Attach to: add_filter("_wpmu_activate_existing_error_");
				
				This function should return the same array that `wpmu_activate_signup()` returns; with the assumption that $user_already_exists.
					* Which is exactly where this function intersects inside the `/wp-includes/ms-functions.php`.
				
				This can ONLY be fired through `/wp-activate.php` on the front-side.
					Or through `/activate` via BuddyPress.
				*/
				public static function ms_activate_existing_user ($__error = FALSE, $vars = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_ms_activate_existing_user", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						extract($vars); /* Extract all variables from `wpmu_activate_signup()` function. */
						/**/
						if (is_multisite ()) /* This event should ONLY be processed with Multisite Networking. */
							if (!is_admin () && ( (preg_match ("/\/wp-activate\.php/", $_SERVER["REQUEST_URI"])) || (defined ("BP_VERSION") && preg_match ("/\/" . preg_quote (BP_ACTIVATION_SLUG, "/") . "/", $_SERVER["REQUEST_URI"]))))
								{
									if ($user_id && $password && $meta && $meta["add_to_blog"] && $meta["new_role"] && $user_already_exists && c_ws_plugin__s2member_utils_users::ms_user_login_email_exists_but_not_on_blog ($user_login, $user_email))
										{
											add_user_to_blog ($meta["add_to_blog"], $user_id, $meta["new_role"]); /* Add this User to the specified Blog. */
											wp_update_user (array ("ID" => $user_id, "user_pass" => $password)); /* Update Password so it's the same as in the following msg. */
											wpmu_welcome_user_notification ($user_id, $password, $meta); /* Send welcome letter via email just like `wpmu_activate_signup()` does. */
											/**/
											do_action ("wpmu_activate_user", $user_id, $password, $meta); /* Process Hook that would have been fired inside `wpmu_activate_signup()`. */
											/**/
											return apply_filters ("ws_plugin__s2member_ms_activate_existing_user", array ("user_id" => $user_id, "password" => $password, "meta" => $meta), get_defined_vars ());
										}
								}
						/**/
						return apply_filters ("ws_plugin__s2member_ms_activate_existing_user", $__error, get_defined_vars ()); /* Else, return the standardized error. */
					}
				/*
				Function for configuring new users.
				Attach to: add_action("wpmu_activate_user");
				
				This can ONLY be fired in the admin via ( `/user-new.php` ).
					Or also during an actual activation; through `/wp-activate.php`.
					Or also during an actual activation; through `/activate` via BuddyPress.
				*/
				public static function configure_user_on_ms_user_activation ($user_id = FALSE, $password = FALSE, $meta = FALSE)
					{
						global $pagenow; /* Need this to detect the current admin page. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_configure_user_on_ms_user_activation", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_multisite ()) /* This event should ONLY be processed with Multisite Networking. */
							if ((c_ws_plugin__s2member_utils_conds::is_blog_admin () && $pagenow === "user-new.php" && isset ($_POST["noconfirmation"])) || (!is_admin () && ( (preg_match ("/\/wp-activate\.php/", $_SERVER["REQUEST_URI"])) || (defined ("BP_VERSION") && preg_match ("/\/" . preg_quote (BP_ACTIVATION_SLUG, "/") . "/", $_SERVER["REQUEST_URI"])))))
								{
									c_ws_plugin__s2member_registrations::configure_user_registration ($user_id, $password, $meta["s2member_ms_signup_meta"]);
									delete_user_meta ($user_id, "s2member_ms_signup_meta");
								}
						/**/
						do_action ("ws_plugin__s2member_after_configure_user_on_ms_user_activation", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Function for configuring new users.
				Attach to: add_action("wpmu_activate_blog");
				
				This does NOT fire for a Super Admin managing Network Blogs.
				~ Actually they do; BUT it's blocked by the routine below.
				Which is good. A Super Admin should NOT trigger this event.
				
				This function should ONLY be fired through `/wp-activate.php`.
					Or also through `/activate` via BuddyPress.
				*/
				public static function configure_user_on_ms_blog_activation ($blog_id = FALSE, $user_id = FALSE, $password = FALSE, $title = FALSE, $meta = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_configure_user_on_ms_blog_activation", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_multisite ()) /* This event should ONLY be processed with Multisite Networking. */
							if (!is_admin () && ( (preg_match ("/\/wp-activate\.php/", $_SERVER["REQUEST_URI"])) || (defined ("BP_VERSION") && preg_match ("/\/" . preg_quote (BP_ACTIVATION_SLUG, "/") . "/", $_SERVER["REQUEST_URI"]))))
								{
									c_ws_plugin__s2member_registrations::configure_user_registration ($user_id, $password, $meta["s2member_ms_signup_meta"]);
									delete_user_meta ($user_id, "s2member_ms_signup_meta");
								}
						/**/
						do_action ("ws_plugin__s2member_after_configure_user_on_ms_blog_activation", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				This routine intersects with `register_new_user()` through s2Member's Multisite Networking patch.
				Attach to: add_filter("registration_errors");
				
				This function Filters registration errors inside `/wp-login.php` via `register_new_user()`.
				When an existing Multisite User is registering, this takes over registration processing.
				
				This can ONLY be fired through `/wp-login.php` on the front-side.
				*/
				public static function ms_register_existing_user ($errors = FALSE, $user_login = FALSE, $user_email = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_ms_register_existing_user", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_multisite ()) /* Should ONLY be processed with Multisite Networking. */
							if (!is_admin () && preg_match ("/\/wp-login\.php/", $_SERVER["REQUEST_URI"]))
								if (is_wp_error ($errors) && $errors->get_error_code ())
									{
										if (($user_id = c_ws_plugin__s2member_utils_users::ms_user_login_email_exists_but_not_on_blog ($user_login, $user_email)))
											{
												foreach ($errors->get_error_codes () as $error_code)
													if (!preg_match ("/^(username_exists|email_exists)$/i", $error_code))
														$other_important_errors_exist = true;
												/**/
												if (!$other_important_errors_exist) /* Only if/when NO other important errors exist. */
													{
														$user_pass = wp_generate_password (); /* A new Password is now generated here. */
														c_ws_plugin__s2member_registrations::ms_create_existing_user ($user_login, $user_email, $user_pass, $user_id);
														update_user_option ($user_id, "default_password_nag", true, true); /* Set up the Password change nag screen. */
														wp_new_user_notification ($user_id, $user_pass); /* Welcome email, just like `register_new_user()` does. */
														/**/
														$redirect_to = trim (stripslashes ($_REQUEST["redirect_to"]));
														$redirect_to = ($redirect_to) ? $redirect_to : add_query_arg ("checkemail", urlencode ("registered"), wp_login_url ());
														/**/
														do_action ("ws_plugin__s2member_during_ms_register_existing_user", get_defined_vars ());
														/**/
														wp_safe_redirect($redirect_to); /* Use safe redirect; like `register_new_user()`. */
														/**/
														exit (); /* Clean exit. */
													}
											}
									}
								else if (($r = wpmu_validate_user_signup ($user_login, $user_email)) && is_wp_error ($e = $r["errors"]) && $e->get_error_code ())
									$errors->add ($e->get_error_code (), $e->get_error_message ());
						/**/
						do_action ("ws_plugin__s2member_after_ms_register_existing_user", get_defined_vars ());
						/**/
						return apply_filters ("ws_plugin__s2member_ms_register_existing_user", $errors, get_defined_vars ());
					}
				/*
				For Multisite Networksing, this function is used to add a User to an existing Blog; and to simulate `wp_create_user()` behavior.
				The $user_id value will be returned by this function, just like `wp_create_user()` does.
					* This function will fire the Hook `user_register`.
				*/
				public static function ms_create_existing_user ($user_login = FALSE, $user_email = FALSE, $user_pass = FALSE, $user_id = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_ms_create_existing_user", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_multisite ()) /* This event should ONLY be processed with Multisite Networking. */
							{
								if (($user_id || ($user_id = c_ws_plugin__s2member_utils_users::ms_user_login_email_exists_but_not_on_blog ($user_login, $user_email))) && $user_pass)
									{
										$role = get_option ("default_role"); /* Use default Role. */
										add_existing_user_to_blog (array ("user_id" => $user_id, "role" => $role)); /* Add existing User. */
										wp_update_user (array ("ID" => $user_id, "user_pass" => $user_pass)); /* Update Password to $user_pass. */
										/**/
										do_action ("ws_plugin__s2member_during_ms_create_existing_user", get_defined_vars ());
										do_action ("user_register", $user_id); /* So s2Member knows a User is registering. */
										/**/
										return apply_filters ("ws_plugin__s2member_ms_create_existing_user", $user_id, get_defined_vars ());
									}
							}
						/**/
						return apply_filters ("ws_plugin__s2member_ms_create_existing_user", false, get_defined_vars ());
					}
				/*
				Function for configuring new users.
				Attach to: add_action("user_register");
				
				This also receives Multisite events.
				Attach to: add_action("wpmu_activate_user");
				Attach to: add_action("wpmu_activate_blog");
				
				The Hook `user_register` is also fired by calling:
				`c_ws_plugin__s2member_registrations::ms_create_existing_user()`
				`wpmu_create_user()`
						
				This function also receives simulated events from s2Member Pro.
				*/
				public static function configure_user_registration ($user_id = FALSE, $password = FALSE, $meta = FALSE)
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
							c_ws_plugin__s2member_email_configs::email_config (); /* Configures From: header that will be used in new user notifications. */
						/**/
						if (!$processed /* Process only once. Safeguard this routine against duplicate processing via plugins ( or even WordPress® itself ). */
						&& (is_array ($post = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($_POST))) || is_array ($meta)) /* Or a $meta array. */
						/* These negative matches are designed to prevent this routine from running under certain conditions; where we need to wait for `wpmu_activate_user|blog` instead of processing now. */
						&& ! (is_multisite () && c_ws_plugin__s2member_utils_conds::is_blog_admin () && $pagenow === "user-new.php" && isset ($post["noconfirmation"]) && is_super_admin () && func_num_args () !== 3)/**/
						&& ! (preg_match ("/\/wp-activate\.php/", $_SERVER["REQUEST_URI"]) && func_num_args () !== 3) /* If activating; we MUST have a $meta arg to proceed. */
						&& ! (defined ("BP_VERSION") && preg_match ("/\/" . preg_quote (BP_ACTIVATION_SLUG, "/") . "/", $_SERVER["REQUEST_URI"]) && func_num_args () !== 3)
						/* The $meta argument is ONLY passed in by hand-offs from `wpmu_activate_user|blog`. So this is how we check for these events. */
						/**/
						&& $user_id && is_object ($user = new WP_User ($user_id)) && $user->ID && ($processed = true)) /* Process only once. */
							{
								foreach ((array)$post as $key => $value) /* Scan $post vars; adding `custom_reg_field` uniformity keys. */
									if (preg_match ("/^ws_plugin__s2member_user_new_/", $key)) /* Looking for `user_new` keys here. */
										if ($key = preg_replace ("/_user_new_/", "_custom_reg_field_", $key))
											$post[$key] = $value; /* Add these keys for uniformity. */
								unset ($key, $value); /* Prevents bleeding vars into Hooks/Filters. */
								/**/
								$meta = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ((array)$meta)); /* Clean up. */
								/**/
								if (!is_admin () && ($post["ws_plugin__s2member_custom_reg_field_s2member_subscr_gateway"] || $post["ws_plugin__s2member_custom_reg_field_s2member_subscr_id"] || $post["ws_plugin__s2member_custom_reg_field_s2member_custom"] || $post["ws_plugin__s2member_custom_reg_field_s2member_ccaps"] || $post["ws_plugin__s2member_custom_reg_field_s2member_auto_eot_time"] || $post["ws_plugin__s2member_custom_reg_field_s2member_notes"]))
									exit ("s2Member security violation. You attempted to POST administrative variables that will NOT be trusted in a NON-administrative zone!");
								/**/
								$_pmr = array_merge ((array)$post, (array)$meta, (array)$GLOBALS["ws_plugin__s2member_registration_vars"]); /* Merge these together. */
								unset ($post, $meta, $GLOBALS["ws_plugin__s2member_registration_vars"]); /* These vars can all be unset now; we have them all now inside $_pmr. */
								/**/
								if (!is_admin () /* Only run this particular routine whenever a Member Level [1-4] is registering themselves with paid authorization cookies in their browser. */
								&& ($subscr_gateway = c_ws_plugin__s2member_utils_encryption::decrypt ($_COOKIE["s2member_subscr_gateway"])) && ($subscr_id = c_ws_plugin__s2member_utils_encryption::decrypt ($_COOKIE["s2member_subscr_id"])) && preg_match ("/^" . preg_quote (preg_replace ("/\:([0-9]+)$/", "", $_SERVER["HTTP_HOST"]), "/") . "/i", ($custom = c_ws_plugin__s2member_utils_encryption::decrypt ($_COOKIE["s2member_custom"]))) && preg_match ("/^[1-4](\:|$)([\+a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", ($level = c_ws_plugin__s2member_utils_encryption::decrypt ($_COOKIE["s2member_level"])))/**/
								&& (!$usermeta = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1")))
									/* ^ This is for security ^ It checks the database to make sure the User/Member has not already registered in the past, with the same Paid Subscr. ID. */
									{ /*
										This routine could be processed through `wp-login.php?action=register`, `wp-activate.php`, or `/activate` via BuddyPress`.
										This may also be processed through a standard BuddyPress installation, or another plugin calling `user_register`.
										If processed through `wp-activate.php`, it could've originated inside the admin, via `user-new.php`.
										*/
										$processed = "yes"; /* Mark this as yes, to indicate that a routine was processed. */
										/**/
										$current_role = c_ws_plugin__s2member_user_access::user_access_role ($user);
										list ($level, $ccaps, $eotper) = preg_split ("/\:/", $level, 3);
										$role = "s2member_level" . $level; /* Membership Level. */
										/**/
										$email = $user->user_email;
										$login = $user->user_login;
										$ip = $_SERVER["REMOTE_ADDR"];
										$cv = preg_split ("/\|/", $custom);
										/**/
										if (! ($auto_eot_time = "") && $eotper) /* If a specific EOT Period has been attached. */
											$auto_eot_time = c_ws_plugin__s2member_utils_time::auto_eot_time ("", "", "", $eotper);
										/**/
										$notes = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_notes"];
										/**/
										$opt_in = (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"]) ? true : false;
										$opt_in = (!$opt_in && $_pmr["ws_plugin__s2member_custom_reg_field_opt_in"]) ? true : $opt_in;
										/**/
										if (! ($fname = $user->first_name))
											if ($_pmr["ws_plugin__s2member_custom_reg_field_first_name"])
												$fname = $_pmr["ws_plugin__s2member_custom_reg_field_first_name"];
										/**/
										if (!$fname) /* Also try BuddyPress. */
											if ($_pmr["field_1"]) /* BuddyPress. */
												$fname = trim (preg_replace ("/ (.*)$/", "", $_pmr["field_1"]));
										/**/
										if (! ($lname = $user->last_name))
											if ($_pmr["ws_plugin__s2member_custom_reg_field_last_name"])
												$lname = $_pmr["ws_plugin__s2member_custom_reg_field_last_name"];
										/**/
										if (!$lname) /* Also try BuddyPress. */
											if ($_pmr["field_1"] && preg_match ("/^(.+?) (.+)$/", $_pmr["field_1"]))
												$lname = trim (preg_replace ("/^(.+?) (.+)$/", "$2", $_pmr["field_1"]));
										/**/
										$name = trim ($fname . " " . $lname); /* Both names. */
										/**/
										if (! ($pass = $password)) /* Try s2Member's generator. */
											if ($GLOBALS["ws_plugin__s2member_generate_password_return"])
												$pass = $GLOBALS["ws_plugin__s2member_generate_password_return"];
										/**/
										if (!$pass) /* Also try BuddyPress Password. */
											if ($_pmr["signup_password"]) /* BuddyPress. */
												$pass = $_pmr["signup_password"];
										/**/
										if ($pass) /* No Password nag. Update this globally. */
											{
												delete_user_setting ("default_password_nag"); /* setcookie() */
												update_user_option ($user_id, "default_password_nag", false, true);
											}
										/**/
										update_user_option ($user_id, "s2member_auto_eot_time", $auto_eot_time);
										update_user_option ($user_id, "s2member_subscr_gateway", $subscr_gateway);
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
										if (is_multisite ()) /* Should we handle Main Site permissions and Originating Blog ID#? */
											{
												if (!is_main_site () && strtotime ($user->user_registered) >= strtotime ("-10 seconds"))
													remove_user_from_blog ($user_id, $current_site->blog_id); /* No Main Site Role. */
												/**/
												if (!get_user_meta ($user_id, "s2member_originating_blog", true)) /* Recorded yet? */
													update_user_meta ($user_id, "s2member_originating_blog", $current_blog->blog_id);
											}
										/**/
										if ($current_role !== $role) /* Only if NOT the current Role. */
											$user->set_role ($role); /* s2Member. */
										/**/
										if (!preg_match ("/^\+/", $ccaps))
											foreach ($user->allcaps as $cap => $cap_enabled)
												if (preg_match ("/^access_s2member_ccap_/", $cap))
													$user->remove_cap ($ccap = $cap);
										/**/
										if ($ccaps) /* Add Custom Capabilities. */
											foreach (preg_split ("/[\r\n\t\s;,]+/", ltrim ($ccaps, "+")) as $ccap)
												if (strlen ($ccap)) /* Don't add empty Custom Capabilities. */
													$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
										/**/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"])
											foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
												{
													$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
													$field_id_class = preg_replace ("/_/", "-", $field_var);
													/**/
													if (isset ($_pmr["ws_plugin__s2member_custom_reg_field_" . $field_var]))
														$fields[$field_var] = $_pmr["ws_plugin__s2member_custom_reg_field_" . $field_var];
												}
										/**/
										update_user_option ($user_id, "s2member_custom_fields", $fields);
										/**/
										if (($transient = "s2m_" . md5 ("s2member_transient_ipn_subscr_payment_" . $subscr_id)) && is_array ($subscr_payment = get_transient ($transient)))
											{
												$proxy = array ("s2member_paypal_notify" => "1", "s2member_paypal_proxy" => stripslashes ($subscr_payment["subscr_gateway"]), "s2member_paypal_proxy_verification" => c_ws_plugin__s2member_paypal_utilities::paypal_proxy_key_gen ());
												c_ws_plugin__s2member_utils_urls::remote (add_query_arg (urlencode_deep ($proxy), site_url ("/")), stripslashes_deep ($subscr_payment), array ("timeout" => 20));
												delete_transient($transient); /* This can be deleted now. */
											}
										/**/
										if (($transient = "s2m_" . md5 ("s2member_transient_ipn_signup_vars_" . $subscr_id)) && is_array ($ipn_signup_vars = get_transient ($transient)))
											{
												update_user_option ($user_id, "s2member_ipn_signup_vars", $ipn_signup_vars); /* For future reference. */
												delete_transient($transient); /* This can be deleted now. */
											}
										/**/
										setcookie ("s2member_signup_tracking", c_ws_plugin__s2member_utils_encryption::encrypt ($subscr_id), time () + 31556926, "/");
										/**/
										if ($level > 0) /* We ONLY process this if they are higher than Level#0. */
											{
												$pr_times = get_user_option ("s2member_paid_registration_times", $user_id);
												$pr_times["level"] = (!$pr_times["level"]) ? time () : $pr_times["level"]; /* Preserve. */
												$pr_times["level" . $level] = (!$pr_times["level" . $level]) ? time () : $pr_times["level" . $level];
												update_user_option ($user_id, "s2member_paid_registration_times", $pr_times); /* Update now. */
											}
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_configure_user_registration_front_side_paid", get_defined_vars ());
										do_action ("ws_plugin__s2member_during_configure_user_registration_front_side", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								/**/
								else if (!is_admin ()) /* Otherwise, if we are NOT inside the Dashboard during the creation of this account. */
									{ /* This routine could be processed through `wp-login.php?action=register`, `wp-activate.php`, or `/activate` via BuddyPress`.
										This may also be processed through a standard BuddyPress installation, or another plugin calling `user_register`.
										If processed through `wp-activate.php`, it could've originated inside the admin, via `user-new.php`.
										*/
										$processed = "yes"; /* Mark this as yes, to indicate that a routine was processed. */
										/**/
										$current_role = c_ws_plugin__s2member_user_access::user_access_role ($user);
										$role = ($level = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_level"]) ? "s2member_level" . $level : $role;
										$role = (!$role && $current_role) ? $current_role : $role; /* Use existing Role? */
										$role = (!$role) ? get_option ("default_role") : $role; /* Otherwise default. */
										/**/
										$level = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_level"];
										$level = (!$level && preg_match ("/^(administrator|editor|author|contributor)$/i", $role)) ? "4" : $level;
										$level = (!$level && preg_match ("/^s2member_level[1-4]$/i", $role)) ? preg_replace ("/^s2member_level/", "", $role) : $level;
										$level = (!$level && preg_match ("/^subscriber$/i", $role)) ? "0" : $level;
										$level = (!$level) ? "0" : $level;
										/**/
										$ccaps = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_ccaps"];
										/**/
										$email = $user->user_email;
										$login = $user->user_login;
										$ip = $_SERVER["REMOTE_ADDR"];
										$custom = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_custom"];
										$subscr_id = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_subscr_id"];
										$subscr_gateway = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_subscr_gateway"];
										$cv = preg_split ("/\|/", $_pmr["ws_plugin__s2member_custom_reg_field_s2member_custom"]);
										/**/
										$auto_eot_time = ($eot = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_auto_eot_time"]) ? strtotime ($eot) : "";
										$notes = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_notes"];
										/**/
										$opt_in = (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"]) ? true : false;
										$opt_in = (!$opt_in && $_pmr["ws_plugin__s2member_custom_reg_field_opt_in"]) ? true : $opt_in;
										/**/
										if (! ($fname = $user->first_name))
											if ($_pmr["ws_plugin__s2member_custom_reg_field_first_name"])
												$fname = $_pmr["ws_plugin__s2member_custom_reg_field_first_name"];
										/**/
										if (!$fname) /* Also try BuddyPress. */
											if ($_pmr["field_1"]) /* BuddyPress. */
												$fname = trim (preg_replace ("/ (.*)$/", "", $_pmr["field_1"]));
										/**/
										if (! ($lname = $user->last_name))
											if ($_pmr["ws_plugin__s2member_custom_reg_field_last_name"])
												$lname = $_pmr["ws_plugin__s2member_custom_reg_field_last_name"];
										/**/
										if (!$lname) /* Also try BuddyPress. */
											if ($_pmr["field_1"] && preg_match ("/^(.+?) (.+)$/", $_pmr["field_1"]))
												$lname = trim (preg_replace ("/^(.+?) (.+)$/", "$2", $_pmr["field_1"]));
										/**/
										$name = trim ($fname . " " . $lname); /* Both names. */
										/**/
										if (! ($pass = $password)) /* Try s2Member's generator. */
											if ($GLOBALS["ws_plugin__s2member_generate_password_return"])
												$pass = $GLOBALS["ws_plugin__s2member_generate_password_return"];
										/**/
										if (!$pass) /* Also try BuddyPress Password. */
											if ($_pmr["signup_password"]) /* BuddyPress. */
												$pass = $_pmr["signup_password"];
										/**/
										if ($pass) /* No Password nag. Update this globally. */
											{
												delete_user_setting ("default_password_nag"); /* setcookie() */
												update_user_option ($user_id, "default_password_nag", false, true);
											}
										/**/
										update_user_option ($user_id, "s2member_auto_eot_time", $auto_eot_time);
										update_user_option ($user_id, "s2member_subscr_gateway", $subscr_gateway);
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
										if (is_multisite ()) /* Should we handle Main Site permissions and Originating Blog ID#? */
											{
												if (!is_main_site () && strtotime ($user->user_registered) >= strtotime ("-10 seconds"))
													remove_user_from_blog ($user_id, $current_site->blog_id); /* No Main Site Role. */
												/**/
												if (!get_user_meta ($user_id, "s2member_originating_blog", true)) /* Recorded yet? */
													update_user_meta ($user_id, "s2member_originating_blog", $current_blog->blog_id);
											}
										/**/
										if ($current_role !== $role) /* Only if NOT the current Role. */
											$user->set_role ($role); /* s2Member. */
										/**/
										if (!preg_match ("/^\+/", $ccaps))
											foreach ($user->allcaps as $cap => $cap_enabled)
												if (preg_match ("/^access_s2member_ccap_/", $cap))
													$user->remove_cap ($ccap = $cap);
										/**/
										if ($ccaps) /* Add Custom Capabilities. */
											foreach (preg_split ("/[\r\n\t\s;,]+/", ltrim ($ccaps, "+")) as $ccap)
												if (strlen ($ccap)) /* Don't add empty Custom Capabilities. */
													$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
										/**/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"])
											foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
												{
													$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
													$field_id_class = preg_replace ("/_/", "-", $field_var);
													/**/
													if (isset ($_pmr["ws_plugin__s2member_custom_reg_field_" . $field_var]))
														$fields[$field_var] = $_pmr["ws_plugin__s2member_custom_reg_field_" . $field_var];
												}
										/**/
										update_user_option ($user_id, "s2member_custom_fields", $fields);
										/**/
										if ($level > 0) /* We ONLY process this if they are higher than Level#0. */
											{
												$pr_times = get_user_option ("s2member_paid_registration_times", $user_id);
												$pr_times["level"] = (!$pr_times["level"]) ? time () : $pr_times["level"]; /* Preserve. */
												$pr_times["level" . $level] = (!$pr_times["level" . $level]) ? time () : $pr_times["level" . $level];
												update_user_option ($user_id, "s2member_paid_registration_times", $pr_times); /* Update now. */
											}
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_configure_user_registration_front_side_free", get_defined_vars ());
										do_action ("ws_plugin__s2member_during_configure_user_registration_front_side", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								/**/
								else if (c_ws_plugin__s2member_utils_conds::is_blog_admin () && $pagenow === "user-new.php")
									{ /*
										This routine can ONLY be processed through `user-new.php` in the Administrative panel.
										*/
										$processed = "yes"; /* Mark this as yes, to indicate that a routine was processed. */
										/**/
										$current_role = c_ws_plugin__s2member_user_access::user_access_role ($user);
										$role = ($level = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_level"]) ? "s2member_level" . $level : $role;
										$role = (!$role && $current_role) ? $current_role : $role; /* Use existing Role? */
										$role = (!$role) ? get_option ("default_role") : $role; /* Otherwise default. */
										/**/
										$level = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_level"];
										$level = (!$level && preg_match ("/^(administrator|editor|author|contributor)$/i", $role)) ? "4" : $level;
										$level = (!$level && preg_match ("/^s2member_level[1-4]$/i", $role)) ? preg_replace ("/^s2member_level/", "", $role) : $level;
										$level = (!$level && preg_match ("/^subscriber$/i", $role)) ? "0" : $level;
										$level = (!$level) ? "0" : $level;
										/**/
										$ccaps = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_ccaps"];
										/**/
										$email = $user->user_email;
										$login = $user->user_login;
										$ip = ""; /* N/Applicable. */
										$custom = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_custom"];
										$subscr_id = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_subscr_id"];
										$subscr_gateway = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_subscr_gateway"];
										$cv = preg_split ("/\|/", $_pmr["ws_plugin__s2member_custom_reg_field_s2member_custom"]);
										/**/
										$auto_eot_time = ($eot = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_auto_eot_time"]) ? strtotime ($eot) : "";
										$notes = $_pmr["ws_plugin__s2member_custom_reg_field_s2member_notes"];
										/**/
										$opt_in = ($_pmr["ws_plugin__s2member_custom_reg_field_opt_in"]) ? true : false;
										/**/
										if (! ($fname = $user->first_name)) /* `Users -> Add New`. */
											if ($_pmr["ws_plugin__s2member_custom_reg_field_first_name"])
												$fname = $_pmr["ws_plugin__s2member_custom_reg_field_first_name"];
										/**/
										if (! ($lname = $user->last_name)) /* `Users -> Add New`. */
											if ($_pmr["ws_plugin__s2member_custom_reg_field_last_name"])
												$lname = $_pmr["ws_plugin__s2member_custom_reg_field_last_name"];
										/**/
										$name = trim ($fname . " " . $lname); /* Both names. */
										/**/
										if (! ($pass = $password)) /* Try s2Member's generator. */
											if ($GLOBALS["ws_plugin__s2member_generate_password_return"])
												$pass = $GLOBALS["ws_plugin__s2member_generate_password_return"];
										/**/
										if (!$pass) /* Also try the `Users -> Add New` form. */
											if ($_pmr["pass1"]) /* Field in user-new.php. */
												$pass = $_pmr["pass1"];
										/**/
										if ($pass) /* No Password nag. Update this globally. */
											{
												delete_user_setting ("default_password_nag"); /* setcookie() */
												update_user_option ($user_id, "default_password_nag", false, true);
											}
										/**/
										update_user_option ($user_id, "s2member_auto_eot_time", $auto_eot_time);
										update_user_option ($user_id, "s2member_subscr_gateway", $subscr_gateway);
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
										if (is_multisite ()) /* Should we handle Main Site permissions and Originating Blog ID#? */
											{
												if (!is_main_site () && strtotime ($user->user_registered) >= strtotime ("-10 seconds"))
													remove_user_from_blog ($user_id, $current_site->blog_id); /* No Main Site Role. */
												/**/
												if (!get_user_meta ($user_id, "s2member_originating_blog", true)) /* Recorded yet? */
													update_user_meta ($user_id, "s2member_originating_blog", $current_blog->blog_id);
											}
										/**/
										if ($current_role !== $role) /* Only if NOT the current Role. */
											$user->set_role ($role); /* s2Member. */
										/**/
										if (!preg_match ("/^\+/", $ccaps))
											foreach ($user->allcaps as $cap => $cap_enabled)
												if (preg_match ("/^access_s2member_ccap_/", $cap))
													$user->remove_cap ($ccap = $cap);
										/**/
										if ($ccaps) /* Add Custom Capabilities. */
											foreach (preg_split ("/[\r\n\t\s;,]+/", ltrim ($ccaps, "+")) as $ccap)
												if (strlen ($ccap)) /* Don't add empty Custom Capabilities. */
													$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
										/**/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"])
											foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
												{
													$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
													$field_id_class = preg_replace ("/_/", "-", $field_var);
													/**/
													if (isset ($_pmr["ws_plugin__s2member_custom_reg_field_" . $field_var]))
														$fields[$field_var] = $_pmr["ws_plugin__s2member_custom_reg_field_" . $field_var];
												}
										/**/
										update_user_option ($user_id, "s2member_custom_fields", $fields);
										/**/
										if ($level > 0) /* We ONLY process this if they are higher than Level#0. */
											{
												$pr_times = get_user_option ("s2member_paid_registration_times", $user_id);
												$pr_times["level"] = (!$pr_times["level"]) ? time () : $pr_times["level"]; /* Preserve. */
												$pr_times["level" . $level] = (!$pr_times["level" . $level]) ? time () : $pr_times["level" . $level];
												update_user_option ($user_id, "s2member_paid_registration_times", $pr_times); /* Update now. */
											}
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_configure_user_registration_admin_side", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								/**/
								if ($processed === "yes") /* If registration was processed by one of the routines above. */
									{
										if ($urls = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["registration_notification_urls"])
											/**/
											foreach (preg_split ("/[\r\n\t]+/", $urls) as $url) /* Notify each of the urls. */
												/**/
												if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)))
													if (($url = preg_replace ("/%%role%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($role)), $url)))
														if (($url = preg_replace ("/%%level%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($level)), $url)))
															if (($url = preg_replace ("/%%ccaps%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($ccaps)), $url)))
																if (($url = preg_replace ("/%%auto_eot_time%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($auto_eot_time)), $url)))
																	if (($url = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($fname)), $url)))
																		if (($url = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($lname)), $url)))
																			if (($url = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($name)), $url)))
																				if (($url = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($email)), $url)))
																					if (($url = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($login)), $url)))
																						if (($url = preg_replace ("/%%user_pass%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($pass)), $url)))
																							if (($url = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_id)), $url)))
																								{
																									if (is_array ($fields) && !empty ($fields))
																										foreach ($fields as $var => $val) /* Custom Registration Fields. */
																											if (! ($url = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (maybe_serialize ($val))), $url)))
																												break;
																									/**/
																									if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																										c_ws_plugin__s2member_utils_urls::remote ($url);
																								}
										/**/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["registration_notification_recipients"])
											{
												$msg = $sbj = "( s2Member / API Notification Email ) - Registration";
												$msg .= "\n\n"; /* Spacing in the message body. */
												/**/
												$msg .= "role: %%role%%\n";
												$msg .= "level: %%level%%\n";
												$msg .= "ccaps: %%ccaps%%\n";
												$msg .= "auto_eot_time: %%auto_eot_time%%\n";
												$msg .= "user_first_name: %%user_first_name%%\n";
												$msg .= "user_last_name: %%user_last_name%%\n";
												$msg .= "user_full_name: %%user_full_name%%\n";
												$msg .= "user_email: %%user_email%%\n";
												$msg .= "user_login: %%user_login%%\n";
												$msg .= "user_pass: %%user_pass%%\n";
												$msg .= "user_id: %%user_id%%\n";
												/**/
												if (is_array ($fields) && !empty ($fields))
													foreach ($fields as $var => $val)
														$msg .= $var . ": %%" . $var . "%%\n";
												/**/
												$msg .= "cv0: %%cv0%%\n";
												$msg .= "cv1: %%cv1%%\n";
												$msg .= "cv2: %%cv2%%\n";
												$msg .= "cv3: %%cv3%%\n";
												$msg .= "cv4: %%cv4%%\n";
												$msg .= "cv5: %%cv5%%\n";
												$msg .= "cv6: %%cv6%%\n";
												$msg .= "cv7: %%cv7%%\n";
												$msg .= "cv8: %%cv8%%\n";
												$msg .= "cv9: %%cv9%%";
												/**/
												if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)))
													if (($msg = preg_replace ("/%%role%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($role), $msg)))
														if (($msg = preg_replace ("/%%level%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($level), $msg)))
															if (($msg = preg_replace ("/%%ccaps%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($ccaps), $msg)))
																if (($msg = preg_replace ("/%%auto_eot_time%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($auto_eot_time), $msg)))
																	if (($msg = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($fname), $msg)))
																		if (($msg = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($lname), $msg)))
																			if (($msg = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($name), $msg)))
																				if (($msg = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($email), $msg)))
																					if (($msg = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($login), $msg)))
																						if (($msg = preg_replace ("/%%user_pass%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($pass), $msg)))
																							if (($msg = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_id), $msg)))
																								{
																									if (is_array ($fields) && !empty ($fields))
																										foreach ($fields as $var => $val) /* Custom Registration Fields. */
																											if (! ($msg = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (maybe_serialize ($val)), $msg)))
																												break;
																									/**/
																									if (($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																										foreach (c_ws_plugin__s2member_utils_strings::trim_deep (preg_split ("/;+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["registration_notification_recipients"])) as $recipient)
																											($recipient) ? wp_mail ($recipient, apply_filters ("ws_plugin__s2member_registration_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_registration_notification_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") : null;
																								}
											}
										/**/
										if ($url = $GLOBALS["ws_plugin__s2member_registration_return_url"])
											/**/
											if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)))
												if (($url = preg_replace ("/%%role%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($role)), $url)))
													if (($url = preg_replace ("/%%level%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($level)), $url)))
														if (($url = preg_replace ("/%%ccaps%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($ccaps)), $url)))
															if (($url = preg_replace ("/%%auto_eot_time%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($auto_eot_time)), $url)))
																if (($url = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($fname)), $url)))
																	if (($url = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($lname)), $url)))
																		if (($url = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($name)), $url)))
																			if (($url = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($email)), $url)))
																				if (($url = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($login)), $url)))
																					if (($url = preg_replace ("/%%user_pass%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($pass)), $url)))
																						if (($url = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_id)), $url)))
																							{
																								if (is_array ($fields) && !empty ($fields))
																									foreach ($fields as $var => $val) /* Custom Registration Fields. */
																										if (! ($url = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (maybe_serialize ($val))), $url)))
																											break;
																								/**/
																								if (($url = trim ($url))) /* Preserve remaining Replacements. */
																									/* Because the parent routine may perform replacements too. */
																									$GLOBALS["ws_plugin__s2member_registration_return_url"] = $url;
																							}
										/**/
										c_ws_plugin__s2member_list_servers::process_list_servers ($role, $level, $login, $pass, $email, $fname, $lname, $ip, $opt_in, $user_id);
										/*
										Suppress errors here in case this routine is fired in unexpected locations; or with odd output buffering techniques.
											@TODO: It may also be impossible to delete cookies when fired inside: `/wp-activate.php`.
										*/
										if (!headers_sent ()) /* Only if headers are NOT yet sent. */
											{
												@setcookie ("s2member_subscr_gateway", "", time () + 31556926, "/");
												@setcookie ("s2member_subscr_id", "", time () + 31556926, "/");
												@setcookie ("s2member_custom", "", time () + 31556926, "/");
												@setcookie ("s2member_level", "", time () + 31556926, "/");
											}
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
						return; /* Return for uniformity. */
					}
			}
	}
?>