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
		do_action ("s2member_before_handle_user_deletions");
		/**/
		$user = new WP_User ($user_id); /* Acquire user obj. */
		/**/
		$custom = get_usermeta ($user_id, "s2member_custom");
		$subscr_id = get_usermeta ($user_id, "s2member_subscr_id");
		/**/
		if (is_object ($user) && $subscr_id && $custom && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"] && is_array ($cv = preg_split ("/\|/", $custom)))
			{
				foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"]) as $url) /* Handle eot notifications on user deletion. */
					if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", urlencode ($subscr_id), $url)))
						if (($url = preg_replace ("/%%user_first_name%%/i", urlencode ($user->first_name), $url)) && ($url = preg_replace ("/%%user_last_name%%/i", urlencode ($user->last_name), $url)))
							if (($url = preg_replace ("/%%user_full_name%%/i", urlencode (trim ($user->first_name . " " . $user->last_name)), $url)))
								if (($url = preg_replace ("/%%user_email%%/i", urlencode ($user->user_email), $url)))
									/**/
									if (($url = trim ($url))) /* Make sure it is not empty. */
										ws_plugin__s2member_curlpsr ($url, "s2member=1");
				/**/
				do_action ("s2member_during_handle_user_deletions");
			}
		/**/
		do_action ("s2member_after_handle_user_deletions");
		/**/
		return;
	}
?>