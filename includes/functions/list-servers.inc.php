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
Function that process list server integrations for s2Member.
*/
function ws_plugin__s2member_process_list_servers ($level = FALSE, $email = FALSE, $fname = FALSE, $lname = FALSE, $ip = FALSE, $opt_in = FALSE)
	{
		if (strlen ($level) && is_email ($email) && $opt_in) /* Must have a level, a valid email, and opt-in permission. */
			{
				if (($mailchimp_api_key = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mailchimp_api_key"]))
					if (($mailchimp_list_ids = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_mailchimp_list_ids"]))
						{
							if (!class_exists ("NC_MCAPI"))
								include_once dirname (dirname (__FILE__)) . "/mailchimp/nc-mcapi.inc.php";
							/**/
							$MCAPI = new NC_MCAPI ($mailchimp_api_key); /* MailChimp® API class. */
							/**/
							foreach (preg_split ("/[\r\n\t\s;,]+/", $mailchimp_list_ids) as $mailchimp_list_id)
								$MCAPI->listSubscribe ($mailchimp_list_id, $email, array ("FNAME" => $fname, "LNAME" => $lname, "OPTINIP" => $ip));
						}
				/**/
				if ($aweber_list_ids = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_aweber_list_ids"])
					{
						foreach (preg_split ("/[\r\n\t\s;,]+/", $aweber_list_ids) as $aweber_list_id)
							@mail ($aweber_list_id . "@aweber.com", "s2Member Subscription Request",/**/
							"s2Member Subscription Request\ns2Member w/ PayPal Email ID\nBuyer: " . $fname . " " . $lname . "\n - end.",/**/
							"From: \"" . preg_replace ("/\"/", "", $fname . " " . $lname) . "\" <" . $email . ">\r\nContent-Type: text/plain; charset=utf-8");
					}
			}
		/**/
		return;
	}
/*
Function that determines whether or not any list
servers have been integrated into the s2Member options.
*/
function ws_plugin__s2member_list_servers_integrated ()
	{
		for ($i = 0; $i <= 4; $i++)
			if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_mailchimp_list_ids"]/**/
			|| $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_aweber_list_ids"])
				return true;
		/**/
		return false;
	}
?>