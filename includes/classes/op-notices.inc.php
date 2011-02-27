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
if (!class_exists ("c_ws_plugin__s2member_op_notices"))
	{
		class c_ws_plugin__s2member_op_notices
			{
				/*
				Function that describes the General Option overrides for clarity.
				Attach to: add_action("admin_init");
				*/
				public static function general_ops_notice ()
					{
						global $pagenow; /* Need this global variable. */
						/**/
						do_action ("ws_plugin__s2member_before_general_ops_notice", get_defined_vars ());
						/**/
						if (c_ws_plugin__s2member_utils_conds::is_blog_admin () && $pagenow === "options-general.php" && !isset ($_GET["page"]) && !is_multisite ()) /* Multisite does NOT provide these options. */
							{
								$notice = "<em>* Note: The s2Member plugin has control over two options on this page.<br /><code>Allow Open Registration = " . esc_html (get_option ("users_can_register")) . "</code>, and <code>Default Role = " . esc_html (get_option ("default_role")) . "</code>.<br />For further details, see: <code>s2Member -> General Options -> Open Registration</code>.";
								/**/
								$js = '<script type="text/javascript">';
								$js .= "jQuery('input#users_can_register, select#default_role').attr('disabled', 'disabled');";
								$js .= '</script>';
								/**/
								do_action ("ws_plugin__s2member_during_general_ops_notice", get_defined_vars ());
								/**/
								c_ws_plugin__s2member_admin_notices::enqueue_admin_notice ($notice . $js, "blog:" . $pagenow);
							}
						/**/
						do_action ("ws_plugin__s2member_after_general_ops_notice", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Function that describes the Multisite Option overrides for clarity.
				Attach to: add_action("admin_init");
				*/
				public static function multisite_ops_notice ()
					{
						global $pagenow; /* Need this global variable. */
						/**/
						do_action ("ws_plugin__s2member_before_multisite_ops_notice", get_defined_vars ());
						/**/
						if (is_multisite () && c_ws_plugin__s2member_utils_conds::is_network_admin () && in_array ($pagenow, array ("settings.php", "ms-options.php")) && !isset ($_GET["page"]))
							{
								if (version_compare (get_bloginfo ("version"), "3.1-RC", ">="))
									{
										$notice = "<em>* Note: The s2Member plugin has control over two options on this page.<br /><code>Allow Open Registration = " . esc_html (get_site_option ("registration")) . "</code>  and <code>Add New Users = " . esc_html (get_site_option ("add_new_users")) . "</code>.<br />Please check: <code>s2Member -> Multisite ( Config )</code>.";
										/**/
										$js = '<script type="text/javascript">';
										$js .= "jQuery('input[name=registration], input#add_new_users').attr('disabled', 'disabled');";
										$js .= '</script>';
									}
								else /* Else we use the old WordPress® v3.0.x method of disabling these important options. */
									{
										$notice = "<em>* Note: The s2Member plugin has control over four options on this page.<br /><code>Dashboard Blog = " . esc_html (get_site_option ("dashboard_blog")) . " / Main Site</code>, <code>Default Role = " . esc_html (get_site_option ("default_user_role")) . "</code>, <code>Allow Open Registration = " . esc_html (get_site_option ("registration")) . "</code>, and <code>Add New Users = " . esc_html (get_site_option ("add_new_users")) . "</code>.<br />In your Dashboard ( on the Main Site ), see: <code>s2Member -> Multisite ( Config )</code>.";
										/**/
										$js = '<script type="text/javascript">';
										$js .= "jQuery('input#dashboard_blog, select#default_user_role, input[name=registration], input#add_new_users').attr('disabled', 'disabled');";
										$js .= '</script>';
									}
								/**/
								do_action ("ws_plugin__s2member_during_multisite_ops_notice", get_defined_vars ());
								/**/
								c_ws_plugin__s2member_admin_notices::enqueue_admin_notice ($notice . $js, "network:" . $pagenow);
							}
						/**/
						do_action ("ws_plugin__s2member_after_multisite_ops_notice", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Function that deals with Reading Option conflicts.
				Attach to: add_action("admin_init");
				*/
				public static function reading_ops_notice ()
					{
						global $pagenow; /* Need this global variable. */
						/**/
						do_action ("ws_plugin__s2member_before_reading_ops_notice", get_defined_vars ());
						/**/
						if (c_ws_plugin__s2member_utils_conds::is_blog_admin () && $pagenow === "options-reading.php" && !isset ($_GET["page"]))
							{
								do_action ("ws_plugin__s2member_during_reading_ops_notice", get_defined_vars ()); /* Now check for conflicts. */
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"] && (string)get_option ("page_on_front") === $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]/**/
								&& ($notice = '<strong>NOTE:</strong> Your Membership Options Page for s2Member is currently configured as your Home Page ( i.e. static page ) for WordPress®. This causes internal conflicts with s2Member. Your Membership Options Page MUST stand alone. Please correct this.'))
									c_ws_plugin__s2member_admin_notices::enqueue_admin_notice ($notice, "blog:" . $pagenow, true);
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"] && (string)get_option ("page_on_front") === $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]/**/
								&& ($notice = '<strong>NOTE:</strong> Your Login Welcome Page for s2Member is currently configured as your Home Page ( i.e. static page ) for WordPress®. This causes internal conflicts with s2Member. Your Login Welcome Page MUST stand alone. Please correct this.'))
									c_ws_plugin__s2member_admin_notices::enqueue_admin_notice ($notice, "blog:" . $pagenow, true);
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"] && (string)get_option ("page_for_posts") === $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]/**/
								&& ($notice = '<strong>NOTE:</strong> Your Membership Options Page for s2Member is currently configured as your Posts Page ( i.e. static page ) for WordPress®. This causes internal conflicts with s2Member. Your Membership Options Page MUST stand alone. Please correct this.'))
									c_ws_plugin__s2member_admin_notices::enqueue_admin_notice ($notice, "blog:" . $pagenow, true);
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"] && (string)get_option ("page_for_posts") === $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]/**/
								&& ($notice = '<strong>NOTE:</strong> Your Login Welcome Page for s2Member is currently configured as your Posts Page ( i.e. static page ) for WordPress®. This causes internal conflicts with s2Member. Your Login Welcome Page MUST stand alone. Please correct this.'))
									c_ws_plugin__s2member_admin_notices::enqueue_admin_notice ($notice, "blog:" . $pagenow, true);
							}
						/**/
						do_action ("ws_plugin__s2member_after_reading_ops_notice", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>