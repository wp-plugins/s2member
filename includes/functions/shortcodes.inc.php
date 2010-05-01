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
Function that handles the Shortcode for [s2Member-PayPal-Button /].

[s2Member-PayPal-Button level="1" ccaps="" desc="" ps="paypal" cc="USD" custom="www.domain.com" tp="0" tt="D" ra="0.01" rp="1" rt="M" rr="1" /]
[s2Member-PayPal-Button page="0" exp="72" desc="Single-Page Access" ps="paypal" cc="USD" custom="www.domain.com" ra="0.01" sp="1" /]

The desc attribute is only required for Single-Page buttons, optional for others.
The page attribute is only used for Single-Page buttons.

PayPal® Modification Buttons are identified by mb="1".
PayPal® Cancellation Buttons are identified by cb="1".
PayPal® Single-Page Buttons are identified by sp="1".

Attach to: add_shortcode("s2Member-PayPal-Button");
*/
function ws_plugin__s2member_paypal_button ($attr = FALSE, $content = FALSE, $shortcode = FALSE)
	{
		do_action ("s2member_before_paypal_button");
		/**/
		$sc = shortcode_atts (array ("page" => "0", "exp" => "72", "level" => "1", "ccaps" => "", "desc" => "", "ps" => "paypal", "cc" => "USD", "custom" => $_SERVER["HTTP_HOST"], "tp" => "0", "tt" => "D", "ra" => "0.01", "rp" => "1", "rt" => "M", "rr" => "1", "mb" => "0", "cb" => "0", "sp" => "0"), $attr);
		/**/
		do_action ("s2member_before_paypal_button_after_shortcode_atts");
		/**/
		if ($sc["cb"]) /* This is a special routine for Cancellation Buttons. Cancellation Buttons use a different template. */
			{
				$code = trim (file_get_contents (dirname (dirname (__FILE__)) . "/menu-pages/c-button.html"));
				$code = preg_replace ("/%%endpoint%%/", (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com"), $code);
				$code = preg_replace ("/%%paypal_business%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"], $code);
				/**/
				do_action ("s2member_during_paypal_button_cb");
			}
		/**/
		else if ($sc["sp"]) /* This is a special routine for Single-Page Buttons. Single-Page Buttons use a different template. */
			{
				$code = trim (file_get_contents (dirname (dirname (__FILE__)) . "/menu-pages/sp-button.html"));
				$code = preg_replace ("/%%endpoint%%/", (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com"), $code);
				$code = preg_replace ("/%%paypal_business%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"], $code);
				$code = preg_replace ("/%%cancel_return%%/", get_bloginfo ("url"), $code);
				$code = preg_replace ("/%%notify_url%%/", get_bloginfo ("url") . "/?s2member_paypal_notify=1", $code);
				$code = preg_replace ("/%%return%%/", get_bloginfo ("url") . "/?s2member_paypal_return=1", $code);
				$code = preg_replace ("/%%domain%%/", strtolower ($_SERVER["HTTP_HOST"]), $code);
				/**/
				$code = preg_replace ('/ name\="item_name" value\="(.*?)"/', ' name="item_name" value="' . $sc["desc"] . '"', $code);
				$code = preg_replace ('/ name\="item_number" value\="(.*?)"/', ' name="item_number" value="sp:' . $sc["page"] . ':' . $sc["exp"] . '"', $code);
				$code = preg_replace ('/ name\="page_style" value\="(.*?)"/', ' name="page_style" value="' . $sc["ps"] . '"', $code);
				$code = preg_replace ('/ name\="currency_code" value\="(.*?)"/', ' name="currency_code" value="' . $sc["cc"] . '"', $code);
				$code = preg_replace ('/ name\="custom" value\="(.*?)"/', ' name="custom" value="' . $sc["custom"] . '"', $code);
				$code = preg_replace ('/ name\="amount" value\="(.*?)"/', ' name="amount" value="' . $sc["ra"] . '"', $code);
				/**/
				do_action ("s2member_during_paypal_button_sp");
			}
		else /* Otherwise, we'll process this Button normally, using the Membership routines. Also handles Modification Buttons. */
			{
				$sc["desc"] = (!$sc["desc"]) ? $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $sc["level"] . "_label"] : $sc["desc"];
				$sc["level_ccaps"] = ($sc["ccaps"]) ? $sc["level"] . ":" . $sc["ccaps"] : $sc["level"];
				/**/
				$code = trim (file_get_contents (dirname (dirname (__FILE__)) . "/menu-pages/button.html"));
				$code = preg_replace ("/%%endpoint%%/", (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com"), $code);
				$code = preg_replace ("/%%paypal_business%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"], $code);
				$code = preg_replace ("/%%level_label%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $sc["level"] . "_label"], $code);
				$code = preg_replace ("/%%cancel_return%%/", get_bloginfo ("url"), $code);
				$code = preg_replace ("/%%notify_url%%/", get_bloginfo ("url") . "/?s2member_paypal_notify=1", $code);
				$code = preg_replace ("/%%return%%/", get_bloginfo ("url") . "/?s2member_paypal_return=1", $code);
				$code = preg_replace ("/%%domain%%/", strtolower ($_SERVER["HTTP_HOST"]), $code);
				$code = preg_replace ("/%%level%%/", $sc["level"], $code);
				/**/
				$code = preg_replace ('/ \<\!--(\<input type\="hidden" name\="(amount|src|sra|a1|p1|t1|a3|p3|t3)" value\="(.*?)" \/\>)--\>/', " $1", $code);
				$code = ($sc["tp"] <= 0) ? preg_replace ('/ (\<input type\="hidden" name\="(a1|p1|t1)" value\="(.*?)" \/\>)/', " <!--$1-->", $code) : $code;
				$code = ($sc["rt"] === "L") ? preg_replace ('/ (\<input type\="hidden" name\="cmd" value\=")(.*?)(" \/\>)/', " $1_xclick$3", $code) : $code;
				$code = ($sc["rt"] === "L") ? preg_replace ('/ (\<input type\="hidden" name\="(src|sra|a1|p1|t1|a3|p3|t3)" value\="(.*?)" \/\>)/', " <!--$1-->", $code) : $code;
				$code = ($sc["rt"] !== "L") ? preg_replace ('/ (\<input type\="hidden" name\="cmd" value\=")(.*?)(" \/\>)/', " $1_xclick-subscriptions$3", $code) : $code;
				$code = ($sc["rt"] !== "L") ? preg_replace ('/ (\<input type\="hidden" name\="amount" value\="(.*?)" \/\>)/', " <!--$1-->", $code) : $code;
				/**/
				$code = preg_replace ('/ name\="item_name" value\="(.*?)"/', ' name="item_name" value="' . $sc["desc"] . '"', $code);
				$code = preg_replace ('/ name\="item_number" value\="(.*?)"/', ' name="item_number" value="' . $sc["level_ccaps"] . '"', $code);
				$code = preg_replace ('/ name\="page_style" value\="(.*?)"/', ' name="page_style" value="' . $sc["ps"] . '"', $code);
				$code = preg_replace ('/ name\="currency_code" value\="(.*?)"/', ' name="currency_code" value="' . $sc["cc"] . '"', $code);
				$code = preg_replace ('/ name\="custom" value\="(.*?)"/', ' name="custom" value="' . $sc["custom"] . '"', $code);
				$code = preg_replace ('/ name\="on0" value\="(.*?)"/', ' name="on0" value="' . S2MEMBER_CURRENT_USER_VALUE_FOR_PP_ON0 . '"', $code);
				$code = preg_replace ('/ name\="os0" value\="(.*?)"/', ' name="os0" value="' . S2MEMBER_CURRENT_USER_VALUE_FOR_PP_OS0 . '"', $code);
				$code = preg_replace ('/ name\="modify" value\="(.*?)"/', ' name="modify" value="1"', $code);
				$code = preg_replace ('/ name\="amount" value\="(.*?)"/', ' name="amount" value="' . $sc["ra"] . '"', $code);
				$code = preg_replace ('/ name\="src" value\="(.*?)"/', ' name="src" value="' . $sc["rr"] . '"', $code);
				$code = preg_replace ('/ name\="p1" value\="(.*?)"/', ' name="p1" value="' . $sc["tp"] . '"', $code);
				$code = preg_replace ('/ name\="t1" value\="(.*?)"/', ' name="t1" value="' . $sc["tt"] . '"', $code);
				$code = preg_replace ('/ name\="a3" value\="(.*?)"/', ' name="a3" value="' . $sc["ra"] . '"', $code);
				$code = preg_replace ('/ name\="p3" value\="(.*?)"/', ' name="p3" value="' . $sc["rp"] . '"', $code);
				$code = preg_replace ('/ name\="t3" value\="(.*?)"/', ' name="t3" value="' . $sc["rt"] . '"', $code);
				/**/
				if ($sc["mb"])
					do_action ("s2member_during_paypal_button_mb");
				else
					do_action ("s2member_during_paypal_button");
			}
		/**/
		return apply_filters ("s2member_paypal_button", $code); /* The finished PayPal® Button. */
	}
?>