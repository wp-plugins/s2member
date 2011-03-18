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
if (!class_exists ("c_ws_plugin__s2member_admin_lockouts"))
	{
		class c_ws_plugin__s2member_admin_lockouts
			{
				/*
				Function for handling admin lockouts.
				Attach to: add_action("admin_init");
				*/
				public static function admin_lockout () /* Prevents admin access. */
					{
						do_action ("ws_plugin__s2member_before_admin_lockouts", get_defined_vars ());
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["force_admin_lockouts"] && /* Now check for these WordPress® functionality Constants too. */
						(!defined ("XMLRPC_REQUEST") || !XMLRPC_REQUEST) && (!defined ("APP_REQUEST") || !APP_REQUEST) && (!defined ("DOING_AJAX") || !DOING_AJAX)/**/
						&& !current_user_can ("edit_posts")) /* And only if the current User is unable to edit Posts; otherwise we allow them in. */
							if (apply_filters ("ws_plugin__s2member_admin_lockout", true, get_defined_vars ())) /* Give Filters a chance too. */
								{
									if ($special_redirection_url = c_ws_plugin__s2member_login_redirects::login_redirection_url ())
										wp_redirect($special_redirection_url); /* Special Redirection. */
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
				/*
				Function for modifying Admin Menu Bars.
				Attach to: add_action("admin_bar_menu");
				*/
				public static function filter_admin_menu_bar (&$wp_admin_bar = FALSE)
					{
						do_action ("ws_plugin__s2member_before_filter_admin_menu_bar", get_defined_vars ());
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["force_admin_lockouts"] && (!defined ("DOING_AJAX") || !DOING_AJAX) && !current_user_can ("edit_posts"))
							if (is_object ($wp_admin_bar) && apply_filters ("ws_plugin__s2member_admin_lockout", true, get_defined_vars ())) /* Give Filters a chance. */
								{
									if ($special_redirection_url = c_ws_plugin__s2member_login_redirects::login_redirection_url ())
										$lwp = $special_redirection_url; /* Use Special Redirection URL. */
									/**/
									else /* Else we use the Login Welcome Page configured for s2Member. */
										$lwp = get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]);
									/**/
									if (isset ($wp_admin_bar->menu->{"my-account-with-avatar"}["href"]) && isset ($wp_admin_bar->menu->{"my-account-with-avatar"}["children"]->{"edit-my-profile"}["href"]))
										{
											$wp_admin_bar->menu->{"my-account-with-avatar"}["href"] = $lwp;
											$wp_admin_bar->menu->{"my-account-with-avatar"}["children"]->{"edit-my-profile"}["href"] = $lwp;
											unset ($wp_admin_bar->menu->{"my-account-with-avatar"}["children"]->{"dashboard"});
										}
									/**/
									if (isset ($wp_admin_bar->menu->{"my-blogs"}["href"]) && isset ($wp_admin_bar->menu->{"my-blogs"}["children"]) && is_object ($wp_admin_bar->menu->{"my-blogs"}["children"]))
										{
											$wp_admin_bar->menu->{"my-blogs"}["href"] = "#"; /* Void this link by converting to #. */
											/**/
											foreach ($wp_admin_bar->menu->{"my-blogs"}["children"] as &$blog)
												if (is_array ($blog) && isset ($blog["href"]) && isset ($blog["children"]) && is_object ($blog["children"]))
													{
														$blog["href"] = preg_replace ("/\/wp-admin/", "", $blog["href"]);
														unset ($blog["children"]); /* Cause all we need is the link. */
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