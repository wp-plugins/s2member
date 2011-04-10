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
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_paypal_utilities"))
	{
		class c_ws_plugin__s2member_paypal_utilities
			{
				/*
				Get POST vars from PayPal®, verify and return array.
				*/
				public static function paypal_postvars ()
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_postvars", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/*
						Custom conditionals can be applied by filters.
						*/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						if (! ($postvars = apply_filters ("ws_plugin__s2member_during_paypal_postvars_conditionals", array (), get_defined_vars ())))
							{
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								if ($_GET["tx"] && !$_GET["s2member_paypal_proxy"]) /* Auto-Return w/PDT. */
									{
										$postback["tx"] = $_GET["tx"];
										$postback["cmd"] = "_notify-synch";
										$postback["at"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_identity_token"];
										/**/
										$endpoint = ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com";
										/**/
										if (preg_match ("/^SUCCESS/i", ($response = trim (c_ws_plugin__s2member_utils_urls::remote ("https://" . $endpoint . "/cgi-bin/webscr", $postback, array ("timeout" => 20))))))
											{
												foreach (preg_split ("/[\r\n]+/", preg_replace ("/^SUCCESS/i", "", $response)) as $varline)
													{
														list ($key, $value) = preg_split ("/\=/", $varline, 2);
														if (strlen ($key = trim ($key)) && strlen ($value = trim ($value)))
															$postvars[$key] = trim (stripslashes (urldecode ($value)));
													}
												/**/
												return apply_filters ("ws_plugin__s2member_paypal_postvars", $postvars, get_defined_vars ());
											}
										else /* Nope. */
											return false;
									}
								else if (is_array ($postvars = stripslashes_deep ($_REQUEST)))
									{
										foreach ($postvars as $key => $value)
											if (preg_match ("/^s2member_/", $key))
												unset ($postvars[$key]);
										/**/
										$postback = $postvars; /* Copy. */
										$postback["cmd"] = "_notify-validate";
										/**/
										$postvars = c_ws_plugin__s2member_utils_strings::trim_deep ($postvars);
										/**/
										$endpoint = ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com";
										/**/
										if ($_GET["s2member_paypal_proxy"] && $_GET["s2member_paypal_proxy_verification"] === c_ws_plugin__s2member_paypal_utilities::paypal_proxy_key_gen ())
											return apply_filters ("ws_plugin__s2member_paypal_postvars", array_merge ($postvars, array ("proxy_verified" => $_GET["s2member_paypal_proxy"])), get_defined_vars ());
										/**/
										else if (strtolower (trim (c_ws_plugin__s2member_utils_urls::remote ("https://" . $endpoint . "/cgi-bin/webscr", $postback, array ("timeout" => 20)))) === "verified")
											return apply_filters ("ws_plugin__s2member_paypal_postvars", $postvars, get_defined_vars ());
										/**/
										else /* Nope. */
											return false;
									}
								else /* Nope. */
									return false;
							}
						else /* Else a custom conditional has been applied by Filters. */
							{
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								return apply_filters ("ws_plugin__s2member_paypal_postvars", $postvars, get_defined_vars ());
							}
					}
				/*
				Function generated a PayPal® Proxy Key, for simulated IPN responses.
				*/
				public static function paypal_proxy_key_gen () /* Generate Key. */
					{
						global $current_site, $current_blog; /* Multisite Networking. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_proxy_key_gen", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (!is_multisite () || is_main_site ())
							$key = md5 (c_ws_plugin__s2member_utils_encryption::xencrypt (preg_replace ("/\:[0-9]+$/", "", $_SERVER["HTTP_HOST"])));
						/**/
						else if (is_multisite ())
							$key = md5 (c_ws_plugin__s2member_utils_encryption::xencrypt ($current_blog->domain . $current_blog->path));
						/**/
						return apply_filters ("ws_plugin__s2member_paypal_proxy_key_gen", $key, get_defined_vars ());
					}
				/*
				Function that calls upon the PayPal® API, and returns the response.
				*/
				public static function paypal_api_response ($post_vars = FALSE)
					{
						global $current_site, $current_blog; /* For Multisite support. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_api_response", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$url = "https://" . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "api-3t.sandbox.paypal.com" : "api-3t.paypal.com") . "/nvp";
						/**/
						$post_vars = (is_array ($post_vars)) ? $post_vars : array (); /* Must be an array. */
						/**/
						$post_vars["VERSION"] = "63.0"; /* Configure the PayPal® API version. */
						$post_vars["USER"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_api_username"];
						$post_vars["PWD"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_api_password"];
						$post_vars["SIGNATURE"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_api_signature"];
						/**/
						$input_time = date ("D M j, Y g:i:s a T"); /* Record input/nvp for logging. */
						/**/
						$nvp = trim (c_ws_plugin__s2member_utils_urls::remote ($url, $post_vars, array ("timeout" => 20)));
						/**/
						$output_time = date ("D M j, Y g:i:s a T"); /* Now record after output time. */
						/**/
						wp_parse_str ($nvp, $response); /* Parse NVP response. */
						$response = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($response));
						/**/
						if (!$response["ACK"] || !preg_match ("/^(Success|SuccessWithWarning)$/i", $response["ACK"]))
							{
								if (strlen ($response["L_ERRORCODE0"]) || $response["L_SHORTMESSAGE0"] || $response["L_LONGMESSAGE0"]) /* Did we at least get an error msg? */
									$response["__error"] = "Error# " . $response["L_ERRORCODE0"] . ". " . rtrim ($response["L_SHORTMESSAGE0"], ".") . ". " . rtrim ($response["L_LONGMESSAGE0"], ".") . ".";
								/**/
								else /* Else, generate an error messsage - so something is reported back to the Customer. */
									$response["__error"] = "Error. Please contact Support for assistance.";
							}
						/*
						If debugging is enabled; we need to maintain a comprehensive log file.
							Logging now supports Multisite Networking as well.
						*/
						$log4 = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "\nUser-Agent: " . $_SERVER["HTTP_USER_AGENT"];
						$log4 = (is_multisite () && !is_main_site ()) ? ($_log4 = $current_blog->domain . $current_blog->path) . "\n" . $log4 : $log4;
						$log2 = (is_multisite () && !is_main_site ()) ? "paypal-api-4-" . trim (preg_replace ("/[^a-z0-9]/i", "-", $_log4), "-") . ".log" : "paypal-api.log";
						/**/
						if (strlen ($post_vars["ACCT"]) > 4) /* Only log last 4 digits for security. */
							$post_vars["ACCT"] = str_repeat ("*", strlen ($post_vars["ACCT"]) - 4)/**/
							. substr ($post_vars["ACCT"], -4); /* Then display last 4 digits. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["gateway_debug_logs"])
							if (is_dir ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
								if (is_writable ($logs_dir) && c_ws_plugin__s2member_utils_logs::archive_oversize_log_files ())
									if (($log = "-------- Input vars: ( " . $input_time . " ) --------\n" . var_export ($post_vars, true) . "\n"))
										if (($log .= "-------- Output string/vars: ( " . $output_time . " ) --------\n" . $nvp . "\n" . var_export ($response, true)))
											file_put_contents ($logs_dir . "/" . $log2, $log4 . "\n" . $log . "\n\n", FILE_APPEND);
						/**/
						return apply_filters ("ws_plugin__s2member_paypal_api_response", c_ws_plugin__s2member_paypal_utilities::_paypal_api_response_filters ($response), get_defined_vars ());
					}
				/*
				A sort of callback function that Filters PayPal® responses.
				Provides alternative explanations in some cases that require special attention.
				*/
				public static function _paypal_api_response_filters ($response = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_before_paypal_api_response_filters", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($response["__error"]) /* Only if there was a problem. */
							{
								if ($response["L_ERRORCODE0"] == 10422)
									$response["__error"] = "Error# " . $response["L_ERRORCODE0"] . ". Transaction declined. Please use an alternate funding source.";
								/**/
								else if ($response["L_ERRORCODE0"] == 10435)
									$response["__error"] = "Error# " . $response["L_ERRORCODE0"] . ". Transaction declined. Express Checkout was NOT confirmed.";
								/**/
								else if ($response["L_ERRORCODE0"] == 10417)
									$response["__error"] = "Error# " . $response["L_ERRORCODE0"] . ". Transaction declined. Please use an alternate funding source.";
							}
						/**/
						return $response; /* Filters already applied with: ws_plugin__s2member_paypal_api_response. */
					}
				/*
				Function converts a term [DWMY] into PayPal® Pro format.
				*/
				public static function paypal_pro_term ($term = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_pro_term", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$paypal_pro_terms = array ("D" => "Day", "W" => "Week", "M" => "Month", "Y" => "Year");
						/**/
						$pro_term = $paypal_pro_terms[strtoupper ($term)];
						/**/
						return apply_filters ("ws_plugin__s2member_paypal_pro_term", $pro_term, get_defined_vars ());
					}
				/*
				Function converts a term [Day,Week,Month,Year] into PayPal® Standard format.
				*/
				public static function paypal_std_term ($term = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_std_term", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$paypal_std_terms = array ("DAY" => "D", "WEEK" => "W", "MONTH" => "M", "YEAR" => "Y");
						/**/
						$std_term = $paypal_std_terms[strtoupper ($term)];
						/**/
						return apply_filters ("ws_plugin__s2member_paypal_std_term", $std_term, get_defined_vars ());
					}
				/*
				Parse/validate item_name from either an array with recurring_payment_id, or use an existing string.
				*/
				public static function paypal_pro_subscr_id ($array_or_string = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_pro_subscr_id", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_array ($array = $array_or_string) && $array["recurring_payment_id"])
							$subscr_id = $array["recurring_payment_id"];
						/**/
						else if (is_string ($string = $array_or_string) && $string)
							$subscr_id = $string;
						/**/
						return apply_filters ("ws_plugin__s2member_paypal_pro_subscr_id",$subscr_id, get_defined_vars ());
					}
				/*
				Parse/validate item_number from either an array with:
				item_number1|PROFILEREFERENCE|rp_invoice_id, or parse/validate an existing string
				to make sure it is a valid "level:ccaps:eotper" combination.
				*/
				public static function paypal_pro_item_number ($array_or_string = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_pro_item_number", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_array ($array = $array_or_string) && $array["item_number1"])
							$_item_number = $array["item_number1"];
						/**/
						else if (is_array ($array = $array_or_string) && ($array["PROFILEREFERENCE"] || $array["rp_invoice_id"]))
							list ($_reference, $_domain, $_item_number) = preg_split ("/~/", ( ($array["PROFILEREFERENCE"]) ? $array["PROFILEREFERENCE"] : $array["rp_invoice_id"]), 3);
						/**/
						else if (is_string ($string = $array_or_string) && $string)
							$_item_number = $string;
						/**/
						if ($_item_number && preg_match ("/^[1-4](\:|$)([\+a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", $_item_number))
							$item_number = $_item_number;
						/**/
						else if ($_item_number && preg_match ("/^sp\:[0-9,]+\:[0-9]+$/", $_item_number))
							$item_number = $_item_number;
						/**/
						return apply_filters ("ws_plugin__s2member_paypal_pro_item_number",$item_number, get_defined_vars ());
					}
				/*
				Parse/validate item_name from either an array with: item_name1|product_name, or use an existing string.
				*/
				public static function paypal_pro_item_name ($array_or_string = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_pro_item_name", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_array ($array = $array_or_string) && $array["item_name1"])
							$item_name = $array["item_name1"];
						/**/
						else if (is_array ($array = $array_or_string) && $array["product_name"])
							$item_name = $array["product_name"];
						/**/
						else if (is_string ($string = $array_or_string))
							$item_name = $string;
						/**/
						return apply_filters ("ws_plugin__s2member_paypal_pro_item_name",$item_name, get_defined_vars ());
					}
				/*
				Parse/validate period1 from either a return array coming from the
				Pro API with PROFILEREFERENCE|rp_invoice_id, or parse/validate an existing string
				to make sure it is a valid "period term" combination.
				
				Note: This will also convert "1 Day", into "1 D".
				Note: This will also convert "1 SemiMonth", into "2 W".
				*/
				public static function paypal_pro_period1 ($array_or_string = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_pro_period1", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_array ($array = $array_or_string) && ($array["PROFILEREFERENCE"] || $array["rp_invoice_id"]))
							{
								list ($_reference, $_domain, $_item_number) = preg_split ("/~/", ( ($array["PROFILEREFERENCE"]) ? $array["PROFILEREFERENCE"] : $array["rp_invoice_id"]), 3);
								list ($_start_time, $_period1, $_period3) = preg_split ("/\:/", $_reference, 3);
							}
						/**/
						else if (is_string ($string = $array_or_string) && $string)
							$_period1 = $string; /* In string form? */
						/**/
						if ($_period1) /* Were we able to get a period1 string? */
							{
								list ($num, $span) = preg_split ("/ /", $_period1, 2);
								/**/
								if (strtoupper ($span) === "SEMIMONTH")
									if (is_numeric ($num) && $num >= 1)
										eval ('$num = "2"; $span = "W";');
								/**/
								if (strlen ($span) !== 1) /* To Standard format. */
									$span = c_ws_plugin__s2member_paypal_utilities::paypal_std_term ($span);
								/**/
								$span = (preg_match ("/^[DWMY]$/i", $span)) ? $span : "";
								$num = ($span && is_numeric ($num) && $num >= 0) ? $num : "";
								/**/
								$period1 = ($num && $span) ? $num . " " . strtoupper ($span) : "0 D";
								/**/
								return apply_filters ("ws_plugin__s2member_paypal_pro_period1", $period1, get_defined_vars ());
							}
						else /* Default. */
							return apply_filters ("ws_plugin__s2member_paypal_pro_period1", "0 D", get_defined_vars ());
					}
				/*
				Parse/validate period3 from either a return array coming from the
				Pro API with PROFILEREFERENCE|rp_invoice_id, or parse/validate an existing string
				to make sure it is a valid "period term" combination.
				
				Note: This will also convert "1 Day", into "1 D".
				Note: This will also convert "1 SemiMonth", into "2 W".
				Note: The Regular Period can never be less than 1 day ( 1 D ).
				*/
				public static function paypal_pro_period3 ($array_or_string = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_pro_period3", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_array ($array = $array_or_string) && ($array["PROFILEREFERENCE"] || $array["rp_invoice_id"]))
							{
								list ($_reference, $_domain, $_item_number) = preg_split ("/~/", ( ($array["PROFILEREFERENCE"]) ? $array["PROFILEREFERENCE"] : $array["rp_invoice_id"]), 3);
								list ($_start_time, $_period1, $_period3) = preg_split ("/\:/", $_reference, 3);
							}
						/**/
						else if (is_string ($string = $array_or_string) && $string)
							$_period3 = $string; /* In string form? */
						/**/
						if ($_period3) /* Were we able to get a period3 string? */
							{
								list ($num, $span) = preg_split ("/ /", $_period3, 2);
								/**/
								if (strtoupper ($span) === "SEMIMONTH")
									if (is_numeric ($num) && $num >= 1)
										eval ('$num = "2"; $span = "W";');
								/**/
								if (strlen ($span) !== 1) /* To Standard format. */
									$span = c_ws_plugin__s2member_paypal_utilities::paypal_std_term ($span);
								/**/
								$span = (preg_match ("/^[DWMY]$/i", $span)) ? $span : "";
								$num = ($span && is_numeric ($num) && $num >= 0) ? $num : "";
								/**/
								$period3 = ($num && $span) ? $num . " " . strtoupper ($span) : "1 D";
								/**/
								return apply_filters ("ws_plugin__s2member_paypal_pro_period3", $period3, get_defined_vars ());
							}
						else /* Default. */
							return apply_filters ("ws_plugin__s2member_paypal_pro_period3", "1 D", get_defined_vars ());
					}
			}
	}
?>