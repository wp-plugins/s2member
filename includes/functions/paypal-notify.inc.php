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
Handles PayPal® IPN URL processing.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_paypal_notify"))
	{
		function ws_plugin__s2member_paypal_notify ()
			{
				include_once ABSPATH . "wp-admin/includes/admin.php";
				/**/
				do_action ("ws_plugin__s2member_before_paypal_notify", get_defined_vars ());
				/**/
				if ($_GET["s2member_paypal_notify"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"])
					{
						if (is_array ($paypal = ws_plugin__s2member_paypal_postvars ())) /* Verify PayPal® POST vars. */
							{
								$paypal["s2member_log"][] = "IPN received on: " . date ("D M j, Y g:i:s a T");
								$paypal["s2member_log"][] = "s2Member POST vars verified through a POST back to PayPal®.";
								/**/
								$paypal["custom"] = (!$paypal["custom"]) ? ws_plugin__s2member_paypal_custom ($paypal["recurring_payment_id"]) : $paypal["custom"];
								/* Notifications following the PayPal® Pro format for recurring payments, do NOT carry the "custom" value, so we do a lookup.
									This is only crucial for one IPN call in Standard Integration: `txn_type=recurring_payment_suspended_due_to_max_failed_payment`.
									In Pro Integrations, we just need to make sure the "custom" field is assigned for each account during on-site checkout.
										This way the "custom" value will always be available when it needs to be; for both Standard and Pro services. */
								if (preg_match ("/^" . preg_quote ($_SERVER["HTTP_HOST"], "/") . "/i", $paypal["custom"])) /* Matches originating host? */
									{ /* The business address validation was removed from this routine, because PayPal® always fills that with the primary
											email address. In cases where an alternate PayPal® address is being paid, validation was not possible. */
										$paypal["s2member_log"][] = "s2Member originating domain ( _SERVER[HTTP_HOST] ) validated.";
										/*
										Custom conditionals can be applied by filters.
										*/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										if (!apply_filters ("ws_plugin__s2member_during_paypal_notify_conditionals", false, get_defined_vars ()))
											{
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
												/*
												Specific Post/Page Access.
												*/
												if (preg_match ("/^web_accept$/i", $paypal["txn_type"]) && $paypal["payer_email"] && $paypal["txn_id"] && preg_match ("/^sp\:[0-9,]+\:[0-9]+$/", $paypal["item_number"]))
													{
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_notify_before_sp_access", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
														/**/
														$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept) for Specific Post/Page Access.";
														/**/
														list (, $paypal["sp_ids"], $paypal["hours"]) = preg_split ("/\:/", $paypal["item_number"], 3);
														/**/
														if (($sp_access_url = ws_plugin__s2member_sp_access_link_gen ($paypal["sp_ids"], $paypal["hours"])) && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
															{
																$processing = $during = true; /* Yes, we ARE processing this. */
																/**/
																$sbj = preg_replace ("/%%sp_access_url%%/i", $sp_access_url, $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_email_subject"]);
																$sbj = preg_replace ("/%%sp_access_exp%%/i", ws_plugin__s2member_approx_time_difference (time (), strtotime ("+" . $paypal["hours"] . " hours")), $sbj);
																/**/
																$msg = preg_replace ("/%%sp_access_url%%/i", $sp_access_url, $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_email_message"]);
																$msg = preg_replace ("/%%sp_access_exp%%/i", ws_plugin__s2member_approx_time_difference (time (), strtotime ("+" . $paypal["hours"] . " hours")), $msg);
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
																														@mail ($paypal["payer_email"], $sbj, $msg, "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8");
																														/**/
																														$paypal["s2member_log"][] = "Specific Post/Page Confirmation Email sent to Customer, with a URL that provides Specific Post/Page Access.";
																													}
																/**/
																if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_notification_urls"])
																	{
																		foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_notification_urls"]) as $url)
																			/**/
																			if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%sp_access_url%%/i", rawurlencode ($sp_access_url), $url)))
																				if (($url = preg_replace ("/%%sp_access_exp%%/i", urlencode (ws_plugin__s2member_approx_time_difference (time (), strtotime ("+" . $paypal["hours"] . " hours"))), $url)))
																					if (($url = preg_replace ("/%%amount%%/i", urlencode ($paypal["mc_gross"]), $url)) && ($url = preg_replace ("/%%txn_id%%/i", urlencode ($paypal["txn_id"]), $url)))
																						if (($url = preg_replace ("/%%item_number%%/i", urlencode ($paypal["item_number"]), $url)) && ($url = preg_replace ("/%%item_name%%/i", urlencode ($paypal["item_name"]), $url)))
																							if (($url = preg_replace ("/%%first_name%%/i", urlencode ($paypal["first_name"]), $url)) && ($url = preg_replace ("/%%last_name%%/i", urlencode ($paypal["last_name"]), $url)))
																								if (($url = preg_replace ("/%%full_name%%/i", urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $url)))
																									if (($url = preg_replace ("/%%payer_email%%/i", urlencode ($paypal["payer_email"]), $url)))
																										/**/
																										if (($url = trim ($url))) /* Empty? */
																											ws_plugin__s2member_remote ($url);
																		/**/
																		$paypal["s2member_log"][] = "Specific Post/Page Access Notification URLs have been processed.";
																	}
																/**/
																if ($processing && ($code = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_tracking_codes"]))
																	{
																		if (($code = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $code)) && ($code = preg_replace ("/%%amount%%/i", $paypal["mc_gross"], $code)) && ($code = preg_replace ("/%%txn_id%%/i", $paypal["txn_id"], $code)))
																			if (($code = preg_replace ("/%%item_number%%/i", $paypal["item_number"], $code)) && ($code = preg_replace ("/%%item_name%%/i", $paypal["item_name"], $code)))
																				if (($code = preg_replace ("/%%first_name%%/i", $paypal["first_name"], $code)) && ($code = preg_replace ("/%%last_name%%/i", $paypal["last_name"], $code)))
																					if (($code = preg_replace ("/%%full_name%%/i", trim ($paypal["first_name"] . " " . $paypal["last_name"]), $code)))
																						if (($code = preg_replace ("/%%payer_email%%/i", $paypal["payer_email"], $code)))
																							/**/
																							if (($code = trim ($code))) /* Make sure it is not empty. This gets stored into a Transient Queue. */
																								{
																									$paypal["s2member_log"][] = "Storing Specific Post/Page Tracking Codes into a Transient Queue for s2Member. These will be processed on-site.";
																									set_transient (md5 ("s2member_transient_sp_tracking_codes_" . $paypal["txn_id"]), $code, 43200);
																								}
																	}
																/**/
																eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_during_sp_access", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														else
															{
																$paypal["s2member_log"][] = "Unable to generate Access Link for Specific Post/Page Access. Does your Leading Post/Page still exist?";
															}
														/**/
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_notify_after_sp_access", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
													}
												/*
												New Subscriptions. Possibly containing advanced update vars ( option_name1, option_selection1 ); which allow account modifications.
												*/
												else if (preg_match ("/^(web_accept|subscr_signup)$/i", $paypal["txn_type"]) && $paypal["payer_email"] && ($paypal["subscr_id"] || ($paypal["subscr_id"] = $paypal["txn_id"])) && preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", $paypal["item_number"]))
													{
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_signup", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
														/**/
														$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept|subscr_signup).";
														/**/
														list ($paypal["level"], $paypal["ccaps"], $paypal["eotper"]) = preg_split ("/\:/", $paypal["item_number"], 3);
														/**/
														if (preg_match ("/^web_accept$/i", $paypal["txn_type"])) /* Conversions for Lifetime & Fixed-Term sales. Transform into Subscription. */
															{
																$paypal["period3"] = ($paypal["eotper"]) ? $paypal["eotper"] : "1 L"; /* This defaults to exactly 1 Lifetime. */
																$paypal["mc_amount3"] = $paypal["mc_gross"]; /* The "Buy Now" amount. */
															}
														/**/
														$paypal["initial_term"] = $paypal["period1"] ? $paypal["period1"] : "0 D"; /* Do not allow the initial period to be empty. Defaults to 0 D. */
														$paypal["initial"] = (isset ($paypal["mc_amount1"]) && preg_match ("/^[1-9]/", $paypal["period1"])) ? $paypal["mc_amount1"] : $paypal["mc_amount3"];
														$paypal["regular"] = $paypal["mc_amount3"]; /* This is the regular payment amount that is charged to the customer. Always required by PayPal. */
														$paypal["regular_term"] = $paypal["period3"]; /* This is just set to keep a standard; this way both initial_term & regular_term are available. */
														$paypal["recurring"] = ($paypal["recurring"]) ? $paypal["mc_amount3"] : "0"; /* If non-recurring, this should be zero, otherwise regular. */
														/*
														New Subscription with advanced update vars ( option_name1, option_selection1 ).
														*/
														if (preg_match ("/(updat|upgrad)/i", $paypal["option_name1"]) && $paypal["option_selection1"]) /* This is an advanced way to handle Subscription update modifications. */
															/* This advanced method is required whenever a Subscription that is already completed, or was never setup to recur in the first place needs to be modified. PayPal will not allow the
																		modify=1|2 parameter to be used in those scenarios, because technically there is nothing to update. The only thing that actually needs to be updated is the account. */
															{
																eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_signup_w_update_vars", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept|subscr_signup) w/ update vars.";
																/**/
																/* Check for both the old & new subscr_id's, just in case the Return routine already changed it. */
																if (($user_id = ws_plugin__s2member_paypal_user_id ($paypal["subscr_id"], $paypal["option_selection1"])))
																	{
																		$user = new WP_User ($user_id); /* Acquire user object. */
																		/**/
																		if (!ws_plugin__s2member_user_has_wp_role ($user)) /* Non WP Roles. */
																			{
																				$processing = $during = true; /* Yes, we ARE processing this. */
																				/**/
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
																				if (preg_match ("/^web_accept$/i", $paypal["txn_type"]) && $paypal["eotper"])
																					update_usermeta ($user_id, "s2member_auto_eot_time", ws_plugin__s2member_paypal_auto_eot_time (0, 0, 0, $paypal["eotper"]));
																				else /* Otherwise, we need to clear the eot time. */
																					delete_usermeta ($user_id, "s2member_auto_eot_time");
																				/**/
																				ws_plugin__s2member_clear_user_note_lines ($user_id, "/^Demoted by s2Member\:/");
																				/**/
																				$paypal["s2member_log"][] = "s2Member Level/Capabilities updated w/ advanced update routines.";
																				/**/
																				@mail ($paypal["payer_email"], "Thank You! Your membership has been updated.", "Thank You! Your membership has been updated to:\n" . $paypal["item_name"] . "\n\nYou\\'ll need to log back in now.\n" . wp_login_url (), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8");
																				/**/
																				$paypal["s2member_log"][] = "Modification Confirmation Email sent to Customer, with a URL that provides them with a way to log back in.";
																				/**/
																				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																				do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_signup_w_update_vars", get_defined_vars ());
																				unset ($__refs, $__v); /* Unset defined __refs, __v. */
																			}
																		else
																			{
																				$paypal["s2member_log"][] = "Unable to modify Subscription. The existing User ID has a built-in WP Role. Stopping here. Otherwise, an Administrator/Editor/Author/Contributor could lose access.";
																			}
																	}
																else
																	{
																		$paypal["s2member_log"][] = "Unable to modify Subscription. Could not get the existing User ID from the DB. Please check the on0 and os0 variables in your Button Code.";
																	}
																/**/
																eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_signup_w_update_vars", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/*
														New Subscription. Normal Subscription signup, we are not updating anything for a past Subscription.
														*/
														else /* Else this is a normal Subscription signup, we are not updating anything. */
															{
																eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_signup_wo_update_vars", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept|subscr_signup) w/o update vars.";
																/**/
																if (($registration_url = ws_plugin__s2member_register_link_gen ($paypal["subscr_id"], $paypal["custom"], $paypal["item_number"])) && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																	{
																		$processing = $during = true; /* Yes, we ARE processing this. */
																		/**/
																		$sbj = preg_replace ("/%%registration_url%%/i", $registration_url, $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_email_subject"]);
																		$msg = preg_replace ("/%%registration_url%%/i", $registration_url, $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_email_message"]);
																		/**/
																		if (($sbj = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $sbj)) && ($sbj = preg_replace ("/%%subscr_id%%/i", $paypal["subscr_id"], $sbj)))
																			if (($sbj = preg_replace ("/%%initial%%/i", $paypal["initial"], $sbj)) && ($sbj = preg_replace ("/%%regular%%/i", $paypal["regular"], $sbj)) && ($sbj = preg_replace ("/%%recurring%%/i", $paypal["recurring"], $sbj)))
																				if (($sbj = preg_replace ("/%%initial_term%%/i", $paypal["initial_term"], $sbj)) && ($sbj = preg_replace ("/%%regular_term%%/i", $paypal["regular_term"], $sbj)))
																					if (($sbj = preg_replace ("/%%item_number%%/i", $paypal["item_number"], $sbj)) && ($sbj = preg_replace ("/%%item_name%%/i", $paypal["item_name"], $sbj)))
																						if (($sbj = preg_replace ("/%%first_name%%/i", $paypal["first_name"], $sbj)) && ($sbj = preg_replace ("/%%last_name%%/i", $paypal["last_name"], $sbj)))
																							if (($sbj = preg_replace ("/%%full_name%%/i", trim ($paypal["first_name"] . " " . $paypal["last_name"]), $sbj)))
																								if (($sbj = preg_replace ("/%%payer_email%%/i", $paypal["payer_email"], $sbj)))
																									/**/
																									if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%subscr_id%%/i", $paypal["subscr_id"], $msg)))
																										if (($msg = preg_replace ("/%%initial%%/i", $paypal["initial"], $msg)) && ($msg = preg_replace ("/%%regular%%/i", $paypal["regular"], $msg)) && ($msg = preg_replace ("/%%recurring%%/i", $paypal["recurring"], $msg)))
																											if (($msg = preg_replace ("/%%initial_term%%/i", $paypal["initial_term"], $msg)) && ($msg = preg_replace ("/%%regular_term%%/i", $paypal["regular_term"], $msg)))
																												if (($msg = preg_replace ("/%%item_number%%/i", $paypal["item_number"], $msg)) && ($msg = preg_replace ("/%%item_name%%/i", $paypal["item_name"], $msg)))
																													if (($msg = preg_replace ("/%%first_name%%/i", $paypal["first_name"], $msg)) && ($msg = preg_replace ("/%%last_name%%/i", $paypal["last_name"], $msg)))
																														if (($msg = preg_replace ("/%%full_name%%/i", trim ($paypal["first_name"] . " " . $paypal["last_name"]), $msg)))
																															if (($msg = preg_replace ("/%%payer_email%%/i", $paypal["payer_email"], $msg)))
																																/**/
																																if (($sbj = trim ($sbj)) && ($msg = trim ($msg))) /* Make sure they are not empty. */
																																	{
																																		@mail ($paypal["payer_email"], $sbj, $msg, "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8");
																																		/**/
																																		$paypal["s2member_log"][] = "Signup Confirmation Email sent to Customer, with a URL to assist w/ registration.";
																																	}
																		/**/
																		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																		do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_signup_wo_update_vars", get_defined_vars ());
																		unset ($__refs, $__v); /* Unset defined __refs, __v. */
																	}
																/**/
																eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_signup_wo_update_vars", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/**/
														if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
															{
																foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_notification_urls"]) as $url)
																	/**/
																	if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", urlencode ($paypal["subscr_id"]), $url)))
																		if (($url = preg_replace ("/%%initial%%/i", urlencode ($paypal["initial"]), $url)) && ($url = preg_replace ("/%%regular%%/i", urlencode ($paypal["regular"]), $url)) && ($url = preg_replace ("/%%recurring%%/i", urlencode ($paypal["recurring"]), $url)))
																			if (($url = preg_replace ("/%%initial_term%%/i", urlencode ($paypal["initial_term"]), $url)) && ($url = preg_replace ("/%%regular_term%%/i", urlencode ($paypal["regular_term"]), $url)))
																				if (($url = preg_replace ("/%%item_number%%/i", urlencode ($paypal["item_number"]), $url)) && ($url = preg_replace ("/%%item_name%%/i", urlencode ($paypal["item_name"]), $url)))
																					if (($url = preg_replace ("/%%first_name%%/i", urlencode ($paypal["first_name"]), $url)) && ($url = preg_replace ("/%%last_name%%/i", urlencode ($paypal["last_name"]), $url)))
																						if (($url = preg_replace ("/%%full_name%%/i", urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $url)))
																							if (($url = preg_replace ("/%%payer_email%%/i", urlencode ($paypal["payer_email"]), $url)))
																								/**/
																								if (($url = trim ($url))) /* Empty? */
																									ws_plugin__s2member_remote ($url);
																/**/
																$paypal["s2member_log"][] = "Signup Notification URLs have been processed.";
															}
														/**/
														if ($processing && ($code = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_tracking_codes"]) && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
															{
																if (($code = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $code)) && ($code = preg_replace ("/%%subscr_id%%/i", $paypal["subscr_id"], $code)))
																	if (($code = preg_replace ("/%%initial%%/i", $paypal["initial"], $code)) && ($code = preg_replace ("/%%regular%%/i", $paypal["regular"], $code)) && ($code = preg_replace ("/%%recurring%%/i", $paypal["recurring"], $code)))
																		if (($code = preg_replace ("/%%initial_term%%/i", $paypal["initial_term"], $code)) && ($code = preg_replace ("/%%regular_term%%/i", $paypal["regular_term"], $code)))
																			if (($code = preg_replace ("/%%item_number%%/i", $paypal["item_number"], $code)) && ($code = preg_replace ("/%%item_name%%/i", $paypal["item_name"], $code)))
																				if (($code = preg_replace ("/%%first_name%%/i", $paypal["first_name"], $code)) && ($code = preg_replace ("/%%last_name%%/i", $paypal["last_name"], $code)))
																					if (($code = preg_replace ("/%%full_name%%/i", trim ($paypal["first_name"] . " " . $paypal["last_name"]), $code)))
																						if (($code = preg_replace ("/%%payer_email%%/i", $paypal["payer_email"], $code)))
																							/**/
																							if (($code = trim ($code))) /* Make sure it is not empty. This gets stored into a Transient Queue. */
																								{
																									$paypal["s2member_log"][] = "Storing Signup Tracking Codes into a Transient Queue for s2Member. These will be processed on-site.";
																									set_transient (md5 ("s2member_transient_signup_tracking_codes_" . $paypal["subscr_id"]), $code, 43200);
																								}
															}
														/**/
														if ($processing && preg_match ("/^web_accept$/i", $paypal["txn_type"]) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
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
																							if (($url = trim ($url))) /* Empty? */
																								ws_plugin__s2member_remote ($url);
																/**/
																$paypal["s2member_log"][] = "Payment Notification URLs have been processed.";
															}
														/**/
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_signup", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
													}
												/*
												Subscription modifications.
												*/
												else if (preg_match ("/^subscr_modify$/i", $paypal["txn_type"]) && $paypal["payer_email"] && $paypal["subscr_id"] && preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", $paypal["item_number"]))
													{
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_modify", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
														/**/
														$paypal["s2member_log"][] = "s2Member txn_type identified as subscr_modify.";
														/**/
														list ($paypal["level"], $paypal["ccaps"]) = preg_split ("/\:/", $paypal["item_number"], 2);
														/**/
														if (($user_id = ws_plugin__s2member_paypal_user_id ($paypal["subscr_id"])))
															{
																$user = new WP_User ($user_id); /* Acquire user object. */
																/**/
																if (!ws_plugin__s2member_user_has_wp_role ($user)) /* Non WP Roles. */
																	{
																		$processing = $during = true; /* Yes, we ARE processing this. */
																		/**/
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
																		delete_usermeta ($user_id, "s2member_auto_eot_time");
																		/**/
																		ws_plugin__s2member_clear_user_note_lines ($user_id, "/^Demoted by s2Member\:/");
																		/**/
																		$paypal["s2member_log"][] = "s2Member Level/Capabilities updated on Subscription modification.";
																		/**/
																		@mail ($paypal["payer_email"], "Thank You! Your membership has been updated.", "Thank You! Your membership has been updated to:\n" . $paypal["item_name"] . "\n\nYou\\'ll need to log back in now.\n" . wp_login_url (), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8");
																		/**/
																		$paypal["s2member_log"][] = "Modification Confirmation Email sent to Customer, with a URL that provides them with a way to log back in.";
																		/**/
																		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																		do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_modify", get_defined_vars ());
																		unset ($__refs, $__v); /* Unset defined __refs, __v. */
																	}
																else
																	{
																		$paypal["s2member_log"][] = "Unable to modify Subscription. The existing User ID has a built-in WP Role. Stopping here. Otherwise, an Administrator/Editor/Author/Contributor could lose access.";
																	}
															}
														else
															{
																$paypal["s2member_log"][] = "Unable to modify Subscription. Could not get the existing User ID from the DB.";
															}
														/**/
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_modify", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
													}
												/*
												Subscription payments.
												*/
												else if (preg_match ("/^subscr_payment$/i", $paypal["txn_type"]) && $paypal["payer_email"] && $paypal["subscr_id"] && preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", $paypal["item_number"]) && $paypal["txn_id"] && $paypal["mc_gross"])
													{
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_payment", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
														/**/
														$paypal["s2member_log"][] = "s2Member txn_type identified as subscr_payment.";
														$paypal["s2member_log"][] = "Sleeping for 2 seconds. Waiting for a possible subscr_signup|subscr_modify.";
														sleep (2); /* Sleep here for a moment. PayPal® sometimes sends a subscr_payment before the subscr_signup, subscr_modify.
														It is NOT a big deal if they do. However, s2Member goes to sleep here, just to help keep the log files in a logical order. */
														$paypal["s2member_log"][] = "Awake. It's " . date ("D M j, Y g:i:s a T") . ". s2Member txn_type identified as subscr_payment.";
														/**/
														list ($paypal["level"], $paypal["ccaps"]) = preg_split ("/\:/", $paypal["item_number"], 2);
														/**/
														if (($user_id = ws_plugin__s2member_paypal_user_id ($paypal["subscr_id"], $paypal["option_selection1"])))
															{
																$processing = $during = true; /* Yes, we ARE processing this. */
																/**/
																update_usermeta ($user_id, "s2member_last_payment_time", time ());
																/**/
																$paypal["s2member_log"][] = "Updated Last Payment Time for this Member.";
																/**/
																if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
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
																									if (($url = trim ($url))) /* Empty? */
																										ws_plugin__s2member_remote ($url);
																		/**/
																		$paypal["s2member_log"][] = "Payment Notification URLs have been processed.";
																	}
																/**/
																eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_payment", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														else
															{
																$paypal["s2member_log"][] = "Skipping this IPN response, for now. The Subscr. ID is not associated with a registered Member.";
																$paypal["s2member_log"][] = "Storing this IPN response into a Transient Queue for s2Member. This will be re-processed when registration occurs.";
																set_transient (md5 ("s2member_transient_ipn_subscr_payment_" . $paypal["subscr_id"]), $_POST, 43200);
															}
														/**/
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_payment", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
													}
												/*
												Subscription cancellations. s2Member can use this, to determine when/if it should Auto-EOT (demote|delete) a Member's account.
													The IPN for `subscr_cancel` is compatible with newer PayPal® accounts that do NOT send a subscr_eot when an account is cancelled.
													This works in conjunction with `s2member_last_payment_time`, and the s2Member Auto-EOT System.
													For further details & stupidity, see: https://www.x.com/thread/41155?start=15&tstart=0
												*/
												else if (preg_match ("/^subscr_cancel$/i", $paypal["txn_type"]) && $paypal["payer_email"] && $paypal["subscr_id"] && preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", $paypal["item_number"]))
													{
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_cancel", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
														/**/
														$paypal["s2member_log"][] = "s2Member txn_type identified as subscr_cancel.";
														/**/
														list ($paypal["level"], $paypal["ccaps"]) = preg_split ("/\:/", $paypal["item_number"], 2);
														/**/
														if (($user_id = ws_plugin__s2member_paypal_user_id ($paypal["subscr_id"])))
															{
																if (!get_usermeta ($user_id, "s2member_auto_eot_time")) /* Respect existing. */
																	{
																		$processing = $during = true; /* Yes, we ARE processing this. */
																		/**/
																		$auto_eot_time = ws_plugin__s2member_paypal_auto_eot_time ($user_id, $paypal["period1"], $paypal["period3"]);
																		/**/
																		update_usermeta ($user_id, "s2member_auto_eot_time", $auto_eot_time); /* s2Member will follow-up on this later. */
																		/**/
																		$paypal["s2member_log"][] = "Auto-EOT Time for this account: " . date ("D M j, Y g:i a T", $auto_eot_time);
																		/**/
																		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																		do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_cancel", get_defined_vars ());
																		unset ($__refs, $__v); /* Unset defined __refs, __v. */
																	}
																else
																	{
																		$paypal["s2member_log"][] = "Ignoring Cancellation. An Auto-EOT Time is already set for this Member.";
																	}
															}
														else
															{
																$paypal["s2member_log"][] = "Unable to handle Cancellation. Could not get the existing User ID from the DB.";
															}
														/**/
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_cancel", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
													}
												/*
												Subscription terminations, max failed payments, initial payment failed, chargebacks, refunds, and reversals. *** NOT processed for Specific Posts/Pages. */
												else if ( /* An immediate EOT is necessary under MANY different conditions. This consolidates them all, with a sub-classification for refunds/reversals. */
												(preg_match ("/^(subscr_eot|recurring_payment_expired|recurring_payment_suspended_due_to_max_failed_payment)$/i", $paypal["txn_type"]) || (preg_match ("/^recurring_payment_profile_cancel$/i", $paypal["txn_type"]) && preg_match ("/^failed$/i", $paypal["initial_payment_status"])) || (preg_match ("/^new_case$/i", $paypal["txn_type"]) && preg_match ("/^chargeback$/i", $paypal["case_type"])) || (!$paypal["txn_type"] && preg_match ("/^(refunded|reversed)$/i", $paypal["payment_status"])))/**/
												&& ($paypal["subscr_id"] || ($paypal["subscr_id"] = $paypal["recurring_payment_id"]) || ($paypal["subscr_id"] = $paypal["parent_txn_id"]))/**/
												&& (preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", $paypal["item_number"]) || $paypal["recurring_payment_id"])/**/)
													{
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_eot", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
														/**/
														$paypal["s2member_log"][] = "s2Member txn_type identified as (subscr_eot|recurring_payment_expired|recurring_payment_suspended_due_to_max_failed_payment) - or - initial_payment_status (failed) - or - case_type (chargeback) - or - payment_status (refunded|reversed).";
														/**/
														if (($user_id = ws_plugin__s2member_paypal_user_id ($paypal["subscr_id"], $paypal["option_selection1"])))
															{
																if (!get_usermeta ($user_id, "s2member_auto_eot_time")) /* Respect Auto-EOT. */
																	{
																		$user = new WP_User ($user_id); /* Acquire user object. */
																		/**/
																		if (!ws_plugin__s2member_user_has_wp_role ($user)) /* Non WP Roles. */
																			{
																				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["auto_eot_system_enabled"]) /* EOT enabled? */
																					{
																						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_eot_behavior"] === "demote")
																							{
																								$processing = $during = true; /* Yes, we ARE processing this. */
																								/**/
																								$user->set_role ("subscriber");
																								/**/
																								delete_usermeta ($user_id, "s2member_custom");
																								delete_usermeta ($user_id, "s2member_subscr_id");
																								delete_usermeta ($user_id, "s2member_last_payment_time");
																								delete_usermeta ($user_id, "s2member_auto_eot_time");
																								/**/
																								foreach ($user->allcaps as $cap => $cap_enabled)
																									if (preg_match ("/^access_s2member_ccap_/", $cap))
																										$user->remove_cap ($ccap = $cap);
																								/**/
																								delete_usermeta ($user_id, "s2member_file_download_access_arc");
																								delete_usermeta ($user_id, "s2member_file_download_access_log");
																								/**/
																								ws_plugin__s2member_append_user_notes ($user_id, "Demoted by s2Member: " . date ("D M j, Y g:i a T"));
																								/**/
																								$paypal["s2member_log"][] = "Member Level/Capabilities demoted to a Free Subscriber.";
																								/**/
																								if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																									{
																										foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"]) as $url) /* Handle eot notifications. */
																											/**/
																											if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", urlencode ($paypal["subscr_id"]), $url)))
																												if (($url = preg_replace ("/%%user_first_name%%/i", urlencode ($user->first_name), $url)) && ($url = preg_replace ("/%%user_last_name%%/i", urlencode ($user->last_name), $url)))
																													if (($url = preg_replace ("/%%user_full_name%%/i", urlencode (trim ($user->first_name . " " . $user->last_name)), $url)))
																														if (($url = preg_replace ("/%%user_email%%/i", urlencode ($user->user_email), $url)))
																															/**/
																															if (($url = trim ($url))) /* Empty? */
																																ws_plugin__s2member_remote ($url);
																										/**/
																										$paypal["s2member_log"][] = "EOT/Deletion Notification URLs have been processed.";
																									}
																								/**/
																								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																								do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_eot_demote", get_defined_vars ());
																								unset ($__refs, $__v); /* Unset defined __refs, __v. */
																							}
																						else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_eot_behavior"] === "delete")
																							{
																								$processing = $during = true; /* Yes, we ARE processing this. */
																								/**/
																								wp_delete_user ($user_id); /* Triggers: `ws_plugin__s2member_handle_user_deletions()` */
																								/* `ws_plugin__s2member_handle_user_deletions()` triggers `eot_del_notification_urls` */
																								/**/
																								$paypal["s2member_log"][] = "The Member's account has been deleted completely.";
																								/**/
																								$paypal["s2member_log"][] = "EOT/Deletion Notification URLs have been processed.";
																								/**/
																								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																								do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_eot_delete", get_defined_vars ());
																								unset ($__refs, $__v); /* Unset defined __refs, __v. */
																							}
																						/**/
																						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																						do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_eot", get_defined_vars ());
																						unset ($__refs, $__v); /* Unset defined __refs, __v. */
																					}
																				/**/
																				else /* Otherwise, treat this as if it were a cancellation. EOTs are currently disabled. */
																					{
																						$processing = $during = true; /* Yes, we ARE processing this. */
																						/**/
																						update_usermeta ($user_id, "s2member_auto_eot_time", ($auto_eot_time = strtotime ("now")));
																						/**/
																						$paypal["s2member_log"][] = "Auto-EOT is currently disabled. Skipping immediate EOT (demote|delete), for now.";
																						$paypal["s2member_log"][] = "Recording the Auto-EOT Time for this Member's account: " . date ("D M j, Y g:i a T", $auto_eot_time);
																						/**/
																						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																						do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_eot_disabled", get_defined_vars ());
																						unset ($__refs, $__v); /* Unset defined __refs, __v. */
																					}
																			}
																		else
																			{
																				$paypal["s2member_log"][] = "Unable to (demote|delete) Member. The existing User ID has a built-in WP Role. Stopping here. Otherwise, an Administrator/Editor/Author/Contributor could lose access.";
																			}
																	}
																else
																	{
																		$paypal["s2member_log"][] = "Skipping (demote|delete) Member, for now. An Auto-EOT Time is already set. When an Auto-EOT Time has been recorded, s2Member will handle EOT (demote|delete) events using it's own Auto-EOT System.";
																	}
															}
														else
															{
																$paypal["s2member_log"][] = "Unable to (demote|delete) Member. Could not get the existing User ID from the DB. It's possible that it was already removed manually by a Site Administrator, or by s2Member's Auto-EOT System.";
															}
														/*
														Refunds and chargeback reversals. This is excluded from the processing check, because a Member *could* have already been (demoted|deleted).
														In other words, s2Member sends `Refund/Reversal` Notifications ANYTIME a Refund/Reversal occurs; even if s2Member did not process it otherwise.
														Since this routine ignores the processing check, it is *possible* that Refund/Reversal Notification URLs will be contacted more than once.
															If you are writing scripts that depend on Refund/Reversal Notifications, please keep this in mind.
														*/
														if (!$paypal["txn_type"] && preg_match ("/^(refunded|reversed)$/i", $paypal["payment_status"]) && $paypal["parent_txn_id"])
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
																									if (($url = trim ($url))) /* Empty? */
																										ws_plugin__s2member_remote ($url);
																		/**/
																		$paypal["s2member_log"][] = "Refund/Reversal Notification URLs have been processed.";
																	}
																/**/
																eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_eot_refund_reversal", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/**/
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_eot", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
													}
												else
													{
														$paypal["s2member_log"][] = "Properly ignoring this IPN request. The txn_type does not require any action on the part of s2Member.";
													}
											}
										else /* Else a custom conditional has been applied by filters. */
											unset ($__refs, $__v); /* Unset defined __refs, __v. */
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
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_paypal_notify", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						exit;
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_paypal_notify", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
			}
	}
?>