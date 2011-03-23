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
if (!class_exists ("c_ws_plugin__s2member_brute_force"))
	{
		class c_ws_plugin__s2member_brute_force
			{
				/*
				This prevents an attacker from guessing Usernames/Passwords.
				Allows only 5 failed login attempts every 30 minutes.
				Attach to: add_action("wp_login_failed");
				*/
				public static function track_failed_logins ($username = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_track_failed_logins", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (($max = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_failed_login_attempts"]))
							{
								$exp_secs = strtotime ("+" . apply_filters ("ws_plugin__s2member_track_failed_logins__exp_time", "30 minutes", get_defined_vars ())) - time ();
								/* If you add Filters to this value, you should use a string that is compatible with PHP's strtotime() function. */
								/**/
								$transient = "s2m_ipr_" . md5 ("s2member_transient_failed_login_attempts_" . $_SERVER["REMOTE_ADDR"]);
								set_transient ($transient, (int)get_transient ($transient) + 1, $exp_secs);
							}
						/**/
						do_action ("ws_plugin__s2member_after_track_failed_logins", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				This prevents an attacker from guessing Usernames/Passwords.
				Allows only 5 failed login attempts every 30 minutes.
				Attach to: add_filter("authenticate");
				*/
				public static function stop_brute_force_logins ($user = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_stop_brute_force_logins", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (($max = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_failed_login_attempts"]))
							{
								$exp_secs = strtotime ("+" . apply_filters ("ws_plugin__s2member_track_failed_logins__exp_time", "30 minutes", get_defined_vars ())) - time ();
								/* If you add Filters to this value, you should use a string that is compatible with PHP's strtotime() function. */
								/**/
								$about = c_ws_plugin__s2member_utils_time::approx_time_difference (time (), time () + $exp_secs);
								/**/
								if ((int)get_transient ("s2m_ipr_" . md5 ("s2member_transient_failed_login_attempts_" . $_SERVER["REMOTE_ADDR"])) > $max)
									{
										$errors = new WP_Error ("incorrect_password", "Max failed logins. Please wait " . $about . " and try again.");
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_stop_brute_force_logins", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
							}
						/**/
						return apply_filters ("ws_plugin__s2member_stop_brute_force_logins", (($errors) ? $errors : $user), get_defined_vars ());
					}
			}
	}
?>