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
if (!class_exists ("c_ws_plugin__s2member_tracking_cookies"))
	{
		class c_ws_plugin__s2member_tracking_cookies
			{
				/*
				Deletes s2Member's temporary tracking cookie.
				Attach to: add_action("init");
				*/
				public static function delete_signup_tracking_cookie ()
					{
						if ($_GET["s2member_delete_signup_tracking_cookie"]) /* Call inner function? */
							{
								return c_ws_plugin__s2member_tracking_cookies_in::delete_signup_tracking_cookie ();
							}
					}
				/*
				Deletes s2Member's temporary tracking cookie.
				Attach to: add_action("init");
				*/
				public static function delete_sp_tracking_cookie ()
					{
						if ($_GET["s2member_delete_sp_tracking_cookie"]) /* Call inner function? */
							{
								return c_ws_plugin__s2member_tracking_cookies_in::delete_sp_tracking_cookie ();
							}
					}
			}
	}
?>