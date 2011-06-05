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
				* @return str Output string after double quotes are escaped.
				*/
				public static function esc_dq ($string = FALSE)
					{
						return preg_replace ('/"/', '\"', (string)$string);
					}
				/**
				* Escapes single quotes.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $string Input string.
				* @return str Output string after single quotes are escaped.
				*/
				public static function esc_sq ($string = FALSE)
					{
						return preg_replace ("/'/", "\'", (string)$string);
					}
				/**
				* Escapes dollars signs ( for regex patterns ).
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $string Input string.
				* @return str Output string after dollar signs are escaped.
				*/
				public static function esc_ds ($string = FALSE)
					{
						return preg_replace ('/\$/', '\\\$', (string)$string);
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
				* Trims &quot; entities deeply.
				*
				* This is useful on Shortcode attributes mangled by a Visual Editor.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str|array $value Either a string, an array, or a multi-dimensional array, filled with integer and/or string values.
				* @return str|array Either the input string, or the input array; after all data is trimmed up.
				*/
				public static function trim_quot_deep ($value = FALSE)
					{
						return is_array ($value) ? array_map ("c_ws_plugin__s2member_utils_strings::trim_quot_deep", $value) : preg_replace ("(^(&quot;)+|(&quot;)+$)", "", (string)$value);
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
				* @param str $beg A string value to wrap at the beginning of each value.
				* @param str $end A string value to wrap at the ending of each value.
				* @return str|array Either the input string, or the input array; after all data is wrapped up.
				*/
				public static function wrap_deep ($value = FALSE, $beg = FALSE, $end = FALSE)
					{
						return (is_array ($value) && !empty ($value)) ? array_map ("c_ws_plugin__s2member_utils_strings::wrap_deep", $value, array_fill (0, count ($value), $beg), array_fill (0, count ($value), $end)) : ((is_string ($value) && strlen ($value)) ? (string)$beg . (string)$value . (string)$end : ((is_array ($value)) ? $value : (string)$value));
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
				public static function highlight_php ($str = FALSE)
					{
						$str = highlight_string ($str, true); /* Start with PHP syntax highlighting first. */
						/**/
						return preg_replace_callback ("/(\[)(\/?)(_*s2If|s2Get|s2Member-[A-z_0-9\-]+)(.*?)(\])/i", "c_ws_plugin__s2member_utils_strings::_highlight_php", $str);
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
			}
	}
?>