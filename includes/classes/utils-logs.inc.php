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
if (!class_exists ("c_ws_plugin__s2member_utils_logs"))
	{
		class c_ws_plugin__s2member_utils_logs
			{
				/*
				Archive logs to prevent HUGE files from building up over time.
					This routine is staggered to conserve resources.
				This is called by all logging routines for s2Member.
				*/
				public static function archive_oversize_log_files ($stagger = TRUE)
					{
						if (!$stagger || is_float ($stagger = time () / 2)) /* Stagger this routine? */
							{
								if (is_dir ($dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]) && is_writable ($dir))
									{
										$max = apply_filters ("ws_plugin__s2member_oversize_log_file_bytes", 2097152, get_defined_vars ());
										/**/
										eval ('$log_files = scandir ($dir); shuffle($log_files); $counter = 1;');
										/**/
										foreach ($log_files as $file) /* Go through each log file. Up to 25 files at a time. */
											{
												if (preg_match ("/\.log$/i", $file) && !preg_match ("/-ARCHIVED-/i", $file) && is_file ($dir_file = $dir . "/" . $file))
													{
														if (filesize ($dir_file) > $max && is_writable ($dir_file)) /* The file must be writable. */
															if ($log = preg_replace ("/\.log$/i", "", $dir_file)) /* Strip .log before renaming. */
																rename ($dir_file, $log . "-ARCHIVED-" . date ("m-d-Y") . "-" . time () . ".log");
													}
												/**/
												if (($counter = $counter + 1) > 25) /* Up to 25 files at a time. */
													break; /* Stop for now. */
											}
									}
							}
						/**/
						return true;
					}
				/*
				Remove expired Transients inserted into the database by s2Member.
					This routine is staggered to conserve resources.
					- And only 5 Transients are deleted each time.
				This is called by s2Member's Auto-EOT System; every 10 minutes.
				*/
				public static function cleanup_expired_s2m_transients ($stagger = TRUE)
					{
						global $wpdb; /* Will need this for database cleaning. */
						/**/
						if (!$stagger || is_float ($stagger = time () / 2)) /* Stagger this routine? */
							{
								if (is_array ($expired_s2m_transients = $wpdb->get_results ("SELECT * FROM `" . $wpdb->options . "` WHERE `option_name` LIKE '" . esc_sql (like_escape ("_transient_timeout_s2m_")) . "%' AND `option_value` < '" . esc_sql (time ()) . "' LIMIT 5")) && !empty ($expired_s2m_transients))
									{
										foreach ($expired_s2m_transients as $expired_s2m_transient) /* Delete the _timeout, and also the Transient entry name itself. */
											if (($id = $expired_s2m_transient->option_id) && ($name = preg_replace ("/_transient_timeout_/i", "_transient_", $expired_s2m_transient->option_name, 1)))
												$wpdb->query ("DELETE FROM `" . $wpdb->options . "` WHERE `option_id` = '" . esc_sql ($id) . "' OR `option_name` = '" . esc_sql ($name) . "'");
									}
							}
						/**/
						return true;
					}
			}
	}
?>