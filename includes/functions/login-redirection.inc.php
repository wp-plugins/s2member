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
Function for handling login redirections.
Attach to: add_action("wp_login");
*/
if (!function_exists ("ws_plugin__s2member_login_redirect"))
	{
		function ws_plugin__s2member_login_redirect ($username = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_login_redirect", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$username = (!$username && is_object ($current_user = wp_get_current_user ())) ? $current_user->user_login : $username;
				/* This additional check was added in case wp_signon() fires this event with empty $_POST credentials.
					In this rare case, we can check to see if WordPress® is remembering a previously logged in User. */
				/**/
				if (!is_object ($user = new WP_User ($username)) || !($user_id = $user->ID) || !$user->has_cap ("edit_posts"))
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_login_redirect", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"])
							if (function_exists ("ws_plugin__s2member_generate_password"))
								{
									delete_user_setting ("default_password_nag"); /* setcookie() */
									update_user_option ($user_id, "default_password_nag", false, true);
								}
						/**/
						if (ws_plugin__s2member_ip_restrictions_ok ($_SERVER["REMOTE_ADDR"], strtolower ($username)))
							{
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"])
									wp_redirect (ws_plugin__s2member_fill_login_redirect_rc_vars /* Special. */
									($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"], $user));
								/**/
								else /* Otherwise, use the Login Welcome Page for s2Member. */
									wp_redirect (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]));
							}
						/**/
						exit ();
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_login_redirect", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return;
			}
	}
/*
Function that fills replacement code variables in special redirection URLs.
*/
if (!function_exists ("ws_plugin__s2member_fill_login_redirect_rc_vars"))
	{
		function ws_plugin__s2member_fill_login_redirect_rc_vars ($url = FALSE, $current_user = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_fill_login_redirect_rc_vars", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$current_user = (is_object ($current_user)) ? $current_user : wp_get_current_user ();
				$current_user_login = (is_object ($current_user)) ? strtolower ($current_user->user_login) : "";
				$current_user_ID = (is_object ($current_user)) ? (string)$current_user->ID : "";
				$current_user_level = (string)ws_plugin__s2member_user_access_level ($current_user);
				/**/
				$url = preg_replace ("/%%current_user_login%%/i", ws_plugin__s2member_esc_ds ($current_user_login), $url);
				$url = preg_replace ("/%%current_user_ID%%/i", ws_plugin__s2member_esc_ds ($current_user_ID), $url);
				$url = preg_replace ("/%%current_user_level%%/i", ws_plugin__s2member_esc_ds ($current_user_level), $url);
				/**/
				return apply_filters ("ws_plugin__s2member_fill_login_redirect_rc_vars", $url, get_defined_vars ());
			}
	}
?>