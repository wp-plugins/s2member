<?php
/**
* File Download routines for s2Member ( inner processing routines ).
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
* @package s2Member\Files
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_files_in"))
	{
		/**
		* File Download routines for s2Member ( inner processing routines ).
		*
		* @package s2Member\Files
		* @since 3.5
		*/
		class c_ws_plugin__s2member_files_in
			{
				/**
				* Handles Download Access permissions.
				*
				* @package s2Member\Files
				* @since 3.5
				*
				* @attaches-to: ``add_action("init");``
				* @also-called-by: API Function {@link s2Member\API_Functions\s2member_file_download_url()}, w/ ``$create_file_download_url`` param.
				*
				* @param array $create_file_download_url Optional. If this function is called directly, we can pass arguments through this array.
				* 	Possible array elements: `file_download` *(required)*, `file_download_key`, `file_stream`, `file_inline`, `file_storage`, `file_remote`, `file_ssl`, `file_rewrite`, `file_rewrite_base`, `skip_confirmation`, `url_to_storage_source`, `count_against_user`, `check_user`.
				* @return null|str If called directly with ``$create_file_download_url``, returns a string with the URL, based on configuration.
				* 	Else, this function may exit script execution after serving a File Download.
				*/
				public static function check_file_download_access ($create_file_download_url = FALSE)
					{
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_file_download_access", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$_g = !empty ($_GET) ? $_GET : array ();
						$_g = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($_g));
						/**/
						$creating = (is_array ($create = $create_file_download_url)) ? true : false; /* Creating URL? */
						$serving = (!$creating) ? true : false; /* If NOT creating a File Download URL, we're serving one. */
						/**/
						$req["file_download"] = ($creating) ? @$create["file_download"] : @$_g["s2member_file_download"];
						$req["file_download_key"] = ($creating) ? @$create["file_download_key"] : @$_g["s2member_file_download_key"];
						/**/
						$req["file_stream"] = ($creating) ? @$create["file_stream"] : @$_g["s2member_file_stream"];
						$req["file_inline"] = ($creating) ? @$create["file_inline"] : @$_g["s2member_file_inline"];
						$req["file_storage"] = ($creating) ? @$create["file_storage"] : @$_g["s2member_file_storage"];
						$req["file_remote"] = ($creating) ? @$create["file_remote"] : @$_g["s2member_file_remote"];
						$req["file_ssl"] = ($creating) ? @$create["file_ssl"] : @$_g["s2member_file_ssl"];
						/**/
						$req["file_rewrite"] = ($creating) ? @$create["file_rewrite"] : /* N/A. */ null;
						$req["file_rewrite_base"] = ($creating) ? @$create["file_rewrite_base"] : /* N/A. */ null;
						/**/
						$req["skip_confirmation"] = ($creating) ? @$create["skip_confirmation"] : /* N/A. */ null;
						$req["url_to_storage_source"] = ($creating) ? @$create["url_to_storage_source"] : /* N/A. */ null;
						$req["count_against_user"] = ($creating) ? @$create["count_against_user"] : /* N/A. */ null;
						$req["check_user"] = ($creating) ? @$create["check_user"] : /* N/A. */ null;
						/**/
						if ($req["file_download"] && is_string ($req["file_download"]) && ($req["file_download"] = trim ($req["file_download"], "/")))
							if (strpos ($req["file_download"], "..") === false && strpos (basename ($req["file_download"]), ".") !== 0)
								{
									$using_amazon_s3_storage = ((!$req["file_storage"] || strcasecmp ((string)$req["file_storage"], "s3") === 0) && c_ws_plugin__s2member_utils_conds::using_amazon_s3_storage ()) ? true : false;
									$using_amazon_cf_storage = ((!$req["file_storage"] || strcasecmp ((string)$req["file_storage"], "cf") === 0) && c_ws_plugin__s2member_utils_conds::using_amazon_cf_storage ()) ? true : false;
									$using_amazon_storage = ($using_amazon_s3_storage || $using_amazon_cf_storage) ? true : false; /* Either/or? */
									/**/
									$excluded = apply_filters ("ws_plugin__s2member_check_file_download_access_excluded", false, get_defined_vars ());
									$valid_file_download_key = ($req["file_download_key"] && is_string ($req["file_download_key"])) ? c_ws_plugin__s2member_files_in::check_file_download_key ($req["file_download"], $req["file_download_key"]) : false;
									$checking_user = ($excluded || $valid_file_download_key || ($creating && (!isset ($req["check_user"]) || !filter_var ($req["check_user"], FILTER_VALIDATE_BOOLEAN)) && (!isset ($req["count_against_user"]) || !filter_var ($req["count_against_user"], FILTER_VALIDATE_BOOLEAN)))) ? false : true;
									$updating_user_counter = (!$checking_user || ($creating && (!isset ($req["count_against_user"]) || !filter_var ($req["count_against_user"], FILTER_VALIDATE_BOOLEAN)))) ? false : true;
									/**/
									if (($serving || $creating) && $checking_user) /* In either case, the following routines apply whenever we ARE ``$checking_user``. */
										{
											if (!$using_amazon_storage && !file_exists ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $req["file_download"]))
												{
													if ($serving) /* We only need this section when/if we're actually serving. */
														status_header(404) . header ("Content-Type: text/html; charset=utf-8") . eval ('while (@ob_end_clean ());') #
														. exit (_x ('<strong>404: Sorry, file not found.</strong> Please contact Support for assistance.', "s2member-front", "s2member"));
													/**/
													else /* Else return false. */
														return false;
												}
											/**/
											else if ($req["file_download_key"] && is_string ($req["file_download_key"]) && !$valid_file_download_key)
												{
													if ($serving) /* We only need this section when/if we're actually serving. */
														status_header(503) . header ("Content-Type: text/html; charset=utf-8") . eval ('while (@ob_end_clean ());') #
														. exit (_x ('<strong>503 ( Invalid Key ):</strong> Sorry, your access to this file has expired. Please contact Support for assistance.', "s2member-front", "s2member"));
													/**/
													else /* Else return false. */
														return false;
												}
											/**/
											else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"] || ($file_downloads_enabled_by_site_owner = $min_level_4_downloads = c_ws_plugin__s2member_files::min_level_4_downloads ()) === false)
												{
													if ($serving) /* We only need remote functionality when/if we're actually serving. */
														if (!has_filter ("ws_plugin__s2member_check_file_download_access_user", "c_ws_plugin__s2member_files_in::check_file_remote_authorization"))
															add_filter ("ws_plugin__s2member_check_file_download_access_user", "c_ws_plugin__s2member_files_in::check_file_remote_authorization", 10, 2);
													/**/
													if ($creating) /* We only need remote functionality when/if we're actually serving. */
														if (has_filter ("ws_plugin__s2member_check_file_download_access_user", "c_ws_plugin__s2member_files_in::check_file_remote_authorization"))
															remove_filter ("ws_plugin__s2member_check_file_download_access_user", "c_ws_plugin__s2member_files_in::check_file_remote_authorization", 10, 2);
													/**/
													if ((isset ($file_downloads_enabled_by_site_owner, $min_level_4_downloads) && $file_downloads_enabled_by_site_owner === false) || ($file_downloads_enabled_by_site_owner = $min_level_4_downloads = c_ws_plugin__s2member_files::min_level_4_downloads ()) === false)
														{
															if ($serving) /* We only need this section when/if we're actually serving. */
																status_header(503) . header ("Content-Type: text/html; charset=utf-8") . eval ('while (@ob_end_clean ());') #
																. exit (_x ('<strong>503: Basic File Downloads are NOT enabled yet.</strong> Please contact Support for assistance. If you are the site owner, please configure: <code>s2Member -> Download Options -> Basic Download Restrictions</code>.', "s2member-front", "s2member"));
															/**/
															else /* Else return false. */
																return false;
														}
													/**/
													else if (!is_object ($user = apply_filters ("ws_plugin__s2member_check_file_download_access_user", ((is_user_logged_in ()) ? wp_get_current_user () : false), get_defined_vars ())) || empty ($user->ID) || !($user_id = $user->ID) || !is_array ($user_file_downloads = c_ws_plugin__s2member_files::user_downloads ($user)) || (!$user->has_cap ("administrator") && (!$user_file_downloads["allowed"] || !$user_file_downloads["allowed_days"])))
														{
															if (preg_match ("/^access[_\-]s2member[_\-]level([0-9]+)\//", $req["file_download"], $m) && strlen ($level_req = $m[1]) && (!is_object ($user) || empty ($user->ID) || !$user->has_cap ("access_s2member_level" . $level_req)))
																{
																	if ($serving) /* We only need this section when/if we're actually serving. */
																		wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "file-" . $req["file_download"], "s2member_level_req" => $level_req)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) . exit ();
																	/**/
																	else /* Else return false. */
																		return false;
																}
															/**/
															else if (preg_match ("/^access[_\-]s2member[_\-]ccap[_\-](.+?)\//", $req["file_download"], $m) && strlen ($ccap_req = preg_replace ("/-/", "_", $m[1])) && (!is_object ($user) || empty ($user->ID) || !$user->has_cap ("access_s2member_ccap_" . $ccap_req)))
																{
																	if ($serving) /* We only need this section when/if we're actually serving. */
																		wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "file-" . $req["file_download"], "s2member_ccap_req" => $ccap_req)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) . exit ();
																	/**/
																	else /* Else return false. */
																		return false;
																}
															/**/
															else if ($serving) /* We only need this section when/if we're actually serving. */
																wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "file-" . $req["file_download"], "s2member_level_req" => (string)$min_level_4_downloads)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) . exit ();
															/**/
															else /* Else return false. */
																return false;
														}
													/**/
													else if (preg_match ("/^access[_\-]s2member[_\-]level([0-9]+)\//", $req["file_download"], $m) && strlen ($level_req = $m[1]) && !$user->has_cap ("access_s2member_level" . $level_req))
														{
															if ($serving) /* We only need this section when/if we're actually serving. */
																wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "file-" . $req["file_download"], "s2member_level_req" => $level_req)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) . exit ();
															/**/
															else /* Else return false. */
																return false;
														}
													/**/
													else if (preg_match ("/^access[_\-]s2member[_\-]ccap[_\-](.+?)\//", $req["file_download"], $m) && strlen ($ccap_req = preg_replace ("/-/", "_", $m[1])) && !$user->has_cap ("access_s2member_ccap_" . $ccap_req))
														{
															if ($serving) /* We only need this section when/if we're actually serving. */
																wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "file-" . $req["file_download"], "s2member_ccap_req" => $ccap_req)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) . exit ();
															/**/
															else /* Else return false. */
																return false;
														}
													/**/
													else if ($serving || $creating) /* In either case, the following routines apply. */
														{
															$user_previous_file_downloads = 0; /* Downloads the User has already; in current period/cycle. */
															$user_already_downloaded_this_file = $user_already_downloaded_a_streaming_variation_of_this_file = false;
															/**/
															$user_file_download_access_log = (array)get_user_option ("s2member_file_download_access_log", $user_id);
															$user_file_download_access_arc = (array)get_user_option ("s2member_file_download_access_arc", $user_id);
															/**/
															$streaming_file_extns = c_ws_plugin__s2member_utils_strings::preg_quote_deep ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["streaming_file_extns"], "/");
															$streaming_variations = /* Only count one streaming media file variation. */ "/\.(" . implode ("|", $streaming_file_extns) . ")$/i";
															/**/
															$max_download_period_days = c_ws_plugin__s2member_files::max_download_period (); /* Max download period; counted in days. */
															/**/
															foreach ($user_file_download_access_log as $user_file_download_access_log_entry_key => $user_file_download_access_log_entry)
																{
																	if (strtotime ($user_file_download_access_log_entry["date"]) < strtotime ("-" . $max_download_period_days . " days"))
																		{
																			unset($user_file_download_access_log[$user_file_download_access_log_entry_key]);
																			$user_file_download_access_arc[] = $user_file_download_access_log_entry;
																		}
																	else if (strtotime ($user_file_download_access_log_entry["date"]) >= strtotime ("-" . $user_file_downloads["allowed_days"] . " days"))
																		{
																			$user_previous_file_downloads++; /* A previous file that counts against this User/Member, since it's already in the log. */
																			/**/
																			if ($user_file_download_access_log_entry["file"] === $req["file_download"]) /* Already downloaded this file before? */
																				$user_already_downloaded_this_file = true; /* Already downloaded this file? If yes, mark this flag as true. */
																			/**/
																			else if (preg_replace ($streaming_variations, "", $user_file_download_access_log_entry["file"]) === preg_replace ($streaming_variations, "", $req["file_download"]))
																				$user_already_downloaded_this_file = $user_already_downloaded_a_streaming_variation_of_this_file = true;
																		}
																}
															/**/
															if (!$user_already_downloaded_this_file && !$user_already_downloaded_a_streaming_variation_of_this_file && !$user->has_cap ("administrator") && $user_previous_file_downloads >= $user_file_downloads["allowed"])
																{
																	if ($serving) /* We only need this section when/if we're actually serving. */
																		wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "file-" . $req["file_download"])), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) . exit ();
																	/**/
																	else /* Else return false. */
																		return false;
																}
															/**/
															else if (!$user_already_downloaded_this_file && !$user_already_downloaded_a_streaming_variation_of_this_file)
																$user_file_download_access_log[] = array ("date" => date ("Y-m-d"), "file" => $req["file_download"]);
															/**/
															if ($updating_user_counter) /* By default, we do NOT update the counter when a URL is being created; but this behavior can be modified. */
																{
																	update_user_option ($user_id, "s2member_file_download_access_arc", c_ws_plugin__s2member_utils_arrays::array_unique ($user_file_download_access_arc));
																	update_user_option ($user_id, "s2member_file_download_access_log", c_ws_plugin__s2member_utils_arrays::array_unique ($user_file_download_access_log));
																}
														}
												}
										}
									else /* Otherwise, we're either NOT ``$checking_user``; or permission was granted with a valid File Download Key. */
										{
											if (!$using_amazon_storage && !file_exists ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $req["file_download"]))
												{
													if ($serving) /* We only need this section when/if we're actually serving. */
														status_header(404) . header ("Content-Type: text/html; charset=utf-8") . eval ('while (@ob_end_clean ());') #
														. exit (_x ('<strong>404: Sorry, file not found.</strong> Please contact Support for assistance.', "s2member-front", "s2member"));
													/**/
													else /* Else return false. */
														return false;
												}
										}
									/**/
									if ($serving || $creating) /* In either case, the following routines apply. */
										{
											$basename = basename ($req["file_download"]);
											$mimetypes = parse_ini_file (dirname (dirname (dirname (__FILE__))) . "/includes/mime-types.ini");
											$extension = strtolower (substr ($req["file_download"], strrpos ($req["file_download"], ".") + 1));
											/**/
											$key = ($req["file_download_key"] && is_string ($req["file_download_key"])) ? $req["file_download_key"] : false;
											/**/
											$stream = (isset ($req["file_stream"])) ? filter_var ($req["file_stream"], FILTER_VALIDATE_BOOLEAN) : ((in_array ($extension, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_stream_extensions"]))) ? true : false);
											$inline = (!$stream && isset ($req["file_inline"])) ? filter_var ($req["file_inline"], FILTER_VALIDATE_BOOLEAN) : (($stream || in_array ($extension, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_inline_extensions"]))) ? true : false);
											$ssl = (isset ($req["file_ssl"])) ? filter_var ($req["file_ssl"], FILTER_VALIDATE_BOOLEAN) : ((is_ssl ()) ? true : false);
											$storage = ($req["file_storage"] && is_string ($req["file_storage"])) ? strtolower ($req["file_storage"]) : false;
											$remote = (isset ($req["file_remote"])) ? filter_var ($req["file_remote"], FILTER_VALIDATE_BOOLEAN) : false;
											/**/
											$rewrite_base_guess = dirname ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . "/" . c_ws_plugin__s2member_utils_dirs::basename_dir_app_data ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"]);
											$rewrite_base = ($req["file_rewrite_base"] && is_string ($req["file_rewrite_base"])) ? $req["file_rewrite_base"] : false;
											$rewrite = $rewriting = (!$rewrite_base && isset ($req["file_rewrite"])) ? filter_var ($req["file_rewrite"], FILTER_VALIDATE_BOOLEAN) : (($rewrite_base) ? true : false);
											/**/
											$skip_confirmation = (isset ($req["skip_confirmation"])) ? filter_var ($req["skip_confirmation"], FILTER_VALIDATE_BOOLEAN) : false;
											$url_to_storage_source = (isset ($req["url_to_storage_source"])) ? filter_var ($req["url_to_storage_source"], FILTER_VALIDATE_BOOLEAN) : false;
											/**/
											$pathinfo = (!$using_amazon_storage) ? pathinfo (($file = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $req["file_download"])) : array ();
											$mimetype = ($mimetypes[$extension]) ? $mimetypes[$extension] : "application/octet-stream";
											$length = (!$using_amazon_storage && $file) ? filesize ($file) : -1;
											/**/
											eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
											do_action ("ws_plugin__s2member_during_file_download_access", get_defined_vars ());
											unset ($__refs, $__v); /* Unset defined __refs, __v. */
											/**/
											if ($using_amazon_s3_storage && ($serving || ($creating && $url_to_storage_source)))
												{
													if ($serving) /* We only need this section when/if we're actually serving. */
														wp_redirect(c_ws_plugin__s2member_files_in::amazon_s3_url ($req["file_download"], $stream, $inline, $ssl, $basename, $mimetype)) . exit ();
													/**/
													else /* Else return File Download URL. */
														return apply_filters ("ws_plugin__s2member_file_download_access_url", c_ws_plugin__s2member_files_in::amazon_s3_url ($req["file_download"], $stream, $inline, $ssl, $basename, $mimetype), get_defined_vars ());
												}
											/**/
											else if ($using_amazon_cf_storage && ($serving || ($creating && $url_to_storage_source)))
												{
													if ($serving) /* We only need this section when/if we're actually serving. */
														wp_redirect(c_ws_plugin__s2member_files_in::amazon_cf_url ($req["file_download"], $stream, $inline, $ssl, $basename, $mimetype)) . exit ();
													/**/
													else /* Else return File Download URL. */
														return apply_filters ("ws_plugin__s2member_file_download_access_url", c_ws_plugin__s2member_files_in::amazon_cf_url ($req["file_download"], $stream, $inline, $ssl, $basename, $mimetype), get_defined_vars ());
												}
											/**/
											else if ($creating && $rewriting) /* Creating a rewrite URL, pointing to local storage. */
												{
													$url = ($rewrite_base) ? rtrim ($rewrite_base, "/") : rtrim ($rewrite_base_guess, "/");
													$url .= (isset ($req["file_download_key"])) ? (($key) ? "/s2member-file-download-key-" . $key : "") : "";
													$url .= (isset ($req["file_stream"])) ? (($stream) ? "/s2member-file-stream" : "/s2member-file-stream-no") : "";
													$url .= (isset ($req["file_inline"])) ? (($inline) ? "/s2member-file-inline" : "/s2member-file-inline-no") : "";
													$url .= (isset ($req["file_storage"])) ? (($storage) ? "/s2member-file-storage-" . $storage : "") : "";
													$url .= (isset ($req["file_remote"])) ? (($remote) ? "/s2member-file-remote" : "/s2member-file-remote-no") : "";
													$url .= (isset ($req["skip_confirmation"])) ? (($skip_confirmation) ? "/s2member-skip-confirmation" : "/s2member-skip-confirmation-no") : "";
													/**/
													$url = $url . "/" . $req["file_download"]; /* File Download Access URL via `mod_rewrite` functionality. */
													$url = ($ssl) ? preg_replace ("/^https?/", "https", $url) : preg_replace ("/^https?/", "http", $url);
													/**/
													return apply_filters ("ws_plugin__s2member_file_download_access_url", $url, get_defined_vars ());
												}
											/**/
											else if ($creating) /* Else we're creating a URL w/ a query-string, pointing to local storage. */
												{
													$url = (isset ($req["file_download_key"])) ? (($key) ? "&s2member_file_download_key=" . urlencode ($key) : "") : "";
													$url .= (isset ($req["file_stream"])) ? (($stream) ? "&s2member_file_stream=yes" : "&s2member_file_stream=no") : "";
													$url .= (isset ($req["file_inline"])) ? (($inline) ? "&s2member_file_inline=yes" : "&s2member_file_inline=no") : "";
													$url .= (isset ($req["file_storage"])) ? (($storage) ? "&s2member_file_storage=" . urlencode ($storage) : "") : "";
													$url .= (isset ($req["file_remote"])) ? (($remote) ? "&s2member_file_remote=yes" : "&s2member_file_remote=no") : "";
													$url .= (isset ($req["skip_confirmation"])) ? (($skip_confirmation) ? "&s2member_skip_confirmation=yes" : "&s2member_skip_confirmation=no") : "";
													/**/
													$url = site_url ("/?" . ltrim ($url . "&s2member_file_download=/" . urlencode ($req["file_download"]), "&"));
													$url = ($ssl) ? preg_replace ("/^https?/", "https", $url) : preg_replace ("/^https?/", "http", $url);
													/**/
													return apply_filters ("ws_plugin__s2member_file_download_access_url", $url, get_defined_vars ());
												}
											/**/
											else /* Else, ``if ($serving)`` , use local storage option (default). */
												{
													@set_time_limit(0) . @ini_set ("zlib.output_compression", 0);
													/**/
													status_header(200); /* 200 OK status header. */
													/**/
													header("Accept-Ranges: none");
													header("Content-Encoding: none");
													header("Content-Type: " . $mimetype);
													header("Expires: " . gmdate ("D, d M Y H:i:s", strtotime ("-1 week")) . " GMT");
													header("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
													header("Cache-Control: no-cache, must-revalidate, max-age=0");
													header ("Cache-Control: post-check=0, pre-check=0", false);
													header("Pragma: no-cache");
													/**/
													header('Content-Disposition: ' . (($inline) ? "inline" : "attachment") . '; filename="' . $basename . '"');
													/**/
													eval('while (@ob_end_clean ());'); /* End/clean any output buffers that may exist already. */
													/**/
													if ($length && apply_filters ("ws_plugin__s2member_chunk_file_downloads", true, get_defined_vars ()) && is_resource ($resource = fopen ($file, "rb")))
														{
															$_chunk_size = apply_filters ("ws_plugin__s2member_chunk_file_downloads_w_chunk_size", 2097152, get_defined_vars ());
															$_chunk_w_content_length = (stripos (PHP_OS, "win") === 0 && (!function_exists ("apache_get_version") || apache_get_version () === false)) ? false : true;
															/**/
															/* Windows® IIS doesn't seem to like it when both `Content-Length` and `Transfer-Encoding: chunked` are sent together. */
															if (apply_filters ("ws_plugin__s2member_chunk_file_downloads_w_content_length", $_chunk_w_content_length, get_defined_vars ()))
																header("Content-Length: " . $length);
															/**/
															header("Transfer-Encoding: chunked"); /* Uses `Transfer-Encoding: chunked` for simulated streaming. */
															/**/
															while (!feof ($resource) && ($chunk_size = strlen ($data = fread ($resource, $_chunk_size))))
																eval('echo dechex ($chunk_size) . "\r\n". $data . "\r\n"; @flush ();');
															/**/
															fclose($resource) . exit ("0\r\n\r\n");
														}
													else if ($length) /* Else, use: ``file_get_contents()``. */
														{
															header("Content-Length: " . $length) . exit (file_get_contents ($file));
														}
													else /* Else, we have an empty file with no length. */
														{
															header("Content-Length: 0") . exit ();
														}
												}
										}
								}
							/**/
							else if ($serving && $req["file_download"]) /* We only need this section when/if we're actually serving. */
								status_header(503) . header ("Content-Type: text/html; charset=utf-8") . eval ('while (@ob_end_clean ());') #
								. exit (_x ('<strong>503: Access denied.</strong> Invalid File Download specs.', "s2member-front", "s2member"));
							/**/
							else if ($creating) /* We only need this section when/if we're creating a URL. */
								return false;
						/**/
						do_action ("ws_plugin__s2member_after_file_download_access", get_defined_vars ());
						/**/
						return ($creating) ? false : null; /* If creating, false. */
					}
				/**
				* Generates a File Download URL for access to a file protected by s2Member.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @param array $config Required. This is an array of configuration options associated with permissions being checked against the current User/Member; and also the actual URL generated by this routine.
				* 	Possible ``$config`` array elements: `file_download` *(required)*, `file_download_key`, `file_stream`, `file_inline`, `file_storage`, `file_remote`, `file_ssl`, `file_rewrite`, `file_rewrite_base`, `skip_confirmation`, `url_to_storage_source`, `count_against_user`, `check_user`.
				* @param bool $get_streamer_array Optional. Defaults to `false`. If `true`, this function will return an array with the following elements: `streamer`, `file`, `url`. For further details, please review this section in your Dashboard: `s2Member -> Download Options -> JW Player® & RTMP Protocol Examples`.
				* @return str A File Download URL string on success; or an array on success, with elements `streamer`, `file`, `url` when/if ``$get_streamer_array`` is true; else false on any type of failure.
				*
				* @see s2Member\API_Functions\s2member_file_download_url()
				*/
				public static function create_file_download_url ($config = FALSE, $get_streamer_array = FALSE)
					{
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_create_file_download_url", get_defined_vars ()); /* Be VERY careful, if you use this Hook. */
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$config = (is_array ($config)) ? $config : array (); /* This absolutely MUST be an array. */
						/**/
						$config["file_download"] = (isset ($config["file_download"]) && is_string ($config["file_download"])) ? trim ($config["file_download"], "/") : @$config["file_download"];
						$config["file_download_key"] = (isset ($config["file_download"]) && is_string ($config["file_download"]) && !empty ($config["file_download_key"])) ? c_ws_plugin__s2member_files::file_download_key ($config["file_download"], ((in_array ($config["file_download_key"], array ("ip-forever", "universal", "cache-compatible"))) ? $config["file_download_key"] : false)) : @$config["file_download_key"];
						/**/
						$config["url_to_storage_source"] = /* Force a streaming URL here via ``$get_streamer_array``? */ ($get_streamer_array) ? true : @$config["url_to_storage_source"];
						$config["file_stream"] = /* Force a streaming URL here via ``$get_streamer_array``? */ ($get_streamer_array) ? true : @$config["file_stream"];
						/**/
						if (($_url = c_ws_plugin__s2member_files_in::check_file_download_access (($create_file_download_url = $config))) /* Successfully created a URL to the file? */)
							{
								eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_create_file_download_url", get_defined_vars ()); /* Be VERY careful, if you use this Hook. */
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								$extension = strtolower (substr ($config["file_download"], strrpos ($config["file_download"], ".") + 1));
								$streaming = (isset ($config["file_stream"])) ? filter_var ($config["file_stream"], FILTER_VALIDATE_BOOLEAN) : ((in_array ($extension, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_stream_extensions"]))) ? true : false);
								$ssl = (isset ($config["file_ssl"])) ? filter_var ($config["file_ssl"], FILTER_VALIDATE_BOOLEAN) : ((is_ssl ()) ? true : false);
								/**/
								if ($get_streamer_array && $streaming && ($cfx = "/cfx/st") && ($cfx_pos = strpos ($_url, $cfx)) !== false && ($streamer = substr ($_url, 0, $cfx_pos + strlen ($cfx))) && ($url = c_ws_plugin__s2member_files_in::check_file_download_access (array_merge ($config, array ("file_stream" => false, "check_user" => false)))))
									$return = array ("streamer" => $streamer, "file" => preg_replace ("/^" . preg_quote ($streamer, "/") . "\//", "", $_url), "url" => preg_replace ("/^.+?\:/", (($ssl) ? "https:" : "http:"), $url));
								/**/
								else if ($get_streamer_array && $streaming && is_array ($ups = @parse_url ($_url)) && ($streamer = $ups["scheme"] . "://" . $ups["host"] . ((!empty ($ups["port"])) ? ":" . $ups["port"] : "")) && ($url = c_ws_plugin__s2member_files_in::check_file_download_access (array_merge ($config, array ("file_stream" => false, "check_user" => false)))))
									$return = array ("streamer" => $streamer, "file" => preg_replace ("/^" . preg_quote ($streamer, "/") . "\//", "", $_url), "url" => preg_replace ("/^.+?\:/", (($ssl) ? "https:" : "http:"), $url));
								/**/
								else if ($get_streamer_array) /* Else, we MUST return false here, unable to acquire streamer/file. */
									$return = false; /* We MUST return false here, unable to acquire streamer. */
								/**/
								else /* Else return URL string ( ``$get_streamer_array`` is false ). */
									$return = $_url; /* Else return URL string. */
							}
						/**/
						return apply_filters ("ws_plugin__s2member_create_file_download_url", ((isset ($return)) ? $return : false), get_defined_vars ());
					}
				/**
				* Checks Header Authorization for Remote File Downloads.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @attaches-to: ``add_filter("ws_plugin__s2member_check_file_download_access_user");``
				*
				* @param obj $user Expects a WP_User object passed in by the Filter.
				* @return obj A `WP_User` object, possibly obtained through Header Authorization.
				*/
				public static function check_file_remote_authorization ($user = FALSE)
					{
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_check_file_remote_authorization", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$_g = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep (((!empty ($_GET)) ? $_GET : array ())));
						/**/
						if (!is_object ($user) && isset ($_g["s2member_file_remote"]) && filter_var ($_g["s2member_file_remote"], FILTER_VALIDATE_BOOLEAN))
							{
								do_action ("ws_plugin__s2member_during_check_file_remote_authorization_before", get_defined_vars ());
								/**/
								if (empty ($_SERVER["PHP_AUTH_USER"]) || empty ($_SERVER["PHP_AUTH_PW"]) || !user_pass_ok ($_SERVER["PHP_AUTH_USER"], $_SERVER["PHP_AUTH_PW"]))
									{
										header('WWW-Authenticate: Basic realm="' . c_ws_plugin__s2member_utils_strings::esc_dq (strip_tags (_x ("Members Only", "s2member-front", "s2member"))) . '"');
										/**/
										status_header(401); /* Send an unauthorized 401 status header now. */
										header("Content-Type: text/html; charset=utf-8"); /* Content-Type with UTF-8. */
										eval('while (@ob_end_clean ());'); /* End/clean any output buffers that may exist. */
										/**/
										exit(_x ('<strong>401:</strong> Sorry, access denied.', "s2member-front", "s2member"));
									}
								else if (is_object ($_user = new WP_User ($_SERVER["PHP_AUTH_USER"])) && !empty ($_user->ID))
									$user = $_user; /* Now assign ``$user``. */
								/**/
								do_action ("ws_plugin__s2member_during_check_file_remote_authorization_after", get_defined_vars ());
							}
						/**/
						return apply_filters ("ws_plugin__s2member_check_file_remote_authorization", $user, get_defined_vars ());
					}
				/**
				* Checks a File Download Key for validity.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @param str $file Input File Download to validate.
				* @param str $key Input File Download Key to validate.
				* @return bool True if valid, else false.
				*/
				public static function check_file_download_key ($file = FALSE, $key = FALSE)
					{
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_before_check_file_download_key", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($file && is_string ($file) && ($file = trim ($file, "/")) && $key && is_string ($key)) /* Requirements to properly validate. */
							{
								if ($key === c_ws_plugin__s2member_files::file_download_key ($file) || $key === c_ws_plugin__s2member_files::file_download_key ("/" . $file))
									$valid = true; /* File Download Key is valid. */
								else if ($key === c_ws_plugin__s2member_files::file_download_key ($file, "ip-forever") || $key === c_ws_plugin__s2member_files::file_download_key ("/" . $file, "ip-forever"))
									$valid = true; /* File Download Key is valid. */
								else if ($key === c_ws_plugin__s2member_files::file_download_key ($file, "universal") || $key === c_ws_plugin__s2member_files::file_download_key ("/" . $file, "universal"))
									$valid = true; /* File Download Key is valid. */
							}
						/**/
						return apply_filters ("ws_plugin__s2member_check_file_download_key", ((isset ($valid) && $valid) ? true : false), get_defined_vars ());
					}
				/**
				* Creates an Amazon® S3 HMAC-SHA1 signature.
				*
				* @package s2Member\Files
				* @since 110524RC
				*
				* @param str $string Input string/data, to be signed by this routine.
				* @return str An HMAC-SHA1 signature for Amazon® S3.
				*/
				public static function amazon_s3_sign ($string = FALSE)
					{
						$s3c["secret_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_secret_key"];
						/**/
						$s3_signature = str_pad (((strlen ($s3c["secret_key"]) > 64) ? pack ('H*', sha1 ($s3c["secret_key"])) : $s3c["secret_key"]), 64, chr (0x00));
						return pack ('H*', sha1 (($s3_signature ^ str_repeat (chr (0x5c), 64)) . pack ('H*', sha1 (($s3_signature ^ str_repeat (chr (0x36), 64)) . (string)$string))));
					}
				/**
				* Creates an Amazon® S3 HMAC-SHA1 signature URL.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @param str $file Input file path, to be signed by this routine.
				* @param bool $stream Is this resource file to be served as streaming media?
				* @param bool $inline Is this resource file to be served inline, or no?
				* @param bool $ssl Is this resource file to be served via SSL, or no?
				* @param str $basename The absolute basename of the resource file.
				* @param str $mimetype The MIME content-type of the resource file.
				* @return str An HMAC-SHA1 signature URL for Amazon® S3.
				*/
				public static function amazon_s3_url ($file = FALSE, $stream = FALSE, $inline = FALSE, $ssl = FALSE, $basename = FALSE, $mimetype = FALSE)
					{
						$file = trim ((string)$file, "/"); /* Trim / force string. */
						/**/
						foreach ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"] as $option => $option_value)
							if (preg_match ("/^amazon_s3_files_/", $option) && ($option = preg_replace ("/^amazon_s3_files_/", "", $option)))
								$s3c[$option] = $option_value;
						/**/
						$s3c["expires"] = strtotime ("+" . apply_filters ("ws_plugin__s2member_amazon_s3_file_expires_time", "30 seconds", get_defined_vars ()));
						/**/
						$s3_file = add_query_arg (urlencode_deep (array ("response-cache-control" => ($s3_cache_control = "no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0"), "response-content-disposition" => ($s3_content_disposition = (((bool)$inline) ? "inline" : "attachment") . '; filename="' . (string)$basename . '"'), "response-content-type" => ($s3_content_type = (string)$mimetype), "response-expires" => ($s3_expires = gmdate ("D, d M Y H:i:s", strtotime ("-1 week")) . " GMT"))), "/" . $file);
						$s3_raw_file = add_query_arg (array ("response-cache-control" => $s3_cache_control, "response-content-disposition" => $s3_content_disposition, "response-content-type" => $s3_content_type, "response-expires" => $s3_expires), "/" . $file);
						$s3_signature = base64_encode (c_ws_plugin__s2member_files_in::amazon_s3_sign ("GET\n\n\n" . $s3c["expires"] . "\n" . "/" . $s3c["bucket"] . $s3_raw_file));
						/**/
						$s3_url = ((strtolower ($s3c["bucket"]) !== $s3c["bucket"])) ? "http" . (($ssl) ? "s" : "") . "://s3.amazonaws.com/" . $s3c["bucket"] . $s3_file : "http" . (($ssl) ? "s" : "") . "://" . $s3c["bucket"] . ".s3.amazonaws.com" . $s3_file;
						return add_query_arg (urlencode_deep (array ("AWSAccessKeyId" => $s3c["access_key"], "Expires" => $s3c["expires"], "Signature" => $s3_signature)), $s3_url);
					}
				/**
				* Auto-configures an Amazon® S3 Bucket's ACLs.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @return array Array containing a true `success` element on success, else a failure array.
				* 	Failure array will contain a failure `code`, and a failure `message`.
				*/
				public static function amazon_s3_auto_configure_acls ()
					{
						foreach ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"] as $option => $option_value)
							if (preg_match ("/^amazon_s3_files_/", $option) && ($option = preg_replace ("/^amazon_s3_files_/", "", $option)))
								$s3c[$option] = $option_value;
						/**/
						$cfc["distros_s3_access_id"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_cf_files_distros_s3_access_id"];
						/**/
						if ($s3c["bucket"] && $s3c["access_key"] && $s3c["secret_key"]) /* Must have Amazon® S3 Bucket/Keys. */
							{
								$s3_date = gmdate ("D, d M Y H:i:s") . " GMT";
								$s3_location = ((strtolower ($s3c["bucket"]) !== $s3c["bucket"])) ? "/" . $s3c["bucket"] . "/?acl" : "/?acl";
								$s3_domain = ((strtolower ($s3c["bucket"]) !== $s3c["bucket"])) ? "s3.amazonaws.com" : $s3c["bucket"] . ".s3.amazonaws.com";
								$s3_signature = base64_encode (c_ws_plugin__s2member_files_in::amazon_s3_sign ("GET\n\n\n" . $s3_date . "\n/" . $s3c["bucket"] . "/?acl"));
								$s3_args = array ("method" => "GET", "headers" => array ("Host" => $s3_domain, "Date" => $s3_date, "Authorization" => "AWS " . $s3c["access_key"] . ":" . $s3_signature));
								/**/
								if (($s3_response = c_ws_plugin__s2member_utils_urls::remote ("https://" . $s3_domain . $s3_location, false, array_merge ($s3_args, array ("timeout" => 20)), "array")) && $s3_response["code"] === 200)
									{
										if (preg_match ("/\<Owner\>(.+?)\<\/Owner\>/is", $s3_response["body"], $s3_owner_tag) && preg_match ("/\<ID\>(.+?)\<\/ID\>/is", $s3_owner_tag[1], $s3_owner_id_tag) && (preg_match ("/\<DisplayName\>(.*?)\<\/DisplayName\>/is", $s3_owner_tag[1], $s3_owner_display_name_tag) || ($s3_owner_display_name_tag = array ("-", "Owner"))))
											{
												$s3_owner = array ("access_id" => trim ($s3_owner_id_tag[1]), "display_name" => trim ($s3_owner_display_name_tag[1]));
												$s3_acls_xml = '<AccessControlPolicy><Owner><ID>' . esc_html ($s3_owner["access_id"]) . '</ID><DisplayName>' . esc_html ($s3_owner["display_name"]) . '</DisplayName></Owner><AccessControlList><Grant><Grantee xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="CanonicalUser"><ID>' . esc_html ($s3_owner["access_id"]) . '</ID><DisplayName>' . esc_html ($s3_owner["display_name"]) . '</DisplayName></Grantee><Permission>FULL_CONTROL</Permission></Grant>' . (($cfc["distros_s3_access_id"]) ? '<Grant><Grantee xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="CanonicalUser"><ID>' . esc_html ($cfc["distros_s3_access_id"]) . '</ID><DisplayName>s2Member/CloudFront</DisplayName></Grantee><Permission>READ</Permission></Grant>' : '') . '</AccessControlList></AccessControlPolicy>';
												$s3_signature = base64_encode (c_ws_plugin__s2member_files_in::amazon_s3_sign ("PUT\n\napplication/xml\n" . $s3_date . "\n/" . $s3c["bucket"] . "/?acl"));
												$s3_args = array ("method" => "PUT", "body" => $s3_acls_xml, "headers" => array ("Host" => $s3_domain, "Content-Type" => "application/xml", "Date" => $s3_date, "Authorization" => "AWS " . $s3c["access_key"] . ":" . $s3_signature));
												/**/
												if (($s3_response = c_ws_plugin__s2member_utils_urls::remote ("https://" . $s3_domain . $s3_location, false, array_merge ($s3_args, array ("timeout" => 20)), "array")) && $s3_response["code"] === 200)
													{
														$s3_location = ((strtolower ($s3c["bucket"]) !== $s3c["bucket"])) ? "/" . $s3c["bucket"] . "/?policy" : "/?policy";
														$s3_policy_json = '{"Version":"2008-10-17","Id":"' . md5 ("s2Member/CloudFront") . '","Statement":[{"Sid":"s2Member/CloudFront","Effect":"Allow","Principal":{"CanonicalUser":"' . c_ws_plugin__s2member_utils_strings::esc_dq ($cfc["distros_s3_access_id"]) . '"},"Action":"s3:GetObject","Resource":"arn:aws:s3:::' . c_ws_plugin__s2member_utils_strings::esc_dq ($s3c["bucket"]) . '/*"}]}';
														$s3_signature = base64_encode (c_ws_plugin__s2member_files_in::amazon_s3_sign ("PUT\n\napplication/json\n" . $s3_date . "\n/" . $s3c["bucket"] . "/?policy"));
														$s3_args = array ("method" => "PUT", "body" => $s3_policy_json, "headers" => array ("Host" => $s3_domain, "Content-Type" => "application/json", "Date" => $s3_date, "Authorization" => "AWS " . $s3c["access_key"] . ":" . $s3_signature));
														/**/
														if (!$cfc["distros_s3_access_id"] || (($s3_response = c_ws_plugin__s2member_utils_urls::remote ("https://" . $s3_domain . $s3_location, false, array_merge ($s3_args, array ("timeout" => 20)), "array")) && ($s3_response["code"] === 200 || $s3_response["code"] === 204 /* Also OK. */)))
															{
																$s3_location = ((strtolower ($s3c["bucket"]) !== $s3c["bucket"])) ? "/" . $s3c["bucket"] . "/crossdomain.xml" : "/crossdomain.xml";
																$s3_policy_xml = trim (c_ws_plugin__s2member_utilities::evl (file_get_contents (dirname (dirname (__FILE__)) . "/templates/cfg-files/s2-cross-xml.php")));
																$s3_signature = base64_encode (c_ws_plugin__s2member_files_in::amazon_s3_sign ("PUT\n\ntext/xml\n" . $s3_date . "\nx-amz-acl:public-read\n/" . $s3c["bucket"] . "/crossdomain.xml"));
																$s3_args = array ("method" => "PUT", "body" => $s3_policy_xml, "headers" => array ("Host" => $s3_domain, "Content-Type" => "text/xml", "Date" => $s3_date, "X-Amz-Acl" => "public-read", "Authorization" => "AWS " . $s3c["access_key"] . ":" . $s3_signature));
																/**/
																if (($s3_response = c_ws_plugin__s2member_utils_urls::remote ("https://" . $s3_domain . $s3_location, false, array_merge ($s3_args, array ("timeout" => 20)), "array")) && $s3_response["code"] === 200)
																	return array ("success" => true, "code" => null, "message" => null); /* Successfully configured Amazon® S3 Bucket ACLs and Policy. */
																/**/
																else if (isset ($s3_response["code"], $s3_response["message"]))
																	/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® S3 API call. Feel free to exclude `%s` if you like. */
																	return array ("success" => false, "code" => $s3_response["code"], "message" => sprintf (_x ("Unable to update existing Amazon® S3 Cross-Domain Policy. %s", "s2member-admin", "s2member"), $s3_response["message"]));
																/**/
																else /* Else, we use a default error code and message. */
																	return array ("success" => false, "code" => -94, "message" => _x ("Unable to update existing Amazon® S3 Cross-Domain Policy. Connection failed.", "s2member-admin", "s2member"));
															}
														else if (isset ($s3_response["code"], $s3_response["message"]))
															/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® S3 API call. Feel free to exclude `%s` if you like. */
															return array ("success" => false, "code" => $s3_response["code"], "message" => sprintf (_x ("Unable to update existing Amazon® S3 Bucket Policy. %s", "s2member-admin", "s2member"), $s3_response["message"]));
														/**/
														else /* Else, we use a default error code and message. */
															return array ("success" => false, "code" => -95, "message" => _x ("Unable to update existing Amazon® S3 Bucket Policy. Connection failed.", "s2member-admin", "s2member"));
													}
												else if (isset ($s3_response["code"], $s3_response["message"]))
													/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® S3 API call. Feel free to exclude `%s` if you like. */
													return array ("success" => false, "code" => $s3_response["code"], "message" => sprintf (_x ("Unable to update existing Amazon® S3 Bucket ACLs. %s", "s2member-admin", "s2member"), $s3_response["message"]));
												/**/
												else /* Else, we use a default error code and message. */
													return array ("success" => false, "code" => -96, "message" => _x ("Unable to update existing Amazon® S3 Bucket ACLs. Connection failed.", "s2member-admin", "s2member"));
											}
										else /* Else, we use a default error code and message. */
											return array ("success" => false, "code" => -97, "message" => _x ("Unable to acquire/read existing Amazon® S3 Bucket ACLs. Unexpected response.", "s2member-admin", "s2member"));
									}
								else if (isset ($s3_response["code"], $s3_response["message"]))
									/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® S3 API call. Feel free to exclude `%s` if you like. */
									return array ("success" => false, "code" => $s3_response["code"], "message" => sprintf (_x ("Unable to acquire existing Amazon® S3 Bucket ACLs. %s", "s2member-admin", "s2member"), $s3_response["message"]));
								/**/
								else /* Else, we use a default error code and message. */
									return array ("success" => false, "code" => -98, "message" => _x ("Unable to acquire existing Amazon® S3 Bucket ACLs. Connection failed.", "s2member-admin", "s2member"));
							}
						else /* Else, we use a default error code and message. */
							return array ("success" => false, "code" => -99, "message" => _x ("Unable to auto-configure existing Amazon® S3 Bucket ACLs. Incomplete Amazon® S3 configuration options. Missing one of: Amazon® S3 Bucket, Access Key, or Secret Key.", "s2member-admin", "s2member"));
					}
				/**
				* Creates an Amazon® CloudFront HMAC-SHA1 signature.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @param str $string Input string/data, to be signed by this routine.
				* @return str An HMAC-SHA1 signature for Amazon® CloudFront.
				*/
				public static function amazon_cf_sign ($string = FALSE)
					{
						$cfc["secret_key"] = $s3c["secret_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_secret_key"];
						/**/
						$cf_signature = str_pad (((strlen ($cfc["secret_key"]) > 64) ? pack ('H*', sha1 ($cfc["secret_key"])) : $cfc["secret_key"]), 64, chr (0x00));
						return pack ('H*', sha1 (($cf_signature ^ str_repeat (chr (0x5c), 64)) . pack ('H*', sha1 (($cf_signature ^ str_repeat (chr (0x36), 64)) . (string)$string))));
					}
				/**
				* Creates an Amazon® CloudFront RSA-SHA1 signature.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @param str $string Input string/data, to be signed by this routine.
				* @return str|bool An RSA-SHA1 signature for Amazon® CloudFront, else false on failure.
				*/
				public static function amazon_cf_rsa_sign ($string = FALSE)
					{
						$cfc["private_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_cf_files_private_key"];
						/**/
						if (stripos (PHP_SAPI, "apache") !== false) /* PHP is running as an Apache module? */
							if ( /* Some `mod_php` installs have issues with OpenSSL version conflicts. See: <http://www.apachelounge.com/viewtopic.php?t=4180>. */
							($signature = c_ws_plugin__s2member_files_in::amazon_cf_rsa_shell_sign ($string)) /* Also try some other OpenSSL locations on Windows®. */
							|| (stripos (PHP_OS, "win") === 0 && ($signature = c_ws_plugin__s2member_files_in::amazon_cf_rsa_shell_sign ($string, "C:\openssl-win32\bin\openssl.exe"))) #
							|| (stripos (PHP_OS, "win") === 0 && ($signature = c_ws_plugin__s2member_files_in::amazon_cf_rsa_shell_sign ($string, "C:\openssl-win64\bin\openssl.exe"))))
								return $signature;
						/**/
						if (function_exists ("openssl_get_privatekey") && function_exists ("openssl_sign") && is_resource ($private_key = openssl_get_privatekey ($cfc["private_key"])))
							openssl_sign ((string)$string, $signature, $private_key, OPENSSL_ALGO_SHA1) . openssl_free_key ($private_key);
						/**/
						else if (function_exists ("shell_exec")) /* Last ditch effort here. */
							$signature = c_ws_plugin__s2member_files_in::amazon_cf_rsa_shell_sign ($string);
						/**/
						return (!empty ($signature)) ? $signature : false;
					}
				/**
				* Creates an Amazon® CloudFront RSA-SHA1 signature via ``shell_exec()`` to `openssl`.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @param str $string Input string/data, to be signed by this routine.
				* @param str $openssl Optional. A specific absolute path to OpenSSL application.
				* @return str|bool An RSA-SHA1 signature for Amazon® CloudFront, else false on failure.
				*/
				public static function amazon_cf_rsa_shell_sign ($string = FALSE, $openssl = FALSE)
					{
						$cfc["private_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_cf_files_private_key"];
						/**/
						if (function_exists ("shell_exec") && ($openssl = (($openssl && is_string ($openssl)) ? $openssl : "openssl")) && ($esa = "escapeshellarg"))
							{
								file_put_contents (($cf_string_file = get_temp_dir () . wp_unique_filename (get_temp_dir (), md5 (time () . "cf-string") . ".tmp")), (string)$string);
								file_put_contents (($cf_private_key_file = get_temp_dir () . wp_unique_filename (get_temp_dir (), md5 (time () . "cf-private-key") . ".tmp")), $cfc["private_key"]);
								file_put_contents (($cf_rsa_sha1_sig_file = get_temp_dir () . wp_unique_filename (get_temp_dir (), md5 (time () . "cf-rsa-sha1-signature-file") . ".tmp")), "");
								/**/
								@shell_exec($esa ($openssl) . " sha1 -sign " . $esa ($cf_private_key_file) . " -out " . $esa ($cf_rsa_sha1_sig_file) . " " . $esa ($cf_string_file));
								$signature = trim (file_get_contents ($cf_rsa_sha1_sig_file)); /* Now try to obtain signature file contents. */
								unlink($cf_rsa_sha1_sig_file) . unlink ($cf_private_key_file) . unlink ($cf_string_file); /* Cleanup. */
							}
						/**/
						return (!empty ($signature)) ? $signature : false;
					}
				/**
				* Creates an Amazon® CloudFront RSA-SHA1 signature URL.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @param str $file Input file path, to be signed by this routine.
				* @param bool $stream Is this resource file to be served as streaming media?
				* @param bool $inline Is this resource file to be served inline, or no?
				* @param bool $ssl Is this resource file to be served via SSL, or no?
				* @param str $basename The absolute basename of the resource file.
				* @param str $mimetype The MIME content-type of the resource file.
				* @return str An RSA-SHA1 signature URL for Amazon® CloudFront.
				*/
				public static function amazon_cf_url ($file = FALSE, $stream = FALSE, $inline = FALSE, $ssl = FALSE, $basename = FALSE, $mimetype = FALSE)
					{
						$file = trim ((string)$file, "/"); /* Trim / force string. */
						/**/
						foreach ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"] as $option => $option_value)
							if (preg_match ("/^amazon_cf_files_/", $option) && ($option = preg_replace ("/^amazon_cf_files_/", "", $option)))
								$cfc[$option] = $option_value;
						/**/
						$cfc["expires"] = strtotime ("+" . apply_filters ("ws_plugin__s2member_amazon_cf_file_expires_time", "24 hours", get_defined_vars ()));
						/**/
						$cf_extn = strtolower (substr ($file, strrpos ($file, ".") + 1)); /* Parses the file extension out so we can scan it in some special scenarios. */
						$cf_stream_extn_resource_exclusions = array_unique ((array)apply_filters ("ws_plugin__s2member_amazon_cf_file_streaming_extension_resource_exclusions", array ("mp3" /* MP3 files should NOT include an extension in their resource reference. */), get_defined_vars ()));
						$cf_resource = ($stream) ? ((in_array ($cf_extn, $cf_stream_extn_resource_exclusions)) ? substr ($file, 0, strrpos ($file, ".")) : $file) : "http" . (($ssl) ? "s" : "") . "://" . (($cfc["distro_downloads_cname"]) ? $cfc["distro_downloads_cname"] : $cfc["distro_downloads_dname"]) . "/" . $file;
						$cf_url = ($stream) ? "rtmp" . (($ssl) ? "e" : "") . "://" . (($cfc["distro_streaming_cname"]) ? $cfc["distro_streaming_cname"] : $cfc["distro_streaming_dname"]) . "/cfx/st/" . $file : "http" . (($ssl) ? "s" : "") . "://" . (($cfc["distro_downloads_cname"]) ? $cfc["distro_downloads_cname"] : $cfc["distro_downloads_dname"]) . "/" . $file;
						$cf_ip_res = (stripos ($_SERVER["HTTP_HOST"], "localhost") === false && strpos ($_SERVER["HTTP_HOST"], "127.0.0.1") === false && (!defined ("LOCALHOST") || !LOCALHOST)) ? true : false; /* Don NOT restrict access to a particular IP during `localhost` development. The IP will NOT be the same one Amazon® CloudFront sees ( so will NOT jive ). */
						$cf_policy = '{"Statement":[{"Resource":"' . c_ws_plugin__s2member_utils_strings::esc_dq ($cf_resource) . '","Condition":{' . (($cf_ip_res) ? '"IpAddress":{"AWS:SourceIp":"' . c_ws_plugin__s2member_utils_strings::esc_dq ($_SERVER["REMOTE_ADDR"]) . '/32"},' : '') . '"DateLessThan":{"AWS:EpochTime":' . (int)$cfc["expires"] . '}}}]}';
						/**/
						$cf_signature = c_ws_plugin__s2member_files_in::amazon_cf_rsa_sign ($cf_policy);
						$cf_base64_url_safe_policy = c_ws_plugin__s2member_utils_strings::base64_url_safe_encode ($cf_policy, array ("+", "=", "/"), array ("-", "_", "~"), false);
						$cf_base64_url_safe_signature = c_ws_plugin__s2member_utils_strings::base64_url_safe_encode ($cf_signature, array ("+", "=", "/"), array ("-", "_", "~"), false);
						/**/
						return add_query_arg (urlencode_deep (array ("Policy" => $cf_base64_url_safe_policy, "Signature" => $cf_base64_url_safe_signature, "Key-Pair-Id" => $cfc["private_key_id"])), $cf_url);
					}
				/**
				* Auto-configures Amazon® S3/CloudFront distros.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @return array Array containing a true `success` element on success, else a failure array.
				* 	Failure array will contain a failure `code`, and a failure `message`.
				*/
				public static function amazon_cf_auto_configure_distros ()
					{
						foreach ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"] as $option => $option_value)
							if (preg_match ("/^amazon_cf_files_/", $option) && ($option = preg_replace ("/^amazon_cf_files_/", "", $option)))
								$cfc[$option] = $option_value;
						/**/
						$s3c["bucket"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_bucket"];
						$cfc["access_key"] = $s3c["access_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_access_key"];
						$cfc["secret_key"] = $s3c["secret_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_secret_key"];
						/**/
						if ($s3c["bucket"] && $s3c["access_key"] && $s3c["secret_key"]) /* We MUST have an Amazon® S3 Bucket and Keys. */
							{
								if ($cfc["private_key"] && $cfc["private_key_id"]) /* We MUST have Amazon® CloudFront Keys in order to auto-configure. */
									{
										if (!$cfc["distro_downloads_id"] || ($cfc["distro_downloads_id"] && ($cf_get_response = c_ws_plugin__s2member_files_in::amazon_cf_get_distro ($cfc["distro_downloads_id"], "downloads")) && ($cf_get_response["success"] || $cf_get_response["code"] === 404)))
											{
												if (!$cfc["distro_downloads_id"] || ($cfc["distro_downloads_id"] && $cf_get_response && !$cf_get_response["success"] && $cf_get_response["code"] === 404))
													$cf_distro_downloads_clear = true; /* Clear, ready for a new one. */
												/**/
												else if ($cfc["distro_downloads_id"] && $cf_get_response && $cf_get_response["success"] && !$cf_get_response["deployed"])
													return array ("success" => false, "code" => -86, "message" => _x ("Unable to delete existing Amazon® CloudFront Downloads Distro. Still in a `pending` state. Please wait 15 minutes, then try again. There is a certain process that s2Member must strictly adhere to when re-configuring your Amazon® CloudFront Distros. You may have to tick the auto-configure checkbox again, and re-run s2Member's auto-configuration routine many times, because s2Member will likely run into several `pending` challenges, as it works to completely re-configure your Amazon® CloudFront Distros for you. Thanks for your patience. Please wait 15 minutes, then try again.", "s2member-admin", "s2member"));
												/**/
												else if ($cfc["distro_downloads_id"] && $cf_get_response && $cf_get_response["success"] && $cf_get_response["deployed"] && ($cf_del_response = c_ws_plugin__s2member_files_in::amazon_cf_del_distro ($cfc["distro_downloads_id"], $cf_get_response["etag"], $cf_get_response["xml"])) && $cf_del_response["success"])
													$cf_distro_downloads_clear = true; /* Clear, ready for a new one. */
												/**/
												else if (isset ($cf_del_response["code"], $cf_del_response["message"]))
													/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
													return array ("success" => false, "code" => $cf_del_response["code"], "message" => sprintf (_x ("Unable to delete existing Amazon® CloudFront Downloads Distro. %s", "s2member-admin", "s2member"), $cf_del_response["message"]));
												/**/
												if (isset ($cf_distro_downloads_clear) && $cf_distro_downloads_clear) /* Successfully cleared? Ready for a new one? */
													{
														unset ($cf_get_response, $cf_del_response); /* Unset these before processing additional routines. Prevents problems in error reporting. */
														/**/
														if (!$cfc["distro_streaming_id"] || ($cfc["distro_streaming_id"] && ($cf_get_response = c_ws_plugin__s2member_files_in::amazon_cf_get_distro ($cfc["distro_streaming_id"], "streaming")) && ($cf_get_response["success"] || $cf_get_response["code"] === 404)))
															{
																if (!$cfc["distro_streaming_id"] || ($cfc["distro_streaming_id"] && $cf_get_response && !$cf_get_response["success"] && $cf_get_response["code"] === 404))
																	$cf_distro_streaming_clear = true; /* Clear, ready for a new one. */
																/**/
																else if ($cfc["distro_streaming_id"] && $cf_get_response && $cf_get_response["success"] && !$cf_get_response["deployed"])
																	return array ("success" => false, "code" => -87, "message" => _x ("Unable to delete existing Amazon® CloudFront Streaming Distro. Still in a `pending` state. Please wait 15 minutes, then try again. There is a certain process that s2Member must strictly adhere to when re-configuring your Amazon® CloudFront Distros. You may have to tick the auto-configure checkbox again, and re-run s2Member's auto-configuration routine many times, because s2Member will likely run into several `pending` challenges, as it works to completely re-configure your Amazon® CloudFront Distros for you. Thanks for your patience. Please wait 15 minutes, then try again.", "s2member-admin", "s2member"));
																/**/
																else if ($cfc["distro_streaming_id"] && $cf_get_response && $cf_get_response["success"] && $cf_get_response["deployed"] && ($cf_del_response = c_ws_plugin__s2member_files_in::amazon_cf_del_distro ($cfc["distro_streaming_id"], $cf_get_response["etag"], $cf_get_response["xml"])) && $cf_del_response["success"])
																	$cf_distro_streaming_clear = true; /* Clear, ready for a new one. */
																/**/
																else if (isset ($cf_del_response["code"], $cf_del_response["message"]))
																	/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
																	return array ("success" => false, "code" => $cf_del_response["code"], "message" => sprintf (_x ("Unable to delete existing Amazon® CloudFront Streaming Distro. %s", "s2member-admin", "s2member"), $cf_del_response["message"]));
																/**/
																if (isset ($cf_distro_streaming_clear) && $cf_distro_streaming_clear) /* Successfully cleared? Ready for a new one? */
																	{
																		unset ($cf_get_response, $cf_del_response); /* Unset these before processing additional routines. Prevents problems in error reporting. */
																		/**/
																		if (!$cfc["distros_access_id"] || ($cfc["distros_access_id"] && ($cf_get_response = c_ws_plugin__s2member_files_in::amazon_cf_get_access_origin_identity ($cfc["distros_access_id"])) && ($cf_get_response["success"] || $cf_get_response["code"] === 404)))
																			{
																				if (!$cfc["distros_access_id"] || ($cfc["distros_access_id"] && $cf_get_response && !$cf_get_response["success"] && $cf_get_response["code"] === 404))
																					$cf_distros_access_clear = true; /* Clear, ready for a new one. */
																				/**/
																				else if ($cfc["distros_access_id"] && $cf_get_response && $cf_get_response["success"] && ($cf_del_response = c_ws_plugin__s2member_files_in::amazon_cf_del_access_origin_identity ($cfc["distros_access_id"], $cf_get_response["etag"], $cf_get_response["xml"])) && $cf_del_response["success"])
																					$cf_distros_access_clear = true; /* Clear, ready for a new one. */
																				/**/
																				else if (isset ($cf_del_response["code"], $cf_del_response["message"]))
																					/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
																					return array ("success" => false, "code" => $cf_del_response["code"], "message" => sprintf (_x ("Unable to delete existing Amazon® CloudFront Origin Access Identity. %s", "s2member-admin", "s2member"), $cf_del_response["message"]));
																				/**/
																				if (isset ($cf_distros_access_clear) && $cf_distros_access_clear) /* Successfully cleared? Ready for a new one? */
																					{
																						unset ($cf_get_response, $cf_del_response); /* Unset these before processing additional routines. Prevents problems in error reporting. */
																						/**/
																						$cfc = array_merge ($cfc, array ("distros_access_id" => "", "distros_s3_access_id" => "", "distro_downloads_id" => "", "distro_downloads_dname" => "", "distro_streaming_id" => "", "distro_streaming_dname" => "", "distros_auto_config_status" => ""));
																						$cf_options = array ("ws_plugin__s2member_amazon_cf_files_distros_access_id" => "", "ws_plugin__s2member_amazon_cf_files_distros_s3_access_id" => "", "ws_plugin__s2member_amazon_cf_files_distro_downloads_id" => "", "ws_plugin__s2member_amazon_cf_files_distro_downloads_dname" => "", "ws_plugin__s2member_amazon_cf_files_distro_streaming_id" => "", "ws_plugin__s2member_amazon_cf_files_distro_streaming_dname" => "", "ws_plugin__s2member_amazon_cf_files_distros_auto_config_status" => "");
																						c_ws_plugin__s2member_menu_pages::update_all_options ($cf_options, true, false, false, false, false);
																						/**/
																						if (($cf_response = c_ws_plugin__s2member_files_in::amazon_cf_create_distros_access_origin_identity ()) && $cf_response["success"])
																							{
																								$cfc = array_merge ($cfc, array ("distros_access_id" => $cf_response["distros_access_id"], "distros_s3_access_id" => $cf_response["distros_s3_access_id"]));
																								$cf_options = array ("ws_plugin__s2member_amazon_cf_files_distros_access_id" => $cf_response["distros_access_id"], "ws_plugin__s2member_amazon_cf_files_distros_s3_access_id" => $cf_response["distros_s3_access_id"]);
																								c_ws_plugin__s2member_menu_pages::update_all_options ($cf_options, true, false, false, false, false);
																								/**/
																								if (($cf_response = c_ws_plugin__s2member_files_in::amazon_cf_create_distro ("downloads")) && $cf_response["success"])
																									{
																										$cfc = array_merge ($cfc, array ("distro_downloads_id" => $cf_response["distro_downloads_id"], "distro_downloads_dname" => $cf_response["distro_downloads_dname"]));
																										$cf_options = array ("ws_plugin__s2member_amazon_cf_files_distro_downloads_id" => $cf_response["distro_downloads_id"], "ws_plugin__s2member_amazon_cf_files_distro_downloads_dname" => $cf_response["distro_downloads_dname"]);
																										c_ws_plugin__s2member_menu_pages::update_all_options ($cf_options, true, false, false, false, false);
																										/**/
																										if (($cf_response = c_ws_plugin__s2member_files_in::amazon_cf_create_distro ("streaming")) && $cf_response["success"])
																											{
																												$cfc = array_merge ($cfc, array ("distro_streaming_id" => $cf_response["distro_streaming_id"], "distro_streaming_dname" => $cf_response["distro_streaming_dname"]));
																												$cf_options = array ("ws_plugin__s2member_amazon_cf_files_distro_streaming_id" => $cf_response["distro_streaming_id"], "ws_plugin__s2member_amazon_cf_files_distro_streaming_dname" => $cf_response["distro_streaming_dname"]);
																												c_ws_plugin__s2member_menu_pages::update_all_options ($cf_options, true, false, false, false, false);
																												/**/
																												if (($s3_response = c_ws_plugin__s2member_files_in::amazon_s3_auto_configure_acls ()) && $s3_response["success"])
																													{
																														$cfc = array_merge ($cfc, array ("distros_auto_config_status" => "success"));
																														$cf_options = array ("ws_plugin__s2member_amazon_cf_files_distros_auto_config_status" => "configured");
																														c_ws_plugin__s2member_menu_pages::update_all_options ( /* Now configured! */$cf_options, true, false, false, false, false);
																														/**/
																														return array ("success" => true, "code" => null, "message" => null); /* Successfully configured Amazon® S3/CloudFront distros. */
																													}
																												/**/
																												else if (isset ($s3_response["code"], $s3_response["message"]))
																													/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® S3 API call. Feel free to exclude `%s` if you like. */
																													return array ("success" => false, "code" => $s3_response["code"], "message" => sprintf (_x ("Unable to update existing Amazon® S3 ACLs. %s", "s2member-admin", "s2member"), $s3_response["message"]));
																												/**/
																												else /* Else, we use a default error code and message. */
																													return array ("success" => false, "code" => -88, "message" => _x ("Unable to update existing Amazon® S3 ACLs. Connection failed.", "s2member-admin", "s2member"));
																											}
																										else if (isset ($cf_response["code"], $cf_response["message"]))
																											/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
																											return array ("success" => false, "code" => $cf_response["code"], "message" => sprintf (_x ("Unable to create Amazon® CloudFront Streaming Distro. %s", "s2member-admin", "s2member"), $cf_response["message"]));
																										/**/
																										else /* Else, we use a default error code and message. */
																											return array ("success" => false, "code" => -89, "message" => _x ("Unable to create Amazon® CloudFront Streaming Distro. Connection failed.", "s2member-admin", "s2member"));
																									}
																								else if (isset ($cf_response["code"], $cf_response["message"]))
																									/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
																									return array ("success" => false, "code" => $cf_response["code"], "message" => sprintf (_x ("Unable to create Amazon® CloudFront Downloads Distro. %s", "s2member-admin", "s2member"), $cf_response["message"]));
																								/**/
																								else /* Else, we use a default error code and message. */
																									return array ("success" => false, "code" => -90, "message" => _x ("Unable to create Amazon® CloudFront Downloads Distro. Connection failed.", "s2member-admin", "s2member"));
																							}
																						else if (isset ($cf_response["code"], $cf_response["message"]))
																							/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
																							return array ("success" => false, "code" => $cf_response["code"], "message" => sprintf (_x ("Unable to create Amazon® CloudFront Origin Access Identity. %s", "s2member-admin", "s2member"), $cf_response["message"]));
																						/**/
																						else /* Else, we use a default error code and message. */
																							return array ("success" => false, "code" => -91, "message" => _x ("Unable to create Amazon® CloudFront Origin Access Identity. Connection failed.", "s2member-admin", "s2member"));
																					}
																				else /* Else, we use a default error code and message. */
																					return array ("success" => false, "code" => -92, "message" => _x ("Unable to clear existing Amazon® CloudFront Origin Access Identity.", "s2member-admin", "s2member"));
																			}
																		else if (isset ($cf_get_response["code"], $cf_get_response["message"]))
																			/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
																			return array ("success" => false, "code" => $cf_get_response["code"], "message" => sprintf (_x ("Unable to acquire existing Amazon® CloudFront Origin Access Identity. %s", "s2member-admin", "s2member"), $cf_get_response["message"]));
																		/**/
																		else /* Else, we use a default error code and message. */
																			return array ("success" => false, "code" => -93, "message" => _x ("Unable to acquire existing Amazon® CloudFront Origin Access Identity. Connection failed.", "s2member-admin", "s2member"));
																	}
																else /* Else, we use a default error code and message. */
																	return array ("success" => false, "code" => -94, "message" => _x ("Unable to clear existing Amazon® CloudFront Streaming Distro.", "s2member-admin", "s2member"));
															}
														else if (isset ($cf_get_response["code"], $cf_get_response["message"]))
															/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
															return array ("success" => false, "code" => $cf_get_response["code"], "message" => sprintf (_x ("Unable to acquire existing Amazon® CloudFront Streaming Distro. %s", "s2member-admin", "s2member"), $cf_get_response["message"]));
														/**/
														else /* Else, we use a default error code and message. */
															return array ("success" => false, "code" => -95, "message" => _x ("Unable to acquire existing Amazon® CloudFront Streaming Distro. Connection failed.", "s2member-admin", "s2member"));
													}
												else /* Else, we use a default error code and message. */
													return array ("success" => false, "code" => -96, "message" => _x ("Unable to clear existing Amazon® CloudFront Downloads Distro.", "s2member-admin", "s2member"));
											}
										else if (isset ($cf_get_response["code"], $cf_get_response["message"]))
											/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
											return array ("success" => false, "code" => $cf_get_response["code"], "message" => sprintf (_x ("Unable to acquire existing Amazon® CloudFront Downloads Distro. %s", "s2member-admin", "s2member"), $cf_get_response["message"]));
										/**/
										else /* Else, we use a default error code and message. */
											return array ("success" => false, "code" => -97, "message" => _x ("Unable to acquire existing Amazon® CloudFront Downloads Distro. Connection failed.", "s2member-admin", "s2member"));
									}
								else /* Else, we use a default error code and message. */
									return array ("success" => false, "code" => -98, "message" => _x ("Unable to auto-configure Amazon® CloudFront Distros. Incomplete Amazon® CloudFront configuration options. Missing of one: Amazon® CloudFront Private Key-Pair-ID, or Private Key file contents.", "s2member-admin", "s2member"));
							}
						else /* Else, we use a default error code and message. */
							return array ("success" => false, "code" => -99, "message" => _x ("Unable to auto-configure Amazon® S3/CloudFront Distros. Incomplete Amazon® S3 configuration options. Missing one of: Amazon® S3 Bucket, Access Key, or Secret Key. You must provide s2Member with an Amazon® S3 configuration before enabling CloudFront.", "s2member-admin", "s2member"));
					}
				/**
				* Acquires an Amazon® S3/CloudFront Access Origin Identity.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @param str $access_id Required. An Origin Access ID.
				* @return array Array containing a true `success` and `etag`, `xml` elements on success, else a failure array.
				* 	Failure array will contain a failure `code`, and a failure `message`.
				*/
				public static function amazon_cf_get_access_origin_identity ($access_id = FALSE)
					{
						if ($access_id && is_string ($access_id)) /* Valid parameters? */
							{
								foreach ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"] as $option => $option_value)
									if (preg_match ("/^amazon_cf_files_/", $option) && ($option = preg_replace ("/^amazon_cf_files_/", "", $option)))
										$cfc[$option] = $option_value;
								/**/
								$s3c["bucket"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_bucket"];
								$cfc["access_key"] = $s3c["access_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_access_key"];
								$cfc["secret_key"] = $s3c["secret_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_secret_key"];
								/**/
								$cf_domain = "cloudfront.amazonaws.com";
								$cf_date = gmdate ("D, d M Y H:i:s") . " GMT";
								$cf_location = "/2010-11-01/origin-access-identity/cloudfront/" . $access_id;
								$cf_signature = base64_encode (c_ws_plugin__s2member_files_in::amazon_cf_sign ($cf_date));
								$cf_args = array ("method" => "GET", "headers" => array ("Host" => $cf_domain, "Date" => $cf_date, "Authorization" => "AWS " . $cfc["access_key"] . ":" . $cf_signature));
								/**/
								if (($cf_response = c_ws_plugin__s2member_utils_urls::remote ("https://" . $cf_domain . $cf_location, false, array_merge ($cf_args, array ("timeout" => 20)), "array")) && (($cf_response["code"] === 404 && $cf_response["message"]) || ($cf_response["code"] === 200 && !empty ($cf_response["headers"]["etag"]) && !empty ($cf_response["body"]))))
									{
										if ($cf_response["code"] === 200 && !empty ($cf_response["headers"]["etag"]) && !empty ($cf_response["body"]))
											return array ("success" => true, "code" => null, "message" => null, "etag" => trim ($cf_response["headers"]["etag"]), "xml" => trim ($cf_response["body"]));
										/**/
										else /* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
											return array ("success" => false, "code" => $cf_response["code"], "message" => sprintf (_x ("Existing Amazon® CloudFront Origin Access Identity NOT found. %s", "s2member-admin", "s2member"), $cf_response["message"]));
									}
								else if (isset ($cf_response["code"], $cf_response["message"]))
									/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
									return array ("success" => false, "code" => $cf_response["code"], "message" => sprintf (_x ("Unable to acquire existing Amazon® CloudFront Origin Access Identity. %s", "s2member-admin", "s2member"), $cf_response["message"]));
								/**/
								else /* Else, we use a default error code and message. */
									return array ("success" => false, "code" => -98, "message" => _x ("Unable to acquire existing Amazon® CloudFront Origin Access Identity. Connection failed.", "s2member-admin", "s2member"));
							}
						else /* Else, we use a default error code and message. */
							return array ("success" => false, "code" => -99, "message" => _x ("Unable to acquire existing Amazon® CloudFront Origin Access Identity. Invalid Access ID.", "s2member-admin", "s2member"));
					}
				/**
				* Deletes an Amazon® S3/CloudFront Access Origin Identity.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @param str $access_id Required. An Origin Access ID.
				* @param str $access_id_etag Required. An Origin Access ETag header.
				* @param str $access_id_xml Required. An Origin Access Identity's XML configuration.
				* @return array Array containing a true `success` element on success, else a failure array.
				* 	Failure array will contain a failure `code`, and a failure `message`.
				*/
				public static function amazon_cf_del_access_origin_identity ($access_id = FALSE, $access_id_etag = FALSE, $access_id_xml = FALSE)
					{
						if ($access_id && is_string ($access_id) && $access_id_etag && is_string ($access_id_etag) && $access_id_xml && is_string ($access_id_xml))
							{
								foreach ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"] as $option => $option_value)
									if (preg_match ("/^amazon_cf_files_/", $option) && ($option = preg_replace ("/^amazon_cf_files_/", "", $option)))
										$cfc[$option] = $option_value;
								/**/
								$s3c["bucket"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_bucket"];
								$cfc["access_key"] = $s3c["access_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_access_key"];
								$cfc["secret_key"] = $s3c["secret_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_secret_key"];
								/**/
								$cf_domain = "cloudfront.amazonaws.com";
								$cf_date = gmdate ("D, d M Y H:i:s") . " GMT";
								$cf_location = "/2010-11-01/origin-access-identity/cloudfront/" . $access_id;
								$cf_signature = base64_encode (c_ws_plugin__s2member_files_in::amazon_cf_sign ($cf_date));
								$cf_args = array ("method" => "DELETE", "headers" => array ("Host" => $cf_domain, "Date" => $cf_date, "If-Match" => $access_id_etag, "Authorization" => "AWS " . $cfc["access_key"] . ":" . $cf_signature));
								/**/
								if (($cf_response = c_ws_plugin__s2member_utils_urls::remote ("https://" . $cf_domain . $cf_location, false, array_merge ($cf_args, array ("timeout" => 20)), "array")) && ($cf_response["code"] === 200 || $cf_response["code"] === 204 /* Deleted. */))
									return array ("success" => true, "code" => null, "message" => null); /* Deleted successfully. */
								/**/
								else if (isset ($cf_response["code"], $cf_response["message"]))
									/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
									return array ("success" => false, "code" => $cf_response["code"], "message" => sprintf (_x ("Unable to delete existing Amazon® CloudFront Origin Access Identity. %s", "s2member-admin", "s2member"), $cf_response["message"]));
								/**/
								else /* Else, we use a default error code and message. */
									return array ("success" => false, "code" => -98, "message" => _x ("Unable to delete existing Amazon® CloudFront Origin Access Identity. Connection failed.", "s2member-admin", "s2member"));
							}
						else /* Else, we use a default error code and message. */
							return array ("success" => false, "code" => -99, "message" => _x ("Unable to delete existing Amazon® CloudFront Origin Access Identity. Invalid Access ID, ETag, or XML config.", "s2member-admin", "s2member"));
					}
				/**
				* Creates an Amazon® S3/CloudFront Access Origin Identity for all Distros.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @return array Array containing a true `success` and `distros_access_id`, `distros_s3_access_id` elements on success, else a failure array.
				* 	Failure array will contain a failure `code`, and a failure `message`.
				*/
				public static function amazon_cf_create_distros_access_origin_identity ()
					{
						foreach ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"] as $option => $option_value)
							if (preg_match ("/^amazon_cf_files_/", $option) && ($option = preg_replace ("/^amazon_cf_files_/", "", $option)))
								$cfc[$option] = $option_value;
						/**/
						$s3c["bucket"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_bucket"];
						$cfc["access_key"] = $s3c["access_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_access_key"];
						$cfc["secret_key"] = $s3c["secret_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_secret_key"];
						/**/
						$cf_domain = "cloudfront.amazonaws.com";
						$cf_date = gmdate ("D, d M Y H:i:s") . " GMT";
						$cf_location = "/2010-11-01/origin-access-identity/cloudfront";
						$cf_signature = base64_encode (c_ws_plugin__s2member_files_in::amazon_cf_sign ($cf_date));
						$cf_distros_access_reference = time () . "." . md5 ("access" . $s3c["bucket"] . $s3c["access_key"] . $s3c["secret_key"] . $cfc["private_key"] . $cfc["private_key_id"]);
						$cf_distros_access_xml = '<?xml version="1.0" encoding="UTF-8"?><CloudFrontOriginAccessIdentityConfig xmlns="http://cloudfront.amazonaws.com/doc/2010-11-01/"><CallerReference>' . esc_html ($cf_distros_access_reference) . '</CallerReference><Comment>' . esc_html (sprintf (_x ("Created by s2Member, for S3 Bucket: %s.", "s2member-admin", "s2member"), $s3c["bucket"])) . '</Comment></CloudFrontOriginAccessIdentityConfig>';
						$cf_args = array ("method" => "POST", "body" => $cf_distros_access_xml, "headers" => array ("Host" => $cf_domain, "Content-Type" => "application/xml", "Date" => $cf_date, "Authorization" => "AWS " . $cfc["access_key"] . ":" . $cf_signature));
						/**/
						if (($cf_response = c_ws_plugin__s2member_utils_urls::remote ("https://" . $cf_domain . $cf_location, false, array_merge ($cf_args, array ("timeout" => 20)), "array")) && ($cf_response["code"] === 200 || $cf_response["code"] === 201 /* Created. */))
							{
								if (preg_match ("/\<CloudFrontOriginAccessIdentity.*?\>(.+?)\<\/CloudFrontOriginAccessIdentity\>/is", $cf_response["body"], $cf_distros_access_tag) && preg_match ("/\<Id\>(.+?)\<\/Id\>/is", $cf_distros_access_tag[1], $cf_distros_access_id_tag) && preg_match ("/\<S3CanonicalUserId\>(.+?)\<\/S3CanonicalUserId\>/is", $cf_distros_access_tag[1], $cf_distros_s3_access_id_tag))
									return array ("success" => true, "code" => null, "message" => null, "distros_access_id" => trim ($cf_distros_access_id_tag[1]), "distros_s3_access_id" => trim ($cf_distros_s3_access_id_tag[1]));
								/**/
								else /* Else, we use a default error code and message. */
									return array ("success" => false, "code" => -98, "message" => _x ("Unable to create/read Amazon® CloudFront Origin Access Identity. Unexpected response.", "s2member-admin", "s2member"));
							}
						else if (isset ($cf_response["code"], $cf_response["message"]))
							/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
							return array ("success" => false, "code" => $cf_response["code"], "message" => sprintf (_x ("Unable to create Amazon® CloudFront Origin Access Identity. %s", "s2member-admin", "s2member"), $cf_response["message"]));
						/**/
						else /* Else, we use a default error code and message. */
							return array ("success" => false, "code" => -99, "message" => _x ("Unable to create Amazon® CloudFront Origin Access Identity. Connection failed.", "s2member-admin", "s2member"));
					}
				/**
				* Acquires an Amazon® S3/CloudFront Distro.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @param str $distro_id Required. A Distro ID.
				* @param str $distro_type Required: `downloads|streaming`.
				* @return array Array containing a true `success` and `etag`, `xml`, `deployed` elements on success, else a failure array.
				* 	Failure array will contain a failure `code`, and a failure `message`.
				*/
				public static function amazon_cf_get_distro ($distro_id = FALSE, $distro_type = FALSE)
					{
						if ($distro_id && is_string ($distro_id) && $distro_type && is_string ($distro_type) && in_array ($distro_type, array ("downloads", "streaming")))
							{
								foreach ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"] as $option => $option_value)
									if (preg_match ("/^amazon_cf_files_/", $option) && ($option = preg_replace ("/^amazon_cf_files_/", "", $option)))
										$cfc[$option] = $option_value;
								/**/
								$s3c["bucket"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_bucket"];
								$cfc["access_key"] = $s3c["access_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_access_key"];
								$cfc["secret_key"] = $s3c["secret_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_secret_key"];
								/**/
								$cf_domain = "cloudfront.amazonaws.com";
								$cf_date = gmdate ("D, d M Y H:i:s") . " GMT";
								$cf_signature = base64_encode (c_ws_plugin__s2member_files_in::amazon_cf_sign ($cf_date));
								$cf_location = ($distro_type === "streaming") ? "/2010-11-01/streaming-distribution/" . $distro_id : "/2010-11-01/distribution/" . $distro_id;
								$cf_args = array ("method" => "GET", "headers" => array ("Host" => $cf_domain, "Date" => $cf_date, "Authorization" => "AWS " . $cfc["access_key"] . ":" . $cf_signature));
								/**/
								if (($cf_response = c_ws_plugin__s2member_utils_urls::remote ("https://" . $cf_domain . $cf_location, false, array_merge ($cf_args, array ("timeout" => 20)), "array")) && (($cf_response["code"] === 404 && $cf_response["message"]) || ($cf_response["code"] === 200 && !empty ($cf_response["headers"]["etag"]) && !empty ($cf_response["body"]))))
									{
										if ($cf_response["code"] === 200 && !empty ($cf_response["headers"]["etag"]) && !empty ($cf_response["body"]))
											return array ("success" => true, "code" => null, "message" => null, "etag" => trim ($cf_response["headers"]["etag"]), "xml" => trim ($cf_response["body"]), "deployed" => ((stripos ($cf_response["body"], "<Status>Deployed</Status>") !== false) ? true : false));
										/**/
										else /* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
											return array ("success" => false, "code" => $cf_response["code"], "message" => sprintf (_x ("Existing Amazon® CloudFront Distro NOT found. %s", "s2member-admin", "s2member"), $cf_response["message"]));
									}
								else if (isset ($cf_response["code"], $cf_response["message"]))
									/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
									return array ("success" => false, "code" => $cf_response["code"], "message" => sprintf (_x ("Unable to acquire existing Amazon® CloudFront Distro. %s", "s2member-admin", "s2member"), $cf_response["message"]));
								/**/
								else /* Else, we use a default error code and message. */
									return array ("success" => false, "code" => -98, "message" => _x ("Unable to acquire existing Amazon® CloudFront Distro. Connection failed.", "s2member-admin", "s2member"));
							}
						else /* Else, we use a default error code and message. */
							return array ("success" => false, "code" => -99, "message" => _x ("Unable to acquire existing Amazon® CloudFront Distro. Invalid Distro ID and/or Distro type.", "s2member-admin", "s2member"));
					}
				/**
				* Disables an Amazon® S3/CloudFront Distro.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @param str $distro_id Required. A Distro ID.
				* @param str $distro_id_etag Required. A Distro ETag header.
				* @param str $distro_id_xml Required. A Distro's XML configuration.
				* @return array Array containing a true `success` and `etag`, `xml`, `deployed` elements on success, else a failure array.
				* 	Failure array will contain a failure `code`, and a failure `message`.
				*/
				public static function amazon_cf_disable_distro ($distro_id = FALSE, $distro_id_etag = FALSE, $distro_id_xml = FALSE)
					{
						if ($distro_id && is_string ($distro_id) && $distro_id_etag && is_string ($distro_id_etag) && $distro_id_xml && is_string ($distro_id_xml) /* Parse type/reference too. */
						&& ($distro_id_type = (stripos ($distro_id_xml, "<StreamingDistribution") !== false) ? "streaming" : ((stripos ($distro_id_xml, "<Distribution") !== false) ? "downloads" : false)) #
						&& preg_match ("/\<CallerReference\>(.+?)\<\/CallerReference\>/is", $distro_id_xml, $distro_id_reference_tag) && ($distro_id_reference = $distro_id_reference_tag[1]))
							{
								if (stripos ($distro_id_xml, "<Enabled>false</Enabled>") === false) /* Only if it has NOT already been disabled. We do NOT need to do it again. */
									{
										if (stripos ($distro_id_xml, "<Status>Deployed</Status>") !== false) /* Check distro status before we even begin processing. */
											{
												foreach ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"] as $option => $option_value)
													if (preg_match ("/^amazon_cf_files_/", $option) && ($option = preg_replace ("/^amazon_cf_files_/", "", $option)))
														$cfc[$option] = $option_value;
												/**/
												$s3c["bucket"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_bucket"];
												$cfc["access_key"] = $s3c["access_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_access_key"];
												$cfc["secret_key"] = $s3c["secret_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_secret_key"];
												/**/
												$cf_domain = "cloudfront.amazonaws.com";
												$cf_date = gmdate ("D, d M Y H:i:s") . " GMT";
												$cf_signature = base64_encode (c_ws_plugin__s2member_files_in::amazon_cf_sign ($cf_date));
												$cf_location = ($distro_id_type === "streaming") ? "/2010-11-01/streaming-distribution/" . $distro_id . "/config" : "/2010-11-01/distribution/" . $distro_id . "/config";
												$cf_distro_xml = ($distro_id_type === "streaming") ? '<?xml version="1.0" encoding="UTF-8"?><StreamingDistributionConfig xmlns="http://cloudfront.amazonaws.com/doc/2010-11-01/"><S3Origin><DNSName>' . esc_html ($s3c["bucket"]) . '.s3.amazonaws.com</DNSName></S3Origin><CallerReference>' . esc_html ($distro_id_reference) . '</CallerReference><Enabled>false</Enabled><TrustedSigners><Self/></TrustedSigners></StreamingDistributionConfig>' : '<?xml version="1.0" encoding="UTF-8"?><DistributionConfig xmlns="http://cloudfront.amazonaws.com/doc/2010-11-01/"><S3Origin><DNSName>' . esc_html ($s3c["bucket"]) . '.s3.amazonaws.com</DNSName></S3Origin><CallerReference>' . esc_html ($distro_id_reference) . '</CallerReference><Enabled>false</Enabled><TrustedSigners><Self/></TrustedSigners></DistributionConfig>';
												$cf_args = array ("method" => "PUT", "body" => $cf_distro_xml, "headers" => array ("Host" => $cf_domain, "Content-Type" => "application/xml", "Date" => $cf_date, "If-Match" => $distro_id_etag, "Authorization" => "AWS " . $cfc["access_key"] . ":" . $cf_signature));
												/**/
												if (($cf_response = c_ws_plugin__s2member_utils_urls::remote ("https://" . $cf_domain . $cf_location, false, array_merge ($cf_args, array ("timeout" => 20)), "array")) && $cf_response["code"] === 200 && !empty ($cf_response["headers"]["etag"]) && !empty ($cf_response["body"]))
													return array ("success" => true, "code" => null, "message" => null, "etag" => trim ($cf_response["headers"]["etag"]), "xml" => trim ($cf_response["body"]), "deployed" => ((stripos ($cf_response["body"], "<Status>Deployed</Status>") !== false) ? true : false));
												/**/
												else if (isset ($cf_response["code"], $cf_response["message"]))
													/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
													return array ("success" => false, "code" => $cf_response["code"], "message" => sprintf (_x ("Unable to disable existing Amazon® CloudFront Distro. %s", "s2member-admin", "s2member"), $cf_response["message"]));
												/**/
												else /* Else, we use a default error code and message. */
													return array ("success" => false, "code" => -97, "message" => _x ("Unable to disable existing Amazon® CloudFront Distro. Connection failed.", "s2member-admin", "s2member"));
											}
										else /* Else, we use a default error code and message. */
											return array ("success" => false, "code" => -98, "message" => _x ("Existing Amazon® CloudFront Distro cannot be disabled at this time. Still in a `pending` state. Please wait 15 minutes, then try again. There is a certain process that s2Member must strictly adhere to when re-configuring your Amazon® CloudFront Distros. You may have to tick the auto-configure checkbox again, and re-run s2Member's auto-configuration routine many times, because s2Member will likely run into several `pending` challenges, as it works to completely re-configure your Amazon® CloudFront Distros for you. Thanks for your patience. Please wait 15 minutes, then try again.", "s2member-admin", "s2member"));
									}
								else /* Else, we use a default error code and message. */
									return array ("success" => true, "code" => null, "message" => null, "etag" => $distro_id_etag, "xml" => $distro_id_xml, "deployed" => ((stripos ($distro_id_xml, "<Status>Deployed</Status>") !== false) ? true : false));
							}
						else /* Else, we use a default error code and message. */
							return array ("success" => false, "code" => -99, "message" => _x ("Unable to disable existing Amazon® CloudFront Distro. Invalid Distro ID, ETag, or XML config.", "s2member-admin", "s2member"));
					}
				/**
				* Deletes an Amazon® S3/CloudFront Distro.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @param str $distro_id Required. A Distro ID.
				* @param str $distro_id_etag Required. A Distro ETag header.
				* @param str $distro_id_xml Required. A Distro's XML configuration.
				* @return array Array containing a true `success` element on success, else a failure array.
				* 	Failure array will contain a failure `code`, and a failure `message`.
				*/
				public static function amazon_cf_del_distro ($distro_id = FALSE, $distro_id_etag = FALSE, $distro_id_xml = FALSE)
					{
						if ($distro_id && is_string ($distro_id) && $distro_id_etag && is_string ($distro_id_etag) && $distro_id_xml && is_string ($distro_id_xml) /* Parse type/reference too. */
						&& ($distro_id_type = (stripos ($distro_id_xml, "<StreamingDistribution") !== false) ? "streaming" : ((stripos ($distro_id_xml, "<Distribution") !== false) ? "downloads" : false)) #
						&& preg_match ("/\<CallerReference\>(.+?)\<\/CallerReference\>/is", $distro_id_xml, $distro_id_reference_tag) && ($distro_id_reference = $distro_id_reference_tag[1]))
							{
								if (stripos ($distro_id_xml, "<Status>Deployed</Status>") !== false) /* Check distro status before we even begin processing this deletion. */
									{
										if (($cf_response = c_ws_plugin__s2member_files_in::amazon_cf_disable_distro ($distro_id, $distro_id_etag, $distro_id_xml)) && $cf_response["success"])
											{
												if (($cf_response = c_ws_plugin__s2member_files_in::amazon_cf_get_distro ($distro_id, $distro_id_type)) && $cf_response["success"] && $cf_response["deployed"])
													{
														foreach ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"] as $option => $option_value)
															if (preg_match ("/^amazon_cf_files_/", $option) && ($option = preg_replace ("/^amazon_cf_files_/", "", $option)))
																$cfc[$option] = $option_value;
														/**/
														$s3c["bucket"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_bucket"];
														$cfc["access_key"] = $s3c["access_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_access_key"];
														$cfc["secret_key"] = $s3c["secret_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_secret_key"];
														/**/
														$cf_domain = "cloudfront.amazonaws.com";
														$cf_date = gmdate ("D, d M Y H:i:s") . " GMT";
														$cf_signature = base64_encode (c_ws_plugin__s2member_files_in::amazon_cf_sign ($cf_date));
														$cf_location = ($distro_id_type === "streaming") ? "/2010-11-01/streaming-distribution/" . $distro_id : "/2010-11-01/distribution/" . $distro_id;
														$cf_args = array ("method" => "DELETE", "headers" => array ("Host" => $cf_domain, "Date" => $cf_date, "If-Match" => $cf_response["etag"], "Authorization" => "AWS " . $cfc["access_key"] . ":" . $cf_signature));
														/**/
														if (($cf_response = c_ws_plugin__s2member_utils_urls::remote ("https://" . $cf_domain . $cf_location, false, array_merge ($cf_args, array ("timeout" => 20)), "array")) && ($cf_response["code"] === 200 || $cf_response["code"] === 204 /* Deleted. */))
															return array ("success" => true, "code" => null, "message" => null); /* Deleted successfully. */
														/**/
														else if (isset ($cf_response["code"], $cf_response["message"]))
															/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
															return array ("success" => false, "code" => $cf_response["code"], "message" => sprintf (_x ("Unable to delete existing Amazon® CloudFront Distro. %s", "s2member-admin", "s2member"), $cf_response["message"]));
														/**/
														else /* Else, we use a default error code and message. */
															return array ("success" => false, "code" => -94, "message" => _x ("Unable to delete existing Amazon® CloudFront Distro. Connection failed.", "s2member-admin", "s2member"));
													}
												else if (isset ($cf_response["success"], $cf_response["deployed"]) && $cf_response["success"] && !$cf_response["deployed"])
													/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
													return array ("success" => false, "code" => -95, "message" => _x ("Existing Amazon® CloudFront Distro cannot be deleted at this time. Still in a `pending` state after having been disabled by s2Member. Please wait 15 minutes, then try again. There is a certain process that s2Member must strictly adhere to when re-configuring your Amazon® CloudFront Distros. You may have to tick the auto-configure checkbox again, and re-run s2Member's auto-configuration routine many times, because s2Member will likely run into several `pending` challenges, as it works to completely re-configure your Amazon® CloudFront Distros for you. Thanks for your patience. Please wait 15 minutes, then try again.", "s2member-admin", "s2member"));
												/**/
												else if (isset ($cf_response["code"], $cf_response["message"]))
													/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
													return array ("success" => false, "code" => $cf_response["code"], "message" => sprintf (_x ("Unable to check status of existing Amazon® CloudFront Distro. %s", "s2member-admin", "s2member"), $cf_response["message"]));
												/**/
												else /* Else, we use a default error code and message. */
													return array ("success" => false, "code" => -96, "message" => _x ("Unable to check status of existing Amazon® CloudFront Distro. Connection failed.", "s2member-admin", "s2member"));
											}
										else if (isset ($cf_response["code"], $cf_response["message"]))
											/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
											return array ("success" => false, "code" => $cf_response["code"], "message" => sprintf (_x ("Unable to disable existing Amazon® CloudFront Distro. %s", "s2member-admin", "s2member"), $cf_response["message"]));
										/**/
										else /* Else, we use a default error code and message. */
											return array ("success" => false, "code" => -97, "message" => _x ("Unable to disable existing Amazon® CloudFront Distro. Connection failed.", "s2member-admin", "s2member"));
									}
								else /* Else, we use a default error code and message. */
									return array ("success" => false, "code" => -98, "message" => _x ("Existing Amazon® CloudFront Distro cannot be deleted at this time. Still in a `pending` state. Please wait 15 minutes, then try again. There is a certain process that s2Member must strictly adhere to when re-configuring your Amazon® CloudFront Distros. You may have to tick the auto-configure checkbox again, and re-run s2Member's auto-configuration routine many times, because s2Member will likely run into several `pending` challenges, as it works to completely re-configure your Amazon® CloudFront Distros for you. Thanks for your patience. Please wait 15 minutes, then try again.", "s2member-admin", "s2member"));
							}
						else /* Else, we use a default error code and message. */
							return array ("success" => false, "code" => -99, "message" => _x ("Unable to delete existing Amazon® CloudFront Distro. Invalid Distro ID or ETag.", "s2member-admin", "s2member"));
					}
				/**
				* Creates an Amazon® S3/CloudFront Distro.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @param str $distro_type Required: `downloads|streaming`.
				* @return array Array containing a true `success` and `distro_[distro_type]_id`, `distro_[distro_type]_dname` elements on success, else a failure array.
				* 	Failure array will contain a failure `code`, and a failure `message`.
				*/
				public static function amazon_cf_create_distro ($distro_type = FALSE)
					{
						if ($distro_type && is_string ($distro_type) && in_array ($distro_type, array ("downloads", "streaming")))
							{
								foreach ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"] as $option => $option_value)
									if (preg_match ("/^amazon_cf_files_/", $option) && ($option = preg_replace ("/^amazon_cf_files_/", "", $option)))
										$cfc[$option] = $option_value;
								/**/
								$s3c["bucket"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_bucket"];
								$cfc["access_key"] = $s3c["access_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_access_key"];
								$cfc["secret_key"] = $s3c["secret_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_secret_key"];
								/**/
								$cf_domain = "cloudfront.amazonaws.com";
								$cf_date = gmdate ("D, d M Y H:i:s") . " GMT";
								$cf_signature = base64_encode (c_ws_plugin__s2member_files_in::amazon_cf_sign ($cf_date));
								/**/
								if ($distro_type === "downloads") /* Create a `downloads` Distro? This uses a different XML schema. */
									{
										$cf_location = "/2010-11-01/distribution"; /* Create distro. */
										$cf_distro_downloads_reference = time () . "." . md5 ("downloads" . $s3c["bucket"] . $s3c["access_key"] . $s3c["secret_key"] . $cfc["private_key"] . $cfc["private_key_id"] . $cfc["distro_downloads_cname"]);
										$cf_distro_downloads_xml = '<?xml version="1.0" encoding="UTF-8"?><DistributionConfig xmlns="http://cloudfront.amazonaws.com/doc/2010-11-01/"><S3Origin><DNSName>' . esc_html ($s3c["bucket"]) . '.s3.amazonaws.com</DNSName><OriginAccessIdentity>origin-access-identity/cloudfront/' . esc_html ($cfc["distros_access_id"]) . '</OriginAccessIdentity></S3Origin><CallerReference>' . esc_html ($cf_distro_downloads_reference) . '</CallerReference>' . (($cfc["distro_downloads_cname"]) ? '<CNAME>' . esc_html ($cfc["distro_downloads_cname"]) . '</CNAME>' : '') . '<Comment>' . esc_html (sprintf (_x ("Created by s2Member, for S3 Bucket: %s.", "s2member-admin", "s2member"), $s3c["bucket"])) . '</Comment><Enabled>true</Enabled><DefaultRootObject>index.html</DefaultRootObject><TrustedSigners><Self/></TrustedSigners></DistributionConfig>';
										$cf_args = array ("method" => "POST", "body" => $cf_distro_downloads_xml, "headers" => array ("Host" => $cf_domain, "Content-Type" => "application/xml", "Date" => $cf_date, "Authorization" => "AWS " . $cfc["access_key"] . ":" . $cf_signature));
										/**/
										if (($cf_response = c_ws_plugin__s2member_utils_urls::remote ("https://" . $cf_domain . $cf_location, false, array_merge ($cf_args, array ("timeout" => 20)), "array")) && ($cf_response["code"] === 200 || $cf_response["code"] === 201 /* Created. */))
											{
												if (preg_match ("/\<Distribution.*?\>(.+?)\<\/Distribution\>/is", $cf_response["body"], $cf_distro_downloads_tag) && preg_match ("/\<Id\>(.+?)\<\/Id\>/is", $cf_distro_downloads_tag[1], $cf_distro_downloads_id_tag) && preg_match ("/\<DomainName\>(.+?)\<\/DomainName\>/is", $cf_distro_downloads_tag[1], $cf_distro_downloads_dname_tag))
													return array ("success" => true, "code" => null, "message" => null, "distro_downloads_id" => trim ($cf_distro_downloads_id_tag[1]), "distro_downloads_dname" => trim ($cf_distro_downloads_dname_tag[1]));
												else /* Else, we use a default error code and message. */
													return array ("success" => false, "code" => -97, "message" => _x ("Unable to create/read Amazon® CloudFront Downloads Distro. Unexpected response.", "s2member-admin", "s2member"));
											}
										else if (isset ($cf_response["code"], $cf_response["message"]))
											/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
											return array ("success" => false, "code" => $cf_response["code"], "message" => sprintf (_x ("Unable to create Amazon® CloudFront Downloads Distro. %s", "s2member-admin", "s2member"), $cf_response["message"]));
										else /* Else, we use a default error code and message. */
											return array ("success" => false, "code" => -98, "message" => _x ("Unable to create Amazon® CloudFront Downloads Distro. Connection failed.", "s2member-admin", "s2member"));
									}
								/**/
								else if ($distro_type === "streaming") /* Create a `streaming` Distro? A different XML schema. */
									{
										$cf_location = "/2010-11-01/streaming-distribution"; /* Create streaming distro. */
										$cf_distro_streaming_reference = time () . "." . md5 ("streaming" . $s3c["bucket"] . $s3c["access_key"] . $s3c["secret_key"] . $cfc["private_key"] . $cfc["private_key_id"] . $cfc["distro_streaming_cname"]);
										$cf_distro_streaming_xml = '<?xml version="1.0" encoding="UTF-8"?><StreamingDistributionConfig xmlns="http://cloudfront.amazonaws.com/doc/2010-11-01/"><S3Origin><DNSName>' . esc_html ($s3c["bucket"]) . '.s3.amazonaws.com</DNSName><OriginAccessIdentity>origin-access-identity/cloudfront/' . esc_html ($cfc["distros_access_id"]) . '</OriginAccessIdentity></S3Origin><CallerReference>' . esc_html ($cf_distro_streaming_reference) . '</CallerReference>' . (($cfc["distro_streaming_cname"]) ? '<CNAME>' . esc_html ($cfc["distro_streaming_cname"]) . '</CNAME>' : '') . '<Comment>' . esc_html (sprintf (_x ("Created by s2Member, for S3 Bucket: %s.", "s2member-admin", "s2member"), $s3c["bucket"])) . '</Comment><Enabled>true</Enabled><DefaultRootObject>index.html</DefaultRootObject><TrustedSigners><Self/></TrustedSigners></StreamingDistributionConfig>';
										$cf_args = array ("method" => "POST", "body" => $cf_distro_streaming_xml, "headers" => array ("Host" => $cf_domain, "Content-Type" => "application/xml", "Date" => $cf_date, "Authorization" => "AWS " . $cfc["access_key"] . ":" . $cf_signature));
										/**/
										if (($cf_response = c_ws_plugin__s2member_utils_urls::remote ("https://" . $cf_domain . $cf_location, false, array_merge ($cf_args, array ("timeout" => 20)), "array")) && ($cf_response["code"] === 200 || $cf_response["code"] === 201 /* Created. */))
											{
												if (preg_match ("/\<StreamingDistribution.*?\>(.+?)\<\/StreamingDistribution\>/is", $cf_response["body"], $cf_distro_streaming_tag) && preg_match ("/\<Id\>(.+?)\<\/Id\>/is", $cf_distro_streaming_tag[1], $cf_distro_streaming_id_tag) && preg_match ("/\<DomainName\>(.+?)\<\/DomainName\>/is", $cf_distro_streaming_tag[1], $cf_distro_streaming_dname_tag))
													return array ("success" => true, "code" => null, "message" => null, "distro_streaming_id" => trim ($cf_distro_streaming_id_tag[1]), "distro_streaming_dname" => trim ($cf_distro_streaming_dname_tag[1]));
												else /* Else, we use a default error code and message. */
													return array ("success" => false, "code" => -97, "message" => _x ("Unable to create/read Amazon® CloudFront Streaming Distro. Unexpected response.", "s2member-admin", "s2member"));
											}
										else if (isset ($cf_response["code"], $cf_response["message"]))
											/* translators: In this translation, `%s` may be filled with an English message, which comes from the Amazon® CloudFront API call. Feel free to exclude `%s` if you like. */
											return array ("success" => false, "code" => $cf_response["code"], "message" => sprintf (_x ("Unable to create Amazon® CloudFront Streaming Distro. %s", "s2member-admin", "s2member"), $cf_response["message"]));
										else /* Else, we use a default error code and message. */
											return array ("success" => false, "code" => -98, "message" => _x ("Unable to create Amazon® CloudFront Streaming Distro. Connection failed.", "s2member-admin", "s2member"));
									}
							}
						else /* Else, we use a default error code and message. */
							return array ("success" => false, "code" => -99, "message" => _x ("Unable to create Amazon® CloudFront Distro. Invalid Distro type.", "s2member-admin", "s2member"));
					}
			}
	}
?>