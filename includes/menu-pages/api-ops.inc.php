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
API Notifications page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member API / Notifications</h2>' . "\n";
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
echo '<div class="ws-menu-page-group" title="Signup Notifications">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-signup-notifications-section">' . "\n";
echo '<h3>Signup Notification URLs ( optional )</h3>' . "\n";
echo '<p>If you use affiliate software, or have back-office routines that need to be notified whenever a new subscription is created, you\'ll want to read this section. This is marked `Signup`, because the URLs that you list below, will be notified each time a Member signs up. Depending on your fee structure, this may include a first initial payment that establishes their subscription. This notification will only be triggered once for each Member. Signup Notifications are sent right after a Member signs up successfully through PayPal®, regardless of whether any money has actually been received. In other words, this notification is triggered anytime a Member signs up, even if you provided them with a free trial. Please note, this feature is not to be confused with the PayPal® IPN service. PayPal® IPN integration is already built into s2Member and remains active at all times. These Signup Notifications are an added layer of functionality, and they are completely optional; used primarily in affiliate program integration &amp; other back-office routines.</p>' . "\n";
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
echo 'Signup Notifications take place silently behind-the-scenes, using a cURL connection. Each URL will be notified every time a new user signs up successfully through PayPal.<br /><br />' . "\n";
echo '<strong>You can also use these special replacement codes if you need them:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%subscr_id%% = The PayPal® Subscription ID, which remains constant throughout any &amp; all future payments.</code> [ <a href="#" onclick="alert(\'There is one exception. If you are selling Lifetime ( non-recurring ) access, using a Buy It Now button; the %%subscr_id%% is actually set to the Transaction ID for the purchase.\\n\\nPayPal® does not provide a specific Subscription ID for Buy It Now purchases. Since Lifetime subscriptions are NOT recurring ( i.e. there is only ONE payment ), using the Transaction ID as the Subscription ID is a graceful way to deal with this minor conflict.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%initial%% = The Initial Fee charged during signup. If you offered a free trial, this will be 0.</code> [ <a href="#" onclick="alert(\'If no initial period was offered or required, this initial amount will be equal to the %%regular%% rate. In other words, this will always represent the amount of money the Customer spent whenever they signed up, no matter what.\\n\\nIf a user signs up under the terms of a free trial period, this will be 0. So be careful using this value with 3rd party affiliate integrations because a $0 sale amount could cause havoc. If you have a lot of trouble, try using the %%regular%% amount, or use the `Payment` Notifications instead of the `Signup` Notifications.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%regular%% = The Regular Amount of the subscription. This value is always > 0, no matter what.</code> [ <a href="#" onclick="alert(\'This is how much the subscription costs after an initial period expires. The %%regular%% rate is always > 0. If you did not offer an initial period, %%initial%% and %%regular%% will be equal to the same thing.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%recurring%% = This is the amount that will be charged on a Recurring basis, or 0 if non-Recurring.</code> [ <a href="#" onclick="alert(\'If recurring payments have not been required, this will be equal to 0. That being said, %%regular%% &amp; %%recurring%% are usually the same value. This variable can be used in two different ways. You can use it to determine what the regular recurring rate is, or to determine whether the subscription will recur or not. If it is going to recur, %%recurring%% will be > 0.\\n\\nThe only time this is NOT equal to the %%regular%% rate, is when recurring payments are not required; and only a one-time regular rate applies. If you have trouble, try using the %%regular%% amount, or use the `Payment` Notifications instead of the `Signup` Notifications.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%first_name%% = The First Name of the Customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%last_name%% = The Last Name of the Customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%full_name%% = The Full Name ( First & Last ) of the Customer who purchased the membership subscription.</code></li>' . "\n";
echo '<li><code>%%payer_email%% = The Email Address of the Customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%item_number%% = The Item Number ( colon separated <em>level:custom_capabilities</em> ) for the membership subscription.</code></li>' . "\n";
echo '<li><code>%%item_name%% = The Item Name ( in other words, the associated membership Level Label that briefly describes the Item Number ).</code></li>' . "\n";
echo '<li><code>%%initial_term%% = This is the term length of the initial period. This will be a numeric value, followed by a space, then a single letter.</code> [ <a href="#" onclick="alert(\'Here are some examples:\\n\\n%%initial_term%% = 1 D ( this means 1 Day )\\n%%initial_term%% = 1 M ( this means 1 Month )\\n%%initial_term%% = 1 Y ( this means 1 Year )\\n\\nThe initial period never recurs, so this only lasts for the term length specified, then it is over. If no initial period was even offered, the value of %%initial_term%% will just be: 0 D, meaning zero days.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%regular_term%% = This is the term length of the regular period. This will be a numeric value, followed by a space, then a single letter.</code> [ <a href="#" onclick="alert(\'Here are some examples:\\n\\n%%regular_term%% = 1 D ( this means 1 Day )\\n%%regular_term%% = 1 M ( this means 1 Month )\\n%%regular_term%% = 1 Y ( this means 1 Year )\\n%%regular_term%% = 1 L ( this means 1 Lifetime )\\n\\nThe regular term is usually recurring. So the regular term value represents the period ( or duration ) of each recurring period. If %%recurring%% = 0, then the regular term only applies once, because it is not recurring. So if it is not recurring, the value of %%regular_term%% simply represents how long their membership privileges are going to last after the %%initial_term%% has expired, if there was an initial term. The value of this variable ( %%regular_term%% ) will never be empty, it will always be at least: 1 D, meaning 1 day. No exceptions.\'); return false;">?</a> ]</li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>Custom replacement codes can also be inserted using these instructions:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%cv0%% = The domain of your site, which is passed through to PayPal® using the `custom` field in your PayPal® Button Code.</code></li>' . "\n";
echo '<li><code>%%cv1%% = If you need to track additional custom variables, you can pipe delimit them into the `custom` field of your Button Code like this: &lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3" /&gt;. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
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
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Registration Notifications">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-registration-notifications-section">' . "\n";
echo '<h3>Registration Notification URLs ( optional )</h3>' . "\n";
echo '<p>If you use affiliate software, or have back-office routines that need to be notified whenever a new Member is created, you\'ll want to read this section. This is marked `Registration`, because the URLs that you list below, will be notified each time a Member registers a Username. This is usually triggered right after a `Signup` Notification; at the point in which a new Member successfully completes the Registration form, and they are assigned a Username. However, this is ALSO triggered whenever you create a new User inside your WordPress® Dashboard with a Free Subscriber Role, or with one of the s2Member Roles. It will NOT be triggered for other Roles; such as Administrators, Editors, Authors, and Contributors. Please note, this feature is not to be confused with the PayPal® IPN service. PayPal® IPN integration is already built into s2Member and remains active at all times. These Registration Notifications are an added layer of functionality, and they are completely optional; used primarily in affiliate program integration &amp; other back-office routines.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-registration-notification-urls">' . "\n";
echo 'Registration Notification URLs:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo 'You can input multiple notification URLs by inserting one per line.<br />' . "\n";
echo '<textarea name="ws_plugin__s2member_registration_notification_urls" id="ws-plugin--s2member-registration-notification-urls" rows="3" wrap="off">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["registration_notification_urls"]) . '</textarea><br />' . "\n";
echo 'Registration Notifications take place silently behind-the-scenes, using a cURL connection. Each URL will be notified every time a new user registers a Username.<br /><br />' . "\n";
echo '<strong>You can also use these special replacement codes if you need them:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%level%% = The level number ( 0, 1, 2, 3, 4 ) 0 = Free Subscriber.</code></li>' . "\n";
echo '<li><code>%%user_first_name%% = The First Name of the Member who registered their Username.</code></li>' . "\n";
echo '<li><code>%%user_last_name%% = The Last Name of the Member who registered their Username.</code></li>' . "\n";
echo '<li><code>%%user_full_name%% = The Full Name ( First & Last ) of the Member who registered their Username</code></li>' . "\n";
echo '<li><code>%%user_email%% = The Email Address of the Member who registered their Username.</code></li>' . "\n";
echo '<li><code>%%user_login%% = The Username the Member selected during registration.</code></li>' . "\n";
echo '<li><code>%%user_pass%% = Is only filled when you\'re allowing Custom Passwords.<br />' ./**/
'<em>See: s2Member -> General Options -> Custom Registration Fields.</em></code></li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>Custom replacement codes can also be inserted using these instructions:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%cv0%% = The domain of your site, which is passed through to PayPal® using the `custom` field in your PayPal® Button Code.</code></li>' . "\n";
echo '<li><code>%%cv1%% = If you need to track additional custom variables, you can pipe delimit them into the `custom` field of your Button Code like this: &lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3" /&gt;. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
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
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Payment Notifications">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-payment-notifications-section">' . "\n";
echo '<h3>Payment Notification URLs ( optional )</h3>' . "\n";
echo '<p>If you use affiliate software, or have back-office routines that need to be notified whenever payment transactions take place, and/or for recurring payments, you\'ll want to read this section. This is marked `Payment`, because the URLs that you list below, will be notified each time an actual payment occurs. Depending on your fee structure, this may include a first initial payment that establishes a subscription. But more importantly, this will be triggered on all future payments that are received for the lifetime of the subscription. So unlike the `Signup` Notification, `Payment` Notifications take place whenever actual payments are received, instead of just once after signup is completed. If a payment is required during signup ( e.g. no free trial is being offered ), a Signup Notification will be triggered, and a Payment Notification will ALSO be triggered. In other words, a Payment Notification occurs anytime funds are received, no matter what. Please note, this feature is not to be confused with the PayPal® IPN service. PayPal® IPN integration is already built into s2Member and remains active at all times. These Payment Notifications are an added layer of functionality, and they are completely optional; used primarily in affiliate program integration &amp; other back-office routines.</p>' . "\n";
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
echo 'Payment Notifications take place silently behind-the-scenes, using a cURL connection. Each URL will be notified every time an initial and/or recurring payment occurs.<br /><br />' . "\n";
echo '<strong>You can also use these special replacement codes if you need them:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%subscr_id%% = The PayPal® Subscription ID, which remains constant throughout any &amp; all future payments.</code> [ <a href="#" onclick="alert(\'There is one exception. If you are selling Lifetime ( non-recurring ) access, using a Buy It Now button; the %%subscr_id%% is actually set to the Transaction ID for the payment.\\n\\nPayPal® does not provide a specific Subscription ID for Buy It Now purchases. Since Lifetime subscriptions are NOT recurring ( i.e. there is only ONE payment ), using the Transaction ID as the Subscription ID is a graceful way to deal with this minor conflict.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%txn_id%% = The PayPal® unique Transaction ID, which is always unique for each payment received.</code></li>' . "\n";
echo '<li><code>%%amount%% = The Amount of the payment. Most affiliate programs calculate commissions from this.</code></li>' . "\n";
echo '<li><code>%%first_name%% = The First Name of the Customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%last_name%% = The Last Name of the Customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%full_name%% = The Full Name ( First & Last ) of the Customer who purchased the membership subscription.</code></li>' . "\n";
echo '<li><code>%%payer_email%% = The Email Address of the Customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%item_number%% = The Item Number ( colon separated <em>level:custom_capabilities</em> ) that the payment is for.</code></li>' . "\n";
echo '<li><code>%%item_name%% = The Item Name ( in other words, the associated membership Level Label that briefly describes the item number ).</code></li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>Custom replacement codes can also be inserted using these instructions:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%cv0%% = The domain of your site, which is passed through to PayPal® using the `custom` field in your PayPal® Button Code.</code></li>' . "\n";
echo '<li><code>%%cv1%% = If you need to track additional custom variables, you can pipe delimit them into the `custom` field of your Button Code like this: &lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3" /&gt;. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
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
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="EOT/Deletion Notifications">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-eot-deletion-notifications-section">' . "\n";
echo '<h3>EOT/Deletion Notification URLs ( optional )</h3>' . "\n";
echo '<p>If you use affiliate software, or have back-office routines that need to be notified whenever subscriptions have ended ( and a Member is demoted to a Free Subscriber ), or when an account is deleted from the system, you\'ll want to read this section. This is marked `EOT/Deletion`, because the URLs that you list below, will be notified in both cases. EOT = End Of Term. An EOT is triggered anytime you cancel or refund a subscription via PayPal®, or if a Member cancels their own subscription through PayPal®, fails to make payments, etc. In other words, anytime a subscription reaches the end of its term, because you issue a refund, a chargeback occurs, a cancellation occurs, or failed payments force PayPal® to end their subscription, this is triggered.</p>' . "\n";
echo '<p>EOTs are not necessarily triggered immediately after a cancellation takes place though. For example, if a Member signs up for a monthly subscription on Jan 1st, and then cancels their subscription on Jan 15th; technically, they should still be allowed to access your site for another 15 days, and then, on Feb 1st, the time they paid for has completely elapsed. That is when their account is automatically demoted to a Free Subscriber, or deleted from the system completely ( based on your configuration ), and an EOT Notification is triggered. That being said, there are cases when an EOT is triggered immediately. For instance, if too many of their subscription payments fail at PayPal® ( more than 2 in a row ), an EOT will be issued immediately, also resulting in the automatic demotion or deletion of their account. If you log into your PayPal® account and issue a refund to an unhappy Customer, their account will automatically be demoted or deleted, and an EOT is triggered immediately.</p>' . "\n";
echo '<p>Manual Deletions are the other case in which these Notifications will be triggered. If you delete an account manually from within your WordPress® Dashboard, your affiliate software will be notified automatically through this notification. So the two events are an EOT and/or a manual Deletion. Please note, this feature is not to be confused with the PayPal® IPN service. PayPal® IPN integration is already built into s2Member and remains active at all times. These EOT/Deletion Notifications are an added layer of functionality, and they are completely optional; used primarily in affiliate program integration &amp; other back-office routines.</p>' . "\n";
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
echo 'EOT/Deletion Notifications take place silently behind-the-scenes, using a cURL connection. Each URL will be notified every time a subscription reaches the end of its term or is deleted.<br /><br />' . "\n";
echo '<strong>You can also use these special replacement codes if you need them:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%subscr_id%% = The PayPal® Subscription ID, which remained constant throughout the lifetime of the membership.</code> [ <a href="#" onclick="alert(\'There is one exception. If you are selling Lifetime ( non-recurring ) access, using a Buy It Now button; the %%subscr_id%% is actually set to the original Transaction ID for the purchase.\\n\\nPayPal® does not provide a specific Subscription ID for Buy It Now purchases. Since Lifetime subscriptions are NOT recurring ( i.e. there was only ONE payment ), using the Transaction ID as the Subscription ID is a graceful way to deal with this minor conflict.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%user_first_name%% = The First Name listed on their User account. This might be different than what is on file at PayPal®.</code></li>' . "\n";
echo '<li><code>%%user_last_name%% = The Last Name listed on their User account. This might be different than what is on file at PayPal®.</code></li>' . "\n";
echo '<li><code>%%user_full_name%% = The Full Name listed on their User account. This might be different than what is on file at PayPal®.</code></li>' . "\n";
echo '<li><code>%%user_email%% = The Email Address associated with their User account. This might be different than what is on file at PayPal®.</code></li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>Custom replacement codes can also be inserted using these instructions:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%cv0%% = The domain of your site, which is passed through to PayPal® using the `custom` field in your PayPal® Button Code.</code></li>' . "\n";
echo '<li><code>%%cv1%% = If you need to track additional custom variables, you can pipe delimit them into the `custom` field of your Button Code like this: &lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3" /&gt;. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
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
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Refund/Reversal Notifications">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-refund-reversal-notifications-section">' . "\n";
echo '<h3>Refund/Reversal Notification URLs ( optional )</h3>' . "\n";
echo '<p>If you use affiliate software, or have back-office routines that need to be notified whenever subscriptions have been refunded or reversed ( e.g. charged back to you ), you\'ll want to read this section. This is marked `Refund/Reversal`, because the URLs that you list below, will ONLY be notified in those specific cases, as opposed to the EOT Notifications, which are all-inclusive. This is very similar to the EOT/Deletion described above. But, there is an important distinction. EOT includes cancellations, expirations, failed payments, refunds, chargebacks, etc, etc. In other words, ANY time a deletion or End Of Term action takes place.</p>' . "\n";
echo '<p>So the distinction is that Refund/Reversal Notifications are ONLY sent under these specific circumstances: 1. You log into your PayPal® account and refund a payment that is associated with a Subscription. 2. The Customer complains to PayPal® and a chargeback occurs, forcing a Reversal. In both of these cases, an EOT/Deletion Notification will be sent ( as described above ), but since EOT is a more broad Notification, the Refund/Reversal Notification is here so you can nail down specific back-office operations in these two specific scenarios. Please note, this feature is not to be confused with the PayPal® IPN service. PayPal® IPN integration is already built into s2Member and remains active at all times. These Refund/Reversal Notifications are an added layer of functionality, and they are completely optional; used primarily in affiliate program integration &amp; other back-office routines.</p>' . "\n";
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
echo 'Refund/Reversal Notifications take place silently behind-the-scenes, using a cURL connection. Each URL will be notified every time a payment is refunded through PayPal® or a chargeback occurs.<br /><br />' . "\n";
echo '<strong>You can also use these special replacement codes if you need them:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%subscr_id%% = The PayPal® Subscription ID, which remained constant throughout the lifetime of the membership.</code> [ <a href="#" onclick="alert(\'There is one exception. If you are selling Lifetime ( non-recurring ) access, using a Buy It Now button; the %%subscr_id%% is actually set to the original Transaction ID for the purchase.\\n\\nPayPal® does not provide a specific Subscription ID for Buy It Now purchases. Since Lifetime subscriptions are NOT recurring ( i.e. there was only ONE payment ), using the Transaction ID as the Subscription ID is a graceful way to deal with this minor conflict.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%parent_txn_id%% = The PayPal® Transaction ID, associated with the original payment that is being refunded/reversed.</code></li>' . "\n";
echo '<li><code>%%-amount%% = The Negative Amount of the payment, that was refunded or reversed back to the Customer.</code></li>' . "\n";
echo '<li><code>%%first_name%% = The First Name of the Customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%last_name%% = The Last Name of the Customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%full_name%% = The Full Name ( First & Last ) of the Customer who purchased the membership subscription.</code></li>' . "\n";
echo '<li><code>%%payer_email%% = The Email Address of the Customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%item_number%% = The Item Number ( colon separated <em>level:custom_capabilities</em> ) that the payment was for.</code></li>' . "\n";
echo '<li><code>%%item_name%% = The Item Name ( in other words, the associated membership Level Label that briefly describes the item number ).</code></li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>Custom replacement codes can also be inserted using these instructions:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%cv0%% = The domain of your site, which is passed through to PayPal® using the `custom` field in your PayPal® Button Code.</code></li>' . "\n";
echo '<li><code>%%cv1%% = If you need to track additional custom variables, you can pipe delimit them into the `custom` field of your Button Code like this: &lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3" /&gt;. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
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
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Single-Page Access Notifications">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-sp-notifications-section">' . "\n";
echo '<h3>Single-Page Access Notification URLs ( optional )</h3>' . "\n";
echo '<p>If you use affiliate software, or have back-office routines that need to be notified whenever Single-Page transactions take place, you\'ll want to read this section. This is marked `Single-Page`, because the URLs that you list below, will be notified each time a payment occurs, specifically for a Single-Page sale. This is the only Notification that is sent for Single-Page Access. All of the other API Notifications are designed for Membership Level Access. Please note, this feature is not to be confused with the PayPal® IPN service. PayPal® IPN integration is already built into s2Member and remains active at all times. These Payment Notifications are an added layer of functionality, and they are completely optional; used primarily in affiliate program integration &amp; other back-office routines.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-sp-notification-urls">' . "\n";
echo 'Single-Page Notification URLs:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo 'You can input multiple notification URLs by inserting one per line.<br />' . "\n";
echo '<textarea name="ws_plugin__s2member_sp_notification_urls" id="ws-plugin--s2member-sp-notification-urls" rows="3" wrap="off">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_notification_urls"]) . '</textarea><br />' . "\n";
echo 'Single-Page Notifications take place silently behind-the-scenes, using a cURL connection. Each URL will be notified every time a sale occurs.<br /><br />' . "\n";
echo '<strong>You can also use these special replacement codes if you need them:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%sp_access_url%% = The full URL ( generated by s2Member ) where the Customer can gain access. Valid for 72 hours.</code></li>' . "\n";
echo '<li><code>%%txn_id%% = The PayPal® Transaction ID. PayPal® assigns a unique identifier for every purchase.</code></li>' . "\n";
echo '<li><code>%%amount%% = The full Amount of the sale. Most affiliate programs calculate commissions from this.</code></li>' . "\n";
echo '<li><code>%%first_name%% = The First Name of the Customer who purchased Single-Page Access through PayPal®.</code></li>' . "\n";
echo '<li><code>%%last_name%% = The Last Name of the Customer who purchased Single-Page Access through PayPal®.</code></li>' . "\n";
echo '<li><code>%%full_name%% = The Full Name ( First & Last ) of the Customer who purchased Single-Page Access.</code></li>' . "\n";
echo '<li><code>%%payer_email%% = The Email Address of the Customer who purchased Single-Page Access through PayPal®.</code></li>' . "\n";
echo '<li><code>%%item_number%% = The Item Number. Ex: <em>sp:13</em> ( the numerical portion is a Single-Page ID ).</code></li>' . "\n";
echo '<li><code>%%item_name%% = The Item Name. In other words, a brief description, detailing what this purchase was for.</code></li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>Custom replacement codes can also be inserted using these instructions:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%cv0%% = The domain of your site, which is passed through to PayPal® using the `custom` field in your PayPal® Button Code.</code></li>' . "\n";
echo '<li><code>%%cv1%% = If you need to track additional custom variables, you can pipe delimit them into the `custom` field of your Button Code like this: &lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3" /&gt;. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
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