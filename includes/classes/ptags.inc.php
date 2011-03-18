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
if (!class_exists ("c_ws_plugin__s2member_ptags"))
	{
		class c_ws_plugin__s2member_ptags
			{
				/*
				Handles Tag Level Access permissions.
				
				Don't call this function directly, use one of these API functions:
					
					Is it protected by s2Member at all?
					- is_tag_protected_by_s2member($tag_id [ or slug, or tag name ]);
					- is_protected_by_s2member($tag_id [ or slug, or tag name ], "tag");
					
					Is the current User permitted/authorized?
					- is_tag_permitted_by_s2member($tag_id [ or slug, or tag name ]);
					- is_permitted_by_s2member($tag_id [ or slug, or tag name ], "tag");
				
				See: `/s2member/includes/functions/api-functions.inc.php`.
				*/
				public static function check_ptag_level_access ()
					{
						global $wp_query, $post; /* get_the_ID() is NOT available outside The Loop. */
						/**/
						do_action ("ws_plugin__s2member_before_check_ptag_level_access", get_defined_vars ());
						/**/
						$excluded = apply_filters ("ws_plugin__s2member_check_ptag_level_access_excluded", false, get_defined_vars ());
						/**/
						if (!$excluded && is_tag () && is_object ($tag = $wp_query->get_queried_object ()) && ($tag_id = $tag->term_id) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
							{
								$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Get the current User's object. */
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"] && ($login_redirection_uri = c_ws_plugin__s2member_login_redirects::login_redirection_uri ($current_user)) && preg_match ("/^" . preg_quote ($login_redirection_uri, "/") . "$/", $_SERVER["REQUEST_URI"]) && c_ws_plugin__s2member_nocache::nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level0")))
									{
										wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "ptag-" . $tag_id, "s2member_level_req" => "0")), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
										exit ();
									}
								else if (!c_ws_plugin__s2member_systematics::is_systematic_use_page ()) /* Do NOT protect Systematics. However, there is 1 exception above ^. */
									{
										for ($i = 0; $i <= 4; $i++) /* Tag Level restrictions. Go through each Membership Level. This is pretty simple. We're just checking Tags. */
											{
												if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ptags"] === "all" && c_ws_plugin__s2member_nocache::nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
													{
														wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "ptag-" . $tag_id, "s2member_level_req" => $i)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
														exit ();
													}
												/**/
												else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ptags"] && (is_tag ($tags = preg_split ("/[\r\n\t;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ptags"])) || in_array ($tag_id, $tags)) && c_ws_plugin__s2member_nocache::nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
													{
														wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "ptag-" . $tag_id, "s2member_level_req" => $i)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
														exit ();
													}
											}
										/**/
										for ($i = 0; $i <= 4; $i++) /* URIs. Go through each Membership Level. */
											{
												if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ruris"])
													foreach (preg_split ("/[\r\n\t]+/", c_ws_plugin__s2member_ruris::fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ruris"], $current_user)) as $str)
														if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $_SERVER["REQUEST_URI"]) && c_ws_plugin__s2member_nocache::nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
															{
																wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "ptag-" . $tag_id, "s2member_level_req" => $i)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
																exit ();
															}
											}
									}
								/**/
								do_action ("ws_plugin__s2member_during_check_ptag_level_access", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_after_check_ptag_level_access", get_defined_vars ());
						/**/
						return; /* For uniformity. */
					}
			}
	}
?>