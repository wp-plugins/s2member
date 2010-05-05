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
General Options page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member General Options</h2>' . "\n";
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
echo '<input type="hidden" name="ws_plugin__s2member_configured" id="ws-plugin--s2member-configured" value="1" />' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Security Encryption Key">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-security-section">' . "\n";
echo '<h3>Security Encryption Key ( optional, for tighter security )</h3>' . "\n";
echo '<p>Just like WordPress®, s2Member is open-source software. Which is wonderful. However, this also makes it possible for anyone to grab a copy of the software, and try to learn their way around its security measures. In order to keep your installation of s2Member unique/secure, you should configure a Security Encryption Key. s2Member will use your Security Encryption Key to protect itself against hackers. It does this by encrypting all sensitive information with your Key. A Security Encryption Key is unique to your installation.</p>' . "\n";
echo '<p>Once you configure this, you do NOT want to change it; not ever. In fact, it is a VERY good idea to keep this backed up in a safe place, just in case you need to move your site, or re-install s2Member in the future. Some of the sensitive data that s2Member stores, will be encrypted with this Key. If you change it, that data can no longer be read, even by s2Member itself. In other words, don\'t use s2Member for six months, then decide to change your Key. That would break your installation. You configure this once, for each installation of s2Member; and you NEVER change it.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-sec-encryption-key">' . "\n";
echo 'Security Encryption Key:' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"]) ? ' ( <a href="#" onclick="ws_plugin__s2member_enableSecurityKey();" title="( not recommended )">edit key</a> )' : ' ( <a href="#" onclick="ws_plugin__s2member_generateSecurityKey();" title="Insert an auto-generated Key. ( recommended )">auto-generate</a> )') . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_sec_encryption_key" id="ws-plugin--s2member-sec-encryption-key" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"]) . '" maxlength="256" autocomplete="off"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"]) ? ' disabled="disabled"' : '') . ' />' . "\n";
echo (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"]) ? '<br />This may contain letters, numbers, spaces; even punctuation. Up to 256 characters.<br /><em>Ex: <code>' . esc_html (strtoupper (ws_plugin__s2member_random_str_gen (56))) . '</code></em>' . "\n" : '';
echo (count ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key_history"]) > 1) ? '<br /><a href="#" onclick="ws_plugin__s2member_securityKeyHistory();">Click here</a> for a history of your last 10 Encryption Keys.<div id="ws-plugin--s2member-sec-encryption-key-history" style="display:none;"><code>' . implode ('</code><br /><code>', $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key_history"]) . '</code></div>' . "\n" : '';
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Email Configuration">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-email-section">' . "\n";
echo '<h3>EMail From: ' . esc_html ('"Name" <address>') . '</h3>' . "\n";
echo '<p>This is the name/address that will appear in outgoing email notifications sent by the s2Member plugin.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-reg-email-from-name">' . "\n";
echo 'EMail From Name:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_reg_email_from_name" id="ws-plugin--s2member-reg-email-from-name" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . '" /><br />' . "\n";
echo 'We recommend that you use the name of your site here.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-reg-email-from-email">' . "\n";
echo 'EMail From Address:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_reg_email_from_email" id="ws-plugin--s2member-reg-email-from-email" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"]) . '" /><br />' . "\n";
echo 'We recommend something like: support@your-domain.com.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Custom Registration Fields">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-custom-reg-fields-section">' . "\n";
echo '<h3>Custom Registration Fields ( optional, for further customization )</h3>' . "\n";
echo '<p>This is a comma delimited list of additional form fields to collect during registration. By default, all of your Custom Fields will remain optional to the User. That is, the User will NOT be required to enter any of these values. If you want specific fields to be *required*, wrap those Custom Fields inside *asterisks*. Some fields are already built-in by default. The defaults are: <code>*Username*, *Email*, *First Name*, *Last Name*</code>. If you need to add other Custom Fields, in addition to these defaults, you can do that here.</p>' . "\n";
if (defined ("BP_VERSION")) /* Notify the site owner about the conflict with Custom Fields and BuddyPress. */
	echo '<p><em class="ws-menu-page-error">* Custom Registration Fields are NOT applicable with BuddyPress. Instead, use <code>BuddyPress -> Profile Field Setup</code>.</em></p>' . "\n";
if (!function_exists ("ws_plugin__s2member_generate_password"))
	echo '<p><em class="ws-menu-page-error">* Custom Passwords CANNOT be used with your installation of s2Member. This is due to a minor conflict with another plugin that is using <code>wp_generate_password()</code>. If you really want to allow Custom Passwords during registration, please disable some of your other plugins until this warning goes away.</em></p>' . "\n";
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-custom-reg-fields">' . "\n";
echo 'Custom Registration Fields:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_custom_reg_fields" id="ws-plugin--s2member-custom-reg-fields" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) . '" /><br />' . "\n";
echo 'Comma delimited please. <em>Ex: <code>*Company*, *Website URL*, Street Address, City, State, Zip Code, Phone</code></em>' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-custom-reg-password">' . "\n";
echo 'Allow Custom Passwords during Registration?' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<select name="ws_plugin__s2member_custom_reg_password" id="ws-plugin--s2member-custom-reg-password">' . "\n";
echo '<option value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"]) ? ' selected="selected"' : '') . '>No ( send auto-generated passwords via email; after registration )</option>' . "\n";
echo '<option value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"]) ? ' selected="selected"' : '') . '>Yes ( allow members to create their own password during registration )</option>' . "\n";
echo '</select><br />' . "\n";
echo 'Auto-generated Passwords are recommended for best security; because, this also serves as a form of email confirmation.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Login/Registration Design">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-login-registration-section">' . "\n";
echo '<h3>Login/Registration Page Customization ( required )</h3>' . "\n";
echo '<p>These settings allow you to customize the user interface for your Login / Registration Pages:<br />( <a href="' . wp_login_url () . '" target="_blank" rel="xlink">' . esc_html (wp_login_url ()) . '</a> )</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<h3>Background Settings</h3>' . "\n";
echo '<p>These settings are all focused on your Login/Registration Background.</p>' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-login-reg-background-color">' . "\n";
echo 'Background Color:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_login_reg_background_color" id="ws-plugin--s2member-login-reg-background-color" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_color"]) . '" /><br />' . "\n";
echo 'Set this to a 6-digit hex color code.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-login-reg-background-image">' . "\n";
echo 'Seamless Tile Background Image:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_login_reg_background_image" id="ws-plugin--s2member-login-reg-background-image" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image"]) . '" /><br />' . "\n";
echo '<input type="button" id="ws-plugin--s2member-login-reg-background-image-media-btn" value="Open Media Library" class="ws-menu-page-media-btn" rel="ws-plugin--s2member-login-reg-background-image" />' . "\n";
echo 'Set this to the URL of your Background Image. ( this is optional )<br />';
echo 'If supplied, your Background Image will be tiled.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-login-reg-background-text-color">' . "\n";
echo 'Color of Text on top of your Background:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_login_reg_background_text_color" id="ws-plugin--s2member-login-reg-background-text-color" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_text_color"]) . '" /><br />' . "\n";
echo 'Set this to a 6-digit hex color code.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-login-reg-background-text-shadow-color">' . "\n";
echo 'Shadow Color for Text on top of your Background:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_login_reg_background_text_shadow_color" id="ws-plugin--s2member-login-reg-background-text-shadow-color" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_text_shadow_color"]) . '" /><br />' . "\n";
echo 'Set this to a 6-digit hex color code.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-login-reg-background-box-shadow-color">' . "\n";
echo 'Shadow Color for Boxes on top of your Background:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_login_reg_background_box_shadow_color" id="ws-plugin--s2member-login-reg-background-box-shadow-color" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"]) . '" /><br />' . "\n";
echo 'Set this to a 6-digit hex color code.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<h3>Logo Image Settings</h3>' . "\n";
echo '<p>These settings are all focused on your Login/Registration Logo.</p>' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-login-reg-logo-src">' . "\n";
echo 'Logo Image Location:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_login_reg_logo_src" id="ws-plugin--s2member-login-reg-logo-src" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_src"]) . '" /><br />' . "\n";
echo '<input type="button" id="ws-plugin--s2member-login-reg-logo-src-media-btn" value="Open Media Library" class="ws-menu-page-media-btn" rel="ws-plugin--s2member-login-reg-logo-src" />' . "\n";
echo 'Set this to the URL of your Logo Image.<br />' . "\n";
echo 'Suggested size is around 500 x 100.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-login-reg-logo-src-width">' . "\n";
echo 'Logo Image Width:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_login_reg_logo_src_width" id="ws-plugin--s2member-login-reg-logo-src-width" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_src_width"]) . '" /><br />' . "\n";
echo 'The pixel Width of your Logo Image. <em>* This ALSO affects the overall width of your Login/Registration forms. If you want wider form fields, use a wider Logo.</em>' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-login-reg-logo-src-height">' . "\n";
echo 'Logo Image Height:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_login_reg_logo_src_height" id="ws-plugin--s2member-login-reg-logo-src-height" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_src_height"]) . '" /><br />' . "\n";
echo 'The pixel Height of your Logo Image.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-login-reg-logo-url">' . "\n";
echo 'Logo Image Click URL:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_login_reg_logo_url" id="ws-plugin--s2member-login-reg-logo-url" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_url"]) . '" /><br />' . "\n";
echo 'Set this to the Click URL for your Logo Image.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-login-reg-logo-title">' . "\n";
echo 'Logo Image Title Attribute:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_login_reg_logo_title" id="ws-plugin--s2member-login-reg-logo-title" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_title"]) . '" /><br />' . "\n";
echo 'Used as the <code>title=""</code> attribute for your Logo Image.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Login Welcome Page">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-login-welcome-page-section">' . "\n";
echo '<h3>Login Welcome Page ( required, please customize this )</h3>' . "\n";
echo '<p>Please create and/or choose an existing Page to use as the first page Members will see after logging in.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-login-welcome-page">' . "\n";
echo 'Login Welcome Page:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<select name="ws_plugin__s2member_login_welcome_page" id="ws-plugin--s2member-login-welcome-page">' . "\n";
echo '<option value="">&mdash; Select &mdash;</option>' . "\n";
foreach (($ws_plugin__s2member_temp_a = array_merge ((array)get_pages ())) as $ws_plugin__s2member_temp_o)
	echo '<option value="' . esc_attr ($ws_plugin__s2member_temp_o->ID) . '"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"] && $ws_plugin__s2member_temp_o->ID == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]) ? ' selected="selected"' : '') . '>' . esc_html ($ws_plugin__s2member_temp_o->post_title) . '</option>' . "\n";
echo '</select><br />' . "\n";
echo 'Please choose a Page to be used as the first page Members will see after logging in. This Page can contain anything you like. We recommend the following title: <code>Welcome To Our Members Area</code>.<br /><br />' . "\n";
echo '&darr; Or, you may configure a Special Redirection URL, if you prefer. You\'ll need to type in the full URL, starting with: <code>http://</code>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_login_redirection_override" id="ws-plugin--s2member-login-redirection-override" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"]) . '" /><br />' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-allow-subscribers-in">' . "\n";
echo 'Allow Free Subscribers Access To This Page?' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<select name="ws_plugin__s2member_allow_subscribers_in" id="ws-plugin--s2member-allow-subscribers-in">' . "\n";
echo '<option value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["allow_subscribers_in"]) ? ' selected="selected"' : '') . '>No ( only Members can access their Login Welcome Page )</option>' . "\n";
echo '<option value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["allow_subscribers_in"]) ? ' selected="selected"' : '') . '>Yes ( if a Free Subscriber is logged in, they can also access this Page )</option>' . "\n";
echo '</select><br />' . "\n";
echo 'If you set this to <code>Yes</code>, it means that you\'re giving Free Subscribers the ability to access this special Page that is normally intended only for Members. If you set this to <code>Yes</code>, you\'re also turning on the `Anyone Can Register` option that is built into WordPress®. So what this means, is that you\'re allowing people to signup for free, as a Free Subscriber, who will then have access to the Login Welcome Page, even though they\'re NOT a paid Member. This is only useful if you plan to let Users signup for free ( <a href="' . add_query_arg ("action", "register", wp_login_url ()) . '" target="_blank" rel="xlink">' . esc_html (add_query_arg ("action", "register", wp_login_url ())) . '</a> ). See <code>s2Member -> API Scripting -> Advanced Conditionals</code>, for details on how to customize your Login Welcome Page with Conditionals; based on Membership Level.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Membership Options Page">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-membership-options-page-section">' . "\n";
echo '<h3>Membership Options Page ( required, please customize this )</h3>' . "\n";
echo '<p>Please create and/or choose an existing Page that showcases your membership subscription options. This special Page is where you will insert the PayPal® Subscription Buttons generated for you by s2Member. This Page serves as your signup page. It should detail all of the features that come with membership to your site, and provide a PayPal® Subscription Button for each Level of access you plan to offer. This is also the page that Users will be redirected to, should they attempt to access an area of your site that requires membership.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-membership-options-page">' . "\n";
echo 'Membership Options Page:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<select name="ws_plugin__s2member_membership_options_page" id="ws-plugin--s2member-membership-options-page">' . "\n";
echo '<option value="">&mdash; Select &mdash;</option>' . "\n";
foreach (($ws_plugin__s2member_temp_a = array_merge ((array)get_pages ())) as $ws_plugin__s2member_temp_o)
	echo '<option value="' . esc_attr ($ws_plugin__s2member_temp_o->ID) . '"' . (($ws_plugin__s2member_temp_o->ID == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]) ? ' selected="selected"' : '') . '>' . esc_html ($ws_plugin__s2member_temp_o->post_title) . '</option>' . "\n";
echo '</select><br />' . "\n";
echo 'Please choose a Page that provides Users a way to signup for membership. This Page should also contain your PayPal&reg subscription button(s). We recommend the following title: <code>Membership Signup</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Membership Levels/Labels">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-membership-levels-section">' . "\n";
echo '<h3>Membership Levels ( required, please customize these )</h3>' . "\n";
echo '<p>The default Membership Levels are labeled generically; feel free to modify them as needed. s2Member supports up to 4 Primary Levels of membership, and unlimited Custom Capabilities. However, you don\'t have to use all of the Membership Levels if you don\'t want to. To use only 1 or 2 of these Levels, just create and/or modify your Membership Options Page, so that it only includes PayPal® Subscription Buttons for the Levels you wish to use.</p>' . "\n";
echo '<p><em>Support for Custom Capabilities is available. If you\'re an advanced site owner, a theme designer, or a web developer integrating s2Member for a client, please see: <code>s2Member -> API Scripting -> Custom Capabilities</code></em></p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level1-label">' . "\n";
echo 'Membership Level #1 Label:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level1_label" id="ws-plugin--s2member-level1-label" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_label"]) . '" /><br />' . "\n";
echo 'This is the Label for Membership Level 1.<br />' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level2-label">' . "\n";
echo 'Membership Level #2 Label:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level2_label" id="ws-plugin--s2member-level2-label" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"]) . '" /><br />' . "\n";
echo 'This is the Label for Membership Level 2.<br />' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level3-label">' . "\n";
echo 'Membership Level #3 Label:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level3_label" id="ws-plugin--s2member-level3-label" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_label"]) . '" /><br />' . "\n";
echo 'This is the Label for Membership Level 3.<br />' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level4-label">' . "\n";
echo 'Membership Level #4 Label:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level4_label" id="ws-plugin--s2member-level4-label" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_label"]) . '" /><br />' . "\n";
echo 'This is the Label for Membership Level 4.<br />' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Post Access Restrictions">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-post-level-access-section">' . "\n";
echo '<h3>Post Level Access Restrictions ( optional )</h3>' . "\n";
echo '<p>Here you can specify Posts that are restricted to certain Membership Access Levels.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level1-posts">' . "\n";
echo 'Posts That Require Level #1 Or Higher:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level1_posts" id="ws-plugin--s2member-level1-posts" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_posts"]) . '" /><br />' . "\n";
echo 'Post IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level2-posts">' . "\n";
echo 'Posts That Require Level #2 Or Higher:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level2_posts" id="ws-plugin--s2member-level2-posts" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_posts"]) . '" /><br />' . "\n";
echo 'Post IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level3-posts">' . "\n";
echo 'Posts That Require Level #3 Or Higher:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level3_posts" id="ws-plugin--s2member-level3-posts" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_posts"]) . '" /><br />' . "\n";
echo 'Post IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level4-posts">' . "\n";
echo 'Posts That Require Highest Level #4:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level4_posts" id="ws-plugin--s2member-level4-posts" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_posts"]) . '" /><br />' . "\n";
echo 'Post IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Page Access Restrictions">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-page-level-access-section">' . "\n";
echo '<h3>Page Level Access Restrictions ( optional )</h3>' . "\n";
echo '<p>Here you can specify Pages that are restricted to certain Membership Access Levels.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level1-pages">' . "\n";
echo 'Pages That Require Level #1 Or Higher:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level1_pages" id="ws-plugin--s2member-level1-pages" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_pages"]) . '" /><br />' . "\n";
echo 'Page IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level2-pages">' . "\n";
echo 'Pages That Require Level #2 Or Higher:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level2_pages" id="ws-plugin--s2member-level2-pages" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_pages"]) . '" /><br />' . "\n";
echo 'Page IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level3-pages">' . "\n";
echo 'Pages That Require Level #3 Or Higher:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level3_pages" id="ws-plugin--s2member-level3-pages" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_pages"]) . '" /><br />' . "\n";
echo 'Page IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level4-pages">' . "\n";
echo 'Pages That Require Highest Level #4:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level4_pages" id="ws-plugin--s2member-level4-pages" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_pages"]) . '" /><br />' . "\n";
echo 'Page IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Tag Access Restrictions">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-tag-level-access-section">' . "\n";
echo '<h3>Tag Level Access Restrictions ( optional )</h3>' . "\n";
echo '<p>Here you can specify Tags that are restricted to certain Membership Access Levels. Tag restrictions are a bit more complex. When you restrict access to a Tag, it also restricts access to any Posts that may have the Tag. In other words, restricting a Tag protects that Tag Archive, and it also protects any Posts that have the Tag; even if they have other Tags.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level1-ptags">' . "\n";
echo 'Tags That Require Level #1 Or Higher:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level1_ptags" id="ws-plugin--s2member-level1-ptags" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ptags"]) . '" /><br />' . "\n";
echo 'Tags in comma delimited format. Example: <code>premium,restricted</code> — or you can type: <code>all</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level2-ptags">' . "\n";
echo 'Tags That Require Level #2 Or Higher:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level2_ptags" id="ws-plugin--s2member-level2-ptags" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ptags"]) . '" /><br />' . "\n";
echo 'Tags in comma delimited format. Example: <code>premium,restricted</code> — or you can type: <code>all</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level3-ptags">' . "\n";
echo 'Tags That Require Level #3 Or Higher:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level3_ptags" id="ws-plugin--s2member-level3-ptags" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ptags"]) . '" /><br />' . "\n";
echo 'Tags in comma delimited format. Example: <code>premium,restricted</code> — or you can type: <code>all</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level4-ptags">' . "\n";
echo 'Tags That Require Highest Level #4:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level4_ptags" id="ws-plugin--s2member-level4-ptags" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_ptags"]) . '" /><br />' . "\n";
echo 'Tags in comma delimited format. Example: <code>premium,restricted</code> — or you can type: <code>all</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Category Access Restrictions">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-category-level-access-section">' . "\n";
echo '<h3>Category Level Access Restrictions ( optional )</h3>' . "\n";
echo '<p>Here you can specify Categories that are restricted to certain Membership Access Levels. Category restrictions are a bit more complex. When you restrict access to a Category, it also restricts access to any child Categories it may have ( aka: sub-Categories ). In other words, restricting a Category protects that Category Archive, all of its child Category Archives, and any Posts contained within the Category, or its child Categories.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level1-catgs">' . "\n";
echo 'Categories That Require Level #1 Or Higher:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level1_catgs" id="ws-plugin--s2member-level1-catgs" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_catgs"]) . '" /><br />' . "\n";
echo 'Category IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level2-catgs">' . "\n";
echo 'Categories That Require Level #2 Or Higher:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level2_catgs" id="ws-plugin--s2member-level2-catgs" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_catgs"]) . '" /><br />' . "\n";
echo 'Category IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level3-catgs">' . "\n";
echo 'Categories That Require Level #3 Or Higher:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level3_catgs" id="ws-plugin--s2member-level3-catgs" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_catgs"]) . '" /><br />' . "\n";
echo 'Category IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level4-catgs">' . "\n";
echo 'Categories That Require Highest Level #4:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level4_catgs" id="ws-plugin--s2member-level4-catgs" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_catgs"]) . '" /><br />' . "\n";
echo 'Category IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="URI Access Restrictions">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-uri-level-access-section">' . "\n";
echo '<h3>URI Level Access Restrictions ( optional )</h3>' . "\n";
echo '<p>Here you can specify URIs ( or word fragments found in URIs ) that are restricted to certain Membership Access Levels. Control over URIs is a little more complex. This section is intended for advanced webmasters only. That being said, here are the basics... A REQUEST_URI, is the portion of the URL that comes after the domain. This is a URL <code>http://www.example.com/path/to/file.php</code>, and this is the URI: <code>/path/to/file.php</code>.</p>' . "\n";
echo '<p>In the fields below, you can provide a list ( one per line ) of URIs on your site that should be off-limits based on Membership Level. You can also use word fragments instead of a full URI. If a word fragment is found anywhere in the URI, it will be protected. Wildcards and other regex patterns are not supported here, and therefore you don\'t need to escape special characters or anything. Please note, these ARE caSe sensitive. You must be specific with respect to case sensitivity. The word fragment <code>some-path/</code> would NOT match a URI that contains <code>some-Path/</code>.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level1-ruris">' . "\n";
echo 'URIs That Require Level #1 Or Higher:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<textarea name="ws_plugin__s2member_level1_ruris" id="ws-plugin--s2member-level1-ruris" rows="3" wrap="off" spellcheck="false">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ruris"]) . '</textarea><br />' . "\n";
echo 'URIs and/or word fragments found in URIs. One per line please.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level2-ruris">' . "\n";
echo 'URIs That Require Level #2 Or Higher:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<textarea name="ws_plugin__s2member_level2_ruris" id="ws-plugin--s2member-level2-ruris" rows="3" wrap="off" spellcheck="false">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ruris"]) . '</textarea><br />' . "\n";
echo 'URIs and/or word fragments found in URIs. One per line please.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level3-ruris">' . "\n";
echo 'URIs That Require Level #3 Or Higher:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<textarea name="ws_plugin__s2member_level3_ruris" id="ws-plugin--s2member-level3-ruris" rows="3" wrap="off" spellcheck="false">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ruris"]) . '</textarea><br />' . "\n";
echo 'URIs and/or word fragments found in URIs. One per line please.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level4-ruris">' . "\n";
echo 'URIs That Require Highest Level #4:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<textarea name="ws_plugin__s2member_level4_ruris" id="ws-plugin--s2member-level4-ruris" rows="3" wrap="off" spellcheck="false">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_ruris"]) . '</textarea><br />' . "\n";
echo 'URIs and/or word fragments found in URIs. One per line please.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Single-Page Access Restrictions">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-spage-access-section">' . "\n";
echo '<h3>Single-Page Access Restrictions ( optional )</h3>' . "\n";
echo '<p>s2Member now supports an additional layer of functionality ( very powerful ), which allows you to sell access to specific Pages that you\'ve created in WordPress®. Single-Page Access works independently from Member Level Access. That is, you can sell an unlimited number of Pages using "Buy Now" Buttons, and your Customers will NOT be required to have a Membership Account with your site in order to receive access. If they are already a Member, that\'s fine, but they won\'t need to be. In other words, Customers will NOT need to login, just to receive access to the Single-Page they purchased access to. s2Member will immediately redirect the Customer to the Single-Page after checkout is completed successfully. An email is also sent to the Customer with a link ( see: <code>s2Member -> PayPal® Options -> Single-Page Email</code> ). Authentication is handled automatically through IP tracking and Cookies.</p>' . "\n";
echo '<p>Single-Page Access, is sort of like selling a product. Only, instead of shipping anything to the Customer, you just give them access to a specific Page on your site; one that you created in WordPress®. A Single-Page that is protected by s2Member, might contain a download link for your eBook, access to file &amp; music downloads, access to additional support services, and the list goes on and on. The possibilities with this are endless; as long as your digital product can be delivered through access to a WordPress® Page that you\'ve created.</p>' . "\n";
echo '<p>Very simple. All you do is protect the Single-Page IDs that are being sold on your site. Then, you can go to <code>s2Member -> PayPal® Buttons -> Single-Page</code> to generate "Buy Now" Buttons that you can insert into your WordPress® Editor, and make available on your site.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-single-pages">' . "\n";
echo 'Single-Page IDs Being Sold On Your Site:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_single_pages" id="ws-plugin--s2member-single-pages" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["single_pages"]) . '" /><br />' . "\n";
echo 'Page IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> * Note... the word <code>all</code> does NOT work here. Also, please be careful not to create a conflict with other Access Restrictions. If you are going to sell Single-Page Access, you should enter specific Page IDs here; and <strong>make SURE that you\'ve NOT already protected any of these Pages</strong>. In other words, if you configure s2Member, in such as a way, that a Page requires Membership Level Access, you cannot sell that same Page through Single-Page Access. Doing so, would create a conflict. Customers that purchased Single-Page Access, would be unable to access the Page - without also having a Membership. Not good. So be careful with this.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Member Profile Modifications">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-profile-modifications-section">' . "\n";
echo '<h3>Giving Members The Ability To Modify Their Profile</h3>' . "\n";
echo '<p>s2Member can be configured to redirect Members away from the <a href="profile.php" target="_blank" rel="xlink">default Profile Editing Panel</a> that is built into WordPress®. When/if a Member attempts to access the default Profile Editing Panel, they\'ll instead, be redirected to the Login Welcome Page that you\'ve configured through s2Member. <strong>Why would I redirect?</strong> Unless you\'ve made some drastic modifications to your WordPress® installation, the default Profile Editing Panel that ships with WordPress®, is NOT really suited for public access, even by a Member.</p>' . "\n";
echo '<p>So instead of using this default Profile Editing Panel; s2Member creates an added layer of functionality, on top of WordPress®. It does this by providing you ( as the site owner ), with the ability to send your Members to a <a href="' . get_bloginfo ("url") . '/?s2member_profile=1" target="_blank" rel="xlink">special Stand-Alone page</a>, where your Members can modify their entire Profile, including all Custom Fields, and their Password. This special Stand-Alone Editing Panel, has been designed ( with a bare-bones format ), intentionally. This makes it possible for you to <a href="#" onclick="if(!window.open(\'' . get_bloginfo ("url") . '/?s2member_profile=1\', \'_popup\', \'height=350,width=400,left=100,screenX=100,top=100,screenY=100, location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1\')) alert(\'Please disable popup blockers and try again!\'); return false;" rel="xlink">open it up in a popup window</a>, or embed it into your Login Welcome Page using an IFRAME. Code samples are provided below.</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p>Stand-Alone page where Members can modify their Profile:<br />' . "\n";
echo '<code><a href="' . get_bloginfo ("url") . '/?s2member_profile=1" target="_blank" rel="xlink">' . get_bloginfo ("url") . '/?s2member_profile=1</a></code></p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>Code Sample #1</strong> ( standard link tag ):</p>' . "\n";
echo '<p>' . highlight_string (preg_replace ("/\<\?php echo S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL; \?\>/", get_bloginfo ("url") . "/?s2member_profile=1", file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-1.php")), true) . '</p>' . "\n";
/**/
echo '<p><strong>Code Sample #2</strong> ( open the link in a popup window ):</p>' . "\n";
echo '<p>' . highlight_string (preg_replace ("/\<\?php echo S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL; \?\>/", get_bloginfo ("url") . "/?s2member_profile=1", file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-2.php")), true) . '</p>' . "\n";
/**/
echo '<p><strong>Code Sample #3</strong> ( embed the form into a Post/Page using an IFRAME tag ):</p>' . "\n";
echo '<p>' . highlight_string (preg_replace ("/\<\?php echo S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL; \?\>/", get_bloginfo ("url") . "/?s2member_profile=1", file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-3.php")), true) . '</p>' . "\n";
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-force-admin-lockouts">' . "\n";
echo 'Redirect Members away from the Default Profile Panel?' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<select name="ws_plugin__s2member_force_admin_lockouts" id="ws-plugin--s2member-force-admin-lockouts">' . "\n";
echo '<option value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["force_admin_lockouts"]) ? ' selected="selected"' : '') . '>No ( I want to leave all options available to my Members )</option>' . "\n";
echo '<option value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["force_admin_lockouts"]) ? ' selected="selected"' : '') . '>Yes ( redirect Members to their Login Welcome Page )</option>' . "\n";
echo '</select><br />' . "\n";
echo 'Recommended setting ( <code>Yes</code> ). The Stand-Alone version is better.<br />' . "\n";
echo 'You\'ll want to embed the Stand-Alone version into your Login Welcome Page.<br />' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="De-Activation Safeguards">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-deactivation-section">' . "\n";
echo '<h3>De-Activation Safeguards ( optional, for safeguarding s2Member data )</h3>' . "\n";
echo '<p>By default, s2Member will cleanup ( erase ) all of it\'s Roles, Capabilities, and your Configuration Options when/if you de-activate it from the Plugins Menu in WordPress®. If you would like to Safeguard all of this information, in case s2Member is de-activated inadvertently, you can disable the De-Activation Routines for s2Member.</p>' . "\n";
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-run-deactivation-routines">' . "\n";
echo 'Run De-Activation Routines for s2Member?' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<select name="ws_plugin__s2member_run_deactivation_routines" id="ws-plugin--s2member-run-deactivation-routines">' . "\n";
echo '<option value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["run_deactivation_routines"]) ? ' selected="selected"' : '') . '>Yes ( erase all s2Member data/options on de-activation )</option>' . "\n";
echo '<option value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["run_deactivation_routines"]) ? ' selected="selected"' : '') . '>No ( safeguard all s2Member data/options )</option>' . "\n";
echo '</select><br />' . "\n";
echo 'It is recommended that you Safeguard all s2Member data/options on your system.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
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
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["support"]) ? '<div class="ws-menu-page-support"><a href="' . ws_plugin__s2member_parse_readme_value ("Forum URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-support.png" alt="." /></a></div>' . "\n" : '';
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