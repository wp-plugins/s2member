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
Handles paypal ipn url processing.
Attach to: add_action("init");
*/
function ws_plugin__s2member_paypal_notify ()
	{
		do_action ("s2member_before_paypal_notify");
		/**/
		if ($_GET["s2member_paypal_notify"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"])
			{
				global $wpdb; /* Need this global variable as a reference to the database object. */
				/**/
				if (is_object ($wpdb) && is_array ($paypal = ws_plugin__s2member_paypal_postvars ()))
					{
						$paypal["s2member_log"][] = "s2Member POST vars verified through a POST back to PayPal®.";
						/**/
						if (preg_match ("/^" . preg_quote ($_SERVER["HTTP_HOST"], "/") . "/i", $paypal["custom"])) /* Matches originating host? */
							{ /* The business address validation was removed from this routine, because PayPal® always fills that with the primary
									email address. In cases where an alternate PayPal® address is being paid, validation is not possible. */
								$paypal["s2member_log"][] = "s2Member originating domain ( _SERVER[HTTP_HOST] ) validated.";
								/*
								Single-Page Access.
								*/
								if (preg_match ("/^web_accept$/i", $paypal["txn_type"]) && $paypal["payer_email"] && $paypal["txn_id"] && preg_match ("/^sp\:[0-9]+\:[0-9]+$/", $paypal["item_number"]))
									{
										do_action ("s2member_during_paypal_notify_before_sp_access");
										/**/
										$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept) for Single-Page access.";
										/**/
										list (, $paypal["page"], $paypal["hours"]) = preg_split ("/\:/", $paypal["item_number"], 3);
										/**/
										if (($sp_access_url = ws_plugin__s2member_sp_access_link_gen ($paypal["page"], $paypal["hours"])) && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
											{
												$sbj = preg_replace ("/%%sp_access_url%%/i", $sp_access_url, $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["single_page_email_subject"]);
												$sbj = preg_replace ("/%%sp_access_exp%%/i", human_time_diff (strtotime ("now"), strtotime ("+" . $paypal["hours"] . " hours")), $sbj);
												/**/
												$msg = preg_replace ("/%%sp_access_url%%/i", $sp_access_url, $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["single_page_email_message"]);
												$msg = preg_replace ("/%%sp_access_exp%%/i", human_time_diff (strtotime ("now"), strtotime ("+" . $paypal["hours"] . " hours")), $msg);
												/**/
												if (($sbj = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $sbj)) && ($sbj = preg_replace ("/%%txn_id%%/i", $paypal["txn_id"], $sbj)))
													if (($sbj = preg_replace ("/%%amount%%/i", $paypal["mc_gross"], $sbj))) /* Full amount of the payment, before fee is subtracted. */
														if (($sbj = preg_replace ("/%%item_number%%/i", $paypal["item_number"], $sbj)) && ($sbj = preg_replace ("/%%item_name%%/i", $paypal["item_name"], $sbj)))
															if (($sbj = preg_replace ("/%%first_name%%/i", $paypal["first_name"], $sbj)) && ($sbj = preg_replace ("/%%last_name%%/i", $paypal["last_name"], $sbj)))
																if (($sbj = preg_replace ("/%%full_name%%/i", trim ($paypal["first_name"] . " " . $paypal["last_name"]), $sbj)))
																	if (($sbj = preg_replace ("/%%payer_email%%/i", $paypal["payer_email"], $sbj)))
																		/**/
																		if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%txn_id%%/i", $paypal["txn_id"], $msg)))
																			if (($msg = preg_replace ("/%%amount%%/i", $paypal["mc_gross"], $msg))) /* Full amount of the payment, before fee is subtracted. */
																				if (($msg = preg_replace ("/%%item_number%%/i", $paypal["item_number"], $msg)) && ($msg = preg_replace ("/%%item_name%%/i", $paypal["item_name"], $msg)))
																					if (($msg = preg_replace ("/%%first_name%%/i", $paypal["first_name"], $msg)) && ($msg = preg_replace ("/%%last_name%%/i", $paypal["last_name"], $msg)))
																						if (($msg = preg_replace ("/%%full_name%%/i", trim ($paypal["first_name"] . " " . $paypal["last_name"]), $msg)))
																							if (($msg = preg_replace ("/%%payer_email%%/i", $paypal["payer_email"], $msg)))
																								/**/
																								if (($sbj = trim ($sbj)) && ($msg = trim ($msg))) /* Make sure they are not empty. */
																									{
																										@mail ($paypal["payer_email"], $sbj, $msg, "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8", "-f " . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"]);
																										/**/
																										$paypal["s2member_log"][] = "Email sent after purchase, with a URL that provides the Customer with Single-Page Access.";
																									}
												/**/
												if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_notification_urls"])
													{
														foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_notification_urls"]) as $url)
															/**/
															if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%sp_access_url%%/i", rawurlencode ($sp_access_url), $url)))
																if (($url = preg_replace ("/%%sp_access_exp%%/i", urlencode (human_time_diff (strtotime ("now"), strtotime ("+" . $paypal["hours"] . " hours"))), $url)))
																	if (($url = preg_replace ("/%%amount%%/i", urlencode ($paypal["mc_gross"]), $url)) && ($url = preg_replace ("/%%txn_id%%/i", urlencode ($paypal["txn_id"]), $url)))
																		if (($url = preg_replace ("/%%item_number%%/i", urlencode ($paypal["item_number"]), $url)) && ($url = preg_replace ("/%%item_name%%/i", urlencode ($paypal["item_name"]), $url)))
																			if (($url = preg_replace ("/%%first_name%%/i", urlencode ($paypal["first_name"]), $url)) && ($url = preg_replace ("/%%last_name%%/i", urlencode ($paypal["last_name"]), $url)))
																				if (($url = preg_replace ("/%%full_name%%/i", urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $url)))
																					if (($url = preg_replace ("/%%payer_email%%/i", urlencode ($paypal["payer_email"]), $url)))
																						/**/
																						if (($url = trim ($url))) /* Make sure it is not empty. */
																							ws_plugin__s2member_curlpsr ($url, "s2member=1");
														/**/
														$paypal["s2member_log"][] = "Payment Notification URLs have been processed.";
													}
												/**/
												do_action ("s2member_during_paypal_notify_during_sp_access");
											}
										/**/
										do_action ("s2member_during_paypal_notify_after_sp_access");
									}
								/*
								New subscriptions. Possibly containing advanced updated vars ( option_name1, option_selection1 ); which allow account modifications.
								*/
								else if (preg_match ("/^(web_accept|subscr_signup)$/i", $paypal["txn_type"]) && $paypal["payer_email"] && ($paypal["subscr_id"] || ($paypal["subscr_id"] = $paypal["txn_id"])) && preg_match ("/^[1-4](\:|$)/", $paypal["item_number"]))
									{
										do_action ("s2member_during_paypal_notify_before_subscr_signup");
										/**/
										$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept|subscr_signup).";
										/**/
										list ($paypal["level"], $paypal["ccaps"]) = preg_split ("/\:/", $paypal["item_number"], 2);
										/*
										New subscription with advanced update vars ( option_name1, option_selection1 ).
										*/
										if (preg_match ("/(updat|upgrad)/i", $paypal["option_name1"]) && $paypal["option_selection1"]) /* This is an advanced way to handle subscription update modifications. */
											/* This advanced method is required whenever a subscription that is already completed, or was never setup to recur in the first place needs to be modified. PayPal will not allow the
														modify=1|2 parameter to be used in those scenarios, because technically there is nothing to update. The only thing that actually needs to be updated is their existing account. */
											{
												do_action ("s2member_during_paypal_notify_before_subscr_signup_w_update_vars");
												/**/
												$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept|subscr_signup) w/ update vars.";
												/**/
												/* Here we need to check for both the old & new s2member_subscr_id's, just in case the Return routine has already changed it. */
												if (($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND (`meta_value` = '" . $wpdb->escape ($paypal["option_selection1"]) . "' OR `meta_value` = '" . $wpdb->escape ($paypal["subscr_id"]) . "') LIMIT 1"))/**/
												|| ($q = $wpdb->get_row ("SELECT `ID` AS `user_id` FROM `" . $wpdb->users . "` WHERE `ID` = '" . $wpdb->escape ($paypal["option_selection1"]) . "' LIMIT 1")))
													{
														if ($user_id = $q->user_id) /* Got it! */
															{
																$user = new WP_User ($user_id);
																$user->set_role ("s2member_level" . $paypal["level"]);
																update_usermeta ($user_id, "s2member_subscr_id", $paypal["subscr_id"]);
																update_usermeta ($user_id, "s2member_custom", $paypal["custom"]);
																/**/
																foreach ($user->allcaps as $cap => $cap_enabled)
																	if (preg_match ("/^access_s2member_ccap_/", $cap))
																		$user->remove_cap ($ccap = $cap);
																/**/
																foreach (preg_split ("/[\r\n\t\s;,]+/", $paypal["ccaps"]) as $ccap)
																	if (strlen ($ccap)) /* Don't add empty capabilities. */
																		$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
																/**/
																delete_usermeta ($user_id, "s2member_file_download_access_arc");
																delete_usermeta ($user_id, "s2member_file_download_access_log");
																/**/
																$paypal["s2member_log"][] = "s2Member Level/Capabilities updated w/ advanced update routines.";
																/**/
																do_action ("s2member_during_paypal_notify_during_subscr_signup_w_update_vars");
															}
														else
															{
																$paypal["s2member_log"][] = "Unable to modify subscription. Could not get the existing user_id from the DB. Please check the on0 and os0 variables in your Button Code.";
															}
													}
												else
													{
														$paypal["s2member_log"][] = "Unable to modify subscription. Could not find existing subscription in the DB. Please check the on0 and os0 variables in your Button Code.";
													}
												/**/
												do_action ("s2member_during_paypal_notify_after_subscr_signup_w_update_vars");
											}
										/*
										New subscription. Normal subscription signup, we are not updating anything for a past subscription.
										*/
										else /* Else this is a normal subscription signup, we are not updating anything for a past subscription. */
											{
												do_action ("s2member_during_paypal_notify_before_subscr_signup_wo_update_vars");
												/**/
												$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept|subscr_signup) w/o update vars.";
												/**/
												if ($registration_url = ws_plugin__s2member_register_link_gen ($paypal["subscr_id"], $paypal["custom"], $paypal["item_number"]) && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
													{
														$sbj = preg_replace ("/%%registration_url%%/i", $registration_url, $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_email_subject"]);
														$msg = preg_replace ("/%%registration_url%%/i", $registration_url, $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_email_message"]);
														/**/
														if (preg_match ("/^web_accept$/i", $paypal["txn_type"]))
															{
																$paypal["period3"] = "1 L"; /* 1 Lifetime. */
																$paypal["mc_amount3"] = $paypal["mc_gross"];
															}
														/**/
														$initial_term = $paypal["period1"] ? $paypal["period1"] : "0 D"; /* Do not allow the initial period to be empty. Defaults to 0 D. */
														$initial = (isset ($paypal["mc_amount1"]) && preg_match ("/^[1-9]/", $paypal["period1"])) ? $paypal["mc_amount1"] : $paypal["mc_amount3"];
														$regular = $paypal["mc_amount3"]; /* This is the regular payment amount that is charged to the customer. Always required by PayPal. */
														$recurring = ($paypal["recurring"]) ? $paypal["mc_amount3"] : "0"; /* If non-recurring, this should be zero, otherwise regular. */
														/* The initial amount will only be $0 if a trial was offered. If no trial was offered, they were charged a regular rate. */
														/**/
														if (($sbj = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $sbj)) && ($sbj = preg_replace ("/%%subscr_id%%/i", $paypal["subscr_id"], $sbj)))
															if (($sbj = preg_replace ("/%%initial%%/i", $initial, $sbj)) && ($sbj = preg_replace ("/%%recurring%%/i", $recurring, $sbj)) && ($sbj = preg_replace ("/%%regular%%/i", $regular, $sbj)))
																if (($sbj = preg_replace ("/%%initial_term%%/i", $initial_term, $sbj)) && ($sbj = preg_replace ("/%%regular_term%%/i", $paypal["period3"], $sbj)))
																	if (($sbj = preg_replace ("/%%item_number%%/i", $paypal["item_number"], $sbj)) && ($sbj = preg_replace ("/%%item_name%%/i", $paypal["item_name"], $sbj)))
																		if (($sbj = preg_replace ("/%%first_name%%/i", $paypal["first_name"], $sbj)) && ($sbj = preg_replace ("/%%last_name%%/i", $paypal["last_name"], $sbj)))
																			if (($sbj = preg_replace ("/%%full_name%%/i", trim ($paypal["first_name"] . " " . $paypal["last_name"]), $sbj)))
																				if (($sbj = preg_replace ("/%%payer_email%%/i", $paypal["payer_email"], $sbj)))
																					/**/
																					if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%subscr_id%%/i", $paypal["subscr_id"], $msg)))
																						if (($msg = preg_replace ("/%%initial%%/i", $initial, $msg)) && ($msg = preg_replace ("/%%recurring%%/i", $recurring, $msg)) && ($msg = preg_replace ("/%%regular%%/i", $regular, $msg)))
																							if (($msg = preg_replace ("/%%initial_term%%/i", $initial_term, $msg)) && ($msg = preg_replace ("/%%regular_term%%/i", $paypal["period3"], $msg)))
																								if (($msg = preg_replace ("/%%item_number%%/i", $paypal["item_number"], $msg)) && ($msg = preg_replace ("/%%item_name%%/i", $paypal["item_name"], $msg)))
																									if (($msg = preg_replace ("/%%first_name%%/i", $paypal["first_name"], $msg)) && ($msg = preg_replace ("/%%last_name%%/i", $paypal["last_name"], $msg)))
																										if (($msg = preg_replace ("/%%full_name%%/i", trim ($paypal["first_name"] . " " . $paypal["last_name"]), $msg)))
																											if (($msg = preg_replace ("/%%payer_email%%/i", $paypal["payer_email"], $msg)))
																												/**/
																												if (($sbj = trim ($sbj)) && ($msg = trim ($msg))) /* Make sure they are not empty. */
																													{
																														@mail ($paypal["payer_email"], $sbj, $msg, "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8", "-f " . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"]);
																														/**/
																														$paypal["s2member_log"][] = "Email sent after signup, with a URL to assist Customer w/ registration.";
																													}
														/**/
														do_action ("s2member_during_paypal_notify_during_subscr_signup_wo_update_vars");
													}
												/**/
												do_action ("s2member_during_paypal_notify_after_subscr_signup_wo_update_vars");
											}
										/**/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
											{
												if (preg_match ("/^web_accept$/i", $paypal["txn_type"]))
													{
														$paypal["period3"] = "1 L"; /* 1 Lifetime. */
														$paypal["mc_amount3"] = $paypal["mc_gross"];
													}
												/**/
												$initial_term = $paypal["period1"] ? $paypal["period1"] : "0 D"; /* Do not allow the initial period to be empty. Defaults to 0 D. */
												$initial = (isset ($paypal["mc_amount1"]) && preg_match ("/^[1-9]/", $paypal["period1"])) ? $paypal["mc_amount1"] : $paypal["mc_amount3"];
												$regular = $paypal["mc_amount3"]; /* This is the regular payment amount that is charged to the customer. Always required by PayPal. */
												$recurring = ($paypal["recurring"]) ? $paypal["mc_amount3"] : "0"; /* If non-recurring, this should be zero, otherwise regular. */
												/* The initial amount will only be $0 if a trial was offered. If no trial was offered, they were charged a regular rate. */
												/**/
												foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_notification_urls"]) as $url)
													/**/
													if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", urlencode ($paypal["subscr_id"]), $url)))
														if (($url = preg_replace ("/%%initial%%/i", urlencode ($initial), $url)) && ($url = preg_replace ("/%%recurring%%/i", urlencode ($recurring), $url)) && ($url = preg_replace ("/%%regular%%/i", urlencode ($regular), $url)))
															if (($url = preg_replace ("/%%initial_term%%/i", urlencode ($initial_term), $url)) && ($url = preg_replace ("/%%regular_term%%/i", urlencode ($paypal["period3"]), $url)))
																if (($url = preg_replace ("/%%item_number%%/i", urlencode ($paypal["item_number"]), $url)) && ($url = preg_replace ("/%%item_name%%/i", urlencode ($paypal["item_name"]), $url)))
																	if (($url = preg_replace ("/%%first_name%%/i", urlencode ($paypal["first_name"]), $url)) && ($url = preg_replace ("/%%last_name%%/i", urlencode ($paypal["last_name"]), $url)))
																		if (($url = preg_replace ("/%%full_name%%/i", urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $url)))
																			if (($url = preg_replace ("/%%payer_email%%/i", urlencode ($paypal["payer_email"]), $url)))
																				/**/
																				if (($url = trim ($url))) /* Make sure it is not empty. */
																					ws_plugin__s2member_curlpsr ($url, "s2member=1");
												/**/
												$paypal["s2member_log"][] = "Signup Notification URLs have been processed.";
											}
										/**/
										do_action ("s2member_during_paypal_notify_after_subscr_signup");
									}
								/*
								Subscription modifications.
								*/
								else if (preg_match ("/^subscr_modify$/i", $paypal["txn_type"]) && $paypal["subscr_id"] && preg_match ("/^[1-4](\:|$)/", $paypal["item_number"]))
									{
										do_action ("s2member_during_paypal_notify_before_subscr_modify");
										/**/
										$paypal["s2member_log"][] = "s2Member txn_type identified as subscr_modify.";
										/**/
										list ($paypal["level"], $paypal["ccaps"]) = preg_split ("/\:/", $paypal["item_number"], 2);
										/**/
										if ($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($paypal["subscr_id"]) . "' LIMIT 1"))
											{
												if ($user_id = $q->user_id) /* Got it! */
													{
														$user = new WP_User ($user_id);
														$user->set_role ("s2member_level" . $paypal["level"]);
														update_usermeta ($user_id, "s2member_subscr_id", $paypal["subscr_id"]);
														update_usermeta ($user_id, "s2member_custom", $paypal["custom"]);
														/**/
														foreach ($user->allcaps as $cap => $cap_enabled)
															if (preg_match ("/^access_s2member_ccap_/", $cap))
																$user->remove_cap ($ccap = $cap);
														/**/
														foreach (preg_split ("/[\r\n\t\s;,]+/", $paypal["ccaps"]) as $ccap)
															if (strlen ($ccap)) /* Don't add empty capabilities. */
																$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
														/**/
														delete_usermeta ($user_id, "s2member_file_download_access_arc");
														delete_usermeta ($user_id, "s2member_file_download_access_log");
														/**/
														$paypal["s2member_log"][] = "s2Member Level/Capabilities updated on subscription modification.";
														/**/
														do_action ("s2member_during_paypal_notify_during_subscr_modify");
													}
												else
													{
														$paypal["s2member_log"][] = "Unable to modify subscription. Could not get the existing user_id from the DB.";
													}
											}
										else
											{
												$paypal["s2member_log"][] = "Unable to modify subscription. Could not find existing subscription in the DB.";
											}
										/**/
										do_action ("s2member_during_paypal_notify_after_subscr_modify");
									}
								/*
								Subscription payments.
								*/
								else if (preg_match ("/^subscr_payment$/i", $paypal["txn_type"]) && $paypal["payer_email"] && $paypal["subscr_id"] && preg_match ("/^[1-4](\:|$)/", $paypal["item_number"]) && $paypal["txn_id"] && $paypal["mc_gross"])
									{
										do_action ("s2member_during_paypal_notify_before_subscr_payment");
										/**/
										$paypal["s2member_log"][] = "s2Member txn_type identified as subscr_payment.";
										/**/
										list ($paypal["level"], $paypal["ccaps"]) = preg_split ("/\:/", $paypal["item_number"], 2);
										/**/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
											{
												foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_urls"]) as $url)
													/**/
													if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", urlencode ($paypal["subscr_id"]), $url)))
														if (($url = preg_replace ("/%%amount%%/i", urlencode ($paypal["mc_gross"]), $url)) && ($url = preg_replace ("/%%txn_id%%/i", urlencode ($paypal["txn_id"]), $url)))
															if (($url = preg_replace ("/%%item_number%%/i", urlencode ($paypal["item_number"]), $url)) && ($url = preg_replace ("/%%item_name%%/i", urlencode ($paypal["item_name"]), $url)))
																if (($url = preg_replace ("/%%first_name%%/i", urlencode ($paypal["first_name"]), $url)) && ($url = preg_replace ("/%%last_name%%/i", urlencode ($paypal["last_name"]), $url)))
																	if (($url = preg_replace ("/%%full_name%%/i", urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $url)))
																		if (($url = preg_replace ("/%%payer_email%%/i", urlencode ($paypal["payer_email"]), $url)))
																			/**/
																			if (($url = trim ($url))) /* Make sure it is not empty. */
																				ws_plugin__s2member_curlpsr ($url, "s2member=1");
												/**/
												$paypal["s2member_log"][] = "Payment Notification URLs have been processed.";
											}
										/**/
										do_action ("s2member_during_paypal_notify_after_subscr_payment");
									}
								/*
								Subscription terminations.
								*/
								else if ((preg_match ("/^subscr_eot$/i", $paypal["txn_type"]) || preg_match ("/^(refunded|reversed)$/i", $paypal["payment_status"])) && ($paypal["subscr_id"] || ($paypal["subscr_id"] = $paypal["parent_txn_id"])) && preg_match ("/^[1-4](\:|$)/", $paypal["item_number"]))
									{
										do_action ("s2member_during_paypal_notify_before_subscr_eot");
										/**/
										$paypal["s2member_log"][] = "s2Member txn_type identified as subscr_eot - or - payment_status (refunded|reversed).";
										/**/
										list ($paypal["level"], $paypal["ccaps"]) = preg_split ("/\:/", $paypal["item_number"], 2);
										/**/
										if ($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($paypal["subscr_id"]) . "' LIMIT 1"))
											{
												if ($user_id = $q->user_id) /* Demote to Free Subscriber, or delete the Member completely. */
													{
														if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_eot_behavior"] === "demote")
															{
																$user = new WP_User ($user_id);
																$user->set_role ("subscriber");
																delete_usermeta ($user_id, "s2member_custom");
																delete_usermeta ($user_id, "s2member_subscr_id");
																/**/
																foreach ($user->allcaps as $cap => $cap_enabled)
																	if (preg_match ("/^access_s2member_ccap_/", $cap))
																		$user->remove_cap ($ccap = $cap);
																/**/
																delete_usermeta ($user_id, "s2member_file_download_access_arc");
																delete_usermeta ($user_id, "s2member_file_download_access_log");
																/**/
																$paypal["s2member_log"][] = "Member Level/Capabilities demoted to a Free Subscriber.";
																/**/
																if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																	{
																		foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"]) as $url) /* Handle eot notifications. */
																			/**/
																			if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", urlencode ($paypal["subscr_id"]), $url)))
																				if (($url = preg_replace ("/%%user_first_name%%/i", urlencode ($user->first_name), $url)) && ($url = preg_replace ("/%%user_last_name%%/i", urlencode ($user->last_name), $url)))
																					if (($url = preg_replace ("/%%user_full_name%%/i", urlencode (trim ($user->first_name . " " . $user->last_name)), $url)))
																						if (($url = preg_replace ("/%%user_email%%/i", urlencode ($user->user_email), $url)))
																							/**/
																							if (($url = trim ($url))) /* Make sure it is not empty. */
																								ws_plugin__s2member_curlpsr ($url, "s2member=1");
																		/**/
																		$paypal["s2member_log"][] = "EOT/Deletion Notification URLs have been processed.";
																	}
																/**/
																do_action ("s2member_during_paypal_notify_during_subscr_eot_demote");
															}
														else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_eot_behavior"] === "delete")
															{
																wp_delete_user ($user_id); /* Triggers: `ws_plugin__s2member_handle_user_deletions()` */
																/* `ws_plugin__s2member_handle_user_deletions()` triggers `eot_del_notification_urls` */
																/**/
																$paypal["s2member_log"][] = "The Member's account has been deleted completely.";
																/**/
																$paypal["s2member_log"][] = "EOT/Deletion Notification URLs have been processed.";
																/**/
																do_action ("s2member_during_paypal_notify_during_subscr_eot_delete");
															}
														/**/
														do_action ("s2member_during_paypal_notify_during_subscr_eot");
													}
												else
													{
														$paypal["s2member_log"][] = "Unable to (demote|delete) Member. Could not get the existing user_id from the DB. It's possible that it was already removed manually by a site administrator.";
													}
												/**/
												if (!preg_match ("/^subscr_eot$/i", $paypal["txn_type"]) && preg_match ("/^(refunded|reversed)$/i", $paypal["payment_status"]) && $paypal["parent_txn_id"])
													{
														if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["ref_rev_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
															{
																foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["ref_rev_notification_urls"]) as $url)
																	/**/
																	if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", urlencode ($paypal["subscr_id"]), $url)))
																		if (($url = preg_replace ("/%%-amount%%/i", urlencode ($paypal["mc_gross"]), $url)) && ($url = preg_replace ("/%%parent_txn_id%%/i", urlencode ($paypal["parent_txn_id"]), $url)))
																			if (($url = preg_replace ("/%%item_number%%/i", urlencode ($paypal["item_number"]), $url)) && ($url = preg_replace ("/%%item_name%%/i", urlencode ($paypal["item_name"]), $url)))
																				if (($url = preg_replace ("/%%first_name%%/i", urlencode ($paypal["first_name"]), $url)) && ($url = preg_replace ("/%%last_name%%/i", urlencode ($paypal["last_name"]), $url)))
																					if (($url = preg_replace ("/%%full_name%%/i", urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $url)))
																						if (($url = preg_replace ("/%%payer_email%%/i", urlencode ($paypal["payer_email"]), $url)))
																							/**/
																							if (($url = trim ($url))) /* Make sure it is not empty. */
																								ws_plugin__s2member_curlpsr ($url, "s2member=1");
																/**/
																$paypal["s2member_log"][] = "Refund/Reversal Notification URLs have been processed.";
															}
													}
											}
										else
											{
												$paypal["s2member_log"][] = "Unable to (demote|delete) Member. Could not find existing subscription in the DB. It's possible that it was already removed manually by a site administrator.";
											}
										/**/
										do_action ("s2member_during_paypal_notify_after_subscr_eot");
									}
								else
									{
										$paypal["s2member_log"][] = "Properly ignoring this IPN request. The txn_type does not require any action on the part of s2Member.";
									}
							}
						else
							{
								$paypal["s2member_log"][] = "Unable to verify _SERVER[HTTP_HOST]. Possibly caused by a fraudulent request. If this error continues, please check the `custom` value in your Button Code. It MUST start with your domain name.";
							}
					}
				else
					{
						$paypal["s2member_log"][] = "Unable to verify POST vars. Possibly caused by a fraudulent request. If this error continues, please run IPN tests against your server from a PayPal® Sandbox account. They provide special diagnostic tools that may assist you.";
					}
				/**/
				if ($_GET["s2member_paypal_proxy"]) /* For proxy identification. */
					$paypal["s2member_paypal_proxy"] = $_GET["s2member_paypal_proxy"];
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_debug"])
					if (is_dir ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
						if (is_writable ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
							file_put_contents ($logs_dir . "/paypal-ipn.log", var_export ($paypal, true) . "\n\n", FILE_APPEND);
				/**/
				do_action ("s2member_during_paypal_notify");
				/**/
				exit;
			}
		/**/
		do_action ("s2member_after_paypal_notify");
	}
?>