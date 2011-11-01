<?php
/**
* s2Member's Post protection routines *( for current Post )*.
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
* @package s2Member\Posts
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_posts"))
	{
		/**
		* s2Member's Post protection routines *( for current Post )*.
		*
		* @package s2Member\Posts
		* @since 3.5
		*/
		class c_ws_plugin__s2member_posts
			{
				/**
				* Handles Post Level Access permissions *( for current Post )*.
				*
				* @package s2Member\Posts
				* @since 3.5
				*
				* @return null Or exits script execution after redirection.
				*/
				public static function check_post_level_access ()
					{
						global $post; /* ``get_the_ID()`` unavailable outside The Loop. */
						/**/
						do_action ("ws_plugin__s2member_before_check_post_level_access", get_defined_vars ());
						/**/
						$excluded = apply_filters ("ws_plugin__s2member_check_post_level_access_excluded", false, get_defined_vars ());
						/**/
						if (!$excluded && is_single () && is_object ($post) && ($post_id = (int)$post->ID) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
							{
								if (!c_ws_plugin__s2member_systematics::is_wp_systematic_use_page ()) /* Do NOT touch WordPress® Systematics. This excludes all WordPress® Systematics. */
									{
										$user = (is_user_logged_in () && is_object ($user = wp_get_current_user ()) && !empty ($user->ID)) ? $user : false; /* Current User's object. */
										/**/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"] && ($login_redirection_uri = c_ws_plugin__s2member_login_redirects::login_redirection_uri ($user, "root-returns-false")) && preg_match ("/^" . preg_quote ($login_redirection_uri, "/") . "$/", $_SERVER["REQUEST_URI"]) && c_ws_plugin__s2member_no_cache::no_cache_constants (true) && (!$user || !$user->has_cap ("access_s2member_level0")))
											wp_redirect (add_query_arg (urlencode_deep (array ("_s2member_seeking[post]" => $post_id, "_s2member_seeking[req_level]" => "0", "_s2member_seeking[_uri]" => base64_encode ($_SERVER["REQUEST_URI"]), "s2member_seeking" => "post-" . $post_id, "s2member_level_req" => "0")), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) . exit ();
										/**/
										else if (!c_ws_plugin__s2member_systematics::is_systematic_use_page ()) /* Do NOT protect Systematics. However, there is 1 exception above. */
											{
												for ($n = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n >= 0; $n--) /* Post Level restrictions ( including Custom Post Types ). Go through each Level. */
													{
														if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_posts"] === "all" && c_ws_plugin__s2member_no_cache::no_cache_constants (true) && (!$user || !$user->has_cap ("access_s2member_level" . $n)))
															wp_redirect (add_query_arg (urlencode_deep (array ("_s2member_seeking[post]" => $post_id, "_s2member_seeking[req_level]" => $n, "_s2member_seeking[_uri]" => base64_encode ($_SERVER["REQUEST_URI"]), "s2member_seeking" => "post-" . $post_id, "s2member_level_req" => $n)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) . exit ();
														/**/
														else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_posts"] && in_array ($post_id, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_posts"])) && c_ws_plugin__s2member_no_cache::no_cache_constants (true) && (!$user || !$user->has_cap ("access_s2member_level" . $n)))
															wp_redirect (add_query_arg (urlencode_deep (array ("_s2member_seeking[post]" => $post_id, "_s2member_seeking[req_level]" => $n, "_s2member_seeking[_uri]" => base64_encode ($_SERVER["REQUEST_URI"]), "s2member_seeking" => "post-" . $post_id, "s2member_level_req" => $n)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) . exit ();
													}
												/**/
												for ($n = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n >= 0; $n--) /* Category Level restrictions. Go through each Level. */
													{
														if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_catgs"] === "all" && c_ws_plugin__s2member_no_cache::no_cache_constants (true) && (!$user || !$user->has_cap ("access_s2member_level" . $n)))
															wp_redirect (add_query_arg (urlencode_deep (array ("_s2member_seeking[post]" => $post_id, "_s2member_seeking[req_level]" => $n, "_s2member_seeking[_uri]" => base64_encode ($_SERVER["REQUEST_URI"]), "s2member_seeking" => "post-" . $post_id, "s2member_level_req" => $n)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) . exit ();
														/**/
														else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_catgs"] && (in_category (($catgs = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_catgs"])), $post_id) || c_ws_plugin__s2member_utils_conds::in_descendant_category ($catgs, $post_id)) && c_ws_plugin__s2member_no_cache::no_cache_constants (true) && (!$user || !$user->has_cap ("access_s2member_level" . $n)))
															wp_redirect (add_query_arg (urlencode_deep (array ("_s2member_seeking[post]" => $post_id, "_s2member_seeking[req_level]" => $n, "_s2member_seeking[_uri]" => base64_encode ($_SERVER["REQUEST_URI"]), "s2member_seeking" => "post-" . $post_id, "s2member_level_req" => $n)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) . exit ();
													}
												/**/
												if (has_tag ()) /* Here we take a look to see if this Post has any Tags. If so, we need to run the full set of routines against Tags also. */
													{
														for ($n = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n >= 0; $n--) /* Tag Level restrictions. Go through each Level. */
															{
																if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_ptags"] === "all" && c_ws_plugin__s2member_no_cache::no_cache_constants (true) && (!$user || !$user->has_cap ("access_s2member_level" . $n)))
																	wp_redirect (add_query_arg (urlencode_deep (array ("_s2member_seeking[post]" => $post_id, "_s2member_seeking[req_level]" => $n, "_s2member_seeking[_uri]" => base64_encode ($_SERVER["REQUEST_URI"]), "s2member_seeking" => "post-" . $post_id, "s2member_level_req" => $n)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) . exit ();
																/**/
																else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_ptags"] && has_tag (preg_split ("/[\r\n\t;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_ptags"])) && c_ws_plugin__s2member_no_cache::no_cache_constants (true) && (!$user || !$user->has_cap ("access_s2member_level" . $n)))
																	wp_redirect (add_query_arg (urlencode_deep (array ("_s2member_seeking[post]" => $post_id, "_s2member_seeking[req_level]" => $n, "_s2member_seeking[_uri]" => base64_encode ($_SERVER["REQUEST_URI"]), "s2member_seeking" => "post-" . $post_id, "s2member_level_req" => $n)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) . exit ();
															}
													}
												/**/
												for ($n = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n >= 0; $n--) /* URIs. Go through each Level. */
													{
														if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_ruris"]) /* URIs configured at this Level? */
															/**/
															foreach (preg_split ("/[\r\n\t]+/", c_ws_plugin__s2member_ruris::fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_ruris"], $user)) as $str)
																if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $_SERVER["REQUEST_URI"]) && c_ws_plugin__s2member_no_cache::no_cache_constants (true) && (!$user || !$user->has_cap ("access_s2member_level" . $n)))
																	wp_redirect (add_query_arg (urlencode_deep (array ("_s2member_seeking[post]" => $post_id, "_s2member_seeking[req_level]" => $n, "_s2member_seeking[_uri]" => base64_encode ($_SERVER["REQUEST_URI"]), "s2member_seeking" => "post-" . $post_id, "s2member_level_req" => $n)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) . exit ();
													}
												/**/
												if (is_array ($ccaps_req = get_post_meta ($post_id, "s2member_ccaps_req", true)) && !empty ($ccaps_req) && c_ws_plugin__s2member_no_cache::no_cache_constants (true))
													{
														foreach ($ccaps_req as $ccap) /* The ``$user`` MUST satisfy ALL Custom Capability requirements. Stored as a serialized array. */
															if (strlen ($ccap) && (!$user || !$user->has_cap ("access_s2member_ccap_" . $ccap)))
																wp_redirect (add_query_arg (urlencode_deep (array ("_s2member_seeking[post]" => $post_id, "_s2member_seeking[req_ccap]" => $ccap, "_s2member_seeking[_uri]" => base64_encode ($_SERVER["REQUEST_URI"]), "s2member_seeking" => "post-" . $post_id, "s2member_ccap_req" => $ccap)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) . exit ();
													}
												/**/
												if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"] && in_array ($post_id, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"])) && c_ws_plugin__s2member_no_cache::no_cache_constants (true) && !c_ws_plugin__s2member_sp_access::sp_access ($post_id))
													wp_redirect (add_query_arg (urlencode_deep (array ("_s2member_seeking[post]" => $post_id, "_s2member_seeking[req_sp]" => $post_id, "_s2member_seeking[_uri]" => base64_encode ($_SERVER["REQUEST_URI"]), "s2member_seeking" => "post-" . $post_id, "s2member_sp_req" => $post_id)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ())) . exit ();
											}
										/**/
										do_action ("ws_plugin__s2member_during_check_post_level_access", get_defined_vars ());
									}
							}
						/**/
						do_action ("ws_plugin__s2member_after_check_post_level_access", get_defined_vars ());
						/**/
						return; /* For uniformity. */
					}
			}
	}
?>