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
Function that extends array_unique to
support multi-dimensional arrays.
*/
function ws_plugin__s2member_array_unique ($array = FALSE)
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
function ws_plugin__s2member_regex_in_array ($regex = FALSE, $array = FALSE)
	{
		if ($regex && is_array ($array))
			{
				foreach ($array as $value)
					{
						if (is_array ($value)) /* Recursive function call. */
							{
								if (ws_plugin__s2member_regex_in_array ($regex, $value))
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
/*
Function that buffers ( gets ) function output.
*/
function ws_plugin__s2member_get ($function = FALSE)
	{
		$args = func_get_args ();
		$function = array_shift ($args);
		/**/
		if (is_string ($function) && $function)
			{
				ob_start ();
				/**/
				if (is_array ($args) && !empty ($args))
					{
						$return = call_user_func_array ($function, $args);
					}
				else /* There are no additional arguments to pass. */
					{
						$return = call_user_func ($function);
					}
				/**/
				$echo = ob_get_contents ();
				/**/
				ob_end_clean ();
				/**/
				return (!strlen ($echo) && strlen ($return)) ? $return : $echo;
			}
		else /* Else return null. */
			return;
	}
/*
Function for appending query string vars onto the end.
*/
function ws_plugin__s2member_append_query_var ($url = FALSE, $var = FALSE)
	{
		if (is_string ($url) && $url && is_string ($var) && $var)
			return preg_match ("/\?/", $url) ? $url . "&" . $var : $url . "?" . $var;
		/**/
		return $url;
	}
/*
Function checks if a post is in a child category.
*/
function ws_plugin__s2member_in_descendant_category ($cats = FALSE, $post_ID = FALSE)
	{
		foreach ((array)$cats as $cat)
			{
				$descendants = get_term_children ((int)$cat, "category");
				if ($descendants && in_category ($descendants, $post_ID))
					return true;
			}
		/**/
		return false;
	}
/*
Curl operation for posting data and reading response.
*/
function ws_plugin__s2member_curlpsr ($url = FALSE, $vars = FALSE)
	{
		if ($url && ($c = curl_init ()))
			{
				curl_setopt ($c, CURLOPT_URL, $url);
				curl_setopt ($c, CURLOPT_POST, true);
				curl_setopt ($c, CURLOPT_TIMEOUT, 20);
				curl_setopt ($c, CURLOPT_CONNECTTIMEOUT, 20);
				curl_setopt ($c, CURLOPT_FOLLOWLOCATION, false);
				curl_setopt ($c, CURLOPT_MAXREDIRS, 0);
				curl_setopt ($c, CURLOPT_HEADER, false);
				curl_setopt ($c, CURLOPT_VERBOSE, true);
				curl_setopt ($c, CURLOPT_ENCODING, "");
				curl_setopt ($c, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt ($c, CURLOPT_RETURNTRANSFER, true);
				curl_setopt ($c, CURLOPT_FORBID_REUSE, true);
				curl_setopt ($c, CURLOPT_FAILONERROR, true);
				curl_setopt ($c, CURLOPT_POSTFIELDS, $vars);
				/**/
				$o = trim (curl_exec ($c));
				/**/
				curl_close ($c);
			}
		/**/
		return (strlen ($o)) ? $o : false;
	}
/*
Function escapes single quotes.
*/
function ws_plugin__s2member_esc_sq ($string = FALSE)
	{
		return preg_replace ("/'/", "\'", $string);
	}
/*
RIJNDAEL 256: two-way encryption/decryption, with a url-safe base64 wrapper.
Includes a built-in fallback on XOR encryption when mcrypt is not available.
*/
function ws_plugin__s2member_encrypt ($string = FALSE, $key = FALSE)
	{
		$string = (is_string ($string)) ? $string : "";
		/**/
		$key = (!is_string ($key) || !strlen ($key)) ? /* For security. */
		$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"] : $key;
		$key = (!is_string ($key) || !strlen ($key)) ? wp_salt () : $key;
		/**/
		if (function_exists ("mcrypt_encrypt") && in_array ("rijndael-256", mcrypt_list_algorithms ()) && in_array ("cbc", mcrypt_list_modes ()))
			{
				$string = (strlen ($string)) ? "~r2|" . $string : "";
				$key = substr ($key, 0, mcrypt_get_key_size (MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC));
				$iv = ws_plugin__s2member_random_str_gen (mcrypt_get_iv_size (MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), false);
				$encrypted = mcrypt_encrypt (MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_CBC, $iv);
				$encrypted = (strlen ($encrypted)) ? "~r2:" . $iv . "|" . $encrypted : "";
				/**/
				return ($base64 = str_replace (array ("+", "/", "="), array ("-", "_", "."), base64_encode ($encrypted)));
			}
		else /* Fallback on XOR encryption. */
			return ws_plugin__s2member_xencrypt ($string, $key);
	}
/*
Alias function for API Scripting usage.
*/
function s2member_encrypt ($string = FALSE, $key = FALSE)
	{
		return ws_plugin__s2member_encrypt ($string, $key);
	}
/*
RIJNDAEL 256: two-way encryption/decryption, with a url-safe base64 wrapper.
Includes a built-in fallback on XOR encryption when mcrypt is not available.
*/
function ws_plugin__s2member_decrypt ($base64 = FALSE, $key = FALSE)
	{
		$base64 = (is_string ($base64)) ? $base64 : "";
		/**/
		$key = (!is_string ($key) || !strlen ($key)) ? /* For security. */
		$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"] : $key;
		$key = (!is_string ($key) || !strlen ($key)) ? wp_salt () : $key;
		/**/
		$encrypted = base64_decode (str_replace (array ("-", "_", "."), array ("+", "/", "="), $base64));
		/**/
		if (function_exists ("mcrypt_decrypt") && in_array ("rijndael-256", mcrypt_list_algorithms ()) && in_array ("cbc", mcrypt_list_modes ())/**/
		&& preg_match ("/^~r2\:(.+?)\|/", $encrypted, $v1)) /* Check validity. */
			{
				$encrypted = preg_replace ("/^~r2\:(.+?)\|/", "", $encrypted);
				$key = substr ($key, 0, mcrypt_get_key_size (MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC));
				$decrypted = mcrypt_decrypt (MCRYPT_RIJNDAEL_256, $key, $encrypted, MCRYPT_MODE_CBC, $v1[1]);
				$decrypted = preg_replace ("/^~r2\|/", "", $decrypted, 1, $v2);
				$decrypted = ($v2) ? $decrypted : ""; /* Check validity. */
				$decrypted = rtrim ($decrypted, "\0\4"); /* Nulls/EOTs. */
				/**/
				return ($string = $decrypted);
			}
		else /* Fallback on XOR decryption. */
			return ws_plugin__s2member_xdecrypt ($base64, $key);
	}
/*
Alias function for API Scripting usage.
*/
function s2member_decrypt ($base64 = FALSE, $key = FALSE)
	{
		return ws_plugin__s2member_decrypt ($base64, $key);
	}
/*
XOR two-way encryption/decryption, with a base64 wrapper.
*/
function ws_plugin__s2member_xencrypt ($string = FALSE, $key = FALSE)
	{
		$string = (is_string ($string)) ? $string : "";
		/**/
		$key = (!is_string ($key) || !strlen ($key)) ? /* For security. */
		$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"] : $key;
		$key = (!is_string ($key) || !strlen ($key)) ? wp_salt () : $key;
		/**/
		$string = (strlen ($string)) ? "~xe|" . $string : "";
		/**/
		for ($i = 1, $encrypted = ""; $i <= strlen ($string); $i++)
			{
				$char = substr ($string, $i - 1, 1);
				$keychar = substr ($key, ($i % strlen ($key)) - 1, 1);
				$encrypted .= chr (ord ($char) + ord ($keychar));
			}
		/**/
		$encrypted = (strlen ($encrypted)) ? "~xe|" . $encrypted : "";
		/**/
		return ($base64 = str_replace (array ("+", "/", "="), array ("-", "_", "."), base64_encode ($encrypted)));
	}
/*
Alias function for API Scripting usage.
*/
function s2member_xencrypt ($string = FALSE, $key = FALSE)
	{
		return ws_plugin__s2member_xencrypt ($string, $key);
	}
/*
XOR two-way encryption/decryption, with a base64 wrapper.
*/
function ws_plugin__s2member_xdecrypt ($base64 = FALSE, $key = FALSE)
	{
		$base64 = (is_string ($base64)) ? $base64 : "";
		/**/
		$key = (!is_string ($key) || !strlen ($key)) ? /* For security. */
		$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"] : $key;
		$key = (!is_string ($key) || !strlen ($key)) ? wp_salt () : $key;
		/**/
		$encrypted = base64_decode (str_replace (array ("-", "_", "."), array ("+", "/", "="), $base64));
		/**/
		$encrypted = preg_replace ("/^~xe\|/", "", $encrypted, 1, $v1);
		$encrypted = ($v1) ? $encrypted : ""; /* Check validity. */
		/**/
		for ($i = 1, $decrypted = ""; $i <= strlen ($encrypted); $i++)
			{
				$char = substr ($encrypted, $i - 1, 1);
				$keychar = substr ($key, ($i % strlen ($key)) - 1, 1);
				$decrypted .= chr (ord ($char) - ord ($keychar));
			}
		/**/
		$decrypted = preg_replace ("/^~xe\|/", "", $decrypted, 1, $v2);
		$decrypted = ($v2) ? $decrypted : ""; /* Check validity. */
		/**/
		return ($string = $decrypted);
	}
/*
Alias function for API Scripting usage.
*/
function s2member_xdecrypt ($base64 = FALSE, $key = FALSE)
	{
		return ws_plugin__s2member_xdecrypt ($base64, $key);
	}
/*
Function generates a random string with letters/numbers/symbols.
*/
function ws_plugin__s2member_random_str_gen ($length = 12, $special_chars = TRUE)
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$chars .= ($special_chars) ? "!@#$%^&*()" : "";
		/**/
		for ($i = 0, $random_str = ""; $i < $length; $i++)
			$random_str .= substr ($chars, mt_rand (0, strlen ($chars) - 1), 1);
		/**/
		return $random_str;
	}
?>