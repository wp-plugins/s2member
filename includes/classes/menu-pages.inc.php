<?php
/**
* Administrative menu pages.
*
* Copyright: © 2009-2011
* {@link http://www.websharks-inc.com/ WebSharks, Inc.}
* ( coded in the USA )
*
* Released under the terms of the GNU General Public License.
* You should have received a copy of the GNU General Public License,
* along with this software. In the main directory, see: /licensing/
* If not, see: {@link http://www.gnu.org/licenses/}.
*
* @package s2Member\Menu_Pages
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_menu_pages"))
	{
		/**
		* Administrative menu pages.
		*
		* @package s2Member\Menu_Pages
		* @since 3.5
		*/
		class c_ws_plugin__s2member_menu_pages
			{
				/**
				* Saves all options from any menu page.
				* 
				* Can also be self-verified; and configured extensively with function parameters.
				*
				* @package s2Member\Menu_Pages
				* @since 3.5
				*
				* @param array $new_options Optional. Force feed an array of new options. Defaults to ``$_POST`` vars.
				* @param bool $verified Optional. Defaults to false. If true, ``wp_verify_nonce()`` is skipped in this routine.
				* @param bool $update_other Optional. Defaults to true. If false, other option-dependent routines will not be processed.
				* @param bool|array $display_notices Optional. Defaults to true. Can be false, or an array of certain notices that can be displayed.
				* @param bool|array $enqueue_notices Optional. Defaults to false. Can be true, or an array of certain notices that should be enqueued.
				* @param bool $request_refresh Optional. Defaults to false. If true, resulting `success` notice will include a link to refresh the menu page.
				* @return bool True if options were updated successfully.
				*/
				public static function update_all_options ($new_options = FALSE, $verified = FALSE, $update_other = TRUE, $display_notices = TRUE, $enqueue_notices = FALSE, $request_refresh = FALSE)
					{
						do_action ("ws_plugin__s2member_before_update_all_options", get_defined_vars ()); /* If you use this Hook, be sure to use `wp_verify_nonce()`. */
						/**/
						if ($verified || (!empty ($_POST["ws_plugin__s2member_options_save"]) && ($nonce = $_POST["ws_plugin__s2member_options_save"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-options-save")))
							{
								$options = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]; /* Here we get all of the existing options. */
								$new_options = (is_array ($new_options)) ? $new_options : ((!empty ($_POST)) ? stripslashes_deep ($_POST) : array ());
								$new_options = c_ws_plugin__s2member_utils_strings::trim_deep ($new_options);
								/**/
								foreach ((array)$new_options as $key => $value) /* Looking for relevant keys. */
									if (preg_match ("/^" . preg_quote ("ws_plugin__s2member_", "/") . "/", $key))
										/**/
										if ($key === "ws_plugin__s2member_configured") /* Configured. */
											{
												update_option ("ws_plugin__s2member_configured", $value);
												$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["configured"] = $value;
											}
										else /* Place this option into the array. Remove ws_plugin__s2member_. */
											{
												(is_array ($value)) ? array_shift ($value) : null; /* Arrays should be padded. */
												$key = preg_replace ("/^" . preg_quote ("ws_plugin__s2member_", "/") . "/", "", $key);
												$options[$key] = $value; /* Overriding a possible existing option. */
											}
								/**/
								$options["options_version"] = (string)($options["options_version"] + 0.001);
								$options = ws_plugin__s2member_configure_options_and_their_defaults ($options);
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_update_all_options", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								update_option ("ws_plugin__s2member_options", $options) . update_option ("ws_plugin__s2member_cache", array ());
								/**/
								if ($update_other === true || in_array ("auto_eot_system", (array)$update_other)) /* Handle the Auto-EOT System now ( enable/disable ). */
									($options["auto_eot_system_enabled"] == 1) ? c_ws_plugin__s2member_auto_eots::add_auto_eot_system () : c_ws_plugin__s2member_auto_eots::delete_auto_eot_system ();
								/**/
								if (($display_notices === true || in_array ("success", (array)$display_notices)) && ($notice = '<strong>Options saved.' . (($request_refresh) ? ' Please <a href="' . esc_attr ($_SERVER["REQUEST_URI"]) . '">refresh</a>.' : '') . '</strong>'))
									($enqueue_notices === true || in_array ("success", (array)$enqueue_notices)) ? c_ws_plugin__s2member_admin_notices::enqueue_admin_notice ($notice, "*:*") : c_ws_plugin__s2member_admin_notices::display_admin_notice ($notice);
								/**/
								if ($_GET["page"] !== "ws-plugin--s2member-mms-ops") /* Do NOT display page-conflict-warnings on the Main Multisite Configuration panel. */
									{
										if (!$options["membership_options_page"] && ($display_notices === true || in_array ("page-conflict-warnings", (array)$display_notices)) && ($notice = '<strong>NOTE:</strong> s2Member security restrictions will NOT be enforced until you\'ve configured a Membership Options Page. See: <code>s2Member -> General Options -> Membership Options Page</code>.'))
											($enqueue_notices === true || in_array ("page-conflict-warnings", (array)$enqueue_notices)) ? c_ws_plugin__s2member_admin_notices::enqueue_admin_notice ($notice, "*:*", true) : c_ws_plugin__s2member_admin_notices::display_admin_notice ($notice, true);
										/**/
										if ($options["login_welcome_page"] && $options["login_welcome_page"] === $options["membership_options_page"] && ($display_notices === true || in_array ("page-conflict-warnings", (array)$display_notices)) && ($notice = '<strong>s2Member:</strong> Your Login Welcome Page is the same as your Membership Options Page. Please correct this. See: <code>s2Member -> General Options -> Login Welcome Page</code>.'))
											($enqueue_notices === true || in_array ("page-conflict-warnings", (array)$enqueue_notices)) ? c_ws_plugin__s2member_admin_notices::enqueue_admin_notice ($notice, "*:*", true) : c_ws_plugin__s2member_admin_notices::display_admin_notice ($notice, true);
										/**/
										if ($options["membership_options_page"] && (string)get_option ("page_on_front") === $options["membership_options_page"] && ($display_notices === true || in_array ("page-conflict-warnings", (array)$display_notices)) && ($notice = '<strong>s2Member:</strong> Your Membership Options Page is currently configured as your Home Page ( i.e. static page ) for WordPress®. This causes internal conflicts with s2Member. Your Membership Options Page MUST stand alone. Please correct this. See: <code>WordPress® -> Reading Options</code>. Or change: <code>s2Member -> General Options -> Membership Options Page</code>.'))
											($enqueue_notices === true || in_array ("page-conflict-warnings", (array)$enqueue_notices)) ? c_ws_plugin__s2member_admin_notices::enqueue_admin_notice ($notice, "*:*", true) : c_ws_plugin__s2member_admin_notices::display_admin_notice ($notice, true);
										/**/
										if ($options["login_welcome_page"] && (string)get_option ("page_on_front") === $options["login_welcome_page"] && ($display_notices === true || in_array ("page-conflict-warnings", (array)$display_notices)) && ($notice = '<strong>s2Member:</strong> Your Login Welcome Page is currently configured as your Home Page ( i.e. static page ) for WordPress®. This causes internal conflicts with s2Member. Your Login Welcome Page MUST stand alone. Please correct this. See: <code>WordPress® -> Reading Options</code>. Or change: <code>s2Member -> General Options -> Login Welcome Page</code>.'))
											($enqueue_notices === true || in_array ("page-conflict-warnings", (array)$enqueue_notices)) ? c_ws_plugin__s2member_admin_notices::enqueue_admin_notice ($notice, "*:*", true) : c_ws_plugin__s2member_admin_notices::display_admin_notice ($notice, true);
										/**/
										if ($options["membership_options_page"] && (string)get_option ("page_for_posts") === $options["membership_options_page"] && ($display_notices === true || in_array ("page-conflict-warnings", (array)$display_notices)) && ($notice = '<strong>s2Member:</strong> Your Membership Options Page is currently configured as your Posts Page ( i.e. static page ) for WordPress®. This causes internal conflicts with s2Member. Your Membership Options Page MUST stand alone. Please correct this. See: <code>WordPress® -> Reading Options</code>. Or change: <code>s2Member -> General Options -> Membership Options Page</code>.'))
											($enqueue_notices === true || in_array ("page-conflict-warnings", (array)$enqueue_notices)) ? c_ws_plugin__s2member_admin_notices::enqueue_admin_notice ($notice, "*:*", true) : c_ws_plugin__s2member_admin_notices::display_admin_notice ($notice, true);
										/**/
										if ($options["login_welcome_page"] && (string)get_option ("page_for_posts") === $options["login_welcome_page"] && ($display_notices === true || in_array ("page-conflict-warnings", (array)$display_notices)) && ($notice = '<strong>s2Member:</strong> Your Login Welcome Page is currently configured as your Posts Page ( i.e. static page ) for WordPress®. This causes internal conflicts with s2Member. Your Login Welcome Page MUST stand alone. Please correct this. See: <code>WordPress® -> Reading Options</code>. Or change: <code>s2Member -> General Options -> Login Welcome Page</code>.'))
											($enqueue_notices === true || in_array ("page-conflict-warnings", (array)$enqueue_notices)) ? c_ws_plugin__s2member_admin_notices::enqueue_admin_notice ($notice, "*:*", true) : c_ws_plugin__s2member_admin_notices::display_admin_notice ($notice, true);
										/**/
										if ($options["file_download_limit_exceeded_page"] && $options["file_download_limit_exceeded_page"] === $options["membership_options_page"] && ($display_notices === true || in_array ("page-conflict-warnings", (array)$display_notices)) && ($notice = '<strong>s2Member:</strong> Your Download Limit Exceeded Page is the same as your Membership Options Page. Please correct this. See: <code>s2Member -> Download Options</code>.'))
											($enqueue_notices === true || in_array ("page-conflict-warnings", (array)$enqueue_notices)) ? c_ws_plugin__s2member_admin_notices::enqueue_admin_notice ($notice, "*:*", true) : c_ws_plugin__s2member_admin_notices::display_admin_notice ($notice, true);
									}
								/**/
								$updated_all_options = true; /* Flag indicating this routine was indeed processed. */
							}
						/**/
						do_action ("ws_plugin__s2member_after_update_all_options", get_defined_vars ());
						/**/
						return isset ($updated_all_options) ? $updated_all_options : false;
					}
				/**
				* Adds option menus / sub-menus.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @attaches-to: ``add_action("admin_menu");``
				*
				* @return null
				*/
				public static function add_admin_options ()
					{
						do_action ("ws_plugin__s2member_before_add_admin_options", get_defined_vars ());
						/**/
						add_filter ("plugin_action_links", "c_ws_plugin__s2member_menu_pages::_add_settings_link", 10, 2);
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_create_menu_items", true, get_defined_vars ()))
							{
								if ((is_multisite () && c_ws_plugin__s2member_utils_conds::is_multisite_farm () && !is_main_site ()) || apply_filters ("ws_plugin__s2member_during_add_admin_options_clear_right_side", false, get_defined_vars ()))
									$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"] = array (); /* Clear right side. */
								/**/
								$menu = apply_filters ("ws_plugin__s2member_during_add_admin_options_menu_slug", "ws-plugin--s2member-start", get_defined_vars ());
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_menu_page", true, get_defined_vars ()))
									add_menu_page ("s2Member®", "s2Member®", "create_users", $menu, "c_ws_plugin__s2member_menu_pages::start_page", $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images/brand-favicon.png");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_start_page", true, get_defined_vars ()))
									add_submenu_page ($menu, "s2Member Quick-Start Guide", "Quick-Start Guide", "create_users", "ws-plugin--s2member-start", "c_ws_plugin__s2member_menu_pages::start_page");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_divider_1", true, get_defined_vars ())) /* Divider. */
									add_submenu_page ($menu, "-", '<div style="margin:1px 0 1px -5px; height:1px; line-height:1px; background:#CCCCCC;"></div>', "create_users", "#");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_mms_ops_page", (!is_multisite () || is_main_site ()), get_defined_vars ()))
									add_submenu_page ($menu, "s2Member Multisite Configuration", "Multisite (Config)", "create_users", "ws-plugin--s2member-mms-ops", "c_ws_plugin__s2member_menu_pages::mms_ops_page");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_gen_ops_page", true, get_defined_vars ()))
									add_submenu_page ($menu, "s2Member General Options", "General Options", "create_users", "ws-plugin--s2member-gen-ops", "c_ws_plugin__s2member_menu_pages::gen_ops_page");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_res_ops_page", true, get_defined_vars ()))
									add_submenu_page ($menu, "s2Member Restriction Options", "Restriction Options", "create_users", "ws-plugin--s2member-res-ops", "c_ws_plugin__s2member_menu_pages::res_ops_page");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_down_ops_page", (!is_multisite () || !c_ws_plugin__s2member_utils_conds::is_multisite_farm () || is_main_site ()), get_defined_vars ()))
									add_submenu_page ($menu, "s2Member Download Options", "Download Options", "create_users", "ws-plugin--s2member-down-ops", "c_ws_plugin__s2member_menu_pages::down_ops_page");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_divider_2", true, get_defined_vars ())) /* Divider. */
									add_submenu_page ($menu, "-", '<div style="margin:1px 0 1px -5px; height:1px; line-height:1px; background:#CCCCCC;"></div>', "create_users", "#");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_new_user_page", true, get_defined_vars ())) /* Shortcut. */
									add_submenu_page ($menu, "s2Member / Add A Member", "Add A Member", "create_users", "user-new.php");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_browse_users_page", true, get_defined_vars ())) /* Shortcut. */
									add_submenu_page ($menu, "s2Member / Browse Members", "Browse Members", "create_users", "users.php");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_divider_3", true, get_defined_vars ())) /* Divider. */
									add_submenu_page ($menu, "-", '<div style="margin:1px 0 1px -5px; height:1px; line-height:1px; background:#CCCCCC;"></div>', "create_users", "#");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_paypal_ops_page", true, get_defined_vars ()))
									add_submenu_page ($menu, "s2Member PayPal Options", "PayPal® Options", "create_users", "ws-plugin--s2member-paypal-ops", "c_ws_plugin__s2member_menu_pages::paypal_ops_page");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_paypal_buttons_page", true, get_defined_vars ()))
									add_submenu_page ($menu, "s2Member PayPal® Buttons", "PayPal® Buttons", "create_users", "ws-plugin--s2member-paypal-buttons", "c_ws_plugin__s2member_menu_pages::paypal_buttons_page");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_divider_4", true, get_defined_vars ())) /* Divider. */
									add_submenu_page ($menu, "-", '<div style="margin:1px 0 1px -5px; height:1px; line-height:1px; background:#CCCCCC;"></div>', "create_users", "#");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_trk_ops_page", true, get_defined_vars ()))
									add_submenu_page ($menu, "s2Member API / Tracking", "API / Tracking", "create_users", "ws-plugin--s2member-trk-ops", "c_ws_plugin__s2member_menu_pages::trk_ops_page");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_els_ops_page", true, get_defined_vars ()))
									add_submenu_page ($menu, "s2Member API / List Servers", "API / List Servers", "create_users", "ws-plugin--s2member-els-ops", "c_ws_plugin__s2member_menu_pages::els_ops_page");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_api_ops_page", true, get_defined_vars ()))
									add_submenu_page ($menu, "s2Member API / Notifications", "API / Notifications", "create_users", "ws-plugin--s2member-api-ops", "c_ws_plugin__s2member_menu_pages::api_ops_page");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_scripting_page", true, get_defined_vars ()))
									add_submenu_page ($menu, "s2Member API / Scripting", "API / Scripting", "create_users", "ws-plugin--s2member-scripting", "c_ws_plugin__s2member_menu_pages::scripting_page");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_divider_5", true, get_defined_vars ())) /* Divider. */
									add_submenu_page ($menu, "-", '<div style="margin:1px 0 1px -5px; height:1px; line-height:1px; background:#CCCCCC;"></div>', "create_users", "#");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_integrations_page", (!is_multisite () || !c_ws_plugin__s2member_utils_conds::is_multisite_farm () || is_main_site ()), get_defined_vars ()))
									add_submenu_page ($menu, "s2Member / Other Integrations", "Other Integrations", "create_users", "ws-plugin--s2member-integrations", "c_ws_plugin__s2member_menu_pages::integrations_page");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_divider_6", true, get_defined_vars ())) /* Divider. */
									add_submenu_page ($menu, "-", '<div style="margin:1px 0 1px -5px; height:1px; line-height:1px; background:#CCCCCC;"></div>', "create_users", "#");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_info_page", (!is_multisite () || !c_ws_plugin__s2member_utils_conds::is_multisite_farm () || is_main_site ()), get_defined_vars ()))
									add_submenu_page ($menu, "s2Member Information", "s2Member Info", "create_users", "ws-plugin--s2member-info", "c_ws_plugin__s2member_menu_pages::info_page");
								/**/
								do_action ("ws_plugin__s2member_during_add_admin_options_additional_pages", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_after_add_admin_options", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Adds network option menus / sub-menus.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @attaches-to: ``add_action("network_admin_menu");``
				*
				* @return null
				*/
				public static function add_network_admin_options ()
					{
						do_action ("ws_plugin__s2member_before_add_network_admin_options", get_defined_vars ());
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_network_admin_options_create_menu_items", true, get_defined_vars ()))
							{
								if ((is_multisite () && c_ws_plugin__s2member_utils_conds::is_multisite_farm () && !is_main_site ()) || apply_filters ("ws_plugin__s2member_during_add_network_admin_options_clear_right_side", false, get_defined_vars ()))
									$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"] = array (); /* Clear right side. */
								/**/
								$menu = "ws-plugin--s2member-mms-ops"; /* Used below for nesting additional sub-menu pages. */
								/**/
								add_menu_page ("s2Member®", "s2Member®", "create_users", $menu, "c_ws_plugin__s2member_menu_pages::mms_ops_page", $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images/brand-favicon.png");
								/**/
								add_submenu_page ($menu, "s2Member Multisite ( Configuration )", "Multisite (Config)", "create_users", "ws-plugin--s2member-mms-ops", "c_ws_plugin__s2member_menu_pages::mms_ops_page");
								/**/
								if (apply_filters ("ws_plugin__s2member_during_add_network_admin_options_add_info_page", (!is_multisite () || !c_ws_plugin__s2member_utils_conds::is_multisite_farm () || is_main_site ()), get_defined_vars ()))
									add_submenu_page ($menu, "s2Member Information", "s2Member Info", "create_users", "ws-plugin--s2member-info", "c_ws_plugin__s2member_menu_pages::info_page");
								/**/
								do_action ("ws_plugin__s2member_during_add_network_admin_options_additional_pages", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_after_add_network_admin_options", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* A sort of callback function to add the settings link.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @attaches-to: ``add_filter("plugin_action_links");``
				*
				* @param array $links Expects an existing array of links, passed in by the Filter.
				* @param str $file Expects path to a plugin file. We need to test against this for s2Member.
				* @return array An array of links, Filtered by this routine.
				*/
				public static function _add_settings_link ($links = FALSE, $file = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_before_add_settings_link", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (preg_match ("/" . preg_quote ($file, "/") . "$/", $GLOBALS["WS_PLUGIN__"]["s2member"]["l"]) && is_array ($links))
							{
								$settings = '<a href="' . esc_attr (admin_url ("/admin.php?page=ws-plugin--s2member-gen-ops")) . '">Settings</a>';
								array_unshift ($links, apply_filters ("ws_plugin__s2member_add_settings_link", $settings, get_defined_vars ()));
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_add_settings_link", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						return apply_filters ("_ws_plugin__s2member_add_settings_link", $links, get_defined_vars ());
					}
				/**
				* Enqueue scripts for administrative menu pages.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @attaches-to: ``add_action("admin_print_scripts");``
				*
				* @return null
				*/
				public static function add_admin_scripts ()
					{
						do_action ("ws_plugin__s2member_before_add_admin_scripts", get_defined_vars ());
						/**/
						if (!empty ($_GET["page"]) && preg_match ("/ws-plugin--s2member-/", $_GET["page"]))
							{
								wp_enqueue_script ("jquery");
								wp_enqueue_script ("thickbox");
								wp_enqueue_script ("media-upload");
								wp_enqueue_script ("jquery-ui-core");
								wp_enqueue_script ("jquery-json-ps", $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/includes/menu-pages/jquery-json-ps-min.js", array ("jquery"), c_ws_plugin__s2member_utilities::ver_checksum ());
								wp_enqueue_script ("jquery-ui-effects", $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/includes/menu-pages/jquery-ui-effects.js", array ("jquery", "jquery-ui-core"), c_ws_plugin__s2member_utilities::ver_checksum ());
								wp_enqueue_script ("ws-plugin--s2member-menu-pages", site_url ("/?ws_plugin__s2member_menu_pages_js=" . urlencode (mt_rand ())), array ("jquery", "thickbox", "media-upload", "jquery-json-ps", "jquery-ui-core", "jquery-ui-effects", "password-strength-meter"), c_ws_plugin__s2member_utilities::ver_checksum ());
								/**/
								do_action ("ws_plugin__s2member_during_add_admin_scripts", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_after_add_admin_scripts", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Enqueue styles for administrative menu pages.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @attaches-to: ``add_action("admin_print_styles");``
				*
				* @return null
				*/
				public static function add_admin_styles ()
					{
						do_action ("ws_plugin__s2member_before_add_admin_styles", get_defined_vars ());
						/**/
						if (!empty ($_GET["page"]) && preg_match ("/ws-plugin--s2member-/", $_GET["page"]))
							{
								wp_enqueue_style ("thickbox");
								wp_enqueue_style ("ws-plugin--s2member-menu-pages", site_url ("/?ws_plugin__s2member_menu_pages_css=" . urlencode (mt_rand ())), array ("thickbox"), c_ws_plugin__s2member_utilities::ver_checksum (), "all");
								/**/
								do_action ("ws_plugin__s2member_during_add_admin_styles", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_after_add_admin_styles", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Builds and handles the Quick Start page.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @return null
				*/
				public static function start_page ()
					{
						do_action ("ws_plugin__s2member_before_start_page", get_defined_vars ());
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/start.inc.php";
						/**/
						do_action ("ws_plugin__s2member_after_start_page", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Builds and handles the Main Multisite Options page.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @return null
				*/
				public static function mms_ops_page ()
					{
						do_action ("ws_plugin__s2member_before_mms_ops_page", get_defined_vars ());
						/**/
						if (c_ws_plugin__s2member_menu_pages::update_all_options ())
							c_ws_plugin__s2member_mms_patches::mms_patches (true);
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/mms-ops.inc.php";
						/**/
						do_action ("ws_plugin__s2member_after_mms_ops_page", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Builds and handles the General Options page.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @return null
				*/
				public static function gen_ops_page ()
					{
						do_action ("ws_plugin__s2member_before_gen_ops_page", get_defined_vars ());
						/**/
						c_ws_plugin__s2member_menu_pages::update_all_options ();
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/gen-ops.inc.php";
						/**/
						do_action ("ws_plugin__s2member_after_gen_ops_page", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Builds and handles the Restriction Options page.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @return null
				*/
				public static function res_ops_page ()
					{
						do_action ("ws_plugin__s2member_before_res_ops_page", get_defined_vars ());
						/**/
						c_ws_plugin__s2member_menu_pages::update_all_options ();
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/res-ops.inc.php";
						/**/
						do_action ("ws_plugin__s2member_after_res_ops_page", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Builds and handles the Paypal Options page.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @return null
				*/
				public static function paypal_ops_page ()
					{
						do_action ("ws_plugin__s2member_before_paypal_ops_page", get_defined_vars ());
						/**/
						c_ws_plugin__s2member_menu_pages::update_all_options ();
						/**/
						$logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"];
						/**/
						if (!is_dir ($logs_dir) && is_writable (dirname (c_ws_plugin__s2member_utils_dirs::strip_dir_app_data ($logs_dir))))
							mkdir ($logs_dir, 0777, true) . clearstatcache ();
						/**/
						$htaccess = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"] . "/.htaccess";
						/**/
						if (is_dir ($logs_dir) && is_writable ($logs_dir) && !file_exists ($htaccess))
							file_put_contents ($htaccess, "deny from all") . clearstatcache ();
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["gateway_debug_logs"]) /* Logging enabled? */
							{
								if (!is_dir ($logs_dir)) /* If the security-enabled logs directory does not exist yet. */
									c_ws_plugin__s2member_admin_notices::display_admin_notice ("The security-enabled logs directory ( <code>" . esc_html (preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $logs_dir)) . "</code> ) does not exist. Please create this directory manually &amp; make it writable ( chmod 777 ).", true);
								/**/
								else if (!is_writable ($logs_dir)) /* If the logs directory is not writable yet. */
									c_ws_plugin__s2member_admin_notices::display_admin_notice ("Permissions error. The security-enabled logs directory ( <code>" . esc_html (preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $logs_dir)) . "</code> ) is not writable. Please make this directory writable ( chmod 777 ).", true);
								/**/
								if (!file_exists ($htaccess)) /* If the .htaccess file has not been created yet. */
									c_ws_plugin__s2member_admin_notices::display_admin_notice ("The .htaccess protection file ( <code>" . esc_html (preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $htaccess)) . "</code> ) does not exist. Please create this file manually. Inside your .htaccess file, add this one line: <code>deny from all</code>.", true);
								/**/
								else if (!preg_match ("/deny from all/i", file_get_contents ($htaccess))) /* Else if the .htaccess file does not offer the required protection. */
									c_ws_plugin__s2member_admin_notices::display_admin_notice ("Unprotected. The .htaccess protection file ( <code>" . esc_html (preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $htaccess)) . "</code> ) does not contain <code>deny from all</code>. Inside your .htaccess file, add this one line: <code>deny from all</code>.", true);
							}
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/paypal-ops.inc.php";
						/**/
						do_action ("ws_plugin__s2member_after_paypal_ops_page", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Builds and handles the Download Options page.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @return null
				*/
				public static function down_ops_page ()
					{
						do_action ("ws_plugin__s2member_before_down_ops_page", get_defined_vars ());
						/**/
						c_ws_plugin__s2member_menu_pages::update_all_options ();
						/**/
						if (!($using_amazon_s3_storage = 0) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_bucket"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_access_key"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_secret_key"])
							$using_amazon_s3_storage = true; /* Amazon® S3 storage has been configured! */
						/**/
						$files_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"];
						/**/
						if (!is_dir ($files_dir) && is_writable (dirname (c_ws_plugin__s2member_utils_dirs::strip_dir_app_data ($files_dir))))
							mkdir ($files_dir, 0777, true) . clearstatcache ();
						/**/
						$htaccess = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/.htaccess";
						/**/
						if (is_dir ($files_dir) && is_writable ($files_dir) && !file_exists ($htaccess))
							file_put_contents ($htaccess, "deny from all") . clearstatcache ();
						/**/
						if (!$using_amazon_s3_storage && !is_dir ($files_dir)) /* If the security-enabled files directory does not exist yet. */
							c_ws_plugin__s2member_admin_notices::display_admin_notice ("The security-enabled files directory ( <code>" . esc_html (preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $files_dir)) . "</code> ) does not exist. Please create this directory manually.", true);
						/**/
						if (!$using_amazon_s3_storage && !file_exists ($htaccess)) /* If the .htaccess file has not been created yet. */
							c_ws_plugin__s2member_admin_notices::display_admin_notice ("The .htaccess protection file ( <code>" . esc_html (preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $htaccess)) . "</code> ) does not exist. Please create this file manually. Inside your .htaccess file, add this one line: <code>deny from all</code>.", true);
						/**/
						else if (!$using_amazon_s3_storage && !preg_match ("/deny from all/i", file_get_contents ($htaccess))) /* Else if the .htaccess file does not offer the required protection. */
							c_ws_plugin__s2member_admin_notices::display_admin_notice ("Unprotected. The .htaccess protection file ( <code>" . esc_html (preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $htaccess)) . "</code> ) does not contain <code>deny from all</code>. Inside your .htaccess file, add this one line: <code>deny from all</code>.", true);
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/down-ops.inc.php";
						/**/
						do_action ("ws_plugin__s2member_after_down_ops_page", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Builds and handles the API Tracking options page.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @return null
				*/
				public static function trk_ops_page ()
					{
						do_action ("ws_plugin__s2member_before_trk_ops_page", get_defined_vars ());
						/**/
						c_ws_plugin__s2member_menu_pages::update_all_options ();
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/trk-ops.inc.php";
						/**/
						do_action ("ws_plugin__s2member_after_trk_ops_page", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Builds and handles the API List Server options page.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @return null
				*/
				public static function els_ops_page ()
					{
						do_action ("ws_plugin__s2member_before_els_ops_page", get_defined_vars ());
						/**/
						c_ws_plugin__s2member_menu_pages::update_all_options ();
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/els-ops.inc.php";
						/**/
						do_action ("ws_plugin__s2member_after_els_ops_page", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Builds and handles the API Notifications page.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @return null
				*/
				public static function api_ops_page ()
					{
						do_action ("ws_plugin__s2member_before_api_ops_page", get_defined_vars ());
						/**/
						c_ws_plugin__s2member_menu_pages::update_all_options ();
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/api-ops.inc.php";
						/**/
						do_action ("ws_plugin__s2member_after_api_ops_page", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Builds and handles the PayPal Button Generator page.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @return null
				*/
				public static function paypal_buttons_page ()
					{
						do_action ("ws_plugin__s2member_before_paypal_buttons_page", get_defined_vars ());
						/**/
						if (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"] || !$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_api_username"] || !$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_api_password"] || !$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_api_signature"])
							c_ws_plugin__s2member_admin_notices::display_admin_notice ('Please configure <code>s2Member -> PayPal® Options</code> first. Once all of your PayPal® Options are configured; including your Email Address, API Username, Password, and Signature; return to this page &amp; generate your PayPal® Button(s).', true);
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/paypal-buttons.inc.php";
						/**/
						do_action ("ws_plugin__s2member_after_paypal_buttons_page", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Builds and handles the API Scripting page.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @return null
				*/
				public static function scripting_page ()
					{
						do_action ("ws_plugin__s2member_before_scripting_page", get_defined_vars ());
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/scripting.inc.php";
						/**/
						do_action ("ws_plugin__s2member_after_scripting_page", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Builds and handles the Integrations page.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @return null
				*/
				public static function integrations_page ()
					{
						do_action ("ws_plugin__s2member_before_integrations_page", get_defined_vars ());
						/**/
						if (!empty ($_POST["ws_plugin__s2member_bridge_bbpress"]) && ($nonce = $_POST["ws_plugin__s2member_bridge_bbpress"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-bridge-bbpress") && ($_p = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($_POST))))
							{
								if (!empty ($_p["ws_plugin__s2member_bridge_bbpress_plugins_dir"]) && is_dir ($plugins_dir = untrailingslashit ($_p["ws_plugin__s2member_bridge_bbpress_plugins_dir"])))
									{
										if (is_writable ($plugins_dir)) /* This directory MUST be writable. */
											{
												if (preg_match ("/^Install/i", $_p["ws_plugin__s2member_bridge_bbpress_action"]))
													{
														$min = (string)$_p["ws_plugin__s2member_bridge_bbpress_min_level"];
														$ovg = (string)$_p["ws_plugin__s2member_bridge_bbpress_ovg"];
														/**/
														if (($file = file_get_contents (dirname (dirname (__FILE__)) . "/dropins/bridges/_s2member-bbpress-bridge.php")) && ($file = preg_replace ("/%%min%%/i", c_ws_plugin__s2member_utils_strings::esc_dq ($min), preg_replace ("/%%ovg%%/i", c_ws_plugin__s2member_utils_strings::esc_dq ($ovg), $file))) && file_put_contents ($plugins_dir . "/_s2member-bbpress-bridge.php", $file))
															c_ws_plugin__s2member_admin_notices::display_admin_notice ("The bbPress® Bridge/plugin has been <strong>installed successfully</strong>.");
														/**/
														else /* Otherwise, something unexpected. The site owner will need to install the bbPress® plugin manually. */
															c_ws_plugin__s2member_admin_notices::display_admin_notice ("Unknown error. Please try again, or install manually.", true);
													}
												/**/
												else if (preg_match ("/^Un-Install/i", $_p["ws_plugin__s2member_bridge_bbpress_action"]))
													{
														if (file_exists ($plugins_dir . "/_s2member-bbpress-bridge.php"))
															{
																if (!unlink ($plugins_dir . "/_s2member-bbpress-bridge.php")) /* Test return value of unlink. */
																	c_ws_plugin__s2member_admin_notices::display_admin_notice ("Unknown error. Please try again, or un-install manually.", true);
																/**/
																else /* Otherwise, everything looks good. The plugin file has been removed successfully. */
																	c_ws_plugin__s2member_admin_notices::display_admin_notice ("The bbPress® Bridge/plugin has been successfully <strong>uninstalled</strong>.");
															}
														else
															c_ws_plugin__s2member_admin_notices::display_admin_notice ("The bbPress® Bridge/plugin is already un-installed.", true);
													}
											}
										else
											c_ws_plugin__s2member_admin_notices::display_admin_notice ("The directory you specified is NOT writable. Please try again, or install manually.", true);
									}
								else
									c_ws_plugin__s2member_admin_notices::display_admin_notice ("The directory you specified does NOT exist. Please try again, or install manually.", true);
							}
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/integrations.inc.php";
						/**/
						do_action ("ws_plugin__s2member_after_integrations_page", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Builds and handles the s2Member Info page.
				* 
				* @package s2Member\Menu_Pages
				* @since 3.5
				* 
				* @return null
				*/
				public static function info_page ()
					{
						do_action ("ws_plugin__s2member_before_info_page", get_defined_vars ());
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/info.inc.php";
						/**/
						do_action ("ws_plugin__s2member_after_info_page", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>