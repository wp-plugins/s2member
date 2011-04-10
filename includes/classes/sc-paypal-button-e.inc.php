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
if (!class_exists ("c_ws_plugin__s2member_sc_paypal_button_e"))
	{
		class c_ws_plugin__s2member_sc_paypal_button_e
			{
				/*
				Handles PayPal® Button encryption ( when/if configured ).
				This uses the PayPal® API. s2Member will NOT attempt to encrypt Buttons until there is at least a Business Email Address and API Username configured.
				s2Member also maintains a log of communication with the PayPal® API. If logging is enabled, check: `/wp-content/plugins/s2member-logs/paypal-api.log`.
				*/
				public static function sc_paypal_button_encryption ($code = FALSE, $vars = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_sc_paypal_button_encryption", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_btn_encryption"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_api_username"])
							{
								$cache = apply_filters ("ws_plugin__s2member_sc_paypal_button_encryption_cache", true, get_defined_vars ()); /* Are we caching? */
								/**/
								eval ('$_code = $vars["_code"]; $attr = $vars["attr"];'); /* Let's unpack ( i.e. use shorter references ) to these two important data vars. */
								/**/
								if ($cache && ($transient = "s2m_btn_" . md5 ($code . c_ws_plugin__s2member_utilities::ver_checksum ())) && ($cache = get_transient ($transient)))
									$code = $cache; /* Great, so we can use the cached version here to save processing time. Notice the MD5 hash uses $code and NOT $_code. */
								/**/
								else if (is_array ($inputs = c_ws_plugin__s2member_utils_forms::form_whips_2_array ($_code)) && !empty ($inputs)) /* Were we able to parse hidden input variables? */
									{
										$paypal = array ("METHOD" => "BMCreateButton", "BUTTONCODE" => "ENCRYPTED", "BUTTONTYPE" => ( ($attr["sp"] || $attr["rr"] === "BN") ? "BUYNOW" : "SUBSCRIBE"));
										/**/
										$i = 0; /* Initialize incremental variable counter. PayPal® wants these numbered using L_BUTTONVAR{n}; where {n} starts at zero. */
										foreach ($inputs as $input => $value) /* Now run through each of the input variables that we parsed from the Full Button Code */
											if (!preg_match ("/^cmd$/i", $input)) /* Don't include the `cmd` var; it will produce major errors in the API response. */
												{
													/* The PayPal® API method `BMCreateButton` expects (amount|a1|a3) to include 2 decimal places. */
													if (preg_match ("/^(amount|a1|a3)$/i", $input))
														$value = number_format ($value, 2, ".", "");
													/**/
													$paypal["L_BUTTONVAR" . $i] = $input . "=" . $value;
													$i++; /* Increment variable counter. */
												}
										/**/
										if (($paypal = c_ws_plugin__s2member_paypal_utilities::paypal_api_response ($paypal)) && !$paypal["__error"] && $paypal["WEBSITECODE"] && ($code = $paypal["WEBSITECODE"]))
											/* Only proceed if we DID get a valid response from the PayPal® API. This works as a nice fallback; just in case the API connection fails. */
											{
												$default_image = "https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif"; /* Default PayPal® image. */
												/**/
												$code = preg_replace ("/\<img[^\>]+\>/i", "", $code); /* Remove the 1x1 pixel tracking image that PayPal® sticks in there. */
												$code = preg_replace ("/(\<input)([^\>]+)(\>)/ie", "'\\1'.rtrim(stripslashes('\\2'),'/').' /\\3'", $code); /* Use XHTML! */
												/**/
												$code = ($attr["image"] && $attr["image"] !== "default") ? preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["image"])) . '"', $code) : preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($default_image)) . '"', $code);
												/**/
												$code = ($attr["output"] === "anchor") ? '<a href="' . esc_attr (c_ws_plugin__s2member_utils_forms::form_whips_2_url ($code)) . '"><img src="' . esc_attr (($attr["image"] && $attr["image"] !== "default") ? $attr["image"] : $default_image) . '" style="width:auto; height:auto; border:0;" alt="PayPal®" /></a>' : $code;
												$code = ($attr["output"] === "url") ? c_ws_plugin__s2member_utils_forms::form_whips_2_url ($code) : $code;
												/**/
												($cache && $transient) ? set_transient ($transient, $code, apply_filters ("ws_plugin__s2member_sc_paypal_button_encryption_cache_exp_time", 3600, get_defined_vars ())) : null; /* Caching? */
											}
									}
							}
						/* No WordPress® Filters apply here. */
						/* Instead, use: `ws_plugin__s2member_sc_paypal_button`. */
						return $code; /* Button Code. Possibly w/ API encryption applied now. */
					}
			}
	}
?>