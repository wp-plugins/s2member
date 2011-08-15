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
	exit ("Do not access this file directly.");
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
				*
				* @return null Or exits script execution after serving a File Download.
				*/
				public static function check_file_download_access ()
					{
						do_action ("ws_plugin__s2member_before_file_download_access", get_defined_vars ());
						/**/
						if (!empty ($_GET["s2member_file_download"]) && strpos ($_GET["s2member_file_download"], "..") === false)
							{
								$excluded = apply_filters ("ws_plugin__s2member_check_file_download_access_excluded", false, get_defined_vars ());
								/**/
								if (!($using_amazon_s3_storage = 0) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_bucket"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_access_key"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_secret_key"])
									$using_amazon_s3_storage = true; /* Amazon® S3 storage has been configured! */
								/**/
								if (!$excluded && (empty ($_GET["s2member_file_download_key"]) || (!empty ($_GET["s2member_file_download_key"]) && !($file_download_key_is_valid = ($_GET["s2member_file_download_key"] === c_ws_plugin__s2member_files::file_download_key ($_GET["s2member_file_download"]) || $_GET["s2member_file_download_key"] === c_ws_plugin__s2member_files::file_download_key ($_GET["s2member_file_download"], "ip-forever") || $_GET["s2member_file_download_key"] === c_ws_plugin__s2member_files::file_download_key ($_GET["s2member_file_download"], "universal"))))))
									{
										$_GET["s2member_file_download"] = trim ($_GET["s2member_file_download"], "/"); /* Trim slashes after Key comparison. */
										/**/
										if (!$using_amazon_s3_storage && !file_exists ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $_GET["s2member_file_download"]))
											{
												header ("HTTP/1.0 404 Not Found"); /* The file does NOT even exist. */
												exit ("404: Sorry, file not found. Please contact Support for assistance.");
											}
										/**/
										else if (!empty ($_GET["s2member_file_download_key"]) && !$file_download_key_is_valid) /* Invalid Key? */
											{
												header ("HTTP/1.0 503 Service Temporarily Unavailable"); /* Invalid Download Keys are handled separately. */
												exit ("503 ( Invalid Key ): Sorry, your access to this file has expired. Please contact Support for assistance.");
											}
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]) /* Is a Membership Options Page configured? */
											/* This file will be processed WITHOUT a Download Key, using Membership Level Access ( w/ possible Custom Capabilities ). */
											{
												if (!has_filter ("ws_plugin__s2member_check_file_download_access_user", "c_ws_plugin__s2member_files_in::_file_remote_authorization"))
													add_filter ("ws_plugin__s2member_check_file_download_access_user", "c_ws_plugin__s2member_files_in::_file_remote_authorization", 10, 2);
												/**/
												if (($file_download_access_is_allowed = $min_level_4_downloads = c_ws_plugin__s2member_files::min_level_4_downloads ()) === false)
													{
														header ("HTTP/1.0 503 Service Temporarily Unavailable"); /* File downloads are NOT yet configured? */
														exit ("503: Sorry, File Downloads are NOT enabled yet. Please contact Support for assistance. If you are the site owner, please configure: `s2Member -> Download Options -> Basic Download Restrictions`.");
													}
												/**/
												else if (!is_object ($user = apply_filters ("ws_plugin__s2member_check_file_download_access_user", ((is_user_logged_in ()) ? wp_get_current_user () : false), get_defined_vars ())) || !($user_id = $user->ID))
													{
														if (preg_match ("/^access[_\-]s2member[_\-]level([0-9]+)\//", $_GET["s2member_file_download"], $m))
															{
																$level_req = $m[1]; /* Which Level does this require? */
																if (wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "file-" . $_GET["s2member_file_download"], "s2member_level_req" => $level_req)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) !== "nill")
																	exit ();
															}
														else if (preg_match ("/^access[_\-]s2member[_\-]ccap[_\-](.+?)\//", $_GET["s2member_file_download"], $m))
															{
																$ccap_req = preg_replace ("/-/", "_", $m[1]); /* Which Capability does this require? */
																if (wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "file-" . $_GET["s2member_file_download"], "s2member_ccap_req" => $ccap_req)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) !== "nill")
																	exit ();
															}
														else if (wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "file-" . $_GET["s2member_file_download"], "s2member_level_req" => (string)$min_level_4_downloads)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) !== "nill")
															exit ();
													}
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
												$already_downloaded = false; /* Initialize this to a false value. */
												$previous_file_downloads = 0; /* Here we're going to count how many downloads they've performed. */
												$max_days_logged = c_ws_plugin__s2member_files::max_download_period (); /* Longest period/days. */
												$file_download_access_log = (array)get_user_option ("s2member_file_download_access_log", $user_id);
												$file_download_access_arc = (array)get_user_option ("s2member_file_download_access_arc", $user_id);
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
												update_user_option ($user_id, "s2member_file_download_access_arc", c_ws_plugin__s2member_utils_arrays::array_unique ($file_download_access_arc));
												update_user_option ($user_id, "s2member_file_download_access_log", c_ws_plugin__s2member_utils_arrays::array_unique ($file_download_access_log));
											}
									}
								else /* Otherwise... it's either $excluded; or permission was granted with a valid Download Key. */
									{
										$_GET["s2member_file_download"] = trim ($_GET["s2member_file_download"], "/");
										/**/
										if (!$using_amazon_s3_storage && !file_exists ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $_GET["s2member_file_download"]))
											{
												header ("HTTP/1.0 404 Not Found"); /* The file does NOT even exist. */
												exit ("404: Sorry, file not found. Please contact Support for assistance.");
											}
									}
								/*
								Here we are going to put together all of the File Download information.
								*/
								$extension = strtolower (substr ($_GET["s2member_file_download"], strrpos ($_GET["s2member_file_download"], ".") + 1)); /* To lowercase. */
								/**/
								$mimetypes = parse_ini_file (dirname (dirname (dirname (__FILE__))) . "/includes/mime-types.ini"); /* Types provided by: `mime-types.ini`. */
								$mimetype = ($mimetypes[$extension]) ? $mimetypes[$extension] : "application/octet-stream"; /* Lookup the MIME type for this file extension. */
								/**/
								$inline = (!empty ($_GET["s2member_file_inline"]) || in_array ($extension, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_inline_extensions"]))) ? true : false;
								/**/
								$basename = basename ($_GET["s2member_file_download"]); /* The actual name of this File Download ( i.e. the basename ); including its file extension too. */
								/**/
								$pathinfo = (!$using_amazon_s3_storage) ? pathinfo (($file = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $_GET["s2member_file_download"])) : array ();
								$length = (!$using_amazon_s3_storage && $file) ? filesize ($file) : -1; /* The overall file size, in bytes. */
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_file_download_access", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								if ($using_amazon_s3_storage) /* Using Amazon® S3 storage? In this case, we use an authenticated redirection to S3 storage. */
									{
										$amazon_s3_file_expires = strtotime ("+" . apply_filters ("ws_plugin__s2member_amazon_s3_file_expires_time", "30 seconds", get_defined_vars ()));
										/**/
										$amazon_s3_file = "/" . $_GET["s2member_file_download"] . "?response-cache-control=" . urlencode (($amazon_s3_cache_control = "no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0")) . "&response-content-disposition=" . urlencode (($amazon_s3_content_disposition = (($inline) ? "inline" : "attachment") . '; filename="' . $basename . '"')) . "&response-content-type=" . urlencode (($amazon_s3_content_type = $mimetype)) . "&response-expires=" . urlencode (($amazon_s3_expires = gmdate ("D, d M Y H:i:s", strtotime ("-1 week")) . " GMT"));
										$amazon_s3_raw_file = "/" . $_GET["s2member_file_download"] . "?response-cache-control=" . $amazon_s3_cache_control . "&response-content-disposition=" . $amazon_s3_content_disposition . "&response-content-type=" . $amazon_s3_content_type . "&response-expires=" . $amazon_s3_expires;
										$amazon_s3_signature = base64_encode (c_ws_plugin__s2member_files_in::amazon_s3_sign ("GET\n\n\n" . $amazon_s3_file_expires . "\n" . "/" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_bucket"] . $amazon_s3_raw_file));
										/**/
										$amazon_s3_redirection_url = "http://" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_bucket"] . ".s3.amazonaws.com" . $amazon_s3_file;
										if (strtolower ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_bucket"]) !== $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_bucket"])
											$amazon_s3_redirection_url = "http://s3.amazonaws.com/" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_bucket"] . $amazon_s3_file;
										/**/
										$amazon_s3_redirection_url .= "&AWSAccessKeyId=" . urlencode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_access_key"]);
										$amazon_s3_redirection_url .= "&Expires=" . urlencode ($amazon_s3_file_expires);
										$amazon_s3_redirection_url .= "&Signature=" . urlencode ($amazon_s3_signature);
										/**/
										wp_redirect ($amazon_s3_redirection_url); /* 302 redirection. */
										/**/
										exit (); /* Clean exit. */
									}
								/**/
								else /* Else, using localized storage ( default ). */
									{
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
												fclose ($stream);
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
							}
						/**/
						do_action ("ws_plugin__s2member_after_file_download_access", get_defined_vars ());
					}
				/**
				* Creates an Amazon® S3 HMAC-SHA1 signature.
				*
				* @package s2Member\Files
				* @since 110524RC
				*
				* @param str $data Input data, to be signed by this routine.
				* @return str An HMAC-SHA1 signature for Amazon® S3.
				*/
				public static function amazon_s3_sign ($data = FALSE)
					{
						$key = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_secret_key"];
						$key = str_pad (((strlen ($key) > 64) ? pack ('H*', sha1 ($key)) : $key), 64, chr (0x00));
						return pack ('H*', sha1 (($key ^ str_repeat (chr (0x5c), 64)) . pack ('H*', sha1 (($key ^ str_repeat (chr (0x36), 64)) . $data))));
					}
				/**
				* A sort of callback function that handles Header Authorization for File Downloads.
				*
				* @package s2Member\Files
				* @since 3.5
				*
				* @attaches-to: ``add_filter("ws_plugin__s2member_check_file_download_access_user");``
				*
				* @param obj $user Expects a WP_User object passed in by the Filter.
				* @return obj A WP_User object, possibly obtained through Header Authorization.
				*/
				public static function _file_remote_authorization ($user = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_before_file_remote_authorization", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (!is_object ($user) && !empty ($_GET["s2member_file_remote"])) /* Use Header Authorization? */
							{
								do_action ("_ws_plugin__s2member_during_file_remote_authorization_before", get_defined_vars ());
								/**/
								if (empty ($_SERVER["PHP_AUTH_USER"]) || empty ($_SERVER["PHP_AUTH_PW"]) || !user_pass_ok ($_SERVER["PHP_AUTH_USER"], $_SERVER["PHP_AUTH_PW"]))
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