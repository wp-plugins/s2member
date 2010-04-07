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
[s2Member-PayPal-Button level="1" ps="paypal" cc="USD" on0="" os0="" modify="0" custom="www.domain.com" tp="0" tt="D" ra="0.01" rp="1" rt="M" rr="1" /]
Attach to: add_shortcode("s2Member-PayPal-Button");
*/
function ws_plugin__s2member_paypal_button ($attr = FALSE, $content = FALSE, $shortcode = FALSE)
	{
		$sc = shortcode_atts (array ("level" => "1", "ps" => "paypal", "cc" => "USD", "on0" => "", "os0" => "", "modify" => "0", "custom" => $_SERVER["HTTP_HOST"], "tp" => "0", "tt" => "D", "ra" => "0.01", "rp" => "1", "rt" => "M", "rr" => "1"), $attr);
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
		$code = preg_replace ('/\<\!--(\<input type\="hidden" name\="(amount|modify|src|sra|a1|p1|t1|a3|p3|t3)" value\="(.*?)"\>)--\>$/m', "$1", $code);
		$code = ($sc["on0"] || $sc["os0"]) ? preg_replace ('/\<\!--(\<input type\="hidden" name\="(on0|os0)" value\="(.*?)"\>)--\>$/m', "$1", $code) : $code;
		$code = ($sc["tp"] <= 0) ? preg_replace ('/(\<input type\="hidden" name\="(a1|p1|t1)" value\="(.*?)"\>)$/m', "<!--$1-->", $code) : $code;
		$code = ($sc["rp"] <= 0) ? preg_replace ('/(\<input type\="hidden" name\="cmd" value\=")(.*?)("\>)$/m', "$1_xclick$3", $code) : $code;
		$code = ($sc["rp"] <= 0) ? preg_replace ('/(\<input type\="hidden" name\="(modify|src|sra|a1|p1|t1|a3|p3|t3)" value\="(.*?)"\>)$/m', "<!--$1-->", $code) : $code;
		$code = ($sc["rp"] >= 1) ? preg_replace ('/(\<input type\="hidden" name\="cmd" value\=")(.*?)("\>)$/m', "$1_xclick-subscriptions$3", $code) : $code;
		$code = ($sc["rp"] >= 1) ? preg_replace ('/(\<input type\="hidden" name\="amount" value\="(.*?)"\>)$/m', "<!--$1-->", $code) : $code;
		/**/
		$code = preg_replace ('/name\="page_style" value\="(.*?)"/', 'name="page_style" value="' . $sc["ps"] . '"', $code);
		$code = preg_replace ('/name\="currency_code" value\="(.*?)"/', 'name="currency_code" value="' . $sc["cc"] . '"', $code);
		$code = preg_replace ('/name\="on0" value\="(.*?)"/', 'name="on0" value="' . $sc["on0"] . '"', $code);
		$code = preg_replace ('/name\="os0" value\="(.*?)"/', 'name="os0" value="' . $sc["os0"] . '"', $code);
		$code = preg_replace ('/name\="modify" value\="(.*?)"/', 'name="modify" value="' . $sc["modify"] . '"', $code);
		$code = preg_replace ('/name\="custom" value\="(.*?)"/', 'name="custom" value="' . $sc["custom"] . '"', $code);
		$code = preg_replace ('/name\="amount" value\="(.*?)"/', 'name="amount" value="' . $sc["ra"] . '"', $code);
		$code = preg_replace ('/name\="src" value\="(.*?)"/', 'name="src" value="' . $sc["rr"] . '"', $code);
		$code = preg_replace ('/name\="p1" value\="(.*?)"/', 'name="p1" value="' . $sc["tp"] . '"', $code);
		$code = preg_replace ('/name\="t1" value\="(.*?)"/', 'name="t1" value="' . $sc["tt"] . '"', $code);
		$code = preg_replace ('/name\="a3" value\="(.*?)"/', 'name="a3" value="' . $sc["ra"] . '"', $code);
		$code = preg_replace ('/name\="p3" value\="(.*?)"/', 'name="p3" value="' . $sc["rp"] . '"', $code);
		$code = preg_replace ('/name\="t3" value\="(.*?)"/', 'name="t3" value="' . $sc["rt"] . '"', $code);
		/**/
		return $code; /* The finished PayPal® Button. */
	}
?>