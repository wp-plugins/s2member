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
				ws_plugin__s2member_display_admin_notice ('<strong>Options saved.</strong>'); /* Display admin notice. */
			}
		/**/
		return;
	}
/*
Add the options menus & sub-menus.
Attach to: add_action("admin_menu");
*/
function ws_plugin__s2member_add_admin_options ()
	{
		add_filter ("plugin_action_links", "_ws_plugin__s2member_add_settings_link", 10, 2);
		/**/
		add_menu_page ("s2Member Options", "s2Member", "edit_plugins", "ws-plugin--s2member-options", "ws_plugin__s2member_options_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member General Options", "General Options", "edit_plugins", "ws-plugin--s2member-options", "ws_plugin__s2member_options_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member PayPal Options", "PayPal® Options", "edit_plugins", "ws-plugin--s2member-paypal-ops", "ws_plugin__s2member_paypal_ops_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member PayPal® Buttons", "PayPal® Buttons", "edit_plugins", "ws-plugin--s2member-buttons", "ws_plugin__s2member_buttons_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member File Download Options", "Download Options", "edit_plugins", "ws-plugin--s2member-down-ops", "ws_plugin__s2member_down_ops_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member Pixel Tracking", "Pixel Tracking", "edit_plugins", "ws-plugin--s2member-pix-ops", "ws_plugin__s2member_pix_ops_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member API Options", "API Urls/Options", "edit_plugins", "ws-plugin--s2member-api-ops", "ws_plugin__s2member_api_ops_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member Advanced Scripting", "Advanced Scripting", "edit_plugins", "ws-plugin--s2member-scripting", "ws_plugin__s2member_scripting_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member Flow Of Events", "Flow Of Events", "edit_plugins", "ws-plugin--s2member-events", "ws_plugin__s2member_events_page");
		add_submenu_page ("ws-plugin--s2member-options", "s2Member Information", "s2Member Info", "edit_plugins", "ws-plugin--s2member-info", "ws_plugin__s2member_info_page");
		/**/
		return;
	}
/*
A sort of callback function to add the settings link.
*/
function _ws_plugin__s2member_add_settings_link ($links = array (), $file = "")
	{
		if (preg_match ("/" . preg_quote ($file, "/") . "$/", $GLOBALS["WS_PLUGIN__"]["s2member"]["l"]) && is_array ($links))
			{
				$settings = '<a href="admin.php?page=ws-plugin--s2member-options">Settings</a>';
				array_unshift ($links, $settings);
			}
		/**/
		return $links;
	}
/*
Add scripts to admin panels.
Attach to: add_action("admin_print_scripts");
*/
function ws_plugin__s2member_add_admin_scripts ()
	{
		if ($_GET["page"] && preg_match ("/ws-plugin--s2member-/", $_GET["page"]))
			{
				wp_enqueue_script ("jquery");
				wp_enqueue_script ("thickbox");
				wp_enqueue_script ("media-upload");
				wp_enqueue_script ("ws-plugin--s2member-menu-pages", get_bloginfo ("url") . "/?ws_plugin__s2member_menu_pages_js=1", array ("jquery", "thickbox", "media-upload"), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"]);
			}
		/**/
		return;
	}
/*
Add styles to admin panels.
Attach to: add_action("admin_print_styles");
*/
function ws_plugin__s2member_add_admin_styles ()
	{
		if ($_GET["page"] && preg_match ("/ws-plugin--s2member-/", $_GET["page"]))
			{
				wp_enqueue_style ("thickbox");
				wp_enqueue_style ("ws-plugin--s2member-menu-pages", get_bloginfo ("url") . "/?ws_plugin__s2member_menu_pages_css=1", array ("thickbox"), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"], "all");
			}
		/**/
		return;
	}
/*
Function that outputs the js for menu pages.
Attach to: add_action("init");
*/
function ws_plugin__s2member_menu_pages_js ()
	{
		if ($_GET["ws_plugin__s2member_menu_pages_js"] && is_user_logged_in () && current_user_can ("edit_plugins"))
			{
				header ("Content-Type: text/javascript; charset=utf-8");
				/**/
				$u = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"];
				$i = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images";
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/menu-pages.js";
				/**/
				exit;
			}
	}
/*
Function that outputs the css for menu pages.
Attach to: add_action("init");
*/
function ws_plugin__s2member_menu_pages_css ()
	{
		if ($_GET["ws_plugin__s2member_menu_pages_css"] && is_user_logged_in () && current_user_can ("edit_plugins"))
			{
				header ("Content-Type: text/css; charset=utf-8");
				/**/
				$u = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"];
				$i = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images";
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/menu-pages.css";
				/**/
				exit;
			}
	}
/*
Function for building and handling the options page.
*/
function ws_plugin__s2member_options_page ()
	{
		ws_plugin__s2member_update_all_options ();
		/**/
		include_once dirname (dirname (__FILE__)) . "/menu-pages/options.inc.php";
		/**/
		return;
	}
/*
Function for building and handling the paypal options page.
*/
function ws_plugin__s2member_paypal_ops_page ()
	{
		ws_plugin__s2member_update_all_options ();
		/**/
		$logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"];
		/**/
		if (!is_dir ($logs_dir) && is_writable (dirname ($logs_dir)))
			mkdir ($logs_dir, 0777);
		/**/
		$htaccess = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"] . "/.htaccess";
		/**/
		if (is_dir ($logs_dir) && is_writable ($logs_dir) && !file_exists ($htaccess))
			file_put_contents ($htaccess, "deny from all");
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
		return;
	}
/*
Function for building and handling the download options page.
*/
function ws_plugin__s2member_down_ops_page ()
	{
		ws_plugin__s2member_update_all_options ();
		/**/
		$files_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"];
		/**/
		if (!is_dir ($files_dir) && is_writable (dirname ($files_dir)))
			mkdir ($files_dir, 0777);
		/**/
		$htaccess = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/.htaccess";
		/**/
		if (is_dir ($files_dir) && is_writable ($files_dir) && !file_exists ($htaccess))
			file_put_contents ($htaccess, "deny from all");
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
		return;
	}
/*
Function for building and handling the pixel tracking options page.
*/
function ws_plugin__s2member_pix_ops_page ()
	{
		ws_plugin__s2member_update_all_options ();
		/**/
		include_once dirname (dirname (__FILE__)) . "/menu-pages/pix-ops.inc.php";
		/**/
		return;
	}
/*
Function for building and handling the api options page.
*/
function ws_plugin__s2member_api_ops_page ()
	{
		ws_plugin__s2member_update_all_options ();
		/**/
		include_once dirname (dirname (__FILE__)) . "/menu-pages/api-ops.inc.php";
		/**/
		return;
	}
/*
Function for building the buttons page.
*/
function ws_plugin__s2member_buttons_page ()
	{
		include_once dirname (dirname (__FILE__)) . "/menu-pages/buttons.inc.php";
		/**/
		return;
	}
/*
Function for building the scripting page.
*/
function ws_plugin__s2member_scripting_page ()
	{
		include_once dirname (dirname (__FILE__)) . "/menu-pages/scripting.inc.php";
		/**/
		return;
	}
/*
Function for building the events page.
*/
function ws_plugin__s2member_events_page ()
	{
		include_once dirname (dirname (__FILE__)) . "/menu-pages/events.inc.php";
		/**/
		return;
	}
/*
Function for building the info page.
*/
function ws_plugin__s2member_info_page ()
	{
		include_once dirname (dirname (__FILE__)) . "/menu-pages/info.inc.php";
		/**/
		return;
	}
?>