<?php
/**
* URL utilities.
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
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_utils_urls"))
	{
		/**
		* URL utilities.
		*
		* @package s2Member\Utilities
		* @since 3.5
		*/
		class c_ws_plugin__s2member_utils_urls
			{
				/**
				* Builds a WordPress® signup URL to `/wp-signup.php`.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @return str Full URL to `/wp-signup.php`.
				*/
				public static function wp_signup_url () /* With Filters. */
					{
						return apply_filters ("wp_signup_location", site_url ("/wp-signup.php"));
					}
				/**
				* Builds a WordPress® registration URL to `/wp-login.php?action=register`.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $redirect_to Optional. Force a specific redirection after registration.
				* @return str Location of `/wp-login.php?action=register`.
				*/
				public static function wp_register_url ($redirect_to = FALSE)
					{
						return apply_filters ("wp_register_location", /* « NOT a core Filter; we're anticipating. */
						add_query_arg ("action", urlencode ("register"), wp_login_url ($redirect_to)), get_defined_vars ());
					}
				/**
				* Responsible for all remote communications processed by s2Member.
				*
				* Uses ``wp_remote_request()`` through the `WP_Http` class.
				* This function will try to use cURL first, and then fall back on FOPEN and/or other supported transports.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $url Full URL with possible query string parameters.
				* @param str|array $post_vars Optional. Either a string of POST vars, or an array.
				* @param array $args Optional. An array of additional arguments used by ``wp_remote_request()``.
				* @param bool $return Optional. One of: `body|array`. Defaults to `body`. If `array`, an array with the following elements is returned:
				* 	`headers` *(an array of headers)*, `body` *(the response body string)*, `code` *(http response code)*, `message` *(http response message)*, `response` *(response array)*.
				* @return str|array|bool Requested response data from the remote location *(see ``$return`` parameter )*, else false on failure.
				*/
				public static function remote ($url = FALSE, $post_vars = FALSE, $args = FALSE, $return = FALSE)
					{
						static $http_response_filtered = false; /* Apply GZ filters only once. */
						/**/
						$args = (!is_array ($args)) ? array (): $args; /* Disable SSL verifications. */
						$args["sslverify"] = (!isset ($args["sslverify"])) ? false : $args["sslverify"];
						/**/
						if (!$http_response_filtered && ($http_response_filtered = true))
							add_filter ("http_response", "c_ws_plugin__s2member_utils_urls::_remote_gz_variations");
						/**/
						if ($url) /* Obviously, we must have a valid URL before we do anything at all here. */
							{
								if (preg_match ("/^https/i", $url) && stripos (PHP_OS, "win") === 0)
									add_filter ("use_curl_transport", "__return_false", ($curl_disabled = 1352));
								/**/
								if ((is_array ($post_vars) || is_string ($post_vars)) && !empty ($post_vars))
									$args = array_merge ($args, array ("method" => "POST", "body" => $post_vars));
								/**/
								$response = wp_remote_request ($url, $args); /* Get remote request response. */
								/**/
								if ($return === "array" && !is_wp_error ($response) && is_array ($response))
									{
										$r["code"] = (int)wp_remote_retrieve_response_code ($response);
										$r["message"] = wp_remote_retrieve_response_message ($response);
										/**/
										$r["headers"] = array (); /* Creates an array of lowercase headers. */
										foreach (array_keys ($r["o_headers"] = wp_remote_retrieve_headers ($response)) as $header)
											$r["headers"][strtolower ($header)] = $r["o_headers"][$header];
										/**/
										$r["body"] = wp_remote_retrieve_body ($response);
										$r["response"] = $response;
									}
								/**/
								else if (!is_wp_error ($response) && is_array ($response))
									$r = wp_remote_retrieve_body ($response);
								/**/
								else /* Else the request has failed. */
									$r = false; /* Request failed. */
								/**/
								if (!empty ($curl_disabled) && $curl_disabled === 1352)
									remove_filter ("use_curl_transport", "__return_false", 1352);
								/**/
								return $r; /* The return value. */
							}
						/**/
						return false; /* Else return false. */
					}
				/**
				* Filters the `WP_Http` response for additional gzinflate variations.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @attaches-to: ``add_filter("http_response");``
				*
				* @param array $response An array of response details.
				* @return array of ``$response`` details, with possible body modifications.
				*/
				public static function _remote_gz_variations ($response = array ())
					{
						if (!isset ($response["ws__gz_variations"]) && ($response["ws__gz_variations"] = 1))
							{
								if (!empty ($response["headers"]["content-encoding"]))
									if (!empty ($response["body"]) && substr ($response["body"], 0, 2) === "\x78\x9c")
										if (($gz = @gzinflate (substr ($response["body"], 2))))
											$response["body"] = $gz;
							}
						/**/
						return $response; /* Return response. */
					}
				/**
				* Filters content redirection status *( uses 302s for browsers )*.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @attaches-to: ``add_filter("ws_plugin__s2member_content_redirect_status");``
				*
				* @param int|str $status A numeric redirection status code.
				* @return int|str A numeric status redirection code, possibly modified to a value of `302`.
				*
				* @see http://en.wikipedia.org/wiki/Web_browser_engine
				*/
				public static function redirect_browsers_using_302_status ($status = 301)
					{
						$engines = "msie|trident|gecko|webkit|presto|konqueror|playstation";
						/**/
						if ((int)$status === 301 && !empty ($_SERVER["HTTP_USER_AGENT"]))
							if (($is_browser = preg_match ("/(" . $engines . ")[\/ ]([0-9\.]+)/i", $_SERVER["HTTP_USER_AGENT"])))
								return 302;
						/**/
						return $status; /* Else keep existing status code. */
					}
				/**
				* Parses out a full valid URI, from either a full URL, or a partial.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $url_or_uri Either a full URL, or a partial URI.
				* @return str|bool A valid URI, starting with `/` on success, else false.
				*/
				public static function parse_uri ($url_or_uri = FALSE)
					{
						if (($parse = @parse_url ($url_or_uri))) /* See: http://php.net/manual/en/function.parse-url.php. */
							{
								$parse["path"] = (!empty ($parse["path"])) ? ((strpos ($parse["path"], "/") === 0) ? $parse["path"] : "/" . $parse["path"]) : "/";
								$parse["path"] = preg_replace ("/\/+/", "/", $parse["path"]); /* Removes multi slashes. */
								/**/
								return (!empty ($parse["query"])) ? $parse["path"] . "?" . $parse["query"] : $parse["path"];
							}
						/**/
						return false;
					}
			}
	}
?>