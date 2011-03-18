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
if (!class_exists ("c_ws_plugin__s2member_sc_profile_in"))
	{
		class c_ws_plugin__s2member_sc_profile_in
			{
				/*
				Function that handles the Shortcode for [s2Member-Profile /].
				Attach to: add_shortcode("s2Member-Profile");
				*/
				public static function sc_profile ($attr = FALSE, $content = FALSE, $shortcode = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_sc_profile", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						c_ws_plugin__s2member_nocache::nocache_constants (true); /* No caching on pages with this. */
						/**/
						if (($current_user = (is_user_logged_in ()) ? wp_get_current_user () : false)) /* OK? */
							{
								$attr = c_ws_plugin__s2member_utils_strings::trim_quot_deep ((array)$attr);
								/**/
								$attr = shortcode_atts (array (), $attr); /* Possible Attributes. None at this time. */
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_before_sc_profile_after_shortcode_atts", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								ob_start (); /* Start buffering. Allows Hooks to echo output like: `/?s2member_profile=1`. */
								/**/
								echo '<form method="post" name="ws_plugin__s2member_profile" id="ws-plugin--s2member-profile">' . "\n";
								/**/
								if ($GLOBALS["ws_plugin__s2member_profile_saved"]) /* Respond to successful updates. */
									{
										echo '<div id="ws-plugin--s2member-profile-saved">' . "\n";
										echo 'Profile updated successfully.' . "\n";
										echo '</div>' . "\n";
									}
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_profile_before_table", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								echo '<table style="width:100%; border:0;">' . "\n";
								echo '<tbody>' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_profile_before_fields", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_username", true, get_defined_vars ()))
									{
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_during_fields_before_username", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<td>' . "\n";
										echo '<label>' . "\n";
										echo '<strong>Username *</strong> ( cannot be changed )<br />' . "\n";
										echo '<input aria-required="true" type="text" maxlength="60" name="ws_plugin__s2member_profile_login" id="ws-plugin--s2member-profile-login" style="width:99%;" value="' . format_to_edit ($current_user->user_login) . '" disabled="disabled" />' . "\n";
										echo '</label>' . "\n";
										echo '</td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_during_fields_after_username", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								/**/
								if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_email", true, get_defined_vars ()))
									{
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_during_fields_before_email", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<td>' . "\n";
										echo '<label>' . "\n";
										echo '<strong>Email Address *</strong><br />' . "\n";
										echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_profile_email" id="ws-plugin--s2member-profile-email" style="width:99%;" value="' . format_to_edit ($current_user->user_email) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
										echo '</label>' . "\n";
										echo '</td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_during_fields_after_email", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								/**/
								if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_first_name", true, get_defined_vars ()))
									{
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_during_fields_before_first_name", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<td>' . "\n";
										echo '<label>' . "\n";
										echo '<strong>First Name *</strong><br />' . "\n";
										echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_profile_first_name" id="ws-plugin--s2member-profile-first-name" style="width:99%;" value="' . format_to_edit ($current_user->first_name) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
										echo '</label>' . "\n";
										echo '</td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_during_fields_after_first_name", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								/**/
								if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_last_name", true, get_defined_vars ()))
									{
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_during_fields_before_last_name", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<td>' . "\n";
										echo '<label>' . "\n";
										echo '<strong>Last Name *</strong><br />' . "\n";
										echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_profile_last_name" id="ws-plugin--s2member-profile-last-name" style="width:99%;" value="' . format_to_edit ($current_user->last_name) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
										echo '</label>' . "\n";
										echo '</td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_during_fields_after_last_name", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								/**/
								if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_display_name", true, get_defined_vars ()))
									{
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_during_fields_before_display_name", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<td>' . "\n";
										echo '<label>' . "\n";
										echo '<strong>Display Name *</strong><br />' . "\n";
										echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_profile_display_name" id="ws-plugin--s2member-profile-display-name" style="width:99%;" value="' . format_to_edit ($current_user->display_name) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
										echo '</label>' . "\n";
										echo '</td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_during_fields_after_last_name", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								/**/
								if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_custom_fields", true, get_defined_vars ()))
									{
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) /* Now, do we have Custom Fields? */
											if ($fields_applicable = c_ws_plugin__s2member_custom_reg_fields::custom_fields_configured_at_level ("auto-detection", "profile"))
												{
													$fields = get_user_option ("s2member_custom_fields", $current_user->ID); /* Existing fields. */
													/**/
													eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
													do_action ("ws_plugin__s2member_during_profile_during_fields_before_custom_fields", get_defined_vars ());
													unset ($__refs, $__v); /* Unset defined __refs, __v. */
													/**/
													foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
														{
															eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
															do_action ("ws_plugin__s2member_during_profile_during_fields_during_custom_fields_before", get_defined_vars ());
															unset ($__refs, $__v); /* Unset defined __refs, __v. */
															/**/
															if (in_array ($field["id"], $fields_applicable)) /* Field applicable? */
																{
																	$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
																	$field_id_class = preg_replace ("/_/", "-", $field_var);
																	/**/
																	eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																	if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_during_custom_fields_display", true, get_defined_vars ()))
																		{
																			echo '<tr>' . "\n";
																			echo '<td>' . "\n";
																			echo '<label>' . "\n";
																			echo '<strong' . ( (preg_match ("/^(checkbox|pre_checkbox)$/", $field["type"])) ? ' style="display:none;"' : '') . '>' . $field["label"] . ( ($field["required"] === "yes") ? ' *' : '') . '</strong>' . ( (preg_match ("/^(checkbox|pre_checkbox)$/", $field["type"])) ? '' : '<br />') . "\n";
																			echo c_ws_plugin__s2member_custom_reg_fields::custom_field_gen ("ws_plugin__s2member_profile", $field, "ws_plugin__s2member_profile_", "ws-plugin--s2member-profile-", "", ( (preg_match ("/^(select|selects)$/", $field["type"])) ? "width:100%;" : ( (preg_match ("/^(text|textarea)$/", $field["type"])) ? "width:99%;" : "")), ($tabindex = $tabindex + 10), "", $fields,$fields[$field_var], true);
																			echo '</label>' . "\n";
																			echo '</td>' . "\n";
																			echo '</tr>' . "\n";
																		}
																	unset ($__refs, $__v); /* Unset defined __refs, __v. */
																}
															/**/
															eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
															do_action ("ws_plugin__s2member_during_profile_during_fields_during_custom_fields_after", get_defined_vars ());
															unset ($__refs, $__v); /* Unset defined __refs, __v. */
														}
													/**/
													eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
													do_action ("ws_plugin__s2member_during_profile_during_fields_after_custom_fields", get_defined_vars ());
													unset ($__refs, $__v); /* Unset defined __refs, __v. */
												}
									}
								/**/
								if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_password", true, get_defined_vars ()))
									{
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_during_fields_before_password", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<td>' . "\n";
										/**/
										echo '<label title="Please type your Password twice to confirm.">' . "\n";
										echo '<strong>New Password</strong> ( only if you want to change it )<br />' . "\n";
										echo '<input type="password" maxlength="100" autocomplete="off" name="ws_plugin__s2member_profile_password" id="ws-plugin--s2member-profile-password" style="width:99%;" value="" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '"' . ( ($current_user->user_login === "demo") ? ' disabled="disabled"' : '') . ' />' . "\n";
										echo '</label>' . "\n";
										/**/
										echo '<label title="Please type your Password twice to confirm.">' . "\n";
										echo '<input type="password" maxlength="100" autocomplete="off" id="ws-plugin--s2member-profile-password-confirmation" style="width:99%;" value="" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '"' . ( ($current_user->user_login === "demo") ? ' disabled="disabled"' : '') . ' />' . "\n";
										echo '</label>' . "\n";
										/**/
										echo '</td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_during_fields_after_password", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_profile_after_fields", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								echo '<tr>' . "\n";
								echo '<td>' . "\n";
								echo '<input type="hidden" name="ws_plugin__s2member_profile_save" id="ws-plugin--s2member-profile-save" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-profile-save")) . '" />' . "\n";
								echo '<input type="hidden" name="ws_plugin__s2member_sc_profile_save" id="ws-plugin--s2member-sc-profile-save" value="1" />' . "\n";
								echo '<input type="submit" value="Save Changes" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
								echo '</td>' . "\n";
								echo '</tr>' . "\n";
								/**/
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_profile_after_table", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								echo '</form>' . "\n";
								/**/
								$code = ob_get_clean ();
							}
						/**/
						return apply_filters ("ws_plugin__s2member_sc_profile", $code, get_defined_vars ());
					}
			}
	}
?>