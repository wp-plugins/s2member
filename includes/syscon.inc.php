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
WARNING: This is a system configuration file, please DO NOT EDIT this file directly!
... Instead, use the plugin options panel in WordPress® to override these settings.
*/
/*
Direct access denial.
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/*
Determine the full url to the directory this plugin resides in.
*/
$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] = content_url () . preg_replace ("/^(.*?)(\/" . preg_quote (basename (WP_CONTENT_DIR), "/") . ")/", "", preg_replace ("/" . preg_quote (DIRECTORY_SEPARATOR, "/") . "/", "/", dirname (dirname (__FILE__))));
/*
Check if the plugin has been configured *should be set after the first config via options panel*.
*/
$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["configured"] = get_option ("ws_plugin__s2member_configured");
/*
This is a special option cache that holds some additional information autoloaded into WordPress®.
*/
$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["cache"] = get_option ("ws_plugin__s2member_cache");
/*
Configure the right menu options panel for this software.
*/
$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"] = array ("upsell-pro" => true, "installation" => true, "tools" => true, "support" => true, "donations" => true);
/*
Configure the directory for files protected by this plugin.
*/
$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] = dirname (dirname (__FILE__)) . "-files";
/*
Configure the directory for logs protected by this plugin.
*/
$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"] = dirname (dirname (__FILE__)) . "-logs";
/*
Configure the file modification time for the syscon.inc.php file.
*/
$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"] = filemtime (__FILE__);
/*
Configure & validate all of the plugin options; and set their defaults.
*/
function ws_plugin__s2member_configure_options_and_their_defaults ($options = FALSE)
	{
		global $current_site, $current_blog; /* Multisite Networking compatiblity. */
		/* Here we build the default options array, which will be merged with the user options.
		It is important to note that sometimes default options may not or should not be pre-filled on an options form.
		These defaults are for the system to use in various ways, we may choose not to pre-fill certain fields.
		In other words, some defaults may be used internally, but to the user, the option will be empty. */
		$default_options = apply_filters ("ws_plugin__s2member_default_options", array ( /* For filters. */
		/**/
		"options_version" => "1.0", /* Used internally to keep runtime files up-to-date. */
		/**/
		"sec_encryption_key" => "", /* For security. This keeps each installation unique. */
		"sec_encryption_key_history" => array (), /* This keeps a history of the last 10 keys. */
		/**/
		"max_ip_restriction" => "5", /* Maximum IPs on record for each Username/Post/Page. */
		"max_ip_restriction_time" => "3600", /* How long before restrictions are lifted? */
		/**/
		"run_deactivation_routines" => "1", /* Should deactivation routines be processed? */
		/**/
		"custom_reg_fields" => "", /* A comma-delimited list of Custom Fields to collect/use. */
		"custom_reg_password" => "0", /* Allow users to register their own Custom Password? */
		"custom_reg_opt_in" => "1", /* Use a Double Opt-In Checkbox on the Registration Form? */
		"custom_reg_opt_in_label" => "Yes, I want to receive updates via email.", /* Label. */
		/**/
		"allow_subscribers_in" => "0", /* Allow Subscribers to register for absolutely free access? */
		"mms_registration_file" => "wp-login", /* A Multisite registration ( on the main site ) uses which file? */
		"mms_registration_grants" => "none", /* A public visitor, on a Multisite Blog Farm can register what? */
		"mms_registration_blogs_level0" => "0", /* A Visitor on a Multisite Farm, can create how many Blogs? */
		"mms_registration_blogs_level1" => "1", /* A Customer on a Multisite Farm can create how many Blogs? */
		"mms_registration_blogs_level2" => "5", /* A Customer on a Multisite Farm can create how many Blogs? */
		"mms_registration_blogs_level3" => "25", /* A Customer on a Multisite Farm can create how many Blogs? */
		"mms_registration_blogs_level4" => "100", /* A Customer on a Multisite Farm can create how many Blogs? */
		"force_admin_lockouts" => "0", /* Redirects admin Pages/Profile to the Login Welcome Page. */
		/**/
		"login_welcome_page" => "", /* Defaults to the Home Page. */
		"login_redirection_override" => "", /* Alternate redirection location; instead of the Welcome Page. */
		"membership_options_page" => "", /* Defaults to the Home Page. */
		/**/
		"login_reg_background_color" => "FFFFFF", /* Defaults to white, and the bg.png is also white. */
		"login_reg_background_image" => $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images/bg.png",/**/
		"login_reg_background_image_repeat" => "repeat", /* How should the background image repeat? repeat[-x|y]*/
		"login_reg_background_text_color" => "000000", /* Defaults to black, which is high contrast on white. */
		"login_reg_background_text_shadow_color" => "CCCCCC", /* Defaults to gray, which is slightly visible. */
		"login_reg_background_box_shadow_color" => "CCCCCC", /* Defaults to gray, which is slightly visible. */
		/**/
		"login_reg_logo_src" => $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images/logo.png",/**/
		"login_reg_logo_src_width" => "500", /* Defaults to the logo_src image width. */
		"login_reg_logo_src_height" => "100", /* Defaults to the logo_src image height. */
		"login_reg_logo_url" => get_bloginfo ("url"), /* Defaults to the site url. */
		"login_reg_logo_title" => get_bloginfo ("name"), /* Defaults to the site name. */
		/**/
		"reg_email_from_name" => get_bloginfo ("name"), /* Defaults to the site name. */
		"reg_email_from_email" => get_bloginfo ("admin_email"), /* Defaults to the admin. */
		/**/
		"paypal_debug" => "0", /* Use the PayPal debug/logs for development testing? */
		"paypal_sandbox" => "0", /* Use the PayPal sandbox for development testing? */
		"paypal_business" => "", /* Paypal business email address for their account. */
		"paypal_identity_token" => "", /* Paypal payment data transfer identity token. */
		/**/
		"signup_tracking_codes" => "", /* Signup Tracking Codes. */
		"signup_email_recipients" => '"%%full_name%%" <%%payer_email%%>',/**/
		"signup_email_subject" => "Congratulations! ( your membership has been approved )",/**/
		"signup_email_message" => "Thanks %%first_name%%! Your membership has been approved.\n\nIf you haven't already done so, the next step is to Register a Username.\n\nComplete your registration here:\n%%registration_url%%\n\nIf you have any trouble, please feel free to contact us.\n\nBest Regards,\n" . get_bloginfo ("name"),/**/
		/**/
		"sp_tracking_codes" => "", /* Specific Post/Page Tracking. */
		"sp_email_recipients" => '"%%full_name%%" <%%payer_email%%>',/**/
		"sp_email_subject" => "Thank You! ( instructions for access )",/**/
		"sp_email_message" => "Thanks %%first_name%%!\n\n%%item_name%%\n\nYour order can be retrieved here:\n%%sp_access_url%%\n( link expires in %%sp_access_exp%% )\n\nIf you have any trouble, please feel free to contact us.\n\nBest Regards,\n" . get_bloginfo ("name"),/**/
		/**/
		"mailchimp_api_key" => "", /* MailChimp® API Key for MailChimp® integration. */
		"level0_mailchimp_list_ids" => "", /* A comma-delimited list of MailChimp® List IDs. */
		"level1_mailchimp_list_ids" => "", /* A comma-delimited list of MailChimp® List IDs. */
		"level2_mailchimp_list_ids" => "", /* A comma-delimited list of MailChimp® List IDs. */
		"level3_mailchimp_list_ids" => "", /* A comma-delimited list of MailChimp® List IDs. */
		"level4_mailchimp_list_ids" => "", /* A comma-delimited list of MailChimp® List IDs. */
		/**/
		"level0_aweber_list_ids" => "", /* A comma-delimited list of AWeber® List IDs. */
		"level1_aweber_list_ids" => "", /* A comma-delimited list of AWeber® List IDs. */
		"level2_aweber_list_ids" => "", /* A comma-delimited list of AWeber® List IDs. */
		"level3_aweber_list_ids" => "", /* A comma-delimited list of AWeber® List IDs. */
		"level4_aweber_list_ids" => "", /* A comma-delimited list of AWeber® List IDs. */
		/**/
		"signup_notification_urls" => "", /* s2Member Signup Notification urls. */
		"registration_notification_urls" => "", /* s2Member Reg Notification urls. */
		"payment_notification_urls" => "", /* s2Member Payment Notification urls. */
		"eot_del_notification_urls" => "", /* s2Member Eot/del Notification urls. */
		"ref_rev_notification_urls" => "", /* s2Member Ref/rev Notification urls. */
		"sp_notification_urls" => "", /* s2Member Specific Post/Page Notification urls. */
		/**/
		"level0_label" => "Free", /* This is just an initial generic Level Label. */
		"level1_label" => "Bronze", /* This is just an initial generic Level Label. */
		"level2_label" => "Silver", /* This is just an initial generic Level Label. */
		"level3_label" => "Gold", /* This is just an initial generic Level Label. */
		"level4_label" => "Platinum", /* This is just an initial generic Level Label. */
		/**/
		"level0_file_downloads_allowed" => "", /* This should always be numeric or empty. */
		"level1_file_downloads_allowed" => "", /* This should always be numeric or empty. */
		"level2_file_downloads_allowed" => "", /* This should always be numeric or empty. */
		"level3_file_downloads_allowed" => "", /* This should always be numeric or empty. */
		"level4_file_downloads_allowed" => "", /* This should always be numeric or empty. */
		/**/
		"level0_file_downloads_allowed_days" => "", /* This should be numeric or empty. */
		"level1_file_downloads_allowed_days" => "", /* This should be numeric or empty. */
		"level2_file_downloads_allowed_days" => "", /* This should be numeric or empty. */
		"level3_file_downloads_allowed_days" => "", /* This should be numeric or empty. */
		"level4_file_downloads_allowed_days" => "", /* This should be numeric or empty. */
		/**/
		"file_download_limit_exceeded_page" => "", /* Defaults to the Home Page. */
		"file_download_inline_extensions" => "", /* List of Extensions to serve Inline. */
		/**/
		"level0_ruris" => "", /* A line-delimited list of URIs, and/or URI fragments. */
		"level1_ruris" => "", /* A line-delimited list of URIs, and/or URI fragments. */
		"level2_ruris" => "", /* A line-delimited list of URIs, and/or URI fragments. */
		"level3_ruris" => "", /* A line-delimited list of URIs, and/or URI fragments. */
		"level4_ruris" => "", /* A line-delimited list of URIs, and/or URI fragments. */
		/**/
		"level0_catgs" => "", /* A comma-delimited list of Category IDs to protect. */
		"level1_catgs" => "", /* A comma-delimited list of Category IDs to protect. */
		"level2_catgs" => "", /* A comma-delimited list of Category IDs to protect. */
		"level3_catgs" => "", /* A comma-delimited list of Category IDs to protect. */
		"level4_catgs" => "", /* A comma-delimited list of Category IDs to protect. */
		/**/
		"level0_ptags" => "", /* A comma-delimited list of Post/Page Tags to protect. */
		"level1_ptags" => "", /* A comma-delimited list of Post/Page Tags to protect. */
		"level2_ptags" => "", /* A comma-delimited list of Post/Page Tags to protect. */
		"level3_ptags" => "", /* A comma-delimited list of Post/Page Tags to protect. */
		"level4_ptags" => "", /* A comma-delimited list of Post/Page Tags to protect. */
		/**/
		"level0_posts" => "", /* A comma-delimited list of Post IDs to protect. */
		"level1_posts" => "", /* A comma-delimited list of Post IDs to protect. */
		"level2_posts" => "", /* A comma-delimited list of Post IDs to protect. */
		"level3_posts" => "", /* A comma-delimited list of Post IDs to protect. */
		"level4_posts" => "", /* A comma-delimited list of Post IDs to protect. */
		/**/
		"level0_pages" => "", /* A comma-delimited list of Page IDs to protect. */
		"level1_pages" => "", /* A comma-delimited list of Page IDs to protect. */
		"level2_pages" => "", /* A comma-delimited list of Page IDs to protect. */
		"level3_pages" => "", /* A comma-delimited list of Page IDs to protect. */
		"level4_pages" => "", /* A comma-delimited list of Page IDs to protect. */
		/**/
		"specific_ids" => "", /* Comma-delimited list of Specific Post/Page IDs. */
		/**/
		"triggers_immediate_eot" => "refunds,reversals", /* Immediate EOT? */
		"membership_eot_behavior" => "demote", /* Demote or delete Members? */
		"auto_eot_system_enabled" => "1")); /* 0|1|2. 1 = WP-Cron, 2 = Cron tab. */
		/*
		Disable de-activation routines ( by default ) on a Multisite Blog Farm installation; excluding the Main Site ( Dashboard Blog ).
		*/
		if (is_multisite () && !is_main_site () && defined ("MULTISITE_FARM") && MULTISITE_FARM) /* Auto-protects Blog Owners. */
			$default_options["run_deactivation_routines"] = "0"; /* By default, disable all de-activation routines in this case. */
		/*
		Here they are merged. User options will overwrite some or all default values. 
		*/
		$GLOBALS["WS_PLUGIN__"]["s2member"]["o"] = array_merge ($default_options, (($options !== false) ? (array)$options : (array)get_option ("ws_plugin__s2member_options")));
		/*
		Validate each option, possibly reverting back to the default value if invalid.
		Also check if options were passed in on some of these, in case empty values are to be allowed. 
		*/
		foreach ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"] as $key => &$value)
			{
				if (!is_array ($value))
					$value = trim (stripslashes ($value));
				else /* A string, or an array of strings. */
					foreach ($value as $k => $v)
						$value[$k] = trim (stripslashes ($v));
				/**/
				if (!isset ($default_options[$key]) && !preg_match ("/^pro_/", $key))
					unset($GLOBALS["WS_PLUGIN__"]["s2member"]["o"][$key]);
				/**/
				else if ($key === "options_version" && (!is_string ($value) || !is_numeric ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "sec_encryption_key" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "sec_encryption_key_history" && (!is_array ($value) || empty ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "max_ip_restriction" && (!is_string ($value) || !is_numeric ($value) || $value < 1 || $value > 100))
					$value = $default_options[$key];
				/**/
				else if ($key === "max_ip_restriction_time" && (!is_string ($value) || !is_numeric ($value) || $value < 900 || $value > 31556926))
					$value = $default_options[$key];
				/**/
				else if ($key === "run_deactivation_routines" && (!is_string ($value) || !is_numeric ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "custom_reg_fields" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "custom_reg_password" && (!is_string ($value) || !is_numeric ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "custom_reg_opt_in" && (!is_string ($value) || !is_numeric ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "custom_reg_opt_in_label" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "allow_subscribers_in" && (!is_string ($value) || !is_numeric ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "mms_registration_file" && (!is_string ($value) || !preg_match ("/^(wp-login|wp-signup)$/", $value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "mms_registration_grants" && (!is_string ($value) || !preg_match ("/^(none|user|all)$/", $value)))
					$value = $default_options[$key];
				/**/
				else if (preg_match ("/^mms_registration_blogs_level[0-4]$/", $key) && (!is_string ($value) || !is_numeric ($value) || $value < 0))
					$value = $default_options[$key];
				/**/
				else if ($key === "force_admin_lockouts" && (!is_string ($value) || !is_numeric ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "login_welcome_page" && (!is_string ($value) || !is_numeric ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "login_redirection_override" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "membership_options_page" && (!is_string ($value) || !is_numeric ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "login_reg_background_color" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "login_reg_background_image" && !is_string ($value)) /* This is optional. */
					$value = $default_options[$key];
				/**/
				else if ($key === "login_reg_background_image_repeat" && (!is_string ($value) || !preg_match ("/^(repeat|repeat-x|repeat-y|no-repeat)$/", $value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "login_reg_logo_src" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "login_reg_logo_src_width" && (!is_string ($value) || !is_numeric ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "login_reg_logo_src_height" && (!is_string ($value) || !is_numeric ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "login_reg_logo_url" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "login_reg_logo_title" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "reg_email_from_name" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "reg_email_from_email" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "paypal_debug" && (!is_string ($value) || !is_numeric ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "paypal_sandbox" && (!is_string ($value) || !is_numeric ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "paypal_business" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "paypal_identity_token" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "signup_tracking_codes" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "signup_email_recipients" && !is_string ($value)) /* Can be empty. */
					$value = $default_options[$key];
				/**/
				else if ($key === "signup_email_subject" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "signup_email_message" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "sp_tracking_codes" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "sp_email_recipients" && !is_string ($value)) /* Can be empty. */
					$value = $default_options[$key];
				/**/
				else if ($key === "sp_email_subject" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "sp_email_message" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "mailchimp_api_key" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if (preg_match ("/^level[0-4]_mailchimp_list_ids$/", $key) && (!is_string ($value) || !strlen ($value = preg_replace ("/\s+/", "", $value))))
					$value = $default_options[$key];
				/**/
				else if (preg_match ("/^level[0-4]_aweber_list_ids$/", $key) && (!is_string ($value) || !strlen ($value = preg_replace ("/\s+/", "", $value))))
					$value = $default_options[$key];
				/**/
				else if ($key === "signup_notification_urls" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "registration_notification_urls" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "payment_notification_urls" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "eot_del_notification_urls" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "ref_rev_notification_urls" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "sp_notification_urls" && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if (preg_match ("/^level[0-4]_label$/", $key) && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if (preg_match ("/^level[0-4]_file_downloads_allowed$/", $key) && (!is_string ($value) || !is_numeric ($value) || $value < 0))
					$value = $default_options[$key];
				/**/
				else if (preg_match ("/^level[0-4]_file_downloads_allowed_days$/", $key) && (!is_string ($value) || !is_numeric ($value) || $value < 0))
					$value = $default_options[$key];
				/**/
				else if ($key === "file_download_limit_exceeded_page" && (!is_string ($value) || !is_numeric ($value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "file_download_inline_extensions" && (!is_string ($value) || !($value = strtolower (preg_replace ("/\s+/", "", $value)))))
					$value = $default_options[$key];
				/**/
				else if (preg_match ("/^level[0-4]_ruris$/", $key) && (!is_string ($value) || !strlen ($value)))
					$value = $default_options[$key];
				/**/
				else if (preg_match ("/^level[0-4]_catgs$/", $key) && (!is_string ($value) || !($value = (($value === "all") ? $value : trim (preg_replace ("/[^0-9,]/", "", $value), ",")))))
					$value = $default_options[$key];
				/**/
				else if (preg_match ("/^level[0-4]_ptags$/", $key) && (!is_string ($value) || !($value = (($value === "all") ? $value : strtolower (preg_replace ("/( +)/", " ", trim (preg_replace ("/( *),( *)/", ",", $value))))))))
					$value = $default_options[$key];
				/**/
				else if (preg_match ("/^level[0-4]_posts$/", $key) && (!is_string ($value) || !($value = (($value === "all") ? $value : trim (preg_replace ("/[^0-9,]/", "", $value), ",")))))
					$value = $default_options[$key];
				/**/
				else if (preg_match ("/^level[0-4]_pages$/", $key) && (!is_string ($value) || !($value = (($value === "all") ? $value : trim (preg_replace ("/[^0-9,]/", "", $value), ",")))))
					$value = $default_options[$key];
				/**/
				else if ($key === "specific_ids" && (!is_string ($value) || !($value = trim (preg_replace ("/[^0-9,]/", "", $value), ","))))
					$value = $default_options[$key];
				/**/
				else if ($key === "triggers_immediate_eot" && (!is_string ($value) || !preg_match ("/^(none|refunds|reversals|refunds,reversals)$/", $value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "membership_eot_behavior" && (!is_string ($value) || !preg_match ("/^(demote|delete)$/", $value)))
					$value = $default_options[$key];
				/**/
				else if ($key === "auto_eot_system_enabled" && (!is_string ($value) || !is_numeric ($value)))
					$value = $default_options[$key];
			}
		/*
		Keeps a history of the last 10 Security Encryption Keys configured for this installation.
		*/
		if ($options !== false && is_string ($options["sec_encryption_key"]) && strlen ($options["sec_encryption_key"]) && !in_array ($options["sec_encryption_key"], $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key_history"]))
			{
				array_unshift ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key_history"], $options["sec_encryption_key"]);
				$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key_history"] = array_slice ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key_history"], 0, 10);
			}
		/**/
		return apply_filters_ref_array ("ws_plugin__s2member_options", array (&$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]));
	}
/**/
call_user_func("ws_plugin__s2member_configure_options_and_their_defaults");
?>