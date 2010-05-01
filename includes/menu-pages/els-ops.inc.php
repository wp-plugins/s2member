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
PayPal® Options page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member API / List Servers</h2>' . "\n";
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
echo '<div class="ws-menu-page-group" title="MailChimp® List Server Integration">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-mailchimp-section">' . "\n";
echo '<a href="http://www.mailchimp.com/signup/?aid=8f347da54d66b5298d13237d9&afl=1" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/mailchimp-stamp.png" class="ws-menu-page-right" style="width:125px; height:125px; border:0;" alt="." /></a>' . "\n";
echo '<h3>MailChimp® List Server Integration ( optional )</h3>' . "\n";
echo '<p>s2Member can be integrated with MailChimp®. MailChimp® is an email marketing service. MailChimp® makes it easy to send email newsletters to your Customers, manage your MailChimp® subscriber lists, and track campaign performance. Although s2Member can be integrated with almost ANY list server, we highly recommend MailChimp®; because of their <a href="http://www.mailchimp.com/api/?aid=8f347da54d66b5298d13237d9&afl=1" target="_blank" rel="xlink">powerful API for MailChimp® services</a>. In future versions of s2Member, we plan to build additional features into s2Member that work with, and extend, MailChimp® services.</p>' . "\n";
echo '<p>For now, we\'ve covered the basics. You can have your Members automatically subscribed to your MailChimp® marketing lists ( e.g. newsletters / auto-responders ). You\'ll need a <a href="http://www.mailchimp.com/signup/?aid=8f347da54d66b5298d13237d9&afl=1" target="_blank" rel="xlink">MailChimp® account</a>, a <a href="http://admin.mailchimp.com/account/api-key-popup" target="_blank" rel="xlink">MailChimp® API Key</a>, and your <a href="#" onclick="alert(\'To obtain your MailChimp® List ID(s), log into your MailChimp® account, click on the Lists tab. Click the (View) button, for the list(s) you want to integrate with s2Member. Then, click the (settings) link at the top. On the main (settings) page, for each list, you\\\'ll find a Unique List ID.\'); return false;">MailChimp® List IDs</a>.</p>' . "\n";
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
echo 'Once you have a MailChimp® account, you\'ll need to <a href="http://admin.mailchimp.com/account/api-key-popup" target="_blank" rel="xlink">add an API Key</a>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level0-mailchimp-list-ids">' . "\n";
echo 'List ID(s) for Free Subscribers ( comma delimited ):' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level0_mailchimp_list_ids" id="ws-plugin--s2member-level0-mailchimp-list-ids" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_mailchimp_list_ids"]) . '" /><br />' . "\n";
echo 'New Free Subscribers will be subscribed to these List IDs.<br />' . "\n";
echo 'Ex: <code>4654aad4s5d, 4323344ksdf, 23234j23k3</code>' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level1-mailchimp-list-ids">' . "\n";
echo 'List ID(s) for Level #1 ( comma delimited ):' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level1_mailchimp_list_ids" id="ws-plugin--s2member-level1-mailchimp-list-ids" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_mailchimp_list_ids"]) . '" /><br />' . "\n";
echo 'New Level 1 Members will be subscribed to these List IDs.<br />' . "\n";
echo 'Ex: <code>4654aad4s5d, 4323344ksdf, 23234j23k3</code>' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level2-mailchimp-list-ids">' . "\n";
echo 'List ID(s) for Level #2 ( comma delimited ):' . "\n";
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
echo 'List ID(s) for Level #3 ( comma delimited ):' . "\n";
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
echo 'List ID(s) for Level #4 ( comma delimited ):' . "\n";
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
echo '<div class="ws-menu-page-group" title="AWeber® List Server Integration">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-aweber-section">' . "\n";
echo '<a href="http://aweber.com/?348037" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/aweber-logo.png" class="ws-menu-page-right" style="width:125px; height:125px; border:0;" alt="." /></a>' . "\n";
echo '<h3>AWeber® List Server Integration ( optional )</h3>' . "\n";
echo '<p>s2Member can be integrated with AWeber®. AWeber® is an email marketing service. Whether you\'re looking to get your first email campaign off the ground, or you\'re a seasoned veteran who wants to dig into advanced tools like detailed email web analytics, activity based segmentation, geo-targeting and broadcast split-testing, AWeber\'s got just what you need to make email marketing work for you.</p>' . "\n";
echo '<p>You can have your Members automatically subscribed to your AWeber® marketing lists ( e.g. newsletters / auto-responders ). You\'ll need an <a href="http://aweber.com/?348037" target="_blank" rel="xlink">AWeber® account</a> and your <a href="#" onclick="alert(\'To obtain your AWeber® List ID(s), log into your AWeber® account. Click on the Lists tab. On that page you\\\'ll find a Unique List ID associated with each of your lists. AWeber® sometimes refers to this as a List Name instead of a List ID.\'); return false;">AWeber® List IDs</a>. You will ALSO need to configure a Custom Email Parser inside your AWeber® account. Log into AWeber®, and go to <em>My Lists -> Email Parser</em>. Choose the PayPal® Parser. You can safely ignore the additional instructions they provide. s2Member just needs the PayPal® box checked, and that\'s all. At some point, we\'ll get in contact with AWeber® about integrating a Custom Parser that is specifically designed for s2Member. Until then, you can just use the PayPal® Parser that is already available in your AWeber® account.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level0-aweber-list-ids">' . "\n";
echo 'List ID(s) for Free Subscribers ( comma delimited ):' . "\n";
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
echo 'List ID(s) for Level #1 ( comma delimited ):' . "\n";
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
echo 'List ID(s) for Level #2 ( comma delimited ):' . "\n";
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
echo 'List ID(s) for Level #3 ( comma delimited ):' . "\n";
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
echo 'List ID(s) for Level #4 ( comma delimited ):' . "\n";
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
echo '<div class="ws-menu-page-group" title="Other List Server Integration Methods">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-other-lists-section">' . "\n";
echo '<h3>Other List Server Integrations ( there\'s always a way )</h3>' . "\n";
echo '<p>Check the s2Member API Notifications panel. You\'ll find additional layers of automation available through the use of the `Signup`, `Registration`, `Payment`, `EOT/Deletion`, `Refund/Reversal`, and `Single-Page` notifications that are available to you through the s2Member API. These make it possible to integrate with 3rd party applications; like list servers, affiliate programs, and other back-office routines; in more advanced ways. You will probably need to get help from a web developer though. s2Member API Notifications require some light PHP scripting by someone familiar with web service connections.</p>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p class="submit"><input type="submit" class="button-primary" value="Save Changes" /></p>' . "\n";
/**/
echo '</form>' . "\n";
/**/
echo '</td>' . "\n";
/**/
echo '<td class="ws-menu-page-table-r">' . "\n";
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["installation"]) ? '<div class="ws-menu-page-installation"><a href="' . ws_plugin__s2member_parse_readme_value ("Professional Installation URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-installation.png" alt="." title="Contact PriMoThemes!" /></a></div>' . "\n" : '';
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["tools"]) ? '<div class="ws-menu-page-tools"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-tools.png" alt="." /></div>' . "\n" : '';
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["tips"]) ? '<div class="ws-menu-page-tips"><a href="' . ws_plugin__s2member_parse_readme_value ("Customization URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-tips.png" alt="." /></a></div>' . "\n" : '';
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["donations"]) ? '<div class="ws-menu-page-donations"><a href="' . ws_plugin__s2member_parse_readme_value ("Donate link") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-donations.jpg" alt="." /></a></div>' . "\n" : '';
/**/
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
/**/
echo '</div>' . "\n";
?>