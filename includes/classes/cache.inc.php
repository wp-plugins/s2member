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
if (!class_exists ("c_ws_plugin__s2member_cache"))
	{
		class c_ws_plugin__s2member_cache
			{
				/*
				Pulls all of the Page links needed for Constants.
				Page links are cached into the s2Member options on 15 min intervals.
				This allows the API Constants to provide quick access to them without being forced to execute get_page_link() all the time, which piles up DB queries.
				*/
				public static function cached_page_links ()
					{
						do_action ("ws_plugin__s2member_before_cached_page_links", get_defined_vars ());
						/**/
						$login_welcome_page = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"];
						$membership_options_page = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"];
						$file_download_limit_exceeded_page = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"];
						/**/
						$login_welcome_page_cache = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["login_welcome_page"];
						$membership_options_page_cache = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["membership_options_page"];
						$file_download_limit_exceeded_page_cache = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["file_download_limit_exceeded_page"];
						/**/
						$links = array ("login_welcome_page" => "", "membership_options_page" => "", "file_download_limit_exceeded_page" => "");
						/**/
						if ($login_welcome_page_cache["page"] === $login_welcome_page && $login_welcome_page_cache["time"] >= strtotime ("-15 minutes") && $login_welcome_page_cache["link"])
							{
								$links["login_welcome_page"] = $login_welcome_page_cache["link"];
							}
						else /* Otherwise, we need to query the database using get_page_link() and update the cache. */
							{
								$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["login_welcome_page"]["time"] = time ();
								$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["login_welcome_page"]["page"] = $login_welcome_page;
								$links["login_welcome_page"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["login_welcome_page"]["link"] = get_page_link ($login_welcome_page);
								/**/
								$cache_needs_updating = true; /* Flag for cache update. */
							}
						/**/
						if ($membership_options_page_cache["page"] === $membership_options_page && $membership_options_page_cache["time"] >= strtotime ("-15 minutes") && $membership_options_page_cache["link"])
							{
								$links["membership_options_page"] = $membership_options_page_cache["link"];
							}
						else /* Otherwise, we need to query the database using get_page_link() and update the cache. */
							{
								$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["membership_options_page"]["time"] = time ();
								$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["membership_options_page"]["page"] = $membership_options_page;
								$links["membership_options_page"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["membership_options_page"]["link"] = get_page_link ($membership_options_page);
								/**/
								$cache_needs_updating = true; /* Flag for cache update. */
							}
						/**/
						if ($file_download_limit_exceeded_page_cache["page"] === $file_download_limit_exceeded_page && $file_download_limit_exceeded_page_cache["time"] >= strtotime ("-15 minutes") && $file_download_limit_exceeded_page_cache["link"])
							{
								$links["file_download_limit_exceeded_page"] = $file_download_limit_exceeded_page_cache["link"];
							}
						else /* Otherwise, we need to query the database using get_page_link() and update the cache. */
							{
								$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["file_download_limit_exceeded_page"]["time"] = time ();
								$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["file_download_limit_exceeded_page"]["page"] = $file_download_limit_exceeded_page;
								$links["file_download_limit_exceeded_page"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["file_download_limit_exceeded_page"]["link"] = get_page_link ($file_download_limit_exceeded_page);
								/**/
								$cache_needs_updating = true; /* Flag for cache update. */
							}
						/**/
						if ($cache_needs_updating) /* Cache is also reset dynamically during back-end option updates. */
							{
								update_option ("ws_plugin__s2member_cache", $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]);
							}
						/**/
						$scheme = (is_ssl ()) ? "https" : "http"; /* SSL mode? */
						foreach ($links as &$link) /* Conversions for SSL and non-SSL mode. */
							$link = preg_replace ("/^http(s)?\:\/\//i", $scheme . "://", $link);
						/**/
						return apply_filters ("ws_plugin__s2member_cached_page_links", $links, get_defined_vars ());
					}
			}
	}
?>