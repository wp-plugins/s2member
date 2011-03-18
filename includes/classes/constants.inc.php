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
if (!class_exists ("c_ws_plugin__s2member_constants"))
	{
		class c_ws_plugin__s2member_constants
			{
				/*
				Defines several API Constants for s2Member.
				Note that these are duplicated into the JavaScript API as well.
				Attach to: add_action("init");
				*/
				public static function constants ()
					{
						do_action ("ws_plugin__s2member_before_constants", get_defined_vars ());
						/**/
						$links = c_ws_plugin__s2member_cache::cached_page_links ();
						/**/
						$user = (is_user_logged_in () && is_object ($user = wp_get_current_user ()) && $user->ID) ? $user : false;
						/**/
						$level = c_ws_plugin__s2member_user_access::user_access_level ($user);
						$file_downloads = c_ws_plugin__s2member_files::user_downloads ($user);
						$login_redirection_url = c_ws_plugin__s2member_login_redirects::login_redirection_url ($user);
						/**/
						$custom = ($user) ? get_user_option ("s2member_custom", $user->ID) : "";
						$subscr_id = ($user) ? get_user_option ("s2member_subscr_id", $user->ID) : "";
						$subscr_gateway = ($user) ? get_user_option ("s2member_subscr_gateway", $user->ID) : "";
						$custom_fields = ($user) ? get_user_option ("s2member_custom_fields", $user->ID) : array ();
						$paid_registration_times = ($user) ? get_user_option ("s2member_paid_registration_times", $user->ID) : array ();
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_constants", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						define ("S2MEMBER_VERSION", ($c[] = (string)WS_PLUGIN__S2MEMBER_VERSION));
						/**/
						define ("S2MEMBER_CURRENT_USER_IS_LOGGED_IN", ($c[] = (($user) ? true : false)));
						define ("S2MEMBER_CURRENT_USER_IS_LOGGED_IN_AS_MEMBER", ($c[] = ( ($user && $level >= 1) ? true : false)));
						define ("S2MEMBER_CURRENT_USER_ACCESS_LEVEL", ($c[] = (int)$level)); /* Negative -1 through max Membership Level number. */
						define ("S2MEMBER_CURRENT_USER_ACCESS_LABEL", ($c[] = (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_label"]));
						define ("S2MEMBER_CURRENT_USER_SUBSCR_ID", ($c[] = (($user) ? (string)$subscr_id : ""))); /* A Member's Paid Subscription ID. */
						define ("S2MEMBER_CURRENT_USER_SUBSCR_OR_WP_ID", ($c[] = (($user) ? (($subscr_id) ? (string)$subscr_id : (string)$user->ID) : "")));
						define ("S2MEMBER_CURRENT_USER_SUBSCR_GATEWAY", ($c[] = (($user) ? (string)$subscr_gateway : ""))); /* Payment Gateway. */
						define ("S2MEMBER_CURRENT_USER_CUSTOM", ($c[] = (($user) ? (string)$custom : ""))); /* Starts w/ domain name. */
						define ("S2MEMBER_CURRENT_USER_REGISTRATION_TIME", ($c[] = ( ($user && $user->user_registered) ? (int)strtotime ($user->user_registered) : 0)));
						define ("S2MEMBER_CURRENT_USER_PAID_REGISTRATION_TIME", ($c[] = ( ($user && (int)$paid_registration_times["level"]) ? (int)$paid_registration_times["level"] : 0)));
						define ("S2MEMBER_CURRENT_USER_PAID_REGISTRATION_DAYS", ($c[] = ( ($user && (int)$paid_registration_times["level"]) ? (int)floor ((strtotime ("now") - (int)$paid_registration_times["level"]) / 86400) : 0)));
						define ("S2MEMBER_CURRENT_USER_REGISTRATION_DAYS", ($c[] = ( ($user && $user->user_registered) ? (int)floor ((strtotime ("now") - strtotime ($user->user_registered)) / 86400) : 0)));
						define ("S2MEMBER_CURRENT_USER_DISPLAY_NAME", ($c[] = (($user) ? (string)$user->display_name : "")));
						define ("S2MEMBER_CURRENT_USER_FIRST_NAME", ($c[] = (($user) ? (string)$user->first_name : "")));
						define ("S2MEMBER_CURRENT_USER_LAST_NAME", ($c[] = (($user) ? (string)$user->last_name : "")));
						define ("S2MEMBER_CURRENT_USER_LOGIN", ($c[] = (($user) ? (string)$user->user_login : "")));
						define ("S2MEMBER_CURRENT_USER_EMAIL", ($c[] = (($user) ? (string)$user->user_email : "")));
						define ("S2MEMBER_CURRENT_USER_IP", ($c[] = (string)$_SERVER["REMOTE_ADDR"]));
						define ("S2MEMBER_CURRENT_USER_ID", ($c[] = (($user) ? (int)$user->ID : 0)));
						/**/
						define ("S2MEMBER_CURRENT_USER_FIELDS", ($c[] = (($user) ? json_encode (array_merge (array ("id" => S2MEMBER_CURRENT_USER_ID, "ip" => S2MEMBER_CURRENT_USER_IP, "email" => S2MEMBER_CURRENT_USER_EMAIL, "login" => S2MEMBER_CURRENT_USER_LOGIN, "first_name" => S2MEMBER_CURRENT_USER_FIRST_NAME, "last_name" => S2MEMBER_CURRENT_USER_LAST_NAME, "display_name" => S2MEMBER_CURRENT_USER_DISPLAY_NAME, "subscr_id" => S2MEMBER_CURRENT_USER_SUBSCR_ID, "subscr_or_wp_id" => S2MEMBER_CURRENT_USER_SUBSCR_OR_WP_ID, "subscr_gateway" => S2MEMBER_CURRENT_USER_SUBSCR_GATEWAY, "custom" => S2MEMBER_CURRENT_USER_CUSTOM), (array)$custom_fields)) : json_encode (array ()))));
						/**/
						define ("S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED", ($c[] = (int)$file_downloads["allowed"]));
						define ("S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_IS_UNLIMITED", ($c[] = ( ($file_downloads["allowed"] >= 999999999) ? true : false)));
						define ("S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY", ($c[] = (int)$file_downloads["currently"]));
						define ("S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS", ($c[] = (int)$file_downloads["allowed_days"]));
						/**/
						define ("S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_ID", ($c[] = (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]));
						define ("S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_ID", ($c[] = (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]));
						define ("S2MEMBER_LOGIN_WELCOME_PAGE_ID", ($c[] = (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]));
						/**/
						define ("S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL", ($c[] = (string)site_url ("/?s2member_profile=1")));
						define ("S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_URL", ($c[] = (string)$links["file_download_limit_exceeded_page"]));
						define ("S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_URL", ($c[] = (string)$links["membership_options_page"])); /* Signup page. */
						define ("S2MEMBER_LOGIN_WELCOME_PAGE_URL", ($c[] = (($login_redirection_url) ? (string)$login_redirection_url : (string)$links["login_welcome_page"])));
						define ("S2MEMBER_LOGOUT_PAGE_URL", ($c[] = (string)wp_logout_url ())); /* This triggers `wp_nonce_tick()`; watch out for dynamic changes. */
						define ("S2MEMBER_LOGIN_PAGE_URL", ($c[] = (string)wp_login_url ())); /* Will not trigger `wp_nonce_tick()`, no worries in this case. */
						/**/
						define ("S2MEMBER_LEVEL0_LABEL", ($c[] = (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_label"]));
						define ("S2MEMBER_LEVEL1_LABEL", ($c[] = (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_label"]));
						define ("S2MEMBER_LEVEL2_LABEL", ($c[] = (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"]));
						define ("S2MEMBER_LEVEL3_LABEL", ($c[] = (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_label"]));
						define ("S2MEMBER_LEVEL4_LABEL", ($c[] = (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_label"]));
						/**/
						define ("S2MEMBER_LEVEL0_FILE_DOWNLOADS_ALLOWED", ($c[] = (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed"]));
						define ("S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED", ($c[] = (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed"]));
						define ("S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED", ($c[] = (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed"]));
						define ("S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED", ($c[] = (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed"]));
						define ("S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED", ($c[] = (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed"]));
						/**/
						define ("S2MEMBER_LEVEL0_FILE_DOWNLOADS_ALLOWED_DAYS", ($c[] = (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed_days"]));
						define ("S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED_DAYS", ($c[] = (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed_days"]));
						define ("S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED_DAYS", ($c[] = (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed_days"]));
						define ("S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED_DAYS", ($c[] = (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed_days"]));
						define ("S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED_DAYS", ($c[] = (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed_days"]));
						/**/
						define ("S2MEMBER_FILE_DOWNLOAD_INLINE_EXTENSIONS", ($c[] = (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_inline_extensions"]));
						/**/
						define ("S2MEMBER_REG_EMAIL_FROM_NAME", ($c[] = (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]));
						define ("S2MEMBER_REG_EMAIL_FROM_EMAIL", ($c[] = (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"]));
						/**/
						define ("S2MEMBER_PAYPAL_NOTIFY_URL", ($c[] = (string)site_url ("/?s2member_paypal_notify=1")));
						define ("S2MEMBER_PAYPAL_RETURN_URL", ($c[] = (string)site_url ("/?s2member_paypal_return=1")));
						/**/
						define ("S2MEMBER_PAYPAL_BUSINESS", ($c[] = (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"]));
						define ("S2MEMBER_PAYPAL_ENDPOINT", ($c[] = ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com")));
						define ("S2MEMBER_PAYPAL_API_ENDPOINT", ($c[] = ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "api-3t.sandbox.paypal.com" : "api-3t.paypal.com")));
						define ("S2MEMBER_PAYPAL_API_USERNAME", ($c[] = (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_api_username"]));
						define ("S2MEMBER_PAYPAL_API_PASSWORD", ($c[] = (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_api_password"]));
						define ("S2MEMBER_PAYPAL_API_SIGNATURE", ($c[] = (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_api_signature"]));
						/**/
						define ("S2MEMBER_PAYPAL_PDT_IDENTITY_TOKEN", ($c[] = (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_identity_token"]));
						/**/
						define ("S2MEMBER_CURRENT_USER_VALUE_FOR_PP_ON0", ($c[] = ((S2MEMBER_CURRENT_USER_SUBSCR_OR_WP_ID) ? "Updating Subscr. ID" : "")));
						define ("S2MEMBER_CURRENT_USER_VALUE_FOR_PP_OS0", ($c[] = ((S2MEMBER_CURRENT_USER_SUBSCR_OR_WP_ID) ? S2MEMBER_CURRENT_USER_SUBSCR_OR_WP_ID : "")));
						/**/
						$c = apply_filters ("ws_plugin__s2member_during_constants_c", $c, get_defined_vars ()); /* Allows other Constants to be calculated nicely. */
						/**/
						define ("WS_PLUGIN__S2MEMBER_API_CONSTANTS_MD5", md5 (serialize ($c) . c_ws_plugin__s2member_utilities::ver_checksum ())); /* Checksum. */
						/**/
						do_action ("ws_plugin__s2member_after_constants", get_defined_vars ()); /* Calls the after Hook. Do NOT set Constants here. */
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>