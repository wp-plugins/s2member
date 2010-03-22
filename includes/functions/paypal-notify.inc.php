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
								/**/
								if (preg_match ("/^subscr_signup$/i", $paypal["txn_type"]) && $paypal["payer_email"] && $paypal["subscr_id"] && preg_match ("/^[1-4]$/", $paypal["item_number"]))
									{
										$paypal["s2member_log"][] = "s2Member txn_type identified as subscr_signup.";
										/**/
										if (preg_match ("/(updat|upgrad)/i", $paypal["option_name1"]) && $paypal["option_selection1"]) /* This is an advanced way to handle subscription update modifications. */
											/* This advanced method is required whenever a subscription that is already completed, or was never setup to recur in the first place needs to be modified. PayPal will not allow the
														modify=2 parameter to be used in those scenarios, because technically there is nothing to update. The only thing that actually needs to be updated is their existing account. */
											{
												$paypal["s2member_log"][] = "s2Member txn_type identified as subscr_signup w/ update vars.";
												/**/
												/* Here we need to check for both the old & new s2member_subscr_id's, just in case the Auto-Return routine has already changed it. */
												if ($usermeta = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND (`meta_value` = '" . $wpdb->escape ($paypal["option_selection1"]) . "' OR `meta_value` = '" . $wpdb->escape ($paypal["subscr_id"]) . "') LIMIT 1"))
													{
														if ($usermeta->user_id) /* Modify role. */
															{
																$user = new WP_User ($usermeta->user_id);
																$user->set_role ("s2member_level" . $paypal["item_number"]);
																update_usermeta ($usermeta->user_id, "s2member_subscr_id", $paypal["subscr_id"]);
																update_usermeta ($usermeta->user_id, "s2member_custom", $paypal["custom"]);
																delete_usermeta ($usermeta->user_id, "s2member_file_download_access_arc");
																delete_usermeta ($usermeta->user_id, "s2member_file_download_access_log");
																/**/
																$paypal["s2member_log"][] = "s2Member level updated w/ advanced update routines.";
															}
														else
															{
																$paypal["s2member_log"][] = "Unable to get user_id from the DB.";
															}
													}
												else
													{
														$paypal["s2member_log"][] = "Unable to find former subscription in the DB.";
													}
											}
										else /* Else this is a normal subscription signup, we are not updating anything for a past subscription. */
											{
												$paypal["s2member_log"][] = "s2Member txn_type identified as subscr_signup w/o update vars.";
												/**/
												if ($subscr_id_custom_item_number_xencrypted = ws_plugin__s2member_xencrypt ("subscr_id_custom_item_number:.:|:.:" . $paypal["subscr_id"] . ":.:|:.:" . $paypal["custom"] . ":.:|:.:" . $paypal["item_number"]))
													{
														if ($tinyurl = @file_get_contents ("http://tinyurl.com/api-create.php?url=" . rawurlencode (get_bloginfo ("url") . "/?s2member_paypal_register=" . urlencode ($subscr_id_custom_item_number_xencrypted))))
															{
																$message = "Congratulations! Your membership has been approved.\n\nIf you haven't already done so, the next step is to Register a Username.\n\nComplete your registration here:\n" . $tinyurl . "\n\nNote: You can only register once. If you receive an error message during your registration, it's probably because you already have an account.\n\nIf you have any trouble, please feel free to contact us.\n\n\nBest Regards,\n" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"];
																@mail ($paypal["payer_email"], "Congratulations! Your membership has been approved.", $message, "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8", "-f " . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"]);
																/**/
																$paypal["s2member_log"][] = "Email sent ( w/tiny URL ) to congratulate customer after signup.";
															}
														else if ($longurl = get_bloginfo ("url") . "/?s2member_paypal_register=" . urlencode ($subscr_id_custom_item_number_xencrypted))
															{
																$message = "Congratulations! Your membership has been approved.\n\nIf you haven't already done so, the next step is to Register a Username.\n\nComplete your registration here:\n" . $longurl . "\n\nNote: You can only register once. If you receive an error message during your registration, it's probably because you already have an account.\n\nIf you have any trouble, please feel free to contact us.\n\n\nBest Regards,\n" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"];
																@mail ($paypal["payer_email"], "Congratulations! Your membership has been approved.", $message, "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8", "-f " . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"]);
																/**/
																$paypal["s2member_log"][] = "Email sent ( w/long URL ) to congratulate customer after signup.";
															}
													}
											}
										/**/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
											{
												$initial_term = $paypal["period1"] ? $paypal["period1"] : "0 D"; /* Do not allow the initial period to be empty. */
												$regular = $paypal["amount3"]; /* This is the regular payment amount that is charged to the customer. Always required by PayPal. */
												$initial = (isset ($paypal["amount1"]) && preg_match ("/^[1-9]/", $paypal["period1"])) ? $paypal["amount1"] : $paypal["amount3"];
												$recurring = $paypal["recurring"] ? $paypal["amount3"] : "0"; /* If non-recurring, this should be zero, otherwise regular. */
												/* The initial amount will only be $0 if a trial was offered. If no trial was offered, they were charged a regular rate. */
												foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_notification_urls"]) as $url)
													if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", urlencode ($paypal["subscr_id"]), $url)))
														if (($url = preg_replace ("/%%initial%%/i", urlencode ($initial), $url)) && ($url = preg_replace ("/%%recurring%%/i", urlencode ($recurring), $url))) /* Adv calculations. */
															if (($url = preg_replace ("/%%regular%%/i", urlencode ($regular), $url))) /* This is provided mostly for rare cases where a trial is offered, and there is NO recurrence. */
																/* In cases where there is a free trial offered, and no recurring charges either ( could happen ), both initial & recurring are 0. So regular should be reported then. */
																if (($url = preg_replace ("/%%initial_term%%/i", urlencode ($initial_term), $url)) && ($url = preg_replace ("/%%regular_term%%/i", urlencode ($paypal["period3"]), $url)))
																	if (($url = preg_replace ("/%%item_number%%/i", urlencode ($paypal["item_number"]), $url)) && ($url = preg_replace ("/%%item_name%%/i", urlencode ($paypal["item_name"]), $url)))
																		if (($url = preg_replace ("/%%first_name%%/i", urlencode ($paypal["first_name"]), $url)) && ($url = preg_replace ("/%%last_name%%/i", urlencode ($paypal["last_name"]), $url)))
																			if (($url = preg_replace ("/%%full_name%%/i", urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $url)))
																				if (($url = preg_replace ("/%%payer_email%%/i", urlencode ($paypal["payer_email"]), $url)))
																					if (($url = trim ($url))) /* Make sure it is not empty now. */
																						ws_plugin__s2member_curlpsr ($url, "s2member=1");
												/**/
												$paypal["s2member_log"][] = "Signup notification URLs have been processed.";
											}
									}
								else if (preg_match ("/^subscr_modify$/i", $paypal["txn_type"]) && $paypal["subscr_id"] && preg_match ("/^[1-4]$/", $paypal["item_number"]))
									{
										$paypal["s2member_log"][] = "s2Member txn_type identified as subscr_modify.";
										/**/
										if ($usermeta = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($paypal["subscr_id"]) . "' LIMIT 1"))
											{
												if ($usermeta->user_id) /* Modify role. */
													{
														$user = new WP_User ($usermeta->user_id);
														$user->set_role ("s2member_level" . $paypal["item_number"]);
														update_usermeta ($usermeta->user_id, "s2member_custom", $paypal["custom"]);
														/**/
														$paypal["s2member_log"][] = "s2Member level updated on subscription modification.";
													}
												else
													{
														$paypal["s2member_log"][] = "Unable to get user_id from the DB.";
													}
											}
										else
											{
												$paypal["s2member_log"][] = "Unable to find subscription in the DB.";
											}
									}
								else if (preg_match ("/^subscr_payment$/i", $paypal["txn_type"]) && $paypal["payer_email"] && $paypal["subscr_id"] && preg_match ("/^[1-4]$/", $paypal["item_number"]) && $paypal["txn_id"] && $paypal["payment_gross"])
									{
										$paypal["s2member_log"][] = "s2Member txn_type identified as subscr_payment.";
										/**/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
											{
												foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_urls"]) as $url)
													if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", urlencode ($paypal["subscr_id"]), $url)))
														if (($url = preg_replace ("/%%amount%%/i", urlencode ($paypal["payment_gross"]), $url)) && ($url = preg_replace ("/%%txn_id%%/i", urlencode ($paypal["txn_id"]), $url)))
															if (($url = preg_replace ("/%%item_number%%/i", urlencode ($paypal["item_number"]), $url)) && ($url = preg_replace ("/%%item_name%%/i", urlencode ($paypal["item_name"]), $url)))
																if (($url = preg_replace ("/%%first_name%%/i", urlencode ($paypal["first_name"]), $url)) && ($url = preg_replace ("/%%last_name%%/i", urlencode ($paypal["last_name"]), $url)))
																	if (($url = preg_replace ("/%%full_name%%/i", urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $url)))
																		if (($url = preg_replace ("/%%payer_email%%/i", urlencode ($paypal["payer_email"]), $url)))
																			if (($url = trim ($url))) /* Make sure it is not empty now. */
																				ws_plugin__s2member_curlpsr ($url, "s2member=1");
												/**/
												$paypal["s2member_log"][] = "Payment notification URLs have been processed.";
											}
									}
								else if ((preg_match ("/^subscr_eot$/i", $paypal["txn_type"]) || preg_match ("/^(refunded|reversed)$/i", $paypal["payment_status"])) && $paypal["subscr_id"] && preg_match ("/^[1-4]$/", $paypal["item_number"]))
									{
										$paypal["s2member_log"][] = "s2Member txn_type identified as subscr_eot.";
										/**/
										if ($usermeta = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($paypal["subscr_id"]) . "' LIMIT 1"))
											{
												if ($usermeta->user_id) /* Delete the user. Note that `ws_plugin__s2member_handle_user_deletions()` is fired too; it handles the `eot_del_notification_urls`. */
													{
														wp_delete_user ($usermeta->user_id); /* This triggers `ws_plugin__s2member_handle_user_deletions()` */
														/**/
														$paypal["s2member_log"][] = "User account automatically deleted from the system.";
														/**/
														$paypal["s2member_log"][] = "EOT/Deletion notification URLs have been processed.";
													}
												else
													{
														$paypal["s2member_log"][] = "Unable to get user_id from the DB.";
													}
												/**/
												if (!preg_match ("/^subscr_eot$/i", $paypal["txn_type"]) && preg_match ("/^(refunded|reversed)$/i", $paypal["payment_status"]) && $paypal["parent_txn_id"])
													{
														if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["ref_rev_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
															{
																foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["ref_rev_notification_urls"]) as $url)
																	if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", urlencode ($paypal["subscr_id"]), $url)))
																		if (($url = preg_replace ("/%%-amount%%/i", urlencode ($paypal["payment_gross"]), $url)) && ($url = preg_replace ("/%%parent_txn_id%%/i", urlencode ($paypal["parent_txn_id"]), $url)))
																			if (($url = preg_replace ("/%%item_number%%/i", urlencode ($paypal["item_number"]), $url)) && ($url = preg_replace ("/%%item_name%%/i", urlencode ($paypal["item_name"]), $url)))
																				if (($url = preg_replace ("/%%first_name%%/i", urlencode ($paypal["first_name"]), $url)) && ($url = preg_replace ("/%%last_name%%/i", urlencode ($paypal["last_name"]), $url)))
																					if (($url = preg_replace ("/%%full_name%%/i", urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $url)))
																						if (($url = preg_replace ("/%%payer_email%%/i", urlencode ($paypal["payer_email"]), $url)))
																							if (($url = trim ($url))) /* Make sure it is not empty now. */
																								ws_plugin__s2member_curlpsr ($url, "s2member=1");
																/**/
																$paypal["s2member_log"][] = "Refund/Reversal notification URLs have been processed.";
															}
													}
											}
										else
											{
												$paypal["s2member_log"][] = "Unable to find subscription in the DB.";
											}
									}
								else
									{
										$paypal["s2member_log"][] = "The txn_type does not require any action on the part of s2Member.";
									}
							}
						else
							{
								$paypal["s2member_log"][] = "Unable to verify _SERVER[HTTP_HOST].";
							}
					}
				else
					{
						$paypal["s2member_log"][] = "Unable to verify POST vars.";
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
				exit;
			}
	}
?>