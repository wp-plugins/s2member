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
		if ($url && ($connection = curl_init ()))
			{
				curl_setopt ($connection, CURLOPT_URL, $url);
				curl_setopt ($connection, CURLOPT_POST, true);
				curl_setopt ($connection, CURLOPT_TIMEOUT, 20);
				curl_setopt ($connection, CURLOPT_CONNECTTIMEOUT, 20);
				curl_setopt ($connection, CURLOPT_FOLLOWLOCATION, false);
				curl_setopt ($connection, CURLOPT_MAXREDIRS, 0);
				curl_setopt ($connection, CURLOPT_HEADER, false);
				curl_setopt ($connection, CURLOPT_VERBOSE, true);
				curl_setopt ($connection, CURLOPT_ENCODING, "");
				curl_setopt ($connection, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt ($connection, CURLOPT_RETURNTRANSFER, true);
				curl_setopt ($connection, CURLOPT_FORBID_REUSE, true);
				curl_setopt ($connection, CURLOPT_FAILONERROR, true);
				curl_setopt ($connection, CURLOPT_POSTFIELDS, $vars);
				/**/
				$output = trim (curl_exec ($connection));
				/**/
				curl_close ($connection);
			}
		/**/
		return (strlen ($output)) ? $output : false;
	}
/*
Base32 encode ( base32 is case insensitive ).
*/
function ws_plugin__s2member_base32_encode ($string = FALSE)
	{
		for ($i = 0; $i < strlen ((string)$string); $i++)
			{
				$hexdec = dechex (ord (substr ($string, $i, 1)));
				$base32 .= base_convert ($hexdec, 16, 32);
			}
		/**/
		return (string)$base32;
	}
/*
Base32 decode ( base32 is case insensitive ).
*/
function ws_plugin__s2member_base32_decode ($base32 = FALSE)
	{
		for ($i = 0; $i < strlen ((string)$base32); $i += 2)
			{
				$hexdec = base_convert (substr ($base32, $i, 2), 32, 16);
				$string .= chr (hexdec ($hexdec));
			}
		/**/
		return (string)$string;
	}
/*
Xencrypt and xdecrypt ( very useful functions ).
*/
function ws_plugin__s2member_xencrypt ($string = FALSE, $key = FALSE)
	{
		$key = (!is_string ($key) || !strlen ($key)) ? "POE993432" : $key;
		/**/
		for ($i = 1; $i <= strlen ((string)$string); $i++)
			{
				$char = substr ($string, $i - 1, 1);
				$keychar = substr ($key, ($i % strlen ($key)) - 1, 1);
				$encrypted .= chr (ord ($char) + ord ($keychar));
			}
		/**/
		return ws_plugin__s2member_base32_encode ((string)$encrypted);
	}
/*
Alias function for advanced scripting usage.
*/
function s2member_xencrypt ($string = FALSE, $key = FALSE)
	{
		return ws_plugin__s2member_xencrypt ($string, $key);
	}
/*
Xencrypt and xdecrypt ( very useful functions ).
*/
function ws_plugin__s2member_xdecrypt ($string = FALSE, $key = FALSE)
	{
		$key = (!is_string ($key) || !strlen ($key)) ? "POE993432" : $key;
		/**/
		$string = ws_plugin__s2member_base32_decode ((string)$string);
		/**/
		for ($i = 1; $i <= strlen ((string)$string); $i++)
			{
				$char = substr ($string, $i - 1, 1);
				$keychar = substr ($key, ($i % strlen ($key)) - 1, 1);
				$decrypted .= chr (ord ($char) - ord ($keychar));
			}
		/**/
		return (string)$decrypted;
	}
/*
Alias function for advanced scripting usage.
*/
function s2member_xdecrypt ($string = FALSE, $key = FALSE)
	{
		return ws_plugin__s2member_xdecrypt ($string, $key);
	}
?>