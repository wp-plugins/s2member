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
		/* Note: Auto-Return with PDT does not send anything when subscriptions are modified.
		Therefore, we need to be sure that we always send a thank you message here by default,
		and then we'll just leave the rest of the modification up to the IPN handler instead. */
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
								/**/
								if (preg_match ("/^(subscr_signup|subscr_payment)$/i", $paypal["txn_type"]) && $paypal["subscr_id"] && preg_match ("/^[1-4]$/", $paypal["item_number"]))
									{ /* With Auto-Return/PDT, PayPal will send subscr_payment instead of subscr_signup to the return URL.
											So we need to look for both (subscr_signup|subscr_payment), and treat them as the same. */
										$paypal["s2member_log"][] = "s2Member txn_type identified as (subscr_signup|subscr_payment).";
										/**/
										if (preg_match ("/(updat|upgrad)/i", $paypal["option_name1"]) && $paypal["option_selection1"]) /* Advanced subscription update modifications. */
											/* This advanced method is required whenever a subscription that is already completed, or was never setup to recur in the first place needs to be modified. PayPal® will not allow the
														modify=2 parameter to be used in those scenarios, because technically there is nothing to update. The only thing to be updated is the existing account. */
											{
												$paypal["s2member_log"][] = "s2Member txn_type identified as (subscr_signup|subscr_payment) w/ update vars.";
												/**/
												/* Here we need to check for both the old & new s2member_subscr_id's, just in case the IPN routine has already changed it. */
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
																/**/
																echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n";
																echo '<html xmlns="http://www.w3.org/1999/xhtml" ', language_attributes (), '>' . "\n";
																echo '<head profile="http://gmpg.org/xfn/11">' . "\n";
																echo '<meta http-equiv="Content-Type" content="' . get_bloginfo ("html_type") . '; charset=' . get_bloginfo ("charset") . '" />' . "\n";
																echo '<script type="text/javascript">' . "\n"; /* Onload allows any pixel codes to finish loading. */
																echo "window.onload = function(){ " . "\n"; /* After everything has finished loading, we alert and then redirect. */
																echo "alert('Thank You! Your membership has been updated to:\\n\\n" . esc_js ($paypal["item_name"]) . "\\n\\nYou\\'ll need to log back in now.');" . "\n";
																echo "window.location = '" . wp_login_url () . "'; };" . "\n";
																echo '</script>' . "\n";
																echo '</head>' . "\n";
																/**/
																echo '<body style="background:#' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_color"] . ' url(' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image"] . ');">' . "\n";
																/**/
																echo '<!-- Pixel tracking codes from the s2Member plugin for WordPress. -->' . "\n";
																/**/
																if (($code = trim ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_pixel_tracking_codes"])) && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																	{
																		if (preg_match ("/^subscr_signup$/i", $paypal["txn_type"]))
																			$initial = (isset ($paypal["amount1"]) && preg_match ("/^[1-9]/", $paypal["period1"])) ? $paypal["amount1"] : $paypal["amount3"];
																		/* The initial amount will only be $0 if a trial was offered. If no trial was offered, they were charged a regular rate. */
																		else if (preg_match ("/^subscr_payment$/i", $paypal["txn_type"])) /* PDT w/Auto-Return sends subscr_payment instead. */
																			$initial = $paypal["payment_gross"]; /* Here, the initial payment is provided clearly as the payment gross. */
																		/**/
																		if (($code = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $code)) && ($code = preg_replace ("/%%subscr_id%%/i", urlencode ($paypal["subscr_id"]), $code)))
																			if (($code = preg_replace ("/%%initial%%/i", urlencode ($initial), $code))) /* Adv calculations here. We have to support both sets of variables, subscr_signup & subscr_payment. */
																				if (($code = preg_replace ("/%%item_number%%/i", urlencode ($paypal["item_number"]), $code)) && ($code = preg_replace ("/%%item_name%%/i", urlencode ($paypal["item_name"]), $code)))
																					if (($code = preg_replace ("/%%first_name%%/i", urlencode ($paypal["first_name"]), $code)) && ($code = preg_replace ("/%%last_name%%/i", urlencode ($paypal["last_name"]), $code)))
																						if (($code = preg_replace ("/%%full_name%%/i", urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $code)))
																							if (($code = preg_replace ("/%%payer_email%%/i", urlencode ($paypal["payer_email"]), $code)))
																								if (($code = trim ($code))) /* Make sure it is not empty now. */
																									echo $code . "\n"; /* Everything here must finish loading. */
																		/**/
																		$paypal["s2member_log"][] = "Signup pixel tracking codes have been processed.";
																	}
																echo '<!-- Pixel tracking codes from the s2Member plugin for WordPress. -->' . "\n";
																/**/
																$paypal["s2member_log"][] = "Redirecting user to login page.";
																/**/
																echo '</body>' . "\n";
																echo '</html>';
															}
														else
															{
																$paypal["s2member_log"][] = "Unable to get user_id from the DB.";
																/**/
																echo '<script type="text/javascript">' . "\n";
																echo "alert('Thank you very much... please click OK!');" . "\n";
																echo "window.location = '" . esc_js (wp_login_url ()) . "';";
																echo '</script>' . "\n";
																/**/
																$paypal["s2member_log"][] = "Redirecting user to login page.";
															}
													}
												else
													{
														$paypal["s2member_log"][] = "Unable to find former subscription in the DB.";
														/**/
														echo '<script type="text/javascript">' . "\n";
														echo "alert('Thank you very much... please click OK!');" . "\n";
														echo "window.location = '" . esc_js (wp_login_url ()) . "';";
														echo '</script>' . "\n";
														/**/
														$paypal["s2member_log"][] = "Redirecting user to login page.";
													}
											}
										else /* Else this is a normal subscription signup, we are not updating anything for a past subscription. */
											{
												$paypal["s2member_log"][] = "s2Member txn_type identified as (subscr_signup|subscr_payment) w/o update vars.";
												/**/
												setcookie ("s2member_subscr_id", $paypal["subscr_id"], time () + 31556926, "/");
												setcookie ("s2member_custom", $paypal["custom"], time () + 31556926, "/");
												setcookie ("s2member_level", $paypal["item_number"], time () + 31556926, "/");
												/**/
												$paypal["s2member_log"][] = "s2Member cookies set on (subscr_signup|subscr_payment) w/o update vars.";
												/**/
												echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n";
												echo '<html xmlns="http://www.w3.org/1999/xhtml" ', language_attributes (), '>' . "\n";
												echo '<head profile="http://gmpg.org/xfn/11">' . "\n";
												echo '<meta http-equiv="Content-Type" content="' . get_bloginfo ("html_type") . '; charset=' . get_bloginfo ("charset") . '" />' . "\n";
												echo '<script type="text/javascript">' . "\n"; /* Onload allows any pixel codes to finish loading. */
												echo "window.onload = function(){ " . "\n"; /* After everything has finished loading, we alert and then redirect. */
												echo "alert('Thank You! Your membership has been approved.\\nThe next step is to Register a Username.\\n\\nPlease click OK to Register now.');" . "\n";
												echo "window.location = '" . esc_js (add_query_arg ("action", "register", wp_login_url ())) . "'; };" . "\n";
												echo '</script>' . "\n";
												echo '</head>' . "\n";
												/**/
												echo '<body style="background:#' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_color"] . ' url(' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image"] . ');">' . "\n";
												/**/
												echo '<!-- Pixel tracking codes from the s2Member plugin for WordPress. -->' . "\n";
												/**/
												if (($code = trim ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_pixel_tracking_codes"])) && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
													{
														if (preg_match ("/^subscr_signup$/i", $paypal["txn_type"]))
															$initial = (isset ($paypal["amount1"]) && preg_match ("/^[1-9]/", $paypal["period1"])) ? $paypal["amount1"] : $paypal["amount3"];
														/* The initial amount will only be $0 if a trial was offered. If no trial was offered, they were charged a regular rate. */
														else if (preg_match ("/^subscr_payment$/i", $paypal["txn_type"])) /* PDT w/Auto-Return sends subscr_payment instead. */
															$initial = $paypal["payment_gross"]; /* Here, the initial payment is provided clearly as the payment gross. */
														/**/
														if (($code = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $code)) && ($code = preg_replace ("/%%subscr_id%%/i", urlencode ($paypal["subscr_id"]), $code)))
															if (($code = preg_replace ("/%%initial%%/i", urlencode ($initial), $code))) /* Adv calculations here. We have to support both sets of variables, subscr_signup & subscr_payment. */
																if (($code = preg_replace ("/%%item_number%%/i", urlencode ($paypal["item_number"]), $code)) && ($code = preg_replace ("/%%item_name%%/i", urlencode ($paypal["item_name"]), $code)))
																	if (($code = preg_replace ("/%%first_name%%/i", urlencode ($paypal["first_name"]), $code)) && ($code = preg_replace ("/%%last_name%%/i", urlencode ($paypal["last_name"]), $code)))
																		if (($code = preg_replace ("/%%full_name%%/i", urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $code)))
																			if (($code = preg_replace ("/%%payer_email%%/i", urlencode ($paypal["payer_email"]), $code)))
																				if (($code = trim ($code))) /* Make sure it is not empty now. */
																					echo $code . "\n"; /* Everything here must finish loading. */
														/**/
														$paypal["s2member_log"][] = "Signup pixel tracking codes have been processed.";
													}
												echo '<!-- Pixel tracking codes from the s2Member plugin for WordPress. -->' . "\n";
												/**/
												$paypal["s2member_log"][] = "Redirecting user to registration page.";
												/**/
												echo '</body>' . "\n";
												echo '</html>';
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
														/**/
														echo '<script type="text/javascript">' . "\n";
														echo "alert('Thank You! Your membership has been updated to:\\n\\n" . esc_js ($paypal["item_name"]) . "\\n\\nYou\\'ll need to log back in now.');" . "\n";
														echo "window.location = '" . esc_js (wp_login_url ()) . "';";
														echo '</script>' . "\n";
														/**/
														$paypal["s2member_log"][] = "Redirecting user to login page.";
													}
												else
													{
														$paypal["s2member_log"][] = "Unable to get user_id from the DB.";
														/**/
														echo '<script type="text/javascript">' . "\n";
														echo "alert('Thank you very much... please click OK!');" . "\n";
														echo "window.location = '" . esc_js (wp_login_url ()) . "';";
														echo '</script>' . "\n";
														/**/
														$paypal["s2member_log"][] = "Redirecting user to login page.";
													}
											}
										else
											{
												$paypal["s2member_log"][] = "Unable to find subscription in the DB.";
												/**/
												echo '<script type="text/javascript">' . "\n";
												echo "alert('Thank you very much... please click OK!');" . "\n";
												echo "window.location = '" . esc_js (wp_login_url ()) . "';";
												echo '</script>' . "\n";
												/**/
												$paypal["s2member_log"][] = "Redirecting user to login page.";
											}
									}
								else
									{
										$paypal["s2member_log"][] = "The txn_type does not require any action on the part of s2Member.";
										/**/
										echo '<script type="text/javascript">' . "\n";
										echo "alert('Thank you very much... please click OK!');" . "\n";
										echo "window.location = '" . esc_js (wp_login_url ()) . "';";
										echo '</script>' . "\n";
										/**/
										$paypal["s2member_log"][] = "Redirecting user to login page.";
									}
							}
						else
							{
								$paypal["s2member_log"][] = "Unable to verify _SERVER[HTTP_HOST].";
								/**/
								echo '<script type="text/javascript">' . "\n";
								echo "alert('Thank you very much... please click OK!');" . "\n";
								echo "window.location = '" . esc_js (wp_login_url ()) . "';";
								echo '</script>' . "\n";
								/**/
								$paypal["s2member_log"][] = "Redirecting user to login page.";
							}
					}
				else
					{
						$paypal["s2member_log"][] = "Unable to verify POST vars.";
						/**/
						echo '<script type="text/javascript">' . "\n";
						echo "alert('Thank you very much... please click OK!');" . "\n";
						echo "window.location = '" . esc_js (wp_login_url ()) . "';";
						echo '</script>' . "\n";
						/**/
						$paypal["s2member_log"][] = "Redirecting user to login page.";
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
				exit;
			}
	}
?>