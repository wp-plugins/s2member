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
				global $wpdb; /* Global database object reference. */
				/**/
				if (!$usermeta = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($_COOKIE["s2member_subscr_id"]) . "' LIMIT 1"))
					{
						return ($users_can_register = true);
					}
			}
		/**/
		return $users_can_register;
	}
/*
This adds custom fields to the registration form.
Attach to: add_action("register_form");
*/
function ws_plugin__s2member_custom_registration_fields ()
	{
		if ($_COOKIE["s2member_subscr_id"] && $_COOKIE["s2member_custom"] && preg_match ("/^[1-4]$/", $_COOKIE["s2member_level"]) && ($tabindex = 20))
			{
				echo '<p>' . "\n";
				echo '<label>' . "\n";
				echo 'First Name' . "\n";
				echo '<input type="text" name="s2member_custom_reg_field_first_name" id="s2member-custom-reg-field-first-name" class="s2member-custom-reg-field input" size="25" tabindex="' . esc_attr (($tabindex = $tabindex + 1)) . '" value="' . format_to_edit (trim (stripslashes ($_REQUEST["s2member_custom_reg_field_first_name"]))) . '" maxlength="100" />' . "\n";
				echo '</label>' . "\n";
				echo '</p>';
				/**/
				echo '<p>' . "\n";
				echo '<label>' . "\n";
				echo 'Last Name' . "\n";
				echo '<input type="text" name="s2member_custom_reg_field_last_name" id="s2member-custom-reg-field-last-name" class="s2member-custom-reg-field input" size="25" tabindex="' . esc_attr (($tabindex = $tabindex + 1)) . '" value="' . format_to_edit (trim (stripslashes ($_REQUEST["s2member_custom_reg_field_last_name"]))) . '" maxlength="100" />' . "\n";
				echo '</label>' . "\n";
				echo '</p>';
				/**/
				foreach (preg_split ("/[\r\n\t,;]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
					{
						if ($field = trim ($field)) /* Don't process empty fields. */
							{
								echo '<p>' . "\n";
								echo '<label>' . "\n";
								echo esc_html ($field) . "\n";
								$field = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
								echo '<input type="text" name="s2member_custom_reg_field_' . esc_attr ($field) . '" id="s2member-custom-reg-field-' . esc_attr (preg_replace ("/_/", "-", $field)) . '" class="s2member-custom-reg-field input" size="25" tabindex="' . esc_attr (($tabindex = $tabindex + 1)) . '" value="' . format_to_edit (trim (stripslashes ($_REQUEST["s2member_custom_reg_field_" . $field]))) . '" maxlength="100" />' . "\n";
								echo '</label>' . "\n";
								echo '</p>';
							}
					}
			}
		/**/
		return;
	}
/*
Function for configuring the registration of new users.
Attach to: add_action("user_register");
Attach to: add_action("bp_core_signup_user");
*/
function ws_plugin__s2member_configure_user_registration ($user_id = FALSE)
	{
		static $processed = false; /* Prevents duplicate processing when attached to multiple hooks in support of plugins like BuddyPress. */
		/**/
		if (!$processed && $user_id && $_COOKIE["s2member_subscr_id"] && $_COOKIE["s2member_custom"] && preg_match ("/^[1-4]$/", $_COOKIE["s2member_level"]) && ($processed = true))
			{
				global $wpdb; /* We need to check the uniqueness of their subscription id. */
				/**/
				if (!$usermeta = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($_COOKIE["s2member_subscr_id"]) . "' LIMIT 1"))
					{
						$_POST = stripslashes_deep ($_POST);
						/**/
						ws_plugin__s2member_email_config ();
						/**/
						$user = new WP_User ($user_id);
						$user->set_role ("s2member_level" . $_COOKIE["s2member_level"]);
						/**/
						update_usermeta ($user_id, "s2member_subscr_id", $_COOKIE["s2member_subscr_id"]);
						update_usermeta ($user_id, "s2member_custom", $_COOKIE["s2member_custom"]);
						/**/
						if (!defined ("BP_VERSION")) /* Custom fields are not compatible when running together with BuddyPress. */
							{
								update_usermeta ($user_id, "first_name", ($first_name = trim ($_POST["s2member_custom_reg_field_first_name"])));
								update_usermeta ($user_id, "last_name", ($last_name = trim ($_POST["s2member_custom_reg_field_last_name"])));
								wp_update_user (array ("ID" => $user_id, "display_name" => $first_name));
								/**/
								foreach (preg_split ("/[\r\n\t,;]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
									{
										if ($field = trim ($field)) /* Don't process empty fields. */
											{
												$field = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
												$fields[$field] = trim ($_POST["s2member_custom_reg_field_" . $field]);
											}
									}
								/**/
								update_usermeta ($user_id, "s2member_custom_fields", $fields);
							}
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