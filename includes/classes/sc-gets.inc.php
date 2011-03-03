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
if (!class_exists ("c_ws_plugin__s2member_sc_gets"))
	{
		class c_ws_plugin__s2member_sc_gets
			{
				/*
				Function that handles the Shortcode for:
				[s2Get constant="S2MEMBER_CURRENT_USER_DISPLAY_NAME" /]
				[s2Get user_field="a_custom_registration_field_id" /]
				[s2Get user_option="s2member_subscr_id" /]
				
				Attach to: add_shortcode("s2Get");
				*/
				public static function sc_get_details ($attr = FALSE, $content = FALSE, $shortcode = FALSE)
					{
						return c_ws_plugin__s2member_sc_gets_in::sc_get_details ($attr, $content, $shortcode);
					}
			}
	}
?>