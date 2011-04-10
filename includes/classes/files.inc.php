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
if (!class_exists ("c_ws_plugin__s2member_files"))
	{
		class c_ws_plugin__s2member_files
			{
				/*
				Function creates a special File Download Key.
				Uses: date("Y-m-d") . $_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_USER_AGENT"] . $file.
				
				The optional second argument can be passed in for compatiblity with Quick Cache / WP Super Cache.
				When $cache_compatible is passed in, the salt is reduced to only the $file value.
					- which is NOT as secure. So use that with caution.
				*/
				public static function file_download_key ($file = FALSE, $universal = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_file_download_key", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$salt = ($universal) ? $file /* ( cache compatible / universally available ) */
						: date ("Y-m-d") . $_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_USER_AGENT"] . $file;
						/**/
						$key = md5 (c_ws_plugin__s2member_utils_encryption::xencrypt ($salt));
						/**/
						if (!$universal) /* Disallow caching. */
							c_ws_plugin__s2member_nocache::nocache_constants (true);
						/**/
						return apply_filters ("ws_plugin__s2member_file_download_key", $key, get_defined_vars ());
					}
				/*
				Function determines the max period in days for download access.
				Returns number of days, where 0 means no access to files has been allowed.
				*/
				public static function max_download_period ()
					{
						do_action ("ws_plugin__s2member_before_max_download_period", get_defined_vars ());
						/**/
						$max = 0; /* This initializes the default value for $max file download allowed days. */
						/**/
						if ($days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed_days"])
							$max = ($max < $days) ? $days : $max;
						/**/
						if ($days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed_days"])
							$max = ($max < $days) ? $days : $max;
						/**/
						if ($days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed_days"])
							$max = ($max < $days) ? $days : $max;
						/**/
						if ($days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed_days"])
							$max = ($max < $days) ? $days : $max;
						/**/
						return apply_filters ("ws_plugin__s2member_max_download_period", ( ($max > 365) ? 365 : (int)$max), get_defined_vars ());
					}
				/*
				Function determines the minimum level required for file download access.
				Test === false to see if no access is allowed.
				This returns false, or (int)[0-1].
				*/
				public static function min_level_4_downloads ()
					{
						do_action ("ws_plugin__s2member_before_min_level_4_downloads", get_defined_vars ());
						/**/
						$file_download_access_is_allowed = $min_level_4_downloads = false; /* Test with === false, which means no access is allowed at all. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed_days"])
							$file_download_access_is_allowed = $min_level_4_downloads = 0;
						/**/
						else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed_days"])
							$file_download_access_is_allowed = $min_level_4_downloads = 1;
						/**/
						else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed_days"])
							$file_download_access_is_allowed = $min_level_4_downloads = 2;
						/**/
						else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed_days"])
							$file_download_access_is_allowed = $min_level_4_downloads = 3;
						/**/
						else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed_days"])
							$file_download_access_is_allowed = $min_level_4_downloads = 4;
						/**/
						return apply_filters ("ws_plugin__s2member_min_level_4_downloads", ($file_download_access_is_allowed = $min_level_4_downloads), get_defined_vars ());
					}
				/*
				Function determines how many downloads allowed - etc, etc.
				Returns an array with 3 elements: allowed, allowed_days, currently.
				The 2nd parameter can be used to prevent another database connection.
				*/
				public static function user_downloads ($current_user = FALSE, $not_counting_this_particular_file = FALSE, $log = NULL)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_user_downloads", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($current_user || ($current_user = (is_user_logged_in ()) ? wp_get_current_user () : false))
							{
								if ($current_user->has_cap ("access_s2member_level0") && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed"])
									{
										$allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed"];
										$allowed_days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed_days"];
									}
								/**/
								if ($current_user->has_cap ("access_s2member_level1") && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed"])
									{
										$allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed"];
										$allowed_days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed_days"];
									}
								/**/
								if ($current_user->has_cap ("access_s2member_level2") && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed"])
									{
										$allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed"];
										$allowed_days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed_days"];
									}
								/**/
								if ($current_user->has_cap ("access_s2member_level3") && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed"])
									{
										$allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed"];
										$allowed_days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed_days"];
									}
								/**/
								if ($current_user->has_cap ("access_s2member_level4") && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed"])
									{
										$allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed"];
										$allowed_days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed_days"];
									}
								/**/
								$file_download_access_log = (isset ($log)) ? (array)$log : (array)get_user_option ("s2member_file_download_access_log", $current_user->ID);
								foreach ($file_download_access_log as $file_download_access_log_entry_key => $file_download_access_log_entry)
									if (strtotime ($file_download_access_log_entry["date"]) >= strtotime ("-" . (int)$allowed_days . " days"))
										if ($file_download_access_log_entry["file"] !== $not_counting_this_particular_file)
											$currently = ($currently) ? $currently + 1 : 1;
							}
						/**/
						return apply_filters ("ws_plugin__s2member_user_downloads", array ("allowed" => (int)$allowed, "allowed_days" => (int)$allowed_days, "currently" => (int)$currently), get_defined_vars ());
					}
			}
	}
?>