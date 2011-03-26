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
if (!class_exists ("c_ws_plugin__s2member_users_list_in"))
	{
		class c_ws_plugin__s2member_users_list_in
			{
				/*
				Function adds Custom Fields to the admin profile editing page.
					
					Attach to: add_action("edit_user_profile");
					Attach to: add_action("show_user_profile");
						w/ the Contant available:
						IS_PROFILE_PAGE
				
				Conditionals here need to match those in the function below:
					c_ws_plugin__s2member_users_list::users_list_update_cols()
				*/
				public static function users_list_edit_cols ($user = FALSE)
					{
						global $current_site, $current_blog; /* Multisite Networking. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_users_list_edit_cols", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Get the current User's object. */
						/**/
						if (is_object ($user) && $user->ID && is_object ($current_user) && $current_user->ID) /* Validate both of these User objects. */
							{
								$level = c_ws_plugin__s2member_user_access::user_access_level ($user); /* This User's Access Level for s2Member; needed below. */
								/**/
								if (current_user_can ("edit_users") && (!is_multisite () || is_super_admin () || is_user_member_of_blog ($user->ID)))
									{
										echo '<div style="margin:25px 0 25px 0; height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
										/**/
										echo '<h3 style="position:relative;"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/large-icon.png" title="s2Member ( a Membership management system for WordPress® )" alt="" style="position:absolute; top:-15px; right:0; border:0;" />s2Member Configuration &amp; Profile Fields' . ( (is_multisite ()) ? ' ( for this Blog )' : '') . '</h3>' . "\n";
										/**/
										echo '<table class="form-table">' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_before", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										if (is_multisite () && is_super_admin ()) /* MUST be a Super Admin. */
											/* On a Multisite Network, the Super Administrator can ALWAYS edit this. */
											{
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_originating_blog", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
												/**/
												echo '<tr>' . "\n";
												echo '<th><label>Originating Blog ID#:</label> <a href="#" onclick="alert(\'On a Multisite Network, this is how s2Member keeps track of which Blog each User/Member originated from. So this ID#, is automatically associated with a Blog in your Network, matching the User\\\'s point of origin. ~ ONLY a Super Admin can modify this.\\n\\nOn a Multisite Blog Farm, the Originating Blog ID# for your own Customers, will ALWAYS be associated with your ( Main Site ). It is NOT likely that you\\\'ll need to modify this manually, but s2Member makes it available; just in case.\\n\\n*Tip* - If you add Users ( and/or Blogs ) with the `Super Admin` Network Administration panel inside WordPress®, then you WILL need to set everything manually. s2Member does NOT tamper with automation routines whenever YOU ( as a Super Administrator ) are working in that area.\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
												echo '<td><input type="text" name="ws_plugin__s2member_profile_s2member_originating_blog" id="ws-plugin--s2member-profile-s2member-originating-blog" value="' . format_to_edit (get_user_meta ($user->ID, "s2member_originating_blog", true)) . '" class="regular-text" /></td>' . "\n";
												echo '</tr>' . "\n";
												/**/
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_originating_blog", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
											}
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_subscr_gateway", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<th><label>Paid Subscr. Gateway:</label> <a href="#" onclick="alert(\'A Payment Gateway code is associated with the Paid Subscr. ID below. A Paid Subscription ID ( or a Buy Now Transaction ID ) is only valid for paid Members. Also known as ( a Recurring Profile ID, a ClickBank® Receipt #, a Google® TID/SID ( with an s2 prefix ), an AliPay® Trade No. ). This will be filled automatically by s2Member.\\n\\nThis field will be empty for Free Subscribers, and/or anyone who is NOT paying you. This field is only editable for Customer Service purposes; just in case you ever need to update the Paid Subscr. Gateway/ID manually.\\n\\nThe value of Paid® Subscr. ID, can be a PayPal® Standard `Subscription ID`, or a PayPal® Pro `Recurring Profile ID`, or a PayPal® `Transaction ID`; depending on the type of sale. Your PayPal® account will supply this information. If you\\\'re using Google® Checkout, use the TID/SID value in the sale Description; it always starts with `s2-`. ClickBank® provides a Receipt #, ccBill® provides a Subscription ID, Authorize.Net® provides a Subscription ID, and AliPay® provides a Transaction ID. The general rule is... IF there\\\'s a Subscription ID, use that! If there\\\'s NOT, use the Transaction ID.\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
										echo '<td><select name="ws_plugin__s2member_profile_s2member_subscr_gateway" id="ws-plugin--s2member-profile-s2member-subscr-gateway" style="width:27.5em;"><option value=""></option>' . "\n";
										foreach (apply_filters ("ws_plugin__s2member_profile_s2member_subscr_gateways", array ("paypal" => "PayPal® ( code: paypal )"), get_defined_vars ()) as $gateway => $gateway_name)
											echo '<option value="' . esc_attr ($gateway) . '"' . ( ($gateway === get_user_option ("s2member_subscr_gateway", $user->ID)) ? ' selected="selected"' : '') . '>' . esc_html ($gateway_name) . '</option>' . "\n";
										echo '</select>' . "\n";
										echo '</td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_subscr_gateway", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_subscr_id", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<th><label>Paid Subscr. ID:</label> <a href="#" onclick="alert(\'A Paid Subscription ID ( or a Buy Now Transaction ID ) is only valid for paid Members. Also known as ( a Recurring Profile ID, a ClickBank® Receipt #, a Google® TID/SID ( with an s2 prefix ), an AliPay® Trade No. ). This will be filled automatically by s2Member.\\n\\nThis field will be empty for Free Subscribers, and/or anyone who is NOT paying you. This field is only editable for Customer Service purposes; just in case you ever need to update the Paid Subscr. Gateway/ID manually.\\n\\nThe value of Paid® Subscr. ID, can be a PayPal® Standard `Subscription ID`, or a PayPal® Pro `Recurring Profile ID`, or a PayPal® `Transaction ID`; depending on the type of sale. Your PayPal® account will supply this information. If you\\\'re using Google® Checkout, use the TID/SID value in the sale Description; it always starts with `s2-`. ClickBank® provides a Receipt #, ccBill® provides a Subscription ID, Authorize.Net® provides a Subscription ID, and AliPay® provides a Transaction ID. The general rule is... IF there\\\'s a Subscription ID, use that! If there\\\'s NOT, use the Transaction ID.\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
										echo '<td><input type="text" name="ws_plugin__s2member_profile_s2member_subscr_id" id="ws-plugin--s2member-profile-s2member-subscr-id" value="' . format_to_edit (get_user_option ("s2member_subscr_id", $user->ID)) . '" class="regular-text" /></td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_subscr_id", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_custom", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<th><label>Custom Value:</label> <a href="#" onclick="alert(\'A Paid Subscription is always associated with a Custom String that is passed through the custom=\\\'\\\'' . c_ws_plugin__s2member_utils_strings::esc_sq (esc_attr ($_SERVER["HTTP_HOST"])) . '\\\'\\\' attribute of your Shortcode. This Custom Value, MUST always start with your domain name. However, you can also pipe delimit additional values after your domain, if you need to.\\n\\nFor example:\n' . c_ws_plugin__s2member_utils_strings::esc_sq (esc_attr ($_SERVER["HTTP_HOST"])) . '|cv1|cv2|cv3\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
										echo '<td><input type="text" name="ws_plugin__s2member_profile_s2member_custom" id="ws-plugin--s2member-profile-s2member-custom" value="' . format_to_edit (get_user_option ("s2member_custom", $user->ID)) . '" class="regular-text" /></td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_custom", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										if (!is_multisite () || !c_ws_plugin__s2member_utils_conds::is_multisite_farm () || is_main_site ())
											/* ^ Will change once Custom Capabilities are compatible with a Blog Farm. */
											{
												foreach ($user->allcaps as $cap => $cap_enabled)
													if (preg_match ("/^access_s2member_ccap_/", $cap))
														$ccaps[] = preg_replace ("/^access_s2member_ccap_/", "", $cap);
												/**/
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_ccaps", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
												/**/
												echo '<tr>' . "\n";
												echo '<th><label>Custom Capabilities:</label> <a href="#" onclick="alert(\'Optional. This is VERY advanced. For full details, see:\\ns2Member -> API Scripting -> Custom Capabilities.' . ( (is_multisite ()) ? '\\n\\nCustom Capabilities are assigned on a per-Blog basis. So having a set of Custom Capabilities for one Blog, and having NO Custom Capabilities on another Blog - is very common. This is how permissions are designed to work.' : '') . '\'); return false;" tabindex="-1">[?]</a>' . ( (is_multisite ()) ? '<br /><small>( for this Blog )</small>' : '') . '</th>' . "\n";
												echo '<td><input type="text" name="ws_plugin__s2member_profile_s2member_ccaps" id="ws-plugin--s2member-profile-s2member-ccaps" value="' . format_to_edit (( (!empty ($ccaps)) ? implode (",", $ccaps) : "")) . '" class="regular-text" onkeyup="if(this.value.match(/[^a-z_0-9,]/)) this.value = jQuery.trim (jQuery.trim (this.value).replace (/[ \-]/g, \'_\').replace (/[^A-Z_0-9,]/gi, \'\').toLowerCase ());" /></td>' . "\n";
												echo '</tr>' . "\n";
												/**/
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_ccaps", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
											}
										/**/
										if (!$user->has_cap ("administrator")) /* Do NOT present these details for Administrator accounts. */
											{
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_auto_eot_time", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
												/**/
												echo '<tr>' . "\n";
												$auto_eot_time = get_user_option ("s2member_auto_eot_time", $user->ID);
												$auto_eot_time = ($auto_eot_time) ? date ("D M j, Y g:i a T", $auto_eot_time) : "";
												echo '<th><label>Automatic EOT Time:</label> <a href="#" onclick="alert(\'EOT = End Of Term. ( i.e. Account Expiration / Termination. ).\\n\\nIf you leave this empty, s2Member will configure an EOT Time automatically, based on the paid Subscription associated with this account. In other words, if a paid Subscription expires, is cancelled, terminated, refunded, reversed, or charged back to you; s2Member will deal with the EOT automatically.\\n\\nThat being said, if you would rather take control over this, you can. If you type in a date manually, s2Member will obey the Auto-EOT Time that you\\\'ve given, no matter what. In other words, you can force certain Members to expire automatically, at a time that you specify. s2Member will obey.\\n\\nValid formats for Automatic EOT Time:\\n\\nmm/dd/yyyy\\nyyyy-mm-dd\\n+1 year\\n+2 weeks\\n+2 months\\n+10 minutes\\nnext thursday\\ntomorrow\\ntoday\\n\\n* anything compatible with PHP\\\'s strtotime() function.\'); return false;" tabindex="-1">[?]</a>' . (($auto_eot_time) ? '<br /><small>( based on server time )</small>' : '') . '</th>' . "\n";
												echo '<td><input type="text" name="ws_plugin__s2member_profile_s2member_auto_eot_time" id="ws-plugin--s2member-profile-s2member-auto-eot-time" value="' . format_to_edit ($auto_eot_time) . '" class="regular-text" /></td>' . "\n";
												echo '</tr>' . "\n";
												/**/
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_auto_eot_time", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
											}
										/**/
										if (c_ws_plugin__s2member_list_servers::list_servers_integrated ()) /* Only if integrated with s2Member. */
											{
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_opt_in", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
												/**/
												echo '<tr>' . "\n";
												echo '<th><label>Process List Servers:</label> <a href="#" onclick="alert(\'You have at least one List Server integrated with s2Member. Would you like to process a confirmation request for this User? If not, just leave the box un-checked.\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
												echo '<td><label><input type="checkbox" name="ws_plugin__s2member_profile_opt_in" id="ws-plugin--s2member-profile-opt-in" value="1" /> Yes, send a mailing list confirmation email to this User.</label></td>' . "\n";
												echo '</tr>' . "\n";
												/**/
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_opt_in", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
											}
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_ip_restrictions", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<th><label>Reset IP Restrictions:</label> <a href="#" onclick="alert(\'A single Username is only valid for a certain number of unique IP addresses ( as configured in your s2Member -> General Options ). Once that limit is reached, s2Member assumes there has been a security breach. At that time, s2Member will place a temporary ban ( preventing access ).\\n\\nIf you have spoken to a legitimate Customer that is receiving an error upon logging in ( ex: 503 / too many IP addresses ), you can remove this temporary ban by checking the box below. If the abusive behavior continues, s2Member will automatically re-instate IP Restrictions in the future. If you would like to gain further control over IP Restrictions, please check your General Options panel for s2Member.\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
										echo '<td><label><input type="checkbox" name="ws_plugin__s2member_profile_ip_restrictions" id="ws-plugin--s2member-profile-ip-restrictions" value="1" /> Yes, delete/reset IP Restrictions associated with this Username.</label>' . ( (c_ws_plugin__s2member_ip_restrictions::specific_ip_restriction_breached_security (strtolower ($user->user_login))) ? '<br /><em>*Note* this User HAS breached security through existing IP Restrictions.</em>' : '<br /><em>*Note* this User is NOT currently banned by any of your IP Restrictions.</em>') . '</td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_ip_restrictions", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) /* Only if configured. */
											if ($fields_applicable = c_ws_plugin__s2member_custom_reg_fields::custom_fields_configured_at_level ($level))
												{
													echo '<tr>' . "\n";
													echo '<td colspan="2">' . "\n";
													echo '<div style="height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
													echo '</td>' . "\n";
													echo '</tr>' . "\n";
													/**/
													$fields = get_user_option ("s2member_custom_fields", $user->ID); /* Existing fields. */
													/**/
													eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
													do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_custom_fields", get_defined_vars ());
													unset ($__refs, $__v); /* Unset defined __refs, __v. */
													/**/
													foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
														{
															eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
															do_action ("ws_plugin__s2member_during_users_list_edit_cols_during_custom_fields_before", get_defined_vars ());
															unset ($__refs, $__v); /* Unset defined __refs, __v. */
															/**/
															if (in_array ($field["id"], $fields_applicable)) /* Field applicable? */
																{
																	$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
																	$field_id_class = preg_replace ("/_/", "-", $field_var);
																	/**/
																	eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																	if (apply_filters ("ws_plugin__s2member_during_users_list_edit_cols_during_custom_fields_display", true, get_defined_vars ()))
																		{
																			echo '<tr>' . "\n";
																			echo '<th><label>' . ( (preg_match ("/^(checkbox|pre_checkbox)$/", $field["type"])) ? ucwords (preg_replace ("/_/", " ", $field_var)) : $field["label"]) . ':</label></th>' . "\n";
																			echo '<td>' . c_ws_plugin__s2member_custom_reg_fields::custom_field_gen (__FUNCTION__, $field, "ws_plugin__s2member_profile_", "ws-plugin--s2member-profile-", "", ( (preg_match ("/^(text|textarea|select|selects)$/", $field["type"])) ? "width:99%;" : ""), "", "", $fields, $fields[$field_var]) . '</td>' . "\n";
																			echo '</tr>' . "\n";
																		}
																	unset ($__refs, $__v); /* Unset defined __refs, __v. */
																}
															/**/
															eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
															do_action ("ws_plugin__s2member_during_users_list_edit_cols_during_custom_fields_after", get_defined_vars ());
															unset ($__refs, $__v); /* Unset defined __refs, __v. */
														}
													/**/
													eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
													do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_custom_fields", get_defined_vars ());
													unset ($__refs, $__v); /* Unset defined __refs, __v. */
													/**/
													echo '<tr>' . "\n";
													echo '<td colspan="2">' . "\n";
													echo '<div style="height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
													echo '</td>' . "\n";
													echo '</tr>' . "\n";
												}
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_notes", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<th><label>Administrative<br />Notations:</label> <a href="#" onclick="alert(\'This is for Administrative purposes. You can keep a list of Notations about this account. These Notations are private; Users/Members will never see these.\\n\\n*Note* The s2Member software may `append` Notes to this field occasionally, under special circumstances. For example, when/if s2Member demotes a paid Member to a Free Subscriber, s2Member will leave a Note in this field.\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
										echo '<td><textarea name="ws_plugin__s2member_profile_s2member_notes" id="ws-plugin--s2member-profile-s2member-notes" rows="5" wrap="off" spellcheck="false" style="width:99%;">' . format_to_edit (get_user_option ("s2member_notes", $user->ID)) . '</textarea></td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_notes", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_after", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '</table>' . "\n";
										/**/
										echo '<div style="margin:25px 0 25px 0; height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
									}
								/**/
								else if ($current_user->ID === $user->ID) /* Otherwise, a User can always edit their own Profile. */
									{
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) /* Only if configured. */
											if ($fields_applicable = c_ws_plugin__s2member_custom_reg_fields::custom_fields_configured_at_level ($level, "profile"))
												{
													echo '<div style="margin:25px 0 25px 0; height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
													/**/
													echo '<h3>Additional Profile Fields' . ( (is_multisite ()) ? ' ( for this Blog )' : '') . '</h3>' . "\n";
													/**/
													echo '<table class="form-table">' . "\n";
													/**/
													eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
													do_action ("ws_plugin__s2member_during_users_list_edit_cols_before", get_defined_vars ());
													unset ($__refs, $__v); /* Unset defined __refs, __v. */
													/**/
													$fields = get_user_option ("s2member_custom_fields", $user->ID); /* Existing fields. */
													/**/
													eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
													do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_custom_fields", get_defined_vars ());
													unset ($__refs, $__v); /* Unset defined __refs, __v. */
													/**/
													foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
														{
															eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
															do_action ("ws_plugin__s2member_during_users_list_edit_cols_during_custom_fields_before", get_defined_vars ());
															unset ($__refs, $__v); /* Unset defined __refs, __v. */
															/**/
															if (in_array ($field["id"], $fields_applicable)) /* Field applicable? */
																{
																	$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
																	$field_id_class = preg_replace ("/_/", "-", $field_var);
																	/**/
																	eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																	if (apply_filters ("ws_plugin__s2member_during_users_list_edit_cols_during_custom_fields_display", true, get_defined_vars ()))
																		{
																			echo '<tr>' . "\n";
																			echo '<th><label>' . ( (preg_match ("/^(checkbox|pre_checkbox)$/", $field["type"])) ? ucwords (preg_replace ("/_/", " ", $field_var)) : $field["label"]) . ':</label></th>' . "\n";
																			echo '<td>' . c_ws_plugin__s2member_custom_reg_fields::custom_field_gen (__FUNCTION__, $field, "ws_plugin__s2member_profile_", "ws-plugin--s2member-profile-", "", ( (preg_match ("/^(text|textarea|select|selects)$/", $field["type"])) ? "width:99%;" : ""), "", "", $fields, $fields[$field_var], true) . '</td>' . "\n";
																			echo '</tr>' . "\n";
																		}
																	unset ($__refs, $__v); /* Unset defined __refs, __v. */
																}
															/**/
															eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
															do_action ("ws_plugin__s2member_during_users_list_edit_cols_during_custom_fields_after", get_defined_vars ());
															unset ($__refs, $__v); /* Unset defined __refs, __v. */
														}
													/**/
													eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
													do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_custom_fields", get_defined_vars ());
													unset ($__refs, $__v); /* Unset defined __refs, __v. */
													/**/
													eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
													do_action ("ws_plugin__s2member_during_users_list_edit_cols_after", get_defined_vars ());
													unset ($__refs, $__v); /* Unset defined __refs, __v. */
													/**/
													echo '</table>' . "\n";
													/**/
													echo '<div style="margin:25px 0 25px 0; height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
												}
									}
							}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_after_users_list_edit_cols", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Function that saves custom fields after an admin updates profile.
					
					Attach to: add_action("edit_user_profile_update");
					Attach to: add_action("personal_options_update");
						w/ the Contant available:
						IS_PROFILE_PAGE
				
				Conditionals here need to match those in the function above:
					c_ws_plugin__s2member_users_list::users_list_edit_cols()
				*/
				public static function users_list_update_cols ($user_id = FALSE)
					{
						global $current_site, $current_blog; /* Multisite Networking. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_users_list_update_cols", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$user = new WP_User ($user_id); /* We need both. The $user and $current_user. */
						$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Get the current User's object. */
						/**/
						if (is_object ($user) && $user->ID && is_object ($current_user) && $current_user->ID) /* Validate both User objects. */
							{
								$level = c_ws_plugin__s2member_user_access::user_access_level ($user); /* This User's Access Level for s2Member. */
								/**/
								if (current_user_can ("edit_users") && (!is_multisite () || is_super_admin () || is_user_member_of_blog ($user->ID)))
									{
										if (is_array ($_p = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($_POST))) && !empty ($_p))
											{
												if (isset ($_p["ws_plugin__s2member_profile_s2member_originating_blog"]) && is_multisite () && is_super_admin ())
													update_user_meta ($user_id, "s2member_originating_blog", $_p["ws_plugin__s2member_profile_s2member_originating_blog"]);
												/**/
												if (isset ($_p["ws_plugin__s2member_profile_s2member_custom"]))
													update_user_option ($user_id, "s2member_custom", $_p["ws_plugin__s2member_profile_s2member_custom"]);
												/**/
												if (isset ($_p["ws_plugin__s2member_profile_s2member_subscr_gateway"]))
													update_user_option ($user_id, "s2member_subscr_gateway", $_p["ws_plugin__s2member_profile_s2member_subscr_gateway"]);
												/**/
												if (isset ($_p["ws_plugin__s2member_profile_s2member_subscr_id"]))
													update_user_option ($user_id, "s2member_subscr_id", $_p["ws_plugin__s2member_profile_s2member_subscr_id"]);
												/**/
												if (isset ($_p["ws_plugin__s2member_profile_s2member_notes"]))
													update_user_option ($user_id, "s2member_notes", $_p["ws_plugin__s2member_profile_s2member_notes"]);
												/**/
												$auto_eot_time = ($eot = $_p["ws_plugin__s2member_profile_s2member_auto_eot_time"]) ? strtotime ($eot) : "";
												if (isset ($_p["ws_plugin__s2member_profile_s2member_auto_eot_time"])) /* Then check if set. */
													update_user_option ($user_id, "s2member_auto_eot_time", $auto_eot_time);
												/**/
												if (isset ($_p["ws_plugin__s2member_profile_s2member_ccaps"]))
													{
														foreach ($user->allcaps as $cap => $cap_enabled)
															if (preg_match ("/^access_s2member_ccap_/", $cap))
																$user->remove_cap ($ccap = $cap);
														/**/
														foreach (preg_split ("/[\r\n\t\s;,]+/", $_p["ws_plugin__s2member_profile_s2member_ccaps"]) as $ccap)
															if (strlen ($ccap)) /* Don't add empty capabilities. */
																$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
													}
												/**/
												if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"])
													{
														foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
															{
																$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
																$field_id_class = preg_replace ("/_/", "-", $field_var);
																/**/
																$fields[$field_var] = $_p["ws_plugin__s2member_profile_" . $field_var];
															}
													}
												/**/
												update_user_option ($user_id, "s2member_custom_fields", $fields);
												/**/
												if ($level > 0) /* We ONLY process this if they are higher than Level #0. */
													{
														$pr_times = get_user_option ("s2member_paid_registration_times", $user_id);
														$pr_times["level"] = (!$pr_times["level"]) ? time () : $pr_times["level"]; /* Preserve. */
														$pr_times["level" . $level] = (!$pr_times["level" . $level]) ? time () : $pr_times["level" . $level];
														update_user_option ($user_id, "s2member_paid_registration_times", $pr_times); /* Update now. */
													}
												/**/
												if ($_p["ws_plugin__s2member_profile_opt_in"]) /* Should we process List Servers for this User? */
													c_ws_plugin__s2member_list_servers::process_list_servers (c_ws_plugin__s2member_user_access::user_access_role ($user), c_ws_plugin__s2member_user_access::user_access_level ($user), $user->user_login, $_p["pass1"], $user->user_email, $user->first_name, $user->last_name, false, true, $user_id);
												/**/
												if ($_p["ws_plugin__s2member_profile_ip_restrictions"]) /* Delete/reset IP Restrictions? */
													c_ws_plugin__s2member_ip_restrictions::delete_reset_specific_ip_restrictions (strtolower ($user->user_login));
												/**/
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_users_list_update_cols", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
											}
									}
								/**/
								else if ($current_user->ID === $user->ID) /* Otherwise, a User can always edit their own Profile. */
									{
										if (is_array ($_p = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($_POST))) && !empty ($_p))
											{
												if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"])
													if ($fields_applicable = c_ws_plugin__s2member_custom_reg_fields::custom_fields_configured_at_level ($level, "profile"))
														{
															$_existing_fields = get_user_option ("s2member_custom_fields", $user_id);
															/**/
															foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
																{
																	$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
																	$field_id_class = preg_replace ("/_/", "-", $field_var);
																	/**/
																	if (!in_array ($field["id"], $fields_applicable) || preg_match ("/^no/", $field["editable"]))
																		$fields[$field_var] = $_existing_fields[$field_var];
																	/**/
																	else if ($field["required"] === "yes" && empty ($_p["ws_plugin__s2member_profile_" . $field_var]) && $_p["ws_plugin__s2member_profile_" . $field_var] !== "0")
																		$fields[$field_var] = $_existing_fields[$field_var];
																	/**/
																	else /* Otherwise, we can use the newly updated value. */
																		$fields[$field_var] = $_p["ws_plugin__s2member_profile_" . $field_var];
																}
															/**/
															update_user_option ($user_id, "s2member_custom_fields", $fields);
														}
												/**/
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_users_list_update_cols", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
											}
									}
							}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_after_users_list_update_cols", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>