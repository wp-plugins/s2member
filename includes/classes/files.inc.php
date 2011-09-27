<?php
/**
* File Download routines for s2Member.
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
if (!class_exists ("c_ws_plugin__s2member_files"))
	{
		/**
		* File Download routines for s2Member.
		*
		* @package s2Member\Files
		* @since 3.5
		*/
		class c_ws_plugin__s2member_files
			{
				/**
				* Handles Download Access permissions.
				*
				* @package s2Member\Files
				* @since 110524RC
				*
				* @attaches-to: ``add_action("init");``
				* @also-called-by: API Function {@link s2Member\API_Functions\s2member_file_download_url()}, w/ ``$create_file_download_url`` param.
				*
				* @param array $create_file_download_url Optional. If this function is called directly, we can pass arguments through this array.
				* 	Possible array elements: `file_download` *(required)*, `file_download_key`, `file_stream`, `file_inline`, `file_storage`, `file_remote`, `file_ssl`, `file_rewrite`, `file_rewrite_base`, `skip_confirmation`, `url_to_storage_source`, `count_against_user`, `check_user`.
				* @return null|str If called directly with ``$create_file_download_url``, returns a string with the URL, based on configuration.
				* 	Else, this function may exit script execution after serving a File Download.
				*/
				public static function check_file_download_access ($create_file_download_url = FALSE) /* Calls inner routine. */
					{
						if (is_array ($create_file_download_url) || !empty ($_GET["s2member_file_download"])) /* Call inner routine? */
							{
								return c_ws_plugin__s2member_files_in::check_file_download_access ($create_file_download_url);
							}
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
				public static function create_file_download_url ($config = FALSE, $get_streamer_array = FALSE) /* Calls inner routine. */
					{
						return c_ws_plugin__s2member_files_in::create_file_download_url ($config, $get_streamer_array);
					}
				/**
				* Auto-configures an Amazon® S3 Bucket's ACLs.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @return bool|array True on success, else array on failure.
				* 	Failure array will contain a failure `code`, and a failure `message`.
				*/
				public static function amazon_s3_auto_configure_acls () /* Calls inner routine. */
					{
						return c_ws_plugin__s2member_files_in::amazon_s3_auto_configure_acls ();
					}
				/**
				* Auto-configures Amazon® S3/CloudFront distros.
				*
				* @package s2Member\Files
				* @since 110926
				*
				* @return bool|array True on success, else array on failure.
				* 	Failure array will contain a failure `code`, and a failure `message`.
				*/
				public static function amazon_s3_cf_auto_configure_distros () /* Calls inner routine. */
					{
						return c_ws_plugin__s2member_files_in::amazon_s3_cf_auto_configure_distros ();
					}
				/**
				* Determines the max period ( in days ), for Download Access.
				*
				* @package s2Member\Files
				* @since 3.5
				*
				* @return int Number of days, where 0 means no access to files is allowed.
				* 	Will not return a value > `365`, because this routine also controls the age of download logs to archives.
				*
				* @todo Remove the limitation of `365` days somehow.
				*/
				public static function max_download_period ()
					{
						do_action ("ws_plugin__s2member_before_max_download_period", get_defined_vars ());
						/**/
						for ($n = 0, $max = 0; $n <= $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n++)
							if (!empty ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_file_downloads_allowed"]))
								if (!empty ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_file_downloads_allowed_days"]))
									if (($days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_file_downloads_allowed_days"]))
										$max = ($max < $days) ? $days : $max;
						/**/
						return apply_filters ("ws_plugin__s2member_max_download_period", (($max > 365) ? 365 : $max), get_defined_vars ());
					}
				/**
				* Determines the minimum Level required for File Download Access.
				*
				* @package s2Member\Files
				* @since 3.5
				*
				* @return bool|int False if no access is allowed, else Level number (int) 0+.
				*/
				public static function min_level_4_downloads ()
					{
						do_action ("ws_plugin__s2member_before_min_level_4_downloads", get_defined_vars ());
						/**/
						for ($n = 0, $min = false; $n <= $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n++)
							if (!empty ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_file_downloads_allowed"]))
								if (!empty ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_file_downloads_allowed_days"]))
									if (($min = $n) >= 0)
										break;
						/**/
						return apply_filters ("ws_plugin__s2member_min_level_4_downloads", ((is_int ($min)) ? $min : false), get_defined_vars ());
					}
				/**
				* Determines how many File Downloads are allowed, also provides some extended details.
				*
				* @package s2Member\Files
				* @since 3.5
				*
				* @param obj $user Optional. Defaults to the current User's object.
				* @param str $not_counting_this_particular_file Optional. If you want to exclude a particular file.
				* @param array $log Optional. Prevents another database connection *( i.e. the log does not need to be pulled again )*.
				* @return array An array with three elements: `allowed`, `allowed_days`, `currently`.
				*/
				public static function user_downloads ($user = FALSE, $not_counting_this_particular_file = FALSE, $log = NULL)
					{
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_user_downloads", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$allowed = $allowed_days = $currently = 0; /* Initialize all of these to zero. */
						/**/
						if ((is_object ($user) || is_object ($user = (is_user_logged_in ()) ? wp_get_current_user () : false)) && !empty ($user->ID) && ($user_id = $user->ID))
							{
								for ($n = 0; $n <= $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n++)
									{
										if ($user->has_cap ("access_s2member_level" . $n)) /* Do they have access? */
											{
												if (!empty ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_file_downloads_allowed"]))
													if (!empty ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_file_downloads_allowed_days"]))
														{
															$allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_file_downloads_allowed"];
															$allowed_days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_file_downloads_allowed_days"];
														}
												if ($user->has_cap ("s2member_level" . $n)) /* We can stop now, if this is their Role. */
													break; /* Break now. */
											}
									}
								/**/
								$file_download_access_log = (isset ($log)) ? (array)$log : (array)get_user_option ("s2member_file_download_access_log", $user_id);
								foreach ($file_download_access_log as $file_download_access_log_entry_key => $file_download_access_log_entry)
									if (strtotime ($file_download_access_log_entry["date"]) >= strtotime ("-" . $allowed_days . " days"))
										if ($file_download_access_log_entry["file"] !== $not_counting_this_particular_file)
											$currently = $currently + 1;
							}
						/**/
						return apply_filters ("ws_plugin__s2member_user_downloads", array ("allowed" => $allowed, "allowed_days" => $allowed_days, "currently" => $currently), get_defined_vars ());
					}
				/**
				* Creates a File Download Key.
				*
				* Builds a hash of: ``date("Y-m-d") . $_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_USER_AGENT"] . $file``.
				*
				* @package s2Member\Files
				* @since 3.5
				*
				* @param str $file Location of your protected file, relative to the `/s2member-files/` directory.
				* 	In other words, just the name of the file *(i.e. `file.zip` )*.
				* @param str $directive Optional. One of `ip-forever|universal|cache-compatible`.
				* 	`ip-forever` = a Download Key that never expires, tied only to a specific file and IP address.
				* 	`universal` and/or `cache-compatible` = a Download Key which never expires, and is NOT tied to any specific User. Use at your own risk.
				* @return str A Download Key. MD5 hash, 32 characters, URL-safe.
				*/
				public static function file_download_key ($file = FALSE, $directive = FALSE)
					{
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_file_download_key", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$file = ($file && is_string ($file) && ($file = trim ($file, "/"))) ? $file : "";
						/**/
						if ($directive === "ip-forever") /* Allows the current IP forever. */
							eval('$allow_caching = false; $salt = $file . $_SERVER["REMOTE_ADDR"];');
						/**/
						else if ($directive === "universal" || $directive === "cache-compatible" || $directive)
							eval('$allow_caching = true; $salt = $file;');
						/**/
						else /* Otherwise, we use the default ``$salt``, which is VERY restrictive; even to a specific browser. */
							eval('$allow_caching = false; $salt = date ("Y-m-d") . $_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_USER_AGENT"] . $file;');
						/**/
						$key = md5 (c_ws_plugin__s2member_utils_encryption::xencrypt ($salt));
						/**/
						if ($allow_caching === false) /* Disallow caching? */
							c_ws_plugin__s2member_no_cache::no_cache_constants (true);
						/**/
						return apply_filters ("ws_plugin__s2member_file_download_key", $key, get_defined_vars ());
					}
			}
	}
?>