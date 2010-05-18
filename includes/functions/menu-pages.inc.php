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
Function for saving all options from any page.
*/
function ws_plugin__s2member_update_all_options ()
	{
		do_action ("s2member_before_update_all_options");
		/**/
		if (($nonce = $_POST["ws_plugin__s2member_options_save"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-options-save"))
			{
				$options = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]; /* Get current options. */
				/**/
				foreach ($_POST as $key => $value) /* Go through each post variable and look for s2member. */
					{
						if (preg_match ("/^" . preg_quote ("ws_plugin__s2member", "/") . "/", $key)) /* Look for keys. */
							{
								if ($key === "ws_plugin__s2member_configured") /* This is a special configuration option. */
									{
										update_option ("ws_plugin__s2member_configured", trim (stripslashes ($value))); /* Update this option separately. */
										/**/
										$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["configured"] = trim (stripslashes ($value)); /* Update configuration on-the-fly. */
									}
								else /* We need to place this option into the array. Here we remove the ws_plugin__s2member_ portion on the beginning. */
									{
										(is_array ($value)) ? array_shift ($value) : null; /* Arrays should be padded, 1st key is removed. */
										$options[preg_replace ("/^" . preg_quote ("ws_plugin__s2member_", "/") . "/", "", $key)] = $value;
									}
							}
					}
				/**/
				$options["options_version"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] + 0.001; /* Increment options version. */
				/**/
				$options = ws_plugin__s2member_configure_options_and_their_defaults ($options); /* Also updates the global options array. */
				/**/
				update_option ("ws_plugin__s2member_options", $options) . update_option ("ws_plugin__s2member_cache", array ());
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["auto_eot_system_enabled"])
					ws_plugin__s2member_add_auto_eot_system (); /* Uses WP_Cron. */
				else /* Otherwise, the Auto-EOT System needs to be disabled. */
					ws_plugin__s2member_remove_auto_eot_system ();
				/**/
				do_action ("s2member_during_update_all_options"); /* Purposely after the update. */
				/**/
				ws_plugin__s2member_display_admin_notice ('<strong>Options saved.</strong>'); /* Display admin notice. */
			}
		/**/
		do_action ("s2member_after_update_all_options");
		/**/
		return;
	}
/*
Add the options menus & sub-menus.
Attach to: add_action("admin_menu");
*/
function ws_plugin__s2member_add_admin_options ()
	{
		do_action ("s2member_before_add_admin_options");
		/**/
		add_filter ("plugin_action_links", "_ws_plugin__s2member_add_settings_link", 10, 2);
		/**/
		add_menu_page ("s2Member Options", "s2Member", "edit_plugins", "ws-plugin--s2member-options", "ws_plugin__s2member_options_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member General Options", "General Options", "edit_plugins", "ws-plugin--s2member-options", "ws_plugin__s2member_options_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member PayPal Options", "PayPal® Options", "edit_plugins", "ws-plugin--s2member-paypal-ops", "ws_plugin__s2member_paypal_ops_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member PayPal® Buttons", "PayPal® Buttons", "edit_plugins", "ws-plugin--s2member-buttons", "ws_plugin__s2member_buttons_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member File Download Options", "Download Options", "edit_plugins", "ws-plugin--s2member-down-ops", "ws_plugin__s2member_down_ops_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member API / Tracking", "API / Tracking", "edit_plugins", "ws-plugin--s2member-trk-ops", "ws_plugin__s2member_trk_ops_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member API / List Servers", "API / List Servers", "edit_plugins", "ws-plugin--s2member-els-ops", "ws_plugin__s2member_els_ops_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member API / Notifications", "API / Notifications", "edit_plugins", "ws-plugin--s2member-api-ops", "ws_plugin__s2member_api_ops_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member API / Scripting", "API / Scripting", "edit_plugins", "ws-plugin--s2member-scripting", "ws_plugin__s2member_scripting_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member Information", "s2Member Info", "edit_plugins", "ws-plugin--s2member-info", "ws_plugin__s2member_info_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member Quick Start Guide", "Quick Start Guide", "edit_plugins", "ws-plugin--s2member-start", "ws_plugin__s2member_start_page");
		/**/
		do_action ("s2member_after_add_admin_options");
		/**/
		return;
	}
/*
A sort of callback function to add the settings link.
*/
function _ws_plugin__s2member_add_settings_link ($links = array (), $file = "")
	{
		do_action ("s2member_before_add_settings_link");
		/**/
		if (preg_match ("/" . preg_quote ($file, "/") . "$/", $GLOBALS["WS_PLUGIN__"]["s2member"]["l"]) && is_array ($links))
			{
				$settings = '<a href="admin.php?page=ws-plugin--s2member-options">Settings</a>';
				array_unshift ($links, apply_filters ("s2member_add_settings_link", $settings));
				/**/
				do_action ("s2member_during_add_settings_link");
			}
		/**/
		return apply_filters ("s2member_add_settings_link", $links);
	}
/*
Add scripts to admin panels.
Attach to: add_action("admin_print_scripts");
*/
function ws_plugin__s2member_add_admin_scripts ()
	{
		do_action ("s2member_before_add_admin_scripts");
		/**/
		if ($_GET["page"] && preg_match ("/ws-plugin--s2member-/", $_GET["page"]))
			{
				wp_enqueue_script ("jquery");
				wp_enqueue_script ("thickbox");
				wp_enqueue_script ("media-upload");
				wp_enqueue_script ("ws-plugin--s2member-menu-pages", get_bloginfo ("url") . "/?ws_plugin__s2member_menu_pages_js=1", array ("jquery", "thickbox", "media-upload"), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"]);
				/**/
				do_action ("s2member_during_add_admin_scripts");
			}
		/**/
		do_action ("s2member_after_add_admin_scripts");
		/**/
		return;
	}
/*
Add styles to admin panels.
Attach to: add_action("admin_print_styles");
*/
function ws_plugin__s2member_add_admin_styles ()
	{
		do_action ("s2member_before_add_admin_styles");
		/**/
		if ($_GET["page"] && preg_match ("/ws-plugin--s2member-/", $_GET["page"]))
			{
				wp_enqueue_style ("thickbox");
				wp_enqueue_style ("ws-plugin--s2member-menu-pages", get_bloginfo ("url") . "/?ws_plugin__s2member_menu_pages_css=1", array ("thickbox"), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"], "all");
				/**/
				do_action ("s2member_during_add_admin_styles");
			}
		/**/
		do_action ("s2member_after_add_admin_styles");
		/**/
		return;
	}
/*
Function that outputs the JS for menu pages.
Attach to: add_action("init");
*/
function ws_plugin__s2member_menu_pages_js ()
	{
		do_action ("s2member_before_menu_pages_js");
		/**/
		if ($_GET["ws_plugin__s2member_menu_pages_js"] && is_user_logged_in () && current_user_can ("edit_plugins"))
			{
				header ("Content-Type: text/javascript; charset=utf-8");
				header ("Expires: " . gmdate ("D, d M Y H:i:s", strtotime ("-1 week")) . " GMT");
				header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
				header ("Cache-Control: no-cache, must-revalidate, max-age=0");
				header ("Pragma: no-cache");
				/**/
				$u = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"];
				$i = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images";
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/menu-pages.js";
				/**/
				do_action ("s2member_during_menu_pages_js");
				/**/
				exit;
			}
		/**/
		do_action ("s2member_after_menu_pages_js");
	}
/*
Function that outputs the CSS for menu pages.
Attach to: add_action("init");
*/
function ws_plugin__s2member_menu_pages_css ()
	{
		do_action ("s2member_before_menu_pages_css");
		/**/
		if ($_GET["ws_plugin__s2member_menu_pages_css"] && is_user_logged_in () && current_user_can ("edit_plugins"))
			{
				header ("Content-Type: text/css; charset=utf-8");
				header ("Expires: " . gmdate ("D, d M Y H:i:s", strtotime ("-1 week")) . " GMT");
				header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
				header ("Cache-Control: no-cache, must-revalidate, max-age=0");
				header ("Pragma: no-cache");
				/**/
				$u = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"];
				$i = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images";
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/menu-pages.css";
				/**/
				do_action ("s2member_during_menu_pages_css");
				/**/
				exit;
			}
		/**/
		do_action ("s2member_after_menu_pages_css");
	}
/*
Function for building and handling the General Options page.
*/
function ws_plugin__s2member_options_page ()
	{
		do_action ("s2member_before_options_page");
		/**/
		ws_plugin__s2member_update_all_options ();
		/**/
		include_once dirname (dirname (__FILE__)) . "/menu-pages/options.inc.php";
		/**/
		do_action ("s2member_after_options_page");
		/**/
		return;
	}
/*
Function for building and handling the Paypal Options page.
*/
function ws_plugin__s2member_paypal_ops_page ()
	{
		do_action ("s2member_before_paypal_ops_page");
		/**/
		ws_plugin__s2member_update_all_options ();
		/**/
		$logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"];
		/**/
		if (!is_dir ($logs_dir) && is_writable (dirname ($logs_dir)))
			mkdir ($logs_dir, 0777) . clearstatcache ();
		/**/
		$htaccess = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"] . "/.htaccess";
		/**/
		if (is_dir ($logs_dir) && is_writable ($logs_dir) && !file_exists ($htaccess))
			file_put_contents ($htaccess, "deny from all") . clearstatcache ();
		/**/
		if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_debug"]) /* If logging is enabled. */
			{
				if (!is_dir ($logs_dir)) /* If the security-enabled logs directory does not exist yet. */
					ws_plugin__s2member_display_admin_notice ("The security-enabled logs directory ( <code>" . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $logs_dir) . "</code> ) does not exist. Please create this directory manually &amp; make it writable ( chmod 777 ).", true);
				/**/
				else if (!is_writable ($logs_dir)) /* If the logs directory is not writable yet. */
					ws_plugin__s2member_display_admin_notice ("Permissions error. The security-enabled logs directory ( <code>" . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $logs_dir) . "</code> ) is not writable. Please make this directory writable ( chmod 777 ).", true);
				/**/
				if (!file_exists ($htaccess)) /* If the .htaccess file has not been created yet. */
					ws_plugin__s2member_display_admin_notice ("The .htaccess protection file ( <code>" . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $htaccess) . "</code> ) does not exist. Please create this file manually. Inside your .htaccess file, add this one line: <code>deny from all</code>.", true);
				/**/
				else if (!preg_match ("/deny from all/i", file_get_contents ($htaccess))) /* Else if the .htaccess file does not offer the required protection. */
					ws_plugin__s2member_display_admin_notice ("Unprotected. The .htaccess protection file ( <code>" . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $htaccess) . "</code> ) does not contain <code>deny from all</code>. Inside your .htaccess file, add this one line: <code>deny from all</code>.", true);
			}
		/**/
		include_once dirname (dirname (__FILE__)) . "/menu-pages/paypal-ops.inc.php";
		/**/
		do_action ("s2member_after_paypal_ops_page");
		/**/
		return;
	}
/*
Function for building and handling the Download Options page.
*/
function ws_plugin__s2member_down_ops_page ()
	{
		do_action ("s2member_before_down_ops_page");
		/**/
		ws_plugin__s2member_update_all_options ();
		/**/
		$files_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"];
		/**/
		if (!is_dir ($files_dir) && is_writable (dirname ($files_dir)))
			mkdir ($files_dir, 0777) . clearstatcache ();
		/**/
		$htaccess = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/.htaccess";
		/**/
		if (is_dir ($files_dir) && is_writable ($files_dir) && !file_exists ($htaccess))
			file_put_contents ($htaccess, "deny from all") . clearstatcache ();
		/**/
		if (!is_dir ($files_dir)) /* If the security-enabled files directory does not exist yet. */
			ws_plugin__s2member_display_admin_notice ("The security-enabled files directory ( <code>" . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $files_dir) . "</code> ) does not exist. Please create this directory manually.", true);
		/**/
		if (!file_exists ($htaccess)) /* If the .htaccess file has not been created yet. */
			ws_plugin__s2member_display_admin_notice ("The .htaccess protection file ( <code>" . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $htaccess) . "</code> ) does not exist. Please create this file manually. Inside your .htaccess file, add this one line: <code>deny from all</code>.", true);
		/**/
		else if (!preg_match ("/deny from all/i", file_get_contents ($htaccess))) /* Else if the .htaccess file does not offer the required protection. */
			ws_plugin__s2member_display_admin_notice ("Unprotected. The .htaccess protection file ( <code>" . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $htaccess) . "</code> ) does not contain <code>deny from all</code>. Inside your .htaccess file, add this one line: <code>deny from all</code>.", true);
		/**/
		include_once dirname (dirname (__FILE__)) . "/menu-pages/down-ops.inc.php";
		/**/
		do_action ("s2member_after_down_ops_page");
		/**/
		return;
	}
/*
Function for building and handling the API Tracking options page.
*/
function ws_plugin__s2member_trk_ops_page ()
	{
		do_action ("s2member_before_trk_ops_page");
		/**/
		ws_plugin__s2member_update_all_options ();
		/**/
		include_once dirname (dirname (__FILE__)) . "/menu-pages/trk-ops.inc.php";
		/**/
		do_action ("s2member_after_trk_ops_page");
		/**/
		return;
	}
/*
Function for building and handling the API List Server options page.
*/
function ws_plugin__s2member_els_ops_page ()
	{
		do_action ("s2member_before_els_ops_page");
		/**/
		ws_plugin__s2member_update_all_options ();
		/**/
		include_once dirname (dirname (__FILE__)) . "/menu-pages/els-ops.inc.php";
		/**/
		do_action ("s2member_after_els_ops_page");
		/**/
		return;
	}
/*
Function for building and handling the API Notifications page.
*/
function ws_plugin__s2member_api_ops_page ()
	{
		do_action ("s2member_before_api_ops_page");
		/**/
		ws_plugin__s2member_update_all_options ();
		/**/
		include_once dirname (dirname (__FILE__)) . "/menu-pages/api-ops.inc.php";
		/**/
		do_action ("s2member_after_api_ops_page");
		/**/
		return;
	}
/*
Function for building the PayPal Button Generator page.
*/
function ws_plugin__s2member_buttons_page ()
	{
		do_action ("s2member_before_buttons_page");
		/**/
		include_once dirname (dirname (__FILE__)) . "/menu-pages/buttons.inc.php";
		/**/
		do_action ("s2member_after_buttons_page");
		/**/
		return;
	}
/*
Function for building the API Scripting page.
*/
function ws_plugin__s2member_scripting_page ()
	{
		do_action ("s2member_before_scripting_page");
		/**/
		include_once dirname (dirname (__FILE__)) . "/menu-pages/scripting.inc.php";
		/**/
		do_action ("s2member_after_scripting_page");
		/**/
		return;
	}
/*
Function for building the s2Member Info page.
*/
function ws_plugin__s2member_info_page ()
	{
		do_action ("s2member_before_info_page");
		/**/
		include_once dirname (dirname (__FILE__)) . "/menu-pages/info.inc.php";
		/**/
		do_action ("s2member_after_info_page");
		/**/
		return;
	}
/*
Function for building and handling the Quick Start page.
*/
function ws_plugin__s2member_start_page ()
	{
		do_action ("s2member_before_start_page");
		/**/
		include_once dirname (dirname (__FILE__)) . "/menu-pages/start.inc.php";
		/**/
		do_action ("s2member_after_start_page");
		/**/
		return;
	}
?>