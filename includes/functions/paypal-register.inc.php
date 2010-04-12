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
	exit;
/*
Handles paypal registration links.
Attach to: add_action("init");
*/
function ws_plugin__s2member_paypal_register ()
	{
		if ($_GET["s2member_paypal_register"])
			{
				if (is_array ($registered = preg_split ("/\:\.\:\|\:\.\:/", ws_plugin__s2member_xdecrypt ($_GET["s2member_paypal_register"]))))
					{
						if (count ($registered) === 4 && $registered[0] === "subscr_id_custom_item_number" && $registered[1] && $registered[2] && $registered[3])
							{
								setcookie ("s2member_subscr_id", $registered[1], time () + 31556926, "/");
								setcookie ("s2member_custom", $registered[2], time () + 31556926, "/");
								setcookie ("s2member_level", $registered[3], time () + 31556926, "/");
								/**/
								echo '<script type="text/javascript">' . "\n";
								echo "window.location = '" . esc_js (add_query_arg ("action", "register", wp_login_url ())) . "';";
								echo '</script>' . "\n";
							}
					}
				exit;
			}
	}
?>