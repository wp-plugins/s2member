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
if (!class_exists ("c_ws_plugin__s2member_utils_forms"))
	{
		class c_ws_plugin__s2member_utils_forms
			{
				/*
				Function converts a form with hidden inputs into a URL w/ query string.
				*/
				public static function form_whips_2_url ($form = FALSE)
					{
						if (preg_match ("/\<form(.+?)\>/is", $form, $form_attr_m)) /* Is this a form? */
							{
								if (preg_match ("/(\s)(action)( ?)(\=)( ?)(['\"])(.+?)(['\"])/is", $form_attr_m[1], $form_action_m))
									{
										if (($url = trim ($form_action_m[7]))) /* Set URL value dynamically. Now we add values. */
											{
												foreach ((array)c_ws_plugin__s2member_utils_forms::form_whips_2_array ($form) as $name => $value)
													{
														if (strlen ($name) && strlen ($value)) /* Check $name -> $value lengths. */
															/**/
															if (strlen ($value = (preg_match ("/^http(s)?\:\/\//i", $value)) ? rawurlencode ($value) : urlencode ($value)))
																{
																	$url = add_query_arg ($name, $value, $url);
																}
													}
												/**/
												return $url;
											}
									}
							}
						/**/
						return false;
					}
				/*
				Function converts a form with hidden inputs into an associative array.
				*/
				public static function form_whips_2_array ($form = FALSE)
					{
						if (preg_match ("/\<form(.+?)\>/is", $form)) /* Is this a form? */
							{
								if (preg_match_all ("/(?<!\<\!--)\<input(.+?)\>/is", $form, $input_attr_ms, PREG_SET_ORDER))
									{
										foreach ($input_attr_ms as $input_attr_m) /* Go through each hidden input variable. */
											{
												if (preg_match ("/(\s)(type)( ?)(\=)( ?)(['\"])(hidden)(['\"])/is", $input_attr_m[1]))
													{
														if (preg_match ("/(\s)(name)( ?)(\=)( ?)(['\"])(.+?)(['\"])/is", $input_attr_m[1], $input_name_m))
															{
																if (preg_match ("/(\s)(value)( ?)(\=)( ?)(['\"])(.+?)(['\"])/is", $input_attr_m[1], $input_value_m))
																	{
																		$array[trim ($input_name_m[7])] = trim (wp_specialchars_decode ($input_value_m[7], ENT_QUOTES));
																	}
															}
													}
											}
									}
							}
						/**/
						return (array)$array;
					}
			}
	}
?>