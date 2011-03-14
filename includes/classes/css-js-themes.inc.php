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
if (!class_exists ("c_ws_plugin__s2member_css_js_themes"))
	{
		class c_ws_plugin__s2member_css_js_themes
			{
				/*
				Adds CSS files.
				Attach to: add_action("wp_print_styles");
				*/
				public static function add_css ()
					{
						do_action ("ws_plugin__s2member_before_add_css", get_defined_vars ());
						/**/
						if (!is_admin ()) /* Not in the admin. */
							{
								wp_enqueue_style ("ws-plugin--s2member", site_url ("/?ws_plugin__s2member_css=1&qcABC=1"), array (), c_ws_plugin__s2member_utilities::ver_checksum (), "all");
								/**/
								do_action ("ws_plugin__s2member_during_add_css", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_after_add_css", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Adds JavaScript files.
				Attach to: add_action("wp_print_scripts");
				*/
				public static function add_js_w_globals ()
					{
						global $pagenow; /* Need this for comparisons. */
						/**/
						do_action ("ws_plugin__s2member_before_add_js_w_globals", get_defined_vars ());
						/**/
						if (!is_admin () || (c_ws_plugin__s2member_utils_conds::is_user_admin () && $pagenow === "profile.php" && !current_user_can ("edit_users")))
							{
								if (is_user_logged_in ()) /* Separate version for logged-in Users/Members. */
									{
										$md5 = WS_PLUGIN__S2MEMBER_API_CONSTANTS_MD5; /* An MD5 hash based on global key => values. */
										/* The MD5 hash allows the script to be cached in the browser until the globals happen to change. */
										/* For instance, the global variables may change when a User who is logged-in changes their Profile. */
										wp_enqueue_script ("ws-plugin--s2member", site_url ("/?ws_plugin__s2member_js_w_globals=" . urlencode ($md5) . "&qcABC=1"), array ("jquery"), c_ws_plugin__s2member_utilities::ver_checksum ());
									}
								else /* Else if they are not logged in, we distinguish the JavaScript file by NOT including $md5. */
									{ /* This essentially creates 2 versions of the script. One while logged in & another when not. */
										wp_enqueue_script ("ws-plugin--s2member", site_url ("/?ws_plugin__s2member_js_w_globals=1&qcABC=1"), array ("jquery"), c_ws_plugin__s2member_utilities::ver_checksum ());
									}
								/**/
								do_action ("ws_plugin__s2member_during_add_js_w_globals", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_after_add_js_w_globals", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>