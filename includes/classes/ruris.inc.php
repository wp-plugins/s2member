<?php
/**
* s2Member's URI protection routines *( for current URI )*.
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
* @package s2Member\URIs
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_ruris"))
	{
		/**
		* s2Member's URI protection routines *( for current URI )*.
		*
		* @package s2Member\URIs
		* @since 3.5
		*/
		class c_ws_plugin__s2member_ruris
			{
				/**
				* Handles URI Level Access permissions *( for current URI )*.
				*
				* @package s2Member\URIs
				* @since 3.5
				*
				* @return null Or exits script execution after redirection.
				*/
				public static function check_ruri_level_access ()
					{
						do_action ("ws_plugin__s2member_before_check_ruri_level_access", get_defined_vars ());
						/**/
						$excluded = apply_filters ("ws_plugin__s2member_check_ruri_level_access_excluded", false, get_defined_vars ());
						/**/
						if (!$excluded && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]) /* Has it been excluded? */
							{
								$user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Get the current User's object. */
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"] && ($login_redirection_uri = c_ws_plugin__s2member_login_redirects::login_redirection_uri ($user, "root-returns-false")) && preg_match ("/^" . preg_quote ($login_redirection_uri, "/") . "$/", $_SERVER["REQUEST_URI"]) && c_ws_plugin__s2member_no_cache::no_cache_constants (true) !== "nill" && (!$user || !current_user_can ("access_s2member_level0")))
									{
										wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "ruri-" . base64_encode ($_SERVER["REQUEST_URI"]), "s2member_level_req" => "0")), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
										exit ();
									}
								else if (!c_ws_plugin__s2member_systematics::is_systematic_use_page ()) /* Do NOT protect Systematics. However, there is 1 exception above ^. */
									{
										for ($n = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n >= 0; $n--) /* URIs. Go through each Level. */
											{
												if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_ruris"])
													foreach (preg_split ("/[\r\n\t]+/", c_ws_plugin__s2member_ruris::fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_ruris"], $user)) as $str)
														if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $_SERVER["REQUEST_URI"]) && c_ws_plugin__s2member_no_cache::no_cache_constants (true) !== "nill" && (!$user || !current_user_can ("access_s2member_level" . $n)))
															{
																wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "ruri-" . base64_encode ($_SERVER["REQUEST_URI"]), "s2member_level_req" => $n)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
																exit ();
															}
											}
									}
								/**/
								do_action ("ws_plugin__s2member_during_check_ruri_level_access", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_after_check_ruri_level_access", get_defined_vars ());
						/**/
						return; /* For uniformity. */
					}
				/**
				* Fills Replacement Code variables in URIs; collectively.
				*
				* @package s2Member\URIs
				* @since 3.5
				*
				* @return str Collective string of input URIs, with Replacement Codes having been filled.
				*/
				public static function fill_ruri_level_access_rc_vars ($uris = FALSE, $user = FALSE)
					{
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_fill_ruri_level_access_rc_vars", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$orig_uris = $uris; /* Record the original URIs that were passed in; collectively. */
						/**/
						$user = ((is_object ($user) || is_object ($user = (is_user_logged_in ()) ? wp_get_current_user () : false)) && !empty ($user->ID)) ? $user : false;
						/**/
						$user_login = ($user) ? (string)strtolower ($user->user_login) : "";
						$user_id = ($user) ? (string)$user->ID : "";
						/**/
						$user_level = (string)c_ws_plugin__s2member_user_access::user_access_level ($user);
						$user_role = (string)c_ws_plugin__s2member_user_access::user_access_role ($user);
						$user_ccaps = (string)implode ("-", c_ws_plugin__s2member_user_access::user_access_ccaps ($user));
						$user_logins = ($user) ? (string)(int)get_user_option ("s2member_login_counter", $user_id) : "-1";
						/**/
						$uris = (strlen ($user_login)) ? preg_replace ("/%%current_user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_login), $uris) : $uris;
						$uris = (strlen ($user_id)) ? preg_replace ("/%%current_user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_id), $uris) : $uris;
						$uris = (strlen ($user_level)) ? preg_replace ("/%%current_user_level%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_level), $uris) : $uris;
						$uris = (strlen ($user_role)) ? preg_replace ("/%%current_user_role%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_role), $uris) : $uris;
						$uris = (strlen ($user_ccaps)) ? preg_replace ("/%%current_user_ccaps%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_ccaps), $uris) : $uris;
						$uris = (strlen ($user_logins)) ? preg_replace ("/%%current_user_logins%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_logins), $uris) : $uris;
						/**/
						return apply_filters ("ws_plugin__s2member_fill_ruri_level_access_rc_vars", $uris, get_defined_vars ());
					}
			}
	}
?>