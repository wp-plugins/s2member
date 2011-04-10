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
if (!class_exists ("c_ws_plugin__s2member_login_redirects_r"))
	{
		class c_ws_plugin__s2member_login_redirects_r
			{
				/*
				Removes login_redirect Filters to prevent conflicts with s2Member.
				Attach to: add_action("init");
				*/
				public static function remove_login_redirect_filters () /* For compatibility. */
					{
						do_action ("ws_plugin__s2member_before_remove_login_redirect_filters", get_defined_vars ());
						/**/
						if (!apply_filters ("ws_plugin__s2member_allow_other_login_redirect_filters", false, get_defined_vars ()))
							remove_all_filters ("login_redirect"); /* Removes ALL `login_redirect` Filters. */
						/**/
						do_action ("ws_plugin__s2member_after_remove_login_redirect_filters", get_defined_vars ());
					}
			}
	}
?>