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
Function that handles a remote request.
This extends wp_remote_request() through the `WP_Http` class.
*/
function ws_plugin__s2member_remote ($url = FALSE, $post_vars = FALSE, $args = array ())
	{
		static $http_response_filtered = false; /* Filter once. */
		/**/
		$args = (!is_array ($args)) ? array (): $args;
		/**/
		if (!$http_response_filtered && ($http_response_filtered = true))
			add_filter ("http_response", "_ws_plugin__s2member_remote_gz_variations");
		/**/
		if ($url) /* Obviously, we must have a URL to do anything. */
			{
				if ((is_array ($post_vars) || is_string ($post_vars)) && !empty ($post_vars))
					{
						$args["method"] = "POST";
						$args["body"] = $post_vars;
					}
				/**/
				return wp_remote_retrieve_body (wp_remote_request ($url, $args));
			}
		/**/
		return false;
	}
/*
A sort of callback function that filters the WP_Http response for additional gzinflate variations.
Attach to: add_filter("http_response");
*/
function _ws_plugin__s2member_remote_gz_variations ($response = array ())
	{
		if (!isset ($response["ws__gz_variations"]) && ($response["ws__gz_variations"] = 1))
			{
				if ($response["headers"]["content-encoding"])
					if (substr ($response["body"], 0, 2) === "\x78\x9c")
						if (($gz = @gzinflate (substr ($response["body"], 2))))
							$response["body"] = $gz;
			}
		/**/
		return $response;
	}
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
Function escapes single quotes.
*/
function ws_plugin__s2member_esc_sq ($string = FALSE)
	{
		return preg_replace ("/'/", "\'", $string);
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
/*
Function that determines the difference between two timestamps. Returns the difference in a human readable format.
Supports: minutes, hours, days, weeks, months, and years. This is an improvement on WordPress® human_time_diff().
This returns an "approximate" time difference. Rounded to the nearest minute, hour, day, week, month, year.
*/
function ws_plugin__s2member_approx_time_difference ($from = FALSE, $to = FALSE)
	{
		$from = (!$from) ? strtotime ("now") : (int)$from;
		$to = (!$to) ? strtotime ("now") : (int)$to;
		/**/
		if (($difference = abs ($to - $from)) < 3600)
			{
				$m = (int)round ($difference / 60);
				/**/
				$since = ($m < 1) ? "less than a minute" : $since;
				$since = ($m === 1) ? "1 minute" : $since;
				$since = ($m > 1) ? $m . " minutes" : $since;
				$since = ($m >= 60) ? "about 1 hour" : $since;
			}
		else if ($difference >= 3600 && $difference < 86400)
			{
				$h = (int)round ($difference / 3600);
				/**/
				$since = ($h === 1) ? "1 hour" : $since;
				$since = ($h > 1) ? $h . " hours" : $since;
				$since = ($h >= 24) ? "about 1 day" : $since;
			}
		else if ($difference >= 86400 && $difference < 604800)
			{
				$d = (int)round ($difference / 86400);
				/**/
				$since = ($d === 1) ? "1 day" : $since;
				$since = ($d > 1) ? $d . " days" : $since;
				$since = ($d >= 7) ? "about 1 week" : $since;
			}
		else if ($difference >= 604800 && $difference < 2592000)
			{
				$w = (int)round ($difference / 604800);
				/**/
				$since = ($w === 1) ? "1 week" : $since;
				$since = ($w > 1) ? $w . " weeks" : $since;
				$since = ($w >= 4) ? "about 1 month" : $since;
			}
		else if ($difference >= 2592000 && $difference < 31556926)
			{
				$m = (int)round ($difference / 2592000);
				/**/
				$since = ($m === 1) ? "1 month" : $since;
				$since = ($m > 1) ? $m . " months" : $since;
				$since = ($m >= 12) ? "about 1 year" : $since;
			}
		else if ($difference >= 31556926) /* Years. */
			{
				$y = (int)round ($difference / 31556926);
				/**/
				$since = ($y === 1) ? "1 year" : $since;
				$since = ($y > 1) ? $y . " years" : $since;
			}
		/**/
		return $since;
	}
?>