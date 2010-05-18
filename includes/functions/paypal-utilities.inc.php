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
Get POST vars from PayPal®, verify and return array.
*/
function ws_plugin__s2member_paypal_postvars ()
	{
		do_action ("s2member_before_paypal_postvars");
		/**/
		if ($_GET["tx"]) /* PDT with Auto-Return. */
			{
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_identity_token"])
					{
						$postback = "cmd=_notify-synch";
						/**/
						$postback .= "&tx=" . urlencode ($_GET["tx"]);
						$postback .= "&at=" . urlencode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_identity_token"]);
						/**/
						$endpoint = ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com";
						/**/
						if (preg_match ("/^SUCCESS/i", ($response = trim (ws_plugin__s2member_curlpsr ("https://" . $endpoint . "/cgi-bin/webscr", $postback)))))
							{
								foreach (preg_split ("/[\r\n]+/", preg_replace ("/^SUCCESS/i", "", $response)) as $varline)
									{
										list ($key, $value) = preg_split ("/\=/", $varline, 2);
										if (strlen ($key = trim ($key)) && strlen ($value = trim ($value)))
											$postvars[$key] = trim (stripslashes (urldecode ($value)));
									}
								/**/
								return apply_filters ("s2member_paypal_postvars", $postvars);
							}
					}
				/**/
				return false;
			}
		else if (is_array ($postvars = stripslashes_deep ($_POST)))
			{
				$postback = "cmd=_notify-validate";
				/**/
				foreach ($postvars as $key => $value)
					$postback .= "&" . $key . "=" . urlencode ($value);
				/**/
				foreach ($postvars as $key => $value)
					$postvars[$key] = trim ($value);
				/**/
				$endpoint = ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com";
				/**/
				if (strtolower (trim (ws_plugin__s2member_curlpsr ("https://" . $endpoint . "/cgi-bin/webscr", $postback))) === "verified")
					{
						return apply_filters ("s2member_paypal_postvars", $postvars);
					}
				/**/
				return false;
			}
		else /* Unable to obtain. */
			{
				return false;
			}
	}
/*
Get the custom value for an existing Member, referenced by a Subscr. ID.
*/
function ws_plugin__s2member_paypal_custom ($subscr_id = FALSE, $os0 = FALSE)
	{
		global $wpdb; /* Need global DB obj. */
		/**/
		do_action ("s2member_before_paypal_custom");
		/**/
		if ($subscr_id && $os0) /* This case includes some additional routines that can use the $os0 value. */
			{
				if (($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND (`meta_value` = '" . $wpdb->escape ($subscr_id) . "' OR `meta_value` = '" . $wpdb->escape ($os0) . "') LIMIT 1"))/**/
				|| ($q = $wpdb->get_row ("SELECT `ID` AS `user_id` FROM `" . $wpdb->users . "` WHERE `ID` = '" . $wpdb->escape ($os0) . "' LIMIT 1")))
					if (($custom = get_usermeta ($q->user_id, "s2member_custom")))
						return apply_filters ("s2member_paypal_custom", $custom);
			}
		else if ($subscr_id) /* Otherwise, if all we have is a Subscr. ID value. */
			{
				if ($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1"))
					if (($custom = get_usermeta ($q->user_id, "s2member_custom")))
						return apply_filters ("s2member_paypal_custom", $custom);
			}
		/**/
		return apply_filters ("s2member_paypal_custom", false);
	}
/*
Get the user ID for an existing Member, referenced by a Subscr. ID.
A second lookup parameter can be provided, which will trigger some additional routines.
The $os0 value comes from advanced update vars, pertaining to subscription modifications.
*/
function ws_plugin__s2member_paypal_user_id ($subscr_id = FALSE, $os0 = FALSE)
	{
		global $wpdb; /* Need global DB obj. */
		/**/
		do_action ("s2member_before_paypal_user_id");
		/**/
		if ($subscr_id && $os0) /* This case includes some additional routines that can use the $os0 value. */
			{
				if (($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND (`meta_value` = '" . $wpdb->escape ($subscr_id) . "' OR `meta_value` = '" . $wpdb->escape ($os0) . "') LIMIT 1"))/**/
				|| ($q = $wpdb->get_row ("SELECT `ID` AS `user_id` FROM `" . $wpdb->users . "` WHERE `ID` = '" . $wpdb->escape ($os0) . "' LIMIT 1")))
					return apply_filters ("s2member_paypal_user_id", $q->user_id);
			}
		else if ($subscr_id) /* Otherwise, if all we have is a Subscr. ID value. */
			{
				if ($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1"))
					return apply_filters ("s2member_paypal_user_id", $q->user_id);
			}
		/**/
		return apply_filters ("s2member_paypal_user_id", false);
	}
/*
Calculate Auto-EOT Time, based on last_payment_time, period1, and period3.
This is used by s2Member's built-in Auto-EOT System, and by its IPN routines.
*/
function ws_plugin__s2member_paypal_auto_eot_time ($user_id = FALSE, $period1 = FALSE, $period3 = FALSE, $eotper = FALSE)
	{
		do_action ("s2member_before_paypal_auto_eot_time");
		/**/
		if ($user_id && ($user = new WP_User ($user_id))) /* Must have a valid user_id. */
			{
				$registration_time = strtotime ($user->user_registered);
				$last_payment_time = (int)get_usermeta ($user_id, "s2member_last_payment_time");
				/**/
				if (!($p1_time = 0) && ($period1 = trim (strtoupper ($period1))))
					{
						list ($num, $span) = preg_split ("/ /", $period1, 2);
						/**/
						$days = 0; /* Days start at 0. */
						$days = ($span === "D") ? 1 : $days;
						$days = ($span === "W") ? 7 : $days;
						$days = ($span === "M") ? 30 : $days;
						$days = ($span === "Y") ? 365 : $days;
						/**/
						$p1_days = (int)$num * (int)$days;
						$p1_time = $p1_days * 86400;
					}
				/**/
				if (!($p3_time = 0) && ($period3 = trim (strtoupper ($period3))))
					{
						list ($num, $span) = preg_split ("/ /", $period3, 2);
						/**/
						$days = 0; /* Days start at 0. */
						$days = ($span === "D") ? 1 : $days;
						$days = ($span === "W") ? 7 : $days;
						$days = ($span === "M") ? 30 : $days;
						$days = ($span === "Y") ? 365 : $days;
						/**/
						$p3_days = (int)$num * (int)$days;
						$p3_time = $p3_days * 86400;
					}
				/**/
				if (!$last_payment_time) /* If no payment yet.
				EOT after p1, if there was a p1. Otherwise, now + 1 day grace. */
					{
						$auto_eot_time = $registration_time + $p1_time + 86400;
					}
				/* Else if p1, and last payment was within p1, last + p1 + 1 day grace. */
				else if ($p1_time && $last_payment_time <= $registration_time + $p1_time)
					{
						$auto_eot_time = $last_payment_time + $p1_time + 86400;
					}
				else /* Otherwise, the EOT comes after last payment + p3 + 1 day grace. */
					{
						$auto_eot_time = $last_payment_time + $p3_time + 86400;
					}
			}
		/**/
		else if ($eotper) /* Otherwise, if we have a specific EOT period; calculate from today. */
			{
				if (!($eot_time = 0) && ($eotper = trim (strtoupper ($eotper))))
					{
						list ($num, $span) = preg_split ("/ /", $eotper, 2);
						/**/
						$days = 0; /* Days start at 0. */
						$days = ($span === "D") ? 1 : $days;
						$days = ($span === "W") ? 7 : $days;
						$days = ($span === "M") ? 30 : $days;
						$days = ($span === "Y") ? 365 : $days;
						/**/
						$eot_days = (int)$num * (int)$days;
						$eot_time = $eot_days * 86400;
					}
				/**/
				$auto_eot_time = strtotime ("now") + $eot_time + 86400;
			}
		/**/
		$auto_eot_time = ($auto_eot_time <= 0) ? strtotime ("now") : $auto_eot_time;
		/**/
		return apply_filters ("s2member_paypal_auto_eot_time", $auto_eot_time);
	}
?>