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
echo '<div class="ws-menu-page-group" title="PayPal® Account Details">' . "\n";
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
echo 'Sandbox Testing?' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="radio" name="ws_plugin__s2member_paypal_sandbox" id="ws-plugin--s2member-paypal-sandbox-0" value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? ' checked="checked"' : '') . ' /> <label for="ws-plugin--s2member-paypal-sandbox-0">No</label> &nbsp;&nbsp;&nbsp; <input type="radio" name="ws_plugin__s2member_paypal_sandbox" id="ws-plugin--s2member-paypal-sandbox-1" value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? ' checked="checked"' : '') . ' /> <label for="ws-plugin--s2member-paypal-sandbox-1">Yes, enable support for Sandbox testing.</label><br />' . "\n";
echo '<em>Only enable this if you\'ve provided a Sandbox email address above.<br />This puts the IPN, PDT and Button Generator into Sandbox mode.<br />See: <a href="https://developer.paypal.com/" target="_blank" rel="xlink">https://developer.paypal.com</a></em>' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-paypal-debug">' . "\n";
echo 'Enable Logging Routines?' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="radio" name="ws_plugin__s2member_paypal_debug" id="ws-plugin--s2member-paypal-debug-0" value="0"' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_debug"]) ? ' checked="checked"' : '') . ' /> <label for="ws-plugin--s2member-paypal-debug-0">No</label> &nbsp;&nbsp;&nbsp; <input type="radio" name="ws_plugin__s2member_paypal_debug" id="ws-plugin--s2member-paypal-debug-1" value="1"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_debug"]) ? ' checked="checked"' : '') . ' /> <label for="ws-plugin--s2member-paypal-debug-1">Yes, enable debugging, with IPN &amp; Return Page logging.</label><br />' . "\n";
echo '<em>This enables IPN and Return Page logging. The log files are stored here:<br /><code>' . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]) . '</code></em>' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
/**/
echo '<p><em><strong>*Sandbox Tip*</strong> If you\'re testing your site through a PayPal® Sandbox account, please remember that Email Confirmations from s2Member will NOT be received after a test purchase. s2Member sends its Confirmation Emails to the PayPal® Email Address of the Customer. Since PayPal® Sandbox addresses are usually bogus ( for testing ), you will have to run live transactions before Email Confirmations from s2Member are received. That being said, all other s2Member functionality CAN be tested through a PayPal® Sandbox account. Email Confirmations are the only hang-up.</em></p>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="PayPal® IPN->s2Member Integration">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-paypal-ipn-section">' . "\n";
echo '<h3>PayPal® IPN / Instant Payment Notifications ( required, please enable )</h3>' . "\n";
echo '<p>Log into your PayPal® account and navigate to this section:<br /><code>Account Profile -> Instant Payment Notification Preferences</code></p>' . "\n";
echo '<p>Edit your IPN settings &amp; turn IPN Notifications: <strong><code>On</code></strong></p>' . "\n";
echo '<p>You\'ll need your IPN URL, which is:<br /><code>' . get_bloginfo ("url") . '/?s2member_paypal_notify=1</code></p>' . "\n";
echo '<p><strong>Quick tip:</strong> In addition to the default IPN Settings inside your PayPal® account, the IPN URL is also set on a per-transaction basis by the special PayPal® Button Code that s2Member provides you with. In other words, if you have multiple sites operating on one PayPal® account, that\'s OK. s2Member dynamically sets the IPN URL for each transaction. The result is that the IPN URL configured from within your PayPal® account, becomes the default, which is then overwritten on a per transaction basis. In fact, PayPal® recently updated their system to support IPN URL preservation. One PayPal® account can handle multiple sites, all using different IPN URLs.' . "\n";
echo '<p><strong>More information:</strong> You\'ll be happy to know that s2Member handles cancellations, expirations, failed payments ( more than 2 in a row ), terminations ( e.g. refunds &amp; chargebacks ) for you automatically. If you log into your PayPal® account and cancel a Member\'s subscription, or, if the Member logs into their PayPal® account and cancels their own subscription, s2Member will be notified of these important changes and react accordingly through the PayPal® IPN service that runs silently behind-the-scene. The PayPal® IPN service will notify s2Member whenever a Member\'s payments have been failing ( more than 2 times in a row ), and/or whenever a Member\'s subscription has expired for any reason. Even refunds &amp; chargeback reversals are supported through the IPN service. If you issue a refund to an unhappy Customer through PayPal®, s2Member will be notified, and the account for that Customer will either be demote to a Free Subscriber, or deleted automatically ( based on your configuration ). The communication from PayPal® -> s2Member is seamless.</p>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="PayPal® PDT/Auto-Return Integration">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-paypal-pdt-section">' . "\n";
echo '<h3>PayPal® PDT Identity Token ( required, please enable )</h3>' . "\n";
echo '<p>Log into your PayPal® account and navigate to this section:<br /><code>Account Profile -> Website Payment Preferences</code></p>' . "\n";
echo '<p>Turn the Auto-Return feature: <strong><code>On</code></strong></p>' . "\n";
echo '<p>You\'ll need your Auto-Return URL, which is:<br /><code>' . get_bloginfo ("url") . '/?s2member_paypal_return=1</code></p>' . "\n";
echo '<p>You MUST also enable PDT ( Payment Data Transfer ): <strong><code>On</code></strong><br /><em>You\'ll be issued an Identity Token that you MUST enter below.</em></p>' . "\n";
echo '<p><strong>Quick tip:</strong> In addition to your default PayPal® account configuration, the Auto-Return URL is also set on a per-transaction basis from within the special PayPal® Button Code that s2Member provides you with. In other words, if you have multiple sites operating on one PayPal® account, that\'s OK. s2Member dynamically sets the Auto-Return URL for each transaction. The result is that the Auto-Return URL configured from within your PayPal® account, becomes the default, which is then overwritten on a per transaction basis.' . "\n";
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
echo 'Your PDT Identity Token will appear under <em>Profile -> Website Payment Preferences</em> in your PayPal® account.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="PayPal® Confirmation Email">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-signup-confirmation-email-section">' . "\n";
echo '<h3>Signup Confirmation Email ( required, but the default works fine )</h3>' . "\n";
echo '<p>This email is sent to new Customers after they return from a successful signup at PayPal®. The <strong>primary</strong> purpose of this email, is to provide the Customer with instructions, along with a link to register a Username for their Membership. You may also customize this further by providing details that are specifically geared to your site.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-signup-email-subject">' . "\n";
echo 'Signup Confirmation Email Subject:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_signup_email_subject" id="ws-plugin--s2member-signup-email-subject" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_email_subject"]) . '" /><br />' . "\n";
echo 'Subject Line used in the email sent to a Customer after a successful signup has occurred through PayPal®.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-signup-email-message">' . "\n";
echo 'Signup Confirmation Email Message:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<textarea name="ws_plugin__s2member_signup_email_message" id="ws-plugin--s2member-signup-email-message" rows="10">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_email_message"]) . '</textarea><br />' . "\n";
echo 'Message Body used in the email sent to a Customer after a successful signup has occurred through PayPal®.<br /><br />' . "\n";
echo '<strong>You can also use these special replacement codes if you need them:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%registration_url%% = The full URL ( generated by s2Member ) where the Customer can get registered.</code></li>' . "\n";
echo '<li><code>%%subscr_id%% = The PayPal® Subscription ID, which remains constant throughout any &amp; all future payments.</code> [ <a href="#" onclick="alert(\'There is one exception. If you are selling Lifetime ( non-recurring ) access, using a Buy It Now button; the %%subscr_id%% is actually set to the Transaction ID for the purchase.\\n\\nPayPal® does not provide a specific Subscription ID for Buy It Now purchases. Since Lifetime subscriptions are NOT recurring ( i.e. there is only ONE payment ), using the Transaction ID as the Subscription ID is a graceful way to deal with this minor conflict.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%initial%% = The Initial Fee charged during signup. If you offered a free trial, this will be 0.</code> [ <a href="#" onclick="alert(\'This will always represent the amount of money the Customer spent, whenever they initially signed up, no matter what. If a Customer signs up, under the terms of a free trial period, this will be 0.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%regular%% = The Regular Amount of the subscription. This value is always > 0, no matter what.</code> [ <a href="#" onclick="alert(\'This is how much the subscription costs after an initial period expires. The %%regular%% rate is always > 0. If you did not offer an initial period, %%initial%% and %%regular%% will be equal to the same thing.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%recurring%% = This is the amount that will be charged on a Recurring basis, or 0 if non-Recurring.</code> [ <a href="#" onclick="alert(\'If recurring payments have not been required, this will be equal to 0. That being said, %%regular%% &amp; %%recurring%% are usually the same value. This variable can be used in two different ways. You can use it to determine what the regular recurring rate is, or to determine whether the subscription will recur or not. If it is going to recur, %%recurring%% will be > 0.\\n\\nThe only time this is NOT equal to the %%regular%% rate, is when recurring payments are not required; and only a one-time regular rate applies.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%first_name%% = The First Name of the Customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%last_name%% = The Last Name of the Customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%full_name%% = The Full Name ( First & Last ) of the Customer who purchased the membership subscription.</code></li>' . "\n";
echo '<li><code>%%payer_email%% = The Email Address of the Customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%item_number%% = The Item Number ( colon separated <em>level:custom_capabilities</em> ) that the subscription is for.</code></li>' . "\n";
echo '<li><code>%%item_name%% = The Item Name ( in other words, the associated membership Level Label that briefly describes the item number ).</code></li>' . "\n";
echo '<li><code>%%initial_term%% = This is the term length of the initial period. This will be a numeric value, followed by a space, then a single letter.</code> [ <a href="#" onclick="alert(\'Here are some examples:\\n\\n%%initial_term%% = 1 D ( this means 1 Day )\\n%%initial_term%% = 1 M ( this means 1 Month )\\n%%initial_term%% = 1 Y ( this means 1 Year )\\n\\nThe initial period never recurs, so this only lasts for the term length specified, then it is over. If no initial period was even offered, the value of %%initial_term%% will just be: 0 D, meaning zero days.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%regular_term%% = This is the term length of the regular period. This will be a numeric value, followed by a space, then a single letter.</code> [ <a href="#" onclick="alert(\'Here are some examples:\\n\\n%%regular_term%% = 1 D ( this means 1 Day )\\n%%regular_term%% = 1 M ( this means 1 Month )\\n%%regular_term%% = 1 Y ( this means 1 Year )\\n%%regular_term%% = 1 L ( this means 1 Lifetime )\\n\\nThe regular term is usually recurring. So the regular term value represents the period ( or duration ) of each recurring period. If %%recurring%% = 0, then the regular term only applies once, because it is not recurring. So if it is not recurring, the value of %%regular_term%% simply represents how long their membership privileges are going to last after the %%initial_term%% has expired, if there was an initial term. The value of this variable ( %%regular_term%% ) will never be empty, it will always be at least: 1 D, meaning 1 day. No exceptions.\'); return false;">?</a> ]</li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>Custom replacement codes can also be inserted using these instructions:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%cv0%% = The domain of your site, which is passed through to PayPal® using the `custom` field in your PayPal® Button Code.</code></li>' . "\n";
echo '<li><code>%%cv1%% = If you need to track additional custom variables, you can pipe delimit them into the `custom` field of your Button Code like this: &lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3" /&gt;. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>This example uses cv1 to track a user\'s IP address:</strong><br />' . "\n";
echo '<em>( The IP address can be referenced in your Confirmation Email using %%cv1%% )</em><br />' . "\n";
echo '<code>&lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|&lt;?php echo $_SERVER["REMOTE_ADDR"]; ?&gt;" /&gt;</code>' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="PayPal® Single-Page Email">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-single-page-email-section">' . "\n";
echo '<h3>Single-Page Confirmation Email ( required, but the default works fine )</h3>' . "\n";
echo '<p>This email is sent to new Customers after they return from a successful purchase at PayPal®, specifically for Single-Page Access. ( see: <code>s2Member -> General Options -> Single-Page Access</code> ). This is NOT used for Membership sales, only for Single-Page Access. The <strong>primary</strong> purpose of this email, is to provide the Customer with instructions, along with a link to access the Page they\'ve obtained access to. You may also customize this further by providing details that are specifically geared to your site.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-single-page-email-subject">' . "\n";
echo 'Single-Page Confirmation Email Subject:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_single_page_email_subject" id="ws-plugin--s2member-single-page-email-subject" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["single_page_email_subject"]) . '" /><br />' . "\n";
echo 'Subject Line used in the email sent to a Customer after a successful purchase has occurred through PayPal® for Single-Page Access.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-single-page-email-message">' . "\n";
echo 'Single-Page Confirmation Email Message:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<textarea name="ws_plugin__s2member_single_page_email_message" id="ws-plugin--s2member-single-page-email-message" rows="10">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["single_page_email_message"]) . '</textarea><br />' . "\n";
echo 'Message Body used in the email sent to a Customer after a successful purchase has occurred through PayPal® for Single-Page Access.<br /><br />' . "\n";
echo '<strong>You can also use these special replacement codes if you need them:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%sp_access_url%% = The full URL ( generated by s2Member ) where the Customer can gain access.</code></li>' . "\n";
echo '<li><code>%%sp_access_exp%% = Human readable expiration for %%sp_access_url%%. Ex: <em>( link expires in %%sp_access_exp%% )</em>.</code></li>' . "\n";
echo '<li><code>%%txn_id%% = The PayPal® Transaction ID. PayPal® assigns a unique identifier for every purchase.</code></li>' . "\n";
echo '<li><code>%%amount%% = The full Amount that you charged for Single-Page Access. This value will always be > 0.</code></li>' . "\n";
echo '<li><code>%%first_name%% = The First Name of the Customer who purchased Single-Page Access through PayPal®.</code></li>' . "\n";
echo '<li><code>%%last_name%% = The Last Name of the Customer who purchased Single-Page Access through PayPal®.</code></li>' . "\n";
echo '<li><code>%%full_name%% = The Full Name ( First & Last ) of the Customer who purchased Single-Page Access.</code></li>' . "\n";
echo '<li><code>%%payer_email%% = The Email Address of the Customer who purchased Single-Page Access through PayPal®.</code></li>' . "\n";
echo '<li><code>%%item_number%% = The Item Number. Ex: <em>sp:13:72</em> ( sp:page_ID:expiration_hours ).</code></li>' . "\n";
echo '<li><code>%%item_name%% = The Item Name. In other words, a brief description, detailing what this purchase was for.</code></li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>Custom replacement codes can also be inserted using these instructions:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%cv0%% = The domain of your site, which is passed through to PayPal® using the `custom` field in your PayPal® Button Code.</code></li>' . "\n";
echo '<li><code>%%cv1%% = If you need to track additional custom variables, you can pipe delimit them into the `custom` field of your Button Code like this: &lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3" /&gt;. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>This example uses cv1 to track a user\'s IP address:</strong><br />' . "\n";
echo '<em>( The IP address can be referenced in your Confirmation Email using %%cv1%% )</em><br />' . "\n";
echo '<code>&lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|&lt;?php echo $_SERVER["REMOTE_ADDR"]; ?&gt;" /&gt;</code>' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="PayPal® EOT Behavior">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-eot-behavior-section">' . "\n";
echo '<h3>PayPal® EOT Behavior ( required, please choose )</h3>' . "\n";
echo '<p>EOT = End Of Term. By default, s2Member will demote a paid Member to a Free Subscriber whenever their subscription term has ended, been canceled, refunded, charged back to you, etc. s2Member demotes them to a Free Subscriber, so they will no longer have paid Member Level Access to your site. However, in some cases, you may prefer to have Customer accounts deleted completely, instead of just being demoted. This is where you choose which method works best for your site.</p>' . "\n";
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-membership-eot-behavior">' . "\n";
echo 'Membership EOT Behavior ( demote or delete )?' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<select name="ws_plugin__s2member_membership_eot_behavior" id="ws-plugin--s2member-membership-eot-behavior">' . "\n";
echo '<option value="demote"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_eot_behavior"] === "demote") ? ' selected="selected"' : '') . '>Demote ( convert them to a Free Subscriber )</option>' . "\n";
echo '<option value="delete"' . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_eot_behavior"] === "delete") ? ' selected="selected"' : '') . '>Delete ( erase their account completely )</option>' . "\n";
echo '</select>' . "\n";
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