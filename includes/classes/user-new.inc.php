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
if (!class_exists ("c_ws_plugin__s2member_user_new"))
	{
		class c_ws_plugin__s2member_user_new
			{
				/*
				Function that adds custom fields to `/wp-admin/user-new.php`.
				We have to buffer output because `/user-new.php` has NO Hooks.
				Attach to: add_action("load-user-new.php");
				*/
				public static function admin_user_new_fields ()
					{
						global $pagenow; /* The current admin page file name. */
						/**/
						do_action ("ws_plugin__s2member_before_admin_user_new_fields", get_defined_vars ());
						/**/
						if (c_ws_plugin__s2member_utils_conds::is_blog_admin () && $pagenow === "user-new.php" && current_user_can ("create_users"))
							{
								ob_start ("c_ws_plugin__s2member_user_new_in::_admin_user_new_fields"); /* No Hooks, so we buffer. */
								/**/
								do_action ("ws_plugin__s2member_during_admin_user_new_fields", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_after_admin_user_new_fields", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>