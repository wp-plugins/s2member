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
if (!class_exists ("c_ws_plugin__s2member_meta_boxes"))
	{
		class c_ws_plugin__s2member_meta_boxes
			{
				/*
				Function adds meta boxes to Post/Page editing stations.
				Attach to: add_action("admin_menu");
				*/
				public static function add_meta_boxes ()
					{
						do_action ("ws_plugin__s2member_before_add_meta_boxes", get_defined_vars ());
						/**/
						foreach (get_post_types () as $type) /* Handles Custom Post Types as well. */
							if (!in_array ($type, array ("revision", "attachment", "nav_menu_item"))) /* But NOT on these Post Types. */
								add_meta_box ("ws-plugin--s2member-security", "s2Member", "c_ws_plugin__s2member_meta_box_security::security_meta_box", $type, "side", "high");
						/**/
						do_action ("ws_plugin__s2member_after_add_meta_boxes", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>