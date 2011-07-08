<?php
/**
* s2Member's PayPal® IPN handler ( inner processing routines ).
*
* Copyright: © 2009-2011
* {@link http://www.websharks-inc.com/ WebSharks, Inc.}
* ( coded in the USA )
*
* Released under the terms of the GNU General Public License.
* You should have received a copy of the GNU General Public License,
* along with this software. In the main directory, see: /licensing/
* If not, see: {@link http://www.gnu.org/licenses/}.
*
* @package s2Member\PayPal
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_paypal_notify_in"))
	{
		/**
		* s2Member's PayPal® IPN handler ( inner processing routines ).
		*
		* @package s2Member\PayPal
		* @since 3.5
		*/
		class c_ws_plugin__s2member_paypal_notify_in
			{
				/**
				* Handles PayPal® IPN processing.
				*
				* These same routines also handle s2Member Pro/PayPal® Pro operations;
				* giving you the ability *( as needed )* to Hook into these routines using
				* WordPress® Hooks/Filters; as seen in the source code below.
				*
				* Please do NOT modify the source code directly.
				* Instead, use WordPress® Hooks/Filters.
				*
				* For example, if you'd like to add your own custom conditionals, use:
				* ``add_filter ("ws_plugin__s2member_during_paypal_notify_conditionals", "your_function");``
				*
				* @package s2Member\PayPal
				* @since 3.5
				*
				* @attaches-to: ``add_action("init");``
				*
				* @return null Or exits script execution after handling IPN procesing.
				*
				* @todo Break this HUGE routine apart into logical class methods.
				* @todo Optimize with ``empty()`` and ``isset()``.
				*/
				public static function paypal_notify ()
					{
						global $current_site, $current_blog; /* For Multisite support. */
						/**/
						do_action ("ws_plugin__s2member_before_paypal_notify", get_defined_vars ());
						/**/
						if (!empty ($_GET["s2member_paypal_notify"]) && ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"] || $_GET["s2member_paypal_proxy"]))
							{
								@ignore_user_abort(true); /* Important. Continue processing even if/when the connection is broken by the sending party. */
								/**/
								include_once ABSPATH . "wp-admin/includes/admin.php"; /* Get administrative functions. Needed for `wp_delete_user()`. */
								/**/
								c_ws_plugin__s2member_email_configs::email_config_release (); /* Release Filters on wp_mail() / From: headers. */
								/**/
								if (is_array ($paypal = c_ws_plugin__s2member_paypal_utilities::paypal_postvars ()) && ($_paypal = $paypal))
									{
										$paypal["s2member_log"][] = "IPN received on: " . date ("D M j, Y g:i:s a T");
										$paypal["s2member_log"][] = "s2Member POST vars verified " . (($paypal["proxy_verified"]) ? "with a Proxy Key" : "through a POST back to PayPal®.");
										/**/
										$payment_status_issues = "/^(failed|denied|expired|refunded|partially_refunded|reversed|reversal|canceled_reversal|voided)$/i";
										/**/
										$paypal["subscr_gateway"] = ($_GET["s2member_paypal_proxy"]) ? $_GET["s2member_paypal_proxy"] : "paypal"; /* Defaults to: `paypal`. */
										/**/
										$paypal["custom"] = (!$paypal["custom"]) ? c_ws_plugin__s2member_utils_users::get_user_custom_with ($paypal["recurring_payment_id"]) : $paypal["custom"];
										/* Notifications following the PayPal® Pro format for Recurring Payments, do NOT carry the "custom" value, so we have to do a lookup.
											This is only crucial for one IPN call in Standard Integration: `txn_type=recurring_payment_suspended_due_to_max_failed_payment`.
											In Pro Integrations, we just need to make sure the "custom" field is assigned for each account during on-site checkout.
												This way the "custom" value will always be available when it needs to be; for both Standard and Pro services. */
										if (preg_match ("/^" . preg_quote (preg_replace ("/\:([0-9]+)$/", "", $_SERVER["HTTP_HOST"]), "/") . "/i", $paypal["custom"]))
											{ /* The business address validation was removed from this routine, because PayPal® always fills that with the primary
													email address. In cases where an alternate PayPal® address is being paid, validation was not possible. */
												$paypal["s2member_log"][] = "s2Member originating domain ( _SERVER[HTTP_HOST] ) validated.";
												/*
												Custom conditionals can be applied by Filters.
												*/
												eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												if (!apply_filters ("ws_plugin__s2member_during_paypal_notify_conditionals", false, get_defined_vars ()))
													{
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
														/*
														Virtual Terminal transactions.
														This is not really necessary. It is only here because this txn_type could
														be necessary in a future release of s2Member. For now, it's just a fill-in.
														These Hooks/Filters will remain, so you can use them now; if you need to.
														*/
														if (/**/(preg_match ("/^virtual_terminal$/i", $paypal["txn_type"]))/**/
														&& (!preg_match ($payment_status_issues, $paypal["payment_status"]))/**/
														&& ($paypal["txn_id"])/**/)
															{
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_before_virtual_terminal", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "s2Member txn_type identified as virtual_terminal.";
																/**/
																$processing = $during = true; /* Yes, we ARE processing this. */
																/**/
																$paypal["s2member_log"][] = "The txn_type does not require any action on the part of s2Member.";
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_during_virtual_terminal", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_after_virtual_terminal", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/*
														Express Checkout transactions.
														This is not really necessary. It is only here because this txn_type could
														be necessary in a future release of s2Member. For now, it's just a fill-in.
														These Hooks/Filters will remain, so you can use them now; if you need to.
														*/
														else if (/**/(preg_match ("/^express_checkout$/i", $paypal["txn_type"]))/**/
														&& (!preg_match ($payment_status_issues, $paypal["payment_status"]))/**/
														&& ($paypal["txn_id"])/**/)
															{
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_before_express_checkout", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "s2Member txn_type identified as express_checkout.";
																/**/
																$processing = $during = true; /* Yes, we ARE processing this. */
																/**/
																$paypal["s2member_log"][] = "The txn_type does not require any action on the part of s2Member.";
																$paypal["s2member_log"][] = "s2Member Pro handles Express Checkout events on-site, with an IPN proxy.";
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_during_express_checkout", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_after_express_checkout", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/*
														Cart ( Line Item ) transactions.
														This is not really necessary. It is only here because this txn_type could
														be necessary in a future release of s2Member. For now, it's just a fill-in.
														These Hooks/Filters will remain, so you can use them now; if you need to.
														*/
														else if (/**/(preg_match ("/^cart$/i", $paypal["txn_type"]))/**/
														&& (!preg_match ($payment_status_issues, $paypal["payment_status"]))/**/
														&& ($paypal["txn_id"])/**/)
															{
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_before_cart", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "s2Member txn_type identified as cart.";
																/**/
																$processing = $during = true; /* Yes, we ARE processing this. */
																/**/
																$paypal["s2member_log"][] = "The txn_type does not require any action on the part of s2Member.";
																$paypal["s2member_log"][] = "s2Member Pro handles Cart events on-site, with an IPN proxy.";
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_during_cart", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_after_cart", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/*
														Send Money / Mobile transactions.
														This is not really necessary. It is only here because this txn_type could
														be necessary in a future release of s2Member. For now, it's just a fill-in.
														These Hooks/Filters will remain, so you can use them now; if you need to.
														*/
														else if (/**/(preg_match ("/^send_money$/i", $paypal["txn_type"]))/**/
														&& (!preg_match ($payment_status_issues, $paypal["payment_status"]))/**/
														&& ($paypal["txn_id"])/**/)
															{
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_before_send_money", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "s2Member txn_type identified as send_money.";
																/**/
																$processing = $during = true; /* Yes, we ARE processing this. */
																/**/
																$paypal["s2member_log"][] = "The txn_type does not require any action on the part of s2Member.";
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_during_send_money", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_after_send_money", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/*
														Specific Post/Page Access ~ Sales.
														*/
														else if (/**/(preg_match ("/^web_accept$/i", $paypal["txn_type"]))/**/
														&& (preg_match ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["sp_access_item_number_regex"], $paypal["item_number"]))/**/
														&& (!preg_match ($payment_status_issues, $paypal["payment_status"]))/**/
														&& ($paypal["payer_email"] && $paypal["txn_id"])/**/)
															{
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_before_sp_access", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept) for Specific Post/Page Access.";
																/**/
																list (, $paypal["sp_ids"], $paypal["hours"]) = preg_split ("/\:/", $paypal["item_number"], 3);
																/**/
																$paypal["ip"] = (preg_match ("/ip address/i", $paypal["option_name2"]) && $paypal["option_selection2"]) ? $paypal["option_selection2"] : "";
																$paypal["ip"] = (!$paypal["ip"] && preg_match ("/^[0-9]+~[0-9\.]+$/", $paypal["invoice"])) ? preg_replace ("/^[0-9]+~/", "", $paypal["invoice"]) : $paypal["ip"];
																/**/
																if (($sp_access_url = c_ws_plugin__s2member_sp_access::sp_access_link_gen ($paypal["sp_ids"], $paypal["hours"])) && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																	{
																		$processing = $during = true; /* Yes, we ARE processing this. */
																		/**/
																		if (preg_match ("/(referenc|associat)/i", $paypal["option_name1"]) && $paypal["option_selection1"]) /* Associating this purchase with a Member? */
																			if (($user_id = c_ws_plugin__s2member_utils_users::get_user_id_with ($paypal["option_selection1"], $paypal["option_selection1"])) && is_object ($user = new WP_User ($user_id)) && $user->ID)
																				{
																					$sp_references = (array)get_user_option ("s2member_sp_references", $user_id);
																					$_sp_reference = array ("time" => time (), "ids" => $paypal["sp_ids"], "hours" => $paypal["hours"], "url" => $sp_access_url);
																					$sp_references = c_ws_plugin__s2member_utils_arrays::array_unique (array_merge ($sp_references, $_sp_reference));
																					update_user_option ($user_id, "s2member_sp_references", $sp_references);
																					/**/
																					$paypal["s2member_log"][] = "Specific Post/Page ~ Sale associated with User ID: " . $user_id . ".";
																				}
																		/**/
																		$sbj = preg_replace ("/%%sp_access_url%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($sp_access_url), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"][(($_GET["s2member_paypal_proxy"] && preg_match ("/pro-emails/", $_GET["s2member_paypal_proxy_use"])) ? "pro_" : "") . "sp_email_subject"]);
																		$sbj = preg_replace ("/%%sp_access_exp%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (c_ws_plugin__s2member_utils_time::approx_time_difference (time (), strtotime ("+" . $paypal["hours"] . " hours"))), $sbj);
																		/**/
																		$msg = preg_replace ("/%%sp_access_url%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($sp_access_url), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"][(($_GET["s2member_paypal_proxy"] && preg_match ("/pro-emails/", $_GET["s2member_paypal_proxy_use"])) ? "pro_" : "") . "sp_email_message"]);
																		$msg = preg_replace ("/%%sp_access_exp%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (c_ws_plugin__s2member_utils_time::approx_time_difference (time (), strtotime ("+" . $paypal["hours"] . " hours"))), $msg);
																		/**/
																		$rec = preg_replace ("/%%sp_access_url%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($sp_access_url), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"][(($_GET["s2member_paypal_proxy"] && preg_match ("/pro-emails/", $_GET["s2member_paypal_proxy_use"])) ? "pro_" : "") . "sp_email_recipients"]);
																		$rec = preg_replace ("/%%sp_access_exp%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (c_ws_plugin__s2member_utils_time::approx_time_difference (time (), strtotime ("+" . $paypal["hours"] . " hours"))), $rec);
																		/**/
																		if (($rec = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $rec)) && ($rec = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["txn_id"]), $rec)))
																			if (($rec = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_gross"]), $rec))) /* Full amount of the payment, before fee is subtracted. */
																				if (($rec = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $rec)) && ($rec = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $rec)))
																					if (($rec = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_dq (c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"])), $rec)) && ($rec = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_dq (c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"])), $rec)))
																						if (($rec = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_dq (c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $rec))) /* **NOTE** c_ws_plugin__s2member_utils_strings::esc_dq() is applied here. ( ex. "N\"ame" <email> ). */
																							if (($rec = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $rec)))
																								if (($rec = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $rec)))
																									/**/
																									if (($sbj = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $sbj)) && ($sbj = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["txn_id"]), $sbj)))
																										if (($sbj = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_gross"]), $sbj))) /* Full amount of the payment, before fee is subtracted. */
																											if (($sbj = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $sbj)) && ($sbj = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $sbj)))
																												if (($sbj = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $sbj)) && ($sbj = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $sbj)))
																													if (($sbj = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $sbj)))
																														if (($sbj = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $sbj)))
																															if (($sbj = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $sbj)))
																																/**/
																																if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["txn_id"]), $msg)))
																																	if (($msg = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_gross"]), $msg))) /* Full amount of the payment, before fee is subtracted. */
																																		if (($msg = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $msg)) && ($msg = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $msg)))
																																			if (($msg = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $msg)) && ($msg = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $msg)))
																																				if (($msg = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $msg)))
																																					if (($msg = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $msg)))
																																						if (($msg = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $msg)))
																																							/**/
																																							if (($recipients = preg_split ("/;+/", preg_replace ("/%%(.+?)%%/i", "", $rec))) && ($sbj = trim (preg_replace ("/%%(.+?)%%/i", "", $sbj))) && ($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																																								{
																																									foreach (c_ws_plugin__s2member_utils_strings::trim_deep ($recipients) as $recipient) /* Go through the full list of recipients. */
																																										($recipient) ? wp_mail ($recipient, apply_filters ("ws_plugin__s2member_sp_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_sp_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") : null;
																																									/**/
																																									$paypal["s2member_log"][] = "Specific Post/Page Confirmation Email sent to: " . implode ("; ", $recipients) . ".";
																																								}
																		/**/
																		if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_sale_notification_urls"])
																			{
																				foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_sale_notification_urls"]) as $url)
																					/**/
																					if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%sp_access_url%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (rawurlencode ($sp_access_url)), $url)))
																						if (($url = preg_replace ("/%%sp_access_exp%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (c_ws_plugin__s2member_utils_time::approx_time_difference (time (), strtotime ("+" . $paypal["hours"] . " hours")))), $url)))
																							if (($url = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["mc_gross"])), $url)) && ($url = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["txn_id"])), $url)))
																								if (($url = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_number"])), $url)) && ($url = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_name"])), $url)))
																									if (($url = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["first_name"])), $url)) && ($url = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["last_name"])), $url)))
																										if (($url = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $url)))
																											if (($url = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["payer_email"])), $url)))
																												if (($url = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["ip"])), $url)))
																													/**/
																													if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																														c_ws_plugin__s2member_utils_urls::remote ($url);
																				/**/
																				$paypal["s2member_log"][] = "Specific Post/Page ~ Sale Notification URLs have been processed.";
																			}
																		/**/
																		if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_sale_notification_recipients"])
																			{
																				$msg = $sbj = "( s2Member / API Notification Email ) - Specific Post/Page ~ Sale";
																				$msg .= "\n\n"; /* Spacing in the message body. */
																				/**/
																				$msg .= "sp_access_url: %%sp_access_url%%\n";
																				$msg .= "sp_access_exp: %%sp_access_exp%%\n";
																				$msg .= "amount: %%amount%%\n";
																				$msg .= "txn_id: %%txn_id%%\n";
																				$msg .= "item_number: %%item_number%%\n";
																				$msg .= "item_name: %%item_name%%\n";
																				$msg .= "first_name: %%first_name%%\n";
																				$msg .= "last_name: %%last_name%%\n";
																				$msg .= "full_name: %%full_name%%\n";
																				$msg .= "payer_email: %%payer_email%%\n";
																				$msg .= "user_ip: %%user_ip%%\n";
																				/**/
																				$msg .= "cv0: %%cv0%%\n";
																				$msg .= "cv1: %%cv1%%\n";
																				$msg .= "cv2: %%cv2%%\n";
																				$msg .= "cv3: %%cv3%%\n";
																				$msg .= "cv4: %%cv4%%\n";
																				$msg .= "cv5: %%cv5%%\n";
																				$msg .= "cv6: %%cv6%%\n";
																				$msg .= "cv7: %%cv7%%\n";
																				$msg .= "cv8: %%cv8%%\n";
																				$msg .= "cv9: %%cv9%%";
																				/**/
																				if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%sp_access_url%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($sp_access_url), $msg)))
																					if (($msg = preg_replace ("/%%sp_access_exp%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (c_ws_plugin__s2member_utils_time::approx_time_difference (time (), strtotime ("+" . $paypal["hours"] . " hours"))), $msg)))
																						if (($msg = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_gross"]), $msg)) && ($msg = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["txn_id"]), $msg)))
																							if (($msg = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $msg)) && ($msg = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $msg)))
																								if (($msg = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $msg)) && ($msg = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $msg)))
																									if (($msg = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $msg)))
																										if (($msg = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $msg)))
																											if (($msg = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $msg)))
																												/**/
																												if (($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																													foreach (c_ws_plugin__s2member_utils_strings::trim_deep (preg_split ("/;+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_sale_notification_recipients"])) as $recipient)
																														($recipient) ? wp_mail ($recipient, apply_filters ("ws_plugin__s2member_sp_sale_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_sp_sale_notification_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") : null;
																				/**/
																				$paypal["s2member_log"][] = "Specific Post/Page ~ Sale Notification Emails have been processed.";
																			}
																		/**/
																		if ($processing && $_GET["s2member_paypal_proxy"] && ($url = $_GET["s2member_paypal_proxy_return_url"])) /* A Proxy is requesting a Return URL for this transaction? */
																			{
																				if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%sp_access_url%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (rawurlencode ($sp_access_url)), $url)))
																					if (($url = preg_replace ("/%%sp_access_exp%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (c_ws_plugin__s2member_utils_time::approx_time_difference (time (), strtotime ("+" . $paypal["hours"] . " hours")))), $url)))
																						if (($url = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["mc_gross"])), $url)) && ($url = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["txn_id"])), $url)))
																							if (($url = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_number"])), $url)) && ($url = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_name"])), $url)))
																								if (($url = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["first_name"])), $url)) && ($url = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["last_name"])), $url)))
																									if (($url = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $url)))
																										if (($url = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["payer_email"])), $url)))
																											if (($url = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["ip"])), $url)))
																												/**/
																												if (($url = trim ($url))) /* Preserve Remaining replacements. */
																													/* Because the parent routine may perform replacements too. */
																													$paypal["s2member_paypal_proxy_return_url"] = $url;
																				/**/
																				$paypal["s2member_log"][] = "Specific Post/Page Return, a Proxy Return URL is ready.";
																			}
																		/**/
																		if ($processing && ($code = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_tracking_codes"]))
																			{
																				if (($code = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $code)) && ($code = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_gross"]), $code)) && ($code = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["txn_id"]), $code)))
																					if (($code = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $code)) && ($code = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $code)))
																						if (($code = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $code)) && ($code = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $code)))
																							if (($code = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $code)))
																								if (($code = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $code)))
																									if (($code = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $code)))
																										/**/
																										if (($code = trim (preg_replace ("/%%(.+?)%%/i", "", $code)))) /* This gets stored into a Transient Queue. */
																											{
																												$paypal["s2member_log"][] = "Storing Specific Post/Page Tracking Codes into a Transient Queue. These will be processed on-site.";
																												set_transient ("s2m_" . md5 ("s2member_transient_sp_tracking_codes_" . $paypal["txn_id"]), $code, 43200);
																											}
																			}
																		/**/
																		eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																		do_action ("ws_plugin__s2member_during_paypal_notify_during_sp_access", get_defined_vars ());
																		unset ($__refs, $__v); /* Unset defined __refs, __v. */
																	}
																else
																	$paypal["s2member_log"][] = "Unable to generate Access Link for Specific Post/Page Access. Does your Leading Post/Page still exist?";
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_after_sp_access", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/*
														New Subscriptions.
														Possibly containing advanced update vars
														( option_name1, option_selection1 ); which allow account modifications.
														*/
														else if (/**/(preg_match ("/^(web_accept|subscr_signup)$/i", $paypal["txn_type"]))/**/
														&& (preg_match ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["membership_item_number_regex"], $paypal["item_number"]))/**/
														&& ($paypal["subscr_id"] || ($paypal["subscr_id"] = $paypal["txn_id"]))/**/
														&& (!preg_match ($payment_status_issues, $paypal["payment_status"]))/**/
														&& ($paypal["payer_email"])/**/)
															{
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_signup", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept|subscr_signup).";
																/**/
																list ($paypal["level"], $paypal["ccaps"], $paypal["eotper"]) = preg_split ("/\:/", $paypal["item_number"], 3);
																/**/
																$paypal["ip"] = (preg_match ("/ip address/i", $paypal["option_name2"]) && $paypal["option_selection2"]) ? $paypal["option_selection2"] : "";
																$paypal["ip"] = (!$paypal["ip"] && preg_match ("/^[0-9]+~[0-9\.]+$/", $paypal["invoice"])) ? preg_replace ("/^[0-9]+~/", "", $paypal["invoice"]) : $paypal["ip"];
																/**/
																$paypal["period1"] = (preg_match ("/^[1-9]/", $paypal["period1"])) ? $paypal["period1"] : "0 D"; /* Defaults to "0 D" ( zero days ). */
																$paypal["mc_amount1"] = (strlen ($paypal["mc_amount1"]) && $paypal["mc_amount1"] > 0) ? $paypal["mc_amount1"] : "0.00"; /* "0.00". */
																/**/
																if (preg_match ("/^web_accept$/i", $paypal["txn_type"])) /* Conversions for Lifetime & Fixed-Term sales. */
																	{
																		$paypal["period3"] = ($paypal["eotper"]) ? $paypal["eotper"] : "1 L"; /* 1 Lifetime. */
																		$paypal["mc_amount3"] = $paypal["mc_gross"]; /* The "Buy Now" amount is the full gross. */
																	}
																/**/
																$paypal["initial_term"] = (preg_match ("/^[1-9]/", $paypal["period1"])) ? $paypal["period1"] : "0 D"; /* Defaults to "0 D" ( zero days ). */
																$paypal["initial"] = (strlen ($paypal["mc_amount1"]) && preg_match ("/^[1-9]/", $paypal["period1"])) ? $paypal["mc_amount1"] : $paypal["mc_amount3"];
																$paypal["regular"] = $paypal["mc_amount3"]; /* This is the Regular Payment Amount that is charged to the Customer. Always required by PayPal®. */
																$paypal["regular_term"] = $paypal["period3"]; /* This is just set to keep a standard; this way both initial_term & regular_term are available. */
																$paypal["recurring"] = ($paypal["recurring"]) ? $paypal["mc_amount3"] : "0"; /* If non-recurring, this should be zero, otherwise Regular. */
																/**/
																eval('$ipn_signup_vars = $paypal; unset($ipn_signup_vars["s2member_log"]);'); /* Create array of IPN signup vars w/o s2member_log. */
																/*
																New Subscription with advanced update vars ( option_name1, option_selection1 )? These variables are used in Subscr. Modifications.
																*/
																if (preg_match ("/(referenc|associat|updat|upgrad)/i", $paypal["option_name1"]) && $paypal["option_selection1"]) /* Advanced way to handle Subscription mods. */
																	/* This advanced method is required whenever a Subscription that is already completed, or was never setup to recur in the first place needs to be modified.
																	PayPal® will not allow the `modify=1|2` parameter to be used in those scenarios, because technically there is no billing to update; only the account. */
																	{
																		eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																		do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_signup_w_update_vars", get_defined_vars ());
																		unset ($__refs, $__v); /* Unset defined __refs, __v. */
																		/**/
																		$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept|subscr_signup) w/ update vars.";
																		/**/
																		/* Check for both the old & new subscr_id's, just in case the Return routine already changed it. */
																		if (($user_id = c_ws_plugin__s2member_utils_users::get_user_id_with ($paypal["subscr_id"], $paypal["option_selection1"])) && is_object ($user = new WP_User ($user_id)) && $user->ID)
																			{
																				if (!$user->has_cap ("administrator")) /* Do NOT process this routine on Administrators. */
																					{
																						$processing = $modifying = $during = true; /* Yes, we ARE processing this. */
																						/**/
																						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																						do_action ("ws_plugin__s2member_during_paypal_notify_during_before_subscr_signup_w_update_vars", get_defined_vars ());
																						do_action ("ws_plugin__s2member_during_collective_mods", $user_id, get_defined_vars (), "ipn-upgrade-downgrade", "modification", "s2member_level" . $paypal["level"]);
																						unset ($__refs, $__v); /* Unset defined __refs, __v. */
																						/**/
																						$fields = get_user_option ("s2member_custom_fields", $user_id); /* These will be needed in the routines below. */
																						$user_reg_ip = get_user_option ("s2member_registration_ip", $user_id); /* Original IP during Registration. */
																						$user_reg_ip = $paypal["ip"] = ($user_reg_ip) ? $user_reg_ip : $paypal["ip"]; /* Now merge conditionally. */
																						/**/
																						if (is_multisite () && !is_user_member_of_blog ($user_id))
																							{
																								add_existing_user_to_blog(array ("user_id" => $user_id, "role" => "s2member_level" . $paypal["level"]));
																								$user = new WP_User ($user_id);
																							}
																						/**/
																						$current_role = c_ws_plugin__s2member_user_access::user_access_role ($user);
																						/**/
																						if ($current_role !== "s2member_level" . $paypal["level"]) /* Only if we need to. */
																							$user->set_role ("s2member_level" . $paypal["level"]); /* (upgrade/downgrade) */
																						/**/
																						if (!preg_match ("/^\+/", $paypal["ccaps"]))
																							foreach ($user->allcaps as $cap => $cap_enabled)
																								if (preg_match ("/^access_s2member_ccap_/", $cap))
																									$user->remove_cap ($ccap = $cap);
																						/**/
																						foreach (preg_split ("/[\r\n\t\s;,]+/", ltrim ($paypal["ccaps"], "+")) as $ccap)
																							if (strlen ($ccap)) /* Don't add empty Custom Capabilities. */
																								$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
																						/**/
																						update_user_option ($user_id, "s2member_subscr_gateway", $paypal["subscr_gateway"]);
																						update_user_option ($user_id, "s2member_subscr_id", $paypal["subscr_id"]);
																						update_user_option ($user_id, "s2member_custom", $paypal["custom"]);
																						/**/
																						if (!get_user_option ("s2member_registration_ip", $user_id))
																							update_user_option ($user_id, "s2member_registration_ip", $paypal["ip"]);
																						/**/
																						update_user_option ($user_id, "s2member_ipn_signup_vars", $ipn_signup_vars);
																						/**/
																						delete_user_option ($user_id, "s2member_file_download_access_arc");
																						delete_user_option ($user_id, "s2member_file_download_access_log");
																						/**/
																						if (preg_match ("/^web_accept$/i", $paypal["txn_type"]) && $paypal["eotper"])
																							{
																								update_user_option ($user_id, "s2member_auto_eot_time", /* Set exclusively by the IPN handler; to avoid duplicate extensions. */
																								($eot_time = c_ws_plugin__s2member_utils_time::auto_eot_time ("", "", "", $paypal["eotper"], "", get_user_option ("s2member_auto_eot_time", $user_id))));
																								$paypal["s2member_log"][] = "Automatic EOT ( End Of Term ) Time set to: " . date ("D M j, Y g:i:s a T", $eot_time) . ".";
																							}
																						else /* Otherwise, we need to clear the Auto-EOT Time. */
																							delete_user_option ($user_id, "s2member_auto_eot_time");
																						/**/
																						$pr_times = get_user_option ("s2member_paid_registration_times", $user_id);
																						$pr_times["level"] = (!$pr_times["level"]) ? time () : $pr_times["level"]; /* Preserves existing. */
																						$pr_times["level" . $paypal["level"]] = (!$pr_times["level" . $paypal["level"]]) ? time () : $pr_times["level" . $paypal["level"]];
																						update_user_option ($user_id, "s2member_paid_registration_times", $pr_times); /* Update now. */
																						/**/
																						c_ws_plugin__s2member_user_notes::clear_user_note_lines ($user_id, "/^Demoted by s2Member\:/");
																						/**/
																						$paypal["s2member_log"][] = "s2Member Level/Capabilities updated w/ advanced update routines.";
																						/**/
																						wp_mail ($paypal["payer_email"], apply_filters ("ws_plugin__s2member_modification_email_sbj", "Thank you! Your account has been updated.", get_defined_vars ()), apply_filters ("ws_plugin__s2member_modification_email_msg", "Thank you! You've been updated to:\n" . $paypal["item_name"] . "\n\nPlease log back in now.\n" . wp_login_url (), get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8");
																						/**/
																						$paypal["s2member_log"][] = "Modification Confirmation Email sent to Customer, with a URL that provides them with a way to log back in.";
																						/**/
																						if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["modification_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																							{
																								foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["modification_notification_urls"]) as $url)
																									/**/
																									if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["subscr_id"])), $url)))
																										if (($url = preg_replace ("/%%initial%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["initial"])), $url)) && ($url = preg_replace ("/%%regular%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["regular"])), $url)) && ($url = preg_replace ("/%%recurring%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["recurring"])), $url)))
																											if (($url = preg_replace ("/%%initial_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["initial_term"])), $url)) && ($url = preg_replace ("/%%regular_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["regular_term"])), $url)))
																												if (($url = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_number"])), $url)) && ($url = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_name"])), $url)))
																													if (($url = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["first_name"])), $url)) && ($url = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["last_name"])), $url)))
																														if (($url = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $url)))
																															if (($url = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["payer_email"])), $url)))
																																/**/
																																if (($url = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->first_name)), $url)) && ($url = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->last_name)), $url)))
																																	if (($url = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($user->first_name . " " . $user->last_name))), $url)))
																																		if (($url = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_email)), $url)))
																																			if (($url = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_login)), $url)))
																																				if (($url = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_reg_ip)), $url)))
																																					if (($url = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_id)), $url)))
																																						{
																																							if (is_array ($fields) && !empty ($fields))
																																								foreach ($fields as $var => $val) /* Custom Registration Fields. */
																																									if (!($url = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (maybe_serialize ($val))), $url)))
																																										break;
																																							/**/
																																							if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																																								c_ws_plugin__s2member_utils_urls::remote ($url);
																																						}
																								/**/
																								$paypal["s2member_log"][] = "Modification Notification URLs have been processed.";
																							}
																						/**/
																						if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["modification_notification_recipients"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																							{
																								$msg = $sbj = "( s2Member / API Notification Email ) - Modification";
																								$msg .= "\n\n"; /* Spacing in the message body. */
																								/**/
																								$msg .= "subscr_id: %%subscr_id%%\n";
																								$msg .= "initial: %%initial%%\n";
																								$msg .= "regular: %%regular%%\n";
																								$msg .= "recurring: %%recurring%%\n";
																								$msg .= "initial_term: %%initial_term%%\n";
																								$msg .= "regular_term: %%regular_term%%\n";
																								$msg .= "item_number: %%item_number%%\n";
																								$msg .= "item_name: %%item_name%%\n";
																								$msg .= "first_name: %%first_name%%\n";
																								$msg .= "last_name: %%last_name%%\n";
																								$msg .= "full_name: %%full_name%%\n";
																								$msg .= "payer_email: %%payer_email%%\n";
																								/**/
																								$msg .= "user_first_name: %%user_first_name%%\n";
																								$msg .= "user_last_name: %%user_last_name%%\n";
																								$msg .= "user_full_name: %%user_full_name%%\n";
																								$msg .= "user_email: %%user_email%%\n";
																								$msg .= "user_login: %%user_login%%\n";
																								$msg .= "user_ip: %%user_ip%%\n";
																								$msg .= "user_id: %%user_id%%\n";
																								/**/
																								if (is_array ($fields) && !empty ($fields))
																									foreach ($fields as $var => $val)
																										$msg .= $var . ": %%" . $var . "%%\n";
																								/**/
																								$msg .= "cv0: %%cv0%%\n";
																								$msg .= "cv1: %%cv1%%\n";
																								$msg .= "cv2: %%cv2%%\n";
																								$msg .= "cv3: %%cv3%%\n";
																								$msg .= "cv4: %%cv4%%\n";
																								$msg .= "cv5: %%cv5%%\n";
																								$msg .= "cv6: %%cv6%%\n";
																								$msg .= "cv7: %%cv7%%\n";
																								$msg .= "cv8: %%cv8%%\n";
																								$msg .= "cv9: %%cv9%%";
																								/**/
																								if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["subscr_id"]), $msg)))
																									if (($msg = preg_replace ("/%%initial%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["initial"]), $msg)) && ($msg = preg_replace ("/%%regular%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["regular"]), $msg)) && ($msg = preg_replace ("/%%recurring%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["recurring"]), $msg)))
																										if (($msg = preg_replace ("/%%initial_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["initial_term"]), $msg)) && ($msg = preg_replace ("/%%regular_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["regular_term"]), $msg)))
																											if (($msg = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $msg)) && ($msg = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $msg)))
																												if (($msg = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $msg)) && ($msg = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $msg)))
																													if (($msg = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $msg)))
																														if (($msg = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $msg)))
																															/**/
																															if (($msg = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->first_name), $msg)) && ($msg = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->last_name), $msg)))
																																if (($msg = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($user->first_name . " " . $user->last_name)), $msg)))
																																	if (($msg = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->user_email), $msg)))
																																		if (($msg = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->user_login), $msg)))
																																			if (($msg = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_reg_ip), $msg)))
																																				if (($msg = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_id), $msg)))
																																					{
																																						if (is_array ($fields) && !empty ($fields))
																																							foreach ($fields as $var => $val) /* Custom Registration Fields. */
																																								if (!($msg = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (maybe_serialize ($val)), $msg)))
																																									break;
																																						/**/
																																						if (($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																																							foreach (c_ws_plugin__s2member_utils_strings::trim_deep (preg_split ("/;+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["modification_notification_recipients"])) as $recipient)
																																								($recipient) ? wp_mail ($recipient, apply_filters ("ws_plugin__s2member_modification_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_modification_notification_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") : null;
																																					}
																								/**/
																								$paypal["s2member_log"][] = "Modification Notification Emails have been processed.";
																							}
																						/**/
																						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																						do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_signup_w_update_vars", get_defined_vars ());
																						unset ($__refs, $__v); /* Unset defined __refs, __v. */
																					}
																				else
																					$paypal["s2member_log"][] = "Unable to modify Subscription. The existing User ID is associated with an Administrator. Stopping here. Otherwise, an Administrator could lose access.";
																			}
																		else
																			$paypal["s2member_log"][] = "Unable to modify Subscription. Could not get the existing User ID from the DB. Please check the on0 and os0 variables in your Button Code.";
																		/**/
																		eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																		do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_signup_w_update_vars", get_defined_vars ());
																		unset ($__refs, $__v); /* Unset defined __refs, __v. */
																	}
																/*
																New Subscription. Normal Subscription signup, we are not updating anything for a past Subscription.
																*/
																else /* Else this is a normal Subscription signup, we are not updating anything. */
																	{
																		eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																		do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_signup_wo_update_vars", get_defined_vars ());
																		unset ($__refs, $__v); /* Unset defined __refs, __v. */
																		/**/
																		$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept|subscr_signup) w/o update vars.";
																		/**/
																		if (($registration_url = c_ws_plugin__s2member_register_access::register_link_gen ($paypal["subscr_gateway"], $paypal["subscr_id"], $paypal["custom"], $paypal["item_number"])) && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																			{
																				$processing = $during = true; /* Yes, we ARE processing this. */
																				/**/
																				$sbj = preg_replace ("/%%registration_url%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($registration_url), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"][(($_GET["s2member_paypal_proxy"] && preg_match ("/pro-emails/", $_GET["s2member_paypal_proxy_use"])) ? "pro_" : "") . "signup_email_subject"]);
																				$msg = preg_replace ("/%%registration_url%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($registration_url), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"][(($_GET["s2member_paypal_proxy"] && preg_match ("/pro-emails/", $_GET["s2member_paypal_proxy_use"])) ? "pro_" : "") . "signup_email_message"]);
																				$rec = preg_replace ("/%%registration_url%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($registration_url), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"][(($_GET["s2member_paypal_proxy"] && preg_match ("/pro-emails/", $_GET["s2member_paypal_proxy_use"])) ? "pro_" : "") . "signup_email_recipients"]);
																				/**/
																				if (($rec = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $rec)) && ($rec = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["subscr_id"]), $rec)))
																					if (($rec = preg_replace ("/%%initial%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["initial"]), $rec)) && ($rec = preg_replace ("/%%regular%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["regular"]), $rec)))
																						if (($rec = preg_replace ("/%%initial_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["initial_term"]), $rec)) && ($rec = preg_replace ("/%%regular_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["regular_term"]), $rec)))
																							if (($rec = preg_replace ("/%%initial_cycle%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (c_ws_plugin__s2member_utils_time::period_term ($paypal["initial_term"])), $rec)) && ($rec = preg_replace ("/%%regular_cycle%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (c_ws_plugin__s2member_utils_time::period_term ($paypal["regular_term"], $paypal["recurring"])), $rec)))
																								if (($rec = preg_replace ("/%%recurring%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["recurring"]), $rec)) && ($rec = preg_replace ("/%%recurring\/regular_cycle%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ((($paypal["recurring"]) ? $paypal["recurring"] . " / " . c_ws_plugin__s2member_utils_time::period_term ($paypal["regular_term"], true) : "0 / non-recurring")), $rec)))
																									if (($rec = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $rec)) && ($rec = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $rec)))
																										if (($rec = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_dq (c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"])), $rec)) && ($rec = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_dq (c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"])), $rec)))
																											if (($rec = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_dq (c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $rec))) /* **NOTE** c_ws_plugin__s2member_utils_strings::esc_dq() is applied here. ( ex. "N\"ame" <email> ). */
																												if (($rec = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $rec)))
																													if (($rec = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $rec)))
																														/**/
																														if (($sbj = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $sbj)) && ($sbj = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["subscr_id"]), $sbj)))
																															if (($sbj = preg_replace ("/%%initial%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["initial"]), $sbj)) && ($sbj = preg_replace ("/%%regular%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["regular"]), $sbj)))
																																if (($sbj = preg_replace ("/%%initial_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["initial_term"]), $sbj)) && ($sbj = preg_replace ("/%%regular_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["regular_term"]), $sbj)))
																																	if (($sbj = preg_replace ("/%%initial_cycle%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (c_ws_plugin__s2member_utils_time::period_term ($paypal["initial_term"])), $sbj)) && ($sbj = preg_replace ("/%%regular_cycle%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (c_ws_plugin__s2member_utils_time::period_term ($paypal["regular_term"], $paypal["recurring"])), $sbj)))
																																		if (($sbj = preg_replace ("/%%recurring%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["recurring"]), $sbj)) && ($sbj = preg_replace ("/%%recurring\/regular_cycle%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ((($paypal["recurring"]) ? $paypal["recurring"] . " / " . c_ws_plugin__s2member_utils_time::period_term ($paypal["regular_term"], true) : "0 / non-recurring")), $sbj)))
																																			if (($sbj = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $sbj)) && ($sbj = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $sbj)))
																																				if (($sbj = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $sbj)) && ($sbj = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $sbj)))
																																					if (($sbj = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $sbj)))
																																						if (($sbj = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $sbj)))
																																							if (($sbj = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $sbj)))
																																								/**/
																																								if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["subscr_id"]), $msg)))
																																									if (($msg = preg_replace ("/%%initial%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["initial"]), $msg)) && ($msg = preg_replace ("/%%regular%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["regular"]), $msg)))
																																										if (($msg = preg_replace ("/%%initial_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["initial_term"]), $msg)) && ($msg = preg_replace ("/%%regular_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["regular_term"]), $msg)))
																																											if (($msg = preg_replace ("/%%initial_cycle%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (c_ws_plugin__s2member_utils_time::period_term ($paypal["initial_term"])), $msg)) && ($msg = preg_replace ("/%%regular_cycle%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (c_ws_plugin__s2member_utils_time::period_term ($paypal["regular_term"], $paypal["recurring"])), $msg)))
																																												if (($msg = preg_replace ("/%%recurring%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["recurring"]), $msg)) && ($msg = preg_replace ("/%%recurring\/regular_cycle%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ((($paypal["recurring"]) ? $paypal["recurring"] . " / " . c_ws_plugin__s2member_utils_time::period_term ($paypal["regular_term"], true) : "0 / non-recurring")), $msg)))
																																													if (($msg = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $msg)) && ($msg = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $msg)))
																																														if (($msg = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $msg)) && ($msg = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $msg)))
																																															if (($msg = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $msg)))
																																																if (($msg = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $msg)))
																																																	if (($msg = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $msg)))
																																																		/**/
																																																		if (($recipients = preg_split ("/;+/", preg_replace ("/%%(.+?)%%/i", "", $rec))) && ($sbj = trim (preg_replace ("/%%(.+?)%%/i", "", $sbj))) && ($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																																																			{
																																																				foreach (c_ws_plugin__s2member_utils_strings::trim_deep ($recipients) as $recipient) /* Go through the full list of recipients. */
																																																					($recipient) ? wp_mail ($recipient, apply_filters ("ws_plugin__s2member_signup_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_signup_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") : null;
																																																				/**/
																																																				$paypal["s2member_log"][] = "Signup Confirmation Email sent to: " . implode ("; ", $recipients) . ".";
																																																			}
																				/**/
																				if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																					{
																						foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_notification_urls"]) as $url)
																							/**/
																							if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["subscr_id"])), $url)))
																								if (($url = preg_replace ("/%%initial%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["initial"])), $url)) && ($url = preg_replace ("/%%regular%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["regular"])), $url)) && ($url = preg_replace ("/%%recurring%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["recurring"])), $url)))
																									if (($url = preg_replace ("/%%initial_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["initial_term"])), $url)) && ($url = preg_replace ("/%%regular_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["regular_term"])), $url)))
																										if (($url = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_number"])), $url)) && ($url = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_name"])), $url)))
																											if (($url = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["first_name"])), $url)) && ($url = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["last_name"])), $url)))
																												if (($url = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $url)))
																													if (($url = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["payer_email"])), $url)))
																														if (($url = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["ip"])), $url)))
																															/**/
																															if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																																c_ws_plugin__s2member_utils_urls::remote ($url);
																						/**/
																						$paypal["s2member_log"][] = "Signup Notification URLs have been processed.";
																					}
																				/**/
																				if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_notification_recipients"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																					{
																						$msg = $sbj = "( s2Member / API Notification Email ) - Signup";
																						$msg .= "\n\n"; /* Spacing in the message body. */
																						/**/
																						$msg .= "subscr_id: %%subscr_id%%\n";
																						$msg .= "initial: %%initial%%\n";
																						$msg .= "regular: %%regular%%\n";
																						$msg .= "recurring: %%recurring%%\n";
																						$msg .= "initial_term: %%initial_term%%\n";
																						$msg .= "regular_term: %%regular_term%%\n";
																						$msg .= "item_number: %%item_number%%\n";
																						$msg .= "item_name: %%item_name%%\n";
																						$msg .= "first_name: %%first_name%%\n";
																						$msg .= "last_name: %%last_name%%\n";
																						$msg .= "full_name: %%full_name%%\n";
																						$msg .= "payer_email: %%payer_email%%\n";
																						$msg .= "user_ip: %%user_ip%%\n";
																						/**/
																						$msg .= "cv0: %%cv0%%\n";
																						$msg .= "cv1: %%cv1%%\n";
																						$msg .= "cv2: %%cv2%%\n";
																						$msg .= "cv3: %%cv3%%\n";
																						$msg .= "cv4: %%cv4%%\n";
																						$msg .= "cv5: %%cv5%%\n";
																						$msg .= "cv6: %%cv6%%\n";
																						$msg .= "cv7: %%cv7%%\n";
																						$msg .= "cv8: %%cv8%%\n";
																						$msg .= "cv9: %%cv9%%";
																						/**/
																						if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["subscr_id"]), $msg)))
																							if (($msg = preg_replace ("/%%initial%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["initial"]), $msg)) && ($msg = preg_replace ("/%%regular%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["regular"]), $msg)) && ($msg = preg_replace ("/%%recurring%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["recurring"]), $msg)))
																								if (($msg = preg_replace ("/%%initial_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["initial_term"]), $msg)) && ($msg = preg_replace ("/%%regular_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["regular_term"]), $msg)))
																									if (($msg = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $msg)) && ($msg = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $msg)))
																										if (($msg = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $msg)) && ($msg = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $msg)))
																											if (($msg = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $msg)))
																												if (($msg = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $msg)))
																													if (($msg = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $msg)))
																														/**/
																														if (($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																															foreach (c_ws_plugin__s2member_utils_strings::trim_deep (preg_split ("/;+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_notification_recipients"])) as $recipient)
																																($recipient) ? wp_mail ($recipient, apply_filters ("ws_plugin__s2member_signup_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_signup_notification_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") : null;
																						/**/
																						$paypal["s2member_log"][] = "Signup Notification Emails have been processed.";
																					}
																				/**/
																				if ($processing && ($code = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_tracking_codes"]) && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																					{
																						if (($code = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $code)) && ($code = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["subscr_id"]), $code)))
																							if (($code = preg_replace ("/%%initial%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["initial"]), $code)) && ($code = preg_replace ("/%%regular%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["regular"]), $code)) && ($code = preg_replace ("/%%recurring%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["recurring"]), $code)))
																								if (($code = preg_replace ("/%%initial_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["initial_term"]), $code)) && ($code = preg_replace ("/%%regular_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["regular_term"]), $code)))
																									if (($code = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $code)) && ($code = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $code)))
																										if (($code = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $code)) && ($code = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $code)))
																											if (($code = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $code)))
																												if (($code = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $code)))
																													if (($code = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $code)))
																														/**/
																														if (($code = trim (preg_replace ("/%%(.+?)%%/i", "", $code)))) /* This gets stored into a Transient Queue. */
																															{
																																$paypal["s2member_log"][] = "Storing Signup Tracking Codes into a Transient Queue. These will be processed on-site.";
																																set_transient ("s2m_" . md5 ("s2member_transient_signup_tracking_codes_" . $paypal["subscr_id"]), $code, 43200);
																															}
																					}
																				/**/
																				eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																				do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_signup_wo_update_vars", get_defined_vars ());
																				unset ($__refs, $__v); /* Unset defined __refs, __v. */
																			}
																		else
																			$paypal["s2member_log"][] = "Unable to generate Registration URL for Membership Access. Possible data corruption within the IPN response.";
																		/**/
																		eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																		do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_signup_wo_update_vars", get_defined_vars ());
																		unset ($__refs, $__v); /* Unset defined __refs, __v. */
																	}
																/**/
																if ($processing && $_GET["s2member_paypal_proxy"] && ($url = $_GET["s2member_paypal_proxy_return_url"]) && is_array ($cv = preg_split ("/\|/", $paypal["custom"]))) /* A Proxy is requesting a Return URL? */
																	{
																		if (($user_id && is_object ($user) && $user->ID) || (($user_id = c_ws_plugin__s2member_utils_users::get_user_id_with ($paypal["subscr_id"], $paypal["option_selection1"])) && is_object ($user = new WP_User ($user_id)) && $user->ID))
																			{
																				$fields = get_user_option ("s2member_custom_fields", $user_id); /* These will be needed in the routines below. */
																				$user_reg_ip = get_user_option ("s2member_registration_ip", $user_id); /* Original IP during Registration. */
																				/**/
																				if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["subscr_id"])), $url)))
																					if (($url = preg_replace ("/%%initial%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["initial"])), $url)) && ($url = preg_replace ("/%%regular%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["regular"])), $url)) && ($url = preg_replace ("/%%recurring%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["recurring"])), $url)))
																						if (($url = preg_replace ("/%%initial_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["initial_term"])), $url)) && ($url = preg_replace ("/%%regular_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["regular_term"])), $url)))
																							if (($url = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_number"])), $url)) && ($url = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_name"])), $url)))
																								if (($url = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["first_name"])), $url)) && ($url = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["last_name"])), $url)))
																									if (($url = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $url)))
																										if (($url = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["payer_email"])), $url)))
																											if (($url = preg_replace ("/%%modification%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ((int)$modifying)), $url)))
																												{
																													if (($url = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->first_name)), $url)) && ($url = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->last_name)), $url)))
																														if (($url = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($user->first_name . " " . $user->last_name))), $url)))
																															if (($url = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_email)), $url)))
																																if (($url = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_login)), $url)))
																																	if (($url = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_reg_ip)), $url)))
																																		if (($url = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_id)), $url)))
																																			{
																																				if (is_array ($fields) && !empty ($fields))
																																					foreach ($fields as $var => $val) /* Custom Registration Fields. */
																																						if (!($url = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (maybe_serialize ($val))), $url)))
																																							break;
																																				/**/
																																				if (($url = trim ($url))) /* Preserve remaining replacements. */
																																					/* Because the parent routine may perform replacements too. */
																																					$paypal["s2member_paypal_proxy_return_url"] = $url;
																																			}
																												}
																			}
																		/**/
																		$paypal["s2member_log"][] = "Subscr. Return ( modification=" . (int)$modifying . " ), a Proxy Return URL is ready.";
																	}
																/**/
																if ($processing /* Process a payment now? Special cases for web_accept and/or Proxy requests with `subscr-signup-as-subscr-payment`. */
																&& (preg_match ("/^web_accept$/i", $paypal["txn_type"]) || ($_GET["s2member_paypal_proxy"] && preg_match ("/subscr-signup-as-subscr-payment/", $_GET["s2member_paypal_proxy_use"]) && $paypal["txn_id"] && $paypal["mc_gross"] > 0))/**/
																&& (($user_id && is_object ($user) && $user->ID) || (($user_id = c_ws_plugin__s2member_utils_users::get_user_id_with ($paypal["subscr_id"], $paypal["option_selection1"])) && is_object ($user = new WP_User ($user_id)) && $user->ID)))
																	{
																		$paypal["s2member_log"][] = "User exists. Handling `payment` for Subscription via (" . ((preg_match ("/^web_accept$/i", $paypal["txn_type"])) ? "web_accept" : "subscr-signup-as-subscr-payment") . ").";
																		/**/
																		$pr_times = get_user_option ("s2member_paid_registration_times", $user_id);
																		$pr_times["level"] = (!$pr_times["level"]) ? time () : $pr_times["level"]; /* Preserves existing. */
																		$pr_times["level" . $paypal["level"]] = (!$pr_times["level" . $paypal["level"]]) ? time () : $pr_times["level" . $paypal["level"]];
																		update_user_option ($user_id, "s2member_paid_registration_times", $pr_times); /* Update now. */
																		/**/
																		if (!get_user_option ("s2member_first_payment_txn_id", $user_id)) /* 1st payment? */
																			update_user_option ($user_id, "s2member_first_payment_txn_id", $paypal["txn_id"]);
																		/**/
																		update_user_option ($user_id, "s2member_last_payment_time", time ()); /* Update the last payment time. */
																		/**/
																		$fields = get_user_option ("s2member_custom_fields", $user_id); /* These will be needed in the routines below. */
																		$user_reg_ip = get_user_option ("s2member_registration_ip", $user_id); /* Original IP during Registration. */
																		/**/
																		if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																			{
																				foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_urls"]) as $url)
																					/**/
																					if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["subscr_id"])), $url)))
																						if (($url = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["mc_gross"])), $url)) && ($url = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["txn_id"])), $url)))
																							if (($url = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_number"])), $url)) && ($url = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_name"])), $url)))
																								if (($url = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["first_name"])), $url)) && ($url = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["last_name"])), $url)))
																									if (($url = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $url)))
																										if (($url = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["payer_email"])), $url)))
																											{
																												if (($url = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->first_name)), $url)) && ($url = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->last_name)), $url)))
																													if (($url = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($user->first_name . " " . $user->last_name))), $url)))
																														if (($url = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_email)), $url)))
																															if (($url = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_login)), $url)))
																																if (($url = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_reg_ip)), $url)))
																																	if (($url = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_id)), $url)))
																																		{
																																			if (is_array ($fields) && !empty ($fields))
																																				foreach ($fields as $var => $val) /* Custom Registration Fields. */
																																					if (!($url = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (maybe_serialize ($val))), $url)))
																																						break;
																																			/**/
																																			if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																																				c_ws_plugin__s2member_utils_urls::remote ($url);
																																		}
																											}
																				/**/
																				$paypal["s2member_log"][] = "Payment Notification URLs have been processed.";
																			}
																		/**/
																		if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_recipients"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																			{
																				$msg = $sbj = "( s2Member / API Notification Email ) - Payment";
																				$msg .= "\n\n"; /* Spacing in the message body. */
																				/**/
																				$msg .= "subscr_id: %%subscr_id%%\n";
																				$msg .= "amount: %%amount%%\n";
																				$msg .= "txn_id: %%txn_id%%\n";
																				$msg .= "item_number: %%item_number%%\n";
																				$msg .= "item_name: %%item_name%%\n";
																				$msg .= "first_name: %%first_name%%\n";
																				$msg .= "last_name: %%last_name%%\n";
																				$msg .= "full_name: %%full_name%%\n";
																				$msg .= "payer_email: %%payer_email%%\n";
																				/**/
																				$msg .= "user_first_name: %%user_first_name%%\n";
																				$msg .= "user_last_name: %%user_last_name%%\n";
																				$msg .= "user_full_name: %%user_full_name%%\n";
																				$msg .= "user_email: %%user_email%%\n";
																				$msg .= "user_login: %%user_login%%\n";
																				$msg .= "user_ip: %%user_ip%%\n";
																				$msg .= "user_id: %%user_id%%\n";
																				/**/
																				if (is_array ($fields) && !empty ($fields))
																					foreach ($fields as $var => $val)
																						$msg .= $var . ": %%" . $var . "%%\n";
																				/**/
																				$msg .= "cv0: %%cv0%%\n";
																				$msg .= "cv1: %%cv1%%\n";
																				$msg .= "cv2: %%cv2%%\n";
																				$msg .= "cv3: %%cv3%%\n";
																				$msg .= "cv4: %%cv4%%\n";
																				$msg .= "cv5: %%cv5%%\n";
																				$msg .= "cv6: %%cv6%%\n";
																				$msg .= "cv7: %%cv7%%\n";
																				$msg .= "cv8: %%cv8%%\n";
																				$msg .= "cv9: %%cv9%%";
																				/**/
																				if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["subscr_id"]), $msg)))
																					if (($msg = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_gross"]), $msg)) && ($msg = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["txn_id"]), $msg)))
																						if (($msg = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $msg)) && ($msg = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $msg)))
																							if (($msg = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $msg)) && ($msg = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $msg)))
																								if (($msg = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $msg)))
																									if (($msg = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $msg)))
																										{
																											if (($msg = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->first_name), $msg)) && ($msg = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->last_name), $msg)))
																												if (($msg = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($user->first_name . " " . $user->last_name)), $msg)))
																													if (($msg = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->user_email), $msg)))
																														if (($msg = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->user_login), $msg)))
																															if (($msg = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_reg_ip), $msg)))
																																if (($msg = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_id), $msg)))
																																	{
																																		if (is_array ($fields) && !empty ($fields))
																																			foreach ($fields as $var => $val) /* Custom Registration Fields. */
																																				if (!($msg = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (maybe_serialize ($val)), $msg)))
																																					break;
																																		/**/
																																		if (($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																																			foreach (c_ws_plugin__s2member_utils_strings::trim_deep (preg_split ("/;+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_recipients"])) as $recipient)
																																				($recipient) ? wp_mail ($recipient, apply_filters ("ws_plugin__s2member_payment_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_payment_notification_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") : null;
																																	}
																										}
																				/**/
																				$paypal["s2member_log"][] = "Payment Notification Emails have been processed.";
																			}
																	}
																else if ($processing /* Process a payment now? Special cases for web_accept and/or Proxy requests with `subscr-signup-as-subscr-payment`. */
																&& (preg_match ("/^web_accept$/i", $paypal["txn_type"]) || ($_GET["s2member_paypal_proxy"] && preg_match ("/subscr-signup-as-subscr-payment/", $_GET["s2member_paypal_proxy_use"]) && $paypal["txn_id"] && $paypal["mc_gross"] > 0)))
																	{
																		$paypal["s2member_log"][] = "Storing `payment` for Subscription via (" . ((preg_match ("/^web_accept$/i", $paypal["txn_type"])) ? "web_accept" : "subscr-signup-as-subscr-payment") . ").";
																		/**/
																		$ipn = array ("txn_type" => "subscr_payment"); /* Create a simulated IPN response for txn_type=subscr_payment. */
																		/**/
																		foreach ($paypal as $var => $val)
																			if (in_array ($var, array ("subscr_gateway", "subscr_id", "txn_id", "custom", "invoice", "mc_gross", "mc_currency", "tax", "payer_email", "first_name", "last_name", "item_name", "item_number", "option_name1", "option_selection1", "option_name2", "option_selection2")))
																				$ipn[$var] = $val;
																		/**/
																		$paypal["s2member_log"][] = "Creating an IPN response for `subscr_payment`. This will go into a Transient Queue; and be processed during registration.";
																		/**/
																		set_transient ("s2m_" . md5 ("s2member_transient_ipn_subscr_payment_" . $paypal["subscr_id"]), $ipn, 43200);
																	}
																/**/
																if ($processing /* Store signup vars now? If the User already exists in the database, we can go ahead and store these right now. */
																&& (($user_id && is_object ($user) && $user->ID) || (($user_id = c_ws_plugin__s2member_utils_users::get_user_id_with ($paypal["subscr_id"], $paypal["option_selection1"])) && is_object ($user = new WP_User ($user_id)) && $user->ID)))
																	{
																		$paypal["s2member_log"][] = "Storing IPN signup vars now. These are associated with a User's account record; for future reference.";
																		/**/
																		update_user_option ($user_id, "s2member_ipn_signup_vars", $ipn_signup_vars);
																	}
																else if ($processing) /* Otherwise, we can store these into a Transient Queue for registration processing. */
																	{
																		$paypal["s2member_log"][] = "Storing IPN signup vars into a Transient Queue. These will be processed on registration.";
																		/**/
																		set_transient ("s2m_" . md5 ("s2member_transient_ipn_signup_vars_" . $paypal["subscr_id"]), $ipn_signup_vars, 43200);
																	}
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_signup", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/*
														Recurring Payment Profile creation.
														This is not really necessary. It is only here because this txn_type could
														be necessary in a future release of s2Member. For now, it's just a fill-in.
														These Hooks/Filters will remain, so you can use them now; if you need to.
														*/
														else if (/**/(preg_match ("/^recurring_payment_profile_created$/i", $paypal["txn_type"]))/**/
														&& ($paypal["item_number"] || ($paypal["item_number"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_number ($paypal)))/**/
														&& (preg_match ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["membership_item_number_regex"], $paypal["item_number"])) /* Membership. */
														&& ($paypal["subscr_id"] || ($paypal["subscr_id"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_subscr_id ($paypal)))/**/
														&& ($paypal["item_name"] || ($paypal["item_name"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_name ($paypal)))/**/
														&& ($paypal["payer_email"] || ($paypal["payer_email"] = c_ws_plugin__s2member_utils_users::get_user_email_with ($paypal["subscr_id"])))/**/)
															{
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_before_recurring_payment_profile_created", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "s2Member txn_type identified as recurring_payment_profile_created.";
																/**/
																$processing = $during = true; /* Yes, we ARE processing this. */
																/**/
																$paypal["s2member_log"][] = "The txn_type does not require any action on the part of s2Member.";
																$paypal["s2member_log"][] = "s2Member Pro handles this event on-site, with an IPN proxy.";
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_during_recurring_payment_profile_created", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_after_recurring_payment_profile_created", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/*
														Subscription modifications.
														*/
														else if (/**/(preg_match ("/^subscr_modify$/i", $paypal["txn_type"]))/**/
														&& (preg_match ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["membership_item_number_regex"], $paypal["item_number"]))/**/
														&& ($paypal["subscr_id"] && $paypal["payer_email"])/**/)
															{
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_modify", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "s2Member txn_type identified as subscr_modify.";
																/**/
																list ($paypal["level"], $paypal["ccaps"]) = preg_split ("/\:/", $paypal["item_number"], 2);
																/**/
																$paypal["ip"] = (preg_match ("/ip address/i", $paypal["option_name2"]) && $paypal["option_selection2"]) ? $paypal["option_selection2"] : "";
																$paypal["ip"] = (!$paypal["ip"] && preg_match ("/^[0-9]+~[0-9\.]+$/", $paypal["invoice"])) ? preg_replace ("/^[0-9]+~/", "", $paypal["invoice"]) : $paypal["ip"];
																/**/
																$paypal["period1"] = (preg_match ("/^[1-9]/", $paypal["period1"])) ? $paypal["period1"] : "0 D"; /* Defaults to "0 D" ( zero days ). */
																$paypal["mc_amount1"] = (strlen ($paypal["mc_amount1"]) && $paypal["mc_amount1"] > 0) ? $paypal["mc_amount1"] : "0.00"; /* "0.00". */
																/**/
																$paypal["initial_term"] = (preg_match ("/^[1-9]/", $paypal["period1"])) ? $paypal["period1"] : "0 D"; /* Defaults to "0 D" ( zero days ). */
																$paypal["initial"] = (strlen ($paypal["mc_amount1"]) && preg_match ("/^[1-9]/", $paypal["period1"])) ? $paypal["mc_amount1"] : $paypal["mc_amount3"];
																$paypal["regular"] = $paypal["mc_amount3"]; /* This is the Regular Payment Amount that is charged to the Customer. Always required by PayPal®. */
																$paypal["regular_term"] = $paypal["period3"]; /* This is just set to keep a standard; this way both initial_term & regular_term are available. */
																$paypal["recurring"] = ($paypal["recurring"]) ? $paypal["mc_amount3"] : "0"; /* If non-recurring, this should be zero, otherwise Regular. */
																/**/
																eval('$ipn_signup_vars = $paypal; unset($ipn_signup_vars["s2member_log"]);'); /* Create array of IPN signup vars w/o s2member_log. */
																/**/
																if (($user_id = c_ws_plugin__s2member_utils_users::get_user_id_with ($paypal["subscr_id"])) && is_object ($user = new WP_User ($user_id)) && $user->ID)
																	{
																		if (!$user->has_cap ("administrator")) /* Do NOT process this routine on Administrators. */
																			{
																				$processing = $modifying = $during = true; /* Yes, we ARE processing this. */
																				/**/
																				eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																				do_action ("ws_plugin__s2member_during_paypal_notify_during_before_subscr_modify", get_defined_vars ());
																				do_action ("ws_plugin__s2member_during_collective_mods", $user_id, get_defined_vars (), "ipn-upgrade-downgrade", "modification", "s2member_level" . $paypal["level"]);
																				unset ($__refs, $__v); /* Unset defined __refs, __v. */
																				/**/
																				$fields = get_user_option ("s2member_custom_fields", $user_id); /* These will be needed in the routines below. */
																				$user_reg_ip = get_user_option ("s2member_registration_ip", $user_id); /* Original IP during Registration. */
																				$user_reg_ip = $paypal["ip"] = ($user_reg_ip) ? $user_reg_ip : $paypal["ip"]; /* Now merge conditionally. */
																				/**/
																				if (is_multisite () && !is_user_member_of_blog ($user_id))
																					{
																						add_existing_user_to_blog(array ("user_id" => $user_id, "role" => "s2member_level" . $paypal["level"]));
																						$user = new WP_User ($user_id);
																					}
																				/**/
																				$current_role = c_ws_plugin__s2member_user_access::user_access_role ($user);
																				/**/
																				if ($current_role !== "s2member_level" . $paypal["level"]) /* Only if we need to. */
																					$user->set_role ("s2member_level" . $paypal["level"]); /* (upgrade/downgrade) */
																				/**/
																				if (!preg_match ("/^\+/", $paypal["ccaps"]))
																					foreach ($user->allcaps as $cap => $cap_enabled)
																						if (preg_match ("/^access_s2member_ccap_/", $cap))
																							$user->remove_cap ($ccap = $cap);
																				/**/
																				foreach (preg_split ("/[\r\n\t\s;,]+/", ltrim ($paypal["ccaps"], "+")) as $ccap)
																					if (strlen ($ccap)) /* Don't add empty Custom Capabilities. */
																						$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
																				/**/
																				update_user_option ($user_id, "s2member_subscr_gateway", $paypal["subscr_gateway"]);
																				update_user_option ($user_id, "s2member_subscr_id", $paypal["subscr_id"]);
																				update_user_option ($user_id, "s2member_custom", $paypal["custom"]);
																				/**/
																				if (!get_user_option ("s2member_registration_ip", $user_id))
																					update_user_option ($user_id, "s2member_registration_ip", $paypal["ip"]);
																				/**/
																				update_user_option ($user_id, "s2member_ipn_signup_vars", $ipn_signup_vars);
																				/**/
																				delete_user_option ($user_id, "s2member_file_download_access_arc");
																				delete_user_option ($user_id, "s2member_file_download_access_log");
																				/**/
																				delete_user_option ($user_id, "s2member_auto_eot_time");
																				/**/
																				$pr_times = get_user_option ("s2member_paid_registration_times", $user_id);
																				$pr_times["level"] = (!$pr_times["level"]) ? time () : $pr_times["level"]; /* Preserves existing. */
																				$pr_times["level" . $paypal["level"]] = (!$pr_times["level" . $paypal["level"]]) ? time () : $pr_times["level" . $paypal["level"]];
																				update_user_option ($user_id, "s2member_paid_registration_times", $pr_times); /* Update now. */
																				/**/
																				c_ws_plugin__s2member_user_notes::clear_user_note_lines ($user_id, "/^Demoted by s2Member\:/");
																				/**/
																				$paypal["s2member_log"][] = "s2Member Level/Capabilities updated on Subscription modification.";
																				/**/
																				wp_mail ($paypal["payer_email"], apply_filters ("ws_plugin__s2member_modification_email_sbj", "Thank you! Your account has been updated.", get_defined_vars ()), apply_filters ("ws_plugin__s2member_modification_email_msg", "Thank you! You've been updated to:\n" . $paypal["item_name"] . "\n\nPlease log back in now.\n" . wp_login_url (), get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8");
																				/**/
																				$paypal["s2member_log"][] = "Modification Confirmation Email sent to Customer, with a URL that provides them with a way to log back in.";
																				/**/
																				if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["modification_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																					{
																						foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["modification_notification_urls"]) as $url)
																							/**/
																							if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["subscr_id"])), $url)))
																								if (($url = preg_replace ("/%%initial%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["initial"])), $url)) && ($url = preg_replace ("/%%regular%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["regular"])), $url)) && ($url = preg_replace ("/%%recurring%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["recurring"])), $url)))
																									if (($url = preg_replace ("/%%initial_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["initial_term"])), $url)) && ($url = preg_replace ("/%%regular_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["regular_term"])), $url)))
																										if (($url = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_number"])), $url)) && ($url = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_name"])), $url)))
																											if (($url = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["first_name"])), $url)) && ($url = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["last_name"])), $url)))
																												if (($url = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $url)))
																													if (($url = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["payer_email"])), $url)))
																														/**/
																														if (($url = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->first_name)), $url)) && ($url = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->last_name)), $url)))
																															if (($url = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($user->first_name . " " . $user->last_name))), $url)))
																																if (($url = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_email)), $url)))
																																	if (($url = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_login)), $url)))
																																		if (($url = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_reg_ip)), $url)))
																																			if (($url = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_id)), $url)))
																																				{
																																					if (is_array ($fields) && !empty ($fields))
																																						foreach ($fields as $var => $val) /* Custom Registration Fields. */
																																							if (!($url = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (maybe_serialize ($val))), $url)))
																																								break;
																																					/**/
																																					if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																																						c_ws_plugin__s2member_utils_urls::remote ($url);
																																				}
																						/**/
																						$paypal["s2member_log"][] = "Modification Notification URLs have been processed.";
																					}
																				/**/
																				if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["modification_notification_recipients"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																					{
																						$msg = $sbj = "( s2Member / API Notification Email ) - Modification";
																						$msg .= "\n\n"; /* Spacing in the message body. */
																						/**/
																						$msg .= "subscr_id: %%subscr_id%%\n";
																						$msg .= "initial: %%initial%%\n";
																						$msg .= "regular: %%regular%%\n";
																						$msg .= "recurring: %%recurring%%\n";
																						$msg .= "initial_term: %%initial_term%%\n";
																						$msg .= "regular_term: %%regular_term%%\n";
																						$msg .= "item_number: %%item_number%%\n";
																						$msg .= "item_name: %%item_name%%\n";
																						$msg .= "first_name: %%first_name%%\n";
																						$msg .= "last_name: %%last_name%%\n";
																						$msg .= "full_name: %%full_name%%\n";
																						$msg .= "payer_email: %%payer_email%%\n";
																						/**/
																						$msg .= "user_first_name: %%user_first_name%%\n";
																						$msg .= "user_last_name: %%user_last_name%%\n";
																						$msg .= "user_full_name: %%user_full_name%%\n";
																						$msg .= "user_email: %%user_email%%\n";
																						$msg .= "user_login: %%user_login%%\n";
																						$msg .= "user_ip: %%user_ip%%\n";
																						$msg .= "user_id: %%user_id%%\n";
																						/**/
																						if (is_array ($fields) && !empty ($fields))
																							foreach ($fields as $var => $val)
																								$msg .= $var . ": %%" . $var . "%%\n";
																						/**/
																						$msg .= "cv0: %%cv0%%\n";
																						$msg .= "cv1: %%cv1%%\n";
																						$msg .= "cv2: %%cv2%%\n";
																						$msg .= "cv3: %%cv3%%\n";
																						$msg .= "cv4: %%cv4%%\n";
																						$msg .= "cv5: %%cv5%%\n";
																						$msg .= "cv6: %%cv6%%\n";
																						$msg .= "cv7: %%cv7%%\n";
																						$msg .= "cv8: %%cv8%%\n";
																						$msg .= "cv9: %%cv9%%";
																						/**/
																						if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["subscr_id"]), $msg)))
																							if (($msg = preg_replace ("/%%initial%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["initial"]), $msg)) && ($msg = preg_replace ("/%%regular%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["regular"]), $msg)) && ($msg = preg_replace ("/%%recurring%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["recurring"]), $msg)))
																								if (($msg = preg_replace ("/%%initial_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["initial_term"]), $msg)) && ($msg = preg_replace ("/%%regular_term%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["regular_term"]), $msg)))
																									if (($msg = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $msg)) && ($msg = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $msg)))
																										if (($msg = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $msg)) && ($msg = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $msg)))
																											if (($msg = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $msg)))
																												if (($msg = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $msg)))
																													/**/
																													if (($msg = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->first_name), $msg)) && ($msg = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->last_name), $msg)))
																														if (($msg = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($user->first_name . " " . $user->last_name)), $msg)))
																															if (($msg = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->user_email), $msg)))
																																if (($msg = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->user_login), $msg)))
																																	if (($msg = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_reg_ip), $msg)))
																																		if (($msg = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_id), $msg)))
																																			{
																																				if (is_array ($fields) && !empty ($fields))
																																					foreach ($fields as $var => $val) /* Custom Registration Fields. */
																																						if (!($msg = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (maybe_serialize ($val)), $msg)))
																																							break;
																																				/**/
																																				if (($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																																					foreach (c_ws_plugin__s2member_utils_strings::trim_deep (preg_split ("/;+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["modification_notification_recipients"])) as $recipient)
																																						($recipient) ? wp_mail ($recipient, apply_filters ("ws_plugin__s2member_modification_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_modification_notification_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") : null;
																																			}
																						/**/
																						$paypal["s2member_log"][] = "Modification Notification Emails have been processed.";
																					}
																				/**/
																				eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																				do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_modify", get_defined_vars ());
																				unset ($__refs, $__v); /* Unset defined __refs, __v. */
																			}
																		else
																			$paypal["s2member_log"][] = "Unable to modify Subscription. The existing User ID is associated with an Administrator. Stopping here. Otherwise, an Administrator could lose access.";
																	}
																else
																	$paypal["s2member_log"][] = "Unable to modify Subscription. Could not get the existing User ID from the DB.";
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_modify", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/*
														Subscription payment notifications.
														We need these to update: `s2member_last_payment_time`.
														*/
														else if (/**/(preg_match ("/^(subscr_payment|recurring_payment)$/i", $paypal["txn_type"]))/**/
														&& ($paypal["item_number"] || ($paypal["item_number"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_number ($paypal)))/**/
														&& (preg_match ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["membership_item_number_regex"], $paypal["item_number"])) /* Membership. */
														&& ($paypal["subscr_id"] || ($paypal["subscr_id"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_subscr_id ($paypal)))/**/
														&& (!preg_match ($payment_status_issues, $paypal["payment_status"])) /* Status OK? This goes thru a list of known status issues. */
														&& ($paypal["item_name"] || ($paypal["item_name"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_name ($paypal)))/**/
														&& ($paypal["payer_email"] || ($paypal["payer_email"] = c_ws_plugin__s2member_utils_users::get_user_email_with ($paypal["subscr_id"])))/**/
														&& ($paypal["txn_id"] && $paypal["mc_gross"])/**/)
															{
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_payment", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "s2Member txn_type identified as " . ($identified_as = "subscr_payment|recurring_payment") . ".";
																$paypal["s2member_log"][] = "Sleeping for 5 seconds. Waiting for a possible subscr_signup|subscr_modify|recurring_payment_profile_created.";
																sleep(5); /* Sleep here for a moment. PayPal® sometimes sends a subscr_payment before the subscr_signup, subscr_modify. */
																/* It is NOT a big deal if they do. However, s2Member goes to sleep here, just to help keep the log files in a logical order. */
																$paypal["s2member_log"][] = "Awake. It's " . date ("D M j, Y g:i:s a T") . ". s2Member txn_type identified as " . $identified_as . ".";
																/**/
																list ($paypal["level"], $paypal["ccaps"]) = preg_split ("/\:/", $paypal["item_number"], 2);
																/**/
																$paypal["ip"] = (preg_match ("/ip address/i", $paypal["option_name2"]) && $paypal["option_selection2"]) ? $paypal["option_selection2"] : "";
																$paypal["ip"] = (!$paypal["ip"] && preg_match ("/^[0-9]+~[0-9\.]+$/", $paypal["invoice"])) ? preg_replace ("/^[0-9]+~/", "", $paypal["invoice"]) : $paypal["ip"];
																/**/
																if (($user_id = c_ws_plugin__s2member_utils_users::get_user_id_with ($paypal["subscr_id"])) && is_object ($user = new WP_User ($user_id)) && $user->ID)
																	{
																		$processing = $during = true; /* Yes, we ARE processing this. */
																		/**/
																		$pr_times = get_user_option ("s2member_paid_registration_times", $user_id);
																		$pr_times["level"] = (!$pr_times["level"]) ? time () : $pr_times["level"]; /* Preserves existing. */
																		$pr_times["level" . $paypal["level"]] = (!$pr_times["level" . $paypal["level"]]) ? time () : $pr_times["level" . $paypal["level"]];
																		update_user_option ($user_id, "s2member_paid_registration_times", $pr_times); /* Update now. */
																		/**/
																		if (!get_user_option ("s2member_first_payment_txn_id", $user_id)) /* 1st payment? */
																			update_user_option ($user_id, "s2member_first_payment_txn_id", $paypal["txn_id"]);
																		/**/
																		update_user_option ($user_id, "s2member_last_payment_time", time ()); /* Also update last payment time. */
																		/**/
																		$paypal["s2member_log"][] = "Updated Payment Times for this Member."; /* Flag this action in the log. */
																		/**/
																		$fields = get_user_option ("s2member_custom_fields", $user_id); /* These will be needed in the routines below. */
																		$user_reg_ip = get_user_option ("s2member_registration_ip", $user_id); /* Original IP during Registration. */
																		$user_reg_ip = $paypal["ip"] = ($user_reg_ip) ? $user_reg_ip : $paypal["ip"]; /* Now merge conditionally. */
																		/**/
																		if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																			{
																				foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_urls"]) as $url)
																					/**/
																					if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["subscr_id"])), $url)))
																						if (($url = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["mc_gross"])), $url)) && ($url = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["txn_id"])), $url)))
																							if (($url = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_number"])), $url)) && ($url = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_name"])), $url)))
																								if (($url = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["first_name"])), $url)) && ($url = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["last_name"])), $url)))
																									if (($url = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $url)))
																										if (($url = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["payer_email"])), $url)))
																											{
																												if (($url = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->first_name)), $url)) && ($url = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->last_name)), $url)))
																													if (($url = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($user->first_name . " " . $user->last_name))), $url)))
																														if (($url = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_email)), $url)))
																															if (($url = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_login)), $url)))
																																if (($url = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_reg_ip)), $url)))
																																	if (($url = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_id)), $url)))
																																		{
																																			if (is_array ($fields) && !empty ($fields))
																																				foreach ($fields as $var => $val) /* Custom Registration Fields. */
																																					if (!($url = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (maybe_serialize ($val))), $url)))
																																						break;
																																			/**/
																																			if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																																				c_ws_plugin__s2member_utils_urls::remote ($url);
																																		}
																											}
																				/**/
																				$paypal["s2member_log"][] = "Payment Notification URLs have been processed.";
																			}
																		/**/
																		if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_recipients"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																			{
																				$msg = $sbj = "( s2Member / API Notification Email ) - Payment";
																				$msg .= "\n\n"; /* Spacing in the message body. */
																				/**/
																				$msg .= "subscr_id: %%subscr_id%%\n";
																				$msg .= "amount: %%amount%%\n";
																				$msg .= "txn_id: %%txn_id%%\n";
																				$msg .= "item_number: %%item_number%%\n";
																				$msg .= "item_name: %%item_name%%\n";
																				$msg .= "first_name: %%first_name%%\n";
																				$msg .= "last_name: %%last_name%%\n";
																				$msg .= "full_name: %%full_name%%\n";
																				$msg .= "payer_email: %%payer_email%%\n";
																				/**/
																				$msg .= "user_first_name: %%user_first_name%%\n";
																				$msg .= "user_last_name: %%user_last_name%%\n";
																				$msg .= "user_full_name: %%user_full_name%%\n";
																				$msg .= "user_email: %%user_email%%\n";
																				$msg .= "user_login: %%user_login%%\n";
																				$msg .= "user_ip: %%user_ip%%\n";
																				$msg .= "user_id: %%user_id%%\n";
																				/**/
																				if (is_array ($fields) && !empty ($fields))
																					foreach ($fields as $var => $val)
																						$msg .= $var . ": %%" . $var . "%%\n";
																				/**/
																				$msg .= "cv0: %%cv0%%\n";
																				$msg .= "cv1: %%cv1%%\n";
																				$msg .= "cv2: %%cv2%%\n";
																				$msg .= "cv3: %%cv3%%\n";
																				$msg .= "cv4: %%cv4%%\n";
																				$msg .= "cv5: %%cv5%%\n";
																				$msg .= "cv6: %%cv6%%\n";
																				$msg .= "cv7: %%cv7%%\n";
																				$msg .= "cv8: %%cv8%%\n";
																				$msg .= "cv9: %%cv9%%";
																				/**/
																				if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["subscr_id"]), $msg)))
																					if (($msg = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_gross"]), $msg)) && ($msg = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["txn_id"]), $msg)))
																						if (($msg = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $msg)) && ($msg = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $msg)))
																							if (($msg = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $msg)) && ($msg = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $msg)))
																								if (($msg = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $msg)))
																									if (($msg = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $msg)))
																										{
																											if (($msg = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->first_name), $msg)) && ($msg = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->last_name), $msg)))
																												if (($msg = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($user->first_name . " " . $user->last_name)), $msg)))
																													if (($msg = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->user_email), $msg)))
																														if (($msg = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->user_login), $msg)))
																															if (($msg = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_reg_ip), $msg)))
																																if (($msg = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_id), $msg)))
																																	{
																																		if (is_array ($fields) && !empty ($fields))
																																			foreach ($fields as $var => $val) /* Custom Registration Fields. */
																																				if (!($msg = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (maybe_serialize ($val)), $msg)))
																																					break;
																																		/**/
																																		if (($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																																			foreach (c_ws_plugin__s2member_utils_strings::trim_deep (preg_split ("/;+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_recipients"])) as $recipient)
																																				($recipient) ? wp_mail ($recipient, apply_filters ("ws_plugin__s2member_payment_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_payment_notification_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") : null;
																																	}
																										}
																				/**/
																				$paypal["s2member_log"][] = "Payment Notification Emails have been processed.";
																			}
																		/**/
																		eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																		do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_payment", get_defined_vars ());
																		unset ($__refs, $__v); /* Unset defined __refs, __v. */
																	}
																else /* Otherwise, we need to re-generate/store this IPN into a Transient Queue. Then re-process it on registration. */
																	{
																		$paypal["s2member_log"][] = "Skipping this IPN response, for now. The Subscr. ID is not associated with a registered Member.";
																		/**/
																		$ipn = array ("txn_type" => "subscr_payment"); /* Create a simulated IPN response for txn_type=subscr_payment. */
																		/**/
																		foreach ($paypal as $var => $val)
																			if (in_array ($var, array ("subscr_gateway", "subscr_id", "txn_id", "custom", "invoice", "mc_gross", "mc_currency", "tax", "payer_email", "first_name", "last_name", "item_name", "item_number", "option_name1", "option_selection1", "option_name2", "option_selection2")))
																				$ipn[$var] = $val;
																		/**/
																		$paypal["s2member_log"][] = "Re-generating. This IPN will go into a Transient Queue; and be re-processed during registration.";
																		/**/
																		set_transient ("s2m_" . md5 ("s2member_transient_ipn_subscr_payment_" . $paypal["subscr_id"]), $ipn, 43200);
																	}
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_payment", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/*
														Subscription failed payment notifications.
														This is not really necessary. It is only here because this txn_type could
														be necessary in a future release of s2Member. For now, it's just a fill-in.
														These Hooks/Filters will remain, so you can use them now; if you need to.
														*/
														else if (/**/(preg_match ("/^(subscr_failed|recurring_payment_failed|recurring_payment_skipped)$/i", $paypal["txn_type"]))/**/
														&& ($paypal["item_number"] || ($paypal["item_number"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_number ($paypal)))/**/
														&& (preg_match ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["membership_item_number_regex"], $paypal["item_number"])) /* Membership. */
														&& ($paypal["subscr_id"] || ($paypal["subscr_id"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_subscr_id ($paypal)))/**/
														&& ($paypal["item_name"] || ($paypal["item_name"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_name ($paypal)))/**/
														&& ($paypal["payer_email"] || ($paypal["payer_email"] = c_ws_plugin__s2member_utils_users::get_user_email_with ($paypal["subscr_id"])))/**/)
															{
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_failed", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "s2Member txn_type identified as subscr_failed|recurring_payment_failed|recurring_payment_skipped.";
																/**/
																$processing = $during = true; /* Yes, we ARE processing this. */
																/**/
																$paypal["s2member_log"][] = "This txn_type does not require any action on the part of s2Member.";
																$paypal["s2member_log"][] = "s2Member does NOT respond to individual failed payments, only multiple consecutive failed payments.";
																$paypal["s2member_log"][] = "When multiple consecutive payments fail, a special IPN response will be triggered.";
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_failed", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_failed", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/*
														Subscription cancellations. s2Member can use this, to determine when/if it should Auto-EOT (demote|delete) a Member's account.
														This processing routine for `subscr_cancel` is compatible with newer PayPal® accounts that do NOT send a subscr_eot after cancellation.
														This works in conjunction with `s2member_last_payment_time`, and the s2Member Auto-EOT System.
														For further details, see: https://www.x.com/thread/41155?start=15&tstart=0
														*/
														else if (/**/(preg_match ("/^(subscr_cancel|recurring_payment_profile_cancel)$/i", $paypal["txn_type"]))/**/
														&& !(preg_match ("/^recurring_payment_profile_cancel$/i", $paypal["txn_type"]) && preg_match ("/^failed$/i", $paypal["initial_payment_status"]))
														/* ^^ Bypass this case ( for now ) "recurring_payment_profile_cancel" with an initial failed payment warrants an EOT instead of a cancellation. */
														&& ($paypal["item_number"] || ($paypal["item_number"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_number ($paypal))) /* item_number? */
														&& (preg_match ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["membership_item_number_regex"], $paypal["item_number"])) /* Must match Membership Access. */
														&& ($paypal["period1"] || ($paypal["period1"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_period1 ($paypal)) || ($paypal["period1"] = "0 D"))/**/
														&& ($paypal["period3"] || ($paypal["period3"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_period3 ($paypal))) /* Must have a period3 value. */
														&& ($paypal["subscr_id"] || ($paypal["subscr_id"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_subscr_id ($paypal))) /* Must have this. */
														&& ($paypal["item_name"] || ($paypal["item_name"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_name ($paypal))) /* Must have this. */
														&& ($paypal["payer_email"] || ($paypal["payer_email"] = c_ws_plugin__s2member_utils_users::get_user_email_with ($paypal["subscr_id"])))/**/)
															{
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_cancel", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "s2Member txn_type identified as subscr_cancel|recurring_payment_profile_cancel.";
																/**/
																list ($paypal["level"], $paypal["ccaps"]) = preg_split ("/\:/", $paypal["item_number"], 2);
																/**/
																$paypal["ip"] = (preg_match ("/ip address/i", $paypal["option_name2"]) && $paypal["option_selection2"]) ? $paypal["option_selection2"] : "";
																$paypal["ip"] = (!$paypal["ip"] && preg_match ("/^[0-9]+~[0-9\.]+$/", $paypal["invoice"])) ? preg_replace ("/^[0-9]+~/", "", $paypal["invoice"]) : $paypal["ip"];
																/**/
																if (($user_id = c_ws_plugin__s2member_utils_users::get_user_id_with ($paypal["subscr_id"])) && is_object ($user = new WP_User ($user_id)) && $user->ID)
																	{
																		if (!$user->has_cap ("administrator")) /* Do NOT process this routine on Administrators. */
																			{
																				$fields = get_user_option ("s2member_custom_fields", $user_id); /* These will be needed in the routines below. */
																				$user_reg_ip = get_user_option ("s2member_registration_ip", $user_id); /* Original IP during Registration. */
																				$user_reg_ip = $paypal["ip"] = ($user_reg_ip) ? $user_reg_ip : $paypal["ip"]; /* Now merge conditionally. */
																				/**/
																				if (!get_user_option ("s2member_auto_eot_time", $user_id)) /* Respect existing. */
																					{
																						$processing = $during = true; /* Yes, we ARE processing this. */
																						/**/
																						$auto_eot_time = c_ws_plugin__s2member_utils_time::auto_eot_time ($user_id, $paypal["period1"], $paypal["period3"]);
																						/**/
																						update_user_option ($user_id, "s2member_auto_eot_time", $auto_eot_time); /* s2Member follows-up later. */
																						/**/
																						$paypal["s2member_log"][] = "Auto-EOT Time for this account: " . date ("D M j, Y g:i a T", $auto_eot_time);
																						/**/
																						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																						do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_cancel", get_defined_vars ());
																						unset ($__refs, $__v); /* Unset defined __refs, __v. */
																					}
																				else
																					$paypal["s2member_log"][] = "Ignoring Cancellation. An Auto-EOT Time is already set for this Member. An s2Member API Notification will still be processed however.";
																				/**/
																				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["cancellation_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																					{
																						foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["cancellation_notification_urls"]) as $url) /* Handle Cancellation Notifications. */
																							/**/
																							if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["subscr_id"])), $url)))
																								if (($url = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_number"])), $url)) && ($url = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_name"])), $url)))
																									if (($url = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->first_name)), $url)) && ($url = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->last_name)), $url)))
																										if (($url = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($user->first_name . " " . $user->last_name))), $url)))
																											if (($url = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_email)), $url)))
																												if (($url = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_login)), $url)))
																													if (($url = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_reg_ip)), $url)))
																														if (($url = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_id)), $url)))
																															{
																																if (is_array ($fields) && !empty ($fields))
																																	foreach ($fields as $var => $val) /* Custom Registration Fields. */
																																		if (!($url = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (maybe_serialize ($val))), $url)))
																																			break;
																																/**/
																																if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																																	c_ws_plugin__s2member_utils_urls::remote ($url);
																															}
																						/**/
																						$paypal["s2member_log"][] = "Cancellation Notification URLs have been processed.";
																					}
																				/**/
																				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["cancellation_notification_recipients"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																					{
																						$msg = $sbj = "( s2Member / API Notification Email ) - Cancellation";
																						$msg .= "\n\n"; /* Spacing in the message body. */
																						/**/
																						$msg .= "subscr_id: %%subscr_id%%\n";
																						$msg .= "item_number: %%item_number%%\n";
																						$msg .= "item_name: %%item_name%%\n";
																						$msg .= "user_first_name: %%user_first_name%%\n";
																						$msg .= "user_last_name: %%user_last_name%%\n";
																						$msg .= "user_full_name: %%user_full_name%%\n";
																						$msg .= "user_email: %%user_email%%\n";
																						$msg .= "user_login: %%user_login%%\n";
																						$msg .= "user_ip: %%user_ip%%\n";
																						$msg .= "user_id: %%user_id%%\n";
																						/**/
																						if (is_array ($fields) && !empty ($fields))
																							foreach ($fields as $var => $val)
																								$msg .= $var . ": %%" . $var . "%%\n";
																						/**/
																						$msg .= "cv0: %%cv0%%\n";
																						$msg .= "cv1: %%cv1%%\n";
																						$msg .= "cv2: %%cv2%%\n";
																						$msg .= "cv3: %%cv3%%\n";
																						$msg .= "cv4: %%cv4%%\n";
																						$msg .= "cv5: %%cv5%%\n";
																						$msg .= "cv6: %%cv6%%\n";
																						$msg .= "cv7: %%cv7%%\n";
																						$msg .= "cv8: %%cv8%%\n";
																						$msg .= "cv9: %%cv9%%";
																						/**/
																						if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["subscr_id"]), $msg)))
																							if (($msg = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $msg)) && ($msg = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $msg)))
																								if (($msg = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->first_name), $msg)) && ($msg = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->last_name), $msg)))
																									if (($msg = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($user->first_name . " " . $user->last_name)), $msg)))
																										if (($msg = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->user_email), $msg)))
																											if (($msg = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->user_login), $msg)))
																												if (($msg = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_reg_ip), $msg)))
																													if (($msg = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_id), $msg)))
																														{
																															if (is_array ($fields) && !empty ($fields))
																																foreach ($fields as $var => $val) /* Custom Registration Fields. */
																																	if (!($msg = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (maybe_serialize ($val)), $msg)))
																																		break;
																															/**/
																															if (($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																																foreach (c_ws_plugin__s2member_utils_strings::trim_deep (preg_split ("/;+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["cancellation_notification_recipients"])) as $recipient)
																																	($recipient) ? wp_mail ($recipient, apply_filters ("ws_plugin__s2member_cancellation_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_cancellation_notification_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") : null;
																														}
																						/**/
																						$paypal["s2member_log"][] = "Cancellation Notification Emails have been processed.";
																					}
																			}
																		else
																			$paypal["s2member_log"][] = "Ignoring Cancellation. The existing User ID is associated with an Administrator. Stopping here. Otherwise, an Administrator could lose access.";
																	}
																else
																	$paypal["s2member_log"][] = "Unable to handle Cancellation. Could not get the existing User ID from the DB.";
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_cancel", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/*
														Subscription terminations, max failed payments, initial payment failed, chargebacks, refunds, and reversals.
														An immediate EOT is necessary under MANY different conditions. However, in some cases, a delayed EOT is required.
															Delayed EOTs work in conjunction with `s2member_last_payment_time`, and the s2Member Auto-EOT System.
														
														~ NOTE: newer PayPal® accounts ( i.e. Billing Profiles that start with "I-" ), will trigger a "subscr_eot" upon last payment.
															So those are treated as delayed EOTs - ( s2Member was updated at v3.2.3 to deal with this scenario gracefully ).
															In the case of "subscr_eot" with "I-", s2Member calculates the EOT Time, and records it for future processing.
														
														~ NOTE: "new_case" with "case_type=chargeback" is NOT actually processed. It's only been integrated for the future compatibility.
															At this time, PayPal® doesn't send enough information through "new_case" transactions for s2Member to process anything.
															However, that's OK. Refunds and Reversals ( i.e. chargebacks ) are still detected through "payment_status".
														
														~ NOTE: Partial Refunds ( i.e. payment_status=partially_refunded or txn_type=adjustment ) are NOT processed by this routine.
															( This is the intended behavior. A Partial Refund does NOT clearly indicate that s2Member should do anything at all. )
															HOWEVER. PayPal® does NOT always send payment_status=partially_refunded. This is well documented on their site, but in
																practice, it never seems to happen. It's best to check the negative mc_gross amount instead.
														*/
														else if (/**/( /* Partial Refunds ( i.e. payment_status=partially_refunded or txn_type=adjustment ) are NOT processed by this routine. */
														(preg_match ("/^(subscr_eot|recurring_payment_expired|recurring_payment_suspended_due_to_max_failed_payment)$/i", $paypal["txn_type"]) && ($recurring = 1))/**/
														|| (preg_match ("/^recurring_payment_profile_cancel$/i", $paypal["txn_type"]) && preg_match ("/^failed$/i", $paypal["initial_payment_status"]) && ($recurring = 1))/**/
														|| (preg_match ("/^new_case$/i", $paypal["txn_type"]) && preg_match ("/^chargeback$/i", $paypal["case_type"])) /* ONLY for future compatibility. This does NOT work yet. */
														|| (preg_match ("/^(refunded|reversed|reversal)$/i", $paypal["payment_status"])) /* The "txn_type" is irrelevant in all of these cases: refunded|reversed|reversal. */)/**/
														&& ($paypal["period1"] || ($paypal["period1"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_period1 ($paypal)) || !$recurring || ($paypal["period1"] = "0 D"))/**/
														&& ($paypal["period3"] || ($paypal["period3"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_period3 ($paypal)) || !$recurring) /* Was it even recurring? */
														&& ($paypal["item_number"] || ($paypal["item_number"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_number ($paypal))) /* Do we have a valid item_number? */
														&& (preg_match ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["membership_item_number_regex"], $paypal["item_number"])) /* Only for "Membership", NOT for Specific Posts/Pages. */
														&& ($paypal["subscr_id"] || ($paypal["subscr_id"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_subscr_id ($paypal)) || ($paypal["subscr_id"] = $paypal["parent_txn_id"]))/**/
														&& ($paypal["item_name"] || ($paypal["item_name"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_name ($paypal)) || ($paypal["item_name"] = $_SERVER["HTTP_HOST"]))/**/
														/* The item_name can default to HTTP_HOST because we've seen payment_status=reversed come through WITHOUT a product_name or item_name given. */
														&& ($paypal["payer_email"] || ($paypal["payer_email"] = c_ws_plugin__s2member_utils_users::get_user_email_with ($paypal["subscr_id"])))/**/)
															{
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_eot", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$is_refund = (preg_match ("/^refunded$/i", $paypal["payment_status"]) && $paypal["parent_txn_id"]);
																$is_reversal = (preg_match ("/^(reversed|reversal)$/i", $paypal["payment_status"]) && $paypal["parent_txn_id"]);
																$is_reversal = (!$is_reversal) ? (preg_match ("/^new_case$/i", $paypal["txn_type"]) && preg_match ("/^chargeback$/i", $paypal["case_type"])) : $is_reversal;
																$is_refund_or_reversal = ($is_refund || $is_reversal); /* If either of the previous tests above evaluated to true; then it's obviously a Refund and/or a Reversal. */
																$is_delayed_eot = (!$is_refund_or_reversal && preg_match ("/^(subscr_eot|recurring_payment_expired)$/i", $paypal["txn_type"]) && preg_match ("/^I-/i", $paypal["subscr_id"]));
																/**/
																if ($is_refund_or_reversal)
																	$paypal["s2member_log"][] = "s2Member txn_type identified as " . ($identified_as = "[empty or irrelevant] w/ payment_status (refunded|reversed|reversal) - or - new_case w/ case_type (chargeback)") . ".";
																else
																	$paypal["s2member_log"][] = "s2Member txn_type identified as " . ($identified_as = "(subscr_eot|recurring_payment_expired|recurring_payment_suspended_due_to_max_failed_payment) - or - recurring_payment_profile_cancel w/ initial_payment_status (failed)") . ".";
																/**/
																$paypal["s2member_log"][] = "Sleeping for 5 seconds. Waiting for a possible subscr_signup|subscr_modify|recurring_payment_profile_created.";
																sleep(5); /* Sleep here for a moment. PayPal® sometimes sends a subscr_eot before the subscr_signup, subscr_modify. */
																/* It is NOT a big deal if they do. However, s2Member goes to sleep here, just to help keep the log files in a logical order. */
																$paypal["s2member_log"][] = "Awake. It's " . date ("D M j, Y g:i:s a T") . ". s2Member txn_type identified as " . $identified_as . ".";
																/**/
																$paypal["ip"] = (preg_match ("/ip address/i", $paypal["option_name2"]) && $paypal["option_selection2"]) ? $paypal["option_selection2"] : "";
																$paypal["ip"] = (!$paypal["ip"] && preg_match ("/^[0-9]+~[0-9\.]+$/", $paypal["invoice"])) ? preg_replace ("/^[0-9]+~/", "", $paypal["invoice"]) : $paypal["ip"];
																/**/
																if (($user_id = c_ws_plugin__s2member_utils_users::get_user_id_with ($paypal["subscr_id"])) && is_object ($user = new WP_User ($user_id)) && $user->ID)
																	{
																		$fields = get_user_option ("s2member_custom_fields", $user_id); /* These will be needed below. */
																		$user_reg_ip = get_user_option ("s2member_registration_ip", $user_id); /* Needed below. */
																		$user_reg_ip = $paypal["ip"] = ($user_reg_ip) ? $user_reg_ip : $paypal["ip"];
																		/**/
																		if ( /* Here we take action, BUT based on Auto EOT Behavior options; as configured by the Site Owner. */
																		(!$is_refund_or_reversal && !$is_delayed_eot && !get_user_option ("s2member_auto_eot_time", $user_id))/**/
																		|| ($is_refund_or_reversal && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["triggers_immediate_eot"] === "refunds,reversals")/**/
																		|| ($is_reversal && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["triggers_immediate_eot"] === "reversals")/**/
																		|| ($is_refund && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["triggers_immediate_eot"] === "refunds")/**/)
																			{
																				if (!$user->has_cap ("administrator")) /* Do NOT process this routine on Administrators. */
																					{
																						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["auto_eot_system_enabled"]) /* EOT enabled? */
																							{
																								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_eot_behavior"] === "demote")
																									{
																										$processing = $during = true; /* Yes, we ARE processing this. */
																										/**/
																										$eot_del_type = ($is_refund_or_reversal) ? /* Set EOT/Del type. */
																										"ipn-refund-reversal-demotion" : "ipn-cancellation-expiration-demotion";
																										/**/
																										$demotion_role = c_ws_plugin__s2member_option_forces::force_demotion_role ("subscriber");
																										$existing_role = c_ws_plugin__s2member_user_access::user_access_role ($user);
																										/**/
																										eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																										do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_eot_before_demote", get_defined_vars ());
																										do_action ("ws_plugin__s2member_during_collective_mods", $user_id, get_defined_vars (), $eot_del_type, "modification", $demotion_role);
																										do_action ("ws_plugin__s2member_during_collective_eots", $user_id, get_defined_vars (), $eot_del_type, "modification");
																										unset ($__refs, $__v); /* Unset defined __refs, __v. */
																										/**/
																										if ($existing_role !== $demotion_role) /* Only if NOT the existing Role. */
																											$user->set_role ($demotion_role); /* Give User the demotion Role. */
																										/**/
																										foreach ($user->allcaps as $cap => $cap_enabled)
																											if (preg_match ("/^access_s2member_ccap_/", $cap))
																												$user->remove_cap ($ccap = $cap);
																										/**/
																										delete_user_option ($user_id, "s2member_custom");
																										delete_user_option ($user_id, "s2member_subscr_id");
																										delete_user_option ($user_id, "s2member_subscr_gateway");
																										/**/
																										delete_user_option ($user_id, "s2member_ipn_signup_vars");
																										/**/
																										if (!apply_filters ("ws_plugin__s2member_preserve_paid_registration_times", true, get_defined_vars ()))
																											delete_user_option ($user_id, "s2member_paid_registration_times");
																										/**/
																										delete_user_option ($user_id, "s2member_last_status_scan");
																										delete_user_option ($user_id, "s2member_first_payment_txn_id");
																										delete_user_option ($user_id, "s2member_last_payment_time");
																										delete_user_option ($user_id, "s2member_auto_eot_time");
																										/**/
																										delete_user_option ($user_id, "s2member_file_download_access_arc");
																										delete_user_option ($user_id, "s2member_file_download_access_log");
																										/**/
																										c_ws_plugin__s2member_user_notes::append_user_notes ($user_id, "Demoted by s2Member: " . date ("D M j, Y g:i a T"));
																										/**/
																										$paypal["s2member_log"][] = "Member Level/Capabilities demoted to: " . ucwords (preg_replace ("/_/", " ", $demotion_role)) . ".";
																										/**/
																										if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																											{
																												foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"]) as $url) /* Handle EOT Notifications. */
																													/**/
																													if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%eot_del_type%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($eot_del_type)), $url)) && ($url = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["subscr_id"])), $url)))
																														if (($url = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->first_name)), $url)) && ($url = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->last_name)), $url)))
																															if (($url = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($user->first_name . " " . $user->last_name))), $url)))
																																if (($url = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_email)), $url)))
																																	if (($url = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_login)), $url)))
																																		if (($url = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_reg_ip)), $url)))
																																			if (($url = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_id)), $url)))
																																				{
																																					if (is_array ($fields) && !empty ($fields))
																																						foreach ($fields as $var => $val) /* Custom Registration Fields. */
																																							if (!($url = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (maybe_serialize ($val))), $url)))
																																								break;
																																					/**/
																																					if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																																						c_ws_plugin__s2member_utils_urls::remote ($url);
																																				}
																												/**/
																												$paypal["s2member_log"][] = "EOT/Deletion Notification URLs have been processed.";
																											}
																										/**/
																										if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_recipients"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																											{
																												$msg = $sbj = "( s2Member / API Notification Email ) - EOT/Deletion";
																												$msg .= "\n\n"; /* Spacing in the message body. */
																												/**/
																												$msg .= "eot_del_type: %%eot_del_type%%\n";
																												$msg .= "subscr_id: %%subscr_id%%\n";
																												$msg .= "user_first_name: %%user_first_name%%\n";
																												$msg .= "user_last_name: %%user_last_name%%\n";
																												$msg .= "user_full_name: %%user_full_name%%\n";
																												$msg .= "user_email: %%user_email%%\n";
																												$msg .= "user_login: %%user_login%%\n";
																												$msg .= "user_ip: %%user_ip%%\n";
																												$msg .= "user_id: %%user_id%%\n";
																												/**/
																												if (is_array ($fields) && !empty ($fields))
																													foreach ($fields as $var => $val)
																														$msg .= $var . ": %%" . $var . "%%\n";
																												/**/
																												$msg .= "cv0: %%cv0%%\n";
																												$msg .= "cv1: %%cv1%%\n";
																												$msg .= "cv2: %%cv2%%\n";
																												$msg .= "cv3: %%cv3%%\n";
																												$msg .= "cv4: %%cv4%%\n";
																												$msg .= "cv5: %%cv5%%\n";
																												$msg .= "cv6: %%cv6%%\n";
																												$msg .= "cv7: %%cv7%%\n";
																												$msg .= "cv8: %%cv8%%\n";
																												$msg .= "cv9: %%cv9%%";
																												/**/
																												if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%eot_del_type%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($eot_del_type), $msg)) && ($msg = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["subscr_id"]), $msg)))
																													if (($msg = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->first_name), $msg)) && ($msg = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->last_name), $msg)))
																														if (($msg = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($user->first_name . " " . $user->last_name)), $msg)))
																															if (($msg = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->user_email), $msg)))
																																if (($msg = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->user_login), $msg)))
																																	if (($msg = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_reg_ip), $msg)))
																																		if (($msg = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_id), $msg)))
																																			{
																																				if (is_array ($fields) && !empty ($fields))
																																					foreach ($fields as $var => $val) /* Custom Registration Fields. */
																																						if (!($msg = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (maybe_serialize ($val)), $msg)))
																																							break;
																																				/**/
																																				if (($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																																					foreach (c_ws_plugin__s2member_utils_strings::trim_deep (preg_split ("/;+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_recipients"])) as $recipient)
																																						($recipient) ? wp_mail ($recipient, apply_filters ("ws_plugin__s2member_eot_del_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_eot_del_notification_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") : null;
																																			}
																												/**/
																												$paypal["s2member_log"][] = "EOT/Deletion Notification Emails have been processed.";
																											}
																										/**/
																										eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																										do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_eot_demote", get_defined_vars ());
																										unset ($__refs, $__v); /* Unset defined __refs, __v. */
																									}
																								/**/
																								else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_eot_behavior"] === "delete")
																									{
																										$processing = $during = true; /* Yes, we ARE processing this. */
																										/**/
																										$eot_del_type = $GLOBALS["ws_plugin__s2member_eot_del_type"] = /* Configure EOT/Del type. */
																										($is_refund_or_reversal) ? "ipn-refund-reversal-deletion" : "ipn-cancellation-expiration-deletion";
																										/**/
																										eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																										do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_eot_before_delete", get_defined_vars ());
																										do_action ("ws_plugin__s2member_during_collective_eots", $user_id, get_defined_vars (), $eot_del_type, "removal-deletion");
																										unset ($__refs, $__v); /* Unset defined __refs, __v. */
																										/**/
																										if (is_multisite ()) /* Multisite does NOT actually delete; ONLY removes. */
																											{
																												remove_user_from_blog ($user_id, $current_blog->blog_id);
																												/* This will automatically trigger `eot_del_notification_urls` as well. */
																												c_ws_plugin__s2member_user_deletions::handle_ms_user_deletions ($user_id, $current_blog->blog_id, "s2says");
																											}
																										/**/
																										else /* Otherwise, we can actually delete them. */
																											/* This will automatically trigger `eot_del_notification_urls` as well. */
																											wp_delete_user($user_id); /* `c_ws_plugin__s2member_user_deletions::handle_user_deletions()` */
																										/**/
																										$paypal["s2member_log"][] = "This Member's account has been " . ((is_multisite ()) ? "removed" : "deleted") . ".";
																										/**/
																										$paypal["s2member_log"][] = "EOT/Deletion Notification URLs have been processed.";
																										/**/
																										eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																										do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_eot_delete", get_defined_vars ());
																										unset ($__refs, $__v); /* Unset defined __refs, __v. */
																									}
																								/**/
																								eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																								do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_eot", get_defined_vars ());
																								unset ($__refs, $__v); /* Unset defined __refs, __v. */
																							}
																						/**/
																						else /* Otherwise, treat this as if it were a cancellation. EOTs are currently disabled. */
																							{
																								$processing = $during = true; /* Yes, we ARE processing this. */
																								/**/
																								update_user_option ($user_id, "s2member_auto_eot_time", ($auto_eot_time = strtotime ("now")));
																								/**/
																								$paypal["s2member_log"][] = "Auto-EOT is currently disabled. Skipping immediate EOT (demote|delete), for now.";
																								$paypal["s2member_log"][] = "Recording the Auto-EOT Time for this Member's account: " . date ("D M j, Y g:i a T", $auto_eot_time);
																								/**/
																								eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																								do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_eot_disabled", get_defined_vars ());
																								unset ($__refs, $__v); /* Unset defined __refs, __v. */
																							}
																					}
																				else
																					$paypal["s2member_log"][] = "Unable to (demote|delete) Member. The existing User ID is associated with an Administrator. Stopping here. Otherwise, an Administrator could lose access.";
																			}
																		/**/
																		else if ($is_delayed_eot && !get_user_option ("s2member_auto_eot_time", $user_id))
																			{
																				if (!$user->has_cap ("administrator")) /* Do NOT process this routine on Administrators. */
																					{
																						$processing = $during = true; /* Yes, we ARE processing this. */
																						/**/
																						$auto_eot_time = c_ws_plugin__s2member_utils_time::auto_eot_time ($user_id, $paypal["period1"], $paypal["period3"], "", time ());
																						/* We assume the last payment was today, because this is how newer PayPal® accounts function with respect to EOT handling.
																						Newer PayPal® accounts ( i.e. Subscription IDs starting with `I-`, will have their EOT triggered upon the last payment. */
																						update_user_option ($user_id, "s2member_auto_eot_time", $auto_eot_time); /* s2Member will follow-up on this later. */
																						/**/
																						$paypal["s2member_log"][] = "Auto-EOT Time for this account ( delayed ), set to: " . date ("D M j, Y g:i a T", $auto_eot_time);
																						/**/
																						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																						do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_eot_delayed", get_defined_vars ());
																						unset ($__refs, $__v); /* Unset defined __refs, __v. */
																					}
																				else
																					$paypal["s2member_log"][] = "Ignoring Delayed EOT. The existing User ID is associated with an Administrator. Stopping here. Otherwise, an Administrator could lose access.";
																			}
																		/**/
																		else if (!$is_refund_or_reversal || $is_delayed_eot)
																			$paypal["s2member_log"][] = "Skipping (demote|delete) Member, for now. An Auto-EOT Time is already set for this account. When an Auto-EOT Time has been recorded, s2Member will handle EOT (demote|delete) events using it's own Auto-EOT System - internally.";
																		/**/
																		else if ($is_reversal)
																			$paypal["s2member_log"][] = "Skipping (demote|delete) Member. Your configuration dictates that s2Member should NOT take any immediate action on an EOT associated with a Chargeback Reversal. An s2Member API Notification will still be processed however.";
																		/**/
																		else if ($is_refund)
																			$paypal["s2member_log"][] = "Skipping (demote|delete) Member. Your configuration dictates that s2Member should NOT take any immediate action on an EOT associated with a Refund. An s2Member API Notification will still be processed however.";
																	}
																else if ($is_delayed_eot) /* Otherwise, we need to re-generate/store this IPN into a Transient Queue. Then re-process it on registration. */
																	{
																		$paypal["s2member_log"][] = "Skipping this IPN response, for now. The Subscr. ID is not associated with a registered Member.";
																		/**/
																		$ipn = array ("txn_type" => "subscr_eot"); /* Create a simulated IPN response for txn_type=subscr_eot. */
																		/**/
																		foreach ($paypal as $var => $val)
																			if (in_array ($var, array ("subscr_gateway", "subscr_id", "custom", "invoice", "payer_email", "first_name", "last_name", "item_name", "item_number", "period1", "period3", "option_name1", "option_selection1", "option_name2", "option_selection2")))
																				$ipn[$var] = $val;
																		/**/
																		$paypal["s2member_log"][] = "Re-generating. This IPN will go into a Transient Queue; and be re-processed during registration.";
																		/**/
																		set_transient ("s2m_" . md5 ("s2member_transient_ipn_subscr_eot_" . $paypal["subscr_id"]), $ipn, 43200);
																	}
																/**/
																else
																	$paypal["s2member_log"][] = "Unable to (demote|delete) Member. Could not get the existing User ID from the DB. It's possible that it was ALREADY processed through another IPN, removed manually by a Site Administrator, or by s2Member's Auto-EOT Sys.";
																/*
																Refunds and chargeback reversals. This is excluded from the processing check, because a Member *could* have already been (demoted|deleted).
																In other words, s2Member sends `Refund/Reversal` Notifications ANYTIME a Refund/Reversal occurs; even if s2Member did not process it otherwise.
																Since this routine ignores the processing check, it is *possible* that Refund/Reversal Notification URLs will be contacted more than once.
																	If you're writing scripts that depend on Refund/Reversal Notifications, please keep this in mind.
																*/
																if ($is_refund_or_reversal) /* Here we access this variable that was previously assigned as a quick method of Refund/Reversal detection. */
																	{
																		$fields = ($user_id) ? get_user_option ("s2member_custom_fields", $user_id) : array (); /* These will be needed below. */
																		$user_reg_ip = ($user_id) ? get_user_option ("s2member_registration_ip", $user_id) : ""; /* Needed below. */
																		$user_reg_ip = $paypal["ip"] = ($user_reg_ip) ? $user_reg_ip : $paypal["ip"]; /* Now merge conditionally. */
																		/**/
																		if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["ref_rev_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																			{
																				foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["ref_rev_notification_urls"]) as $url)
																					/**/
																					if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["subscr_id"])), $url)) && ($url = preg_replace ("/%%parent_txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["parent_txn_id"])), $url)))
																						if (($url = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_number"])), $url)) && ($url = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_name"])), $url)))
																							if (($url = preg_replace ("/%%-amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["mc_gross"])), $url)) && ($url = preg_replace ("/%%-fee%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["mc_fee"])), $url)))
																								if (($url = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["first_name"])), $url)) && ($url = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["last_name"])), $url)))
																									if (($url = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $url)))
																										if (($url = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["payer_email"])), $url)))
																											if (($url = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_reg_ip)), $url)))
																												if (($url = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_id)), $url)))
																													{
																														if (is_array ($fields) && !empty ($fields))
																															foreach ($fields as $var => $val) /* Custom Registration Fields. */
																																if (!($url = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (maybe_serialize ($val))), $url)))
																																	break;
																														/**/
																														if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																															c_ws_plugin__s2member_utils_urls::remote ($url);
																													}
																				/**/
																				$paypal["s2member_log"][] = "Refund/Reversal Notification URLs have been processed.";
																			}
																		/**/
																		if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["ref_rev_notification_recipients"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																			{
																				$msg = $sbj = "( s2Member / API Notification Email ) - Refund/Reversal";
																				$msg .= "\n\n"; /* Spacing in the message body. */
																				/**/
																				$msg .= "subscr_id: %%subscr_id%%\n";
																				$msg .= "parent_txn_id: %%parent_txn_id%%\n";
																				$msg .= "item_number: %%item_number%%\n";
																				$msg .= "item_name: %%item_name%%\n";
																				$msg .= "-amount: %%-amount%%\n";
																				$msg .= "-fee: %%-fee%%\n";
																				$msg .= "first_name: %%first_name%%\n";
																				$msg .= "last_name: %%last_name%%\n";
																				$msg .= "full_name: %%full_name%%\n";
																				$msg .= "payer_email: %%payer_email%%\n";
																				$msg .= "user_ip: %%user_ip%%\n";
																				$msg .= "user_id: %%user_id%%\n";
																				/**/
																				if (is_array ($fields) && !empty ($fields))
																					foreach ($fields as $var => $val)
																						$msg .= $var . ": %%" . $var . "%%\n";
																				/**/
																				$msg .= "cv0: %%cv0%%\n";
																				$msg .= "cv1: %%cv1%%\n";
																				$msg .= "cv2: %%cv2%%\n";
																				$msg .= "cv3: %%cv3%%\n";
																				$msg .= "cv4: %%cv4%%\n";
																				$msg .= "cv5: %%cv5%%\n";
																				$msg .= "cv6: %%cv6%%\n";
																				$msg .= "cv7: %%cv7%%\n";
																				$msg .= "cv8: %%cv8%%\n";
																				$msg .= "cv9: %%cv9%%";
																				/**/
																				if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["subscr_id"]), $msg)) && ($msg = preg_replace ("/%%parent_txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["parent_txn_id"]), $msg)))
																					if (($msg = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $msg)) && ($msg = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $msg)))
																						if (($msg = preg_replace ("/%%-amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_gross"]), $msg)) && ($msg = preg_replace ("/%%-fee%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_fee"]), $msg)))
																							if (($msg = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $msg)) && ($msg = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $msg)))
																								if (($msg = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $msg)))
																									if (($msg = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $msg)))
																										if (($msg = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_reg_ip), $msg)))
																											if (($msg = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_id), $msg)))
																												{
																													if (is_array ($fields) && !empty ($fields))
																														foreach ($fields as $var => $val) /* Custom Registration Fields. */
																															if (!($msg = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (maybe_serialize ($val)), $msg)))
																																break;
																													/**/
																													if (($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																														foreach (c_ws_plugin__s2member_utils_strings::trim_deep (preg_split ("/;+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["ref_rev_notification_recipients"])) as $recipient)
																															($recipient) ? wp_mail ($recipient, apply_filters ("ws_plugin__s2member_ref_rev_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_ref_rev_notification_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") : null;
																												}
																				/**/
																				$paypal["s2member_log"][] = "Refund/Reversal Notification Emails have been processed.";
																			}
																		/**/
																		eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																		do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_eot_refund_reversal", get_defined_vars ());
																		unset ($__refs, $__v); /* Unset defined __refs, __v. */
																	}
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_eot", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/*
														Refunds/Reversals for Specific Post/Page Access.
															These are handled separately.
														
														~ NOTE: "new_case" with "case_type=chargeback" is NOT actually processed. It's only been integrated for the future compatibility.
															At this time, PayPal® doesn't send enough information through "new_case" transactions for s2Member to process anything.
															However, that's OK. Refunds and Reversals ( i.e. chargebacks ) are still detected through "payment_status".
														
														~ NOTE: Partial Refunds ( i.e. payment_status=partially_refunded ) is NOT processed by this routine, or any other s2Member routine.
															( This is the intended behavior. A Partial Refund does NOT clearly indicate that s2Member should do anything at all. )
															HOWEVER. PayPal® does NOT always send payment_status=partially_refunded. This is well documented on their site, but in
																practice, it never seems to happen. It's best to check the negative mc_gross amount instead.
														*/
														else if (/**/(/**/(preg_match ("/^new_case$/i", $paypal["txn_type"]) && preg_match ("/^chargeback$/i", $paypal["case_type"])) /* Future compatibility. */
														|| (preg_match ("/^(refunded|reversed|reversal)$/i", $paypal["payment_status"])) /* The "txn_type" is irrelevant in all these special situations. */)/**/
														&& ($paypal["item_number"] || ($paypal["item_number"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_number ($paypal))) /* Item number. */
														&& (preg_match ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["sp_access_item_number_regex"], $paypal["item_number"])) /* "Specific Post/Page Access". */
														&& ($paypal["item_name"] || ($paypal["item_name"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_name ($paypal)) || ($paypal["item_name"] = $_SERVER["HTTP_HOST"]))/**/
														/* The item_name can default to HTTP_HOST because we've seen payment_status=reversed come through WITHOUT a product_name or item_name given. */
														&& ($paypal["payer_email"]) && ($paypal["parent_txn_id"])/**/)
															{
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_before_sp_refund_reversal", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "s2Member txn_type identified as [empty or irrelevant] w/ payment_status (refunded|reversed|reversal) - or - new_case w/ case_type (chargeback).";
																/**/
																$paypal["ip"] = (preg_match ("/ip address/i", $paypal["option_name2"]) && $paypal["option_selection2"]) ? $paypal["option_selection2"] : "";
																$paypal["ip"] = (!$paypal["ip"] && preg_match ("/^[0-9]+~[0-9\.]+$/", $paypal["invoice"])) ? preg_replace ("/^[0-9]+~/", "", $paypal["invoice"]) : $paypal["ip"];
																/**/
																$processing = $during = true; /* Yes, we ARE processing this. */
																/*
																Refunds and chargeback reversals. This is excluded from the processing check.
																In other words, s2Member sends `Refund/Reversal` Notifications ANYTIME a Refund/Reversal occurs; even if s2Member did not process it otherwise.
																Since this routine ignores the processing check, it is *possible* that Refund/Reversal Notification URLs will be contacted more than once.
																	If you're writing scripts that depend on Refund/Reversal Notifications, please keep this in mind.
																*/
																if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_ref_rev_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																	{
																		foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_ref_rev_notification_urls"]) as $url)
																			/**/
																			if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%parent_txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["parent_txn_id"])), $url)))
																				if (($url = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_number"])), $url)) && ($url = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_name"])), $url)))
																					if (($url = preg_replace ("/%%-amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["mc_gross"])), $url)) && ($url = preg_replace ("/%%-fee%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["mc_fee"])), $url)))
																						if (($url = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["first_name"])), $url)) && ($url = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["last_name"])), $url)))
																							if (($url = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $url)))
																								if (($url = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["payer_email"])), $url)))
																									if (($url = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["ip"])), $url)))
																										/**/
																										if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																											c_ws_plugin__s2member_utils_urls::remote ($url);
																		/**/
																		$paypal["s2member_log"][] = "Specific Post/Page ~ Refund/Reversal Notification URLs have been processed.";
																	}
																/**/
																if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_ref_rev_notification_recipients"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																	{
																		$msg = $sbj = "( s2Member / API Notification Email ) - Specific Post/Page ~ Refund/Reversal";
																		$msg .= "\n\n"; /* Spacing in the message body. */
																		/**/
																		$msg .= "parent_txn_id: %%parent_txn_id%%\n";
																		$msg .= "item_number: %%item_number%%\n";
																		$msg .= "item_name: %%item_name%%\n";
																		$msg .= "-amount: %%-amount%%\n";
																		$msg .= "-fee: %%-fee%%\n";
																		$msg .= "first_name: %%first_name%%\n";
																		$msg .= "last_name: %%last_name%%\n";
																		$msg .= "full_name: %%full_name%%\n";
																		$msg .= "payer_email: %%payer_email%%\n";
																		$msg .= "user_ip: %%user_ip%%\n";
																		/**/
																		$msg .= "cv0: %%cv0%%\n";
																		$msg .= "cv1: %%cv1%%\n";
																		$msg .= "cv2: %%cv2%%\n";
																		$msg .= "cv3: %%cv3%%\n";
																		$msg .= "cv4: %%cv4%%\n";
																		$msg .= "cv5: %%cv5%%\n";
																		$msg .= "cv6: %%cv6%%\n";
																		$msg .= "cv7: %%cv7%%\n";
																		$msg .= "cv8: %%cv8%%\n";
																		$msg .= "cv9: %%cv9%%";
																		/**/
																		if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%parent_txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["parent_txn_id"]), $msg)))
																			if (($msg = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $msg)) && ($msg = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $msg)))
																				if (($msg = preg_replace ("/%%-amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_gross"]), $msg)) && ($msg = preg_replace ("/%%-fee%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_fee"]), $msg)))
																					if (($msg = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $msg)) && ($msg = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $msg)))
																						if (($msg = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $msg)))
																							if (($msg = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $msg)))
																								if (($msg = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $msg)))
																									/**/
																									if (($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																										foreach (c_ws_plugin__s2member_utils_strings::trim_deep (preg_split ("/;+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_ref_rev_notification_recipients"])) as $recipient)
																											($recipient) ? wp_mail ($recipient, apply_filters ("ws_plugin__s2member_sp_ref_rev_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_sp_ref_rev_notification_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") : null;
																		/**/
																		$paypal["s2member_log"][] = "Specific Post/Page ~ Refund/Reversal Notification Emails have been processed.";
																	}
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_during_sp_refund_reversal", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_notify_after_sp_refund_reversal", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														else
															$paypal["s2member_log"][] = "Ignoring this IPN request. The txn_type/status does NOT require any action on the part of s2Member.";
													}
												else /* Else a custom conditional has been applied by Filters. */
													unset ($__refs, $__v); /* Unset defined __refs, __v. */
											}
										/*
										Else, check on cancelled recurring profiles.
										*/
										else if (preg_match ("/^recurring_payment_profile_cancel$/i", $paypal["txn_type"]))
											{
												$paypal["s2member_log"][] = "Transaction type ( recurring_payment_profile_cancel ), but there is no match to an existing account; so verification of _SERVER[HTTP_HOST] was not possible.";
												$paypal["s2member_log"][] = "It's likely this account was just upgraded/downgraded by s2Member Pro; so the Subscr. ID has probably been updated on-site; nothing to worry about here.";
											}
										/*
										Else, check on other ^recurring_ transaction types.
										*/
										else if (preg_match ("/^recurring_/i", $paypal["txn_type"])) /* Otherwise, is this a ^recurring_ txn_type? */
											$paypal["s2member_log"][] = "Transaction type ( ^recurring_? ), but there is no match to an existing account; so verification of _SERVER[HTTP_HOST] was not possible.";
										/**/
										else /* Else, use the default _SERVER[HTTP_HOST] error. */
											$paypal["s2member_log"][] = "Unable to verify _SERVER[HTTP_HOST]. Possibly caused by a fraudulent request. If this error continues, please check the `custom` value in your Form and/or Button Code. It MUST always start with your domain name.";
									}
								/**/
								else /* Extensive log reporting here. This is an area where many site owners find trouble. Depending on server configuration; remote HTTPS connections may fail. */
									{
										$paypal["s2member_log"][] = "Unable to verify POST vars. Possibly caused by a fraudulent request. If this error continues, please run IPN tests against your server from a PayPal® Sandbox account. They provide special diagnostic tools to assist you.";
										$paypal["s2member_log"][] = "If you're absolutely SURE that your PayPal® configuration is valid, you may want to run some tests on your server, just to be sure \$_POST variables are populated, and that your server is able to connect to PayPal® over an HTTPS connection.";
										$paypal["s2member_log"][] = "s2Member uses the WP_Http class for remote connections; which will try to use cURL first, and then fall back on the FOPEN method when cURL is not available. On a Windows® server, you may have to disable your cURL extension. Instead, set allow_url_fopen = yes in your php.ini file. The cURL extension (usually) does NOT support SSL connections on a Windows® server.";
										$paypal["s2member_log"][] = var_export ($_REQUEST, true); /* Recording _POST + _GET vars for analysis and debugging. */
									}
								/*
								Add IPN proxy ( when available ) to the $paypal array.
								*/
								if ($_GET["s2member_paypal_proxy"]) /* For proxy identification. */
									$paypal["s2member_paypal_proxy"] = $_GET["s2member_paypal_proxy"];
								/*
								Add IPN proxy use vars ( when available ) to the $paypal array.
								*/
								if ($_GET["s2member_paypal_proxy_use"]) /* For proxy specifications. */
									$paypal["s2member_paypal_proxy_use"] = $_GET["s2member_paypal_proxy_use"];
								/*
								Also add IPN proxy self-verification ( when available ) to the $paypal array.
								*/
								if ($_GET["s2member_paypal_proxy_verification"]) /* Proxy identification w/verification. */
									$paypal["s2member_paypal_proxy_verification"] = $_GET["s2member_paypal_proxy_verification"];
								/*
								If debugging/logging is enabled; we need to append $paypal to the log file.
									Logging now supports Multisite Networking as well.
								*/
								$logv = c_ws_plugin__s2member_utilities::ver_details ();
								$log4 = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "\nUser-Agent: " . $_SERVER["HTTP_USER_AGENT"];
								$log4 = (is_multisite () && !is_main_site ()) ? ($_log4 = $current_blog->domain . $current_blog->path) . "\n" . $log4 : $log4;
								$log2 = (is_multisite () && !is_main_site ()) ? "paypal-ipn-4-" . trim (preg_replace ("/[^a-z0-9]/i", "-", $_log4), "-") . ".log" : "paypal-ipn.log";
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["gateway_debug_logs"])
									if (is_dir ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
										if (is_writable ($logs_dir) && c_ws_plugin__s2member_utils_logs::archive_oversize_log_files ())
											file_put_contents ($logs_dir . "/" . $log2, $logv . "\n" . $log4 . "\n" . var_export ($paypal, true) . "\n\n", FILE_APPEND);
								/**/
								eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_paypal_notify", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								header("HTTP/1.0 200 OK"); /* Send a 200 OK status header. */
								header("Content-Type: text/plain; charset=utf-8"); /* With text/plain. */
								exit($paypal["s2member_paypal_proxy_return_url"]); /* Possible return value. */
							}
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_after_paypal_notify", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
					}
			}
	}
?>