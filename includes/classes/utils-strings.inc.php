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
if (!class_exists ("c_ws_plugin__s2member_utils_strings"))
	{
		class c_ws_plugin__s2member_utils_strings
			{
				/*
				Function escapes double quotes.
				*/
				public static function esc_dq ($string = FALSE)
					{
						return preg_replace ('/"/', '\"', $string);
					}
				/*
				Function escapes single quotes.
				*/
				public static function esc_sq ($string = FALSE)
					{
						return preg_replace ("/'/", "\'", $string);
					}
				/*
				Function escapes dollars signs ( for regex patterns ).
				*/
				public static function esc_ds ($string = FALSE)
					{
						return preg_replace ('/\$/', '\\\$', $string);
					}
				/*
				Sanitizes a string; by removing non-standard characters.
				This allows all characters that appears on a standard computer keyboard.
				*/
				public static function keyboard_chars_only ($string = FALSE)
					{
						return preg_replace ("/[^0-9A-Z\r\n\t\s`\=\[\]\\\;',\.\/~\!@#\$%\^&\*\(\)_\+\|\}\{\:\"\?\>\<\-]/i", "", remove_accents ($string));
					}
				/*
				Function that trims deeply.
				*/
				public static function trim_deep ($value = FALSE)
					{
						return is_array ($value) ? array_map ("c_ws_plugin__s2member_utils_strings::trim_deep", $value) : trim ($value);
					}
				/*
				Function that trims &quot; entities deeply.
				This is useful on Shortcode attributes mangled by a Visual Editor.
				*/
				public static function trim_quot_deep ($value = FALSE)
					{
						return is_array ($value) ? array_map ("c_ws_plugin__s2member_utils_strings::trim_quot_deep", $value) : preg_replace ("(^(&quot;)+|(&quot;)+$)", "", $value);
					}
				/*
				Function that trims double quotes deeply ( i.e. " ).
				This is useful on CSV data that is encapsulated by double quotes.
				*/
				public static function trim_dq_deep ($value = FALSE)
					{
						return is_array ($value) ? array_map ("c_ws_plugin__s2member_utils_strings::trim_dq_deep", $value) : trim ($value, "\" \t\n\r\0\x0B");
					}
				/*
				Function generates a random string with letters/numbers/symbols.
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
				/*
				Functions that highlights PHP, and also Shortcodes.
				*/
				public static function highlight_php ($str = FALSE)
					{
						$str = highlight_string ($str, true); /* Start with PHP syntax highlighting first. */
						/**/
						return preg_replace_callback ("/(\[)(\/?)(_*s2If|s2Get|s2Member-[A-z_0-9\-]+)(.*?)(\])/i", "c_ws_plugin__s2member_utils_strings::_highlight_php", $str);
					}
				/**/
				public static function _highlight_php ($m = FALSE)
					{
						return '<span style="color:#164A61;">' . $m[0] . '</span>';
					}
			}
	}
?>