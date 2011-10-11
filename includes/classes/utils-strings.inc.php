<?php
/**
* String utilities.
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
if (!class_exists ("c_ws_plugin__s2member_utils_strings"))
	{
		/**
		* String utilities.
		*
		* @package s2Member\Utilities
		* @since 3.5
		*/
		class c_ws_plugin__s2member_utils_strings
			{
				/**
				* Escapes double quotes.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $string Input string.
				* @param int $times Mumber of escapes. Defaults to 1.
				* @return str Output string after double quotes are escaped.
				*/
				public static function esc_dq ($string = FALSE, $times = FALSE)
					{
						$times = (is_numeric ($times) && $times >= 0) ? (int)$times : 1;
						return str_replace ('"', str_repeat ("\\", $times) . '"', (string)$string);
					}
				/**
				* Escapes single quotes.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $string Input string.
				* @param int $times Mumber of escapes. Defaults to 1.
				* @return str Output string after single quotes are escaped.
				*/
				public static function esc_sq ($string = FALSE, $times = FALSE)
					{
						$times = (is_numeric ($times) && $times >= 0) ? (int)$times : 1;
						return str_replace ("'", str_repeat ("\\", $times) . "'", (string)$string);
					}
				/**
				* Escapes JavaScript and single quotes.
				*
				* @package s2Member\Utilities
				* @since 110901
				*
				* @param str $string Input string.
				* @param int $times Mumber of escapes. Defaults to 1.
				* @return str Output string after JavaScript and single quotes are escaped.
				*/
				public static function esc_js_sq ($string = FALSE, $times = FALSE)
					{
						$times = (is_numeric ($times) && $times >= 0) ? (int)$times : 1;
						return str_replace ("'", str_repeat ("\\", $times) . "'", str_replace (array ("\r", "\n"), array ("", '\\n'), str_replace ("\'", "'", (string)$string)));
					}
				/**
				* Escapes dollars signs ( for regex patterns ).
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $string Input string.
				* @param int $times Mumber of escapes. Defaults to 1.
				* @return str Output string after dollar signs are escaped.
				*/
				public static function esc_ds ($string = FALSE, $times = FALSE)
					{
						$times = (is_numeric ($times) && $times >= 0) ? (int)$times : 1;
						return str_replace ('$', str_repeat ("\\", $times) . '$', (string)$string);
					}
				/**
				* Sanitizes a string; by removing non-standard characters.
				*
				* This allows all characters that appears on a standard U.S. keyboard.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $string Input string.
				* @return str Output string after non-keyboard chars are removed.
				*/
				public static function keyboard_chars_only ($string = FALSE)
					{
						return preg_replace ("/[^0-9A-Z\r\n\t\s`\=\[\]\\\;',\.\/~\!@#\$%\^&\*\(\)_\+\|\}\{\:\"\?\>\<\-]/i", "", remove_accents ((string)$string));
					}
				/**
				* Trims deeply.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str|array $value Either a string, an array, or a multi-dimensional array, filled with integer and/or string values.
				* @return str|array Either the input string, or the input array; after all data is trimmed up.
				*/
				public static function trim_deep ($value = FALSE)
					{
						return is_array ($value) ? array_map ("c_ws_plugin__s2member_utils_strings::trim_deep", $value) : trim ((string)$value);
					}
				/**
				* Trims all single/double quote entity variations deeply.
				*
				* This is useful on Shortcode attributes mangled by a Visual Editor.
				*
				* @package s2Member\Utilities
				* @since 111011
				*
				* @param str|array $value Either a string, an array, or a multi-dimensional array, filled with integer and/or string values.
				* @return str|array Either the input string, or the input array; after all data is trimmed up.
				*/
				public static function trim_qts_deep ($value = FALSE)
					{
						$qts = implode ("|", array_keys /* Keys are regex patterns. */ (array ("&apos;" => "&apos;", "&#0*39;" => "&#39;", "&#[xX]0*27;" => "&#x27;"/**/, "&lsquo;" => "&lsquo;", "&#0*8216;" => "&#8216;", "&#[xX]0*2018;" => "&#x2018;"/**/, "&rsquo;" => "&rsquo;", "&#0*8217;" => "&#8217;", "&#[xX]0*2019;" => "&#x2019;"/**/, "&quot;" => "&quot;", "&#0*34;" => "&#34;", "&#[xX]0*22;" => "&#x22;"/**/, "&ldquo;" => "&ldquo;", "&#0*8220;" => "&#8220;", "&#[xX]0*201[cC];" => "&#x201C;"/**/, "&rdquo;" => "&rdquo;", "&#0*8221;" => "&#8221;", "&#[xX]0*201[dD];" => "&#x201D;")));
						return is_array ($value) ? array_map ("c_ws_plugin__s2member_utils_strings::trim_qts_deep", $value) : preg_replace ("/^(?:" . $qts . ")+|(?:" . $qts . ")+$/", "", (string)$value);
					}
				/**
				* Trims double quotes deeply.
				*
				* This is useful on CSV data that is encapsulated by double quotes.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str|array $value Either a string, an array, or a multi-dimensional array, filled with integer and/or string values.
				* @return str|array Either the input string, or the input array; after all data is trimmed up.
				*/
				public static function trim_dq_deep ($value = FALSE)
					{
						return is_array ($value) ? array_map ("c_ws_plugin__s2member_utils_strings::trim_dq_deep", $value) : trim ((string)$value, "\" \t\n\r\0\x0B");
					}
				/**
				* Wraps a string with the characters provided.
				*
				* This is useful when preparing an input array for ``c_ws_plugin__s2member_utils_arrays::in_regex_array()``.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str|array $value Either a string, an array, or a multi-dimensional array, filled with integer and/or string values.
				* @param str $beg Optional. A string value to wrap at the beginning of each value.
				* @param str $end Optional. A string value to wrap at the ending of each value.
				* @return str|array Either the input string, or the input array; after all data is wrapped up.
				*/
				public static function wrap_deep ($value = FALSE, $beg = FALSE, $end = FALSE)
					{
						if (is_array ($value)) /* Handles all types of arrays.
						Note, we do NOT use ``array_map()`` here, because multiple args to ``array_map()`` causes a loss of string keys.
						For further details, see: <http://php.net/manual/en/function.array-map.php>. */
							{
								foreach ($value as &$r) /* Reference. */
									$r = c_ws_plugin__s2member_utils_strings::wrap_deep ($r, $beg, $end);
								return $value; /* Return modified array. */
							}
						return (strlen ((string)$value)) ? (string)$beg . (string)$value . (string)$end : (string)$value;
					}
				/**
				* Escapes meta characters with ``preg_quote()`` deeply.
				*
				* @package s2Member\Utilities
				* @since 110926
				*
				* @param str|array $value Either a string, an array, or a multi-dimensional array, filled with integer and/or string values.
				* @param str $delimiter Optional. If a delimiting character is specified, it will also be escaped via ``preg_quote()``.
				* @return str|array Either the input string, or the input array; after all data is escaped with ``preg_quote()``.
				*/
				public static function preg_quote_deep ($value = FALSE, $delimiter = FALSE)
					{
						if (is_array ($value)) /* Handles all types of arrays.
						Note, we do NOT use ``array_map()`` here, because multiple args to ``array_map()`` causes a loss of string keys.
						For further details, see: <http://php.net/manual/en/function.array-map.php>. */
							{
								foreach ($value as &$r) /* Reference. */
									$r = c_ws_plugin__s2member_utils_strings::preg_quote_deep ($r, $delimiter);
								return $value; /* Return modified array. */
							}
						return preg_quote ((string)$value, (string)$delimiter);
					}
				/**
				* Generates a random string with letters/numbers/symbols.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param int $length Length of the randomly generated string.
				* @param bool $special_chars Defaults to true. If false, special chars are NOT included.
				* @param bool $extra_special_chars Defaults to false. If true, extra special chars are included.
				* @return str A randomly generated string, based on parameter configuration.
				*/
				public static function random_str_gen ($length = 12, $special_chars = TRUE, $extra_special_chars = FALSE)
					{
						$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
						$chars .= ($extra_special_chars) ? "-_ []{}<>~`+=,.;:/?|" : "";
						$chars .= ($special_chars) ? "!@#$%^&*()" : "";
						/**/
						for ($i = 0, $random_str = ""; $i < $length; $i++)
							$random_str .= substr ($chars, mt_rand (0, strlen ($chars) - 1), 1);
						/**/
						return $random_str;
					}
				/**
				* Highlights PHP, and also Shortcodes.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $str Input string to be highlighted.
				* @return str The highlighted string.
				*/
				public static function highlight_php ($string = FALSE)
					{
						$string = highlight_string ((string)$string, true); /* Start with PHP syntax highlighting first. */
						/**/
						return preg_replace_callback ("/(\[)(\/?)(_*s2If|s2Get|s2Member-[A-z_0-9\-]+)(.*?)(\])/i", "c_ws_plugin__s2member_utils_strings::_highlight_php", $string);
					}
				/**
				* Highlights Shortcodes.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param array $m Array passed in from `preg_replace_callback()`.
				* @return str The highlighted string.
				*/
				public static function _highlight_php ($m = FALSE)
					{
						return '<span style="color:#164A61;">' . $m[0] . '</span>';
					}
				/**
				* Parses email addresses from a string or array.
				*
				* @package s2Member\Utilities
				* @since 111009
				*
				* @param str|array $value Input string or an array is also fine.
				* @return array Array of parsed email addresses.
				*/
				public static function parse_emails ($value = FALSE)
					{
						if (is_array ($value)) /* Handles all types of arrays.
						Note, we do NOT use ``array_map()`` here, because multiple args to ``array_map()`` causes a loss of string keys.
						For further details, see: <http://php.net/manual/en/function.array-map.php>. */
							{
								$emails = array (); /* Initialize array of emails. */
								foreach ($value as $_value) /* Loop through array. */
									$emails = array_merge ($emails, c_ws_plugin__s2member_utils_strings::parse_emails ($_value));
								return $emails; /* Return array of parsed email addresses. */
							}
						/**/
						$delimiter = (strpos ((string)$value, ";") !== false) ? ";" : ",";
						foreach (($sections = c_ws_plugin__s2member_utils_strings::trim_deep (preg_split ("/" . preg_quote ($delimiter, "/") . "+/", (string)$value))) as $section)
							{
								if (preg_match ("/\<(.+?)\>/", $section, $m) && strpos ($m[1], "@") !== false)
									$emails[] = $m[1]; /* Email inside brackets. */
								/**/
								else if (strpos ($section, "@") !== false)
									$emails[] = $section;
							}
						/**/
						return (!empty ($emails)) ? $emails : array ();
					}
				/**
				* Base64 URL-safe encoding.
				*
				* @package s2Member\Utilities
				* @since 110913
				*
				* @param str $string Input string to be base64 encoded.
				* @param array $url_unsafe_chars Optional. An array of un-safe characters. Defaults to: ``array("+", "/")``.
				* @param array $url_safe_chars Optional. An array of safe character replacements. Defaults to: ``array("-", "_")``.
				* @param str $trim_padding_chars Optional. A string of padding chars to rtrim. Defaults to: `=~.`.
				* @return str The base64 URL-safe encoded string.
				*/
				public static function base64_url_safe_encode ($string = FALSE, $url_unsafe_chars = array ("+", "/"), $url_safe_chars = array ("-", "_"), $trim_padding_chars = "=~.")
					{
						eval('$string = (string)$string; $trim_padding_chars = (string)$trim_padding_chars;');
						/**/
						$base64_url_safe = str_replace ((array)$url_unsafe_chars, (array)$url_safe_chars, base64_encode ($string));
						$base64_url_safe = (strlen ($trim_padding_chars)) ? rtrim ($base64_url_safe, $trim_padding_chars) : $base64_url_safe;
						/**/
						return $base64_url_safe; /* Base64 encoded, with URL-safe replacements. */
					}
				/**
				* Base64 URL-safe decoding.
				*
				* Note, this function is backward compatible with routines supplied by s2Member in the past;
				* where padding characters were replaced with `~` or `.`, instead of being stripped completely.
				*
				* @package s2Member\Utilities
				* @since 110913
				*
				* @param str $base64_url_safe Input string to be base64 decoded.
				* @param array $url_unsafe_chars Optional. An array of un-safe character replacements. Defaults to: ``array("+", "/")``.
				* @param array $url_safe_chars Optional. An array of safe characters. Defaults to: ``array("-", "_")``.
				* @param str $trim_padding_chars Optional. A string of padding chars to rtrim. Defaults to: `=~.`.
				* @return str The decoded string.
				*/
				public static function base64_url_safe_decode ($base64_url_safe = FALSE, $url_unsafe_chars = array ("+", "/"), $url_safe_chars = array ("-", "_"), $trim_padding_chars = "=~.")
					{
						eval('$base64_url_safe = (string)$base64_url_safe; $trim_padding_chars = (string)$trim_padding_chars;');
						/**/
						$string = (strlen ($trim_padding_chars)) ? rtrim ($base64_url_safe, $trim_padding_chars) : $base64_url_safe;
						$string = (strlen ($trim_padding_chars)) ? str_pad ($string, strlen ($string) % 4, "=", STR_PAD_RIGHT) : $string;
						$string = base64_decode (str_replace ((array)$url_safe_chars, (array)$url_unsafe_chars, $string));
						/**/
						return $string; /* Base64 decoded, with URL-safe replacements. */
					}
			}
	}
?>