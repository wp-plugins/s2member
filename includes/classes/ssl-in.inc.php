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
if (!class_exists ("c_ws_plugin__s2member_ssl_in"))
	{
		class c_ws_plugin__s2member_ssl_in
			{
				/*
				Forces SSL on specific Posts/Pages.
				Attach to: add_action("init");
				Attach to: add_action("template_redirect");
				
				Triggered by Custom Field:
					s2member_force_ssl = yes
						( i.e. https://www.example.com/ )
				
				Or with a specific port number:
					s2member_force_ssl = 443 ( or whatever port you require )
						( i.e. https://www.example.com:443/ )
				
				* Phase 2 of `c_ws_plugin__s2member_ssl::check_force_ssl()`.
				*/
				public static function force_ssl ($vars = array ()) /* Phase 2 of `c_ws_plugin__s2member_ssl::check_force_ssl()`. */
					{
						extract ($vars); /* Extract all vars passed in from: `c_ws_plugin__s2member_ssl::check_force_ssl()`. */
						/**/
						$force_ssl = (!is_string ($force_ssl)) ? (string)(int)$force_ssl : $force_ssl; /* Force string. */
						$force_ssl = (is_numeric ($force_ssl) && $force_ssl > 1) ? $force_ssl : "yes"; /* Use `yes`. */
						/**/
						$ssl_host = preg_replace ("/\:[0-9]+$/", "", $_SERVER["HTTP_HOST"]); /* Remove port here. */
						$ssl_port = (is_numeric ($force_ssl) && $force_ssl > 1) ? $force_ssl : false; /* Port? */
						$ssl_host_port = $ssl_host . (($ssl_port) ? ":" . $ssl_port : ""); /* Use port # ? */
						/**/
						if (!is_ssl () || !$_GET[$s2_ssl_gv]) /* Redirecting. SSL must be enabled here. */
							{
								$https = "https://" . $ssl_host_port . $_SERVER["REQUEST_URI"];
								$https_with_s2_ssl_gv = add_query_arg ($s2_ssl_gv, urlencode ($force_ssl), $https);
								/**/
								wp_redirect ($https_with_s2_ssl_gv); /* Redirect to https. */
								exit (); /* Clean exit. */
							}
						else /* Otherwise, we buffer all output, and switch all content over to https. */
							/* Also, we assume here that other links on the site should NOT be converted to https. */
							{
								add_filter ("redirect_canonical", "__return_false");
								/**/
								define ("_ws_plugin__s2member_force_ssl_host", $ssl_host);
								define ("_ws_plugin__s2member_force_ssl_port", $ssl_port);
								define ("_ws_plugin__s2member_force_ssl_host_port", $ssl_host_port);
								/**/
								/* Filter these. We do NOT want to create a sitewide https conversion! */
								add_filter ("home_url", "_ws_plugin__s2member_force_non_ssl_scheme", 10, 3);
								add_filter ("network_home_url", "_ws_plugin__s2member_force_non_ssl_scheme", 10, 3);
								add_filter ("site_url", "_ws_plugin__s2member_force_non_ssl_scheme", 10, 3);
								add_filter ("network_site_url", "_ws_plugin__s2member_force_non_ssl_scheme", 10, 3);
								/*
								These additional URLs are NOT Filtered by default; but can be if needed. Use these Filters. */
								if (apply_filters ("_ws_plugin__s2member_force_non_ssl_scheme_plugins_url", false, get_defined_vars ()))
									add_filter ("plugins_url", "_ws_plugin__s2member_force_non_ssl_scheme", 10, 2);
								/*
								These additional URLs are NOT Filtered by default; but can be if needed. Use these Filters. */
								if (apply_filters ("_ws_plugin__s2member_force_non_ssl_scheme_content_url", false, get_defined_vars ()))
									add_filter ("content_url", "_ws_plugin__s2member_force_non_ssl_scheme", 10, 2);
								/**/
								if (!function_exists ("_ws_plugin__s2member_force_ssl_buffer"))
									{
										function _ws_plugin__s2member_force_ssl_buffer ($buffer = FALSE)
											{
												$o_pcre = @ini_get ("pcre.backtrack_limit"); /* Current configuration. */
												/**/
												@ini_set ("pcre.backtrack_limit", 10000000); /* Expands abilities for this routine. */
												/**/
												$ssl_tags = array ("script", "style", "link", "img", "input", "iframe", "object", "embed");
												$ssl_tags = apply_filters ("_ws_plugin__s2member_force_ssl_buffer_tags_array", $ssl_tags, get_defined_vars ());
												$ssl_tags = array_unique (array_map ("strtolower", $ssl_tags)); /* This array should be lowercase / unique. */
												/**/
												$ssl_regex_tags = implode ("|", array_map ("preg_quote", $ssl_tags)); /* Prepare for regex. */
												/**/
												$buffer = ($ssl_regex_tags) ? preg_replace_callback ("/\<(" . $ssl_regex_tags . ")(?![a-z_0-9\-])[^\>]+\>/i", "_ws_plugin__s2member_force_ssl_buffer_callback", $buffer) : $buffer;
												$buffer = (in_array ("object", $ssl_tags)) ? preg_replace_callback ("/\<object(?![a-z_0-9\-])[^\>]*\>.*?\<\/object\>/is", "_ws_plugin__s2member_force_ssl_buffer_callback", $buffer) : $buffer;
												$buffer = (in_array ("script", $ssl_tags)) ? preg_replace_callback ("/\<script(?![a-z_0-9\-])[^\>]*\>.*?\<\/script\>/is", "_ws_plugin__s2member_force_ssl_buffer_callback", $buffer) : $buffer;
												$buffer = (in_array ("style", $ssl_tags)) ? preg_replace_callback ("/\<style(?![a-z_0-9\-])[^\>]*\>.*?\<\/style\>/is", "_ws_plugin__s2member_force_ssl_buffer_callback", $buffer) : $buffer;
												/**/
												$non_ssl_tags = array ("a"); /* Tags that should NOT contain SSL-enabled links in them. Prevents site-wide conversions */
												$non_ssl_tags = apply_filters ("_ws_plugin__s2member_force_non_ssl_buffer_tags_array", $non_ssl_tags, get_defined_vars ());
												$non_ssl_tags = array_unique (array_map ("strtolower", $non_ssl_tags)); /* This array should be lowercase / unique. */
												/**/
												$non_ssl_regex_tags = implode ("|", array_map ("preg_quote", $non_ssl_tags)); /* Prepare for regex. */
												/**/
												$buffer = ($non_ssl_regex_tags) ? preg_replace_callback ("/\<(" . $non_ssl_regex_tags . ")(?![a-z_0-9\-])[^\>]+\>/i", "_ws_plugin__s2member_force_non_ssl_buffer_callback", $buffer) : $buffer;
												/**/
												@ini_set ("pcre.backtrack_limit", $o_pcre); /* Restores previous configuration value now. */
												/**/
												return apply_filters ("_ws_plugin__s2member_force_ssl_buffer", $buffer, get_defined_vars ());
											}
									}
								/**/
								if (!function_exists ("_ws_plugin__s2member_force_ssl_buffer_callback"))
									{
										function _ws_plugin__s2member_force_ssl_buffer_callback ($m = FALSE)
											{
												$s = preg_replace ("/http\:\/\//i", "https://", $m[0]); /* Conversion. */
												/**/
												if (_ws_plugin__s2member_force_ssl_port && _ws_plugin__s2member_force_ssl_host && _ws_plugin__s2member_force_ssl_host_port) /* Need port conversions? */
													$s = preg_replace ("/\/" . preg_quote (_ws_plugin__s2member_force_ssl_host, "/") . "(\:[0-9]+)?\//i", "/" . _ws_plugin__s2member_force_ssl_host_port . "/", $s);
												/**/
												$s = (strtolower ($m[1]) === "link" && preg_match ("/['\"]alternate['\"]/i", $m[0])) ? $m[0] : $s; /* Alternates are fine to leave like they are. */
												/**/
												return $s; /* Return string with conversions. */
											}
									}
								/**/
								if (!function_exists ("_ws_plugin__s2member_force_non_ssl_buffer_callback"))
									{
										function _ws_plugin__s2member_force_non_ssl_buffer_callback ($m = FALSE)
											{
												$s = preg_replace ("/https\:\/\/" . preg_quote (_ws_plugin__s2member_force_ssl_host_port, "/") . "/i", "http://" . _ws_plugin__s2member_force_ssl_host, $m[0]);
												/**/
												$s = preg_replace ("/https\:\/\/" . preg_quote (_ws_plugin__s2member_force_ssl_host, "/") . "/i", "http://" . _ws_plugin__s2member_force_ssl_host, $s);
												/*
												Data gets converted to prevent a site-wide conversion over to SSL links.
												*/
												return $s; /* Return string with conversions. */
											}
									}
								/**/
								if (!function_exists ("_ws_plugin__s2member_force_non_ssl_scheme"))
									{
										function _ws_plugin__s2member_force_non_ssl_scheme ($url = FALSE, $path = FALSE, $scheme = FALSE)
											{
												if (!in_array ($scheme, array ("http", "https"))) /* If NOT explicitly passed through. */
													{
														/* Allows for special exceptions to the rule of always forcing a non-SSL scheme. */
														if (($scheme === "login_post" || $scheme === "rpc") && (force_ssl_login () || force_ssl_admin ()))
															$scheme = "https";
														else if ($scheme === "login" && force_ssl_admin ())
															$scheme = "https";
														else if ($scheme === "admin" && force_ssl_admin ())
															$scheme = "https";
														else /* Defaults to http. */
															$scheme = "http";
													}
												/**/
												$scheme = apply_filters ("_ws_plugin__s2member_force_non_ssl_scheme", $scheme, get_defined_vars ());
												/**/
												return preg_replace ("/^http(s)?\:\/\//i", $scheme . "://", $url);
											}
									}
								/**/
								ob_start ("_ws_plugin__s2member_force_ssl_buffer");
							}
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>