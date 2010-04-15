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
Function that forces a default Subscriber Role.
Attach to: add_filter("pre_option_default_role");
*/
function ws_plugin__s2member_force_default_role ($default_role = FALSE)
	{
		return ($default_role = "subscriber");
	}
/*
Function for allowing access to the register form.
Attach to: add_filter("pre_option_users_can_register");
*/
function ws_plugin__s2member_check_register_access ($users_can_register = FALSE)
	{
		global $pagenow; /* Check if we are on the General Options page. */
		/**/
		if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["allow_subscribers_in"])
			{
				return ($users_can_register = "1");
			}
		else if ($pagenow !== "options-general.php" && $_COOKIE["s2member_subscr_id"] && $_COOKIE["s2member_custom"] && preg_match ("/^[1-4]$/", $_COOKIE["s2member_level"]))
			{
				global $wpdb; /* Global database object reference. */
				/**/
				if (!$usermeta = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($_COOKIE["s2member_subscr_id"]) . "' LIMIT 1"))
					{
						return ($users_can_register = "1");
					}
			}
		/**/
		return ($users_can_register = "0");
	}
/*
Function that describes the General Option overrides for clarity.
Attach to: add_action("admin_init");
*/
function ws_plugin__s2member_general_ops_notice ()
	{
		global $pagenow; /* Need this. */
		/**/
		if ($pagenow === "options-general.php" && !isset ($_GET["page"]))
			{
				$notice = "<em>* Note: The s2Member plugin has control over two options on this page. <code>Anyone Can Register = " . esc_html (get_option ("users_can_register")) . "</code>, and <code>Default Role = " . esc_html (get_option ("default_role")) . "</code>.";
				/**/
				ws_plugin__s2member_enqueue_admin_notice ($notice, $pagenow);
			}
	}
/*
This adds custom fields to the registration form.
Attach to: add_action("register_form");
*/
function ws_plugin__s2member_custom_registration_fields ()
	{
		if (!defined ("BP_VERSION")) /* Not compatible with BuddyPress. */
			{
				echo '<input type="hidden" name="ws_plugin__s2member_registration" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-registration")) . '" />' . "\n";
				/**/
				$tabindex = 20; /* Incremented tabindex starting with 20. */
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"] && function_exists ("ws_plugin__s2member_generate_password"))
					{
						echo '<p>' . "\n";
						echo '<label>' . "\n";
						echo 'Password *' . "\n";
						echo '<input aria-required="true" type="password" maxlength="100" name="ws_plugin__s2member_custom_reg_field_user_pass" id="ws-plugin--s2member-custom-reg-field-user-pass" class="ws-plugin--s2member-custom-reg-field input" size="25" tabindex="' . esc_attr (($tabindex = $tabindex + 1)) . '" value="' . format_to_edit (trim (stripslashes ($_REQUEST["ws_plugin__s2member_custom_reg_field_user_pass"]))) . '" />' . "\n";
						echo '</label>' . "\n";
						echo '</p>';
					}
				/**/
				echo '<p>' . "\n";
				echo '<label>' . "\n";
				echo 'First Name *' . "\n";
				echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_first_name" id="ws-plugin--s2member-custom-reg-field-first-name" class="ws-plugin--s2member-custom-reg-field input" size="25" tabindex="' . esc_attr (($tabindex = $tabindex + 1)) . '" value="' . format_to_edit (trim (stripslashes ($_REQUEST["ws_plugin__s2member_custom_reg_field_first_name"]))) . '" />' . "\n";
				echo '</label>' . "\n";
				echo '</p>';
				/**/
				echo '<p>' . "\n";
				echo '<label>' . "\n";
				echo 'Last Name *' . "\n";
				echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_last_name" id="ws-plugin--s2member-custom-reg-field-last-name" class="ws-plugin--s2member-custom-reg-field input" size="25" tabindex="' . esc_attr (($tabindex = $tabindex + 1)) . '" value="' . format_to_edit (trim (stripslashes ($_REQUEST["ws_plugin__s2member_custom_reg_field_last_name"]))) . '" />' . "\n";
				echo '</label>' . "\n";
				echo '</p>';
				/**/
				foreach (preg_split ("/[\r\n\t,;]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
					{
						$req = preg_match ("/\*/", $field); /* Required fields should be wrapped inside asterisks. */
						$req = ($req) ? ' aria-required="true"' : ''; /* Has JavaScript validation applied. */
						/**/
						if ($field = trim ($field, "* \t\n\r\0\x0B")) /* Don't process empty fields. */
							{
								echo '<p>' . "\n";
								echo '<label>' . "\n";
								echo esc_html ($field) . (($req) ? " *" : "") . "\n";
								$field = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
								echo '<input' . $req . ' type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_' . esc_attr ($field) . '" id="ws-plugin--s2member-custom-reg-field-' . esc_attr (preg_replace ("/_/", "-", $field)) . '" class="ws-plugin--s2member-custom-reg-field input" size="25" tabindex="' . esc_attr (($tabindex = $tabindex + 1)) . '" value="' . format_to_edit (trim (stripslashes ($_REQUEST["ws_plugin__s2member_custom_reg_field_" . $field]))) . '" />' . "\n";
								echo '</label>' . "\n";
								echo '</p>';
							}
					}
			}
		/**/
		return;
	}
/*
Function for configuring new users.
Attach to: add_action("user_register");
Attach to: add_action("bp_core_signup_user");
*/
function ws_plugin__s2member_configure_user_registration ($user_id = FALSE)
	{
		static $processed; /* Prevents duplicate processing when attached to multiple hooks in support of plugins like BuddyPress. */
		/**/
		if (!$processed && $user_id && is_array ($_POST = stripslashes_deep ($_POST)) && is_object ($user = new WP_User ($user_id)) && ($processed = true))
			{
				ws_plugin__s2member_email_config (); /* Configures From: header that will be used in new user notifications. */
				/**/
				if ($_COOKIE["s2member_subscr_id"] && $_COOKIE["s2member_custom"] && preg_match ("/^[1-4]$/", $_COOKIE["s2member_level"]))
					{
						global $wpdb; /* Global database object required for this routine. We need to check the uniqueness of their s2member_subscr_id. */
						/**/
						if (!$usermeta = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($_COOKIE["s2member_subscr_id"]) . "' LIMIT 1"))
							{
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
				if (!defined ("BP_VERSION")) /* Custom fields are not compatible when running together with BuddyPress. */
					{
						update_usermeta ($user_id, "first_name", ($first_name = trim ($_POST["ws_plugin__s2member_custom_reg_field_first_name"])));
						update_usermeta ($user_id, "last_name", ($last_name = trim ($_POST["ws_plugin__s2member_custom_reg_field_last_name"])));
						/**/
						wp_update_user (array ("ID" => $user_id, "display_name" => $first_name));
						/**/
						foreach (preg_split ("/[\r\n\t,;]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
							{
								if ($field = trim ($field, "* \t\n\r\0\x0B")) /* Don't process empty fields. */
									{
										$field = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
										$fields[$field] = trim ($_POST["ws_plugin__s2member_custom_reg_field_" . $field]);
									}
							}
						/**/
						update_usermeta ($user_id, "s2member_custom_fields", $fields);
					}
			}
		/**/
		return;
	}
/*
Pluggable function that handles password generation.
Taken from: /wp-includes/pluggable.php
*/
if (!function_exists ("wp_generate_password"))
	{
		function wp_generate_password ($length = 12, $special_chars = TRUE)
			{
				return ws_plugin__s2member_generate_password ($length, $special_chars);
			}
		/**/
		function ws_plugin__s2member_generate_password ($length = 12, $special_chars = TRUE)
			{
				$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				$chars .= ($special_chars) ? "!@#$%^&*()" : "";
				/**/
				for ($i = 0, $password = ""; $i < $length; $i++)
					$password .= substr ($chars, wp_rand (0, strlen ($chars) - 1), 1);
				/**/
				if (!defined ("BP_VERSION") && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"])
					if (wp_verify_nonce (trim (stripslashes ($_POST["ws_plugin__s2member_registration"])), "ws-plugin--s2member-registration"))
						if ($custom = trim (stripslashes ($_POST["ws_plugin__s2member_custom_reg_field_user_pass"])))
							$password = $custom;
				/**/
				return $password;
			}
	}
?>