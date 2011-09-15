<?php
/**
* Array utilities.
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
if (!class_exists ("c_ws_plugin__s2member_utils_arrays"))
	{
		/**
		* Array utilities.
		*
		* @package s2Member\Utilities
		* @since 3.5
		*/
		class c_ws_plugin__s2member_utils_arrays
			{
				/**
				* Extends ``array_unique()`` to support multi-dimensional arrays.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param array $array Expects an incoming array.
				* @return array Returns the ``$array`` after having reduced it to a unique set of values.
				*/
				public static function array_unique ($array = FALSE)
					{
						if (!is_array ($array))
							{
								return array ($array);
							}
						else /* Serialized array_unique. */
							{
								foreach ($array as &$value)
									{
										$value = serialize ($value);
									}
								/**/
								$array = array_unique ($array);
								/**/
								foreach ($array as &$value)
									{
										$value = unserialize ($value);
									}
								/**/
								return $array;
							}
					}
				/**
				* Searches an array *( or even a multi-dimensional array )* using a regular expression match against array values.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $regex A regular expression to look for inside the array.
				* @return bool True if the regular expression matched at least one value in the array, else false.
				*/
				public static function regex_in_array ($regex = FALSE, $array = FALSE)
					{
						if (is_string ($regex) && strlen ($regex) && is_array ($array))
							{
								foreach ($array as $value)
									{
										if (is_array ($value)) /* Recursive function call? */
											{
												if (c_ws_plugin__s2member_utils_arrays::regex_in_array ($regex, $value))
													return true;
											}
										else if (is_string ($value)) /* Must be a string. */
											{
												if (@preg_match ($regex, $value))
													return true;
											}
									}
								/**/
								return false;
							}
						else /* False. */
							return false;
					}
				/**
				* Searches an array *( or even a multi-dimensional array )* of regular expressions, to match against a string value.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $string A string to test against.
				* @param array $array An array of regex patterns to match against ``$string``.
				* @return bool True if at least one regular expression in the ``$array`` matched ``$string``, else false.
				*/
				public static function in_regex_array ($string = FALSE, $array = FALSE)
					{
						if (is_string ($string) && strlen ($string) && is_array ($array))
							{
								foreach ($array as $value)
									{
										if (is_array ($value)) /* Recursive function call. */
											{
												if (c_ws_plugin__s2member_utils_arrays::in_regex_array ($string, $value))
													return true;
											}
										else if (is_string ($value)) /* Must be a string. */
											{
												if (@preg_match ($value, $string))
													return true;
											}
									}
								/**/
								return false;
							}
						else /* False. */
							return false;
					}
				/**
				* Removes all null-value array keys from an array *( or even a multi-dimensional array )*.
				*
				* @package s2Member\Utilities
				* @since 110720
				*
				* @param array $array An input array.
				* @return array|mixed The output array, or whatever was passed in.
				*/
				public static function remove_null_keys ($array = FALSE)
					{
						if (is_array ($array) && !empty ($array))
							{
								foreach ($array as $key => $value)
									{
										if (is_array ($value)) /* Recursive function call. */
											{
												$array[$key] = c_ws_plugin__s2member_utils_arrays::remove_null_keys ($value);
											}
										else if (is_null ($value)) /* Is it null? */
											{
												unset($array[$key]);
											}
									}
								/**/
								return $array;
							}
						else /* Return same. */
							return $array;
					}
			}
	}
?>