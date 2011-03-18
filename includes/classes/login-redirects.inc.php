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
if (!class_exists ("c_ws_plugin__s2member_login_redirects"))
	{
		class c_ws_plugin__s2member_login_redirects
			{
				/*
				Handles login redirections.
				Attach to: add_action("wp_login");
				*/
				public static function login_redirect ($username = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_login_redirect", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$username = (!$username && is_object ($user = wp_get_current_user ())) ? $user->user_login : $username;
						/**/
						if ($username && (is_object ($user) || is_object ($user = new WP_User ($username))) && ($user_id = $user->ID) && (!$user->has_cap ("edit_posts") || apply_filters ("ws_plugin__s2member_login_redirect", false, get_defined_vars ())))
							{
								if ($user->has_cap ("edit_posts") || strtolower ($username) === "demo" || c_ws_plugin__s2member_ip_restrictions::ip_restrictions_ok ($_SERVER["REMOTE_ADDR"], strtolower ($username)))
									{
										if (!$_REQUEST["redirect_to"] || $_REQUEST["redirect_to"] === "wp-admin/" || $_REQUEST["redirect_to"] === admin_url ()) /* ?redirect_to=[value]. */
											{
												if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"]) /* Using custom Passwords? */
													{
														delete_user_setting ("default_password_nag"); /* `setcookie()` */
														update_user_option ($user_id, "default_password_nag", false, true);
													}
												/**/
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_login_redirect", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
												/**/
												if ($special_redirection_url = c_ws_plugin__s2member_login_redirects::login_redirection_url ($user))
													wp_redirect($special_redirection_url); /* Special Redirection. */
												/**/
												else /* Else we use the Login Welcome Page configured for s2Member. */
													wp_redirect (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]));
												/**/
												exit (); /* Clean exit. */
											}
									}
							}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_after_login_redirect", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						return; /* Return for uniformity. */
					}
				/*
				This function formulates a possible ( Special ) Login Redirection URL.
				*/
				public static function login_redirection_url ($user = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_login_redirection_url", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$url = c_ws_plugin__s2member_login_redirects::fill_login_redirect_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"], $user);
						/**/
						return apply_filters ("ws_plugin__s2member_login_redirection_url", $url, get_defined_vars ());
					}
				/*
				Parses the URI out of a possible ( Special ) Login Redirection URL.
				*/
				public static function login_redirection_uri ($user = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_login_redirection_uri", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (! ($uri = false) && $url = c_ws_plugin__s2member_login_redirects::login_redirection_url ($user))
							{
								$path = parse_url ($url, PHP_URL_PATH);
								$query = parse_url ($url, PHP_URL_QUERY);
								$uri = ($query) ? $path . "?" . $query : $path;
							}
						/**/
						return apply_filters ("ws_plugin__s2member_login_redirection_uri", $uri, get_defined_vars ());
					}
				/*
				Fills Replacement Code variables in Special Redirection URLs.
				*/
				public static function fill_login_redirect_rc_vars ($url = FALSE, $user = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_fill_login_redirect_rc_vars", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$user = (is_object ($user) && $user->ID) ? $user : wp_get_current_user ();
						$user_login = (is_object ($user) && $user->ID) ? strtolower ($user->user_login) : "";
						$user_id = (is_object ($user) && $user->ID) ? (string)$user->ID : "";
						$user_level = (string)c_ws_plugin__s2member_user_access::user_access_level ($user);
						$user_role = (string)c_ws_plugin__s2member_user_access::user_access_role ($user);
						$user_ccaps = implode ("-", c_ws_plugin__s2member_user_access::user_access_ccaps ($user));
						/**/
						$url = preg_replace ("/%%current_user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_login), $url);
						$url = preg_replace ("/%%current_user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_id), $url);
						$url = preg_replace ("/%%current_user_level%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_level), $url);
						$url = preg_replace ("/%%current_user_role%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_role), $url);
						$url = preg_replace ("/%%current_user_ccaps%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_ccaps), $url);
						/**/
						return apply_filters ("ws_plugin__s2member_fill_login_redirect_rc_vars", $url, get_defined_vars ());
					}
			}
	}
?>