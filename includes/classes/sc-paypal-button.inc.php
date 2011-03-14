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
if (!class_exists ("c_ws_plugin__s2member_sc_paypal_button"))
	{
		class c_ws_plugin__s2member_sc_paypal_button
			{
				/*
				Function handles the Shortcode for [s2Member-PayPal-Button /].
				Attach to: add_shortcode("s2Member-PayPal-Button");
				*/
				public static function sc_paypal_button ($attr = FALSE, $content = FALSE, $shortcode = FALSE)
					{
						return c_ws_plugin__s2member_sc_paypal_button_in::sc_paypal_button ($attr, $content, $shortcode);
					}
			}
	}
?>