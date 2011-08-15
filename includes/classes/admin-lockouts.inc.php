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
	exit("Do not access this file directly.");
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
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["force_admin_lockouts"] /* Now check for these WordPress® functionality Constants too. */
						&& (!defined ("XMLRPC_REQUEST") || !XMLRPC_REQUEST) && (!defined ("APP_REQUEST") || !APP_REQUEST) && (!defined ("DOING_AJAX") || !DOING_AJAX)/**/
						&& !current_user_can ("edit_posts")) /* And only if the current User is unable to edit Posts; otherwise we allow them in. */
							if (apply_filters ("ws_plugin__s2member_admin_lockout", true, get_defined_vars ())) /* Give Filters a chance too. */
								{
									if ($special_redirection_url = c_ws_plugin__s2member_login_redirects::login_redirection_url ())
										wp_redirect($special_redirection_url); /* Special Redirection. */
									/**/
									else /* Else we use the Login Welcome Page configured for s2Member. */
										wp_redirect(get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]));
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
						do_action ("ws_plugin__s2member_before_filter_admin_menu_bar", get_defined_vars ());
						/**/
						if (is_object ($wp_admin_bar) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["force_admin_lockouts"] /* Now check functionality Constants too. */
						&& (!defined ("XMLRPC_REQUEST") || !XMLRPC_REQUEST) && (!defined ("APP_REQUEST") || !APP_REQUEST) && (!defined ("DOING_AJAX") || !DOING_AJAX)/**/
						&& !current_user_can ("edit_posts")) /* And only if the current User is unable to edit Posts; otherwise we allow them in. */
							if (apply_filters ("ws_plugin__s2member_admin_lockout", true, get_defined_vars ())) /* Give Filters a chance too. */
								{
									if ($special_redirection_url = c_ws_plugin__s2member_login_redirects::login_redirection_url ())
										$lwp = $special_redirection_url;
									/**/
									else /* Else we use the Login Welcome Page configured for s2Member. */
										$lwp = get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]);
									/**/
									if (isset ($wp_admin_bar->menu->{"my-account-with-avatar"})) /* Profile. */
										{
											if (isset ($wp_admin_bar->menu->{"my-account-with-avatar"}["href"]))
												$wp_admin_bar->menu->{"my-account-with-avatar"}["href"] = $lwp;
											/**/
											if (isset ($wp_admin_bar->menu->{"my-account-with-avatar"}["children"]->{"edit-profile"}["href"]))
												$wp_admin_bar->menu->{"my-account-with-avatar"}["children"]->{"edit-profile"}["href"] = $lwp;
											/*
											Backward compatibility ( {"edit-my-profile"} ), prior to WordPress® 3.2. */
											if (isset ($wp_admin_bar->menu->{"my-account-with-avatar"}["children"]->{"edit-my-profile"}["href"]))
												$wp_admin_bar->menu->{"my-account-with-avatar"}["children"]->{"edit-my-profile"}["href"] = $lwp;
											/*
											Backward compatibility ( ["children"]->{"dashboard"} ), prior to WordPress® 3.2. */
											if (isset ($wp_admin_bar->menu->{"my-account-with-avatar"}["children"]->{"dashboard"}))
												unset($wp_admin_bar->menu->{"my-account-with-avatar"}["children"]->{"dashboard"});
										}
									/**/
									if (isset ($wp_admin_bar->menu->{"dashboard"})) /* Dashboard menu, we don't need this. */
										unset($wp_admin_bar->menu->{"dashboard"}); /* Removes this entire menu from the bar. */
									/**/
									if (isset ($wp_admin_bar->menu->{"my-blogs"}["href"])) /* Deals with multiple Blog drop-down. */
										{
											$wp_admin_bar->menu->{"my-blogs"}["href"] = "#"; /* Void this link out by converting to `#`. */
											/**/
											if (isset ($wp_admin_bar->menu->{"my-blogs"}["children"]) && is_object ($wp_admin_bar->menu->{"my-blogs"}["children"]))
												foreach ($wp_admin_bar->menu->{"my-blogs"}["children"] as &$blog) /* Modify other Blog links in drop-down. */
													if (is_array ($blog) && isset ($blog["href"], $blog["children"]) && is_object ($blog["children"]))
														{
															$blog["href"] = preg_replace ("/\/wp-admin/", "", $blog["href"]);
															unset($blog["children"]); /* Cause all we need is the link. */
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