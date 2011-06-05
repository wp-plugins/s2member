<?php
/**
* Menu page for the s2Member plugin ( List Server Options page ).
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
* @package s2Member\Menu_Pages
* @since 3.0
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_menu_page_els_ops"))
	{
		/**
		* Menu page for the s2Member plugin ( List Server Options page ).
		*
		* @package s2Member\Menu_Pages
		* @since 110531
		*/
		class c_ws_plugin__s2member_menu_page_els_ops
			{
				public function __construct ()
					{
						echo '<div class="wrap ws-menu-page">' . "\n";
						/**/
						echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
						echo '<h2><div>Developed by <a href="' . esc_attr (c_ws_plugin__s2member_readmes::parse_readme_value ("Plugin URI")) . '" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/brand-light.png" alt="." /></a></div>s2Member® API / List Servers</h2>' . "\n";
						/**/
						echo '<div class="ws-menu-page-hr"></div>' . "\n";
						/**/
						echo '<table class="ws-menu-page-table">' . "\n";
						echo '<tbody class="ws-menu-page-table-tbody">' . "\n";
						echo '<tr class="ws-menu-page-table-tr">' . "\n";
						echo '<td class="ws-menu-page-table-l">' . "\n";
						/**/
						echo '<form method="post" name="ws_plugin__s2member_options_form" id="ws-plugin--s2member-options-form">' . "\n";
						echo '<input type="hidden" name="ws_plugin__s2member_options_save" id="ws-plugin--s2member-options-save" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-options-save")) . '" />' . "\n";
						/**/
						do_action ("ws_plugin__s2member_during_els_ops_page_before_left_sections", get_defined_vars ());
						/**/
						if (apply_filters ("ws_plugin__s2member_during_els_ops_page_during_left_sections_display_mailchimp", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_els_ops_page_during_left_sections_before_mailchimp", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="MailChimp® List Server Integration">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-mailchimp-section">' . "\n";
								echo '<a href="http://www.mailchimp.com/signup/?aid=8f347da54d66b5298d13237d9&afl=1" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/mailchimp-stamp.png" class="ws-menu-page-right" style="width:125px; height:125px; border:0;" alt="." /></a>' . "\n";
								echo '<h3>MailChimp® List Server Integration ( optional )</h3>' . "\n";
								echo '<p>s2Member can be integrated with MailChimp®. MailChimp® is an email marketing service. MailChimp® makes it easy to send email newsletters to your Customers, manage your MailChimp® subscriber lists, and track campaign performance. Although s2Member can be integrated with almost ANY list server, we highly recommend MailChimp®; because of their <a href="http://apidocs.mailchimp.com/?aid=8f347da54d66b5298d13237d9&afl=1" target="_blank" rel="external">powerful API for MailChimp® services</a>. In future versions of s2Member, we plan to build additional features into s2Member that work with, and extend, MailChimp® services.</p>' . "\n";
								echo '<p>For now, we\'ve covered the basics. You can have your Members automatically subscribed to your MailChimp® marketing lists <em>( e.g. newsletters / auto-responders )</em>. You\'ll need a <a href="http://www.mailchimp.com/signup/?aid=8f347da54d66b5298d13237d9&afl=1" target="_blank" rel="external">MailChimp® account</a>, a <a href="https://admin.mailchimp.com/account/api/" target="_blank" rel="external">MailChimp® API Key</a>, and your <a href="#" onclick="alert(\'To obtain your MailChimp® List ID(s), log into your MailChimp® account and click the Lists tab. Now click the (View) button, for the List(s) you want to integrate with s2Member. Then, click the (Settings) link. At the bottom of the (Settings) page, for each list; you\\\'ll find a Unique List ID.\'); return false;">MailChimp® List IDs</a>.</p>' . "\n";
								do_action ("ws_plugin__s2member_during_els_ops_page_during_left_sections_during_mailchimp", get_defined_vars ());
								/**/
								echo '<table class="form-table">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-mailchimp-api-key">' . "\n";
								echo 'MailChimp® API Key:' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_mailchimp_api_key" id="ws-plugin--s2member-mailchimp-api-key" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mailchimp_api_key"]) . '" /><br />' . "\n";
								echo 'Once you have a MailChimp® account, you\'ll need to <a href="https://admin.mailchimp.com/account/api/" target="_blank" rel="external">add an API Key</a>.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-level0-mailchimp-list-ids">' . "\n";
								echo 'List ID(s) for Free Subscribers ( comma-delimited ):' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_level0_mailchimp_list_ids" id="ws-plugin--s2member-level0-mailchimp-list-ids" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_mailchimp_list_ids"]) . '" /><br />' . "\n";
								echo 'New Free Subscribers will be subscribed to these List IDs.<br />' . "\n";
								echo 'Ex: <code>4a44fRio5d, 434ksvviEdf, 8834jsdf923, ee9djfs4jel3</code><br />' . "\n";
								echo 'Or: <code>4a44fRio5d::Group Title::Group|Another Group</code>' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-level1-mailchimp-list-ids">' . "\n";
								echo 'List ID(s) for Level #1 ( comma-delimited ):' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_level1_mailchimp_list_ids" id="ws-plugin--s2member-level1-mailchimp-list-ids" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_mailchimp_list_ids"]) . '" /><br />' . "\n";
								echo 'New Level 1 Members will be subscribed to these List IDs.<br />' . "\n";
								echo 'Ex: <code>4a44fRio5d, 434ksvviEdf, 8834jsdf923, ee9djfs4jel3</code><br />' . "\n";
								echo 'Or: <code>4a44fRio5d::Group Title::Group|Another Group</code>' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-level2-mailchimp-list-ids">' . "\n";
								echo 'List ID(s) for Level #2 ( comma-delimited ):' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_level2_mailchimp_list_ids" id="ws-plugin--s2member-level2-mailchimp-list-ids" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_mailchimp_list_ids"]) . '" /><br />' . "\n";
								echo 'New Level 2 Members will be subscribed to these List IDs.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-level3-mailchimp-list-ids">' . "\n";
								echo 'List ID(s) for Level #3 ( comma-delimited ):' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_level3_mailchimp_list_ids" id="ws-plugin--s2member-level3-mailchimp-list-ids" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_mailchimp_list_ids"]) . '" /><br />' . "\n";
								echo 'New Level 3 Members will be subscribed to these List IDs.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-level4-mailchimp-list-ids">' . "\n";
								echo 'List ID(s) for Level #4 ( comma-delimited ):' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_level4_mailchimp_list_ids" id="ws-plugin--s2member-level4-mailchimp-list-ids" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_mailchimp_list_ids"]) . '" /><br />' . "\n";
								echo 'New Level 4 Members will be subscribed to these List IDs.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_els_ops_page_during_left_sections_after_mailchimp", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_els_ops_page_during_left_sections_display_aweber", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_els_ops_page_during_left_sections_before_aweber", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="AWeber® List Server Integration">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-aweber-section">' . "\n";
								echo '<a href="http://aweber.com/?348037" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/aweber-logo.png" class="ws-menu-page-right" style="width:125px; height:125px; border:0;" alt="." /></a>' . "\n";
								echo '<h3>AWeber® List Server Integration ( optional )</h3>' . "\n";
								echo '<p>s2Member can be integrated with AWeber®. AWeber® is an email marketing service. Whether you\'re looking to get your first email campaign off the ground, or you\'re a seasoned veteran who wants to dig into advanced tools like detailed email web analytics, activity based segmentation, geo-targeting and broadcast split-testing, AWeber\'s got just what you need to make email marketing work for you.</p>' . "\n";
								echo '<p>You can have your Members automatically subscribed to your AWeber® marketing lists ( e.g. newsletters / auto-responders ). You\'ll need an <a href="http://aweber.com/?348037" target="_blank" rel="external">AWeber® account</a> and your <a href="#" onclick="alert(\'To obtain your AWeber® List ID(s), log into your AWeber® account. Click on the Lists tab. On that page you\\\'ll find a Unique List ID associated with each of your lists. AWeber® sometimes refers to this as a List Name instead of a List ID.\'); return false;">AWeber® List IDs</a>. You will ALSO need to configure a Custom Email Parser inside your AWeber® account. Log into AWeber®, and go to <em>My Lists -> Email Parser</em>. Choose the PayPal® Parser ( even if you\'re not using PayPal® as your Payment Gateway ). You can safely ignore the additional instructions they provide. s2Member just needs the PayPal® box checked, and that\'s all. At some point, we\'ll get in contact with AWeber® about integrating a Custom Parser that is specifically designed for s2Member. Until then, you can just use the PayPal® Parser that is already available in your AWeber® account.</p>' . "\n";
								do_action ("ws_plugin__s2member_during_els_ops_page_during_left_sections_during_aweber", get_defined_vars ());
								/**/
								echo '<table class="form-table">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-level0-aweber-list-ids">' . "\n";
								echo 'List ID(s) for Free Subscribers ( comma-delimited ):' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_level0_aweber_list_ids" id="ws-plugin--s2member-level0-aweber-list-ids" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_aweber_list_ids"]) . '" /><br />' . "\n";
								echo 'New Free Subscribers will be subscribed to these List IDs.<br />' . "\n";
								echo 'Ex: <code>mylist, myotherlist, anotherlist</code>' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-level1-aweber-list-ids">' . "\n";
								echo 'List ID(s) for Level #1 ( comma-delimited ):' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_level1_aweber_list_ids" id="ws-plugin--s2member-level1-aweber-list-ids" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_aweber_list_ids"]) . '" /><br />' . "\n";
								echo 'New Level 1 Members will be subscribed to these List IDs.<br />' . "\n";
								echo 'Ex: <code>mylist, myotherlist, anotherlist</code>' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-level2-aweber-list-ids">' . "\n";
								echo 'List ID(s) for Level #2 ( comma-delimited ):' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_level2_aweber_list_ids" id="ws-plugin--s2member-level2-aweber-list-ids" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_aweber_list_ids"]) . '" /><br />' . "\n";
								echo 'New Level 2 Members will be subscribed to these List IDs.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-level3-aweber-list-ids">' . "\n";
								echo 'List ID(s) for Level #3 ( comma-delimited ):' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_level3_aweber_list_ids" id="ws-plugin--s2member-level3-aweber-list-ids" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_aweber_list_ids"]) . '" /><br />' . "\n";
								echo 'New Level 3 Members will be subscribed to these List IDs.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-level4-aweber-list-ids">' . "\n";
								echo 'List ID(s) for Level #4 ( comma-delimited ):' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_level4_aweber_list_ids" id="ws-plugin--s2member-level4-aweber-list-ids" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_aweber_list_ids"]) . '" /><br />' . "\n";
								echo 'New Level 4 Members will be subscribed to these List IDs.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_els_ops_page_during_left_sections_after_aweber", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_els_ops_page_during_left_sections_display_opt_in", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_els_ops_page_during_left_sections_before_opt_in", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Registration / Double Opt-In Box?">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-opt-in-section">' . "\n";
								echo '<h3>Double Opt-In Checkbox Field ( optional )</h3>' . "\n";
								echo '<p>A Double Opt-In Checkbox will ONLY be displayed, if you\'ve integrated one <em>or more</em> List Servers.' . ((defined ("BP_VERSION")) ? ' With BuddyPress installed, the Checkbox will only be displayed if your BuddyPress theme supports <code>do_action("bp_before_registration_submit_buttons")</code>. Almost all BuddyPress themes support this. If yours does not, you can add it in.' : '') . '</p>' . "\n";
								do_action ("ws_plugin__s2member_during_els_ops_page_during_left_sections_during_opt_in", get_defined_vars ());
								/**/
								echo '<table class="form-table">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr class="ws-plugin--s2member-custom-reg-opt-in-label-row"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"]) ? ' style="display:none;"' : '') . '>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-custom-reg-opt-in-label">' . "\n";
								echo 'Double Opt-In Checkbox Label:' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr class="ws-plugin--s2member-custom-reg-opt-in-label-row"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"]) ? ' style="display:none;"' : '') . '>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_custom_reg_opt_in_label" id="ws-plugin--s2member-custom-reg-opt-in-label" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in_label"]) . '" /><br />' . "\n";
								echo 'Example: <code><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] == 1) ? 'checked' : 'unchecked') . '.png" class="ws-plugin--s2member-custom-reg-opt-in-label-prev-img ws-menu-page-img-16" style="vertical-align:middle;" alt="" /> Your Label will appear next to a Checkbox.</code>' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-custom-reg-opt-in">' . "\n";
								echo 'Require Double Opt-In Checkbox?' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<select name="ws_plugin__s2member_custom_reg_opt_in" id="ws-plugin--s2member-custom-reg-opt-in">' . "\n";
								echo '<option value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] == 1) ? ' selected="selected"' : '') . '>Yes ( the Box MUST be checked — checked by default )</option>' . "\n";
								echo '<option value="2"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] == 2) ? ' selected="selected"' : '') . '>Yes ( the Box MUST be checked — unchecked by default )</option>' . "\n";
								echo '<option value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"]) ? ' selected="selected"' : '') . '>No ( disable — do NOT display or require the Checkbox )</option>' . "\n";
								echo '</select><br />' . "\n";
								echo 'An email confirmation will NOT be sent to the User, unless the Box is checked, or you\'ve disabled the Box; by choosing <code>No</code>.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_els_ops_page_during_left_sections_after_opt_in", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_els_ops_page_during_left_sections_display_opt_out", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_els_ops_page_during_left_sections_before_opt_out", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Automate Un-Subscribe/Opt-Outs?">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-opt-out-section">' . "\n";
								echo '<h3>Automate Un-Subscribe/Opt-Out Removals ( optional )</h3>' . "\n";
								echo '<p>s2Member can automatically ( and silently ) remove Users from the List Servers you\'ve configured above. s2Member is also capable of automating this, based on your own personal configuration preferences. Below, you can choose which Events you consider grounds for List Removal. It is also important to point out that s2Member will ONLY remove Users from the Lists you\'ve configured at the Level the Member is/was at during the time of the Event. For example, if a Level #1 Member is deleted, they will ONLY be removed from the List(s) you\'ve configured at Level #1. If an account is upgraded from Level #1 to Level #2, they will ONLY be removed from the List(s) you\'ve configured at Level #1. Of course, all of this is based on the configuration below.</p>' . "\n";
								echo '<p><em><strong>*Regarding AWeber®*</strong> these will NOT work for AWeber® until you <a href="http://www.aweber.com/faq/questions/62/Can+I+Unsubscribe+People+Via+Email%3F" target="_blank" rel="external">add a Notification Email</a> to your AWeber® account matching the "EMail From Address" configured in <code>s2Member -> General Options -> EMail Configuration</code>. Which is currently set to: <code>' . esc_html ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"]) . '</code>. This is a required step if you want s2Member to be authenticated properly when it automatically emails List Removal requests to AWeber®.</em></p>' . "\n";
								do_action ("ws_plugin__s2member_during_els_ops_page_during_left_sections_during_opt_out", get_defined_vars ());
								/**/
								echo '<table class="form-table">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-custom-reg-auto-opt-outs">' . "\n";
								echo 'Process List Removals Automatically? ( choose events )' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<div class="ws-menu-page-scrollbox" style="height:150px;">' . "\n";
								echo '<input type="hidden" name="ws_plugin__s2member_custom_reg_auto_opt_outs[]" value="update-signal" />' . "\n";
								foreach (array (/**/
								"removal-deletion" => "<strong>Anytime a User is deleted ( including manual deletions )</strong>",/**/
								"ipn-refund-reversal-deletion" => "&#9492;&#9472; Anytime s2Member deletes an account because of a Refund/Reversal.",/**/
								"(ipn|auto-eot)-cancellation-expiration-deletion" => "&#9492;&#9472; Anytime s2Member deletes an account because of a Cancellation/Expiration.",/**/
								/**/
								"modification" => "<strong>Anytime a User's Role changes ( including manual changes )</strong>",/**/
								"ipn-refund-reversal-demotion" => "&#9492;&#9472; Anytime s2Member demotes an account because of a Refund/Reversal.",/**/
								"(ipn|auto-eot)-cancellation-expiration-demotion" => "&#9492;&#9472; Anytime s2Member demotes an account because of a Cancellation/Expiration.",/**/
								"ipn-upgrade-downgrade" => "&#9492;&#9472; Anytime s2Member changes a User's Role after a paid Subscr. Modification.",/**/
								) as $ws_plugin__s2member_temp_s_value => $ws_plugin__s2member_temp_s_label)
									echo '<input type="checkbox" name="ws_plugin__s2member_custom_reg_auto_opt_outs[]" id="ws-plugin--s2member-custom-reg-auto-opt-outs-' . esc_attr (preg_replace ("/[^a-z0-9_\-]/", "-", $ws_plugin__s2member_temp_s_value)) . '" value="' . esc_attr ($ws_plugin__s2member_temp_s_value) . '"' . ((in_array ($ws_plugin__s2member_temp_s_value, $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_auto_opt_outs"])) ? ' checked="checked"' : '') . ' /> <label for="ws-plugin--s2member-custom-reg-auto-opt-outs-' . esc_attr (preg_replace ("/[^a-z0-9_\-]/", "-", $ws_plugin__s2member_temp_s_value)) . '">' . $ws_plugin__s2member_temp_s_label . '</label><br />' . "\n";
								echo '</div>' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-custom-reg-auto-opt-out-transitions">' . "\n";
								echo 'Also Process List Transitions Automatically?' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<select name="ws_plugin__s2member_custom_reg_auto_opt_out_transitions" id="ws-plugin--s2member-custom-reg-auto-opt-out-transitions">' . "\n";
								echo '<option value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_auto_opt_out_transitions"]) ? ' selected="selected"' : '') . '>No ( do NOT transition mailing list Subscribers automatically )</option>' . "\n";
								echo '<option value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_auto_opt_out_transitions"]) ? ' selected="selected"' : '') . '>Yes ( automatically transition mailing list Subscribers )</option>' . "\n";
								echo '</select><br />' . "\n";
								echo '<em><strong>*Transitions*</strong> When/if s2Member automatically removes a Member from Lists at their current Level# ( based on your configuration in the previous section ), this setting tells s2Member that it should <strong>also</strong> transition the Member to any Lists you\'ve configured at the new Access Level# ( i.e. Role ) they are being changed to. For example, if a Member is demoted from Level #1 to Level #0, do you want s2Member to add them to the Level #0 List(s) after it removes them from the Level #1 List(s)?</em><br /><br />' . "\n";
								echo '<em><strong>*Seamless with MailChimp®*</strong> If enabled, Automatic List Transitions work seamlessly with MailChimp®. Automatic List Transitions also work with AWeber®, but AWeber® will send the Member a new confirmation email, asking them to confirm changes to their mailing list subscription with you. Work is underway to improve this aspect of s2Member\'s integration with AWeber® in a future release. Ideally, a Customer would be transitioned silently behind the scene with AWeber® too.</em>' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_els_ops_page_during_left_sections_after_opt_out", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_els_ops_page_during_left_sections_display_other_methods", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_els_ops_page_during_left_sections_before_other_methods", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Other List Server Integration Methods">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-other-methods-section">' . "\n";
								echo '<h3>Other List Server Integrations ( there\'s always a way )</h3>' . "\n";
								echo '<p>Check the s2Member API Notifications panel. You\'ll find additional layers of automation available through the use of the `Signup`, `Registration`, `Payment`, `EOT/Deletion`, `Refund/Reversal`, and `Specific Post/Page` Notifications that are available to you through the s2Member API. These make it possible to integrate with 3rd party applications; like list servers, affiliate programs, and other back-office routines; in more advanced ways. You will probably need to get help from a web developer though. s2Member API Notifications require some light PHP scripting by someone familiar with web service connections.</p>' . "\n";
								do_action ("ws_plugin__s2member_during_els_ops_page_during_left_sections_during_other_methods", get_defined_vars ());
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_els_ops_page_during_left_sections_after_other_methods", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_during_els_ops_page_after_left_sections", get_defined_vars ());
						/**/
						echo '<div class="ws-menu-page-hr"></div>' . "\n";
						/**/
						echo '<p class="submit"><input type="submit" class="button-primary" value="Save All Changes" /></p>' . "\n";
						/**/
						echo '</form>' . "\n";
						/**/
						echo '</td>' . "\n";
						/**/
						echo '<td class="ws-menu-page-table-r">' . "\n";
						c_ws_plugin__s2member_menu_pages_rs::display ();
						echo '</td>' . "\n";
						/**/
						echo '</tr>' . "\n";
						echo '</tbody>' . "\n";
						echo '</table>' . "\n";
						/**/
						echo '</div>' . "\n";
					}
			}
	}
/**/
new c_ws_plugin__s2member_menu_page_els_ops ();
?>