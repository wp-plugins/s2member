<?php
/**
* Login redirect removals.
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
* @package s2Member\Login_Redirects
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_login_redirects_r"))
	{
		/**
		* Login redirect removals.
		*
		* @package s2Member\Login_Redirects
		* @since 3.5
		*/
		class c_ws_plugin__s2member_login_redirects_r
			{
				/**
				* Removes ``login_redirect`` Filters to prevent conflicts with s2Member.
				*
				* @attaches-to: ``add_action("init");``
				*
				* @package s2Member\Login_Redirects
				* @since 3.5
				*
				* @return null
				*/
				public static function remove_login_redirect_filters () /* For compatibility. */
					{
						do_action ("ws_plugin__s2member_before_remove_login_redirect_filters", get_defined_vars ());
						/**/
						if (!apply_filters ("ws_plugin__s2member_allow_other_login_redirect_filters", false, get_defined_vars ()))
							remove_all_filters("login_redirect"); /* Removes all `login_redirect` Filters. */
						/**/
						do_action ("ws_plugin__s2member_after_remove_login_redirect_filters", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>