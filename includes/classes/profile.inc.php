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
if (!class_exists ("c_ws_plugin__s2member_profile"))
	{
		class c_ws_plugin__s2member_profile
			{
				/*
				Function that displays a Profile Modification Form.
				Attach to: add_action("template_redirect");
				*/
				public static function profile ()
					{
						do_action ("ws_plugin__s2member_before_profile", get_defined_vars ());
						/**/
						if ($_GET["s2member_profile"] && is_user_logged_in ()) /* Logged in? */
							{
								include_once dirname (dirname (__FILE__)) . "/profile.inc.php";
								/* Additional Hooks/Filters inside profile.inc.php. */
								exit (); /* Clean exit. */
							}
						/**/
						do_action ("ws_plugin__s2member_after_profile", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>