<?php
/**
* s2Member Stand-Alone Profile page ( inner processing routines ).
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
* @package s2Member\Profiles
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_profile_in"))
	{
		/**
		* s2Member Stand-Alone Profile page ( inner processing routines ).
		*
		* @package s2Member\Profiles
		* @since 3.5
		*/
		class c_ws_plugin__s2member_profile_in
			{
				/**
				* Displays a Stand-Alone Profile Modification Form.
				*
				* @package s2Member\Profiles
				* @since 3.5
				*
				* @attaches-to: ``add_action("init");``
				*
				* @return null Or exits script execution after display.
				*/
				public static function profile ()
					{
						do_action ("ws_plugin__s2member_before_profile", get_defined_vars ());
						/**/
						if (!empty ($_GET["s2member_profile"])) /* Requesting Profile? */
							{
								c_ws_plugin__s2member_no_cache::no_cache_constants (true);
								/**/
								$tabindex = apply_filters ("ws_plugin__s2member_sc_profile_tabindex", 0, get_defined_vars ());
								/**/
								if (($user = (is_user_logged_in ()) ? wp_get_current_user () : false) && ($user_id = $user->ID))
									{
										echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n";
										/**/
										echo '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n";
										echo '<head>' . "\n";
										/**/
										echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\n";
										/**/
										echo '<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>' . "\n";
										echo '<script type="text/javascript" src="' . esc_attr (site_url ("/?ws_plugin__s2member_js_w_globals=" . urlencode (WS_PLUGIN__S2MEMBER_API_CONSTANTS_MD5) . "&amp;qcABC=1&amp;ver=" . urlencode (c_ws_plugin__s2member_utilities::ver_checksum ()))) . '"></script>' . "\n";
										echo '<link href="' . esc_attr (site_url ("/?ws_plugin__s2member_css=1&amp;qcABC=1&amp;ver=" . urlencode (c_ws_plugin__s2member_utilities::ver_checksum ()))) . '" type="text/css" rel="stylesheet" media="all" />' . "\n";
										/**/
										echo '<title>My Profile</title>' . "\n";
										/**/
										eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_head", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '</head>' . "\n";
										/**/
										echo '<body style="' . esc_attr (apply_filters ("ws_plugin__s2member_profile_body_styles", "background:#FFFFFF; color:#333333; font-family:'Verdana', sans-serif; font-size:13px;", get_defined_vars ())) . '">' . "\n";
										/**/
										echo '<form method="post" name="ws_plugin__s2member_profile" id="ws-plugin--s2member-profile" action="' . esc_attr (site_url ("/")) . '">' . "\n";
										/**/
										eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_before_table", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<table cellpadding="0" cellspacing="0">' . "\n";
										echo '<tbody>' . "\n";
										/**/
										eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_before_fields", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_username", true, get_defined_vars ()))
											{
												eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_profile_during_fields_before_username", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
												/**/
												echo '<tr>' . "\n";
												echo '<td>' . "\n";
												echo '<label for="ws-plugin--s2member-profile-login">' . "\n";
												echo '<strong>Username *</strong> <small>( cannot be changed )</small><br />' . "\n";
												echo '<input aria-required="true" type="text" maxlength="60" name="ws_plugin__s2member_profile_login" id="ws-plugin--s2member-profile-login" class="ws-plugin--s2member-profile-field" value="' . format_to_edit ($user->user_login) . '" disabled="disabled" />' . "\n";
												echo '</label>' . "\n";
												echo '</td>' . "\n";
												echo '</tr>' . "\n";
												/**/
												eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_profile_during_fields_after_username", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
											}
										/**/
										if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_email", true, get_defined_vars ()))
											{
												eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_profile_during_fields_before_email", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
												/**/
												echo '<tr>' . "\n";
												echo '<td>' . "\n";
												echo '<label for="ws-plugin--s2member-profile-email">' . "\n";
												echo '<strong>Email Address *</strong><br />' . "\n";
												echo '<input aria-required="true" data-expected="email" type="text" maxlength="100" name="ws_plugin__s2member_profile_email" id="ws-plugin--s2member-profile-email" class="ws-plugin--s2member-profile-field" value="' . format_to_edit ($user->user_email) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
												echo '</label>' . "\n";
												echo '</td>' . "\n";
												echo '</tr>' . "\n";
												/**/
												eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_profile_during_fields_after_email", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
											}
										/**/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_names"])
											{
												if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_first_name", true, get_defined_vars ()))
													{
														eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_profile_during_fields_before_first_name", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
														/**/
														echo '<tr>' . "\n";
														echo '<td>' . "\n";
														echo '<label for="ws-plugin--s2member-profile-first-name">' . "\n";
														echo '<strong>First Name *</strong><br />' . "\n";
														echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_profile_first_name" id="ws-plugin--s2member-profile-first-name" class="ws-plugin--s2member-profile-field" value="' . format_to_edit ($user->first_name) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
														echo '</label>' . "\n";
														echo '</td>' . "\n";
														echo '</tr>' . "\n";
														/**/
														eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_profile_during_fields_after_first_name", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
													}
												/**/
												if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_last_name", true, get_defined_vars ()))
													{
														eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_profile_during_fields_before_last_name", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
														/**/
														echo '<tr>' . "\n";
														echo '<td>' . "\n";
														echo '<label for="ws-plugin--s2member-profile-last-name">' . "\n";
														echo '<strong>Last Name *</strong><br />' . "\n";
														echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_profile_last_name" id="ws-plugin--s2member-profile-last-name" class="ws-plugin--s2member-profile-field" value="' . format_to_edit ($user->last_name) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
														echo '</label>' . "\n";
														echo '</td>' . "\n";
														echo '</tr>' . "\n";
														/**/
														eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_profile_during_fields_after_last_name", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
													}
												/**/
												if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_display_name", true, get_defined_vars ()))
													{
														eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_profile_during_fields_before_display_name", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
														/**/
														echo '<tr>' . "\n";
														echo '<td>' . "\n";
														echo '<label for="ws-plugin--s2member-profile-display-name">' . "\n";
														echo '<strong>Display Name *</strong><br />' . "\n";
														echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_profile_display_name" id="ws-plugin--s2member-profile-display-name" class="ws-plugin--s2member-profile-field" value="' . format_to_edit ($user->display_name) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
														echo '</label>' . "\n";
														echo '</td>' . "\n";
														echo '</tr>' . "\n";
														/**/
														eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_profile_during_fields_after_display_name", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
													}
											}
										/**/
										if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_custom_fields", true, get_defined_vars ()))
											{
												if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) /* Now, do we have Custom Fields? */
													if ($fields_applicable = c_ws_plugin__s2member_custom_reg_fields::custom_fields_configured_at_level ("auto-detection", "profile"))
														{
															$fields = get_user_option ("s2member_custom_fields", $user_id);
															/**/
															eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
															do_action ("ws_plugin__s2member_during_profile_during_fields_before_custom_fields", get_defined_vars ());
															unset ($__refs, $__v); /* Unset defined __refs, __v. */
															/**/
															foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
																{
																	eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																	do_action ("ws_plugin__s2member_during_profile_during_fields_during_custom_fields_before", get_defined_vars ());
																	unset ($__refs, $__v); /* Unset defined __refs, __v. */
																	/**/
																	if (in_array ($field["id"], $fields_applicable)) /* Field applicable? */
																		{
																			$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
																			$field_id_class = preg_replace ("/_/", "-", $field_var);
																			/**/
																			eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																			if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_during_custom_fields_display", true, get_defined_vars ()))
																				{
																					if (!empty ($field["section"]) && $field["section"] === "yes") /* Starts a new section? */
																						echo '<tr><td><div class="ws-plugin--s2member-profile-field-divider-section' . ((!empty ($field["sectitle"])) ? '-title' : '') . '">' . ((!empty ($field["sectitle"])) ? $field["sectitle"] : '') . '</div></td></tr>';
																					/**/
																					echo '<tr>' . "\n";
																					echo '<td>' . "\n";
																					echo '<label for="ws-plugin--s2member-profile-' . esc_attr ($field_id_class) . '">' . "\n";
																					echo '<strong' . ((preg_match ("/^(checkbox|pre_checkbox)$/", $field["type"])) ? ' style="display:none;"' : '') . '>' . $field["label"] . (($field["required"] === "yes") ? ' *' : '') . '</strong></label>' . ((preg_match ("/^(checkbox|pre_checkbox)$/", $field["type"])) ? '' : '<br />') . "\n";
																					echo c_ws_plugin__s2member_custom_reg_fields::custom_field_gen (__FUNCTION__, $field, "ws_plugin__s2member_profile_", "ws-plugin--s2member-profile-", "ws-plugin--s2member-profile-field", "", ($tabindex = $tabindex + 10), "", $fields, $fields[$field_var], "profile");
																					echo '</td>' . "\n";
																					echo '</tr>' . "\n";
																				}
																			unset ($__refs, $__v); /* Unset defined __refs, __v. */
																		}
																	/**/
																	eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																	do_action ("ws_plugin__s2member_during_profile_during_fields_during_custom_fields_after", get_defined_vars ());
																	unset ($__refs, $__v); /* Unset defined __refs, __v. */
																}
															/**/
															eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
															do_action ("ws_plugin__s2member_during_profile_during_fields_after_custom_fields", get_defined_vars ());
															unset ($__refs, $__v); /* Unset defined __refs, __v. */
														}
											}
										/**/
										if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_password", true, get_defined_vars ()))
											{
												eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_profile_during_fields_before_password", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
												/**/
												echo '<tr>' . "\n";
												echo '<td>' . "\n";
												/**/
												echo '<label for="ws-plugin--s2member-profile-password1" title="Please type your Password twice to confirm.">' . "\n";
												echo '<strong>New Password?</strong> <em>( please type it twice )</em><br />' . "\n";
												echo '<em>Only if changing password, otherwise leave blank.</em><br />' . "\n";
												echo '<input type="password" maxlength="100" autocomplete="off" name="ws_plugin__s2member_profile_password1" id="ws-plugin--s2member-profile-password1" class="ws-plugin--s2member-profile-field" value="" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '"' . (($user->user_login === "demo") ? ' disabled="disabled"' : '') . ' />' . "\n";
												echo '</label>' . "\n";
												/**/
												echo '<label for="ws-plugin--s2member-profile-password2" title="Please type your Password twice to confirm.">' . "\n";
												echo '<input type="password" maxlength="100" autocomplete="off" name="ws_plugin__s2member_profile_password2" id="ws-plugin--s2member-profile-password2" class="ws-plugin--s2member-profile-field" value="" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '"' . (($user->user_login === "demo") ? ' disabled="disabled"' : '') . ' />' . "\n";
												echo '</label>' . "\n";
												/**/
												echo '<div id="ws-plugin--s2member-profile-password-strength" class="ws-plugin--s2member-password-strength"><em>password strength indicator</em></div>' . "\n";
												/**/
												echo '</td>' . "\n";
												echo '</tr>' . "\n";
												/**/
												eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_profile_during_fields_after_password", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
											}
										/**/
										eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_after_fields", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<td>' . "\n";
										echo '<input type="hidden" name="ws_plugin__s2member_profile_save" id="ws-plugin--s2member-profile-save" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-profile-save")) . '" />' . "\n";
										echo '<input id="ws-plugin--s2member-profile-submit" type="submit" value="Save All Changes" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
										echo '</td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										echo '</tbody>' . "\n";
										echo '</table>' . "\n";
										/**/
										eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_profile_after_table", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '</form>' . "\n";
										/**/
										echo '</body>' . "\n";
										echo '</html>';
									}
								/**/
								exit (); /* Clean exit. */
							}
						/**/
						do_action ("ws_plugin__s2member_after_profile", get_defined_vars ());
					}
			}
	}
?>