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
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member API/Url Options</h2>' . "\n";
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
echo '<div class="ws-menu-page-section ws-plugin--s2member-signup-notifications-section">' . "\n";
echo '<h3>Signup Notification URLs ( optional )</h3>' . "\n";
echo '<p>If you use affiliate software, or have back-office routines that need to be notified whenever a new subscription is created, you\'ll want to read this section. This is marked `Signup`, because the URLs that you list below will be notified each time a user signs up. Depending on your fee structure, this may include a first initial payment that establishes their subscription. This notification will only be triggered once for each user. Signup notifications are sent just after a user signs up successfully through PayPal®, regardless of whether any money has actually been received. In other words, this notification is triggered anytime a user signs up, even if you provided them with a free trial. Please note, this feature is not to be confused with the PayPal® IPN service. PayPal® IPN integration is already built into s2Member and remains active at all times. These Signup Notifications are an added layer of functionality, and they are completely optional; used primarily in affiliate program integration &amp; other back-office routines.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-signup-notification-urls">' . "\n";
echo 'Signup Notification URLs:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo 'You can input multiple notification URLs by inserting one per line.<br />' . "\n";
echo '<textarea name="ws_plugin__s2member_signup_notification_urls" id="ws-plugin--s2member-signup-notification-urls" rows="3" wrap="off">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_notification_urls"]) . '</textarea><br />' . "\n";
echo 'Signup notifications take place silently behind-the-scenes, using a cURL connection. Each URL will be notified every time a new user signs up successfully through PayPal.<br /><br />' . "\n";
echo '<strong>You can also use these special replacement codes if you need them:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%subscr_id%% = The PayPal® subscription ID, which remains constant throughout any &amp; all future payments.</code></li>' . "\n";
echo '<li><code>%%initial%% = The initial fee charged during signup, in USD. If you offered a free trial, this will be 0.</code> [ <a href="#" onclick="alert(\'If no initial period was offered or required, this initial amount will be equal to the %%regular%% rate. In other words, this will always represent the amount of money the customer spent whenever they signed up, no matter what.\\n\\nIf a user signs up under the terms of a free trial period, this will be 0. So be careful using this value with 3rd party affiliate integrations because a $0 sale amount could cause havoc. If you have a lot of trouble, try using the %%regular%% amount, or use the `Payment` notifications instead of the `Signup` notifications.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%regular%% = The regular amount of the subscription in USD. This dollar value is always > 0, no matter what.</code> [ <a href="#" onclick="alert(\'This is how much the subscription costs after an initial period expires. This value remains unchanged no matter whether you actually offered an initial period or not. The %%regular%% rate is always > 0. If you did not offer an initial period, %%initial%% and %%regular%% will be equal to the same thing.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%recurring%% = This is the amount in USD that will be charged on a recurring basis, or 0 if non-recurring.</code> [ <a href="#" onclick="alert(\'If recurring payments have not been required, this will be equal to 0. That being said, %%regular%% &amp; %%recurring%% are usually the same value. This variable can be used in two different ways. You can use it to determine what the regular recurring rate is, or to determine whether the subscription will recur or not. If it is going to recur, %%recurring%% will be > 0.\\n\\nThe only time this is NOT equal to the %%regular%% rate, is when recurring payments are not required; and only a one-time regular rate applies. If you have trouble, try using the %%regular%% amount, or use the `Payment` notifications instead of the `Signup` notifications.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%first_name%% = The first name of the customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%last_name%% = The last name of the customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%full_name%% = The full name ( first & last ) of the customer who purchased the membership subscription.</code></li>' . "\n";
echo '<li><code>%%payer_email%% = The email address of the customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%item_number%% = The item number ( in other words, the membership level: 1, 2, 3 or 4 ) that the subscription is for.</code></li>' . "\n";
echo '<li><code>%%item_name%% = The item name ( in other words, the associated membership level label that briefly describes the item number ).</code></li>' . "\n";
echo '<li><code>%%initial_term%% = This is the term length of the initial period. This will be a numeric value, followed by a space, then a single letter.</code> [ <a href="#" onclick="alert(\'Here are some examples:\\n\\n%%initial_term%% = 1 D ( this means 1 Day )\\n%%initial_term%% = 1 M ( this means 1 Month )\\n%%initial_term%% = 1 Y ( this means 1 Year )\\n\\nThe initial period never recurs, so this only lasts for the term length specified, then it is over. If no initial period was even offered, the value of %%initial_term%% will just be: 0 D, meaning zero days.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%regular_term%% = This is the term length of the regular period. This will be a numeric value, followed by a space, then a single letter.</code> [ <a href="#" onclick="alert(\'Here are some examples:\\n\\n%%regular_term%% = 1 D ( this means 1 Day )\\n%%regular_term%% = 1 M ( this means 1 Month )\\n%%regular_term%% = 1 Y ( this means 1 Year )\\n\\nThe regular term is usually recurring. So the regular term value represents the period ( or duration ) of each recurring period. If %%recurring%% = 0, then the regular term only applies once, because it is not recurring. So if it is not recurring, the value of %%regular_term%% simply represents how long their membership priviledges are going to last after the %%initial_term%% has expired, if there was an initial term.\\n\\nThe value of this variable ( %%regular_term%% ) will never be empty, it will always be at least: 1 D, meaning 1 day. No exceptions.\'); return false;">?</a> ]</li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>Custom replacement codes can also be inserted using these instructions:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%cv0%% = The domain of your site, which is passed through to PayPal® using the `custom` field in your PayPal® button code.</code></li>' . "\n";
echo '<li><code>%%cv1%% = If you need to track additional custom variables, you can pipe delimit them into the `custom` field of your button code like this: &lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3" /&gt;. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>This example uses cv1 to track a user\'s IP address:</strong><br />' . "\n";
echo '<em>( The IP address can be referenced in your notification URL using %%cv1%% )</em><br />' . "\n";
echo '<code>&lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|&lt;?php echo $_SERVER["REMOTE_ADDR"]; ?&gt;" /&gt;</code>' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-hr ws-plugin--s2member-payment-notifications-section-hr"></div>' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-payment-notifications-section">' . "\n";
echo '<h3>Payment Notification URLs ( optional )</h3>' . "\n";
echo '<p>If you use affiliate software, or have back-office routines that need to be notified whenever payment transactions take place, and/or for recurring payments, you\'ll want to read this section. This is marked `Payment`, because the URLs that you list below will be notified each time an actual payment occurs. Depending on your fee structure, this may include a first initial payment that establishes a subscription. But more importantly, this will be triggered on all future payments that are received for the lifetime of the subscription. So unlike the `Signup` notification, `Payment` notifications take place whenever actual payments are received, instead of just once after signup is completed. If a payment is required during signup ( e.g. no free trial is being offered ), a signup notification will be triggered, and a payment notification will ALSO be triggered. In other words, a payment notification occurs anytime funds are received, no matter what. Please note, this feature is not to be confused with the PayPal® IPN service. PayPal® IPN integration is already built into s2Member and remains active at all times. These Payment Notifications are an added layer of functionality, and they are completely optional; used primarily in affiliate program integration &amp; other back-office routines.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-payment-notification-urls">' . "\n";
echo 'Payment Notification URLs:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo 'You can input multiple notification URLs by inserting one per line.<br />' . "\n";
echo '<textarea name="ws_plugin__s2member_payment_notification_urls" id="ws-plugin--s2member-payment-notification-urls" rows="3" wrap="off">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_urls"]) . '</textarea><br />' . "\n";
echo 'Payment notifications take place silently behind-the-scenes, using a cURL connection. Each URL will be notified every time an initial and/or recurring payment occurs.<br /><br />' . "\n";
echo '<strong>You can also use these special replacement codes if you need them:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%subscr_id%% = The PayPal® subscription ID, which remains constant throughout any &amp; all future payments.</code></li>' . "\n";
echo '<li><code>%%txn_id%% = The PayPal® unique transaction ID, which is always unique for each payment received.</code></li>' . "\n";
echo '<li><code>%%amount%% = The amount of the payment in USD. Most affiliate programs calculate commissions from this.</code></li>' . "\n";
echo '<li><code>%%first_name%% = The first name of the customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%last_name%% = The last name of the customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%full_name%% = The full name ( first & last ) of the customer who purchased the membership subscription.</code></li>' . "\n";
echo '<li><code>%%payer_email%% = The email address of the customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%item_number%% = The item number ( in other words, the membership level: 1, 2, 3 or 4 ) that the payment is for.</code></li>' . "\n";
echo '<li><code>%%item_name%% = The item name ( in other words, the associated membership level label that briefly describes the item number ).</code></li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>Custom replacement codes can also be inserted using these instructions:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%cv0%% = The domain of your site, which is passed through to PayPal® using the `custom` field in your PayPal® button code.</code></li>' . "\n";
echo '<li><code>%%cv1%% = If you need to track additional custom variables, you can pipe delimit them into the `custom` field of your button code like this: &lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3" /&gt;. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>This example uses cv1 to track a user\'s IP address:</strong><br />' . "\n";
echo '<em>( The IP address can be referenced in your notification URL using %%cv1%% )</em><br />' . "\n";
echo '<code>&lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|&lt;?php echo $_SERVER["REMOTE_ADDR"]; ?&gt;" /&gt;</code>' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-hr ws-plugin--s2member-eot-deletion-notifications-section-hr"></div>' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-eot-deletion-notifications-section">' . "\n";
echo '<h3>EOT/Deletion Notification URLs ( optional )</h3>' . "\n";
echo '<p>If you use affiliate software, or have back-office routines that need to be notified whenever subscriptions have ended, or when an account is deleted from the system otherwise, you\'ll want to read this section. This is marked `EOT/Deletion`, because the URLs that you list below will be notified in both cases. EOT = End Of Term. An EOT is triggered anytime you cancel or refund a subscription via PayPal®, or if a user cancels their own subscription through PayPal®, fails to make payments, etc. In other words, anytime a subscription reaches the end of its term because you issue a refund, a chargeback occurs, a cancellation occurs or failed payments force PayPal® to end their subscription, this is triggered.</p>' . "\n";
echo '<p>EOTs are not necessarily triggered immediately after a cancellation takes place though. For example, if a User signs up for a monthly subscription on Jan 1st, and then cancels their subscription on Jan 15th; technically, they should still be allowed to access your site for another 15 days, and then on Feb 1st, the time they paid for has completely elapsed and that is when their account is automatically deleted from the system and an EOT notification is triggered. That being said, there are cases when an EOT is triggered immediately. For instance, if too many of their subscription payments fail at PayPal® ( more than 2 in a row ), an EOT will be issued immediately, also resulting in the automatic deletion of their account. If you log into your PayPal® account and issue a refund to an unhappy customer, their account will be automatically deleted, and an EOT is triggered immediately.</p>' . "\n";
echo '<p>Manual Deletions are the other case in which these notifications will be triggered. If you delete an account manually from within your WordPress® Dashboard, your affiliate software will be notified automatically through this notification. So the two events are EOT and/or manual Deletion. Please note, this feature is not to be confused with the PayPal® IPN service. PayPal® IPN integration is already built into s2Member and remains active at all times. These EOT/Deletion Notifications are an added layer of functionality, and they are completely optional; used primarily in affiliate program integration &amp; other back-office routines.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-eot-del-notification-urls">' . "\n";
echo 'EOT/Deletion Notification URLs:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo 'You can input multiple notification URLs by inserting one per line.<br />' . "\n";
echo '<textarea name="ws_plugin__s2member_eot_del_notification_urls" id="ws-plugin--s2member-eot-del-notification-urls" rows="3" wrap="off">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"]) . '</textarea><br />' . "\n";
echo 'EOT/Deletion notifications take place silently behind-the-scenes, using a cURL connection. Each URL will be notified every time a subscription reaches the end of its term or is deleted otherwise.<br /><br />' . "\n";
echo '<strong>You can also use these special replacement codes if you need them:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%subscr_id%% = The PayPal® subscription ID, which remained constant throughout the lifetime of the membership.</code></li>' . "\n";
echo '<li><code>%%user_first_name%% = The first name listed on their user account. This might be different than what is on file at PayPal®.</code></li>' . "\n";
echo '<li><code>%%user_last_name%% = The last name listed on their user account. This might be different than what is on file at PayPal®.</code></li>' . "\n";
echo '<li><code>%%user_full_name%% = The full name listed on their user account. This might be different than what is on file at PayPal®.</code></li>' . "\n";
echo '<li><code>%%user_email%% = The email address associated with their user account. This might be different than what is on file at PayPal®.</code></li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>Custom replacement codes can also be inserted using these instructions:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%cv0%% = The domain of your site, which is passed through to PayPal® using the `custom` field in your PayPal® button code.</code></li>' . "\n";
echo '<li><code>%%cv1%% = If you need to track additional custom variables, you can pipe delimit them into the `custom` field of your button code like this: &lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3" /&gt;. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>This example uses cv1 to track a user\'s IP address:</strong><br />' . "\n";
echo '<em>( The IP address can be referenced in your notification URL using %%cv1%% )</em><br />' . "\n";
echo '<code>&lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|&lt;?php echo $_SERVER["REMOTE_ADDR"]; ?&gt;" /&gt;</code>' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-hr ws-plugin--s2member-refund-reversal-notifications-section-hr"></div>' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-refund-reversal-notifications-section">' . "\n";
echo '<h3>Refund/Reversal Notification URLs ( optional )</h3>' . "\n";
echo '<p>If you use affiliate software, or have back-office routines that need to be notified whenever subscriptions have been refunded or reversed ( e.g. charged back to you ), you\'ll want to read this section. This is marked `Refund/Reversal`, because the URLs that you list below will ONLY be notified in those specific cases, as opposed to the EOT notifications, which are all inclusive. This is very similar to the EOT/Deletion decribed above. But, there is an important distinction. EOT includes cancellations, expirations, failed payments, refunds, chargebacks, etc, etc. In other words, ANY time a deletion or End Of Term action takes place.</p>' . "\n";
echo '<p>So the distinction is that Refund/Reversal notifications are ONLY sent under these specific circumstances: 1. You log into your PayPal® account and refund a payment that is associated with a Subscription. 2. The Customer complains to PayPal® and a chargeback occurs, forcing a Reversal. In both of these cases, an EOT/Deletion notification will be sent ( as described above ), but since EOT is a more broad notification, the Refund/Reversal notification is here so you can nail down specific back-office operations in these two specific scenarios. Please note, this feature is not to be confused with the PayPal® IPN service. PayPal® IPN integration is already built into s2Member and remains active at all times. These Refund/Reversal Notifications are an added layer of functionality, and they are completely optional; used primarily in affiliate program integration &amp; other back-office routines.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-ref-rev-notification-urls">' . "\n";
echo 'Refund/Reversal Notification URLs:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo 'You can input multiple notification URLs by inserting one per line.<br />' . "\n";
echo '<textarea name="ws_plugin__s2member_ref_rev_notification_urls" id="ws-plugin--s2member-ref-rev-notification-urls" rows="3" wrap="off">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["ref_rev_notification_urls"]) . '</textarea><br />' . "\n";
echo 'Refund/Reversal notifications take place silently behind-the-scenes, using a cURL connection. Each URL will be notified every time a payment is refunded through PayPal® or a chargeback occurs.<br /><br />' . "\n";
echo '<strong>You can also use these special replacement codes if you need them:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%subscr_id%% = The PayPal® subscription ID, which remained constant throughout the lifetime of the membership.</code></li>' . "\n";
echo '<li><code>%%parent_txn_id%% = The PayPal® transaction ID, associated with the original payment that is being refunded/reversed.</code></li>' . "\n";
echo '<li><code>%%-amount%% = The negative amount of the payment in USD, that was refunded or reversed back to the customer.</code></li>' . "\n";
echo '<li><code>%%first_name%% = The first name of the customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%last_name%% = The last name of the customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%full_name%% = The full name ( first & last ) of the customer who purchased the membership subscription.</code></li>' . "\n";
echo '<li><code>%%payer_email%% = The email address of the customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%item_number%% = The item number ( in other words, the membership level: 1, 2, 3 or 4 ) that the payment was for.</code></li>' . "\n";
echo '<li><code>%%item_name%% = The item name ( in other words, the associated membership level label that briefly describes the item number ).</code></li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>Custom replacement codes can also be inserted using these instructions:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%cv0%% = The domain of your site, which is passed through to PayPal® using the `custom` field in your PayPal® button code.</code></li>' . "\n";
echo '<li><code>%%cv1%% = If you need to track additional custom variables, you can pipe delimit them into the `custom` field of your button code like this: &lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3" /&gt;. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>This example uses cv1 to track a user\'s IP address:</strong><br />' . "\n";
echo '<em>( The IP address can be referenced in your notification URL using %%cv1%% )</em><br />' . "\n";
echo '<code>&lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|&lt;?php echo $_SERVER["REMOTE_ADDR"]; ?&gt;" /&gt;</code>' . "\n";
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