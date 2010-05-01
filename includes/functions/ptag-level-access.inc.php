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
Function for handling ptag level access permissions.
Attach to: add_action("template_redirect");
*/
function ws_plugin__s2member_check_ptag_level_access ()
	{
		global $post; /* get_the_ID() not yet available here. */
		/**/
		do_action ("s2member_before_check_ptag_level_access");
		/**/
		$excluded = apply_filters ("s2member_check_ptag_level_access_excluded", false);
		/**/
		if (!$excluded && ((is_tag () && ($tag_ID = get_query_var ("tag"))) || (is_single () && has_tag () && is_object ($post) && ($post_ID = $post->ID))))
			{
				if (!ws_plugin__s2member_is_systematic_use_page ()) /* Never restrict systematic use pages. */
					{
						$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false;
						/**/
						if (is_tag () && $tag_ID) /* We also check if this is a post or page with tags, having a restricted tag. */
							{
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ptags"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=1")) !== "nill")
									exit;
								/**/
								else if (($level1_ptags = preg_split ("/,/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ptags"]))) && is_tag ($level1_ptags) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=1")) !== "nill")
									exit;
								/**/
								else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ptags"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=2")) !== "nill")
									exit;
								/**/
								else if (($level2_ptags = preg_split ("/,/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ptags"]))) && is_tag ($level2_ptags) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=2")) !== "nill")
									exit;
								/**/
								else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ptags"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=3")) !== "nill")
									exit;
								/**/
								else if (($level3_ptags = preg_split ("/,/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ptags"]))) && is_tag ($level3_ptags) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=3")) !== "nill")
									exit;
								/**/
								else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_catgs"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=4")) !== "nill")
									exit;
								/**/
								else if (($level4_ptags = preg_split ("/,/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_ptags"]))) && is_tag ($level4_ptags) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=4")) !== "nill")
									exit;
							}
						else if (is_single () && has_tag () && $post_ID)
							{
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ptags"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=1")) !== "nill")
									exit;
								/**/
								else if (($level1_ptags = preg_split ("/,/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ptags"]))) && has_tag ($level1_ptags) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=1")) !== "nill")
									exit;
								/**/
								else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ptags"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=2")) !== "nill")
									exit;
								/**/
								else if (($level2_ptags = preg_split ("/,/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ptags"]))) && has_tag ($level2_ptags) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=2")) !== "nill")
									exit;
								/**/
								else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ptags"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=3")) !== "nill")
									exit;
								/**/
								else if (($level3_ptags = preg_split ("/,/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ptags"]))) && has_tag ($level3_ptags) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=3")) !== "nill")
									exit;
								/**/
								else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_ptags"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=4")) !== "nill")
									exit;
								/**/
								else if (($level4_ptags = preg_split ("/,/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_ptags"]))) && has_tag ($level4_ptags) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=4")) !== "nill")
									exit;
							}
						/**/
						do_action ("s2member_during_check_ptag_level_access");
					}
			}
		/**/
		do_action ("s2member_after_check_ptag_level_access");
		/**/
		return;
	}
?>