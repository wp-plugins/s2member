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
Function for handling Page Level Access permissions.
Attach to: add_action("template_redirect");
*/
function ws_plugin__s2member_check_page_level_access ()
	{
		global $post; /* get_the_ID() not yet available here. */
		/**/
		do_action ("s2member_before_check_page_level_access", get_defined_vars ());
		/**/
		$excluded = apply_filters ("s2member_check_page_level_access_excluded", false, get_defined_vars ());
		/**/
		if (!$excluded && is_page () && is_object ($post) && ($page_ID = $post->ID))
			{
				$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false;
				/**/
				if ($page_ID == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"] && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || (!current_user_can ("access_s2member_level1") && !$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["allow_subscribers_in"])) && $page_ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"] && wp_redirect (add_query_arg ("s2member_level_req", "1", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
					exit;
				/**/
				else if ($page_ID == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"] && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && $page_ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"] && wp_redirect (add_query_arg ("s2member_level_req", "1", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
					exit;
				/**/
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_pages"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && !ws_plugin__s2member_is_systematic_use_page () && wp_redirect (add_query_arg ("s2member_level_req", "1", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
					exit;
				/**/
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_pages"] && in_array ($page_ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_pages"])) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && !ws_plugin__s2member_is_systematic_use_page () && wp_redirect (add_query_arg ("s2member_level_req", "1", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
					exit;
				/**/
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_pages"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && !ws_plugin__s2member_is_systematic_use_page () && wp_redirect (add_query_arg ("s2member_level_req", "2", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
					exit;
				/**/
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_pages"] && in_array ($page_ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_pages"])) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && !ws_plugin__s2member_is_systematic_use_page () && wp_redirect (add_query_arg ("s2member_level_req", "2", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
					exit;
				/**/
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_pages"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && !ws_plugin__s2member_is_systematic_use_page () && wp_redirect (add_query_arg ("s2member_level_req", "3", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
					exit;
				/**/
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_pages"] && in_array ($page_ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_pages"])) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && !ws_plugin__s2member_is_systematic_use_page () && wp_redirect (add_query_arg ("s2member_level_req", "3", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
					exit;
				/**/
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_pages"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && !ws_plugin__s2member_is_systematic_use_page () && wp_redirect (add_query_arg ("s2member_level_req", "4", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
					exit;
				/**/
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_pages"] && in_array ($page_ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_pages"])) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && !ws_plugin__s2member_is_systematic_use_page () && wp_redirect (add_query_arg ("s2member_level_req", "4", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
					exit;
				/**/
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"] && in_array ($page_ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"])) && ws_plugin__s2member_nocache_constants () !== "nill" && !ws_plugin__s2member_sp_access ($page_ID) && !ws_plugin__s2member_is_systematic_use_page () && wp_redirect (add_query_arg ("s2member_sp_req", $page_ID, get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
					exit;
				/**/
				do_action ("s2member_during_check_page_level_access", get_defined_vars ());
			}
		/**/
		do_action ("s2member_after_check_page_level_access", get_defined_vars ());
		/**/
		return;
	}
?>