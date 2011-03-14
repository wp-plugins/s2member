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
if (!class_exists ("c_ws_plugin__s2member_user_securities"))
	{
		class c_ws_plugin__s2member_user_securities
			{
				/*
				Alters `WP_User->has_cap()` on a Multisite Blog Farm.
				Attach to: add_filter("user_has_cap");
				*/
				public static function ms_user_capabilities ($capabilities = FALSE, $caps_map = FALSE, $args = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_ms_user_capabilities", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_multisite () && c_ws_plugin__s2member_utils_conds::is_multisite_farm ())
							if ((is_super_admin () || $capabilities["administrator"]) && ($args[0] === "edit_user" || $args[0] === "edit_users"))
								if ($args[0] === "edit_users" || ($args[0] === "edit_user" && $args[2] && ((int)$args[1] === (int)$args[2] || is_user_member_of_blog ($args[2]))))
									$capabilities = array_merge ($capabilities, array ("edit_users" => 1, "do_not_allow" => 1));
						/**/
						return apply_filters ("ws_plugin__s2member_ms_user_capabilities", $capabilities, get_defined_vars ());
					}
				/*
				Alters this Filter inside `/wp-admin/user-edit.php`.
				Attach to: add_filter("enable_edit_any_user_configuration");
				*/
				public static function ms_allow_edits ($allow = FALSE)
					{
						global $user_id; /* Available inside `/wp-admin/user-edit.php`. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_ms_allow_edits", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_multisite () && c_ws_plugin__s2member_utils_conds::is_multisite_farm ())
							if (is_super_admin () || (current_user_can ("administrator") && $user_id && is_user_member_of_blog ($user_id)))
								$allow = true; /* Yes, allow Administrators to edit User Profiles. */
						/**/
						return apply_filters ("ws_plugin__s2member_ms_allow_edits", $allow, get_defined_vars ());
					}
				/*
				Hides Password fields for Demo Users; and deals with Password fields on Multisite Blog Farms.
				
				Demo accounts ( where the Username MUST be "demo" ), will NOT be allowed to change their Password.
				Any other restrictions you need to impose must be done through custom programming, using s2Member's Conditionals.
					See `s2Member -> API Scripting`.
				
				Attach to: add_filter("show_password_fields");
				*/
				public static function hide_password_fields ($show = TRUE, $user = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_hide_password_fields", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($show && is_multisite () && c_ws_plugin__s2member_utils_conds::is_multisite_farm ())
							if (!is_super_admin () && is_object ($user) && is_object ($current_user = wp_get_current_user ()))
								if ($user->ID !== $current_user->ID)
									$show = false;
						/**/
						if ($show && is_object ($user) && $user->user_login === "demo") /* Lock Password on Demos. */
							$show = false; /* Lock Password on Demos. */
						/**/
						return apply_filters ("ws_plugin__s2member_hide_password_fields", $show, get_defined_vars ());
					}
			}
	}
?>