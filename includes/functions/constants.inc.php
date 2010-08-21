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
/*
Define several API Constants for s2Member.
Note that these are duplicated into the JavaScript API as well.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_constants"))
	{
		function ws_plugin__s2member_constants ()
			{
				do_action ("ws_plugin__s2member_before_constants", get_defined_vars ());
				/**/
				$links = ws_plugin__s2member_constant_links ();
				$level = ws_plugin__s2member_user_access_level ();
				$file_downloads = ws_plugin__s2member_user_downloads ();
				/**/
				$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false;
				/**/
				$subscr_id = ($current_user) ? get_user_option ("s2member_subscr_id", $current_user->ID) : "";
				$custom = ($current_user) ? get_user_option ("s2member_custom", $current_user->ID) : "";
				$custom_fields = ($current_user) ? get_user_option ("s2member_custom_fields", $current_user->ID) : array ();
				/**/
				$login_redirection_override = ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"]) ? ws_plugin__s2member_fill_login_redirect_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"], $current_user) : "";
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_constants", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				define ("S2MEMBER_VERSION", WS_PLUGIN__S2MEMBER_VERSION); /* Available since 3.0. */
				/**/
				define ("S2MEMBER_CURRENT_USER_IS_LOGGED_IN", (($current_user) ? true : false));
				define ("S2MEMBER_CURRENT_USER_IS_LOGGED_IN_AS_MEMBER", (($current_user && $level >= 1) ? true : false));
				define ("S2MEMBER_CURRENT_USER_ACCESS_LEVEL", (int)$level);
				define ("S2MEMBER_CURRENT_USER_ACCESS_LABEL", (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_label"]);
				define ("S2MEMBER_CURRENT_USER_SUBSCR_ID", (($current_user) ? (($subscr_id) ? (string)$subscr_id : (string)$current_user->ID) : ""));
				define ("S2MEMBER_CURRENT_USER_CUSTOM", (string)$custom);
				define ("S2MEMBER_CURRENT_USER_REGISTRATION_TIME", (($current_user) ? (int)strtotime ($current_user->user_registered) : 0));
				define ("S2MEMBER_CURRENT_USER_REGISTRATION_DAYS", (($current_user) ? (int)floor ((strtotime ("now") - strtotime ($current_user->user_registered)) / 86400) : 0));
				define ("S2MEMBER_CURRENT_USER_DISPLAY_NAME", (($current_user) ? (string)$current_user->display_name : ""));
				define ("S2MEMBER_CURRENT_USER_FIRST_NAME", (($current_user) ? (string)$current_user->first_name : ""));
				define ("S2MEMBER_CURRENT_USER_LAST_NAME", (($current_user) ? (string)$current_user->last_name : ""));
				define ("S2MEMBER_CURRENT_USER_LOGIN", (($current_user) ? (string)$current_user->user_login : ""));
				define ("S2MEMBER_CURRENT_USER_EMAIL", (($current_user) ? (string)$current_user->user_email : ""));
				define ("S2MEMBER_CURRENT_USER_IP", (string)$_SERVER["REMOTE_ADDR"]);
				define ("S2MEMBER_CURRENT_USER_ID", (($current_user) ? (int)$current_user->ID : 0));
				define ("S2MEMBER_CURRENT_USER_FIELDS", (($current_user) ? json_encode (array_merge (array ("id" => S2MEMBER_CURRENT_USER_ID, "ip" => S2MEMBER_CURRENT_USER_IP, "email" => S2MEMBER_CURRENT_USER_EMAIL, "login" => S2MEMBER_CURRENT_USER_LOGIN, "first_name" => S2MEMBER_CURRENT_USER_FIRST_NAME, "last_name" => S2MEMBER_CURRENT_USER_LAST_NAME, "display_name" => S2MEMBER_CURRENT_USER_DISPLAY_NAME, "subscr_id" => S2MEMBER_CURRENT_USER_SUBSCR_ID, "custom" => S2MEMBER_CURRENT_USER_CUSTOM), (array)$custom_fields)) : json_encode (array ())));
				/**/
				define ("S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED", (int)$file_downloads["allowed"]);
				define ("S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_IS_UNLIMITED", (($file_downloads["allowed"] >= 999999999) ? true : false));
				define ("S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY", (int)$file_downloads["currently"]);
				define ("S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS", (int)$file_downloads["allowed_days"]);
				/**/
				define ("S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_ID", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]);
				define ("S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_ID", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]);
				define ("S2MEMBER_LOGIN_WELCOME_PAGE_ID", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]);
				/**/
				define ("S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL", get_bloginfo ("wpurl") . "/?s2member_profile=1");
				define ("S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_URL", (string)$links["file_download_limit_exceeded_page"]);
				define ("S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_URL", (string)$links["membership_options_page"]);
				define ("S2MEMBER_LOGIN_WELCOME_PAGE_URL", (($login_redirection_override) ? (string)$login_redirection_override : (string)$links["login_welcome_page"]));
				define ("S2MEMBER_LOGOUT_PAGE_URL", (string)wp_logout_url ());
				define ("S2MEMBER_LOGIN_PAGE_URL", (string)wp_login_url ());
				/**/
				define ("S2MEMBER_LEVEL0_LABEL", (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_label"]);
				define ("S2MEMBER_LEVEL1_LABEL", (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_label"]);
				define ("S2MEMBER_LEVEL2_LABEL", (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"]);
				define ("S2MEMBER_LEVEL3_LABEL", (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_label"]);
				define ("S2MEMBER_LEVEL4_LABEL", (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_label"]);
				/**/
				define ("S2MEMBER_LEVEL0_FILE_DOWNLOADS_ALLOWED", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed"]);
				define ("S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed"]);
				define ("S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed"]);
				define ("S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed"]);
				define ("S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed"]);
				/**/
				define ("S2MEMBER_LEVEL0_FILE_DOWNLOADS_ALLOWED_DAYS", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed_days"]);
				define ("S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED_DAYS", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed_days"]);
				define ("S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED_DAYS", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed_days"]);
				define ("S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED_DAYS", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed_days"]);
				define ("S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED_DAYS", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed_days"]);
				/**/
				define ("S2MEMBER_FILE_DOWNLOAD_INLINE_EXTENSIONS", (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_inline_extensions"]);
				/**/
				define ("S2MEMBER_REG_EMAIL_FROM_NAME", (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]);
				define ("S2MEMBER_REG_EMAIL_FROM_EMAIL", (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"]);
				/**/
				define ("S2MEMBER_PAYPAL_NOTIFY_URL", get_bloginfo ("wpurl") . "/?s2member_paypal_notify=1");
				define ("S2MEMBER_PAYPAL_RETURN_URL", get_bloginfo ("wpurl") . "/?s2member_paypal_return=1");
				define ("S2MEMBER_PAYPAL_ENDPOINT", (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com"));
				define ("S2MEMBER_PAYPAL_BUSINESS", (string)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"]);
				/**/
				define ("S2MEMBER_CURRENT_USER_VALUE_FOR_PP_ON0", ((S2MEMBER_CURRENT_USER_SUBSCR_ID) ? "Updating Subscr. ID" : ""));
				define ("S2MEMBER_CURRENT_USER_VALUE_FOR_PP_OS0", ((S2MEMBER_CURRENT_USER_VALUE_FOR_PP_ON0) ? S2MEMBER_CURRENT_USER_SUBSCR_ID : ""));
				/**/
				do_action ("ws_plugin__s2member_after_constants", get_defined_vars ());
				/**/
				return; /* Return nothing here. Just for uniformity. */
			}
	}
/*
This function pulls all of the Page links needed for Constants.
Page links are cached into the s2Member options on 15 min intervals.
This allows the API Constants to provide quick access to them without being
forced to execute get_page_link() all the time, which piles up DB queries.
*/
if (!function_exists ("ws_plugin__s2member_constant_links"))
	{
		function ws_plugin__s2member_constant_links ()
			{
				do_action ("ws_plugin__s2member_before_constant_links", get_defined_vars ());
				/**/
				$l = array ("login_welcome_page" => "", "membership_options_page" => "", "file_download_limit_exceeded_page" => "");
				/**/
				$login_welcome_page = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"];
				$membership_options_page = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"];
				$file_download_limit_exceeded_page = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"];
				/**/
				$login_welcome_page_cache = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["login_welcome_page"];
				$membership_options_page_cache = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["membership_options_page"];
				$file_download_limit_exceeded_page_cache = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["file_download_limit_exceeded_page"];
				/**/
				if ($login_welcome_page && $login_welcome_page_cache["page"] === $login_welcome_page && $login_welcome_page_cache["link"] && $login_welcome_page_cache["time"] >= strtotime ("-15 minutes"))
					{
						$l["login_welcome_page"] = $login_welcome_page_cache["link"];
					}
				else /* Otherwise, we need to query the database using get_page_link() and update the cache. */
					{
						$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["login_welcome_page"]["time"] = strtotime ("now");
						$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["login_welcome_page"]["page"] = $login_welcome_page;
						$l["login_welcome_page"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["login_welcome_page"]["link"] = get_page_link ($login_welcome_page);
						/**/
						$cache_needs_updating = true;
					}
				/**/
				if ($membership_options_page && $membership_options_page_cache["page"] === $membership_options_page && $membership_options_page_cache["link"] && $membership_options_page_cache["time"] >= strtotime ("-15 minutes"))
					{
						$l["membership_options_page"] = $membership_options_page_cache["link"];
					}
				else /* Otherwise, we need to query the database using get_page_link() and update the cache. */
					{
						$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["membership_options_page"]["time"] = strtotime ("now");
						$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["membership_options_page"]["page"] = $membership_options_page;
						$l["membership_options_page"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["membership_options_page"]["link"] = get_page_link ($membership_options_page);
						/**/
						$cache_needs_updating = true;
					}
				/**/
				if ($file_download_limit_exceeded_page && $file_download_limit_exceeded_page_cache["page"] === $file_download_limit_exceeded_page && $file_download_limit_exceeded_page_cache["link"] && $file_download_limit_exceeded_page_cache["time"] >= strtotime ("-15 minutes"))
					{
						$l["file_download_limit_exceeded_page"] = $file_download_limit_exceeded_page_cache["link"];
					}
				else /* Otherwise, we need to query the database using get_page_link() and update the cache. */
					{
						$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["file_download_limit_exceeded_page"]["time"] = strtotime ("now");
						$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["file_download_limit_exceeded_page"]["page"] = $file_download_limit_exceeded_page;
						$l["file_download_limit_exceeded_page"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["file_download_limit_exceeded_page"]["link"] = get_page_link ($file_download_limit_exceeded_page);
						/**/
						$cache_needs_updating = true;
					}
				/**/
				if ($cache_needs_updating) /* The cache is also reset when options are updated from a menu page. */
					{
						update_option ("ws_plugin__s2member_cache", $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]);
					}
				/**/
				return apply_filters ("ws_plugin__s2member_constant_links", $l, get_defined_vars ());
			}
	}
?>