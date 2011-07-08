<?php
/**
* Menu page for the s2Member plugin ( General Options page ).
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
if (!class_exists ("c_ws_plugin__s2member_menu_page_gen_ops"))
	{
		/**
		* Menu page for the s2Member plugin ( General Options page ).
		*
		* @package s2Member\Menu_Pages
		* @since 110531
		*/
		class c_ws_plugin__s2member_menu_page_gen_ops
			{
				public function __construct ()
					{
						echo '<div class="wrap ws-menu-page">' . "\n";
						/**/
						echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
						echo '<h2>s2Member® General Options</h2>' . "\n";
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
						do_action ("ws_plugin__s2member_during_gen_ops_page_before_left_sections", get_defined_vars ());
						/**/
						if (apply_filters ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_display_deactivation", (!is_multisite () || !c_ws_plugin__s2member_utils_conds::is_multisite_farm () || is_main_site () || is_super_admin ()), get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_before_deactivation", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Deactivation Safeguards"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["run_deactivation_routines"]) ? ' default-state="open"' : '') . '>' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-deactivation-section">' . "\n";
								echo '<h3>Deactivation Safeguards ( optional, recommended )</h3>' . "\n";
								echo (is_multisite () && c_ws_plugin__s2member_utils_conds::is_multisite_farm () && !is_main_site () && is_super_admin ()) ? '<p><em class="ws-menu-page-hilite">On a Multisite Blog Farm, this panel is ONLY visible to YOU, as a Super Administrator. s2Member automatically Safeguards everything on a Multisite Blog Farm. However, as the Super Administrator, you may turn this off; on a per-Blog basis. For example, if you\'re going to de-activate s2Member on this particular Blog, you can turn OFF the Safeguards below, so that s2Member will completely erase itself.</em></p>' . "\n" : '<p>By default, s2Member will cleanup ( erase ) all of it\'s Roles, Capabilities, and your Configuration Options when/if you deactivate it from the Plugins Menu in WordPress®. If you would like to Safeguard all of this information, in case s2Member is deactivated inadvertently, please choose Yes ( safeguard all s2Member data/options ).</p>' . "\n";
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_during_deactivation", get_defined_vars ());
								/**/
								echo '<table class="form-table">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-run-deactivation-routines">' . "\n";
								echo 'Safeguard s2Member Data/Options?' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<select name="ws_plugin__s2member_run_deactivation_routines" id="ws-plugin--s2member-run-deactivation-routines">' . "\n";
								echo '<option value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["run_deactivation_routines"]) ? ' selected="selected"' : '') . '></option>' . "\n";
								echo '<option value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["run_deactivation_routines"]) ? ' selected="selected"' : '') . '>Yes ( safeguard all data/options )</option>' . "\n";
								echo '</select><br />' . "\n";
								echo 'Recommended setting: ( <code>Yes, safeguard all data/options</code> )' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_after_deactivation", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_display_security", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_before_security", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Security Encryption Key">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-security-section">' . "\n";
								echo '<img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/large-icon.png" title="s2Member ( a Membership management system for WordPress® )" alt="" style="float:right; margin:0 0 0 25px; border:0;" />' . "\n";
								echo '<h3>Security Encryption Key ( optional, for tighter security )</h3>' . "\n";
								echo '<p>Just like WordPress®, s2Member is open-source software. Which is wonderful. However, this also makes it possible for anyone to grab a copy of the software, and try to learn their way around its security measures. In order to keep your installation of s2Member unique/secure, you should configure a Security Encryption Key. s2Member will use your Security Encryption Key to protect itself against hackers. It does this by encrypting all sensitive information with your Key. A Security Encryption Key is unique to your installation.</p>' . "\n";
								echo '<p>Once you configure this, you do NOT want to change it; not ever. In fact, it is a VERY good idea to keep this backed up in a safe place, just in case you need to move your site, or re-install s2Member in the future. Some of the sensitive data that s2Member stores, will be encrypted with this Key. If you change it, that data can no longer be read, even by s2Member itself. In other words, don\'t use s2Member for six months, then decide to change your Key. That would break your installation. You configure this once, for each installation of s2Member; and you NEVER change it.</p>' . "\n";
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_during_security", get_defined_vars ());
								/**/
								echo '<table class="form-table">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-sec-encryption-key">' . "\n";
								echo 'Security Encryption Key ( at least 60 chars )' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"]) ? ' <a href="#" onclick="ws_plugin__s2member_enableSecurityKey(); return false;" title="( not recommended )">edit key</a>' : ' <a href="#" onclick="ws_plugin__s2member_generateSecurityKey(); return false;" title="Insert an auto-generated Key. ( recommended )">auto-generate</a>') . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_sec_encryption_key" id="ws-plugin--s2member-sec-encryption-key" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"]) . '" maxlength="256" autocomplete="off"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"]) ? ' disabled="disabled"' : '') . ' />' . "\n";
								echo (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"]) ? '<br />This may contain letters, numbers, spaces; even punctuation. Up to 256 characters.<br /><em>Ex: <code>' . esc_html (strtoupper (c_ws_plugin__s2member_utils_strings::random_str_gen (64))) . '</code></em>' . "\n" : '';
								echo (count ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key_history"]) > 1) ? '<br /><a href="#" onclick="ws_plugin__s2member_securityKeyHistory(); return false;">Click here</a> for a history of your last 10 Encryption Keys.<div id="ws-plugin--s2member-sec-encryption-key-history" style="display:none;"><code>' . implode ('</code><br /><code>', $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key_history"]) . '</code></div>' . "\n" : '';
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_after_security", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_display_s_badge_wp_footer_code", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_before_s_badge_wp_footer_code", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="s2Member® Security Badge">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-s-badge-wp-footer-code-section">' . "\n";
								echo '<h3>Security Badge &amp; Footer Configuration ( optional )</h3>' . "\n";
								echo '<div class="ws-menu-page-right">' . c_ws_plugin__s2member_utilities::s_badge_gen ("1", true, true) . '</div>' . "\n";
								echo '<p>An s2Member® Security Badge <em>( optional )</em>, can be used to express your site\'s concern for security; demonstrating to all Users/Members that your site <em>( and the s2Member software )</em>, takes security seriously. However, in order to qualify your site, you MUST generate a Security Encryption Key <em>( previous section )</em>, and then click "Save All Changes". Only then, will s2Member officially verify your installation <em>( verification occurs automatically )</em>. Once you\'ve properly configured all aspects of s2Member, your s2Member® Security Badge will be verified. *Note: to see the "verified" version of your Security Badge, you might need to refresh your browser after saving all changes <em>( i.e. after you create a Security Encryption Key )</em>. Also, s2Member will NOT "verify" your site if you turn off Unique IP Restrictions, Brute Force Login Protection, or if your <code>/wp-config.php</code> file lacks <a href="http://codex.wordpress.org/Editing_wp-config.php#Security_Keys" target="_blank" rel="external">Security Keys</a> <em>( at least 60 chars in length, each )</em>.</p>' . "\n";
								echo '<p><strong>How does s2Member know when my site is secure?</strong><br />If enabled below, an API call for "Security Badge Status", will allow web service connections to determine your status. Clicking <a href="' . esc_attr (site_url ("/?s2member_s_badge_status=1")) . '" target="_blank" rel="external">this link</a> will report <code>1</code> <em>( secure )</em>, <code>0</code> <em>( at risk )</em>, or <code>-</code> <em>( API disabled )</em>. Once all security considerations are satisfied, s2Member will report <code>1</code> <em>( secure )</em> for your installation. *Note, this simple API will NOT, and should not, report any other information. It will ONLY report the current status of your Security Badge, as determined by your installation of s2Member. When/if you install the s2Member Security Badge, s2Member will make a connection to your site "once per day", to test the status of your Security Badge.</p>' . "\n";
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_during_s_badge_wp_footer_code", get_defined_vars ());
								/**/
								echo '<table class="form-table">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-s-badge-status-enabled">' . "\n";
								echo 'Enable Security Badge Status API?' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<select name="ws_plugin__s2member_s_badge_status_enabled" id="ws-plugin--s2member-s-badge-status-enabled">' . "\n";
								echo '<option value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["s_badge_status_enabled"]) ? ' selected="selected"' : '') . '>No ( default, Badge Status API is disabled )</option>' . "\n";
								echo '<option value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["s_badge_status_enabled"]) ? ' selected="selected"' : '') . '>Yes ( enable Badge Status API for verification )</option>' . "\n";
								echo '</select><br />' . "\n";
								echo 'This must be enabled if you want s2Member to verify your Security Badge.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-wp-footer-code">' . "\n";
								echo 'Customize WordPress® Footer:<br />' . "\n";
								echo '<small>[ <a href="#" onclick="this.$code = jQuery(\'textarea#ws-plugin--s2member-wp-footer-code\'); this.$code.val(jQuery.trim(unescape(\'' . rawurlencode ('[s2Member-Security-Badge v="1" /]') . '\')+\'\n\'+this.$code.val())); return false;">Click HERE to insert your Security Badge</a> ],<br />or use Shortcode <code>[s2Member-Security-Badge v="1" /]</code> in a Post/Page/Widget.</small>' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<textarea name="ws_plugin__s2member_wp_footer_code" id="ws-plugin--s2member-wp-footer-code" rows="8" wrap="off" spellcheck="false" style="font-family:Consolas, monospace;">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["wp_footer_code"]) . '</textarea><br />' . "\n";
								echo 'Any valid XHTML / JavaScript' . ((is_multisite () && c_ws_plugin__s2member_utils_conds::is_multisite_farm () && !is_main_site ()) ? '' : ' ( or even PHP )') . ' code will work just fine here.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_after_s_badge_wp_footer_code", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_display_email_config", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_before_email_config", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Email Configuration">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-email-section">' . "\n";
								/**/
								echo '<h3 style="margin:0;">Email From: ' . esc_html ('"Name" <address>') . '</h3>' . "\n";
								echo '<p style="margin:0;">This is the name/address that will appear in outgoing email notifications sent by the s2Member plugin.</p>' . "\n";
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_during_email_from_name_config", get_defined_vars ());
								/**/
								echo '<table class="form-table">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-reg-email-from-name">' . "\n";
								echo 'Email From Name:' . "\n";
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
								echo 'Email From Address:' . "\n";
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
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["pluggables"]["wp_new_user_notification"])
									{
										echo '<div class="ws-menu-page-hr"></div>' . "\n";
										/**/
										echo '<h3 style="margin:0;">New User Email Message</h3>' . "\n";
										echo '<p style="margin:0;">This email is sent to all new Users/Members. It should always contain their Username/Password. In addition to this email, s2Member will also send new paying Customers a Signup Confirmation Email, which you can customize from your Dashboard, under: <code>s2Member -> PayPal® Options</code>. You may wish to customize these emails further, by providing details that are specifically geared to your site.</p>' . "\n";
										do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_during_email_new_user_config", get_defined_vars ());
										/**/
										echo '<table class="form-table">' . "\n";
										echo '<tbody>' . "\n";
										echo '<tr>' . "\n";
										/**/
										echo '<th>' . "\n";
										echo '<label for="ws-plugin--s2member-new-user-email-subject">' . "\n";
										echo 'New User Email Subject:' . "\n";
										echo '</label>' . "\n";
										echo '</th>' . "\n";
										/**/
										echo '</tr>' . "\n";
										echo '<tr>' . "\n";
										/**/
										echo '<td>' . "\n";
										echo '<input type="text" name="ws_plugin__s2member_new_user_email_subject" id="ws-plugin--s2member-new-user-email-subject" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["new_user_email_subject"]) . '" /><br />' . "\n";
										echo 'Subject Line used in the email sent to new Users/Members.' . "\n";
										echo '</td>' . "\n";
										/**/
										echo '</tr>' . "\n";
										echo '<tr>' . "\n";
										/**/
										echo '<th>' . "\n";
										echo '<label for="ws-plugin--s2member-new-user-email-message">' . "\n";
										echo 'New User Email Message:' . "\n";
										echo '</label>' . "\n";
										echo '</th>' . "\n";
										/**/
										echo '</tr>' . "\n";
										echo '<tr>' . "\n";
										/**/
										echo '<td>' . "\n";
										echo '<textarea name="ws_plugin__s2member_new_user_email_message" id="ws-plugin--s2member-new-user-email-message" rows="10">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["new_user_email_message"]) . '</textarea><br />' . "\n";
										echo 'Message Body used in the email sent to new Users/Members.<br /><br />' . "\n";
										echo '<strong>You can also use these special Replacement Codes if you need them:</strong>' . "\n";
										echo '<ul>' . "\n";
										echo '<li><code>%%user_first_name%%</code> = The First Name of the Member who registered their Username.</li>' . "\n";
										echo '<li><code>%%user_last_name%%</code> = The Last Name of the Member who registered their Username.</li>' . "\n";
										echo '<li><code>%%user_full_name%%</code> = The Full Name ( First &amp; Last ) of the Member who registered their Username.</li>' . "\n";
										echo '<li><code>%%user_email%%</code> = The Email Address of the Member who registered their Username.</li>' . "\n";
										echo '<li><code>%%user_login%%</code> = The Username the Member selected during registration.</li>' . "\n";
										echo '<li><code>%%user_pass%%</code> = The Password selected or generated during registration.</li>' . "\n";
										echo '<li><code>%%user_ip%%</code> = The User\'s IP Address, detected via <code>$_SERVER["REMOTE_ADDR"]</code>.</li>' . "\n";
										echo '<li><code>%%user_id%%</code> = A unique WordPress® User ID generated during registration.</li>' . "\n";
										echo '<li><code>%%wp_login_url%%</code> = The full URL where Users can get logged into your site.</li>' . "\n";
										echo '</ul>' . "\n";
										/**/
										echo '<strong>Custom Registration Fields are also supported in this email:</strong>' . "\n";
										echo '<ul>' . "\n";
										echo '<li><code>%%date_of_birth%%</code> would be valid; if you have a Custom Registration Field with the ID <code>date_of_birth</code>.</li>' . "\n";
										echo '<li><code>%%street_address%%</code> would be valid; if you have a Custom Registration Field with the ID <code>street_address</code>.</li>' . "\n";
										echo '<li><code>%%country%%</code> would be valid; if you have a Custom Registration Field with the ID <code>country</code>.</li>' . "\n";
										echo '<li><em><code>%%etc, etc...%%</code> <strong>see:</strong> s2Member -> General Options -> Custom Registration Fields</em>.</li>' . "\n";
										echo '</ul>' . "\n";
										/**/
										echo '<strong>Custom Replacement Codes can also be inserted using these instructions:</strong>' . "\n";
										echo '<ul>' . "\n";
										echo '<li><code>%%cv0%%</code> = The domain of your site, which is passed through the `custom` attribute in your Shortcode.</li>' . "\n";
										echo '<li><code>%%cv1%%</code> = If you need to track additional custom variables, you can pipe delimit them into the `custom` attribute; inside your Shortcode, like this: <code>custom="' . esc_html ($_SERVER["HTTP_HOST"]) . '|cv1|cv2|cv3"</code>. You can have an unlimited number of custom variables. Obviously, this is for advanced webmasters; but the functionality has been made available for those who need it.</li>' . "\n";
										echo '</ul>' . "\n";
										echo '<strong>This example uses cv1 to record a special marketing campaign:</strong><br />' . "\n";
										echo '<em>( The campaign ( i.e. christmas-promo ) could be referenced using <code>%%cv1%%</code> )</em><br />' . "\n";
										echo '<code>custom="' . esc_html ($_SERVER["HTTP_HOST"]) . '|christmas-promo"</code>' . "\n";
										/**/
										echo '</td>' . "\n";
										/**/
										echo '</tr>' . "\n";
										echo '</tbody>' . "\n";
										echo '</table>' . "\n";
									}
								/**/
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_after_email_config", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_display_open_registration", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_before_open_registration", get_defined_vars ());
								/**/
								if (is_multisite () && is_main_site ()) /* A Multisite Network, and we're on the Main Site? */
									{
										echo '<div class="ws-menu-page-group" title="Open Registration">' . "\n";
										/**/
										echo '<div class="ws-menu-page-section ws-plugin--s2member-open-registration-section">' . "\n";
										echo '<h3>Open Registration / Free Subscribers ( optional )</h3>' . "\n";
										echo '<p>On the Main Site of a Multisite Network, the settings for Open Registration are consolidated into the <code>s2Member -> Multisite (Config)</code> panel.</p>' . "\n";
										do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_during_open_registration", get_defined_vars ());
										echo '</div>' . "\n";
										/**/
										echo '</div>' . "\n";
									}
								else /* Else we display this section normally. No special considerations are required in this case. */
									{
										echo '<div class="ws-menu-page-group" title="Open Registration">' . "\n";
										/**/
										echo '<div class="ws-menu-page-section ws-plugin--s2member-open-registration-section">' . "\n";
										echo '<h3>Open Registration / Free Subscribers ( optional )</h3>' . "\n";
										echo '<p>s2Member supports Free Subscribers ( at Level #0 ), along with four Primary Levels [1-4] of paid Membership. If you want your visitors to be capable of registering absolutely free, you will want to "allow" Open Registration. Whenever a visitor registers without paying, they\'ll automatically become a Free Subscriber, at Level #0.</p>' . "\n";
										do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_during_open_registration", get_defined_vars ());
										/**/
										echo '<table class="form-table">' . "\n";
										echo '<tbody>' . "\n";
										echo '<tr>' . "\n";
										/**/
										echo '<th>' . "\n";
										echo '<label for="ws-plugin--s2member-allow-subscribers-in">' . "\n";
										echo 'Allow Open Registration? ( Free Subscribers )' . "\n";
										echo '</label>' . "\n";
										echo '</th>' . "\n";
										/**/
										echo '</tr>' . "\n";
										echo '<tr>' . "\n";
										/**/
										echo '<td>' . "\n";
										echo '<select name="ws_plugin__s2member_allow_subscribers_in" id="ws-plugin--s2member-allow-subscribers-in">' . "\n";
										echo '<option value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["allow_subscribers_in"]) ? ' selected="selected"' : '') . '>No ( do NOT allow Open Registration )</option>' . "\n";
										echo '<option value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["allow_subscribers_in"]) ? ' selected="selected"' : '') . '>Yes ( allow Open Registration; Free Subscribers at Level #0 )</option>' . "\n";
										echo '</select><br />' . "\n";
										echo 'If you set this to <code>Yes</code>, you\'re unlocking <a href="' . esc_attr (c_ws_plugin__s2member_utils_urls::wp_register_url ()) . '" target="_blank" rel="external">wp-login.php?action=register</a>. When a visitor registers without paying, they\'ll automatically become a Free Subscriber, at Level #0. The s2Member software reserves Level #0; to be used ONLY for Free Subscribers. All other Membership Levels [1-4] require payment.' . "\n";
										echo '</td>' . "\n";
										/**/
										echo '</tr>' . "\n";
										echo '</tbody>' . "\n";
										echo '</table>' . "\n";
										echo '</div>' . "\n";
										/**/
										echo '</div>' . "\n";
									}
								/**/
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_after_open_registration", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_display_membership_levels", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_before_membership_levels", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Membership Levels/Labels">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-membership-levels-section">' . "\n";
								echo '<h3>Membership Levels ( required, please customize these )</h3>' . "\n";
								echo '<p>The default Membership Levels are labeled generically; feel free to modify them as needed. s2Member supports Free Subscribers <em>( at Level #0 )</em>, along with several Primary Roles for paid Membership <em>( i.e. Levels 1-4 )</em>, created by the s2Member plugin.' . ((!is_multisite () || !c_ws_plugin__s2member_utils_conds::is_multisite_farm () || is_main_site ()) ? ' s2Member also supports unlimited Custom Capability Packages <em>( see <code>s2Member -> API Scripting -> Custom Capabilities</code> )</em>' : '') . '. That being said, you don\'t have to use all of the Membership Levels if you don\'t want to. To use only 1 or 2 of these Levels, just create and/or modify your Membership Options Page, so that it only includes payment Buttons for the Levels you wish to use.</p>' . "\n";
								echo (!is_multisite () || !c_ws_plugin__s2member_utils_conds::is_multisite_farm () || is_main_site ()) ? '<p><em><strong>TIP:</strong> <strong>Unlimited Membership Levels</strong> are only possible with <a href="' . esc_attr (c_ws_plugin__s2member_readmes::parse_readme_value ("Pro Module / Prices")) . '" target="_blank" rel="external">s2Member Pro</a>. However, Custom Capabilities are possible in all versions of s2Member, including the free version. Custom Capabilities are a great way to extend s2Member in creative ways. If you\'re an advanced site owner, a theme designer, or a web developer integrating s2Member for a client, please check your Dashboard, under: <code>s2Member -> API Scripting -> Custom Capabilities</code>. We also recommend the <a href="http://www.primothemes.com/forums/viewforum.php?f=40" target="_blank" rel="external">s2Member Codex</a>.</em></p>' . "\n" : '';
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_during_membership_levels", get_defined_vars ());
								/**/
								echo '<table class="form-table">' . "\n";
								echo '<tbody>' . "\n";
								/**/
								for ($n = 0; $n <= $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n++)
									{
										echo '<tr>' . "\n";
										/**/
										echo '<th>' . "\n";
										echo '<label for="ws-plugin--s2member-level' . $n . '-label">' . "\n";
										echo ($n === 0) ? 'Level #' . $n . ' <em>( Free Subscribers )</em>:' . "\n" : 'Level #' . $n . ' Members:' . "\n";
										echo '</label>' . "\n";
										echo '</th>' . "\n";
										/**/
										echo '</tr>' . "\n";
										echo '<tr>' . "\n";
										/**/
										echo '<td>' . "\n";
										echo '<input type="text" name="ws_plugin__s2member_level' . $n . '_label" id="ws-plugin--s2member-level' . $n . '-label" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_label"]) . '" /><br />' . "\n";
										echo 'This is the Label for Level #' . $n . (($n === 0) ? ' ( Free Subscribers )' : ' Members') . '.<br />' . "\n";
										echo '</td>' . "\n";
										/**/
										echo '</tr>' . "\n";
									}
								/**/
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								/**/
								echo '<div class="ws-menu-page-hr"></div>' . "\n";
								/**/
								echo '<table class="form-table" style="margin-top:0;">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th style="padding-top:0;">' . "\n";
								echo '<label for="ws-plugin--s2member-apply-label-translations">' . "\n";
								echo 'Force WordPress® to use your Labels?' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="radio" name="ws_plugin__s2member_apply_label_translations" id="ws-plugin--s2member-apply-label-translations-0" value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["apply_label_translations"]) ? ' checked="checked"' : '') . ' /> <label for="ws-plugin--s2member-apply-label-translations-0">No</label> &nbsp;&nbsp;&nbsp; <input type="radio" name="ws_plugin__s2member_apply_label_translations" id="ws-plugin--s2member-apply-label-translations-1" value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["apply_label_translations"]) ? ' checked="checked"' : '') . ' /> <label for="ws-plugin--s2member-apply-label-translations-1">Yes, force WordPress® to use my Labels.</label><br />' . "\n";
								echo 'This particular option affects your administrative Dashboard only <em>( i.e. your list of Users )</em>. s2Member can force WordPress® to use your Labels instead of referencing Roles by `s2Member Level #`. If this is your first installation of s2Member, we suggest leaving this set to <code>no</code> until you\'ve had a chance to get acclimated with s2Member\'s functionality. In fact, many site owners choose to leave this off, because they find it less confusing when Roles are referred to by their s2Member Level #.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_after_membership_levels", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_display_login_registration", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_before_login_registration", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Login/Registration Design">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-login-registration-section">' . "\n";
								echo '<h3>Login/Registration Page Customization ( required )</h3>' . "\n";
								echo '<p>These settings allow you to customize the user interface for your Login / Registration Pages:<br />( <a href="' . esc_attr (c_ws_plugin__s2member_utils_urls::wp_register_url ()) . '" target="_blank" rel="external">' . esc_html (c_ws_plugin__s2member_utils_urls::wp_register_url ()) . '</a> )</p>' . "\n";
								echo (is_multisite () && c_ws_plugin__s2member_utils_conds::is_multisite_farm () && is_main_site ()) ? '<p><em>A Multisite Blog Farm uses this Form instead, powered by your theme.<br />( <a href="' . esc_attr (c_ws_plugin__s2member_utils_urls::wp_signup_url ()) . '" target="_blank" rel="external">' . esc_html (c_ws_plugin__s2member_utils_urls::wp_signup_url ()) . '</a> )</em></p>' . "\n" : '';
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_during_login_registration", get_defined_vars ());
								/**/
								echo '<table class="form-table">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<h3 style="margin:0;">Overall Font/Size Configuration</h3>' . "\n";
								echo '<p style="margin:0;">These settings are all focused on your Login/Registration Fonts.</p>' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-login-reg-font-size">' . "\n";
								echo 'Overall Font Size:' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_login_reg_font_size" id="ws-plugin--s2member-login-reg-font-size" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_font_size"]) . '" /><br />' . "\n";
								echo 'Set this to a numeric value, calculated in pixels.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-login-reg-font-family">' . "\n";
								echo 'Overall Font Family:' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_login_reg_font_family" id="ws-plugin--s2member-login-reg-font-family" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_font_family"]) . '" /><br />' . "\n";
								echo 'Set this to a web-safe font family.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-login-reg-font-field-size">' . "\n";
								echo 'Form Field Font Size:' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_login_reg_font_field_size" id="ws-plugin--s2member-login-reg-font-field-size" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_font_field_size"]) . '" /><br />' . "\n";
								echo 'Set this to a numeric value, calculated in pixels.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								/**/
								echo '<div class="ws-menu-page-hr"></div>' . "\n";
								/**/
								echo '<table class="form-table" style="margin-top:0;">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<h3 style="margin:0;">Background Configuration</h3>' . "\n";
								echo '<p style="margin:0;">These settings are all focused on your Login/Registration Background.</p>' . "\n";
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
								echo 'Background Image:' . "\n";
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
								echo '<label for="ws-plugin--s2member-login-reg-background-image-repeat">' . "\n";
								echo 'Background Image Tile:' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<select name="ws_plugin__s2member_login_reg_background_image_repeat" id="ws-plugin--s2member-login-reg-background-image-repeat">' . "\n";
								echo '<option value="repeat"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image_repeat"] === "repeat") ? ' selected="selected"' : '') . '>Seamless Tile ( background-repeat: repeat; )</option>' . "\n";
								echo '<option value="repeat-x"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image_repeat"] === "repeat-x") ? ' selected="selected"' : '') . '>Tile Horizontally ( background-repeat: repeat-x; )</option>' . "\n";
								echo '<option value="repeat-y"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image_repeat"] === "repeat-y") ? ' selected="selected"' : '') . '>Tile Vertically ( background-repeat: repeat-y; )</option>' . "\n";
								echo '<option value="no-repeat"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image_repeat"] === "no-repeat") ? ' selected="selected"' : '') . '>No Tiles ( background-repeat: no-repeat; )</option>' . "\n";
								echo '</select><br />' . "\n";
								echo 'This controls the way your Background Image is styled with CSS. [ <a href="http://www.w3schools.com/css/pr_background-repeat.asp" target="_blank" rel="external">learn more</a> ]' . "\n";
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
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								/**/
								echo '<div class="ws-menu-page-hr"></div>' . "\n";
								/**/
								echo '<table class="form-table" style="margin-top:0;">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<h3 style="margin:0;">Logo Image Configuration</h3>' . "\n";
								echo '<p style="margin:0;">These settings are all focused on your Login/Registration Logo.</p>' . "\n";
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
								/**/
								echo '<div class="ws-menu-page-hr"></div>' . "\n";
								/**/
								echo '<table class="form-table" style="margin-top:0;">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<h3 style="margin:0;">Footer Design ( i.e. Bottom )</h3>' . "\n";
								echo '<p style="margin:0;">This field accepts raw HTML' . ((!is_multisite () || !c_ws_plugin__s2member_utils_conds::is_multisite_farm () || is_main_site ()) ? ' ( and/or PHP )' : '') . ' code.</p>' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-login-reg-footer-design">' . "\n";
								echo 'Login/Registration Footer Design ( optional ):' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<textarea name="ws_plugin__s2member_login_reg_footer_design" id="ws-plugin--s2member-login-reg-footer-design" rows="3" wrap="off" spellcheck="false">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_footer_design"]) . '</textarea><br />' . "\n";
								echo 'This optional HTML' . ((!is_multisite () || !c_ws_plugin__s2member_utils_conds::is_multisite_farm () || is_main_site ()) ? ' ( and/or PHP )' : '') . ' code will appear at the very bottom of your Login/Registration Forms.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_after_login_registration", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_display_custom_reg_fields", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_before_custom_reg_fields", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Custom Registration Fields/Options">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-custom-reg-fields-section">' . "\n";
								echo '<h3>Custom Registration Fields ( optional, for further customization )</h3>' . "\n";
								echo '<p>Some fields are already built-in by default. The defaults are: <code>*Username*, *Email*, *First Name*, *Last Name*</code>.</p>' . "\n";
								/**/
								echo '<p>Custom Fields will appear in your Standard Registration Form:<br />( <a href="' . esc_attr (c_ws_plugin__s2member_utils_urls::wp_register_url ()) . '" target="_blank" rel="external">' . esc_html (c_ws_plugin__s2member_utils_urls::wp_register_url ()) . '</a> )</p>' . "\n";
								echo (is_multisite () && c_ws_plugin__s2member_utils_conds::is_multisite_farm () && is_main_site ()) ? '<p><em>A Multisite Blog Farm uses this Form instead. It supports Custom Fields too.<br />( <a href="' . esc_attr (c_ws_plugin__s2member_utils_urls::wp_signup_url ()) . '" target="_blank" rel="external">' . esc_html (c_ws_plugin__s2member_utils_urls::wp_signup_url ()) . '</a> )</em></p>' . "\n" : '';
								/**/
								if (is_multisite () && c_ws_plugin__s2member_utils_conds::is_multisite_farm () && is_main_site () && !defined ("WS_PLUGIN__S2MEMBER_PRO_VERSION"))
									echo '<p><em>* For security purposes, Custom Passwords are NOT possible on the Main Site of a Blog Farm. A User MUST wait for the activation/confirmation email; where a randomly generated Password will be assigned. Please note... this limitation only affects your Main Site, via <code>/wp-signup.php</code>. In other words, your Customers ( i.e. other Blog Owners ) will still have the ability to allow Custom Passwords with s2Member. YOU are affected by this limitation, NOT them. * NOTE: s2Member (Pro) removes this limitation. If you install the s2Member Pro Module, you WILL be able to allow Custom Passwords through s2Member Pro Forms; even on a Multisite Blog Farm.</em></p>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_during_custom_reg_fields", get_defined_vars ());
								/**/
								echo '<table class="form-table">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label>' . "\n";
								echo 'Custom Registration Fields:' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="hidden" name="ws_plugin__s2member_custom_reg_fields" id="ws-plugin--s2member-custom-reg-fields" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) . '" />' . "\n";
								echo '<div id="ws-plugin--s2member-custom-reg-field-configuration"></div>' . "\n"; /* This is filled by JavaScript routines. */
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-custom-reg-names">' . "\n";
								echo 'Collect First/Last Names during Registration?' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<select name="ws_plugin__s2member_custom_reg_names" id="ws-plugin--s2member-custom-reg-names">' . "\n";
								echo '<option value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"]) ? ' selected="selected"' : '') . '>Yes ( always collect First/Last Names during registration )</option>' . "\n";
								echo '<option value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_names"]) ? ' selected="selected"' : '') . '>No ( do NOT collect First/Last Names during registration )</option>' . "\n";
								echo '</select><br />' . "\n";
								echo 'Recommended setting ( <code>Yes</code> ). It\'s usually a good idea to leave this on.' . "\n";
								echo (defined ("WS_PLUGIN__S2MEMBER_PRO_VERSION")) ? '<br /><em>* s2Member Pro (Checkout) Forms always require a First/Last Name.</em>' . "\n" : '';
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-custom-reg-display-name">' . "\n";
								echo 'Set "Display Name" during Registration?' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<select name="ws_plugin__s2member_custom_reg_display_name" id="ws-plugin--s2member-custom-reg-display-name">' . "\n";
								echo '<option value="full"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_display_name"] === "full") ? ' selected="selected"' : '') . '>Yes ( set Display Name to User\'s Full Name )</option>' . "\n";
								echo '<option value="first"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_display_name"] === "first") ? ' selected="selected"' : '') . '>Yes ( set Display Name to User\'s First Name )</option>' . "\n";
								echo '<option value="last"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_display_name"] === "last") ? ' selected="selected"' : '') . '>Yes ( set Display Name to User\'s Last Name )</option>' . "\n";
								echo '<option value="login"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_display_name"] === "login") ? ' selected="selected"' : '') . '>Yes ( set Display Name to User\'s Username )</option>' . "\n";
								echo '<option value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_display_name"]) ? ' selected="selected"' : '') . '>No ( leave Display Name at default WordPress® value )</option>' . "\n";
								echo '</select>' . "\n";
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
								echo '<select name="ws_plugin__s2member_custom_reg_password" id="ws-plugin--s2member-custom-reg-password"' . ((is_multisite () && c_ws_plugin__s2member_utils_conds::is_multisite_farm () && is_main_site () && !defined ("WS_PLUGIN__S2MEMBER_PRO_VERSION")) ? ' disabled="disabled"' : '') . '>' . "\n";
								echo '<option value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"]) ? ' selected="selected"' : '') . '>No ( send auto-generated passwords via email; after registration )</option>' . "\n";
								echo '<option value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"]) ? ' selected="selected"' : '') . '>Yes ( allow members to create their own password during registration )</option>' . "\n";
								echo '</select><br />' . "\n";
								echo 'Auto-generated Passwords are recommended for best security; because, this also serves as a form of email confirmation.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-custom-reg-force-personal-emails">' . "\n";
								echo 'Force Personal Emails during Registration?' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_custom_reg_force_personal_emails" id="ws-plugin--s2member-custom-reg-force-personal-emails" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_force_personal_emails"]) . '" /><br />' . "\n";
								echo 'To force personal email addresses, provide a comma-delimited list of email users to reject. <a href="#" onclick="alert(\'s2Member will reject [user]@ ( based on your configuration here ). A JavaScript alert message will be issued, asking the User to, `please use a personal email address`.\'); return false;" tabindex="-1">[?]</a><br />' . "\n";
								echo 'Ex: <code>info,help,admin,webmaster,hostmaster,sales,support,spam</code><br />' . "\n";
								echo 'See: <a href="http://kb.mailchimp.com/article/what-role-addresses-does-mailchimp-specifically-block-from-bulk-importing/" target="_blank" rel="external">this article</a> for a more complete list.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-custom-reg-fields-4bp">' . "\n";
								echo 'Integrate Custom Registration Fields with BuddyPress too?' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<div class="ws-menu-page-scrollbox" style="height:65px;">' . "\n";
								echo '<input type="hidden" name="ws_plugin__s2member_custom_reg_fields_4bp[]" value="update-signal"' . ((!defined ("BP_VERSION")) ? ' disabled="disabled"' : '') . ' />' . "\n";
								foreach (array ("profile-view" => "Yes, integrate with BuddyPress Public Profiles.", "registration" => "Yes, integrate with BuddyPress Registration Form.", "profile" => "Yes, integrate with BuddyPress Profile Editing Panel.") as $ws_plugin__s2member_temp_s_value => $ws_plugin__s2member_temp_s_label)
									echo '<input type="checkbox" name="ws_plugin__s2member_custom_reg_fields_4bp[]" id="ws-plugin--s2member-custom-reg-fields-4bp-' . esc_attr (preg_replace ("/[^a-z0-9_\-]/", "-", $ws_plugin__s2member_temp_s_value)) . '" value="' . esc_attr ($ws_plugin__s2member_temp_s_value) . '"' . ((in_array ($ws_plugin__s2member_temp_s_value, $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields_4bp"])) ? ' checked="checked"' : '') . ((!defined ("BP_VERSION")) ? ' disabled="disabled"' : '') . ' /> <label for="ws-plugin--s2member-custom-reg-fields-4bp-' . esc_attr (preg_replace ("/[^a-z0-9_\-]/", "-", $ws_plugin__s2member_temp_s_value)) . '">' . $ws_plugin__s2member_temp_s_label . '</label><br />' . "\n";
								echo '</div>' . "\n";
								echo (!defined ("BP_VERSION")) ? 'BuddyPress is NOT installed; which is perfectly OK. BuddyPress is NOT a requirement.<br />' . "\n" : '';
								echo 'Also, see below: <code>Member Profile Modifications</code>.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_after_custom_reg_fields", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_display_login_welcome_page", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_before_login_welcome_page", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Login Welcome Page">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-login-welcome-page-section">' . "\n";
								echo '<h3>Login Welcome Page ( required, please customize this )</h3>' . "\n";
								echo '<p>Please create and/or choose an existing Page to use as the first page Members will see after logging in.</p>' . "\n";
								echo '<p><em><strong>*Tip*</strong> This special Page will be protected from public access ( automatically ) by s2Member.</em></p>' . "\n";
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_during_login_welcome_page", get_defined_vars ());
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
								echo '&darr; Or, you may configure a Special Redirection URL, if you prefer. You\'ll need to type in the full URL, starting with: <code>http://</code>. <em>A few <a href="#" onclick="alert(\'Replacement Codes:\\n\\n%%current_user_login%% = The current User\\\'s login ( their Username, lowercase ).\\n%%current_user_id%% = The current User\\\'s ID.\\n%%current_user_level%% = The current User\\\'s s2Member Level.\\n%%current_user_role%% = The current User\\\'s WordPress® Role.' . ((!is_multisite () || !c_ws_plugin__s2member_utils_conds::is_multisite_farm () || is_main_site ()) ? '\\n%%current_user_ccaps%% = The current User\\\'s Custom Capabilities.' : '') . '\\n\\nFor example, if you\\\'re using BuddyPress, and you want to redirect Members to their BuddyPress Profile page after logging in, you would setup a Special Redirection URL, like this: ' . site_url ("/members/%%current_user_login%%/profile/") . '\\n\\nOr ... using %%current_user_level%%, you could have a separate Login Welcome Page for each Membership Level that you plan to offer. BuddyPress not required.\'); return false;">Replacement Codes</a> are also supported here.</em>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_login_redirection_override" id="ws-plugin--s2member-login-redirection-override" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"]) . '" /><br />' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_after_login_welcome_page", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_display_membership_options_page", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_before_membership_options_page", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Membership Options Page">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-membership-options-page-section">' . "\n";
								echo '<h3>Membership Options Page ( required, please customize this )</h3>' . "\n";
								echo '<p>Please create and/or choose an existing Page that showcases your Membership subscription options. This special Page is where you will insert the PayPal® Subscription Buttons generated for you by s2Member. This Page serves as your signup page. It should detail all of the features that come with Membership to your site, and provide a PayPal® Subscription Button for each Level of access you plan to offer. This is also the page that Users will be redirected to, should they attempt to access an area of your site that requires Membership.</p>' . "\n";
								echo '<p><em><strong>*Tip*</strong> s2Member will NEVER allow this Page to be protected from public access.</em></p>' . "\n";
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_during_membership_options_page", get_defined_vars ());
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
								echo 'Please choose a Page that provides Users a way to signup for Membership. This Page should also contain your PayPal&reg Subscription button(s). We recommend the following title: <code>Membership Signup</code>.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_after_membership_options_page", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_display_profile_modifications", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_before_profile_modifications", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Member Profile Modifications">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-profile-modifications-section">' . "\n";
								echo '<h3>Giving Members The Ability To Modify Their Profile</h3>' . "\n";
								echo '<p>s2Member can be configured to redirect Members away from the <a href="' . esc_attr (admin_url ("/profile.php")) . '" target="_blank" rel="external">default Profile Editing Panel</a> that is built into WordPress®. When/if a Member attempts to access the default Profile Editing Panel, they\'ll instead, be redirected to the Login Welcome Page that you\'ve configured through s2Member. <strong>Why would I redirect?</strong> Unless you\'ve made some drastic modifications to your WordPress® installation, the default Profile Editing Panel that ships with WordPress®, is NOT really suited for public access, even by a Member.</p>' . "\n";
								echo '<p>So instead of using this default Profile Editing Panel; s2Member creates an added layer of functionality, on top of WordPress®. It does this by providing you ( as the site owner ), with a special Shortcode: <code>[s2Member-Profile /]</code> that you can place into your Login Welcome Page, or any Post/Page for that matter ( even into a Text Widget ). This Shortcode produces an Inline Profile Editing Form that supports all aspects of s2Member, including Password changes; and any Custom Registration/Profile Fields that you\'ve configured with s2Member.</p>' . "\n";
								echo '<p>Alternatively, s2Member also gives you the ability to send your Members to a <a href="' . esc_attr (site_url ("/?s2member_profile=1")) . '" target="_blank" rel="external">special Stand-Alone version</a>. This Stand-Alone version has been designed ( with a bare-bones format ), intentionally. This makes it possible for you to <a href="#" onclick="if(!window.open(\'' . site_url ("/?s2member_profile=1") . '\', \'_popup\', \'width=600,height=400,left=100,screenX=100,top=100,screenY=100,location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1\')) alert(\'Please disable popup blockers and try again!\'); return false;" rel="external">open it up in a popup window</a>, or embed it into your Login Welcome Page using an IFRAME. Code samples are provided below.</p>' . "\n";
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_during_profile_modifications", get_defined_vars ());
								/**/
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
								echo '<option value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["force_admin_lockouts"]) ? ' selected="selected"' : '') . '>No ( I want to use the WordPress® default methodologies )</option>' . "\n";
								echo '<option value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["force_admin_lockouts"]) ? ' selected="selected"' : '') . '>Yes ( redirect to Login Welcome Page; locking all /wp-admin/ areas )</option>' . "\n";
								echo '</select><br />' . "\n";
								echo 'Recommended setting ( <code>Yes</code> ). <em><strong>*Note*</strong> When this is set to ( <code>Yes</code> ), s2Member will take an initiative to further safeguard ALL <code>/wp-admin/</code> areas of your installation; not just the Default Profile Panel. Also, starting with WordPress® 3.1+, setting this to ( <code>Yes</code> ) tells s2Member to dynamically modify links/titles in the new Admin Bar that can be enabled on WordPress® 3.1+. s2Member will force links to your Login Welcome Page instead of the Default Profile Panel; and Dashboard links are removed for non-Admin accounts ( as they should be ).</em>' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								/**/
								echo '<div class="ws-menu-page-hr"></div>' . "\n";
								/**/
								echo '<p><strong>Shortcode ( copy/paste )</strong>, for an Inline Profile Modification Form:<br />' . "\n";
								echo '<p><input type="text" value="' . format_to_edit ('[s2Member-Profile /]') . '" style="font-size:90%; font-family:Consolas, monospace; width:99%;" onclick="this.select ();" /></p>' . "\n";
								/**/
								echo '<p style="margin-top:20px;"><strong>Stand-Alone ( copy/paste )</strong>, for popup window:</p>' . "\n";
								echo '<p><input type="text" value="' . format_to_edit (preg_replace ("/\<\?php echo S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL; \?\>/", c_ws_plugin__s2member_utils_strings::esc_ds (site_url ("/?s2member_profile=1")), file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-2-ops.php"))) . '" style="font-size:90%; font-family:Consolas, monospace; width:99%;" onclick="this.select ();" /></p>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_after_profile_modifications", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_display_restrictions", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_before_restrictions", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Restrictions ( Posts/Pages/Categories/Tags/URIs/etc. )">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-restrictions-section">' . "\n";
								echo '<h3>Restrictions ( Posts/Pages/Categories/Tags/URIs/etc. )</h3>' . "\n";
								echo '<p>All of these options have been moved into their own configuration panel.<br />Please go to: <code>s2Member -> Restriction Options</code></p>' . "\n";
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_during_restrictions", get_defined_vars ());
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_gen_ops_page_during_left_sections_after_restrictions", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_during_gen_ops_page_after_left_sections", get_defined_vars ());
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
new c_ws_plugin__s2member_menu_page_gen_ops ();
?>