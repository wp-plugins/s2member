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
Options page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member PayPal® Options</h2>' . "\n";
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
echo '<div class="ws-menu-page-section ws-plugin--s2member-paypal-email-section">' . "\n";
echo '<h3>PayPal® EMail Address ( required, please customize this )</h3>' . "\n";
echo '<p>This plugin works in conjunction with PayPal® Website Payments Standard, for businesses. You do NOT need a PayPal® Pro account. You just need to upgrade your Personal PayPal® account to a Business status, which is free. A PayPal® account can be <a href="http://pages.ebay.com/help/buy/questions/upgrade-paypal-account.html" target="_blank" rel="xlink">upgraded</a> from a Personal account to a Business account, simply by going to the `Profile` button under the `My Account` tab, selecting the `Personal Business Information` button, and then clicking the `Upgrade Your Account` button.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-paypal-business">' . "\n";
echo 'Your PayPal® EMail Address:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_paypal_business" id="ws-plugin--s2member-paypal-business" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"]) . '" /><br />' . "\n";
echo 'Enter the email address you\'ve associated with your PayPal® account.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-paypal-sandbox">' . "\n";
echo 'Sandbox Testing:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="radio" name="ws_plugin__s2member_paypal_sandbox" id="ws-plugin--s2member-paypal-sandbox-0" value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? ' checked="checked"' : '') . ' /> <label for="ws-plugin--s2member-paypal-sandbox-0">No</label> &nbsp;&nbsp;&nbsp; <input type="radio" name="ws_plugin__s2member_paypal_sandbox" id="ws-plugin--s2member-paypal-sandbox-1" value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? ' checked="checked"' : '') . ' /> <label for="ws-plugin--s2member-paypal-sandbox-1">Yes, enable support for Sandbox testing.</label><br />' . "\n";
echo '<em>Only enable this if you\'ve provided a Sandbox email address above. This puts the IPN, PDT and Button Generator into Sandbox mode. See: <a href="https://developer.paypal.com/" target="_blank" rel="xlink">https://developer.paypal.com/</a></em>' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-paypal-debug">' . "\n";
echo 'Debugging Log Routines:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="radio" name="ws_plugin__s2member_paypal_debug" id="ws-plugin--s2member-paypal-debug-0" value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_debug"]) ? ' checked="checked"' : '') . ' /> <label for="ws-plugin--s2member-paypal-debug-0">No</label> &nbsp;&nbsp;&nbsp; <input type="radio" name="ws_plugin__s2member_paypal_debug" id="ws-plugin--s2member-paypal-debug-1" value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_debug"]) ? ' checked="checked"' : '') . ' /> <label for="ws-plugin--s2member-paypal-debug-1">Yes, enable debugging, with IPN logging.</label><br />' . "\n";
echo '<em>Only enable if you\'re debugging. This enables IPN and Return Page logging. The log files are stored here: <code>' . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]) . '</code></em>' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-hr ws-plugin--s2member-paypal-ipn-section-hr"></div>' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-paypal-ipn-section">' . "\n";
echo '<h3>PayPal® IPN / Instant Payment Notifications ( required, please enable )</h3>' . "\n";
echo '<p>Log into your PayPal® account and navigate to this section:<br /><code>Account Profile -> Instant Payment Notification Preferences</code></p>' . "\n";
echo '<p>Edit your IPN settings &amp; turn IPN Notifications: <strong><code>On</code></strong></p>' . "\n";
echo '<p>You\'ll need your IPN URL, which is:<br /><code>' . get_bloginfo ("url") . '/?s2member_paypal_notify=1</code></p>' . "\n";
echo '<p><strong>Quick tip:</strong> In addition to the default IPN Settings inside your PayPal® account, the IPN URL is also set on a per-transaction basis by the special PayPal® button code that s2Member provides you with. In other words, if you have multiple sites operating on one PayPal® account, that\'s OK. s2Member dynamically sets the IPN URL for each transaction. The result is that the IPN URL configured from within your PayPal® account, becomes the default, which is then overwritten on a per transaction basis. In fact, PayPal® recently updated their system to support IPN URL preservation, which makes it easier to use one PayPal® account to handle multiple sites, all using different IPN URLs.' . "\n";
echo '<p><strong>More information:</strong> You\'ll be happy to know that s2Member handles cancellations, expirations, failed payments ( more than 2 in a row ), terminations ( e.g. refunds &amp; chargebacks ) for you automatically. If you log into your PayPal® account and cancel a User\'s subscription, or, if the User logs into their PayPal® account and cancels their own subscription, s2Member will be notified of these important changes and react accordingly through the PayPal® IPN service that runs silently behind the scenes. The PayPal® IPN service will notify s2Member whenever a User\'s payments have been failing ( more than 2 times in a row ), and/or whenever a User\'s subscription has expired for any reason. Even refunds &amp; chargeback reversals are supported through the IPN service. If you issue a refund to an unhappy customer through PayPal®, s2Member will be notified, and the account for that customer will be deleted automagically. The communication from PayPal® -> s2Member is seamless.</p>' . "\n";
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-hr ws-plugin--s2member-paypal-pdt-section-hr"></div>' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-paypal-pdt-section">' . "\n";
echo '<h3>PayPal® PDT Identity Token ( required, if using PayPal® Auto-Return )</h3>' . "\n";
echo '<p>Only fill this in if you\'re using PayPal\'s Auto-Return feature with PDT ( Payment Data Transfer ). Please note that Auto-Return w/PDT does <strong>NOT</strong> have to be enabled in your PayPal® account for s2Member to function. It is merely a way to bring visitors back to your site faster after completing checkout at PayPal®. That being said, <strong>if you enable Auto-Return, you MUST also enable PDT &amp; supply your Identity Token here</strong>. Auto-Return &amp; PDT ( Payment Data Transfer ) can both be enabled from within your PayPal® account. You\'ll need your Auto-Return URL, which is:<br /><code>' . get_bloginfo ("url") . '/?s2member_paypal_return=1</code></p>' . "\n";
echo '<p>It is also worth noting that in addition to your default PayPal® account configuration, the Auto-Return URL is also set on a per-transaction basis from within the special PayPal® button code that s2Member provides you with. In other words, if you have multiple sites operating on one PayPal® account, that\'s OK. s2Member dynamically sets the Auto-Return URL for each transaction. The result is that the Auto-Return URL configured from within your PayPal® account, becomes the default, which is then overwritten on a per transaction basis.' . "\n";
echo '<p>Once you\'ve enabled Auto-Return and PDT, PayPal® will issue your Identity Token.' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-paypal-identity-token">' . "\n";
echo 'PayPal® PDT Identity Token:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_paypal_identity_token" id="ws-plugin--s2member-paypal-identity-token" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_identity_token"]) . '" /><br />' . "\n";
echo 'You MUST fill this in if you\'ve enabled Auto-Return. Auto-Return &amp; PDT can both be enabled from within your PayPal® account.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
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