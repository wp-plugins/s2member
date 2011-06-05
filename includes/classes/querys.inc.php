<?php
/**
* Query protection routines.
*
* Copyright: © 2009-2011
* {@link http://www.websharks-inc.com/ WebSharks, Inc.}
* ( coded in the USA )
*
* Released under the terms of the GNU General Public License.
* You should have received a copy of the GNU General Public License,
* along with this software. In the main directory, see: /licensing/
* If not, see: {@link http://www.gnu.org/licenses/}.
*
* @package s2Member\Queries
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_querys"))
	{
		/**
		* Query protection routines.
		*
		* @package s2Member\Queries
		* @since 3.5
		*/
		class c_ws_plugin__s2member_querys
			{
				/**
				* Filter all WordPress® queries.
				*
				* s2Member respects the query var: `suppress_filters`. 
				* If you need to make a query without it being Filtered, use  ``$wp_query->set ("suppress_filters", true);``.
				*
				* WordPress® 3.0+ Menus set: `suppress_filters = true`.
				* So this will NOT affect WP Menus
				* ( intended behavior ).
				*
				* @package s2Member\Queries
				* @since 3.5
				*
				* @param obj $wp_query Expects ``$wp_query`` by reference, from the Filter.
				* @param bool $force Optional. Defaults to false. If true, we bypass all standard conditions.
				* 	However, will never bypass `supress_filters`.
				* @return null
				*/
				public static function query_level_access (&$wp_query = FALSE, $force = FALSE)
					{
						static $initial_query = true; /* Tracks initial query Filtering. */
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_query_level_access", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_object ($wp_query) && !$wp_query->get ("suppress_filters")) /* s2Member will always respect the `suppress_filters` query arg. */
							{
								if (($o = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["filter_wp_query"]) !== "none" || $force) /* If `none`; only Filter with $force. */
									{
										if ($force /* Forcing this routine bypasses all of these other conditions. This works with the API function `attach_s2member_query_filters()`. */
										|| ($initial_query && preg_match ("/^(all|searches,feeds|searches)$/", $o) && $wp_query->is_search ()) /* Initial query for search results? */
										|| ($initial_query && preg_match ("/^(all|searches,feeds|feeds)$/", $o) && $wp_query->is_feed ()) /* Initital query for  feed listings? */
										|| ($o === "all" && !($initial_query && $wp_query->is_singular ())) /* << do NOT create 404's. Allow Security Gate to handle these. */)
											{
												if (!is_admin () /* The additional Ajax checks below, allow search plugins like Daves Live Search to be Filtered. Even when `is_admin() = true`.
												See: `http://wordpress.org/extend/plugins/daves-wordpress-live-search/`. Also see: `http://www.primothemes.com/forums/viewtopic.php?f=4&t=3087#p12786`. */
												|| (is_admin () && defined ("DOING_AJAX") && DOING_AJAX && !empty ($_REQUEST["action"]) && (did_action ("wp_ajax_nopriv_" . $_REQUEST["action"]) || did_action ("wp_ajax_" . $_REQUEST["action"])) && $wp_query->is_search ()))
													{
														$user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Get the current User's object. */
														/*
														Filter all Posts/Pages requiring Custom Capabilities that the current User does NOT have access to.
														*/
														if (is_array ($ccaps = c_ws_plugin__s2member_utils_gets::get_singular_ids_with_ccaps_req ($user)) && !empty ($ccaps))
															$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), $ccaps)));
														/*
														Filter all Posts/Pages requiring Specific Post/Page Access that the current Visitor does NOT have access to.
														*/
														if (is_array ($sps = c_ws_plugin__s2member_utils_gets::get_singular_ids_with_sp_req ()) && !empty ($sps))
															$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), $sps)));
														/**/
														for ($n = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n >= 0; $n--) /* Category Level Restrictions. Go through each Level. */
															{
																if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_catgs"] === "all" && (!$user || !current_user_can ("access_s2member_level" . $n)))
																	{
																		$wp_query->set ("category__not_in", c_ws_plugin__s2member_utils_gets::get_all_category_ids ());
																		break; /* All Categories will be locked down. */
																	}
																else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_catgs"] && (!$user || !current_user_can ("access_s2member_level" . $n)))
																	{
																		foreach (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_catgs"]) as $catg)
																			$catgs = array_merge ((array)$catgs, array ($catg), c_ws_plugin__s2member_utils_gets::get_all_child_category_ids ($catg));
																		$wp_query->set ("category__not_in", array_unique (array_merge ((array)$wp_query->get ("category__not_in"), $catgs)));
																	}
															}
														/**/
														for ($n = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n >= 0; $n--) /* Tag Level Restrictions. Go through each Level. */
															{
																if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_ptags"] === "all" && (!$user || !current_user_can ("access_s2member_level" . $n)))
																	{
																		$wp_query->set ("tag__not_in", c_ws_plugin__s2member_utils_gets::get_all_tag_ids ());
																		break; /* ALL Tags will be locked down. */
																	}
																else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_ptags"] && (!$user || !current_user_can ("access_s2member_level" . $n)))
																	{
																		$tags = c_ws_plugin__s2member_utils_gets::convert_tags_2_ids ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_ptags"]);
																		$wp_query->set ("tag__not_in", array_unique (array_merge ((array)$wp_query->get ("tag__not_in"), $tags)));
																	}
															}
														/**/
														for ($n = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n >= 0; $n--) /* Post Level Restrictions. Go through each Level. */
															{
																if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_posts"] === "all" && (!$user || !current_user_can ("access_s2member_level" . $n)))
																	{
																		$wp_query->set ("post__not_in", c_ws_plugin__s2member_utils_gets::get_all_post_ids ());
																		break; /* ALL Posts will be locked down. */
																	}
																else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_posts"] && (!$user || !current_user_can ("access_s2member_level" . $n)))
																	{
																		$posts = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_posts"]);
																		$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), $posts)));
																	}
															}
														/**/
														for ($n = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n >= 0; $n--) /* Page Level Restrictions. Go through each Level. */
															{
																if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_pages"] === "all" && (!$user || !current_user_can ("access_s2member_level" . $n)))
																	{
																		$wp_query->set ("post__not_in", c_ws_plugin__s2member_utils_gets::get_all_page_ids ());
																		break; /* ALL Pages will be locked down. */
																	}
																else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_pages"] && (!$user || !current_user_can ("access_s2member_level" . $n)))
																	{
																		$pages = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_pages"]);
																		$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), $pages)));
																	}
															}
														/**/
														eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_query_level_access", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
													}
											}
									}
							}
						/**/
						if ($initial_query && is_object ($wp_query)) /* Systematics. */
							c_ws_plugin__s2member_querys::_query_level_access_sys ($wp_query);
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_after_query_level_access", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$initial_query = false; /* No longer. */
						/**/
						return; /* For uniformity. */
					}
				/**
				* Filters Systematics in search results & feeds.
				*
				* s2Member respects the query var: `suppress_filters`. 
				* If you need to make a query without it being Filtered, use  ``$wp_query->set ("suppress_filters", true);``.
				*
				* WordPress® 3.0+ Menus set: `suppress_filters = true`.
				* So this will NOT affect WP Menus
				* ( intended behavior ).
				*
				* @package s2Member\Queries
				* @since 3.5
				*
				* @param obj $wp_query Expects ``$wp_query`` by reference.
				* @return null
				*/
				public static function _query_level_access_sys (&$wp_query = FALSE)
					{
						static $initial_query = true; /* Tracks initial query filtering. */
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_before_query_level_access_sys", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($initial_query && is_object ($wp_query) && !$wp_query->get ("suppress_filters")) /* Suppressing Filters? */
							{
								if ((!is_admin () && ($wp_query->is_search () || $wp_query->is_feed ())) /* Filter Systematics in searches and in feeds. */
								/* The additional Ajax checks below, allow search plugins like Daves Live Search to be Filtered. Even when `is_admin() = true`.
								See: `http://wordpress.org/extend/plugins/daves-wordpress-live-search/`. Also see: `http://www.primothemes.com/forums/viewtopic.php?f=4&t=3087#p12786`. */
								|| (is_admin () && defined ("DOING_AJAX") && DOING_AJAX && !empty ($_REQUEST["action"]) && (did_action ("wp_ajax_nopriv_" . $_REQUEST["action"]) || did_action ("wp_ajax_" . $_REQUEST["action"])) && $wp_query->is_search ()))
									{
										$s[] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"];
										$s[] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"];
										$s[] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"];
										/**/
										$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), $s)));
										/**/
										eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("_ws_plugin__s2member_during_query_level_access_sys", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
							}
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_after_query_level_access_sys", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$initial_query = false; /* No longer. */
						/**/
						return; /* For uniformity. */
					}
				/**
				* Forces query Filters *( on-demand )*.
				*
				* s2Member respects the query var: `suppress_filters`. 
				* If you need to make a query without it being Filtered, use  ``$wp_query->set ("suppress_filters", true);``.
				*
				* WordPress® 3.0+ Menus set: `suppress_filters = true`.
				* So this will NOT affect WP Menus
				* ( intended behavior ).
				*
				* @package s2Member\Queries
				* @since 3.5
				*
				* @param obj $wp_query Expects ``$wp_query`` by reference.
				* @return null
				*/
				public static function force_query_level_access (&$wp_query = FALSE)
					{
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_force_query_level_access", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						c_ws_plugin__s2member_querys::query_level_access ($wp_query, "force-filters");
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_after_force_query_level_access", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						return; /* For uniformity. */
					}
			}
	}
?>