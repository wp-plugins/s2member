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
if (!class_exists ("c_ws_plugin__s2member_css_js_in"))
	{
		class c_ws_plugin__s2member_css_js_in
			{
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
								ob_start ("c_ws_plugin__s2member_utils_css::compress_css");
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
				Builds JavaScript files.
				Attach to: add_action("init");
				* Be sure s2Member's API Constants are already defined before firing this.
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
								$g = "var S2MEMBER_VERSION = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_VERSION) . "',";
								/**/
								$g .= "S2MEMBER_CURRENT_USER_IS_LOGGED_IN = " . ((S2MEMBER_CURRENT_USER_IS_LOGGED_IN) ? "true" : "false") . ",";
								$g .= "S2MEMBER_CURRENT_USER_IS_LOGGED_IN_AS_MEMBER = " . ((S2MEMBER_CURRENT_USER_IS_LOGGED_IN_AS_MEMBER) ? "true" : "false") . ",";
								$g .= "S2MEMBER_CURRENT_USER_ACCESS_LEVEL = " . S2MEMBER_CURRENT_USER_ACCESS_LEVEL . ",";
								$g .= "S2MEMBER_CURRENT_USER_ACCESS_LABEL = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_CURRENT_USER_ACCESS_LABEL) . "',";
								$g .= "S2MEMBER_CURRENT_USER_SUBSCR_ID = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_CURRENT_USER_SUBSCR_ID) . "',";
								$g .= "S2MEMBER_CURRENT_USER_SUBSCR_OR_WP_ID = '" . c_ws_plugin__s2member_utils_strings::esc_sq (S2MEMBER_CURRENT_USER_SUBSCR_OR_WP_ID) . "',";
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