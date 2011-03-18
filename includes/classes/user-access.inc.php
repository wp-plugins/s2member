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
if (!class_exists ("c_ws_plugin__s2member_user_access"))
	{
		class c_ws_plugin__s2member_user_access
			{
				/*
				Determines the Access Role of a User/Member.
				If $user is NOT passed in, check the current User/Member.
				If $user IS passed in, this function will check a specific $user.
					Returns their Role ID/code value.
				*/
				public static function user_access_role ($user = FALSE)
					{
						if ((func_num_args () && (!is_object ($user) || !$user->ID)) || (!func_num_args () && !$user && (!is_object ($user = (is_user_logged_in ()) ? wp_get_current_user () : false) || !$user->ID)))
							{
								return apply_filters ("ws_plugin__s2member_user_access_role", "", get_defined_vars ());
							}
						else /* Else we return the first Role in their array of assigned WordPress® Roles. */
							return apply_filters ("ws_plugin__s2member_user_access_role", reset ($user->roles), get_defined_vars ());
					}
				/*
				Determines Custom Capabilities of a User/Member.
				If $user is NOT passed in, check the current User/Member.
				If $user IS passed in, this function will check a specific $user.
					Returns an array of Custom Capabilities.
				*/
				public static function user_access_ccaps ($user = FALSE)
					{
						if ((func_num_args () && (!is_object ($user) || !$user->ID)) || (!func_num_args () && !$user && (!is_object ($user = (is_user_logged_in ()) ? wp_get_current_user () : false) || !$user->ID)))
							{
								return apply_filters ("ws_plugin__s2member_user_access_ccaps", array (), get_defined_vars ());
							}
						else /* Otherwise, we DO have the $user object available. */
							{
								$ccaps = array (); /* Initializes $ccaps array. */
								/**/
								foreach ($user->allcaps as $cap => $cap_enabled)
									if (preg_match ("/^access_s2member_ccap_/", $cap))
										$ccaps[] = preg_replace ("/^access_s2member_ccap_/", "", $cap);
								/**/
								return apply_filters ("ws_plugin__s2member_user_access_ccaps", $ccaps, get_defined_vars ());
							}
					}
				/*
				Determines Access Level of a User/Member.
				If $user is NOT passed in, check the current User/Member.
				If $user IS passed in, this function will check a specific $user.
				Returns -1 thru 4, according to the User/Member's Access Level.
				*/
				public static function user_access_level ($user = FALSE)
					{
						if ((func_num_args () && (!is_object ($user) || !$user->ID)) || (!func_num_args () && !$user && (!is_object ($user = (is_user_logged_in ()) ? wp_get_current_user () : false) || !$user->ID)))
							{
								return apply_filters ("ws_plugin__s2member_user_access_level", -1, get_defined_vars ()); /* No $user, or NOT logged in. */
							}
						else if ($user->has_cap ("access_s2member_level4")) /* Testing for Membership Level #4 access. */
							{
								return apply_filters ("ws_plugin__s2member_user_access_level", 4, get_defined_vars ());
							}
						else if ($user->has_cap ("access_s2member_level3")) /* Testing for Membership Level #3 access. */
							{
								return apply_filters ("ws_plugin__s2member_user_access_level", 3, get_defined_vars ());
							}
						else if ($user->has_cap ("access_s2member_level2")) /* Testing for Membership Level #2 access. */
							{
								return apply_filters ("ws_plugin__s2member_user_access_level", 2, get_defined_vars ());
							}
						else if ($user->has_cap ("access_s2member_level1")) /* Testing for Membership Level #1 access. */
							{
								return apply_filters ("ws_plugin__s2member_user_access_level", 1, get_defined_vars ());
							}
						else if ($user->has_cap ("access_s2member_level0")) /* Testing for Membership Level #0 access. */
							{
								return apply_filters ("ws_plugin__s2member_user_access_level", 0, get_defined_vars ());
							}
						else /* Else we assume this is a "User" ( a Free Subscriber with an Access Level of 0. ). */
							return apply_filters ("ws_plugin__s2member_user_access_level", 0, get_defined_vars ());
					}
			}
	}
?>