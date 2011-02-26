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
if (!class_exists ("c_ws_plugin__s2member_sc_if_conds"))
	{
		class c_ws_plugin__s2member_sc_if_conds
			{
				/*
				Function that handles the Shortcode for [s2If ... simple conditionals][/s2If].
				- These Shortcodes are also safe to use on a Multisite Blog Farm.
				
				Attach to: add_shortcode("s2If") + _s2If, __s2If, ___s2If for nesting.
				
				Is Multisite Networking enabled? Please keep the following in mind.
				* current_user_can(), will ALWAYS return true for a Super Admin!
					( this can be confusing when testing conditionals )
				
				If you're running a Multisite Blog Farm, you can filter this array:
					ws_plugin__s2member_sc_if_conditionals_blog_farm_safe
					$blog_farm_safe
				*/
				public static function sc_if_conditionals ($attr = FALSE, $content = FALSE, $shortcode = FALSE)
					{
						return c_ws_plugin__s2member_sc_if_conds_in::sc_if_conditionals ($attr, $content, $shortcode);
					}
			}
	}
?>