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
	exit;
/*
Function determines the max period in days for download access.
Returns number of days, where 0 means no access to files has been allowed.
*/
function ws_plugin__s2member_max_download_period ()
	{
		do_action ("s2member_before_max_download_period", get_defined_vars ());
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
		return apply_filters ("s2member_max_download_period", (($max > 365) ? 365 : (int)$max), get_defined_vars ());
	}
/*
Function determines how many downloads allowed - etc, etc.
Returns an array with 3 elements: allowed, allowed_days, currently.
The 2nd parameter can be used to prevent another database connection.
*/
function ws_plugin__s2member_user_downloads ($not_counting_this_particular_file = false, $log = null)
	{
		do_action ("s2member_before_user_downloads", get_defined_vars ());
		/**/
		if (($current_user = (is_user_logged_in ()) ? wp_get_current_user () : false))
			{
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
		return apply_filters ("s2member_user_downloads", array ("allowed" => (int)$allowed, "allowed_days" => (int)$allowed_days, "currently" => (int)$currently), get_defined_vars ());
	}
/*
Function determines the minimum level required for file download access.
Returns 0-4, where 0 means no access to file downloads has been allowed.
*/
function ws_plugin__s2member_min_level_4_downloads ()
	{
		do_action ("s2member_before_min_level_4_downloads", get_defined_vars ());
		/**/
		if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed_days"])
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
		return apply_filters ("s2member_min_level_4_downloads", (int)$min_level_4_downloads, get_defined_vars ());
	}
/*
Function for handling download access permissions.
Attach to: add_action("init");
*/
function ws_plugin__s2member_check_file_download_access ()
	{
		do_action ("s2member_before_file_download_access", get_defined_vars ());
		/**/
		if ($_GET["s2member_file_download"]) /* Filter $excluded to force free downloads. */
			{
				$excluded = apply_filters ("s2member_check_file_download_access_excluded", false, get_defined_vars ()); /* Or use $_GET["s2member_free_file_download_key"] with a hash of the xencrypted version. */
				/**/
				if (!$excluded && (!$_GET["s2member_free_file_download_key"] || ($_GET["s2member_free_file_download_key"] !== md5 (ws_plugin__s2member_xencrypt ($_GET["s2member_file_download"]))/**/
				/* For backward compatiblity, we also check the xencrypted value, without the hash. This is decprecated as of v2.9. It will be removed completely in a future version. */
				&& $_GET["s2member_free_file_download_key"] !== ws_plugin__s2member_xencrypt ($_GET["s2member_file_download"]))))
					{
						$_GET["s2member_file_download"] = trim ($_GET["s2member_file_download"], "/");
						/**/
						$file_download_access_is_allowed = $minimum_level_required_to_download_files = ws_plugin__s2member_min_level_4_downloads ();
						/**/
						if (!($current_user = (is_user_logged_in ()) ? wp_get_current_user () : false) /* Redirect Users who are not logged in. */
						&& wp_redirect (add_query_arg (array ("s2member_level_req" => $minimum_level_required_to_download_files, "s2member_file_download_req" => $_GET["s2member_file_download"]), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
							exit;
						/**/
						else if (!$file_download_access_is_allowed) /* Have file downloads even been enabled? */
							{
								header ("HTTP/1.0 503 Service Temporarily Unavailable");
								echo '503: File Downloads Are Not Enabled.';
								exit;
							}
						/**/
						else if (!file_exists ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $_GET["s2member_file_download"]))
							{
								header ("HTTP/1.0 404 Not Found"); /* The file does not even exist. */
								echo '404: File Download Not Found.';
								exit;
							}
						/**/
						else if ((!is_array ($file_downloads = ws_plugin__s2member_user_downloads ()) || !$file_downloads["allowed"] || !$file_downloads["allowed_days"])/**/
						&& wp_redirect (add_query_arg (array ("s2member_file_download_req" => $_GET["s2member_file_download"]), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]))) !== "nill")
							exit;
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
							exit;
						/**/
						if (!$already_downloaded) /* Only add this file to the log if they have not already downloaded it. */
							$file_download_access_log[] = array ("date" => date ("Y-m-d"), "file" => $_GET["s2member_file_download"]);
						/**/
						update_usermeta ($current_user->ID, "s2member_file_download_access_arc", ws_plugin__s2member_array_unique ($file_download_access_arc));
						update_usermeta ($current_user->ID, "s2member_file_download_access_log", ws_plugin__s2member_array_unique ($file_download_access_log));
					}
				else /* This is a free download that we just need to check on the existence of. */
					{
						$_GET["s2member_file_download"] = trim ($_GET["s2member_file_download"], "/");
						/**/
						if (!file_exists ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $_GET["s2member_file_download"]))
							{
								header ("HTTP/1.0 404 Not Found"); /* The file does not exist. */
								echo '404: File Download Not Found.';
								exit;
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
				do_action ("s2member_during_file_download_access", get_defined_vars ());
				/*
				Now send the file to the browser. Be sure to turn off output compression.
				*/
				ini_set ("zlib.output_compression", 0); /* Must be turned off. */
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
				readfile ($file);
				/**/
				exit;
			}
		/**/
		do_action ("s2member_after_file_download_access", get_defined_vars ());
	}
?>