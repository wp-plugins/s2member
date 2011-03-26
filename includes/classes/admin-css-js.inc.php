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
if (!class_exists ("c_ws_plugin__s2member_admin_css_js"))
	{
		class c_ws_plugin__s2member_admin_css_js
			{
				/*
				Function that outputs the CSS for menu pages.
				Attach to: add_action("init");
				*/
				public static function menu_pages_css ()
					{
						if ($_GET["ws_plugin__s2member_menu_pages_css"]) /* Call inner function? */
							{
								return c_ws_plugin__s2member_admin_css_js_in::menu_pages_css ();
							}
					}
				/*
				Function that outputs the JS for menu pages.
				Attach to: add_action("init");
				*/
				public static function menu_pages_js ()
					{
						if ($_GET["ws_plugin__s2member_menu_pages_js"]) /* Call inner function? */
							{
								return c_ws_plugin__s2member_admin_css_js_in::menu_pages_js ();
							}
					}
			}
	}
?>