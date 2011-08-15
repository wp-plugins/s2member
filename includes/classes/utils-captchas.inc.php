<?php
/**
* Captcha utilities.
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
* @package s2Member\Utilities
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_utils_captchas"))
	{
		/**
		* Captcha utilities.
		*
		* @package s2Member\Utilities
		* @since 3.5
		*/
		class c_ws_plugin__s2member_utils_captchas
			{
				/**
				* Verifies a reCaptcha code though a connection to Google®.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $challenge The value of `recaptcha_challenge_field` during form submisson.
				* @param str $response The value of `recaptcha_response_field` during form submission. 
				* @return bool True if ``$response`` is valid, else false.
				*/
				public static function recaptcha_code_validates ($challenge = FALSE, $response = FALSE)
					{
						$post_vars = array ("privatekey" => $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["recaptcha"]["private_key"], "remoteip" => $_SERVER["REMOTE_ADDR"], "challenge" => $challenge, "response" => $response);
						/**/
						return preg_match ("/^true/i", trim (c_ws_plugin__s2member_utils_urls::remote ("http://www.google.com/recaptcha/api/verify", $post_vars)));
					}
				/**
				* Builds a reCaptcha JavaScript `script` tag for display.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $theme Optional. The theme used in display. Defaults to `clean`.
				* @param str $tabindex Optional. Value of `tabindex=""` attribute. Defaults to `-1`.
				* @param str $error Optional. An error message to display.
				* @return str HTML markup for JavaScript tag.
				*/
				public static function recaptcha_script_tag ($theme = FALSE, $tabindex = FALSE, $error = FALSE)
					{
						$theme = ($theme) ? $theme : "clean"; /* Defaults to the `clean` theme style. */
						$tabindex = (strlen ($tabindex)) ? (int)$tabindex : -1; /* -1 default. */
						/**/
						$options = '<script type="text/javascript">' . "if(typeof RecaptchaOptions !== 'object'){ var RecaptchaOptions = {theme: '" . c_ws_plugin__s2member_utils_strings::esc_sq ($theme) . "', lang: '" . c_ws_plugin__s2member_utils_strings::esc_sq ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["recaptcha"]["lang"]) . "', tabindex: " . $tabindex . " }; }" . '</script>' . "\n";
						$adjustments = '<script type="text/javascript">' . "if(typeof jQuery === 'function'){ jQuery('td a[id^=\"recaptcha\"]').removeAttr('tabindex'); }" . '</script>';
						/**/
						return $options . '<script type="text/javascript" src="' . esc_attr ('https://www.google.com/recaptcha/api/challenge?k=' . urlencode ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["recaptcha"]["public_key"])) . '' . (($error) ? '&amp;error=' . urlencode ($error) : '') . '"></script>' . $adjustments;
					}
			}
	}
?>