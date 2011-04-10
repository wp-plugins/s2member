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
if (!class_exists ("c_ws_plugin__s2member_tracking_cookies_in"))
	{
		class c_ws_plugin__s2member_tracking_cookies_in
			{
				/*
				Deletes s2Member's temporary tracking cookie.
				Attach to: add_action("init");
				*/
				public static function delete_signup_tracking_cookie ()
					{
						do_action ("ws_plugin__s2member_before_delete_signup_tracking_cookie", get_defined_vars ());
						/**/
						if ($_GET["s2member_delete_signup_tracking_cookie"]) /* Deletes cookie. */
							{
								setcookie ("s2member_signup_tracking", "", time () + 31556926, "/");
								/**/
								do_action ("ws_plugin__s2member_during_delete_signup_tracking_cookie", get_defined_vars ());
								/**/
								exit (); /* Clean exit. */
							}
						/**/
						do_action ("ws_plugin__s2member_after_delete_signup_tracking_cookie", get_defined_vars ());
					}
				/*
				Deletes s2Member's temporary tracking cookie.
				Attach to: add_action("init");
				*/
				public static function delete_sp_tracking_cookie ()
					{
						do_action ("ws_plugin__s2member_before_delete_sp_tracking_cookie", get_defined_vars ());
						/**/
						if ($_GET["s2member_delete_sp_tracking_cookie"]) /* Deletes cookie. */
							{
								setcookie ("s2member_sp_tracking", "", time () + 31556926, "/");
								/**/
								do_action ("ws_plugin__s2member_during_delete_sp_tracking_cookie", get_defined_vars ());
								/**/
								exit (); /* Clean exit. */
							}
						/**/
						do_action ("ws_plugin__s2member_after_delete_sp_tracking_cookie", get_defined_vars ());
					}
			}
	}
?>