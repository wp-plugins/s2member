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
if (!class_exists ("c_ws_plugin__s2member_utils_arrays"))
	{
		class c_ws_plugin__s2member_utils_arrays
			{
				/*
				Function that extends array_unique to
				support multi-dimensional arrays.
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
				/*
				Function that searches a multi-dimensional array
				using a regular expression match against array values.
				*/
				public static function regex_in_array ($regex = FALSE, $array = FALSE)
					{
						if ($regex && is_array ($array))
							{
								foreach ($array as $value)
									{
										if (is_array ($value)) /* Recursive function call. */
											{
												if (c_ws_plugin__s2member_utils_arrays::regex_in_array ($regex, $value))
													return true;
											}
										/**/
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
			}
	}
?>