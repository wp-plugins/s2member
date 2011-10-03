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
	exit ("Do not access this file directly.");
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
				* The current WordPress® query object reference.
				*
				* @package s2Member\Queries
				* @since 110912
				*
				* @var null|obj
				*/
				static $current_wp_query;
				/**
				* Forces query Filters *( on-demand )*.
				*
				* s2Member respects the query var: `suppress_filters`. 
				* If you need to make a query without it being Filtered, use  ``$wp_query->set ("suppress_filters", true);``.
				*
				* @package s2Member\Queries
				* @since 3.5
				*
				* @attaches-to ``add_action("pre_get_posts");``
				*
				* @param obj $wp_query Expects ``$wp_query`` by reference.
				* @return null
				*/
				public static function force_query_level_access (&$wp_query = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_force_query_level_access", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						c_ws_plugin__s2member_querys::query_level_access ($wp_query, true);
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_after_force_query_level_access", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						return; /* For uniformity. */
					}
				/**
				* Filter all WordPress® queries.
				*
				* s2Member respects the query var: `suppress_filters`. 
				* If you need to make a query without it being Filtered, use  ``$wp_query->set ("suppress_filters", true);``.
				*
				* @package s2Member\Queries
				* @since 3.5
				*
				* @attaches-to ``add_action("pre_get_posts");``
				*
				* @param obj $wp_query Expects ``$wp_query`` by reference, from the Filter.
				* @param bool $force Optional. Defaults to false. If true, we bypass all standard conditions.
				* 	However, s2Member will NEVER bypass `supress_filters`.
				* @return null
				*/
				public static function query_level_access (&$wp_query = FALSE, $force = FALSE)
					{
						global $wpdb; /* Global database object reference. */
						static $initial_query = true; /* Tracks initial query. */
						c_ws_plugin__s2member_querys::$current_wp_query = &$wp_query;
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_query_level_access", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						c_ws_plugin__s2member_querys::_query_level_access_sys ($wp_query); /* Systematics. */
						/**/
						remove_filter ("comment_feed_where", "c_ws_plugin__s2member_querys::_query_level_access_coms", 100, 2);
						remove_filter ("wp_get_nav_menu_items", "c_ws_plugin__s2member_querys::_query_level_access_navs", 100);
						/**/
						if (is_object ($wpdb) && is_object ($wp_query) && (($o = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["filter_wp_query"]) || $force))
							{
								if (!is_admin () || c_ws_plugin__s2member_querys::_is_admin_ajax_search ($wp_query))
									{
										$suppressing_filters = $wp_query->get ("suppress_filters"); /* Filter suppression on? */
										if (!$suppressing_filters && $force /* Forcing this routine bypasses all of these other conditionals. Works with API function ``attach_s2member_query_filters()``. */
										|| (!$suppressing_filters && in_array ("all", $o) && !($initial_query && $wp_query->is_singular ())) /* Don't create 404 errors. Allow Security Gate to handle these. */
										|| (!$suppressing_filters && (in_array ("all", $o) || in_array ("searches", $o)) && $wp_query->is_search ()) /* Or, is this a search results query, possibly via AJAX: `admin-ajax.php`? */
										|| (!$suppressing_filters && (in_array ("all", $o) || in_array ("feeds", $o)) && $wp_query->is_feed () && !$wp_query->is_comment_feed ()) /* Or, is this a feed; and it's NOT for comments? */
										|| (!$suppressing_filters && (in_array ("all", $o) || in_array ("comment-feeds", $o)) && $wp_query->is_feed () && $wp_query->is_comment_feed ()) /* Or, is this a feed; and it IS indeed for comments? */
										|| (($suppressing_filters !== "n/a") && (in_array ("all", $o) || in_array ("nav-menus", $o)) && in_array ("wp_get_nav_menu_items", ($callers = (isset ($callers) ? $callers : c_ws_plugin__s2member_utilities::callers ()))))/**/)
											{
												if (!$suppressing_filters && (in_array ("all", $o) || in_array ("comment-feeds", $o)) && $wp_query->is_feed () && $wp_query->is_comment_feed ())
													add_filter ("comment_feed_where", "c_ws_plugin__s2member_querys::_query_level_access_coms", 100, 2);
												/**/
												if ($suppressing_filters !== "n/a" && (in_array ("all", $o) || in_array ("nav-menus", $o))) /* Suppression irrelevant here. */
													if (in_array ("wp_get_nav_menu_items", ($callers = (isset ($callers) ? $callers : c_ws_plugin__s2member_utilities::callers ()))))
														add_filter ("wp_get_nav_menu_items", "c_ws_plugin__s2member_querys::_query_level_access_navs", 100);
												/**/
												if ((is_user_logged_in () && is_object ($user = wp_get_current_user ()) && ($user_id = $user->ID)) || !($user = false))
													{
														if (!$user && ($lwp = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]))
															{
																$wp_query->set ("post__in", array_unique (array_diff ((array)$wp_query->get ("post__in"), array ($lwp))));
																$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), array ($lwp))));
															}
														/**/
														if (!$user && ($dep = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]))
															{
																$wp_query->set ("post__in", array_unique (array_diff ((array)$wp_query->get ("post__in"), array ($dep))));
																$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), array ($dep))));
															}
														/**/
														if (is_array ($ccaps = c_ws_plugin__s2member_utils_gets::get_singular_ids_with_ccaps_req ($user)) && !empty ($ccaps))
															{
																$wp_query->set ("post__in", array_unique (array_diff ((array)$wp_query->get ("post__in"), $ccaps)));
																$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), $ccaps)));
															}
														/**/
														if (is_array ($sps = c_ws_plugin__s2member_utils_gets::get_singular_ids_with_sp_req ()) && !empty ($sps))
															{
																$wp_query->set ("post__in", array_unique (array_diff ((array)$wp_query->get ("post__in"), $sps)));
																$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), $sps)));
															}
														/**/
														for ($n = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n >= 0; $n--) /* Category Level Restrictions. */
															{
																if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_catgs"] === "all" && (!$user || !current_user_can ("access_s2member_level" . $n)))
																	{
																		$wp_query->set ("category__in", array ()); /* Include no other Categories. */
																		$wp_query->set ("category__not_in", ($catgs = c_ws_plugin__s2member_utils_gets::get_all_category_ids ()));
																		$wp_query->set ("post__in", array_unique (array_diff ((array)$wp_query->get ("post__in"), c_ws_plugin__s2member_utils_gets::get_singular_ids_in_terms ($catgs))));
																		break; /* All Categories will be locked down. */
																	}
																else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_catgs"] && (!$user || !current_user_can ("access_s2member_level" . $n)))
																	{
																		foreach (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_catgs"]) as $catg)
																			$catgs = array_merge ((array)$catgs, array ($catg), c_ws_plugin__s2member_utils_gets::get_all_child_category_ids ($catg));
																		/**/
																		$wp_query->set ("category__in", array_unique (array_diff ((array)$wp_query->get ("category__in"), $catgs)));
																		$wp_query->set ("category__not_in", array_unique (array_merge ((array)$wp_query->get ("category__not_in"), $catgs)));
																		$wp_query->set ("post__in", array_unique (array_diff ((array)$wp_query->get ("post__in"), c_ws_plugin__s2member_utils_gets::get_singular_ids_in_terms ($catgs))));
																	}
															}
														/**/
														for ($n = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n >= 0; $n--) /* Tag Level Restrictions. */
															{
																if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_ptags"] === "all" && (!$user || !current_user_can ("access_s2member_level" . $n)))
																	{
																		$wp_query->set ("tag__in", array ()); /* Include no other Tags. */
																		$wp_query->set ("tag__not_in", ($tags = c_ws_plugin__s2member_utils_gets::get_all_tag_ids ()));
																		$wp_query->set ("post__in", array_unique (array_diff ((array)$wp_query->get ("post__in"), c_ws_plugin__s2member_utils_gets::get_singular_ids_in_terms ($tags))));
																		break; /* ALL Tags will be locked down. */
																	}
																else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_ptags"] && (!$user || !current_user_can ("access_s2member_level" . $n)))
																	{
																		$tags = c_ws_plugin__s2member_utils_gets::convert_tags_2_ids ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_ptags"]);
																		/**/
																		$wp_query->set ("tag__in", array_unique (array_diff ((array)$wp_query->get ("tag__in"), $tags)));
																		$wp_query->set ("tag__not_in", array_unique (array_merge ((array)$wp_query->get ("tag__not_in"), $tags)));
																		$wp_query->set ("post__in", array_unique (array_diff ((array)$wp_query->get ("post__in"), c_ws_plugin__s2member_utils_gets::get_singular_ids_in_terms ($tags))));
																	}
															}
														/**/
														for ($n = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n >= 0; $n--) /* Post Level Restrictions. */
															{
																if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_posts"] === "all" && (!$user || !current_user_can ("access_s2member_level" . $n)))
																	{
																		$wp_query->set ("post__in", array ()); /* Include no other Posts. */
																		$wp_query->set ("post__not_in", c_ws_plugin__s2member_utils_gets::get_all_post_ids ());
																		break; /* ALL Posts will be locked down. */
																	}
																else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_posts"] && (!$user || !current_user_can ("access_s2member_level" . $n)))
																	{
																		$posts = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_posts"]);
																		/**/
																		$wp_query->set ("post__in", array_unique (array_diff ((array)$wp_query->get ("post__in"), $posts)));
																		$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), $posts)));
																	}
															}
														/**/
														for ($n = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n >= 0; $n--) /* Page Level Restrictions. */
															{
																if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_pages"] === "all" && (!$user || !current_user_can ("access_s2member_level" . $n)))
																	{
																		$wp_query->set ("post__in", array ()); /* Include no other Posts. */
																		$wp_query->set ("post__not_in", c_ws_plugin__s2member_utils_gets::get_all_page_ids ());
																		break; /* ALL Pages will be locked down. */
																	}
																else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_pages"] && (!$user || !current_user_can ("access_s2member_level" . $n)))
																	{
																		$pages = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_pages"]);
																		/**/
																		$wp_query->set ("post__in", array_unique (array_diff ((array)$wp_query->get ("post__in"), $pages)));
																		$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), $pages)));
																	}
															}
													}
												/**/
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_query_level_access", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
											}
									}
							}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_after_query_level_access", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$initial_query = false; /* No longer. */
						/**/
						return; /* For uniformity. */
					}
				/**
				* Always filters Systematics in search results & feeds.
				*
				* s2Member respects the query var: `suppress_filters`. 
				* If you need to make a query without it being Filtered, use  ``$wp_query->set ("suppress_filters", true);``.
				*
				* @package s2Member\Queries
				* @since 3.5
				*
				* @param obj $wp_query Expects ``$wp_query`` by reference.
				* @return null
				*/
				public static function _query_level_access_sys (&$wp_query = FALSE)
					{
						global $wpdb; /* Global database object reference. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_before_query_level_access_sys", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_object ($wpdb) && is_object ($wp_query) && !($suppressing_filters = $wp_query->get ("suppress_filters")))
							if ((!is_admin () && ($wp_query->is_search () || $wp_query->is_feed ())) || c_ws_plugin__s2member_querys::_is_admin_ajax_search ($wp_query))
								{
									$s = array ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"], $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"], $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]);
									/**/
									$wp_query->set ("post__in", array_unique (array_diff ((array)$wp_query->get ("post__in"), $s)));
									$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), $s)));
									/**/
									eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
									do_action ("_ws_plugin__s2member_during_query_level_access_sys", get_defined_vars ());
									unset ($__refs, $__v); /* Unset defined __refs, __v. */
								}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_after_query_level_access_sys", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						return; /* For uniformity. */
					}
				/**
				* Filters WordPress® navigation menu items.
				*
				* @package s2Member\Queries
				* @since 110912
				*
				* @attaches-to ``add_filter("wp_get_nav_menu_items");``
				*
				* @param array $items Expects an array of items to be passed through by the Filter.
				* @return array The revised array of ``$items``.
				*/
				public static function _query_level_access_navs ($items = FALSE)
					{
						global $wpdb; /* Global database object reference. */
						$wp_query = &c_ws_plugin__s2member_querys::$current_wp_query;
						/**/
						if (is_array ($items) && is_object ($wpdb) && is_object ($wp_query) && $wp_query->get ("suppress_filters") !== "n/a")
							{
								$objs = array_merge ((array)$wp_query->get ("post__not_in"));
								$objs = array_unique (array_merge ($objs, (array)$wp_query->get ("tag__not_in")));
								$objs = array_unique (array_merge ($objs, (array)$wp_query->get ("category__not_in")));
								/**/
								foreach ($items as $item_key => $item) /* Filter through all nav menu items. */
									if (isset ($item->ID, $item->object_id) && /* And NOT defaulted to the item `ID`. */ (int)$item->ID !== (int)$item->object_id)
										if (in_array ($item->object_id, $objs)) /* If it is protected by query Filters, we need to remove it. */
											{
												foreach ($items as $child_item_key => $child_item)
													if (!empty ($child_item->menu_item_parent) && (int)$child_item->menu_item_parent === (int)$item->ID)
														unset ($items[$child_item_key]);
												/**/
												unset ($items[$item_key]);
											}
							}
						/**/
						remove_filter ("wp_get_nav_menu_items", "c_ws_plugin__s2member_querys::_query_level_access_navs", 100);
						return apply_filters ("_ws_plugin__s2member_query_level_access_navs", $items, get_defined_vars ());
					}
				/**
				* Filters ``$cwhere`` query portion.
				*
				* @package s2Member\Queries
				* @since 110912
				*
				* @attaches-to ``add_filter("comment_feed_where");``
				*
				* @param str $cwhere Expects the SQL `WHERE` portion to be passed through by the Filter.
				* @param obj $wp_query Expects ``$wp_query`` by reference, from the Filter.
				* @return str The revised ``$cwhere`` string.
				*/
				public static function _query_level_access_coms ($cwhere = FALSE, &$wp_query = FALSE)
					{
						global $wpdb; /* Global database object reference. */
						/**/
						if (is_string ($cwhere) && is_object ($wpdb) && is_object ($wp_query) && !$wp_query->get ("suppress_filters"))
							{
								$terms = array_unique (array_merge ((array)$wp_query->get ("category__not_in"), (array)$wp_query->get ("tag__not_in")));
								/**/
								$cwhere .= " AND `" . $wpdb->comments . "`.`comment_post_ID` NOT IN('" . implode ("','", (array)$wp_query->get ("post__not_in")) . "')";
								$cwhere .= " AND `" . $wpdb->comments . "`.`comment_post_ID` NOT IN('" . implode ("','", c_ws_plugin__s2member_utils_gets::get_singular_ids_in_terms ($terms)) . "')";
							}
						/**/
						remove_filter ("comment_feed_where", "c_ws_plugin__s2member_querys::_query_level_access_coms", 100, 2);
						return apply_filters ("_ws_plugin__s2member_query_level_access_coms", $cwhere, get_defined_vars ());
					}
				/**
				* AJAX search via `admin-ajax.php`?
				*
				* @package s2Member\Queries
				* @since 110912
				*
				* @param obj $wp_query Expects ``$wp_query`` by reference.
				* @return bool True if it's an AJAX search via `admin-ajax.php`, else false.
				*/
				public static function _is_admin_ajax_search (&$wp_query = FALSE)
					{
						global $wpdb; /* Global database object reference. */
						/**/
						if (is_object ($wpdb) && is_object ($wp_query) && is_admin () && $wp_query->is_search ())
							if (defined ("DOING_AJAX") && DOING_AJAX && !empty ($_REQUEST["action"]) && (did_action ("wp_ajax_nopriv_" . $_REQUEST["action"]) || did_action ("wp_ajax_" . $_REQUEST["action"])))
								return apply_filters ("_ws_plugin__s2member_is_admin_ajax_search", true, get_defined_vars ());
						/**/
						return apply_filters ("_ws_plugin__s2member_is_admin_ajax_search", false, get_defined_vars ());
					}
			}
	}
?>