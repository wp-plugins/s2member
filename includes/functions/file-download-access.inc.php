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
/*
Function determines the max period in days for download access.
Returns number of days, where 0 means no access to files has been allowed.
*/
if (!function_exists ("ws_plugin__s2member_max_download_period"))
	{
		function ws_plugin__s2member_max_download_period ()
			{
				do_action ("ws_plugin__s2member_before_max_download_period", get_defined_vars ());
				/**/
				if ($days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed_days"])
					{
						$max = ($max < $days) ? $days : $max;
					}
				/**/
				if ($days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed_days"])
					{
						$max = ($max < $days) ? $days : $max;
					}
				/**/
				if ($days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed_days"])
					{
						$max = ($max < $days) ? $days : $max;
					}
				/**/
				if ($days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed_days"])
					{
						$max = ($max < $days) ? $days : $max;
					}
				/**/
				return apply_filters ("ws_plugin__s2member_max_download_period", (($max > 365) ? 365 : (int)$max), get_defined_vars ());
			}
	}
/*
Function determines how many downloads allowed - etc, etc.
Returns an array with 3 elements: allowed, allowed_days, currently.
The 2nd parameter can be used to prevent another database connection.
*/
if (!function_exists ("ws_plugin__s2member_user_downloads"))
	{
		function ws_plugin__s2member_user_downloads ($not_counting_this_particular_file = false, $log = null)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_user_downloads", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (($current_user = (is_user_logged_in ()) ? wp_get_current_user () : false))
					{
						if (current_user_can ("access_s2member_level0") && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed"])
							{
								$allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed"];
								$allowed_days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed_days"];
							}
						/**/
						if (current_user_can ("access_s2member_level1") && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed"])
							{
								$allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed"];
								$allowed_days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed_days"];
							}
						/**/
						if (current_user_can ("access_s2member_level2") && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed"])
							{
								$allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed"];
								$allowed_days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed_days"];
							}
						/**/
						if (current_user_can ("access_s2member_level3") && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed"])
							{
								$allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed"];
								$allowed_days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed_days"];
							}
						/**/
						if (current_user_can ("access_s2member_level4") && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed"])
							{
								$allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed"];
								$allowed_days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed_days"];
							}
						/**/
						$file_download_access_log = (isset ($log)) ? (array)$log : (array)get_usermeta ($current_user->ID, "s2member_file_download_access_log");
						foreach ($file_download_access_log as $file_download_access_log_entry_key => $file_download_access_log_entry)
							if (strtotime ($file_download_access_log_entry["date"]) >= strtotime ("-" . (int)$allowed_days . " days"))
								if ($file_download_access_log_entry["file"] !== $not_counting_this_particular_file)
									$currently = ($currently) ? $currently + 1 : 1;
					}
				/**/
				return apply_filters ("ws_plugin__s2member_user_downloads", array ("allowed" => (int)$allowed, "allowed_days" => (int)$allowed_days, "currently" => (int)$currently), get_defined_vars ());
			}
	}
/*
Function determines the minimum level required for file download access.
Test === false to see if no access is allowed.
This returns false, or (int)[0-1].
*/
if (!function_exists ("ws_plugin__s2member_min_level_4_downloads"))
	{
		function ws_plugin__s2member_min_level_4_downloads ()
			{
				do_action ("ws_plugin__s2member_before_min_level_4_downloads", get_defined_vars ());
				/**/
				$file_download_access_is_allowed = $min_level_4_downloads = false; /* Test with === false, which means no access is allowed at all. */
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed_days"])
					{
						$file_download_access_is_allowed = $min_level_4_downloads = 0;
					}
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed_days"])
					{
						$file_download_access_is_allowed = $min_level_4_downloads = 1;
					}
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed_days"])
					{
						$file_download_access_is_allowed = $min_level_4_downloads = 2;
					}
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed_days"])
					{
						$file_download_access_is_allowed = $min_level_4_downloads = 3;
					}
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed_days"])
					{
						$file_download_access_is_allowed = $min_level_4_downloads = 4;
					}
				/**/
				return apply_filters ("ws_plugin__s2member_min_level_4_downloads", ($file_download_access_is_allowed = $min_level_4_downloads), get_defined_vars ());
			}
	}
/*
Function for handling download access permissions.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_check_file_download_access"))
	{
		function ws_plugin__s2member_check_file_download_access ()
			{
				do_action ("ws_plugin__s2member_before_file_download_access", get_defined_vars ());
				/**/
				if ($_GET["s2member_file_download"]) /* Filter $excluded to force free downloads. */
					{
						$excluded = apply_filters ("ws_plugin__s2member_check_file_download_access_excluded", false, get_defined_vars ());
						/**/
						$_GET["s2member_file_download_key"] = (!$_GET["s2member_file_download_key"] && $_GET["s2member_free_file_download_key"]) ? $_GET["s2member_free_file_download_key"] : $_GET["s2member_file_download_key"];
						/**/
						/* The use of `md5(s2member_xencrypt("locaton of file"))` was deprecated in v3.0.5 in favor of `s2member_file_download_key()` - because it provides better security and greater flexibility. Also, $_GET["s2member_free_file_download_key"] is deprecated, in favor of $_GET["s2member_file_download_key"]. */
						if (!$excluded && (!$_GET["s2member_file_download_key"] || ($_GET["s2member_file_download_key"] && !($_GET["s2member_file_download_key"] === ws_plugin__s2member_file_download_key ($_GET["s2member_file_download"]) || $_GET["s2member_file_download_key"] === ws_plugin__s2member_file_download_key ($_GET["s2member_file_download"], "cache-compatible") || /* Deprecated « */ $_GET["s2member_file_download_key"] === md5 (ws_plugin__s2member_xencrypt ($_GET["s2member_file_download"])) /* » */))) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
							{
								$_GET["s2member_file_download"] = trim ($_GET["s2member_file_download"], "/"); /* Now trim slashes after key comparison. */
								/**/
								$file_download_access_is_allowed = $min_level_4_downloads = ws_plugin__s2member_min_level_4_downloads ();
								/**/
								if ($file_download_access_is_allowed === false) /* Have file downloads even been enabled? */
									{
										header ("HTTP/1.0 503 Service Temporarily Unavailable"); /* Not yet configured? */
										exit ("503: Sorry, file downloads are not enabled yet. Please contact Support for assistance. If you are the site owner, please configure `s2Member -> Download Options`.");
									}
								/**/
								else if (!($current_user = (is_user_logged_in ()) ? wp_get_current_user () : false) /* Redirect Users who are not logged in. */
								&& wp_redirect (add_query_arg (array ("s2member_level_req" => (string)$min_level_4_downloads, "s2member_file_download_req" => $_GET["s2member_file_download"]), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
									exit ();
								/**/
								else if (!file_exists ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $_GET["s2member_file_download"]))
									{
										header ("HTTP/1.0 404 Not Found"); /* The file does not even exist? */
										exit ("404: Sorry, file download not found. Please contact Support for assistance.");
									}
								/**/
								else if ((!is_array ($file_downloads = ws_plugin__s2member_user_downloads ()) || !$file_downloads["allowed"] || !$file_downloads["allowed_days"])/**/
								&& wp_redirect (add_query_arg (array ("s2member_file_download_req" => $_GET["s2member_file_download"]), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]))) !== "nill")
									exit ();
								/**/
								else if (preg_match ("/^access[_\-]s2member[_\-]level([0-9]+)\//", $_GET["s2member_file_download"])) /* Level required? */
									{
										list ($level_req) = preg_split ("/\//", $_GET["s2member_file_download"], 2); /* Which Level does this require? */
										$level_req = preg_replace ("/[^0-9]/", "", $level_req);
										/**/
										if (!$current_user->has_cap ("access_s2member_level" . $level_req) /* Ok, do they have permission? */
										&& wp_redirect (add_query_arg (array ("s2member_level_req" => $level_req, "s2member_file_download_req" => $_GET["s2member_file_download"]), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
									}
								/**/
								else if (preg_match ("/^access[_\-]s2member[_\-]ccap[_\-](.+?)\//", $_GET["s2member_file_download"])) /* Custom Capability? */
									{
										list ($ccap_req) = preg_split ("/\//", $_GET["s2member_file_download"], 2); /* Which Capability does this require? */
										$ccap_req = preg_replace ("/-/", "_", $ccap_req);
										/**/
										if (!$current_user->has_cap ($ccap_req) /* Ok, do they have permission? */
										&& wp_redirect (add_query_arg (array ("s2member_ccap_req" => $ccap_req, "s2member_file_download_req" => $_GET["s2member_file_download"]), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
									}
								/**/
								$previous_file_downloads = 0; /* Here we're going to count how many downloads they've performed. */
								$max_days_logged = ws_plugin__s2member_max_download_period (); /* The longest period in days. */
								$file_download_access_log = (array)get_usermeta ($current_user->ID, "s2member_file_download_access_log");
								$file_download_access_arc = (array)get_usermeta ($current_user->ID, "s2member_file_download_access_arc");
								/**/
								foreach ($file_download_access_log as $file_download_access_log_entry_key => $file_download_access_log_entry)
									{
										if (strtotime ($file_download_access_log_entry["date"]) < strtotime ("-" . $max_days_logged . " days"))
											{
												unset ($file_download_access_log[$file_download_access_log_entry_key]);
												$file_download_access_arc[] = $file_download_access_log_entry;
											}
										else if (strtotime ($file_download_access_log_entry["date"]) >= strtotime ("-" . $file_downloads["allowed_days"] . " days"))
											{
												$previous_file_downloads++;
												/* Here we check if this file has already been downloaded. */
												if ($file_download_access_log_entry["file"] === $_GET["s2member_file_download"])
													$already_downloaded = true;
											}
									}
								/**/
								if (!$already_downloaded && $previous_file_downloads >= $file_downloads["allowed"] /* They have NOT already downloaded this file, and they're over their limit. */
								&& wp_redirect (add_query_arg (array ("s2member_file_download_req" => $_GET["s2member_file_download"]), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]))) !== "nill")
									exit ();
								/**/
								if (!$already_downloaded) /* Only add this file to the log if they have not already downloaded it. */
									$file_download_access_log[] = array ("date" => date ("Y-m-d"), "file" => $_GET["s2member_file_download"]);
								/**/
								update_usermeta ($current_user->ID, "s2member_file_download_access_arc", ws_plugin__s2member_array_unique ($file_download_access_arc));
								update_usermeta ($current_user->ID, "s2member_file_download_access_log", ws_plugin__s2member_array_unique ($file_download_access_log));
							}
						else /* Else, this is a download that is either $excluded, or has been granted exclusive permission with a key. */
							{
								$_GET["s2member_file_download"] = trim ($_GET["s2member_file_download"], "/");
								/**/
								if (!file_exists ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $_GET["s2member_file_download"]))
									{
										header ("HTTP/1.0 404 Not Found"); /* The file does not even exist? */
										exit ("404: Sorry, file download not found. Please contact Support for assistance.");
									}
							}
						/*
						Here we are going to put together all of the file download information.
						*/
						$mimetypes = parse_ini_file (dirname (dirname (dirname (__FILE__))) . "/includes/mime-types.ini");
						$pathinfo = pathinfo ($file = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $_GET["s2member_file_download"]);
						$extension = strtolower ($pathinfo["extension"]); /* Convert file extension to lowercase format for MIME type lookup. */
						$inline = (in_array ($extension, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_inline_extensions"]))) ? true : false;
						$mimetype = ($mimetypes[$extension]) ? $mimetypes[$extension] : "application/octet-stream"; /* Lookup MIME type. */
						$basename = $pathinfo["basename"]; /* The actual file name, including its extension. */
						$length = filesize ($file); /* The overall file size, in bytes. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_file_download_access", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/*
						Now send the file to the browser. Be sure to turn off output compression.
						*/
						set_time_limit (0); /* Make time. */
						ini_set ("zlib.output_compression", 0);
						/**/
						header ("Content-Encoding: none");
						header ("Content-Type: " . $mimetype);
						header ("Content-Length: " . $length);
						/**/
						if (!$inline) /* If not inline, we default to serving the file as an attachment. */
							header ('Content-Disposition: attachment; filename="' . $basename . '"');
						/**/
						header ("Expires: " . gmdate ("D, d M Y H:i:s", strtotime ("-1 week")) . " GMT");
						header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
						header ("Cache-Control: no-cache, must-revalidate, max-age=0");
						header ("Cache-Control: post-check=0, pre-check=0", false);
						header ("Pragma: no-cache");
						/**/
						ob_clean () . flush () . readfile ($file);
						/**/
						exit ();
					}
				/**/
				do_action ("ws_plugin__s2member_after_file_download_access", get_defined_vars ());
			}
	}
/*
Function creates a special File Download Key.
Uses: date("Y-m-d") . $_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_USER_AGENT"] . $file.
The optional second argument can be passed in for compatiblity with Quick Cache / WP Super Cache.
When $cache_compatible is passed in, the salt is reduced to only the $file value.
*/
if (!function_exists ("ws_plugin__s2member_file_download_key"))
	{
		function ws_plugin__s2member_file_download_key ($file = FALSE, $cache_compatible = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_file_download_key", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$salt = ($cache_compatible) ? $file /* Cache compatible — only the file. */
				: date ("Y-m-d") . $_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_USER_AGENT"] . $file;
				$key = md5 (ws_plugin__s2member_xencrypt ($salt));
				/**/
				if (!$cache_compatible) /* Disallow caching. */
					ws_plugin__s2member_nocache_constants (true);
				/**/
				return apply_filters ("ws_plugin__s2member_file_download_key", $key, get_defined_vars ());
			}
		function s2member_file_download_key ($file = FALSE, $cache_compatible = FALSE)
			{
				return ws_plugin__s2member_file_download_key ($file, $cache_compatible);
			}
	}
?>