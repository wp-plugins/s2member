<?php
/**
* Tracking Cookies ( inner processing routines ).
*
* Copyright: © 2009-2011
* {@link http://www.websharks-inc.com/ WebSharks, Inc.}
* ( coded in the USA )
*
* Released under the terms of the GNU General Public License.
* You should have received a copy of the GNU General Public License,
* along with this software. In the main directory, see: /licensing/
* If not, see: {@link http://www.gnu.org/licenses/}.
*
* @package s2Member\Tracking
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_tracking_cookies_in"))
	{
		/**
		* Tracking Cookies ( inner processing routines ).
		*
		* @package s2Member\Tracking
		* @since 3.5
		*/
		class c_ws_plugin__s2member_tracking_cookies_in
			{
				/**
				* Deletes s2Member's temporary tracking cookie.
				*
				* @package s2Member\Tracking
				* @since 3.5
				*
				* @attaches-to: ``add_action("init");``
				*
				* @return null Or exits script execution after deleting Cookie.
				*/
				public static function delete_signup_tracking_cookie ()
					{
						do_action ("ws_plugin__s2member_before_delete_signup_tracking_cookie", get_defined_vars ());
						/**/
						if (!empty ($_GET["s2member_delete_signup_tracking_cookie"])) /* Deletes cookie. */
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
				/**
				* Deletes s2Member's temporary tracking cookie.
				*
				* @package s2Member\Tracking
				* @since 3.5
				*
				* @attaches-to: ``add_action("init");``
				*
				* @return null Or exits script execution after deleting Cookie.
				*/
				public static function delete_sp_tracking_cookie ()
					{
						do_action ("ws_plugin__s2member_before_delete_sp_tracking_cookie", get_defined_vars ());
						/**/
						if (!empty ($_GET["s2member_delete_sp_tracking_cookie"])) /* Deletes cookie. */
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