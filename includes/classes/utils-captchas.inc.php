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
if (!class_exists ("c_ws_plugin__s2member_utils_captchas"))
	{
		class c_ws_plugin__s2member_utils_captchas
			{
				/*
				Function verifies a reCaptcha code though a connection to Google®.
				*/
				public static function recaptcha_code_validates ($challenge = FALSE, $response = FALSE)
					{
						$post_vars = array ("privatekey" => $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["recaptcha"]["private_key"], "remoteip" => $_SERVER["REMOTE_ADDR"], "challenge" => $challenge, "response" => $response);
						/**/
						return preg_match ("/^true/i", trim (c_ws_plugin__s2member_utils_urls::remote ("http://www.google.com/recaptcha/api/verify", $post_vars)));
					}
				/*
				Function that builds a reCaptcha <script></script> tag for display.
				*/
				public static function recaptcha_script_tag ($theme = FALSE, $tabindex = FALSE, $error = FALSE)
					{
						$theme = ($theme) ? $theme : "clean"; /* Defaults to the `clean` theme style. */
						$tabindex = (strlen ($tabindex)) ? (int)$tabindex : -1; /* -1 default. */
						/**/
						$s = '<script type="text/javascript">' . "if(typeof RecaptchaOptions !== 'object'){ var RecaptchaOptions = {theme: '" . c_ws_plugin__s2member_utils_strings::esc_sq ($theme) . "', lang: '" . c_ws_plugin__s2member_utils_strings::esc_sq ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["recaptcha"]["lang"]) . "', tabindex: " . $tabindex . " }; }" . '</script>' . "\n";
						/**/
						return $s . '<script type="text/javascript" src="' . esc_attr ('https://www.google.com/recaptcha/api/challenge?k=' . urlencode ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["recaptcha"]["public_key"])) . '' . (($error) ? '&amp;error=' . urlencode ($error) : '') . '"></script>';
					}
			}
	}
?>