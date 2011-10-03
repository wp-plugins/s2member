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
	exit("Do not access this file directly.");
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
						if ($url && is_string ($url)) /* We MUST have a valid full URL (string) before we do anything in this routine. */
							{
								$args = (!is_array ($args)) ? array (): $args; /* Force array & disable SSL verification. */
								$args["sslverify"] = (!isset ($args["sslverify"])) ? /* Off. */ false : $args["sslverify"];
								/**/
								if ((is_array ($post_vars) || is_string ($post_vars)) && !empty ($post_vars))
									$args = array_merge ($args, array ("method" => "POST", "body" => $post_vars));
								/**/
								if (preg_match ("/^https/i", $url) && stripos (PHP_OS, "win") === 0)
									add_filter ("use_curl_transport", "__return_false", ($curl_disabled = 1352));
								/**/
								if (!has_filter ("http_response", "c_ws_plugin__s2member_utils_urls::_remote_gz_variations"))
									add_filter ("http_response", "c_ws_plugin__s2member_utils_urls::_remote_gz_variations");
								/**/
								$response = wp_remote_request ($url, $args); /* Try to process the remote request now. */
								/**/
								if ($return === "array" /* Return array? */ && !is_wp_error ($response) && is_array ($response))
									{
										$r = array ("code" => (int)wp_remote_retrieve_response_code ($response), "message" => wp_remote_retrieve_response_message ($response));
										/**/
										$r = array_merge ($r, array ("o_headers" => wp_remote_retrieve_headers ($response), "headers" => array ()));
										foreach (array_keys ($r["o_headers"]) as $header) /* Array of lowercase headers makes things easier. */
											$r["headers"][strtolower ($header)] = $r["o_headers"][$header];
										/**/
										$r = array_merge ($r, array ("body" => wp_remote_retrieve_body ($response), "response" => $response));
									}
								/**/
								else if (!is_wp_error ($response) && is_array ($response)) /* Else returning ``$response`` body only. */
									$r = wp_remote_retrieve_body ($response);
								/**/
								else /* Else this remote request has failed completely. We must return a `false` value. */
									$r = false; /* Remote request failed, return false. */
								/**/
								if (isset ($curl_disabled) && $curl_disabled === 1352) /* Remove this Filter now? */
									remove_filter ("use_curl_transport", "__return_false", 1352);
								/**/
								return $r; /* The ``$r`` return value. */
							}
						/**/
						else /* Else, return false. */
							return false;
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
				* Shortens a long URL through tinyURL, or through another backup API used by this routine.
				*
				* @package s2Member\Utilities
				* @since 111002
				*
				* @param str $url A full/long URL to be shortened.
				* @param str $api_sp Optional. A specific URL shortening API to use. Defaults to that which is configured in the s2Member Dashboard. Normally `tiny_url` by default.
				* @param bool $try_backups Defaults to true. If a failure occurs with the first API, we'll try others until we have success.
				* @return str|bool The shortened URL on success, else false on failure.
				*/
				public static function shorten ($url = FALSE, $api_sp = FALSE, $try_backups = TRUE)
					{
						$url = ($url && is_string ($url)) ? $url : false; /* Only accept a string value here. */
						$api_sp = ($api_sp && is_string ($api_sp)) ? $api_sp : false; /* Only accept a string value. */
						/**/
						$default_url_shortener = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["default_url_shortener"];
						$default_custom_str_url_shortener = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["default_custom_str_url_shortener"];
						/**/
						$apis = array ("tiny_url", "goo_gl"); /* The shortening APIs integrated with this routine so far. More will come soon. */
						/**/
						if ($url && ($api = ($api_sp) ? strtolower ($api_sp) : $default_url_shortener)) /* If specific, use it. Otherwise, default shortener. */
							{
								if (!$api_sp && ($custom_url = apply_filters ("ws_plugin__s2member_url_shorten", false, get_defined_vars ())) && stripos ($custom_url, "http") === 0)
									return ($shorter_url = $custom_url); /* Using whatever other shortener API you prefer, over the ones available by default with s2Member. */
								/**/
								else if (!$api_sp && stripos ($default_custom_str_url_shortener, "http") === 0 && ($custom_url = trim (c_ws_plugin__s2member_utils_urls::remote (str_ireplace (array ("%%s2_long_url%%", "%%s2_long_url_md5%%"), array (rawurlencode ($url), urlencode (md5 ($url))), $default_custom_str_url_shortener)))) && stripos ($custom_url, "http") === 0)
									return ($shorter_url = $custom_url); /* Using whatever other shortener API that a site owner prefers, over the ones available by default with s2Member. */
								/**/
								else if ($api === "tiny_url" && ($tiny_url = trim (c_ws_plugin__s2member_utils_urls::remote ("http://tinyurl.com/api-create.php?url=" . rawurlencode ($url)))) && stripos ($tiny_url, "http") === 0)
									return ($shorter_url = $tiny_url); /* The default tinyURL API: <http://tinyurl.com/api-create.php?url=http://www.example.com/>.
								/**/
								else if ($api === "goo_gl" && ($goo_gl = json_decode (trim (c_ws_plugin__s2member_utils_urls::remote ("https://www.googleapis.com/urlshortener/v1/url" . ((($goo_gl_key = apply_filters ("ws_plugin__s2member_url_shorten_api_goo_gl_key", false))) ? "?key=" . urlencode ($goo_gl_key) : ""), json_encode (array ("longUrl" => $url)), array ("headers" => array ("Content-Type" => "application/json")))), true)) && !empty ($goo_gl["id"]) && ($goo_gl_url = $goo_gl["id"]) && stripos ($goo_gl_url, "http") === 0)
									return ($shorter_url = $goo_gl_url); /* Google® API: <http://code.google.com/apis/urlshortener/v1/getting_started.html>.
								/**/
								else if ($try_backups && count ($apis) > 1) /* Try backups? This way we can still try to shorten the URL. */
									/**/
									foreach (array_diff ($apis, array ($api)) as $backup)
										if (($backup = c_ws_plugin__s2member_utils_urls::shorten ($url, $backup, false)))
											return ($shorter_url = $backup);
							}
						/**/
						return false; /* Default return value. */
					}
			}
	}
?>