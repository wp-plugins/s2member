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
Handles paypal return url processing.
Attach to: add_action("init");
*/
function ws_plugin__s2member_paypal_return ()
	{
		do_action ("s2member_before_paypal_return");
		/**/
		if ($_GET["s2member_paypal_return"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"])
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
								if (preg_match ("/^web_accept$/i", $paypal["txn_type"]) && $paypal["txn_id"] && preg_match ("/^sp\:[0-9]+\:[0-9]+$/", $paypal["item_number"]))
									{
										do_action ("s2member_during_paypal_return_before_sp_access");
										/**/
										$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept) for Single-Page access.";
										/**/
										list (, $paypal["page"], $paypal["hours"]) = preg_split ("/\:/", $paypal["item_number"], 3);
										/**/
										if (($sp_access_url = ws_plugin__s2member_sp_access_link_gen ($paypal["page"], $paypal["hours"], false)))
											{
												do_action ("s2member_during_paypal_return_during_sp_access");
												/**/
												header ("Location: " . $sp_access_url);
											}
										else /* Otherwise, the page ID must have been invalid. Or it's possible that the Page was deleted. */
											{
												$paypal["s2member_log"][] = "Unable to generate Single-Page Access Link.";
												/**/
												echo '<script type="text/javascript">' . "\n";
												echo "alert('ERROR: Unable to generate Access Link. Please contact Support for assistance.');" . "\n";
												echo "window.location = '" . esc_js (get_bloginfo ("url")) . "';";
												echo '</script>' . "\n";
												/**/
												$paypal["s2member_log"][] = "Redirecting Customer to the Home Page, due to an error that occurred.";
											}
										/**/
										do_action ("s2member_during_paypal_return_after_sp_access");
									}
								/*
								New subscriptions. Possibly containing advanced updated vars ( option_name1, option_selection1 ); which allow account modifications.
								*/
								else if (preg_match ("/^(web_accept|subscr_signup|subscr_payment)$/i", $paypal["txn_type"]) && ($paypal["subscr_id"] || ($paypal["subscr_id"] = $paypal["txn_id"])) && preg_match ("/^[1-4](\:|$)/", $paypal["item_number"]))
									{ /* With Auto-Return/PDT, PayPal will send subscr_payment instead of subscr_signup to the return URL.
											So we need to look for (web_accept|subscr_signup|subscr_payment), and treat them as the same. */
										/**/
										do_action ("s2member_during_paypal_return_before_subscr_signup");
										/**/
										$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept|subscr_signup|subscr_payment).";
										/**/
										list ($paypal["level"], $paypal["ccaps"]) = preg_split ("/\:/", $paypal["item_number"], 2);
										/*
										New subscription with advanced update vars ( option_name1, option_selection1 ).
										*/
										if (preg_match ("/(updat|upgrad)/i", $paypal["option_name1"]) && $paypal["option_selection1"]) /* Advanced subscription update modifications. */
											/* This advanced method is required whenever a subscription that is already completed, or was never setup to recur in the first place needs to be modified. PayPal® will not allow the
														modify=2 parameter to be used in those scenarios, because technically there is nothing to update. The only thing to be updated is the existing account. */
											{
												do_action ("s2member_during_paypal_return_before_subscr_signup_w_update_vars");
												/**/
												$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept|subscr_signup|subscr_payment) w/ update vars.";
												/**/
												/* Here we need to check for both the old & new s2member_subscr_id's, just in case the IPN routine has already changed it. */
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
																do_action ("s2member_during_paypal_return_during_subscr_signup_w_update_vars");
																/**/
																echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n";
																echo '<html xmlns="http://www.w3.org/1999/xhtml" ', language_attributes (), '>' . "\n";
																echo '<head profile="http://gmpg.org/xfn/11">' . "\n";
																echo '<meta http-equiv="Content-Type" content="' . get_bloginfo ("html_type") . '; charset=' . get_bloginfo ("charset") . '" />' . "\n";
																echo '<script type="text/javascript">' . "\n"; /* Onload allows any tracking codes to finish loading. */
																echo "window.onload = function(){ " . "\n"; /* After everything has finished loading, we alert and then redirect. */
																echo "alert('Thank You! Your membership has been updated to:\\n\\n" . esc_js ($paypal["item_name"]) . "\\n\\nYou\\'ll need to log back in now.');" . "\n";
																echo "window.location = '" . wp_login_url () . "'; };" . "\n";
																echo '</script>' . "\n";
																echo '</head>' . "\n";
																/**/
																echo '<body style="background:#' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_color"] . ' url(' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image"] . ');">' . "\n";
																/**/
																echo '<!-- Tracking codes from the s2Member plugin for WordPress. -->' . "\n";
																/**/
																if (($code = trim ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_tracking_codes"])) && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																	{
																		if (preg_match ("/^subscr_signup$/i", $paypal["txn_type"]))
																			$initial = (isset ($paypal["mc_amount1"]) && preg_match ("/^[1-9]/", $paypal["period1"])) ? $paypal["mc_amount1"] : $paypal["mc_amount3"];
																		/* The initial amount will only be $0 if a trial was offered. If no trial was offered, they were charged a regular rate. */
																		else if (preg_match ("/^(web_accept|subscr_payment)$/i", $paypal["txn_type"])) /* PDT w/Auto-Return sends subscr_payment. */
																			$initial = $paypal["mc_gross"]; /* Here, the initial payment is provided clearly as the payment gross. */
																		/**/
																		if (($code = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $code)) && ($code = preg_replace ("/%%subscr_id%%/i", $paypal["subscr_id"], $code)))
																			if (($code = preg_replace ("/%%initial%%/i", $initial, $code))) /* Adv calculations here. We have to support both sets of variables, subscr_signup & subscr_payment. */
																				if (($code = preg_replace ("/%%item_number%%/i", $paypal["item_number"], $code)) && ($code = preg_replace ("/%%item_name%%/i", $paypal["item_name"], $code)))
																					if (($code = preg_replace ("/%%first_name%%/i", $paypal["first_name"], $code)) && ($code = preg_replace ("/%%last_name%%/i", $paypal["last_name"], $code)))
																						if (($code = preg_replace ("/%%full_name%%/i", trim ($paypal["first_name"] . " " . $paypal["last_name"]), $code)))
																							if (($code = preg_replace ("/%%payer_email%%/i", $paypal["payer_email"], $code)))
																								/**/
																								if (($code = trim ($code))) /* Make sure it is not empty. */
																									/**/
																									if ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["is_wpmu"])
																										{
																											echo $code . "\n"; /* No PHP allowed here. */
																											$paypal["s2member_log"][] = "Signup Tracking codes have been processed.";
																										}
																									else /* Otherwise, it's safe to allow PHP code. */
																										{
																											eval ("?>" . $code);
																											$paypal["s2member_log"][] = "Signup Tracking codes have been evaluated.";
																										}
																	}
																/**/
																echo '<!-- Tracking codes from the s2Member plugin for WordPress. -->' . "\n";
																/**/
																$paypal["s2member_log"][] = "Success! Redirecting Customer to the Login Page. They need to log back in after this modification.";
																/**/
																echo '</body>' . "\n";
																echo '</html>';
															}
														else
															{
																$paypal["s2member_log"][] = "Unable to modify subscription. Could not get the existing user_id from the DB. Please check the on0 and os0 variables in your Button Code.";
																/**/
																echo '<script type="text/javascript">' . "\n";
																echo "alert('ERROR: Unable to modify subscription. Please contact Support for assistance.\\n\\nCould not get the existing user_id from the DB.');" . "\n";
																echo "window.location = '" . esc_js (wp_login_url ()) . "';";
																echo '</script>' . "\n";
																/**/
																$paypal["s2member_log"][] = "Redirecting Customer to the Login Page, due to an error that occurred.";
															}
													}
												else
													{
														$paypal["s2member_log"][] = "Unable to modify subscription. Could not find existing subscription in the DB. Please check the on0 and os0 variables in your Button Code.";
														/**/
														echo '<script type="text/javascript">' . "\n";
														echo "alert('ERROR: Unable to modify subscription. Please contact Support for assistance.\\n\\nCould not find existing subscription in the DB.');" . "\n";
														echo "window.location = '" . esc_js (wp_login_url ()) . "';";
														echo '</script>' . "\n";
														/**/
														$paypal["s2member_log"][] = "Redirecting Customer to the Login Page, due to an error that occurred.";
													}
												/**/
												do_action ("s2member_during_paypal_return_after_subscr_signup_w_update_vars");
											}
										/*
										New subscription. Normal subscription signup, we are not updating anything for a past subscription.
										*/
										else /* Else this is a normal subscription signup, we are not updating anything for a past subscription. */
											{
												do_action ("s2member_during_paypal_return_before_subscr_signup_wo_update_vars");
												/**/
												$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept|subscr_signup|subscr_payment) w/o update vars.";
												/**/
												setcookie ("s2member_subscr_id", $paypal["subscr_id"], time () + 31556926, "/");
												setcookie ("s2member_custom", $paypal["custom"], time () + 31556926, "/");
												setcookie ("s2member_level", $paypal["item_number"], time () + 31556926, "/");
												/**/
												$paypal["s2member_log"][] = "s2Member cookies set on (web_accept|subscr_signup|subscr_payment) w/o update vars.";
												/**/
												do_action ("s2member_during_paypal_return_during_subscr_signup_wo_update_vars");
												/**/
												echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n";
												echo '<html xmlns="http://www.w3.org/1999/xhtml" ', language_attributes (), '>' . "\n";
												echo '<head profile="http://gmpg.org/xfn/11">' . "\n";
												echo '<meta http-equiv="Content-Type" content="' . get_bloginfo ("html_type") . '; charset=' . get_bloginfo ("charset") . '" />' . "\n";
												echo '<script type="text/javascript">' . "\n"; /* Onload allows any tracking codes to finish loading. */
												echo "window.onload = function(){ " . "\n"; /* After everything has finished loading, we alert and then redirect. */
												echo "alert('Thank You! Your account has been approved.\\nThe next step is to Register a Username.\\n\\nPlease click OK to Register now.');" . "\n";/**/
												echo "window.location = '" . esc_js (add_query_arg ("action", "register", wp_login_url ())) . "'; };" . "\n";
												echo '</script>' . "\n";
												echo '</head>' . "\n";
												/**/
												echo '<body style="background:#' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_color"] . ' url(' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image"] . ');">' . "\n";
												/**/
												echo '<!-- Tracking codes from the s2Member plugin for WordPress. -->' . "\n";
												/**/
												if (($code = trim ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_tracking_codes"])) && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
													{
														if (preg_match ("/^subscr_signup$/i", $paypal["txn_type"]))
															$initial = (isset ($paypal["mc_amount1"]) && preg_match ("/^[1-9]/", $paypal["period1"])) ? $paypal["mc_amount1"] : $paypal["mc_amount3"];
														/* The initial amount will only be $0 if a trial was offered. If no trial was offered, they were charged a regular rate. */
														else if (preg_match ("/^(web_accept|subscr_payment)$/i", $paypal["txn_type"])) /* PDT w/Auto-Return sends subscr_payment. */
															$initial = $paypal["mc_gross"]; /* Here, the initial payment is provided clearly as the payment gross. */
														/**/
														if (($code = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $code)) && ($code = preg_replace ("/%%subscr_id%%/i", $paypal["subscr_id"], $code)))
															if (($code = preg_replace ("/%%initial%%/i", $initial, $code))) /* Adv calculations here. We have to support both sets of variables, subscr_signup & subscr_payment. */
																if (($code = preg_replace ("/%%item_number%%/i", $paypal["item_number"], $code)) && ($code = preg_replace ("/%%item_name%%/i", $paypal["item_name"], $code)))
																	if (($code = preg_replace ("/%%first_name%%/i", $paypal["first_name"], $code)) && ($code = preg_replace ("/%%last_name%%/i", $paypal["last_name"], $code)))
																		if (($code = preg_replace ("/%%full_name%%/i", trim ($paypal["first_name"] . " " . $paypal["last_name"]), $code)))
																			if (($code = preg_replace ("/%%payer_email%%/i", $paypal["payer_email"], $code)))
																				/**/
																				if (($code = trim ($code))) /* Make sure it is not empty. */
																					/**/
																					if ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["is_wpmu"])
																						{
																							echo $code . "\n"; /* No PHP allowed here. */
																							$paypal["s2member_log"][] = "Signup Tracking codes have been processed.";
																						}
																					else /* Otherwise, it's safe to allow PHP code. */
																						{
																							eval ("?>" . $code);
																							$paypal["s2member_log"][] = "Signup Tracking codes have been evaluated.";
																						}
													}
												/**/
												echo '<!-- Tracking codes from the s2Member plugin for WordPress. -->' . "\n";
												/**/
												$paypal["s2member_log"][] = "Success! Redirecting Customer to Registration Page. They need to register a Username now.";
												/**/
												echo '</body>' . "\n";
												echo '</html>';
												/**/
												do_action ("s2member_during_paypal_return_after_subscr_signup_wo_update_vars");
											}
										/**/
										do_action ("s2member_during_paypal_return_after_subscr_signup");
									}
								/*
								Subscription modifications.
								*/
								else if (preg_match ("/^subscr_modify$/i", $paypal["txn_type"]) && $paypal["subscr_id"] && preg_match ("/^[1-4](\:|$)/", $paypal["item_number"]))
									{
										do_action ("s2member_during_paypal_return_before_subscr_modify");
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
														do_action ("s2member_during_paypal_return_during_subscr_modify");
														/**/
														echo '<script type="text/javascript">' . "\n";
														echo "alert('Thank You! Your membership has been updated to:\\n\\n" . esc_js ($paypal["item_name"]) . "\\n\\nYou\\'ll need to log back in now.');" . "\n";
														echo "window.location = '" . esc_js (wp_login_url ()) . "';";
														echo '</script>' . "\n";
														/**/
														$paypal["s2member_log"][] = "Success! Redirecting Customer to the Login Page. They need to log back in after this modification.";
													}
												else
													{
														$paypal["s2member_log"][] = "Unable to modify subscription. Could not get the existing user_id from the DB.";
														/**/
														echo '<script type="text/javascript">' . "\n";
														echo "alert('ERROR: Unable to modify subscription. Please contact Support for assistance.\\n\\nCould not get the existing user_id from the DB.');" . "\n";
														echo "window.location = '" . esc_js (wp_login_url ()) . "';";
														echo '</script>' . "\n";
														/**/
														$paypal["s2member_log"][] = "Redirecting Customer to the Login Page, due to an error that occurred.";
													}
											}
										else
											{
												$paypal["s2member_log"][] = "Unable to modify subscription. Could not find existing subscription in the DB.";
												/**/
												echo '<script type="text/javascript">' . "\n";
												echo "alert('ERROR: Unable to modify subscription. Please contact Support for assistance.\\n\\nCould not find existing subscription in the DB.');" . "\n";
												echo "window.location = '" . esc_js (wp_login_url ()) . "';";
												echo '</script>' . "\n";
												/**/
												$paypal["s2member_log"][] = "Redirecting Customer to the Login Page, due to an error that occurred.";
											}
										/**/
										do_action ("s2member_during_paypal_return_after_subscr_modify");
									}
								else
									{
										$paypal["s2member_log"][] = "Unexpected txn_type. The PayPal® txn_type did not match a required action.";
										/**/
										echo '<script type="text/javascript">' . "\n";
										echo "alert('ERROR: Unexpected txn_type. Please contact Support for assistance.\\n\\nThe PayPal® txn_type did not match a required action.');" . "\n";
										echo "window.location = '" . esc_js (wp_login_url ()) . "';";
										echo '</script>' . "\n";
										/**/
										$paypal["s2member_log"][] = "Redirecting Customer to the Login Page, due to an error that occurred.";
									}
							}
						else
							{
								$paypal["s2member_log"][] = "Unable to verify _SERVER[HTTP_HOST]. Please check the `custom` value in your Button Code. It MUST start with your domain name.";
								/**/
								echo '<script type="text/javascript">' . "\n";
								echo "alert('ERROR: Unable to verify _SERVER[HTTP_HOST]. Please contact Support for assistance.\\n\\nIf you are the site owner, please check the `custom` value in your Button Code. It MUST start with your domain name.');" . "\n";
								echo "window.location = '" . esc_js (wp_login_url ()) . "';";
								echo '</script>' . "\n";
								/**/
								$paypal["s2member_log"][] = "Redirecting Customer to the Login Page, due to an error that occurred.";
							}
					}
				else if (!isset ($_GET["tx"]) && (empty ($_POST) || $_POST["auth"]))
					{
						$paypal["s2member_log"][] = "No Return-Data from PayPal®. Customer must wait for Email Confirmation.";
						/**/
						echo '<script type="text/javascript">' . "\n";
						echo "alert('Thank You! ( please check your email ).\\n\\n* Note: It can take ( up to 15 minutes ) for Email Confirmation. If you don\'t receive email confirmation in the next 15 minutes, please contact Support.');" . "\n";
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"])
							echo "alert('** Sandbox Mode ** You will probably NOT receive this Email Confirmation in Sandbox Mode. Sandbox addresses are usually bogus ( for testing ).');" . "\n";
						echo "window.location = '" . esc_js (get_bloginfo ("url")) . "';";
						echo '</script>' . "\n";
						/**/
						$paypal["s2member_log"][] = "Redirecting Customer to the Home Page.";
					}
				else
					{
						$paypal["s2member_log"][] = "Unable to verify POST vars. This is most likely related to an invalid PayPal® configuration. Please check: s2Member -> PayPal® Options.";
						/**/
						echo '<script type="text/javascript">' . "\n";
						echo "alert('ERROR: Unable to verify POST vars. Please contact Support for assistance.\\n\\nThis is most likely related to an invalid PayPal® configuration. If you are the site owner, please check: s2Member -> PayPal® Options.');" . "\n";
						echo "window.location = '" . esc_js (wp_login_url ()) . "';";
						echo '</script>' . "\n";
						/**/
						$paypal["s2member_log"][] = "Redirecting Customer to the Login Page, due to an error that occurred.";
					}
				/**/
				if ($_GET["s2member_paypal_proxy"]) /* For proxy identification. */
					$paypal["s2member_paypal_proxy"] = $_GET["s2member_paypal_proxy"];
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_debug"])
					if (is_dir ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
						if (is_writable ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
							file_put_contents ($logs_dir . "/paypal-rtn.log", var_export ($paypal, true) . "\n\n", FILE_APPEND);
				/**/
				do_action ("s2member_during_paypal_return");
				/**/
				exit;
			}
		/**/
		do_action ("s2member_after_paypal_return");
	}
?>