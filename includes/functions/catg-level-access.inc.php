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
	exit("Do not access this file directly.");
/*
Function for handling category level access permissions.
Attach to: add_action("template_redirect");
*/
if (!function_exists ("ws_plugin__s2member_check_catg_level_access"))
	{
		function ws_plugin__s2member_check_catg_level_access ()
			{
				global $post; /* get_the_ID() not yet available here. */
				/**/
				do_action ("ws_plugin__s2member_before_check_catg_level_access", get_defined_vars ());
				/**/
				$excluded = apply_filters ("ws_plugin__s2member_check_catg_level_access_excluded", false, get_defined_vars ());
				/**/
				if (!$excluded && ((is_category () && ($cat_ID = get_query_var ("cat"))) || (is_single () && !is_page () && is_object ($post) && ($post_ID = $post->ID))))
					{
						if (!ws_plugin__s2member_is_systematic_use_page ()) /* Never restrict systematic use pages. */
							{
								$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false;
								/**/
								if (is_category () && $cat_ID) /* We also check if this is a child category of a restricted category. */
									{
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_catgs"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level0")) && wp_redirect (add_query_arg ("s2member_level_req", "0", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_catgs"] && in_array ($cat_ID, ($level0_catgs = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_catgs"]))) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level0")) && wp_redirect (add_query_arg ("s2member_level_req", "0", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_catgs"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && wp_redirect (add_query_arg ("s2member_level_req", "1", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_catgs"] && in_array ($cat_ID, ($level1_catgs = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_catgs"]))) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && wp_redirect (add_query_arg ("s2member_level_req", "1", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_catgs"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && wp_redirect (add_query_arg ("s2member_level_req", "2", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_catgs"] && in_array ($cat_ID, ($level2_catgs = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_catgs"]))) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && wp_redirect (add_query_arg ("s2member_level_req", "2", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_catgs"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && wp_redirect (add_query_arg ("s2member_level_req", "3", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_catgs"] && in_array ($cat_ID, ($level3_catgs = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_catgs"]))) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && wp_redirect (add_query_arg ("s2member_level_req", "3", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_catgs"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && wp_redirect (add_query_arg ("s2member_level_req", "4", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_catgs"] && in_array ($cat_ID, ($level4_catgs = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_catgs"]))) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && wp_redirect (add_query_arg ("s2member_level_req", "4", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										if ($level0_catgs)
											foreach ($level0_catgs as $catg)
												if ($catg && cat_is_ancestor_of ($catg, $cat_ID) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level0")) && wp_redirect (add_query_arg ("s2member_level_req", "0", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
													exit ();
										/**/
										if ($level1_catgs)
											foreach ($level1_catgs as $catg)
												if ($catg && cat_is_ancestor_of ($catg, $cat_ID) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && wp_redirect (add_query_arg ("s2member_level_req", "1", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
													exit ();
										/**/
										if ($level2_catgs)
											foreach ($level2_catgs as $catg)
												if ($catg && cat_is_ancestor_of ($catg, $cat_ID) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && wp_redirect (add_query_arg ("s2member_level_req", "2", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
													exit ();
										/**/
										if ($level3_catgs)
											foreach ($level3_catgs as $catg)
												if ($catg && cat_is_ancestor_of ($catg, $cat_ID) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && wp_redirect (add_query_arg ("s2member_level_req", "3", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
													exit ();
										/**/
										if ($level4_catgs)
											foreach ($level4_catgs as $catg)
												if ($catg && cat_is_ancestor_of ($catg, $cat_ID) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && wp_redirect (add_query_arg ("s2member_level_req", "4", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
													exit ();
									}
								else if (is_single () && !is_page () && $post_ID)
									{
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_catgs"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level0")) && wp_redirect (add_query_arg ("s2member_level_req", "0", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_catgs"] && (in_category (($level0_catgs = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_catgs"])), $post_ID) || ws_plugin__s2member_in_descendant_category ($level0_catgs, $post_ID)) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level0")) && wp_redirect (add_query_arg ("s2member_level_req", "0", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_catgs"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && wp_redirect (add_query_arg ("s2member_level_req", "1", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_catgs"] && (in_category (($level1_catgs = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_catgs"])), $post_ID) || ws_plugin__s2member_in_descendant_category ($level1_catgs, $post_ID)) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && wp_redirect (add_query_arg ("s2member_level_req", "1", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_catgs"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && wp_redirect (add_query_arg ("s2member_level_req", "2", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_catgs"] && (in_category (($level2_catgs = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_catgs"])), $post_ID) || ws_plugin__s2member_in_descendant_category ($level2_catgs, $post_ID)) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && wp_redirect (add_query_arg ("s2member_level_req", "2", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_catgs"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && wp_redirect (add_query_arg ("s2member_level_req", "3", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_catgs"] && (in_category (($level3_catgs = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_catgs"])), $post_ID) || ws_plugin__s2member_in_descendant_category ($level3_catgs, $post_ID)) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && wp_redirect (add_query_arg ("s2member_level_req", "3", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_catgs"] === "all" && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && wp_redirect (add_query_arg ("s2member_level_req", "4", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_catgs"] && (in_category (($level4_catgs = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_catgs"])), $post_ID) || ws_plugin__s2member_in_descendant_category ($level4_catgs, $post_ID)) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && wp_redirect (add_query_arg ("s2member_level_req", "4", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
											exit ();
									}
								/**/
								do_action ("ws_plugin__s2member_during_check_catg_level_access", get_defined_vars ());
							}
					}
				/**/
				do_action ("ws_plugin__s2member_after_check_catg_level_access", get_defined_vars ());
				/**/
				return;
			}
	}
?>