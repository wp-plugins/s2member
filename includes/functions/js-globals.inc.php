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
	exit;
/*
Function for adding script to the header.
This function is fired in the admin area also.
Do NOT enqueue the script in the admin area.
Attach to: add_action("wp_print_scripts");
*/
function ws_plugin__s2member_add_js_w_globals ()
	{
		if (!is_admin ()) /* Not in the admin. */
			{
				if (is_user_logged_in ())
					{
						$a = get_defined_constants (true);
						$c = (array)$a["user"];
						unset ($a);
						/**/
						foreach ($c as $k => $v)
							if (preg_match ("/^S2MEMBER_/i", $k))
								$s2member[$k] = $v;
						/**/
						$md5 = md5 (serialize ($s2member)); /* This is a hash based on the global key => values. */
						/* The md5 hash allows the script to be cached in the browser until the globals happen to change. */
						/* For instance, the global variables may change when a user who is logged-in changes their profile. */
						wp_enqueue_script ("ws-plugin--s2member", get_bloginfo ("url") . "/?ws_plugin__s2member_js_w_globals=1&qcABC=1&" . $md5, array ("jquery"), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"]);
					}
				else /* Else if they are not logged in, we distinguish the script by not including the md5 hash. */
					{ /* This essentially creates 2 versions of the script. One while logged in & another when not. */
						wp_enqueue_script ("ws-plugin--s2member", get_bloginfo ("url") . "/?ws_plugin__s2member_js_w_globals=1&qcABC=1", array ("jquery"), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"]);
					}
			}
		/**/
		return;
	}
/*
Function for adding s2member.js with globals.
Attach to: add_action("init");
*/
function ws_plugin__s2member_js_w_globals ()
	{
		if ($_GET["ws_plugin__s2member_js_w_globals"])
			{
				header ("Content-Type: text/javascript; charset=utf-8");
				header ("Expires: " . gmdate ("D, d M Y H:i:s", strtotime ("+1 week")) . " GMT");
				header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
				header ("Cache-Control: max-age=604800");
				header ("Pragma: public");
				/**/
				$g = "var S2MEMBER_CURRENT_USER_IS_LOGGED_IN = " . ((S2MEMBER_CURRENT_USER_IS_LOGGED_IN) ? "true" : "false") . ",";
				$g .= "S2MEMBER_CURRENT_USER_IS_LOGGED_IN_AS_MEMBER = " . ((S2MEMBER_CURRENT_USER_IS_LOGGED_IN_AS_MEMBER) ? "true" : "false") . ",";
				$g .= "S2MEMBER_CURRENT_USER_ACCESS_LEVEL = " . S2MEMBER_CURRENT_USER_ACCESS_LEVEL . ",";
				$g .= "S2MEMBER_CURRENT_USER_ACCESS_LABEL = '" . preg_replace ("/'/", "\'", S2MEMBER_CURRENT_USER_ACCESS_LABEL) . "',";
				$g .= "S2MEMBER_CURRENT_USER_SUBSCR_ID = '" . preg_replace ("/'/", "\'", S2MEMBER_CURRENT_USER_SUBSCR_ID) . "',";
				$g .= "S2MEMBER_CURRENT_USER_CUSTOM = '" . preg_replace ("/'/", "\'", S2MEMBER_CURRENT_USER_CUSTOM) . "',";
				$g .= "S2MEMBER_CURRENT_USER_REGISTRATION_TIME = " . S2MEMBER_CURRENT_USER_REGISTRATION_TIME . ",";
				$g .= "S2MEMBER_CURRENT_USER_REGISTRATION_DAYS = " . S2MEMBER_CURRENT_USER_REGISTRATION_DAYS . ",";
				$g .= "S2MEMBER_CURRENT_USER_DISPLAY_NAME = '" . preg_replace ("/'/", "\'", S2MEMBER_CURRENT_USER_DISPLAY_NAME) . "',";
				$g .= "S2MEMBER_CURRENT_USER_FIRST_NAME = '" . preg_replace ("/'/", "\'", S2MEMBER_CURRENT_USER_FIRST_NAME) . "',";
				$g .= "S2MEMBER_CURRENT_USER_LAST_NAME = '" . preg_replace ("/'/", "\'", S2MEMBER_CURRENT_USER_LAST_NAME) . "',";
				$g .= "S2MEMBER_CURRENT_USER_LOGIN = '" . preg_replace ("/'/", "\'", S2MEMBER_CURRENT_USER_LOGIN) . "',";
				$g .= "S2MEMBER_CURRENT_USER_EMAIL = '" . preg_replace ("/'/", "\'", S2MEMBER_CURRENT_USER_EMAIL) . "',";
				$g .= "S2MEMBER_CURRENT_USER_IP = '" . preg_replace ("/'/", "\'", S2MEMBER_CURRENT_USER_IP) . "',";
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
				$g .= "S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL = '" . preg_replace ("/'/", "\'", S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL) . "',";
				$g .= "S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_URL = '" . preg_replace ("/'/", "\'", S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_URL) . "',";
				$g .= "S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_URL = '" . preg_replace ("/'/", "\'", S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_URL) . "',";
				$g .= "S2MEMBER_LOGIN_WELCOME_PAGE_URL = '" . preg_replace ("/'/", "\'", S2MEMBER_LOGIN_WELCOME_PAGE_URL) . "',";
				$g .= "S2MEMBER_LOGOUT_PAGE_URL = '" . preg_replace ("/'/", "\'", S2MEMBER_LOGOUT_PAGE_URL) . "',";
				$g .= "S2MEMBER_LOGIN_PAGE_URL = '" . preg_replace ("/'/", "\'", S2MEMBER_LOGIN_PAGE_URL) . "',";
				/**/
				$g .= "S2MEMBER_LEVEL1_LABEL = '" . preg_replace ("/'/", "\'", S2MEMBER_LEVEL1_LABEL) . "',";
				$g .= "S2MEMBER_LEVEL2_LABEL = '" . preg_replace ("/'/", "\'", S2MEMBER_LEVEL2_LABEL) . "',";
				$g .= "S2MEMBER_LEVEL3_LABEL = '" . preg_replace ("/'/", "\'", S2MEMBER_LEVEL3_LABEL) . "',";
				$g .= "S2MEMBER_LEVEL4_LABEL = '" . preg_replace ("/'/", "\'", S2MEMBER_LEVEL4_LABEL) . "',";
				/**/
				$g .= "S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED = " . S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED . ",";
				$g .= "S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED = " . S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED . ",";
				$g .= "S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED = " . S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED . ",";
				$g .= "S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED = " . S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED . ",";
				/**/
				$g .= "S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED_DAYS = " . S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED_DAYS . ",";
				$g .= "S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED_DAYS = " . S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED_DAYS . ",";
				$g .= "S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED_DAYS = " . S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED_DAYS . ",";
				$g .= "S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED_DAYS = " . S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED_DAYS . ",";
				/**/
				$g .= "S2MEMBER_REG_EMAIL_FROM_NAME = '" . preg_replace ("/'/", "\'", S2MEMBER_REG_EMAIL_FROM_NAME) . "',";
				$g .= "S2MEMBER_REG_EMAIL_FROM_EMAIL = '" . preg_replace ("/'/", "\'", S2MEMBER_REG_EMAIL_FROM_EMAIL) . "',";
				/**/
				$g .= "S2MEMBER_PAYPAL_NOTIFY_URL = '" . preg_replace ("/'/", "\'", S2MEMBER_PAYPAL_NOTIFY_URL) . "',";
				$g .= "S2MEMBER_PAYPAL_RETURN_URL = '" . preg_replace ("/'/", "\'", S2MEMBER_PAYPAL_RETURN_URL) . "',";
				$g .= "S2MEMBER_PAYPAL_ENDPOINT = '" . preg_replace ("/'/", "\'", S2MEMBER_PAYPAL_ENDPOINT) . "',";
				$g .= "S2MEMBER_PAYPAL_BUSINESS = '" . preg_replace ("/'/", "\'", S2MEMBER_PAYPAL_BUSINESS) . "',";
				/**/
				$g .= "S2MEMBER_CURRENT_USER_VALUE_FOR_PP_ON0 = '" . preg_replace ("/'/", "\'", S2MEMBER_CURRENT_USER_VALUE_FOR_PP_ON0) . "',";
				$g .= "S2MEMBER_CURRENT_USER_VALUE_FOR_PP_OS0 = '" . preg_replace ("/'/", "\'", S2MEMBER_CURRENT_USER_VALUE_FOR_PP_OS0) . "',";
				/**/
				$g = trim ($g, " ,") . ";"; /* Trim & add semicolon. */
				$j = file_get_contents (dirname (dirname (__FILE__)) . "/s2member-min.js");
				$j = preg_replace ("/('|\")%%globals%%('|\");/", $g, $j);
				/**/
				echo $j;
				/**/
				exit;
			}
	}
?>