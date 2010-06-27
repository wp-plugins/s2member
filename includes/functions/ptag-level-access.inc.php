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
/*
Function for handling ptag level access permissions.
Attach to: add_action("template_redirect");
*/
if (!function_exists ("ws_plugin__s2member_check_ptag_level_access"))
	{
		function ws_plugin__s2member_check_ptag_level_access ()
			{
				global $post; /* get_the_ID() not yet available here. */
				/**/
				do_action ("ws_plugin__s2member_before_check_ptag_level_access", get_defined_vars ());
				/**/
				$excluded = apply_filters ("ws_plugin__s2member_check_ptag_level_access_excluded", false, get_defined_vars ());
				/**/
				if (!$excluded && ((is_tag () && ($tag_ID = get_query_var ("tag"))) || (is_single () && has_tag () && is_object ($post) && ($post_ID = $post->ID))))
					{
						if (!ws_plugin__s2member_is_systematic_use_page () && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
							{
								$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Get the current User's object. */
								/**/
								if (is_tag () && $tag_ID) /* We also check if this is a post or page with tags, having a restricted tag. */
									{
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_ptags"] === "all" && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level0")) && wp_redirect (add_query_arg ("s2member_level_req", "0", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_ptags"] && is_tag (preg_split ("/[\r\n\t;,]+/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_ptags"]))) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level0")) && wp_redirect (add_query_arg ("s2member_level_req", "0", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ptags"] === "all" && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && wp_redirect (add_query_arg ("s2member_level_req", "1", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ptags"] && is_tag (preg_split ("/[\r\n\t;,]+/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ptags"]))) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && wp_redirect (add_query_arg ("s2member_level_req", "1", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ptags"] === "all" && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && wp_redirect (add_query_arg ("s2member_level_req", "2", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ptags"] && is_tag (preg_split ("/[\r\n\t;,]+/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ptags"]))) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && wp_redirect (add_query_arg ("s2member_level_req", "2", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ptags"] === "all" && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && wp_redirect (add_query_arg ("s2member_level_req", "3", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ptags"] && is_tag (preg_split ("/[\r\n\t;,]+/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ptags"]))) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && wp_redirect (add_query_arg ("s2member_level_req", "3", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_catgs"] === "all" && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && wp_redirect (add_query_arg ("s2member_level_req", "4", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_ptags"] && is_tag (preg_split ("/[\r\n\t;,]+/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_ptags"]))) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && wp_redirect (add_query_arg ("s2member_level_req", "4", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
									}
								else if (is_single () && has_tag () && $post_ID)
									{
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_ptags"] === "all" && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level0")) && wp_redirect (add_query_arg ("s2member_level_req", "0", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_ptags"] && has_tag (preg_split ("/[\r\n\t;,]+/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_ptags"]))) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level0")) && wp_redirect (add_query_arg ("s2member_level_req", "0", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ptags"] === "all" && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && wp_redirect (add_query_arg ("s2member_level_req", "1", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ptags"] && has_tag (preg_split ("/[\r\n\t;,]+/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ptags"]))) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && wp_redirect (add_query_arg ("s2member_level_req", "1", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ptags"] === "all" && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && wp_redirect (add_query_arg ("s2member_level_req", "2", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ptags"] && has_tag (preg_split ("/[\r\n\t;,]+/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ptags"]))) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && wp_redirect (add_query_arg ("s2member_level_req", "2", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ptags"] === "all" && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && wp_redirect (add_query_arg ("s2member_level_req", "3", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ptags"] && has_tag (preg_split ("/[\r\n\t;,]+/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ptags"]))) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && wp_redirect (add_query_arg ("s2member_level_req", "3", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_ptags"] === "all" && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && wp_redirect (add_query_arg ("s2member_level_req", "4", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_ptags"] && has_tag (preg_split ("/[\r\n\t;,]+/", preg_replace ("/( +)/", "-", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_ptags"]))) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && wp_redirect (add_query_arg ("s2member_level_req", "4", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
									}
								/**/
								do_action ("ws_plugin__s2member_during_check_ptag_level_access", get_defined_vars ());
							}
					}
				/**/
				do_action ("ws_plugin__s2member_after_check_ptag_level_access", get_defined_vars ());
				/**/
				return;
			}
	}
?>