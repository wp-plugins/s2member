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
if (!class_exists ("c_ws_plugin__s2member_sc_paypal_button_in"))
	{
		class c_ws_plugin__s2member_sc_paypal_button_in
			{
				/*
				Function handles the Shortcode for [s2Member-PayPal-Button /].
				Attach to: add_shortcode("s2Member-PayPal-Button");
				*/
				public static function sc_paypal_button ($attr = FALSE, $content = FALSE, $shortcode = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_sc_paypal_button", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						c_ws_plugin__s2member_nocache::nocache_constants (true); /* No caching on pages that contain this Button. */
						/**/
						$attr = c_ws_plugin__s2member_utils_strings::trim_quot_deep ((array)$attr); /* Force array, and fix &quot; in attrs. */
						/**/
						$attr = shortcode_atts (array ("ids" => "0", "exp" => "72", "level" => "1", "ccaps" => "", "desc" => "", "ps" => "paypal", "cc" => "USD", "ns" => "1", "custom" => $_SERVER["HTTP_HOST"], "ta" => "0", "tp" => "0", "tt" => "D", "ra" => "0.01", "rp" => "1", "rt" => "M", "rr" => "1", "modify" => "0", "cancel" => "0", "sp" => "0", "image" => "default", "output" => "button"), $attr);
						/**/
						$attr["tt"] = strtoupper ($attr["tt"]); /* Term lengths absolutely must be provided in upper-case format. Only after running shortcode_atts(). */
						$attr["rt"] = strtoupper ($attr["rt"]); /* Term lengths absolutely must be provided in upper-case format. Only after running shortcode_atts(). */
						$attr["rr"] = strtoupper ($attr["rr"]); /* Must be provided in upper-case format. Numerical, or BN value. Only after running shortcode_atts(). */
						$attr["ccaps"] = strtolower ($attr["ccaps"]); /* Custom Capabilities must be typed in lower-case format. Only after running shortcode_atts(). */
						$attr["rr"] = ($attr["rt"] === "L") ? "BN" : $attr["rr"]; /* Lifetime Subscriptions require Buy Now. Only after running shortcode_atts(). */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_sc_paypal_button_after_shortcode_atts", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($attr["cancel"]) /* This is a special routine for Cancellation Buttons. Cancellation Buttons use a different template. */
							{
								$default_image = "https://www.paypal.com/en_US/i/btn/btn_unsubscribe_LG.gif"; /* Default Image. */
								/**/
								$code = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/paypal-cancellation-button.html"));
								$code = preg_replace ("/%%images%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images")), $code);
								$code = preg_replace ("/%%wpurl%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (site_url ())), $code);
								/**/
								$code = preg_replace ("/%%endpoint%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com")), $code);
								$code = preg_replace ("/%%paypal_business%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"])), $code);
								/**/
								$code = $_code = ($attr["image"] && $attr["image"] !== "default") ? preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["image"])) . '"', $code) : preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($default_image)) . '"', $code);
								/**/
								$code = ($attr["output"] === "anchor") ? $code : $code; /* Cancellation Buttons are already in anchor format; Button format is not used in Cancellations. */
								$code = ($attr["output"] === "url") ? "https://" . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com") . "/cgi-bin/webscr?cmd=_subscr-find&alias=" . urlencode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"]) : $code;
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_sc_paypal_cancellation_button", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						else if ($attr["sp"]) /* This is a special routine for Specific Post/Page Buttons. Specific Post/Page Buttons use a different template. */
							{
								$default_image = "https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif"; /* Default Image. */
								/**/
								$attr["sp_ids_exp"] = "sp:" . $attr["ids"] . ":" . $attr["exp"]; /* Combined "sp:ids:expiration hours". */
								/**/
								$code = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/paypal-sp-checkout-button.html"));
								$code = preg_replace ("/%%images%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images")), $code);
								$code = preg_replace ("/%%wpurl%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (site_url ())), $code);
								/**/
								$code = preg_replace ("/%%endpoint%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com")), $code);
								$code = preg_replace ("/%%paypal_business%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"])), $code);
								$code = preg_replace ("/%%cancel_return%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (home_url ("/"))), $code);
								$code = preg_replace ("/%%notify_url%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (site_url ("/?s2member_paypal_notify=1"))), $code);
								$code = preg_replace ("/%%return%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (site_url ("/?s2member_paypal_return=1"))), $code);
								$code = preg_replace ("/%%custom%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($_SERVER["HTTP_HOST"])), $code);
								/**/
								$code = preg_replace ('/ name\="no_shipping" value\="(.*?)"/', ' name="no_shipping" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["ns"])) . '"', $code);
								$code = preg_replace ('/ name\="item_name" value\="(.*?)"/', ' name="item_name" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["desc"])) . '"', $code);
								$code = preg_replace ('/ name\="item_number" value\="(.*?)"/', ' name="item_number" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["sp_ids_exp"])) . '"', $code);
								$code = preg_replace ('/ name\="page_style" value\="(.*?)"/', ' name="page_style" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["ps"])) . '"', $code);
								$code = preg_replace ('/ name\="currency_code" value\="(.*?)"/', ' name="currency_code" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["cc"])) . '"', $code);
								$code = preg_replace ('/ name\="custom" value\="(.*?)"/', ' name="custom" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["custom"])) . '"', $code);
								$code = preg_replace ('/ name\="amount" value\="(.*?)"/', ' name="amount" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["ra"])) . '"', $code);
								/**/
								$code = $_code = ($attr["image"] && $attr["image"] !== "default") ? preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["image"])) . '"', $code) : preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($default_image)) . '"', $code);
								/**/
								$code = ($attr["output"] === "anchor") ? '<a href="' . esc_attr (c_ws_plugin__s2member_utils_forms::form_whips_2_url ($code)) . '"><img src="' . esc_attr (($attr["image"] && $attr["image"] !== "default") ? $attr["image"] : $default_image) . '" style="width:auto; height:auto; border:0;" alt="PayPal®" /></a>' : $code;
								$code = ($attr["output"] === "url") ? c_ws_plugin__s2member_utils_forms::form_whips_2_url ($code) : $code;
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_sc_paypal_sp_button", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						else /* Otherwise, we'll process this Button normally, using the Membership routines. Also handles Modification Buttons. */
							{
								$default_image = "https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif"; /* Default PayPal® Image. */
								/**/
								$paypal_on0_input_value = ($updating = c_ws_plugin__s2member_utils_users::get_user_subscr_or_wp_id ()) ? "Updating Subscr. ID" : "";
								$paypal_os0_input_value = ($updating) ? $updating : ""; /* Current User's Paid Subscr. ID. Their WP® User ID will also suffice. */
								/**/
								$attr["desc"] = (!$attr["desc"]) ? $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $attr["level"] . "_label"] : $attr["desc"];
								/**/
								$attr["level_ccaps_eotper"] = ($attr["rr"] === "BN" && $attr["rt"] !== "L") ? $attr["level"] . ":" . $attr["ccaps"] . ":" . $attr["rp"] . " " . $attr["rt"] : $attr["level"] . ":" . $attr["ccaps"];
								$attr["level_ccaps_eotper"] = rtrim ($attr["level_ccaps_eotper"], ":"); /* Clean any trailing separators from this string. */
								/**/
								$code = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/paypal-checkout-button.html"));
								$code = preg_replace ("/%%images%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images")), $code);
								$code = preg_replace ("/%%wpurl%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (site_url ())), $code);
								/**/
								$code = preg_replace ("/%%endpoint%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com")), $code);
								$code = preg_replace ("/%%paypal_business%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"])), $code);
								$code = preg_replace ("/%%level_label%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $attr["level"] . "_label"])), $code);
								$code = preg_replace ("/%%cancel_return%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (home_url ("/"))), $code); /* This brings them back to Front Page. */
								$code = preg_replace ("/%%notify_url%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (site_url ("/?s2member_paypal_notify=1"))), $code);
								$code = preg_replace ("/%%return%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (site_url ("/?s2member_paypal_return=1"))), $code);
								$code = preg_replace ("/%%custom%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($_SERVER["HTTP_HOST"])), $code);
								$code = preg_replace ("/%%level%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["level"])), $code);
								/**/
								$code = preg_replace ('/ \<\!--(\<input type\="hidden" name\="(amount|src|sra|a1|p1|t1|a3|p3|t3)" value\="(.*?)" \/\>)--\>/', " $1", $code);
								$code = ($attr["rr"] === "BN") ? preg_replace ('/ (\<input type\="hidden" name\="cmd" value\=")(.*?)(" \/\>)/', " $1_xclick$3", $code) : $code;
								$code = ($attr["rr"] === "BN") ? preg_replace ('/ (\<input type\="hidden" name\="(src|sra|a1|p1|t1|a3|p3|t3)" value\="(.*?)" \/\>)/', " <!--$1-->", $code) : $code;
								$code = ($attr["rr"] === "BN" || !$attr["tp"]) ? preg_replace ('/ (\<input type\="hidden" name\="(a1|p1|t1)" value\="(.*?)" \/\>)/', " <!--$1-->", $code) : $code;
								$code = ($attr["rr"] !== "BN") ? preg_replace ('/ (\<input type\="hidden" name\="cmd" value\=")(.*?)(" \/\>)/', " $1_xclick-subscriptions$3", $code) : $code;
								$code = ($attr["rr"] !== "BN") ? preg_replace ('/ (\<input type\="hidden" name\="amount" value\="(.*?)" \/\>)/', " <!--$1-->", $code) : $code;
								/**/
								$code = preg_replace ('/ name\="no_shipping" value\="(.*?)"/', ' name="no_shipping" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["ns"])) . '"', $code);
								$code = preg_replace ('/ name\="item_name" value\="(.*?)"/', ' name="item_name" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["desc"])) . '"', $code);
								$code = preg_replace ('/ name\="item_number" value\="(.*?)"/', ' name="item_number" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["level_ccaps_eotper"])) . '"', $code);
								$code = preg_replace ('/ name\="page_style" value\="(.*?)"/', ' name="page_style" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["ps"])) . '"', $code);
								$code = preg_replace ('/ name\="currency_code" value\="(.*?)"/', ' name="currency_code" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["cc"])) . '"', $code);
								$code = preg_replace ('/ name\="custom" value\="(.*?)"/', ' name="custom" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["custom"])) . '"', $code);
								$code = preg_replace ('/ name\="on0" value\="(.*?)"/', ' name="on0" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($paypal_on0_input_value)) . '"', $code);
								$code = preg_replace ('/ name\="os0" value\="(.*?)"/', ' name="os0" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($paypal_os0_input_value)) . '"', $code);
								$code = preg_replace ('/ name\="modify" value\="(.*?)"/', ' name="modify" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["modify"])) . '"', $code);
								$code = preg_replace ('/ name\="amount" value\="(.*?)"/', ' name="amount" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["ra"])) . '"', $code);
								$code = preg_replace ('/ name\="src" value\="(.*?)"/', ' name="src" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["rr"])) . '"', $code);
								$code = preg_replace ('/ name\="a1" value\="(.*?)"/', ' name="a1" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["ta"])) . '"', $code);
								$code = preg_replace ('/ name\="p1" value\="(.*?)"/', ' name="p1" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["tp"])) . '"', $code);
								$code = preg_replace ('/ name\="t1" value\="(.*?)"/', ' name="t1" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["tt"])) . '"', $code);
								$code = preg_replace ('/ name\="a3" value\="(.*?)"/', ' name="a3" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["ra"])) . '"', $code);
								$code = preg_replace ('/ name\="p3" value\="(.*?)"/', ' name="p3" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["rp"])) . '"', $code);
								$code = preg_replace ('/ name\="t3" value\="(.*?)"/', ' name="t3" value="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["rt"])) . '"', $code);
								/**/
								$code = $_code = ($attr["image"] && $attr["image"] !== "default") ? preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["image"])) . '"', $code) : preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($default_image)) . '"', $code);
								/**/
								$code = ($attr["output"] === "anchor") ? '<a href="' . esc_attr (c_ws_plugin__s2member_utils_forms::form_whips_2_url ($code)) . '"><img src="' . esc_attr (($attr["image"] && $attr["image"] !== "default") ? $attr["image"] : $default_image) . '" style="width:auto; height:auto; border:0;" alt="PayPal®" /></a>' : $code;
								$code = ($attr["output"] === "url") ? c_ws_plugin__s2member_utils_forms::form_whips_2_url ($code) : $code;
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								($attr["modify"]) ? do_action ("ws_plugin__s2member_during_sc_paypal_modification_button", get_defined_vars ()) : do_action ("ws_plugin__s2member_during_sc_paypal_button", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						$code = c_ws_plugin__s2member_sc_paypal_button_e::sc_paypal_button_encryption ($code, get_defined_vars ());
						/**/
						return apply_filters ("ws_plugin__s2member_sc_paypal_button", $code, get_defined_vars ()); /* Gives Filters a chance too. */
					}
			}
	}
?>