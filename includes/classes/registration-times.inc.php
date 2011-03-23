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
if (!class_exists ("c_ws_plugin__s2member_registration_times"))
	{
		class c_ws_plugin__s2member_registration_times
			{
				/*
				Synchronizes Paid Registration Times with Role assignments.
				Attach to: add_action("set_user_role");
				*/
				public static function synchronize_paid_reg_times ($user_id = FALSE, $role = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_synchronize_paid_reg_times", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($user_id && is_object ($user = new WP_User ($user_id)) && $user->ID)
							if (($level = c_ws_plugin__s2member_user_access::user_access_level ($user)) > 0)
								{
									$pr_times = get_user_option ("s2member_paid_registration_times", $user_id);
									$pr_times["level"] = (!$pr_times["level"]) ? time () : $pr_times["level"]; /* Preserve. */
									$pr_times["level" . $level] = (!$pr_times["level" . $level]) ? time () : $pr_times["level" . $level];
									update_user_option ($user_id, "s2member_paid_registration_times", $pr_times); /* Update now. */
								}
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Retrieves a Registration Time.
				$user_id defaults to the current User; if logged in.
				*/
				public static function registration_time ($user_id = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_registration_time", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$user = ($user_id) ? new WP_User ($user_id) : ( (is_user_logged_in ()) ? wp_get_current_user () : false);
						/**/
						if (is_object ($user) && ($user_id = $user->ID) && $user->user_registered)
							{
								return apply_filters ("ws_plugin__s2member_registration_time", strtotime ($user->user_registered), get_defined_vars ());
							}
						else /* Else we return a default value of 0, because there is insufficient data. */
							return apply_filters ("ws_plugin__s2member_registration_time", 0, get_defined_vars ());
					}
				/*
				Retrieves a Paid Registration Time.
				
				The $level argument is optional. It defaults to the first/initial Paid Registration Time, regardless of Level#.
				Or you could do this: s2member_paid_registration_time("level1"); which will give you the Registration Time at Level #1.
				If a User/Member has never paid for Level #1 ( i.e. they signed up at Level#2 ), the function will return 0.
				
				Here are some other examples:
				$time = c_ws_plugin__s2member_registration_times::registration_time (); // ... first registration time ( free or otherwise ).
				$time = c_ws_plugin__s2member_registration_times::paid_registration_time (); // ... first "paid" registration and/or upgrade time.
				$time = c_ws_plugin__s2member_registration_times::paid_registration_time ("level1"); // ... first "paid" registration or upgrade time at Level#1.
				$time = c_ws_plugin__s2member_registration_times::paid_registration_time ("level2"); // ... first "paid" registration or upgrade time at Level#2.
				$time = c_ws_plugin__s2member_registration_times::paid_registration_time ("level3"); // ... first "paid" registration or upgrade time at Level#3.
				$time = c_ws_plugin__s2member_registration_times::paid_registration_time ("level4"); // ... first "paid" registration or upgrade time at Level#4.
				
				The argument $user_id defaults to the current User; if logged in.
				*/
				public static function paid_registration_time ($level = FALSE, $user_id = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paid_registration_time", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$level = (!strlen ($level)) ? "level" : "level" . preg_replace ("/[^0-9]/", "", $level);
						$user = ($user_id) ? new WP_User ($user_id) : ( (is_user_logged_in ()) ? wp_get_current_user () : false);
						/**/
						if ($level && is_object ($user) && ($user_id = $user->ID) && is_array ($pr_times = get_user_option ("s2member_paid_registration_times", $user_id)))
							{
								return apply_filters ("ws_plugin__s2member_paid_registration_time", (int)$pr_times[$level], get_defined_vars ());
							}
						else /* Else we return a default value of 0, because there is insufficient data. */
							return apply_filters ("ws_plugin__s2member_paid_registration_time", 0, get_defined_vars ());
					}
			}
	}
?>