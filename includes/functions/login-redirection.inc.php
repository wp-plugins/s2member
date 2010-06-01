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
				$user = new WP_User ($username); /* Get user object reference. */
				/**/
				if (!$user->has_cap ("edit_posts")) /* Subscribers & Members. */
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_login_redirect", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
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
						exit;
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
				$current_user_login = (is_object ($current_user)) ? strtolower ($current_user->user_login) : "";
				$current_user_ID = (is_object ($current_user)) ? (string)$current_user->ID : "";
				/**/
				$url = preg_replace ("/%%current_user_login%%/i", $current_user_login, $url);
				$url = preg_replace ("/%%current_user_ID%%/i", $current_user_ID, $url);
				/**/
				return apply_filters ("ws_plugin__s2member_fill_login_redirect_rc_vars", $url, get_defined_vars ());
			}
	}
?>