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
if (!class_exists ("c_ws_plugin__s2member_files_in"))
	{
		class c_ws_plugin__s2member_files_in
			{
				/*
				Function for handling download access permissions.
				Attach to: add_action("init");
				*/
				public static function check_file_download_access ()
					{
						do_action ("ws_plugin__s2member_before_file_download_access", get_defined_vars ());
						/**/
						if ($_GET["s2member_file_download"]) /* Filter $excluded to force free downloads. */
							{
								$excluded = apply_filters ("ws_plugin__s2member_check_file_download_access_excluded", false, get_defined_vars ());
								/**/
								if (!$excluded && (!$_GET["s2member_file_download_key"] || ($_GET["s2member_file_download_key"] && ! ($file_download_key_is_valid = ($_GET["s2member_file_download_key"] === c_ws_plugin__s2member_files::file_download_key ($_GET["s2member_file_download"]) || $_GET["s2member_file_download_key"] === c_ws_plugin__s2member_files::file_download_key ($_GET["s2member_file_download"], true))))))
									{
										$_GET["s2member_file_download"] = trim ($_GET["s2member_file_download"], "/"); /* Trim slashes after Key comparison. */
										/**/
										if (!file_exists ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $_GET["s2member_file_download"]))
											{
												header ("HTTP/1.0 404 Not Found"); /* The file does NOT even exist. */
												exit ("404: Sorry, file not found. Please contact Support for assistance.");
											}
										else if ($_GET["s2member_file_download_key"] && !$file_download_key_is_valid) /* Was an invalid Key passed in? */
											{
												header ("HTTP/1.0 503 Service Temporarily Unavailable"); /* Invalid Download Keys are handled separately. */
												exit ("503 ( Invalid Key ): Sorry, your access to this file has expired. Please contact Support for assistance.");
											}
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]) /* Is a Membership Options Page configured? */
											/* This file will be processed WITHOUT a Download Key, using Membership Level Access ( w/ possible Custom Capabilities ). */
											{
												if (!has_filter ("ws_plugin__s2member_check_file_download_access_user", "c_ws_plugin__s2member_files_in::_file_remote_authorization"))
													add_filter ("ws_plugin__s2member_check_file_download_access_user", "c_ws_plugin__s2member_files_in::_file_remote_authorization", 10, 2);
												/**/
												if (($file_download_access_is_allowed = $min_level_4_downloads = c_ws_plugin__s2member_files::min_level_4_downloads ()) === false)
													{
														header ("HTTP/1.0 503 Service Temporarily Unavailable"); /* File downloads are NOT yet configured? */
														exit ("503: Sorry, file downloads are NOT enabled yet. Please contact Support for assistance. If you are the site owner, please configure `s2Member -> Download Options`.");
													}
												/**/
												else if ((!is_object ($user = apply_filters ("ws_plugin__s2member_check_file_download_access_user", ( (is_user_logged_in ()) ? wp_get_current_user () : false), get_defined_vars ())) || !$user->ID)/**/
												&& wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "file-" . $_GET["s2member_file_download"], "s2member_level_req" => (string)$min_level_4_downloads)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) !== "nill")
													exit ();
												/**/
												else if ((!is_array ($file_downloads = c_ws_plugin__s2member_files::user_downloads ($user)) || !$file_downloads["allowed"] || !$file_downloads["allowed_days"])/**/
												&& wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "file-" . $_GET["s2member_file_download"])), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) !== "nill")
													exit ();
												/**/
												else if (preg_match ("/^access[_\-]s2member[_\-]level([0-9]+)\//", $_GET["s2member_file_download"], $m))
													{
														$level_req = $m[1]; /* Which Level does this require? */
														if (!$user->has_cap ("access_s2member_level" . $level_req) /* Does the User have access to this Level? */
														&& wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "file-" . $_GET["s2member_file_download"], "s2member_level_req" => $level_req)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) !== "nill")
															exit ();
													}
												/**/
												else if (preg_match ("/^access[_\-]s2member[_\-]ccap[_\-](.+?)\//", $_GET["s2member_file_download"], $m))
													{
														$ccap_req = preg_replace ("/-/", "_", $m[1]); /* Which Capability does this require? */
														if (!$user->has_cap ("access_s2member_ccap_" . $ccap_req) /* Does the User have access to this Custom Capability? */
														&& wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "file-" . $_GET["s2member_file_download"], "s2member_ccap_req" => $ccap_req)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) !== "nill")
															exit ();
													}
												/**/
												$previous_file_downloads = 0; /* Here we're going to count how many downloads they've performed. */
												$max_days_logged = c_ws_plugin__s2member_files::max_download_period (); /* The longest period in days. */
												$file_download_access_log = (array)get_user_option ("s2member_file_download_access_log", $user->ID);
												$file_download_access_arc = (array)get_user_option ("s2member_file_download_access_arc", $user->ID);
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
												&& wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "file-" . $_GET["s2member_file_download"])), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) !== "nill")
													exit ();
												/**/
												if (!$already_downloaded) /* Only add this file to the log if they have not already downloaded it. */
													$file_download_access_log[] = array ("date" => date ("Y-m-d"), "file" => $_GET["s2member_file_download"]);
												/**/
												update_user_option ($user->ID, "s2member_file_download_access_arc", c_ws_plugin__s2member_utils_arrays::array_unique ($file_download_access_arc));
												update_user_option ($user->ID, "s2member_file_download_access_log", c_ws_plugin__s2member_utils_arrays::array_unique ($file_download_access_log));
											}
									}
								else /* Otherwise... it's either $excluded; or permission was granted with a valid Download Key. */
									{
										$_GET["s2member_file_download"] = trim ($_GET["s2member_file_download"], "/");
										/**/
										if (!file_exists ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $_GET["s2member_file_download"]))
											{
												header ("HTTP/1.0 404 Not Found"); /* The file does NOT even exist. */
												exit ("404: Sorry, file not found. Please contact Support for assistance.");
											}
									}
								/*
								Here we are going to put together all of the file download information.
								*/
								$mimetypes = parse_ini_file (dirname (dirname (dirname (__FILE__))) . "/includes/mime-types.ini");
								$pathinfo = pathinfo ($file = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $_GET["s2member_file_download"]);
								$extension = strtolower ($pathinfo["extension"]); /* Convert file extension to lowercase format for MIME type lookup. */
								$inline = ($_GET["s2member_file_inline"] || in_array ($extension, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_inline_extensions"]))) ? true : false;
								$mimetype = ($mimetypes[$extension]) ? $mimetypes[$extension] : "application/octet-stream"; /* Lookup MIME type. */
								$basename = $pathinfo["basename"]; /* The actual file name, including its extension. */
								$length = filesize ($file); /* The overall file size, in bytes. */
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_file_download_access", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/*
								Send the file to the browser in chunks ( in support of larger files ).
								Be sure to turn off output compression, as it DOES get in the way.
								*/
								@set_time_limit (0); /* Unlimited. */
								@ini_set ("zlib.output_compression", 0);
								/**/
								header ("Accept-Ranges: none");
								header ("Content-Encoding: none");
								header ("Content-Type: " . $mimetype);
								header ("Expires: " . gmdate ("D, d M Y H:i:s", strtotime ("-1 week")) . " GMT");
								header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
								header ("Cache-Control: no-cache, must-revalidate, max-age=0");
								header ("Cache-Control: post-check=0, pre-check=0", false);
								header ("Pragma: no-cache");
								/**/
								header ('Content-Disposition: ' . (($inline) ? "inline" : "attachment") . '; filename="' . $basename . '"');
								/**/
								if ($length && apply_filters ("ws_plugin__s2member_stream_file_downloads", true, get_defined_vars ()) && ($stream = fopen ($file, "rb")))
									{
										$_stream_w_content_length = (preg_match ("/^win/i", PHP_OS)) ? false : true; /* Windows® IIS does not jive here. */
										/* Windows® IIS doesn't seem to like it when both `Content-Length` and `Transfer-Encoding: chunked` are sent together. */
										if (apply_filters ("ws_plugin__s2member_stream_file_downloads_w_content_length", $_stream_w_content_length, get_defined_vars ()))
											header ("Content-Length: " . $length);
										/**/
										header ("Transfer-Encoding: chunked"); /* Uses `Transfer-Encoding: chunked` for simulated streaming. */
										/**/
										eval ('while (@ob_end_clean ());'); /* End/clean all output buffers that may or may not exist. */
										/**/
										while (!feof ($stream) && ($chunk_size = strlen ($data = fread ($stream, 2097152))))
											eval ('echo dechex ($chunk_size) . "\r\n". $data . "\r\n"; @flush ();');
										/**/
										fclose($stream);
										/**/
										exit ("0\r\n\r\n");
									}
								else if ($length) /* Else `file_get_contents()`. */
									{
										header ("Content-Length: " . $length);
										/**/
										exit (file_get_contents ($file));
									}
								else
									exit (); /* Empty file. */
							}
						/**/
						do_action ("ws_plugin__s2member_after_file_download_access", get_defined_vars ());
					}
				/*
				A sort of callback function that handles header authorization for File Downloads.
				Attach to: add_filter("ws_plugin__s2member_check_file_download_access_user");
				*/
				public static function _file_remote_authorization ($user = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_before_file_remote_authorization", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (!$user && $_GET["s2member_file_remote"]) /* Use remote header authorization? */
							{
								do_action ("_ws_plugin__s2member_during_file_remote_authorization_before", get_defined_vars ());
								/**/
								if (!$_SERVER["PHP_AUTH_USER"] || !$_SERVER["PHP_AUTH_PW"] || !user_pass_ok ($_SERVER["PHP_AUTH_USER"], $_SERVER["PHP_AUTH_PW"]))
									{
										header ('WWW-Authenticate: Basic realm="Members Only"');
										header ("HTTP/1.0 401 Unauthorized");
										exit ("Access Denied");
									}
								else if (is_object ($_user = new WP_User ($_SERVER["PHP_AUTH_USER"])) && $_user->ID)
									{
										$user = $_user; /* Now assign $user. */
									}
								/**/
								do_action ("_ws_plugin__s2member_during_file_remote_authorization_after", get_defined_vars ());
							}
						/**/
						return apply_filters ("_ws_plugin__s2member_file_remote_authorization", $user, get_defined_vars ());
					}
			}
	}
?>