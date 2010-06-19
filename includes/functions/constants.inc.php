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
				$metas = ws_plugin__s2member_constant_metas ();
				$level = ws_plugin__s2member_user_access_level ();
				$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false;
				$file_downloads = ws_plugin__s2member_user_downloads ("", $metas["s2member_file_download_access_log"]);
				$login_redirection_override = ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"]) ? /* Only when applicable. */
				ws_plugin__s2member_fill_login_redirect_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"], $current_user) : "";
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_constants", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				define ("S2MEMBER_VERSION", WS_PLUGIN__S2MEMBER_VERSION); /* Always a (string) containing the version. Available since 3.0. */
				/**/
				define ("S2MEMBER_CURRENT_USER_IS_LOGGED_IN", (($current_user) ? true : false)); /* This will always be (bool) true or false. False if they are NOT currently logged in. */
				define ("S2MEMBER_CURRENT_USER_IS_LOGGED_IN_AS_MEMBER", (($current_user && $level >= 1) ? true : false)); /* This will always be (bool) true or false. Level >= 1 for Members. */
				define ("S2MEMBER_CURRENT_USER_ACCESS_LEVEL", (int)$level); /* This will always be (int) negative 1 thru positive 4. -1 if user is not logged in. 0 if logged in as a Subscriber. */
				define ("S2MEMBER_CURRENT_USER_ACCESS_LABEL", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_label"]); /* This will always be a (string). Empty if not logged in. */
				define ("S2MEMBER_CURRENT_USER_SUBSCR_ID", (($current_user) ? (($metas["s2member_subscr_id"]) ? $metas["s2member_subscr_id"] : $current_user->ID) : "")); /* Empty if not logged in. */
				define ("S2MEMBER_CURRENT_USER_CUSTOM", (($current_user) ? $metas["s2member_custom"] : "")); /* This will always a (string). However, it will be empty if not logged in. */
				define ("S2MEMBER_CURRENT_USER_REGISTRATION_TIME", (($current_user) ? (int)strtotime ($current_user->user_registered) : 0)); /* Always an (int). Or 0 if they're not logged in. */
				define ("S2MEMBER_CURRENT_USER_REGISTRATION_DAYS", (($current_user) ? (int)floor ((strtotime ("now") - strtotime ($current_user->user_registered)) / 86400) : 0)); /* (int). */
				define ("S2MEMBER_CURRENT_USER_DISPLAY_NAME", (($current_user) ? $current_user->display_name : "")); /* This will always be a (string). Empty if not logged in. */
				define ("S2MEMBER_CURRENT_USER_FIRST_NAME", (($current_user) ? $current_user->user_firstname : "")); /* This will always be a (string). Empty if not logged in. */
				define ("S2MEMBER_CURRENT_USER_LAST_NAME", (($current_user) ? $current_user->user_lastname : "")); /* This will always be a (string). Empty if not logged in. */
				define ("S2MEMBER_CURRENT_USER_LOGIN", (($current_user) ? $current_user->user_login : "")); /* This will always be a (string). Empty if not logged in. */
				define ("S2MEMBER_CURRENT_USER_EMAIL", (($current_user) ? $current_user->user_email : "")); /* This will always be a (string). Empty if not logged in. */
				define ("S2MEMBER_CURRENT_USER_IP", $_SERVER["REMOTE_ADDR"]); /* This will always be a (string). It may be empty if the user is browsing anonymously. */
				define ("S2MEMBER_CURRENT_USER_ID", (($current_user) ? (int)$current_user->ID : 0)); /* This will always be an (int). Zero if not logged in. */
				define ("S2MEMBER_CURRENT_USER_FIELDS", (($current_user) ? json_encode (array_merge /* Always a json_encode (array). This includes custom fields. */
				(array ("id" => S2MEMBER_CURRENT_USER_ID, "ip" => S2MEMBER_CURRENT_USER_IP, "email" => S2MEMBER_CURRENT_USER_EMAIL, "login" => S2MEMBER_CURRENT_USER_LOGIN,/**/
				"first_name" => S2MEMBER_CURRENT_USER_FIRST_NAME, "last_name" => S2MEMBER_CURRENT_USER_LAST_NAME, "display_name" => S2MEMBER_CURRENT_USER_DISPLAY_NAME,/**/
				"subscr_id" => S2MEMBER_CURRENT_USER_SUBSCR_ID, "custom" => S2MEMBER_CURRENT_USER_CUSTOM), $metas["s2member_custom_fields"])) : json_encode (array ())));
				/**/
				define ("S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED", (int)$file_downloads["allowed"]); /* This will always be an integer value (int) >= 0 where 0 means no access. */
				define ("S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_IS_UNLIMITED", (($file_downloads["allowed"] >= 999999999) ? true : false)); /* This will always be (bool). */
				define ("S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY", (int)$file_downloads["currently"]); /* This will always be an integer value (int) >= 0 where 0 means none currently. */
				define ("S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS", (int)$file_downloads["allowed_days"]); /* This will always be an integer value (int) >= 0 where 0 means no access. */
				/**/
				define ("S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_ID", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]); /* The exceeded page id (int). */
				define ("S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_ID", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]); /* Options page id, always an (int). */
				define ("S2MEMBER_LOGIN_WELCOME_PAGE_ID", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]); /* The welcome page id, always an (int). */
				/**/
				define ("S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL", get_bloginfo ("url") . "/?s2member_profile=1"); /* Where a user modifies their profile. */
				define ("S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_URL", $links["file_download_limit_exceeded_page"]); /* Always a string. URL to limit exceeded page. */
				define ("S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_URL", $links["membership_options_page"]); /* Always a string. This is the URL to the membership options page. */
				define ("S2MEMBER_LOGIN_WELCOME_PAGE_URL", (($login_redirection_override) ? $login_redirection_override : $links["login_welcome_page"])); /* Always a string. */
				define ("S2MEMBER_LOGOUT_PAGE_URL", wp_logout_url ()); /* This is always the same, it is the default wordpress action=logout url generated by wp_logout_url(). */
				define ("S2MEMBER_LOGIN_PAGE_URL", wp_login_url ()); /* This is always the same, it is the default wordpress login url that is generated by wp_login_url(). */
				/**/
				define ("S2MEMBER_LEVEL0_LABEL", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_label"]); /* This is the (string) label that you created for membership level number 0. */
				define ("S2MEMBER_LEVEL1_LABEL", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_label"]); /* This is the (string) label that you created for membership level number 1. */
				define ("S2MEMBER_LEVEL2_LABEL", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"]); /* This is the (string) label that you created for membership level number 2. */
				define ("S2MEMBER_LEVEL3_LABEL", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_label"]); /* This is the (string) label that you created for membership level number 3. */
				define ("S2MEMBER_LEVEL4_LABEL", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_label"]); /* This is the (string) label that you created for membership level number 4. */
				/**/
				define ("S2MEMBER_LEVEL0_FILE_DOWNLOADS_ALLOWED", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed"]); /* This is the (int) allowed downloads. */
				define ("S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed"]); /* This is the (int) allowed downloads. */
				define ("S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed"]); /* This is the (int) allowed downloads. */
				define ("S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed"]); /* This is the (int) allowed downloads. */
				define ("S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed"]); /* This is the (int) allowed downloads. */
				/**/
				define ("S2MEMBER_LEVEL0_FILE_DOWNLOADS_ALLOWED_DAYS", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed_days"]); /* This is (int) allowed days. */
				define ("S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED_DAYS", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed_days"]); /* This is (int) allowed days. */
				define ("S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED_DAYS", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed_days"]); /* This is (int) allowed days. */
				define ("S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED_DAYS", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed_days"]); /* This is (int) allowed days. */
				define ("S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED_DAYS", (int)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed_days"]); /* This is (int) allowed days. */
				/**/
				define ("S2MEMBER_FILE_DOWNLOAD_INLINE_EXTENSIONS", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_inline_extensions"]); /* This is the (string) list of extensions. */
				/**/
				define ("S2MEMBER_REG_EMAIL_FROM_NAME", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]); /* This is the name that outgoing email messages are sent by. */
				define ("S2MEMBER_REG_EMAIL_FROM_EMAIL", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"]); /* This is the email that outgoing messages are sent by. */
				/**/
				define ("S2MEMBER_PAYPAL_NOTIFY_URL", get_bloginfo ("url") . "/?s2member_paypal_notify=1"); /* This will always be a (string), and it will never be an empty value. */
				define ("S2MEMBER_PAYPAL_RETURN_URL", get_bloginfo ("url") . "/?s2member_paypal_return=1"); /* This will always be a (string), and it will never be an empty value. */
				define ("S2MEMBER_PAYPAL_ENDPOINT", (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com")); /* Using sandbox? */
				define ("S2MEMBER_PAYPAL_BUSINESS", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"]); /* This is the email address that identifies your paypal business. */
				/**/
				define ("S2MEMBER_CURRENT_USER_VALUE_FOR_PP_ON0", ((S2MEMBER_CURRENT_USER_SUBSCR_ID) ? "Updating Subscr. ID" : "")); /* Subscr. ID or $user->ID. Either will work. */
				define ("S2MEMBER_CURRENT_USER_VALUE_FOR_PP_OS0", ((S2MEMBER_CURRENT_USER_VALUE_FOR_PP_ON0) ? S2MEMBER_CURRENT_USER_SUBSCR_ID : "")); /* Subscr. ID or $user->ID. */
				/**/
				do_action ("ws_plugin__s2member_after_constants", get_defined_vars ());
				/**/
				return;
			}
	}
/*
This function pulls all of the page links needed for Constants.
Page links are cached into the s2member options on 15 min intervals.
This allows the API Constants to provide quick access to them without being
forced to execute get_page_link() all the time, which piles up DB queries.
*/
if (!function_exists ("ws_plugin__s2member_constant_links"))
	{
		function ws_plugin__s2member_constant_links ()
			{
				do_action ("ws_plugin__s2member_before_constant_links", get_defined_vars ());
				/**/
				$cache_minutes = 15; /* Could be higher? */
				/**/
				$l["login_welcome_page"] = (string)"";
				$l["membership_options_page"] = (string)"";
				$l["file_download_limit_exceeded_page"] = (string)"";
				/**/
				$login_welcome_page = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"];
				$membership_options_page = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"];
				$file_download_limit_exceeded_page = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"];
				/**/
				$login_welcome_page_cache = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["login_welcome_page"];
				$membership_options_page_cache = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["membership_options_page"];
				$file_download_limit_exceeded_page_cache = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"]["file_download_limit_exceeded_page"];
				/**/
				if ($login_welcome_page && $login_welcome_page_cache["page"] === $login_welcome_page && $login_welcome_page_cache["link"] && $login_welcome_page_cache["time"] >= strtotime ("-" . $cache_minutes . " minutes"))
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
				if ($membership_options_page && $membership_options_page_cache["page"] === $membership_options_page && $membership_options_page_cache["link"] && $membership_options_page_cache["time"] >= strtotime ("-" . $cache_minutes . " minutes"))
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
				if ($file_download_limit_exceeded_page && $file_download_limit_exceeded_page_cache["page"] === $file_download_limit_exceeded_page && $file_download_limit_exceeded_page_cache["link"] && $file_download_limit_exceeded_page_cache["time"] >= strtotime ("-" . $cache_minutes . " minutes"))
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
/*
This function pulls all of the usermeta details needed for Constants.
Pulling them all at once helps to prevent repeated database queries.
*/
if (!function_exists ("ws_plugin__s2member_constant_metas"))
	{
		function ws_plugin__s2member_constant_metas ()
			{
				global $wpdb; /* The global database object. */
				/**/
				do_action ("ws_plugin__s2member_before_constant_metas", get_defined_vars ());
				/**/
				$m["s2member_file_download_access_log"] = array ();
				$m["s2member_custom_fields"] = array ();
				$m["s2member_subscr_id"] = (string)"";
				$m["s2member_custom"] = (string)"";
				/**/
				if (($current_user = (is_user_logged_in ()) ? wp_get_current_user () : false))
					{
						if (is_array ($results = $wpdb->get_results ("SELECT `meta_key`, `meta_value` FROM `" . $wpdb->usermeta . "` WHERE `user_id` = '" . $current_user->ID . "' AND (meta_key = 's2member_file_download_access_log' OR meta_key = 's2member_custom_fields' OR meta_key = 's2member_subscr_id' OR meta_key = 's2member_custom') LIMIT 3")))
							{
								foreach ($results as $r) /* Fill in the array we need. */
									if ($r->meta_key === "s2member_file_download_access_log")
										$m["s2member_file_download_access_log"] = (array)maybe_unserialize ($r->meta_value);
									else if ($result->meta_key === "s2member_custom_fields")
										$m["s2member_custom_fields"] = (array)maybe_unserialize ($r->meta_value);
									else if ($r->meta_key === "s2member_subscr_id")
										$m["s2member_subscr_id"] = (string)$r->meta_value;
									else if ($result->meta_key === "s2member_custom")
										$m["s2member_custom"] = (string)$r->meta_value;
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_constant_metas", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
					}
				/**/
				return apply_filters ("ws_plugin__s2member_constant_metas", $m, get_defined_vars ());
			}
	}
?>