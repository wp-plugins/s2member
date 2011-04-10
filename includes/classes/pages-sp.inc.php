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
if (!class_exists ("c_ws_plugin__s2member_pages_sp"))
	{
		class c_ws_plugin__s2member_pages_sp
			{
				/*
				Checks Page Level Access permissions - for a specific Page.
				
				Don't call this function directly, use one of these API functions:
					
					Is it protected by s2Member at all?
					- is_page_protected_by_s2member($page_id);
					- is_protected_by_s2member($page_id, "page");
					
					Is the current User permitted/authorized?
					- is_page_permitted_by_s2member($page_id);
					- is_permitted_by_s2member($page_id, "page");
				
				See: `/s2member/includes/functions/api-functions.inc.php`.
				*/
				public static function check_specific_page_level_access ($page_id = FALSE, $check_user = TRUE)
					{
						do_action ("ws_plugin__s2member_before_check_specific_page_level_access", get_defined_vars ());
						/**/
						$excluded = apply_filters ("ws_plugin__s2member_check_specific_page_level_access_excluded", false, get_defined_vars ());
						/**/
						if (!$excluded && $page_id && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]) /* Check? */
							{
								$page_link = get_page_link ($page_id); /* Determine link to this Page. */
								$page_path = parse_url ($page_link, PHP_URL_PATH); /* Parse req path. */
								$page_query = parse_url ($page_link, PHP_URL_QUERY); /* Parse query. */
								$page_uri = ($page_query) ? $page_path . "?" . $page_query : $page_path;
								/**/
								$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Get the current User's object. */
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"] && $page_id == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"] && (!$check_user || !$current_user || !current_user_can ("access_s2member_level0")) && $page_id != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
									return apply_filters ("ws_plugin__s2member_check_specific_page_level_access", array ("s2member_level_req" => 0), get_defined_vars ());
								/**/
								else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"] && ($login_redirection_uri = c_ws_plugin__s2member_login_redirects::login_redirection_uri ($current_user)) && preg_match ("/^" . preg_quote ($login_redirection_uri, "/") . "$/", $page_uri) && (!$check_user || !$current_user || !current_user_can ("access_s2member_level0")) && $page_id != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
									return apply_filters ("ws_plugin__s2member_check_specific_page_level_access", array ("s2member_level_req" => 0), get_defined_vars ());
								/**/
								else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"] && $page_id == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"] && (!$check_user || !$current_user || !current_user_can ("access_s2member_level0")) && $page_id != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
									return apply_filters ("ws_plugin__s2member_check_specific_page_level_access", array ("s2member_level_req" => 0), get_defined_vars ());
								/**/
								else if (!c_ws_plugin__s2member_systematics_sp::is_systematic_use_specific_page ($page_id, $page_uri)) /* However, there are 3 exceptions above ^. */
									{
										for ($i = 0; $i <= 4; $i++) /* Page Level restrictions. Go through each Membership Level. */
											{
												if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_pages"] === "all" && (!$check_user || !$current_user || !current_user_can ("access_s2member_level" . $i)))
													return apply_filters ("ws_plugin__s2member_check_specific_page_level_access", array ("s2member_level_req" => $i), get_defined_vars ());
												/**/
												else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_pages"] && in_array ($page_id, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_pages"])) && (!$check_user || !$current_user || !current_user_can ("access_s2member_level" . $i)))
													return apply_filters ("ws_plugin__s2member_check_specific_page_level_access", array ("s2member_level_req" => $i), get_defined_vars ());
											}
										/**/
										if (has_tag ("", $page_id)) /* Here we take a look to see if this Page has any Tags. If so, we need to run the full set of routines against Tags also. */
											{
												for ($i = 0; $i <= 4; $i++) /* Tag Level restrictions ( possibly through Page Tagger ). Go through each Membership Level. */
													{
														if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ptags"] === "all" && (!$check_user || !$current_user || !current_user_can ("access_s2member_level" . $i)))
															return apply_filters ("ws_plugin__s2member_check_specific_page_level_access", array ("s2member_level_req" => $i), get_defined_vars ());
														/**/
														else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ptags"] && has_tag (preg_split ("/[\r\n\t;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ptags"]), $page_id) && (!$check_user || !$current_user || !current_user_can ("access_s2member_level" . $i)))
															return apply_filters ("ws_plugin__s2member_check_specific_page_level_access", array ("s2member_level_req" => $i), get_defined_vars ());
													}
											}
										/**/
										for ($i = 0; $i <= 4; $i++) /* URIs. Go through each Membership Level. */
											{
												if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ruris"])
													foreach (preg_split ("/[\r\n\t]+/", c_ws_plugin__s2member_ruris::fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ruris"], $current_user)) as $str)
														if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $page_uri) && (!$check_user || !$current_user || !current_user_can ("access_s2member_level" . $i)))
															return apply_filters ("ws_plugin__s2member_check_specific_page_level_access", array ("s2member_level_req" => $i), get_defined_vars ());
											}
										/**/
										if (is_array ($ccaps_req = get_post_meta ($page_id, "s2member_ccaps_req", true)) && !empty ($ccaps_req))
											foreach ($ccaps_req as $ccap) /* The $current_user MUST satisfy ALL Custom Capabilities. Serialized array. */
												if (strlen ($ccap) && (!$check_user || !$current_user || !$current_user->has_cap ("access_s2member_ccap_" . $ccap)))
													return apply_filters ("ws_plugin__s2member_check_specific_page_level_access", array ("s2member_ccap_req" => $ccap), get_defined_vars ());
										/**/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"] && in_array ($page_id, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"])) && (!$check_user || !c_ws_plugin__s2member_sp_access::sp_access ($page_id, "read-only")))
											return apply_filters ("ws_plugin__s2member_check_specific_page_level_access", array ("s2member_sp_req" => $page_id), get_defined_vars ());
									}
								/**/
								do_action ("ws_plugin__s2member_during_check_specific_page_level_access", get_defined_vars ());
							}
						/**/
						return apply_filters ("ws_plugin__s2member_check_specific_page_level_access", null, get_defined_vars ());
					}
			}
	}
?>