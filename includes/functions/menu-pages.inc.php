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
	exit("Do not access this file directly.");
/*
Function for saving all options from any page.
*/
if (!function_exists ("ws_plugin__s2member_update_all_options"))
	{
		function ws_plugin__s2member_update_all_options ()
			{
				do_action ("ws_plugin__s2member_before_update_all_options", get_defined_vars ());
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
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_update_all_options", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						update_option ("ws_plugin__s2member_options", $options) . update_option ("ws_plugin__s2member_cache", array ());
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["auto_eot_system_enabled"] == 1)
							ws_plugin__s2member_add_auto_eot_system (); /* 1 == WP-Cron. */
						else /* Otherwise, the Auto-EOT System via WP-Cron is disabled. */
							ws_plugin__s2member_delete_auto_eot_system ();
						/**/
						ws_plugin__s2member_display_admin_notice('<strong>Options saved.</strong>');
						/**/
						if (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
							ws_plugin__s2member_display_admin_notice ('<strong>NOTE:</strong> s2Member security restrictions will NOT be enforced until you\'ve configured a Membership Options Page. See: <code>s2Member -> General Options -> Membership Options Page</code>.', true);
					}
				/**/
				do_action ("ws_plugin__s2member_after_update_all_options", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Add the options menus & sub-menus.
Attach to: add_action("admin_menu");
*/
if (!function_exists ("ws_plugin__s2member_add_admin_options"))
	{
		function ws_plugin__s2member_add_admin_options ()
			{
				global $menu; /* Need this to work out positioning. */
				/**/
				do_action ("ws_plugin__s2member_before_add_admin_options", get_defined_vars ());
				/**/
				add_filter ("plugin_action_links", "_ws_plugin__s2member_add_settings_link", 10, 2);
				/**/
				if (apply_filters ("ws_plugin__s2member_during_add_admin_options_create_menu_items", true, get_defined_vars ()))
					{
						add_menu_page ("s2Member Options", "s2Member", "edit_plugins", "ws-plugin--s2member-options", "ws_plugin__s2member_options_page");
						add_submenu_page ("ws-plugin--s2member-options", "s2Member General Options", "General Options", "edit_plugins", "ws-plugin--s2member-options", "ws_plugin__s2member_options_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_paypal_ops_page", true, get_defined_vars ()))
							add_submenu_page ("ws-plugin--s2member-options", "s2Member PayPal Options", "PayPal® Options", "edit_plugins", "ws-plugin--s2member-paypal-ops", "ws_plugin__s2member_paypal_ops_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_paypal_buttons_page", true, get_defined_vars ()))
							add_submenu_page ("ws-plugin--s2member-options", "s2Member PayPal® Buttons", "PayPal® Buttons", "edit_plugins", "ws-plugin--s2member-paypal-buttons", "ws_plugin__s2member_paypal_buttons_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_down_ops_page", true, get_defined_vars ()))
							add_submenu_page ("ws-plugin--s2member-options", "s2Member File Download Options", "Download Options", "edit_plugins", "ws-plugin--s2member-down-ops", "ws_plugin__s2member_down_ops_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_trk_ops_page", true, get_defined_vars ()))
							add_submenu_page ("ws-plugin--s2member-options", "s2Member API / Tracking", "API / Tracking", "edit_plugins", "ws-plugin--s2member-trk-ops", "ws_plugin__s2member_trk_ops_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_els_ops_page", true, get_defined_vars ()))
							add_submenu_page ("ws-plugin--s2member-options", "s2Member API / List Servers", "API / List Servers", "edit_plugins", "ws-plugin--s2member-els-ops", "ws_plugin__s2member_els_ops_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_api_ops_page", true, get_defined_vars ()))
							add_submenu_page ("ws-plugin--s2member-options", "s2Member API / Notifications", "API / Notifications", "edit_plugins", "ws-plugin--s2member-api-ops", "ws_plugin__s2member_api_ops_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_scripting_page", true, get_defined_vars ()))
							add_submenu_page ("ws-plugin--s2member-options", "s2Member API / Scripting", "API / Scripting", "edit_plugins", "ws-plugin--s2member-scripting", "ws_plugin__s2member_scripting_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_bridges_page", true, get_defined_vars ()))
							add_submenu_page ("ws-plugin--s2member-options", "s2Member Bridge Integrations", "API / Bridges", "edit_plugins", "ws-plugin--s2member-bridges", "ws_plugin__s2member_bridges_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_info_page", true, get_defined_vars ()))
							add_submenu_page ("ws-plugin--s2member-options", "s2Member Information", "s2Member Info", "edit_plugins", "ws-plugin--s2member-info", "ws_plugin__s2member_info_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_start_page", true, get_defined_vars ()))
							add_submenu_page ("ws-plugin--s2member-options", "s2Member Quick Start Guide", "Quick Start Guide", "edit_plugins", "ws-plugin--s2member-start", "ws_plugin__s2member_start_page");
					}
				/**/
				do_action ("ws_plugin__s2member_after_add_admin_options", get_defined_vars ());
				/**/
				return;
			}
	}
/*
A sort of callback function to add the settings link.
*/
if (!function_exists ("_ws_plugin__s2member_add_settings_link"))
	{
		function _ws_plugin__s2member_add_settings_link ($links = array (), $file = "")
			{
				eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("_ws_plugin__s2member_before_add_settings_link", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (preg_match ("/" . preg_quote ($file, "/") . "$/", $GLOBALS["WS_PLUGIN__"]["s2member"]["l"]) && is_array ($links))
					{
						$settings = '<a href="admin.php?page=ws-plugin--s2member-options">Settings</a>';
						array_unshift ($links, apply_filters ("ws_plugin__s2member_add_settings_link", $settings, get_defined_vars ()));
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_add_settings_link", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
					}
				/**/
				return apply_filters ("_ws_plugin__s2member_add_settings_link", $links, get_defined_vars ());
			}
	}
/*
Add scripts to admin panels.
Attach to: add_action("admin_print_scripts");
*/
if (!function_exists ("ws_plugin__s2member_add_admin_scripts"))
	{
		function ws_plugin__s2member_add_admin_scripts ()
			{
				do_action ("ws_plugin__s2member_before_add_admin_scripts", get_defined_vars ());
				/**/
				if ($_GET["page"] && preg_match ("/ws-plugin--s2member-/", $_GET["page"]))
					{
						wp_enqueue_script("jquery");
						wp_enqueue_script("thickbox");
						wp_enqueue_script("media-upload");
						wp_enqueue_script ("ws-plugin--s2member-menu-pages", get_bloginfo ("url") . "/?ws_plugin__s2member_menu_pages_js=1", array ("jquery", "thickbox", "media-upload"), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"]);
						/**/
						do_action ("ws_plugin__s2member_during_add_admin_scripts", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_add_admin_scripts", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Add styles to admin panels.
Attach to: add_action("admin_print_styles");
*/
if (!function_exists ("ws_plugin__s2member_add_admin_styles"))
	{
		function ws_plugin__s2member_add_admin_styles ()
			{
				do_action ("ws_plugin__s2member_before_add_admin_styles", get_defined_vars ());
				/**/
				if ($_GET["page"] && preg_match ("/ws-plugin--s2member-/", $_GET["page"]))
					{
						wp_enqueue_style("thickbox");
						wp_enqueue_style ("ws-plugin--s2member-menu-pages", get_bloginfo ("url") . "/?ws_plugin__s2member_menu_pages_css=1", array ("thickbox"), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"], "all");
						/**/
						do_action ("ws_plugin__s2member_during_add_admin_styles", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_add_admin_styles", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function that outputs the JS for menu pages.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_menu_pages_js"))
	{
		function ws_plugin__s2member_menu_pages_js ()
			{
				do_action ("ws_plugin__s2member_before_menu_pages_js", get_defined_vars ());
				/**/
				if ($_GET["ws_plugin__s2member_menu_pages_js"] && is_user_logged_in () && current_user_can ("edit_plugins"))
					{
						header("Content-Type: text/javascript; charset=utf-8");
						header("Expires: " . gmdate ("D, d M Y H:i:s", strtotime ("-1 week")) . " GMT");
						header("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
						header("Cache-Control: no-cache, must-revalidate, max-age=0");
						header("Pragma: no-cache");
						/**/
						$u = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"];
						$i = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images";
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/menu-pages.js";
						@include_once dirname (dirname (__FILE__)) . "/menu-pages/menu-pages-s.js";
						/**/
						do_action ("ws_plugin__s2member_during_menu_pages_js", get_defined_vars ());
						/**/
						exit ();
					}
				/**/
				do_action ("ws_plugin__s2member_after_menu_pages_js", get_defined_vars ());
			}
	}
/*
Function that outputs the CSS for menu pages.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_menu_pages_css"))
	{
		function ws_plugin__s2member_menu_pages_css ()
			{
				do_action ("ws_plugin__s2member_before_menu_pages_css", get_defined_vars ());
				/**/
				if ($_GET["ws_plugin__s2member_menu_pages_css"] && is_user_logged_in () && current_user_can ("edit_plugins"))
					{
						header("Content-Type: text/css; charset=utf-8");
						header("Expires: " . gmdate ("D, d M Y H:i:s", strtotime ("-1 week")) . " GMT");
						header("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
						header("Cache-Control: no-cache, must-revalidate, max-age=0");
						header("Pragma: no-cache");
						/**/
						$u = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"];
						$i = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images";
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/menu-pages.css";
						@include_once dirname (dirname (__FILE__)) . "/menu-pages/menu-pages-s.css";
						/**/
						do_action ("ws_plugin__s2member_during_menu_pages_css", get_defined_vars ());
						/**/
						exit ();
					}
				/**/
				do_action ("ws_plugin__s2member_after_menu_pages_css", get_defined_vars ());
			}
	}
/*
Function for building and handling the General Options page.
*/
if (!function_exists ("ws_plugin__s2member_options_page"))
	{
		function ws_plugin__s2member_options_page ()
			{
				do_action ("ws_plugin__s2member_before_options_page", get_defined_vars ());
				/**/
				ws_plugin__s2member_update_all_options ();
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/options.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_options_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building and handling the Paypal Options page.
*/
if (!function_exists ("ws_plugin__s2member_paypal_ops_page"))
	{
		function ws_plugin__s2member_paypal_ops_page ()
			{
				do_action ("ws_plugin__s2member_before_paypal_ops_page", get_defined_vars ());
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
				do_action ("ws_plugin__s2member_after_paypal_ops_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building and handling the Download Options page.
*/
if (!function_exists ("ws_plugin__s2member_down_ops_page"))
	{
		function ws_plugin__s2member_down_ops_page ()
			{
				do_action ("ws_plugin__s2member_before_down_ops_page", get_defined_vars ());
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
				do_action ("ws_plugin__s2member_after_down_ops_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building and handling the API Tracking options page.
*/
if (!function_exists ("ws_plugin__s2member_trk_ops_page"))
	{
		function ws_plugin__s2member_trk_ops_page ()
			{
				do_action ("ws_plugin__s2member_before_trk_ops_page", get_defined_vars ());
				/**/
				ws_plugin__s2member_update_all_options ();
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/trk-ops.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_trk_ops_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building and handling the API List Server options page.
*/
if (!function_exists ("ws_plugin__s2member_els_ops_page"))
	{
		function ws_plugin__s2member_els_ops_page ()
			{
				do_action ("ws_plugin__s2member_before_els_ops_page", get_defined_vars ());
				/**/
				ws_plugin__s2member_update_all_options ();
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/els-ops.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_els_ops_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building and handling the API Notifications page.
*/
if (!function_exists ("ws_plugin__s2member_api_ops_page"))
	{
		function ws_plugin__s2member_api_ops_page ()
			{
				do_action ("ws_plugin__s2member_before_api_ops_page", get_defined_vars ());
				/**/
				ws_plugin__s2member_update_all_options ();
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/api-ops.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_api_ops_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building the PayPal Button Generator page.
*/
if (!function_exists ("ws_plugin__s2member_paypal_buttons_page"))
	{
		function ws_plugin__s2member_paypal_buttons_page ()
			{
				do_action ("ws_plugin__s2member_before_paypal_buttons_page", get_defined_vars ());
				/**/
				if (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"]) /* Report error if PayPal® Options are not yet configured. */
					ws_plugin__s2member_display_admin_notice ('Please configure <code>s2Member -> PayPal® Options</code> first. Once all of your PayPal® Options have been configured, return to this page &amp; generate your PayPal® Button(s).', true);
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/paypal-buttons.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_paypal_buttons_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building the API Scripting page.
*/
if (!function_exists ("ws_plugin__s2member_scripting_page"))
	{
		function ws_plugin__s2member_scripting_page ()
			{
				do_action ("ws_plugin__s2member_before_scripting_page", get_defined_vars ());
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/scripting.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_scripting_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building the Bridge Integrations page.
*/
if (!function_exists ("ws_plugin__s2member_bridges_page"))
	{
		function ws_plugin__s2member_bridges_page ()
			{
				do_action ("ws_plugin__s2member_before_bridges_page", get_defined_vars ());
				/**/
				if (($nonce = $_POST["ws_plugin__s2member_bridge_bbpress"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-bridge-bbpress"))
					{
						if (($plugins_dir = trim (rtrim (stripslashes ($_POST["ws_plugin__s2member_bridge_bbpress_plugins_dir"]), "/"))) && is_dir ($plugins_dir))
							{
								if (is_writable ($plugins_dir)) /* This directory MUST be writable. Otherwise, file_put_contents() will fail. */
									{
										if (preg_match ("/^Install/i", $_POST["ws_plugin__s2member_bridge_bbpress_action"]))
											{
												$min = (string)$_POST["ws_plugin__s2member_bridge_bbpress_min_level"];
												/**/
												if (($file = file_get_contents (dirname (dirname (__FILE__)) . "/dropins/bridges/_s2member-bbpress-bridge.php")) && ($file = preg_replace ("/%%min%%/i", ws_plugin__s2member_esc_dq ($min), $file)) && file_put_contents ($plugins_dir . "/_s2member-bbpress-bridge.php", $file))
													ws_plugin__s2member_display_admin_notice("The bbPress® Bridge/plugin has been <strong>installed successfully</strong>.");
												/**/
												else /* Otherwise, something unexpected. The site owner will need to install the bbPress® plugin manually. */
													ws_plugin__s2member_display_admin_notice ("Unknown error. Please try again, or install manually.", true);
											}
										/**/
										else if (preg_match ("/^Un-Install/i", $_POST["ws_plugin__s2member_bridge_bbpress_action"]))
											{
												if (file_exists ($plugins_dir . "/_s2member-bbpress-bridge.php"))
													{
														if (!unlink ($plugins_dir . "/_s2member-bbpress-bridge.php")) /* Test return value of unlink. */
															ws_plugin__s2member_display_admin_notice ("Unknown error. Please try again, or un-install manually.", true);
														/**/
														else /* Otherwise, everything looks good. The plugin file has been removed successfully. */
															ws_plugin__s2member_display_admin_notice("The bbPress® Bridge/plugin has been successfully <strong>un-installed</strong>.");
													}
												else
													ws_plugin__s2member_display_admin_notice ("The bbPress® Bridge/plugin is already un-installed.", true);
											}
									}
								else
									ws_plugin__s2member_display_admin_notice ("The directory you specified is NOT writable. Please try again, or install manually.", true);
							}
						else
							ws_plugin__s2member_display_admin_notice ("The directory you specified does NOT exist. Please try again, or install manually.", true);
					}
				/**/
				if (!is_dir ($plugins_dir_guess = $_SERVER["DOCUMENT_ROOT"] . "/bbpress/my-plugins"))
					if (!is_dir ($plugins_dir_guess = $_SERVER["DOCUMENT_ROOT"] . "/forums/my-plugins"))
						if (!is_dir ($plugins_dir_guess = $_SERVER["DOCUMENT_ROOT"] . "/bbpress/bb-plugins"))
							if (!is_dir ($plugins_dir_guess = $_SERVER["DOCUMENT_ROOT"] . "/forums/bb-plugins"))
								$plugins_dir_guess = ($plugins_dir) ? $plugins_dir : $plugins_dir_guess;
				/**/
				$_bridge_bbpress_plugins_dir_guess = ($plugins_dir) ? $plugins_dir : $plugins_dir_guess;
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/bridges.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_bridges_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building the s2Member Info page.
*/
if (!function_exists ("ws_plugin__s2member_info_page"))
	{
		function ws_plugin__s2member_info_page ()
			{
				do_action ("ws_plugin__s2member_before_info_page", get_defined_vars ());
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/info.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_info_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building and handling the Quick Start page.
*/
if (!function_exists ("ws_plugin__s2member_start_page"))
	{
		function ws_plugin__s2member_start_page ()
			{
				do_action ("ws_plugin__s2member_before_start_page", get_defined_vars ());
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/start.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_start_page", get_defined_vars ());
				/**/
				return;
			}
	}
?>