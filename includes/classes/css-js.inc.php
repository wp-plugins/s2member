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
if (!class_exists ("c_ws_plugin__s2member_css_js"))
	{
		class c_ws_plugin__s2member_css_js
			{
				/*
				Adds CSS files.
				Attach to: add_action("wp_print_styles");
				*/
				public static function add_css ()
					{
						do_action ("ws_plugin__s2member_before_add_css", get_defined_vars ());
						/**/
						if (!is_admin ()) /* Not in the admin. */
							{
								wp_enqueue_style ("ws-plugin--s2member", site_url ("/?ws_plugin__s2member_css=1&qcABC=1"), array (), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"], "all");
								/**/
								do_action ("ws_plugin__s2member_during_add_css", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_after_add_css", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Builds CSS files.
				Attach to: add_action("init");
				*/
				public static function css ()
					{
						do_action ("ws_plugin__s2member_before_css", get_defined_vars ());
						/**/
						if ($_GET["ws_plugin__s2member_css"])
							{
								header ("Content-Type: text/css; charset=utf-8");
								header ("Expires: " . gmdate ("D, d M Y H:i:s", strtotime ("+1 week")) . " GMT");
								header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
								header ("Cache-Control: max-age=604800");
								header ("Pragma: public");
								/**/
								$u = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"];
								$i = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images";
								/**/
								ob_start ("c_ws_plugin__s2member_utils_css::compress_css"); /* Compress. */
								/**/
								include_once dirname (dirname (__FILE__)) . "/s2member.css";
								/**/
								do_action ("ws_plugin__s2member_during_css", get_defined_vars ());
								/**/
								exit (); /* Clean exit. */
							}
						/**/
						do_action ("ws_plugin__s2member_after_css", get_defined_vars ());
					}
				/*
				Adds JavaScript files.
				Attach to: add_action("wp_print_scripts");
				*/
				public static function add_js_w_globals ()
					{
						global $pagenow; /* Need this for comparisons. */
						/**/
						do_action ("ws_plugin__s2member_before_add_js_w_globals", get_defined_vars ());
						/**/
						if (!is_admin () || (c_ws_plugin__s2member_utils_conds::is_user_admin () && $pagenow === "profile.php" && !current_user_can ("edit_users")))
							{
								if (is_user_logged_in ()) /* Separate version for logged-in Users/Members. */
									{
										$md5 = WS_PLUGIN__S2MEMBER_API_CONSTANTS_MD5; /* An MD5 hash based on global key => values. */
										/* The MD5 hash allows the script to be cached in the browser until the globals happen to change. */
										/* For instance, the global variables may change when a User who is logged-in changes their Profile. */
										wp_enqueue_script ("ws-plugin--s2member", site_url ("/?ws_plugin__s2member_js_w_globals=1&qcABC=1&" . $md5), array ("jquery"), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"]);
									}
								else /* Else if they are not logged in, we distinguish the JavaScript file by NOT including $md5. */
									{ /* This essentially creates 2 versions of the script. One while logged in & another when not. */
										wp_enqueue_script ("ws-plugin--s2member", site_url ("/?ws_plugin__s2member_js_w_globals=1&qcABC=1"), array ("jquery"), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"]);
									}
								/**/
								do_action ("ws_plugin__s2member_during_add_js_w_globals", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_after_add_js_w_globals", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Builds JavaScript files.
				Attach to: add_action("init");
				*/
				public static function js_w_globals ()
					{
						do_action ("ws_plugin__s2member_before_js_w_globals", get_defined_vars ());
						/**/
						if ($_GET["ws_plugin__s2member_js_w_globals"])
							{
								header ("Content-Type: text/javascript; charset=utf-8");
								header ("Expires: " . gmdate ("D, d M Y H:i:s", strtotime ("+1 week")) . " GMT");
								header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
								header ("Cache-Control: max-age=604800");
								header ("Pragma: public");
								/**/
								$g = "var S2MEMBER_VERSION = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_VERSION) . "',"; /* Since 3.0. */
								/**/
								$g .= "S2MEMBER_CURRENT_USER_IS_LOGGED_IN = " . ((S2MEMBER_CURRENT_USER_IS_LOGGED_IN) ? "true" : "false") . ",";
								$g .= "S2MEMBER_CURRENT_USER_IS_LOGGED_IN_AS_MEMBER = " . ((S2MEMBER_CURRENT_USER_IS_LOGGED_IN_AS_MEMBER) ? "true" : "false") . ",";
								$g .= "S2MEMBER_CURRENT_USER_ACCESS_LEVEL = " . S2MEMBER_CURRENT_USER_ACCESS_LEVEL . ",";
								$g .= "S2MEMBER_CURRENT_USER_ACCESS_LABEL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_CURRENT_USER_ACCESS_LABEL) . "',";
								$g .= "S2MEMBER_CURRENT_USER_SUBSCR_ID = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_CURRENT_USER_SUBSCR_ID) . "',";
								$g .= "S2MEMBER_CURRENT_USER_CUSTOM = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_CURRENT_USER_CUSTOM) . "',";
								$g .= "S2MEMBER_CURRENT_USER_REGISTRATION_TIME = " . S2MEMBER_CURRENT_USER_REGISTRATION_TIME . ",";
								$g .= "S2MEMBER_CURRENT_USER_PAID_REGISTRATION_TIME = " . S2MEMBER_CURRENT_USER_PAID_REGISTRATION_TIME . ",";
								$g .= "S2MEMBER_CURRENT_USER_PAID_REGISTRATION_DAYS = " . S2MEMBER_CURRENT_USER_PAID_REGISTRATION_DAYS . ",";
								$g .= "S2MEMBER_CURRENT_USER_REGISTRATION_DAYS = " . S2MEMBER_CURRENT_USER_REGISTRATION_DAYS . ",";
								$g .= "S2MEMBER_CURRENT_USER_DISPLAY_NAME = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_CURRENT_USER_DISPLAY_NAME) . "',";
								$g .= "S2MEMBER_CURRENT_USER_FIRST_NAME = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_CURRENT_USER_FIRST_NAME) . "',";
								$g .= "S2MEMBER_CURRENT_USER_LAST_NAME = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_CURRENT_USER_LAST_NAME) . "',";
								$g .= "S2MEMBER_CURRENT_USER_LOGIN = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_CURRENT_USER_LOGIN) . "',";
								$g .= "S2MEMBER_CURRENT_USER_EMAIL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_CURRENT_USER_EMAIL) . "',";
								$g .= "S2MEMBER_CURRENT_USER_IP = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_CURRENT_USER_IP) . "',";
								$g .= "S2MEMBER_CURRENT_USER_ID = " . S2MEMBER_CURRENT_USER_ID . ",";
								$g .= "S2MEMBER_CURRENT_USER_FIELDS = " . S2MEMBER_CURRENT_USER_FIELDS . ",";
								/**/
								$g .= "S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED = " . S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED . ",";
								$g .= "S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_IS_UNLIMITED = " . ((S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_IS_UNLIMITED) ? "true" : "false") . ",";
								$g .= "S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY = " . S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY . ",";
								$g .= "S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS = " . S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS . ",";
								/**/
								$g .= "S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_ID = " . S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_ID . ",";
								$g .= "S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_ID = " . S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_ID . ",";
								$g .= "S2MEMBER_LOGIN_WELCOME_PAGE_ID = " . S2MEMBER_LOGIN_WELCOME_PAGE_ID . ",";
								/**/
								$g .= "S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL) . "',";
								$g .= "S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_URL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_URL) . "',";
								$g .= "S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_URL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_URL) . "',";
								$g .= "S2MEMBER_LOGIN_WELCOME_PAGE_URL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_LOGIN_WELCOME_PAGE_URL) . "',";
								$g .= "S2MEMBER_LOGOUT_PAGE_URL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_LOGOUT_PAGE_URL) . "',";
								$g .= "S2MEMBER_LOGIN_PAGE_URL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_LOGIN_PAGE_URL) . "',";
								/**/
								$g .= "S2MEMBER_LEVEL0_LABEL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_LEVEL0_LABEL) . "',";
								$g .= "S2MEMBER_LEVEL1_LABEL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_LEVEL1_LABEL) . "',";
								$g .= "S2MEMBER_LEVEL2_LABEL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_LEVEL2_LABEL) . "',";
								$g .= "S2MEMBER_LEVEL3_LABEL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_LEVEL3_LABEL) . "',";
								$g .= "S2MEMBER_LEVEL4_LABEL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_LEVEL4_LABEL) . "',";
								/**/
								$g .= "S2MEMBER_LEVEL0_FILE_DOWNLOADS_ALLOWED = " . S2MEMBER_LEVEL0_FILE_DOWNLOADS_ALLOWED . ",";
								$g .= "S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED = " . S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED . ",";
								$g .= "S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED = " . S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED . ",";
								$g .= "S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED = " . S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED . ",";
								$g .= "S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED = " . S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED . ",";
								/**/
								$g .= "S2MEMBER_LEVEL0_FILE_DOWNLOADS_ALLOWED_DAYS = " . S2MEMBER_LEVEL0_FILE_DOWNLOADS_ALLOWED_DAYS . ",";
								$g .= "S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED_DAYS = " . S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED_DAYS . ",";
								$g .= "S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED_DAYS = " . S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED_DAYS . ",";
								$g .= "S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED_DAYS = " . S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED_DAYS . ",";
								$g .= "S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED_DAYS = " . S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED_DAYS . ",";
								/**/
								$g .= "S2MEMBER_FILE_DOWNLOAD_INLINE_EXTENSIONS = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_FILE_DOWNLOAD_INLINE_EXTENSIONS) . "',";
								/**/
								$g .= "S2MEMBER_REG_EMAIL_FROM_NAME = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_REG_EMAIL_FROM_NAME) . "',";
								$g .= "S2MEMBER_REG_EMAIL_FROM_EMAIL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_REG_EMAIL_FROM_EMAIL) . "',";
								/**/
								$g .= "S2MEMBER_PAYPAL_NOTIFY_URL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_PAYPAL_NOTIFY_URL) . "',";
								$g .= "S2MEMBER_PAYPAL_RETURN_URL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_PAYPAL_RETURN_URL) . "',";
								/**/
								$g .= "S2MEMBER_PAYPAL_BUSINESS = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_PAYPAL_BUSINESS) . "',";
								$g .= "S2MEMBER_PAYPAL_ENDPOINT = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_PAYPAL_ENDPOINT) . "',";
								$g .= "S2MEMBER_PAYPAL_API_ENDPOINT = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_PAYPAL_API_ENDPOINT) . "',";
								/**/
								$g .= "S2MEMBER_CURRENT_USER_VALUE_FOR_PP_ON0 = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_CURRENT_USER_VALUE_FOR_PP_ON0) . "',";
								$g .= "S2MEMBER_CURRENT_USER_VALUE_FOR_PP_OS0 = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_CURRENT_USER_VALUE_FOR_PP_OS0) . "',";
								/**/
								$g = trim ($g, " ,") . ";"; /* Trim & add semicolon. */
								/**/
								$u = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"];
								$i = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images";
								/**/
								echo $g . "\n"; /* Add a line break before inclusion. */
								/**/
								include_once dirname (dirname (__FILE__)) . "/s2member-min.js";
								/**/
								do_action ("ws_plugin__s2member_during_js_w_globals", get_defined_vars ());
								/**/
								exit (); /* Clean exit. */
							}
						/**/
						do_action ("ws_plugin__s2member_after_js_w_globals", get_defined_vars ());
					}
			}
	}
?>