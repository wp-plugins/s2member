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
Function for handling download access permissions.
Attach to: add_action("init");
*/
function ws_plugin__s2member_check_file_download_access ()
	{
		if ($_GET["s2member_file_download"])
			{
				if (!$_GET["s2member_free_file_download_key"] || ws_plugin__s2member_xdecrypt ($_GET["s2member_free_file_download_key"]) !== $_GET["s2member_file_download"])
					{
						$_GET["s2member_file_download"] = trim ($_GET["s2member_file_download"], "/");
						/**/
						$file_download_access_is_allowed = $minimum_level_required_to_download_files = ws_plugin__s2member_min_level_4_downloads ();
						/**/
						if (!($current_user = (is_user_logged_in ()) ? wp_get_current_user () : false) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=" . urlencode ($minimum_level_required_to_download_files))) !== "nill")
							exit;
						/**/
						else if (!$file_download_access_is_allowed) /* Have file downloads even been enabled? */
							{
								header ("HTTP/1.0 503 Service Temporarily Unavailable");
								echo '503 File Downloads Are Not Enabled.';
								exit;
							}
						/**/
						else if (!file_exists ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $_GET["s2member_file_download"]))
							{
								header ("HTTP/1.0 404 Not Found"); /* The file does not even exist. */
								echo '404 File Download Not Found.';
								exit;
							}
						/**/
						else if ((!is_array ($file_downloads = ws_plugin__s2member_user_downloads ()) || !$file_downloads["allowed"] || !$file_downloads["allowed_days"])/**/
						&& wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]), "s2member_file_download=" . urlencode ($_GET["s2member_file_download"]))) !== "nill")
							exit;
						/**/
						$previous_file_downloads = 0; /* Here we're going to count how many downloads they've performed. */
						$maximum_days_logged = ws_plugin__s2member_maximum_download_period (); /* The longest period in days. */
						$file_download_access_log = (array)get_usermeta ($current_user->ID, "s2member_file_download_access_log");
						$file_download_access_arc = (array)get_usermeta ($current_user->ID, "s2member_file_download_access_arc");
						/**/
						foreach ($file_download_access_log as $file_download_access_log_entry_key => $file_download_access_log_entry)
							{
								if (strtotime ($file_download_access_log_entry["date"]) < strtotime ("-" . $maximum_days_logged . " days"))
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
						&& wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]), "s2member_file_download=" . urlencode ($_GET["s2member_file_download"]))) !== "nill")
							exit;
						/**/
						if (!$already_downloaded) /* Only add this file to the log if they have not already downloaded it. */
							$file_download_access_log[] = array ("date" => date ("Y-m-d"), "file" => $_GET["s2member_file_download"]);
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
								echo '404 File Download Not Found.';
								exit;
							}
					}
				/*
				Here we are going to put together all of the file download information.
				*/
				$mimetypes = parse_ini_file (dirname (dirname (dirname (__FILE__))) . "/includes/mime-types.ini");
				/**/
				$pathinfo = pathinfo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $_GET["s2member_file_download"]);
				/**/
				$extension = strtolower ($pathinfo["extension"]); /* Convert file extension to lowercase format for MIME type lookup. */
				/**/
				$mimetype = ($mimetypes[$extension]) ? $mimetypes[$extension] : "application/octet-stream"; /* Lookup MIME type. */
				/**/
				$length = filesize ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $_GET["s2member_file_download"]);
				/*
				Now send the file to the browser.
				*/
				ini_set ("zlib.output_compression", false);
				/**/
				header ("Pragma: private");
				header ("Cache-Control: private");
				header ("Cache-Control: no-store, max-age=0, no-cache, must-revalidate");
				header ("Cache-Control: post-check=0, pre-check=0", false);
				/**/
				header ("Content-Encoding: none");
				header ("Content-Type: " . $mimetype);
				header ("Content-Length: " . $length);
				/**/
				header ('Content-Disposition: attachment; filename="' . $pathinfo["basename"] . '"');
				/**/
				readfile ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/" . $_GET["s2member_file_download"]);
				/**/
				exit;
			}
	}
?>