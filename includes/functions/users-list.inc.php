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
Function that adds columns to the list of Users.
Attach to: add_filter ("manage_users_columns");
*/
function ws_plugin__s2member_users_list_cols ($cols = FALSE)
	{
		$cols["s2member_registration_time"] = "Registered On"; /* Date they signed up. */
		$cols["s2member_subscr_id"] = "PayPal® Subscr. ID"; /* Special field that is always applied. */
		$cols["s2member_ccaps"] = "Custom Capabilities"; /* Special field that is always applied. */
		/**/
		if (!defined ("BP_VERSION")) /* Custom fields are not compatible when running together with BuddyPress. */
			{
				foreach (preg_split ("/[\r\n\t,;]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
					{
						if ($field = trim ($field, "* \t\n\r\0\x0B")) /* Don't process empty fields. */
							{
								$cols[preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field))] = $field;
							}
					}
			}
		/**/
		return $cols;
	}
/*
Function that displays column data in the row of details.
Attach to: add_filter ("manage_users_custom_column");
*/
function ws_plugin__s2member_users_list_display_cols ($_ = FALSE, $col = FALSE, $user_id = FALSE)
	{
		global $user_object; /* The user_row() function already has this. */
		$user = $user_object; /* Shorter reference to the user_object var. */
		static $fields, $fields_4_user_id; /* Used to conserve resources. */
		/**/
		if ((!isset ($fields) || $fields_4_user_id !== $user_id) && ($fields_4_user_id = $user_id))
			$fields = get_usermeta ($user_id, "s2member_custom_fields");
		/**/
		if ($col === "s2member_registration_time")
			return ($r = $user->user_registered) ? /* Displays date & time ( 2 lines ). */
			date ("D M j, Y", strtotime ($r)) . '<br />@exactly ' . date ("g:i a", strtotime ($r)) : "—";
		/**/
		else if ($col === "s2member_subscr_id")
			return ($r = get_usermeta ($user_id, "s2member_subscr_id")) ? esc_html ($r) : "—";
		/**/
		else if ($col === "s2member_ccaps") /* Custom Capabilities. */
			{
				foreach ($user->allcaps as $cap => $cap_enabled)
					if (preg_match ("/^access_s2member_ccap_/", $cap))
						$ccaps[] = preg_replace ("/^access_s2member_ccap_/", "", $cap);
				/**/
				return (!empty ($ccaps)) ? implode ("<br />", $ccaps) : "—";
			}
		/**/
		if ($fields[$col] && preg_match ("/^http(s?)\:/i", $fields[$col]))
			return '<a href="' . esc_attr ($fields[$col]) . '" target="_blank">' . esc_html (substr ($fields[$col], strpos ($fields[$col], ":") + 3, 25) . "...") . '</a>';
		/**/
		return ($fields[$col]) ? esc_html ($fields[$col]) : "—";
	}
/*
Function that adds custom fields to the admin profile editing page.
Attach to: add_action("edit_user_profile");
Attach to: add_action("show_user_profile");
*/
function ws_plugin__s2member_users_list_edit_cols ($user = FALSE)
	{
		if (current_user_can ("edit_users")) /* Security check. */
			{
				echo '<div style="margin:25px 0 25px 0; height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
				/**/
				echo '<h3>s2Member Configuration &amp; Profile Fields</h3>' . "\n";
				/**/
				echo '<table class="form-table">' . "\n";
				/**/
				echo '<tr>' . "\n";
				echo '<th><label>PayPal® Subscr. ID</label> <a href="#" onclick="alert(\'This will be filled automatically by s2Member, as needed.\\n\\nA PayPal® Subscr ID is only valid for paid Members. This field will always be empty for Free Subscribers, Administrators, Contributors, and Authors. This field is only editable for Customer Service purposes; just in case you ever need to update the PayPal® Subscr ID manually. You are not likely to need this, but s2Member makes it editable, just in case.\'); return false;">[?]</a></th>' . "\n";
				echo '<td><input type="text" name="ws_plugin__s2member_profile_s2member_subscr_id" value="' . esc_attr (get_usermeta ($user->ID, "s2member_subscr_id")) . '" class="regular-text" /></td>' . "\n";
				echo '</tr>' . "\n";
				/**/
				foreach ($user->allcaps as $cap => $cap_enabled)
					if (preg_match ("/^access_s2member_ccap_/", $cap))
						$ccaps[] = preg_replace ("/^access_s2member_ccap_/", "", $cap);
				/**/
				echo '<tr>' . "\n";
				echo '<th><label>Custom Capabilities</label> <a href="#" onclick="alert(\'Optional. This is VERY advanced. For full details, see:\\ns2Member -> API Scripting -> Custom Capabilities.\'); return false;">[?]</a></th>' . "\n";
				echo '<td><input type="text" name="ws_plugin__s2member_profile_s2member_ccaps" value="' . esc_attr (((!empty ($ccaps)) ? implode (",", $ccaps) : "")) . '" class="regular-text" onkeyup="this.value = jQuery.trim (jQuery.trim (this.value).replace (/[ \-]/g, \'_\').replace (/[^A-Z_0-9,]/gi, \'\').toLowerCase ());"; /></td>' . "\n";
				echo '</tr>' . "\n";
				/**/
				if (!defined ("BP_VERSION")) /* Custom fields are not compatible when running together with BuddyPress. */
					{
						$fields = get_usermeta ($user->ID, "s2member_custom_fields");
						/**/
						foreach (preg_split ("/[\r\n\t,;]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
							{
								if ($field = trim ($field, "* \t\n\r\0\x0B")) /* Don't process empty fields. */
									{
										echo '<tr>' . "\n";
										echo '<th><label>' . esc_html ($field) . ' </label></th>' . "\n";
										$field = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
										echo '<td><input type="text" name="ws_plugin__s2member_profile_' . esc_attr ($field) . '" value="' . esc_attr ($fields[$field]) . '" class="regular-text" /></td>' . "\n";
										echo '</tr>' . "\n";
									}
							}
					}
				/**/
				echo '</table>' . "\n";
				/**/
				echo '<div style="margin:25px 0 25px 0; height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
			}
	}
/*
Function that saves custom fields after an admin updates profile.
Attach to: add_action("edit_user_profile");
Attach to: add_action("personal_options_update");
*/
function ws_plugin__s2member_users_list_update_cols ($user_id = FALSE)
	{
		if (current_user_can ("edit_users")) /* Quick security check here. */
			{
				if (is_array ($_POST = stripslashes_deep ($_POST)) && !empty ($_POST))
					{
						$user = new WP_User ($user_id);
						update_usermeta ($user_id, "s2member_subscr_id", $_POST["ws_plugin__s2member_profile_s2member_subscr_id"]);
						/**/
						foreach ($user->allcaps as $cap => $cap_enabled)
							if (preg_match ("/^access_s2member_ccap_/", $cap))
								$user->remove_cap ($ccap = $cap);
						/**/
						foreach (preg_split ("/[\r\n\t\s;,]+/", $_POST["ws_plugin__s2member_profile_s2member_ccaps"]) as $ccap)
							if (strlen ($ccap)) /* Don't add empty capabilities. */
								$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
						/**/
						if (!defined ("BP_VERSION")) /* Custom fields are not compatible when running together with BuddyPress. */
							{
								foreach (preg_split ("/[\r\n\t,;]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
									{
										if ($field = trim ($field, "* \t\n\r\0\x0B")) /* Don't process empty fields. */
											{
												$field = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
												$fields[$field] = trim ($_POST["ws_plugin__s2member_profile_" . $field]);
											}
									}
								/**/
								update_usermeta ($user_id, "s2member_custom_fields", $fields);
							}
					}
			}
	}
?>