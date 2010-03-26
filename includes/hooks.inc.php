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
Add the plugin actions/filters here.
*/
add_action ("init", "ws_plugin__s2member_nocache");
add_action ("init", "ws_plugin__s2member_constants");
add_action ("init", "ws_plugin__s2member_js_w_globals");
add_action ("init", "ws_plugin__s2member_menu_pages_js");
add_action ("init", "ws_plugin__s2member_menu_pages_css");
add_action ("init", "ws_plugin__s2member_paypal_return");
add_action ("init", "ws_plugin__s2member_paypal_notify");
add_action ("init", "ws_plugin__s2member_paypal_register");
add_action ("init", "ws_plugin__s2member_check_file_download_access");
add_action ("init", "ws_plugin__s2member_handle_profile_modifications");
/**/
add_action ("template_redirect", "ws_plugin__s2member_check_ruri_level_access");
add_action ("template_redirect", "ws_plugin__s2member_check_catg_level_access");
add_action ("template_redirect", "ws_plugin__s2member_check_ptag_level_access");
add_action ("template_redirect", "ws_plugin__s2member_check_post_level_access");
add_action ("template_redirect", "ws_plugin__s2member_check_page_level_access");
/**/
add_action ("wp_print_scripts", "ws_plugin__s2member_add_js_w_globals");
add_filter ("gettext", "ws_plugin__s2member_translation_mangler", 10, 3);
add_filter ("posts_where", "ws_plugin__s2member_hide_some_systematics");
/**/
add_action ("delete_user", "ws_plugin__s2member_handle_user_deletions");
add_filter ("pre_option_users_can_register", "ws_plugin__s2member_check_register_access");
add_action ("user_register", "ws_plugin__s2member_configure_user_registration");
add_action ("register_form", "ws_plugin__s2member_custom_registration_fields");
/**/
add_action ("wp_login", "ws_plugin__s2member_login_redirect");
add_action ("login_head", "ws_plugin__s2member_login_header_styles");
add_filter ("login_headerurl", "ws_plugin__s2member_login_header_url");
add_filter ("login_headertitle", "ws_plugin__s2member_login_header_title");
/**/
add_action ("admin_init", "ws_plugin__s2member_admin_lockout");
add_action ("admin_notices", "ws_plugin__s2member_admin_notices");
add_action ("admin_menu", "ws_plugin__s2member_add_admin_options");
add_action ("admin_print_scripts", "ws_plugin__s2member_add_admin_scripts");
add_action ("admin_print_styles", "ws_plugin__s2member_add_admin_styles");
/*
Register the activation | de-activation routines.
*/
register_activation_hook ($GLOBALS["WS_PLUGIN__"]["s2member"]["l"], "ws_plugin__s2member_activate");
register_deactivation_hook ($GLOBALS["WS_PLUGIN__"]["s2member"]["l"], "ws_plugin__s2member_deactivate");
?>