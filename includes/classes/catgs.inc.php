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
if (!class_exists ("c_ws_plugin__s2member_catgs"))
	{
		class c_ws_plugin__s2member_catgs
			{
				/*
				Function for handling Category Level Access permissions.
				Attach to: add_action("template_redirect");
				
				Don't call this function directly, use one of these API functions:
					
					Is it protected by s2Member at all?
					- is_category_protected_by_s2member($cat_id);
					- is_protected_by_s2member($cat_id, "category");
					
					Is the current User permitted/authorized?
					- is_category_permitted_by_s2member($cat_id);
					- is_permitted_by_s2member($cat_id, "category");
				
				see: `/s2member/includes/functions/api-functions.inc.php`.
				*/
				public static function check_catg_level_access ()
					{
						global $post; /* get_the_ID() is NOT available outside The Loop. */
						/**/
						do_action ("ws_plugin__s2member_before_check_catg_level_access", get_defined_vars ());
						/**/
						$excluded = apply_filters ("ws_plugin__s2member_check_catg_level_access_excluded", false, get_defined_vars ());
						/**/
						if (!$excluded && is_category () && ($cat_id = get_query_var ("cat")) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
							{
								$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Get the current User's object. */
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"] && ($login_redirection_uri = c_ws_plugin__s2member_login_redirects::login_redirection_uri ($current_user)) && preg_match ("/^" . preg_quote ($login_redirection_uri, "/") . "$/", $_SERVER["REQUEST_URI"]) && c_ws_plugin__s2member_nocache::nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level0")))
									{
										wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "catg-" . $cat_id, "s2member_level_req" => "0")), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
										exit ();
									}
								else if (!c_ws_plugin__s2member_systematics::is_systematic_use_page ()) /* Do NOT protect Systematics. However, there is 1 exception above ^. */
									{
										for ($i = 0; $i <= 4; $i++) /* Category Level restrictions. Go through each Membership Level. We also check nested Categories, using `cat_is_ancestor_of()`. */
											{
												if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_catgs"] === "all" && c_ws_plugin__s2member_nocache::nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
													{
														wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "catg-" . $cat_id, "s2member_level_req" => $i)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
														exit ();
													}
												/**/
												else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_catgs"] && in_array ($cat_id, ($catgs = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_catgs"]))) && c_ws_plugin__s2member_nocache::nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
													{
														wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "catg-" . $cat_id, "s2member_level_req" => $i)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
														exit ();
													}
												/**/
												else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_catgs"]) /* Check Category ancestry. */
													foreach (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_catgs"]) as $catg)
														if ($catg && cat_is_ancestor_of ($catg, $cat_id) && c_ws_plugin__s2member_nocache::nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
															{
																wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "catg-" . $cat_id, "s2member_level_req" => $i)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
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
																wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "catg-" . $cat_id, "s2member_level_req" => $i)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
																exit ();
															}
											}
									}
								/**/
								do_action ("ws_plugin__s2member_during_check_catg_level_access", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_after_check_catg_level_access", get_defined_vars ());
						/**/
						return; /* For uniformity. */
					}
			}
	}
?>