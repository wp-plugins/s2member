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
Function for handling user deletions.
Attach to: add_action("delete_user");
*/
function ws_plugin__s2member_handle_user_deletions ($user_id = FALSE)
	{
		$userdata = get_userdata ($user_id);
		$paypal["custom"] = get_usermeta ($user_id, "s2member_custom");
		$paypal["subscr_id"] = get_usermeta ($user_id, "s2member_subscr_id");
		/**/
		if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"] && is_object ($userdata) && $paypal["subscr_id"] && $paypal["custom"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
			{
				foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"]) as $url) /* Handle eot notifications on user deletion. */
					if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", urlencode ($paypal["subscr_id"]), $url)))
						if (($url = preg_replace ("/%%user_first_name%%/i", urlencode ($userdata->first_name), $url)) && ($url = preg_replace ("/%%user_last_name%%/i", urlencode ($userdata->last_name), $url)))
							if (($url = preg_replace ("/%%user_full_name%%/i", urlencode (trim ($userdata->first_name . " " . $userdata->last_name)), $url)))
								if (($url = preg_replace ("/%%user_email%%/i", urlencode ($userdata->user_email), $url)))
									if (($url = trim ($url))) /* Make sure it is not empty now. */
										ws_plugin__s2member_curlpsr ($url, "s2member=1");
			}
		/**/
		return;
	}
?>