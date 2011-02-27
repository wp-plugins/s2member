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
if (!class_exists ("c_ws_plugin__s2member_meta_box_saves"))
	{
		class c_ws_plugin__s2member_meta_box_saves
			{
				/*
				Function save data entered into meta boxes,
					on Post/Page editing stations.
				Attach to: add_action("save_post");
				*/
				public static function save_meta_boxes ($post_id = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_save_meta_boxes", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($post_id && ($nonce = $_POST["ws_plugin__s2member_security_meta_box_save"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-security-meta-box-save"))
							if ($post_id == $_POST["ws_plugin__s2member_security_meta_box_save_id"]) /* Do NOT process historical revisions. */
								/* We do NOT process historical revisions here; because it causes confusion in the General Options panel for s2Member. */
								{
									$_p = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($_POST)); /* Clean and create a local copy. */
									/**/
									if (($_p["post_type"] === "page" && current_user_can ("edit_page", $post_id)) || current_user_can ("edit_post", $post_id))
										{
											if ($_p["post_type"] === "page" && ($page_id = $post_id)) /* OK. So we're dealing with a Page classification. */
												{
													if (isset ($_p["ws_plugin__s2member_security_meta_box_level"])) /* Just needs to be set. It CAN be empty. */
														{
															$pages["0"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_pages"]));
															$pages["1"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_pages"]));
															$pages["2"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_pages"]));
															$pages["3"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_pages"]));
															$pages["4"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_pages"]));
															/**/
															if (($i = array_search ($page_id, $pages["0"])) !== false) /* Remove $page_id from existing options. */
																unset ($pages["0"][$i]);
															else if (($i = array_search ($page_id, $pages["1"])) !== false)
																unset ($pages["1"][$i]);
															else if (($i = array_search ($page_id, $pages["2"])) !== false)
																unset ($pages["2"][$i]);
															else if (($i = array_search ($page_id, $pages["3"])) !== false)
																unset ($pages["3"][$i]);
															else if (($i = array_search ($page_id, $pages["4"])) !== false)
																unset ($pages["4"][$i]);
															/**/
															if (strlen ($_p["ws_plugin__s2member_security_meta_box_level"]) && is_array ($pages[$_p["ws_plugin__s2member_security_meta_box_level"]]))
																if (!$pages[$_p["ws_plugin__s2member_security_meta_box_level"]] !== array ("all"))
																	array_push ($pages[$_p["ws_plugin__s2member_security_meta_box_level"]], $page_id);
															/**/
															$new_options = array_merge ((array)$new_options, array ("ws_plugin__s2member_level0_pages" => implode (",", $pages[0]), "ws_plugin__s2member_level1_pages" => implode (",", $pages[1]), "ws_plugin__s2member_level2_pages" => implode (",", $pages[2]), "ws_plugin__s2member_level3_pages" => implode (",", $pages[3]), "ws_plugin__s2member_level4_pages" => implode (",", $pages[4])));
															/**/
															eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
															do_action ("ws_plugin__s2member_during_save_meta_boxes", get_defined_vars ());
															unset ($__refs, $__v); /* Unset defined __refs, __v. */
															/**/
															c_ws_plugin__s2member_menu_pages::update_all_options ($new_options, true, false, array ("page-conflict-warnings"), true);
														}
												}
											/**/
											else /* Otherwise, we assume this is a Post, or possibly a Custom Post Type. It's NOT a Page. */
												{
													if (isset ($_p["ws_plugin__s2member_security_meta_box_level"])) /* Just needs to be set. It CAN be empty. */
														{
															$posts["0"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_posts"]));
															$posts["1"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_posts"]));
															$posts["2"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_posts"]));
															$posts["3"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_posts"]));
															$posts["4"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_posts"]));
															/**/
															if (($i = array_search ($post_id, $posts["0"])) !== false) /* Remove $post_id from existing options. */
																unset ($posts["0"][$i]);
															else if (($i = array_search ($post_id, $posts["1"])) !== false)
																unset ($posts["1"][$i]);
															else if (($i = array_search ($post_id, $posts["2"])) !== false)
																unset ($posts["2"][$i]);
															else if (($i = array_search ($post_id, $posts["3"])) !== false)
																unset ($posts["3"][$i]);
															else if (($i = array_search ($post_id, $posts["4"])) !== false)
																unset ($posts["4"][$i]);
															/**/
															if (strlen ($_p["ws_plugin__s2member_security_meta_box_level"]) && is_array ($posts[$_p["ws_plugin__s2member_security_meta_box_level"]]))
																if (!$posts[$_p["ws_plugin__s2member_security_meta_box_level"]] !== array ("all"))
																	array_push ($posts[$_p["ws_plugin__s2member_security_meta_box_level"]], $post_id);
															/**/
															$new_options = array_merge ((array)$new_options, array ("ws_plugin__s2member_level0_posts" => implode (",", $posts[0]), "ws_plugin__s2member_level1_posts" => implode (",", $posts[1]), "ws_plugin__s2member_level2_posts" => implode (",", $posts[2]), "ws_plugin__s2member_level3_posts" => implode (",", $posts[3]), "ws_plugin__s2member_level4_posts" => implode (",", $posts[4])));
															/**/
															eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
															do_action ("ws_plugin__s2member_during_save_meta_boxes", get_defined_vars ());
															unset ($__refs, $__v); /* Unset defined __refs, __v. */
															/**/
															c_ws_plugin__s2member_menu_pages::update_all_options ($new_options, true, false, array ("page-conflict-warnings"), true);
														}
												}
											/**/
											if ($_p["post_type"] === "page" && ($page_id = $post_id)) /* OK. So we're dealing with a Page classification. */
												{
													if (isset ($_p["ws_plugin__s2member_security_meta_box_ccaps"])) /* Just needs to be set. It CAN be empty. */
														{
															$ccaps_req = trim (strtolower ($_p["ws_plugin__s2member_security_meta_box_ccaps"]), ",");
															$ccaps_req = trim (preg_replace ("/[^a-z_0-9,]/", "", $ccaps_req), ","); /* Now clean up. */
															/**/
															if (strlen ($ccaps_req) && ($s2member_ccaps_req = preg_split ("/[\r\n\t\s;,]+/", $ccaps_req)))
																update_post_meta ($page_id, "s2member_ccaps_req", $s2member_ccaps_req);
															/**/
															else /* Otherwise, the array is empty. Safe to delete. */
																delete_post_meta ($page_id, "s2member_ccaps_req");
														}
												}
											/**/
											else /* Otherwise, we assume this is a Post, or possibly a Custom Post Type. It's NOT a Page. */
												{
													if (isset ($_p["ws_plugin__s2member_security_meta_box_ccaps"])) /* Just needs to be set. It CAN be empty. */
														{
															$ccaps_req = trim (strtolower ($_p["ws_plugin__s2member_security_meta_box_ccaps"]), ",");
															$ccaps_req = trim (preg_replace ("/[^a-z_0-9,]/", "", $ccaps_req), ","); /* Now clean up. */
															/**/
															if (strlen ($ccaps_req) && ($s2member_ccaps_req = preg_split ("/[\r\n\t\s;,]+/", $ccaps_req)))
																update_post_meta ($post_id, "s2member_ccaps_req", $s2member_ccaps_req);
															/**/
															else /* Otherwise, the array is empty. Safe to delete. */
																delete_post_meta ($post_id, "s2member_ccaps_req");
														}
												}
										}
								}
						/**/
						do_action ("ws_plugin__s2member_after_save_meta_boxes", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>