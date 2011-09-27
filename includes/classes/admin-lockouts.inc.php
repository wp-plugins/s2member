<?php
/**
* Locks Users/Members out of admin panels.
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
* @package s2Member\Admin_Lockouts
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_admin_lockouts"))
	{
		/**
		* Locks Users/Members out of admin panels.
		*
		* @package s2Member\Admin_Lockouts
		* @since 3.5
		*/
		class c_ws_plugin__s2member_admin_lockouts
			{
				/**
				* Locks Users/Members out of admin panels.
				*
				* @package s2Member\Admin_Lockouts
				* @since 3.5
				*
				* @attaches-to ``add_action("admin_init");``
				*
				* @return null Or exits script execution after redirection.
				*/
				public static function admin_lockout () /* Prevents admin access. */
					{
						do_action ("ws_plugin__s2member_before_admin_lockouts", get_defined_vars ());
						/**/
						if ((!defined ("DOING_AJAX") || !DOING_AJAX) && !current_user_can ("edit_posts") && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["force_admin_lockouts"])
							if (apply_filters ("ws_plugin__s2member_admin_lockout", true, get_defined_vars ()) /* Give Filters a chance here too. */)
								{
									if ($redirection_url = c_ws_plugin__s2member_login_redirects::login_redirection_url ())
										wp_redirect ($redirection_url); /* Special Redirection. */
									/**/
									else /* Else we use the Login Welcome Page configured for s2Member. */
										wp_redirect (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]));
									/**/
									exit (); /* Clean exit. */
								}
						/**/
						do_action ("ws_plugin__s2member_after_admin_lockouts", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Filters administrative menu bars.
				*
				* @package s2Member\Admin_Lockouts
				* @since 3.5
				*
				* @attaches-to ``add_action("admin_bar_menu");``
				*
				* @param obj $wp_admin_bar Expects the ``$wp_admin_bar``, by reference; passed in by the Action Hook.
				* @return null After modifying ``$wp_admin_var``.
				*/
				public static function filter_admin_menu_bar (&$wp_admin_bar = FALSE)
					{
						global $current_site, $current_blog; /* In support of Multisite Networking. */
						/**/
						do_action ("ws_plugin__s2member_before_filter_admin_menu_bar", get_defined_vars ());
						/**/
						if (is_object ($wp_admin_bar) && !current_user_can ("edit_posts"))
							{
								if (isset ($wp_admin_bar->menu->{"dashboard"})) /* We don't need this. */
									unset ($wp_admin_bar->menu->{"dashboard"}); /* Remove this entire menu. */
								/**/
								if (is_multisite () && !c_ws_plugin__s2member_utils_conds::is_multisite_farm () && isset ($wp_admin_bar->menu->{"my-blogs"}))
									{
										$wp_admin_bar->menu->{"my-blogs"}["href"] = "#"; /* Void this link out by converting to `#`. */
										/**/
										if (isset ($wp_admin_bar->menu->{"my-blogs"}["children"]) && is_object ($wp_admin_bar->menu->{"my-blogs"}["children"]))
											foreach ($wp_admin_bar->menu->{"my-blogs"}["children"] as &$blog) /* Modify other Blog links in drop-down. */
												if (is_array ($blog) && isset ($blog["href"], $blog["children"]) && is_object ($blog["children"]))
													{
														$blog["href"] = preg_replace ("/\/wp-admin/", "", $blog["href"]);
														unset ($blog["children"]); /* Cause all we need is the link. */
													}
									}
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["force_admin_lockouts"] && apply_filters ("ws_plugin__s2member_admin_lockout", true, get_defined_vars ()))
									{
										$lwp = c_ws_plugin__s2member_login_redirects::login_redirection_url ($user);
										$lwp = (!$lwp) ? get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]) : $lwp;
										/**/
										if (isset ($wp_admin_bar->menu->{"my-account-with-avatar"})) /* Profile. */
											{
												if (isset ($wp_admin_bar->menu->{"my-account-with-avatar"}["href"]))
													$wp_admin_bar->menu->{"my-account-with-avatar"}["href"] = $lwp;
												/**/
												if (isset ($wp_admin_bar->menu->{"my-account-with-avatar"}["children"]->{"edit-profile"}["href"]))
													$wp_admin_bar->menu->{"my-account-with-avatar"}["children"]->{"edit-profile"}["href"] = $lwp;
											}
									}
							}
						/**/
						do_action ("ws_plugin__s2member_after_filter_admin_menu_bar", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>