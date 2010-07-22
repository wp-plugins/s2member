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
/*
Function that displays the Profile Modification Form.
Attach to: add_action("template_redirect");
*/
if (!function_exists ("ws_plugin__s2member_profile"))
	{
		function ws_plugin__s2member_profile ()
			{
				do_action ("ws_plugin__s2member_before_profile", get_defined_vars ());
				/**/
				if ($_GET["s2member_profile"] && is_user_logged_in ()) /* Logged in? */
					{
						include_once dirname (dirname (__FILE__)) . "/profile.inc.php";
						/* Additional Hooks/Filters inside profile.inc.php. */
						exit ();
					}
				/**/
				do_action ("ws_plugin__s2member_after_profile", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for handling profile modifications.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_handle_profile_modifications"))
	{
		function ws_plugin__s2member_handle_profile_modifications ()
			{
				do_action ("ws_plugin__s2member_before_handle_profile_modifications", get_defined_vars ());
				/**/
				if ($_GET["s2member_profile"] && ($current_user = (is_user_logged_in ()) ? wp_get_current_user () : false))
					{
						if (($nonce = $_POST["ws_plugin__s2member_profile_save"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-profile-save"))
							{
								$_POST = stripslashes_deep ($_POST); /* Clean POST vars. */
								/**/
								$userdata["ID"] = $user_id = $current_user->ID;
								/**/
								include_once ABSPATH . WPINC . "/registration.php";
								/**/
								if (trim ($_POST["ws_plugin__s2member_profile_email"]))
									if (is_email (trim ($_POST["ws_plugin__s2member_profile_email"])))
										if (!email_exists (trim ($_POST["ws_plugin__s2member_profile_email"])))
											$userdata["user_email"] = trim ($_POST["ws_plugin__s2member_profile_email"]);
								/**/
								if (trim ($_POST["ws_plugin__s2member_profile_password"]))
									if ($current_user->user_login !== "demo") /* No password change on demos. */
										$userdata["user_pass"] = trim ($_POST["ws_plugin__s2member_profile_password"]);
								/**/
								$userdata["first_name"] = $userdata["display_name"] = trim ($_POST["ws_plugin__s2member_profile_first_name"]);
								/**/
								$userdata["last_name"] = trim ($_POST["ws_plugin__s2member_profile_last_name"]);
								/**/
								wp_update_user ($userdata); /* Send this array for an update. */
								/**/
								foreach (preg_split ("/[\r\n\t;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
									{
										if ($field = trim ($field, "* \t\n\r\0\x0B")) /* Don't process empty fields. */
											{
												$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
												$field_id_class = preg_replace ("/_/", "-", $field_var);
												/**/
												$fields[$field_var] = trim ($_POST["ws_plugin__s2member_profile_" . $field_var]);
											}
									}
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_handle_profile_modifications", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								update_usermeta ($user_id, "s2member_custom_fields", $fields);
								/**/
								echo '<script type="text/javascript">' . "\n";
								echo "if(window.parent && window.parent != window) { try{ window.parent.Shadowbox.close(); } catch(e){} try{ window.parent.tb_remove(); } catch(e){} window.parent.alert('Profile updated successfully!'); window.parent.location = '" . esc_js (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"])) . "'; }";
								echo "else if(window.opener) { window.close(); window.opener.alert('Profile updated successfully!'); window.opener.location = '" . esc_js (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"])) . "'; }";
								echo "else { alert('Profile updated successfully!'); window.location = '" . esc_js (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"])) . "'; }";
								echo '</script>' . "\n";
								/**/
								exit ();
							}
					}
				/**/
				do_action ("ws_plugin__s2member_after_handle_profile_modifications", get_defined_vars ());
				/**/
				return;
			}
	}
?>