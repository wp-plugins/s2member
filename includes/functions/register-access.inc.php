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
Function for checking registration form access.
Attach to: add_filter("pre_option_users_can_register");
*/
function ws_plugin__s2member_check_register_access ($users_can_register = FALSE)
	{
		if ($users_can_register)
			{
				return ($users_can_register = true);
			}
		else if ($_COOKIE["s2member_subscr_id"] && $_COOKIE["s2member_custom"] && preg_match ("/^[1-4]$/", $_COOKIE["s2member_level"]))
			{
				if (preg_match ("/\/wp-login\.php$/", $_SERVER["SCRIPT_FILENAME"]))
					{
						global $wpdb; /* Global database object reference. */
						/**/
						if (!$usermeta = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($_COOKIE["s2member_subscr_id"]) . "' LIMIT 1"))
							{
								return ($users_can_register = true);
							}
					}
			}
		/**/
		return $users_can_register;
	}
/*
Function for configuring the registration of new users.
Attach to: add_action("user_register");
*/
function ws_plugin__s2member_configure_user_registration ($user_id = FALSE)
	{
		if ($user_id && $_COOKIE["s2member_subscr_id"] && $_COOKIE["s2member_custom"] && preg_match ("/^[1-4]$/", $_COOKIE["s2member_level"]))
			{
				global $wpdb; /* We need to check the uniqueness of their subscription id. */
				/**/
				if (!$usermeta = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($_COOKIE["s2member_subscr_id"]) . "' LIMIT 1"))
					{
						ws_plugin__s2member_email_config ();
						/**/
						$user = new WP_User ($user_id);
						$user->set_role ("s2member_level" . $_COOKIE["s2member_level"]);
						/**/
						update_usermeta ($user_id, "s2member_subscr_id", $_COOKIE["s2member_subscr_id"]);
						update_usermeta ($user_id, "s2member_custom", $_COOKIE["s2member_custom"]);
					}
				/**/
				setcookie ("s2member_subscr_id", "", time () + 31556926, "/");
				setcookie ("s2member_custom", "", time () + 31556926, "/");
				setcookie ("s2member_level", "", time () + 31556926, "/");
			}
		/**/
		return;
	}
?>