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
/*
API Notifications page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member API / Notifications</h2>' . "\n";
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
do_action ("ws_plugin__s2member_during_api_ops_page_before_left_sections", get_defined_vars ());
/**/
if (apply_filters ("ws_plugin__s2member_during_api_ops_page_during_left_sections_display_signup_notifications", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_before_signup_notifications", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Signup Notifications">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-signup-notifications-section">' . "\n";
		echo '<h3>Signup Notification URLs ( optional )</h3>' . "\n";
		echo '<p>If you use affiliate software, or have back-office routines that need to be notified whenever a new Subscription is created, you\'ll want to read this section. This is marked `Signup`, because the URLs that you list below, will be notified each time a Member signs up. Depending on your fee structure, this may include a first initial payment that establishes their Subscription. This Notification will only be triggered once for each Member. Signup Notifications are sent right after a Member signs up successfully through PayPal®, regardless of whether any money has actually been received. In other words, this Notification is triggered anytime a Member signs up, even if you provided them with a free trial. Please note, this feature is not to be confused with the PayPal® IPN service. PayPal® IPN integration is already built into s2Member and remains active at all times. These Signup Notifications are an added layer of functionality, and they are completely optional; used primarily in affiliate program integration &amp; other back-office routines.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_during_signup_notifications", get_defined_vars ());
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
		echo 'You can input multiple Notification URLs by inserting one per line.<br />' . "\n";
		echo '<textarea name="ws_plugin__s2member_signup_notification_urls" id="ws-plugin--s2member-signup-notification-urls" rows="3" wrap="off">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_notification_urls"]) . '</textarea><br />' . "\n";
		echo 'Signup Notifications take place silently behind-the-scene, using an HTTP connection. Each URL will be notified every time a new user signs up successfully through PayPal.<br /><br />' . "\n";
		echo '<strong>You can also use these special Replacement Codes if you need them:</strong>' . "\n";
		echo '<ul>' . "\n";
		echo '<li><code>%%subscr_id%%</code> = The PayPal® Subscription ID, which remains constant throughout any &amp; all future payments. [ <a href="#" onclick="alert(\'There is one exception. If you are selling Lifetime or Fixed-Term ( non-recurring ) access, using Buy Now functionality; the %%subscr_id%% is actually set to the Transaction ID for the purchase.\\n\\nPayPal® does not provide a specific Subscription ID for Buy Now purchases. Since Lifetime &amp; Fixed-Term Subscriptions are NOT recurring ( i.e. there is only ONE payment ), using the Transaction ID as the Subscription ID is a graceful way to deal with this minor conflict.\'); return false;">?</a> ]</li>' . "\n";
		echo '<li><code>%%initial%%</code> = The Initial Fee charged during signup. If you offered a free trial, this will be <code>0</code>. [ <a href="#" onclick="alert(\'This will always represent the amount of money the Customer spent, whenever they initially signed up, no matter what. Even if that amount is 0.\\n\\nIf a Customer signs up, under the terms of a free trial period, this will be 0. So be careful using %%initial%% when you offer a free trial period, because a $0.00 sale amount could cause havoc with affiliate programs.\\n\\nIf you\\\'re offering a free trial period, and you need to track sales through affiliate programs, you can either hard-code an amount; or use `Payment Notifications` instead.\'); return false;">?</a> ]</li>' . "\n";
		echo '<li><code>%%regular%%</code> = The Regular Amount of the Subscription. This value is <code>always > 0</code>, no matter what. [ <a href="#" onclick="alert(\'This is how much the Subscription costs after an initial period expires. The %%regular%% rate is always > 0. If you did not offer an initial period, %%initial%% and %%regular%% will be equal to the same thing.\'); return false;">?</a> ]</li>' . "\n";
		echo '<li><code>%%recurring%%</code> = This is the amount that will be charged on a Recurring basis, or <code>0</code> if non-Recurring. [ <a href="#" onclick="alert(\'If recurring payments have not been required, this will be equal to 0. That being said, %%regular%% &amp; %%recurring%% are usually the same value. This variable can be used in two different ways. You can use it to determine what the regular recurring rate is, or to determine whether the Subscription will recur or not. If it is going to recur, %%recurring%% will be > 0.\'); return false;">?</a> ]</li>' . "\n";
		echo '<li><code>%%first_name%%</code> = The First Name of the Customer who purchased the Membership Subscription.</li>' . "\n";
		echo '<li><code>%%last_name%%</code> = The Last Name of the Customer who purchased the Membership Subscription.</li>' . "\n";
		echo '<li><code>%%full_name%%</code> = The Full Name ( First & Last ) of the Customer who purchased the Membership Subscription.</li>' . "\n";
		echo '<li><code>%%payer_email%%</code> = The Email Address of the Customer who purchased the Membership Subscription.</li>' . "\n";
		echo '<li><code>%%item_number%%</code> = The Item Number ( colon separated <code><em>level:custom_capabilities:fixed term</em></code> ) for the Membership Subscription.</li>' . "\n";
		echo '<li><code>%%item_name%%</code> = The Item Name ( as provided by the <code>desc=""</code> attribute in your Shortcode, which briefly describes the Item Number ).</li>' . "\n";
		echo '<li><code>%%initial_term%%</code> = This is the term length of the initial period. This will be a numeric value, followed by a space, then a single letter. [ <a href="#" onclick="alert(\'Here are some examples:\\n\\n%%initial_term%% = 1 D ( this means 1 Day )\\n%%initial_term%% = 1 W ( this means 1 Week )\\n%%initial_term%% = 1 M ( this means 1 Month )\\n%%initial_term%% = 1 Y ( this means 1 Year )\\n\\nThe initial period never recurs, so this only lasts for the term length specified, then it is over. If no initial period was even offered, the value of %%initial_term%% will just be: 0 D, meaning zero days.\'); return false;">?</a> ]</li>' . "\n";
		echo '<li><code>%%regular_term%%</code> = This is the term length of the regular period. This will be a numeric value, followed by a space, then a single letter. [ <a href="#" onclick="alert(\'Here are some examples:\\n\\n%%regular_term%% = 1 D ( this means 1 Day )\\n%%regular_term%% = 1 W ( this means 1 Week )\\n%%regular_term%% = 1 M ( this means 1 Month )\\n%%regular_term%% = 1 Y ( this means 1 Year )\\n%%regular_term%% = 1 L ( this means 1 Lifetime )\\n\\nThe regular term is usually recurring. So the regular term value represents the period ( or duration ) of each recurring period. If %%recurring%% = 0, then the regular term only applies once, because it is not recurring. So if it is not recurring, the value of %%regular_term%% simply represents how long their membership privileges are going to last after the %%initial_term%% has expired, if there was an initial term. The value of this variable ( %%regular_term%% ) will never be empty, it will always be at least: 1 D, meaning 1 day. No exceptions.\'); return false;">?</a> ]</li>' . "\n";
		echo '</ul>' . "\n";
		echo '<strong>Custom Replacement Codes can also be inserted using these instructions:</strong>' . "\n";
		echo '<ul>' . "\n";
		echo '<li><code>%%cv0%%</code> = The domain of your site, which is passed through the `custom` attribute in your Shortcode.</li>' . "\n";
		echo '<li><code>%%cv1%%</code> = If you need to track additional custom variables, you can pipe delimit them into the `custom` attribute, inside your Shortcode, like this: <code>custom="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3"</code>. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
		echo '</ul>' . "\n";
		echo '<strong>This example uses cv1 to track a User\'s IP address:</strong><br />' . "\n";
		echo '<em>( The IP address could be referenced using <code>%%cv1%%</code> )</em><br />' . "\n";
		echo '<code>custom="' . $_SERVER["HTTP_HOST"] . '|&lt;?php echo $_SERVER["REMOTE_ADDR"]; ?&gt;"</code>' . "\n";
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
if (apply_filters ("ws_plugin__s2member_during_api_ops_page_during_left_sections_display_registration_notifications", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_before_registration_notifications", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Registration Notifications">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-registration-notifications-section">' . "\n";
		echo '<h3>Registration Notification URLs ( optional )</h3>' . "\n";
		echo '<p>If you use affiliate software, or have back-office routines that need to be notified whenever a new Member is created, you\'ll want to read this section. This is marked `Registration`, because the URLs that you list below, will be notified each time a Member registers a Username. This is usually triggered right after a `Signup` Notification; at the point in which a new Member successfully completes the Registration form, and they are assigned a Username. However, this is ALSO triggered whenever you create a new User inside your WordPress® Dashboard with a Free Subscriber Role, or with one of the s2Member Roles. It will NOT be triggered for other Roles; such as Administrators, Editors, Authors, and Contributors. Please note, this feature is not to be confused with the PayPal® IPN service. PayPal® IPN integration is already built into s2Member and remains active at all times. These Registration Notifications are an added layer of functionality, and they are completely optional; used primarily in affiliate program integration &amp; other back-office routines.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_during_registration_notifications", get_defined_vars ());
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
		echo 'You can input multiple Notification URLs by inserting one per line.<br />' . "\n";
		echo '<textarea name="ws_plugin__s2member_registration_notification_urls" id="ws-plugin--s2member-registration-notification-urls" rows="3" wrap="off">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["registration_notification_urls"]) . '</textarea><br />' . "\n";
		echo 'Registration Notifications take place silently behind-the-scene, using an HTTP connection. Each URL will be notified every time a new user registers a Username.<br /><br />' . "\n";
		echo '<strong>You can also use these special Replacement Codes if you need them:</strong>' . "\n";
		echo '<ul>' . "\n";
		echo '<li><code>%%level%%</code> = The Level number <code>( 0, 1, 2, 3, 4 )</code>, where <code>0 = Free Subscriber</code>.</li>' . "\n";
		echo '<li><code>%%user_first_name%%</code> = The First Name of the Member who registered their Username.</li>' . "\n";
		echo '<li><code>%%user_last_name%%</code> = The Last Name of the Member who registered their Username.</li>' . "\n";
		echo '<li><code>%%user_full_name%%</code> = The Full Name ( First & Last ) of the Member who registered their Username.</li>' . "\n";
		echo '<li><code>%%user_email%%</code> = The Email Address of the Member who registered their Username.</li>' . "\n";
		echo '<li><code>%%user_login%%</code> = The Username the Member selected during registration.</li>' . "\n";
		echo '<li><code>%%user_pass%%</code> = The Password selected or generated during registration.</li>' . "\n";
		echo '</ul>' . "\n";
		echo '<strong>Custom Replacement Codes can also be inserted using these instructions:</strong>' . "\n";
		echo '<ul>' . "\n";
		echo '<li><code>%%cv0%%</code> = The domain of your site, which is passed through the `custom` attribute in your Shortcode.</li>' . "\n";
		echo '<li><code>%%cv1%%</code> = If you need to track additional custom variables, you can pipe delimit them into the `custom` attribute, inside your Shortcode, like this: <code>custom="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3"</code>. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
		echo '</ul>' . "\n";
		echo '<strong>This example uses cv1 to track a User\'s IP address:</strong><br />' . "\n";
		echo '<em>( The IP address could be referenced using <code>%%cv1%%</code> )</em><br />' . "\n";
		echo '<code>custom="' . $_SERVER["HTTP_HOST"] . '|&lt;?php echo $_SERVER["REMOTE_ADDR"]; ?&gt;"</code>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_after_registration_notifications", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_api_ops_page_during_left_sections_display_payment_notifications", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_before_payment_notifications", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Payment Notifications">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-payment-notifications-section">' . "\n";
		echo '<h3>Payment Notification URLs ( optional )</h3>' . "\n";
		echo '<p>If you use affiliate software, or have back-office routines that need to be notified whenever payment transactions take place, and/or for recurring payments, you\'ll want to read this section. This is marked `Payment`, because the URLs that you list below, will be notified each time an actual payment occurs. Depending on your fee structure, this may include a first initial payment that establishes a Subscription. But more importantly, this will be triggered on all future payments that are received for the lifetime of the Subscription. So unlike the `Signup` Notification, `Payment` Notifications take place whenever actual payments are received, instead of just once after signup is completed. If a payment is required during signup ( e.g. no free trial is being offered ), a Signup Notification will be triggered, and a Payment Notification will ALSO be triggered. In other words, a Payment Notification occurs anytime funds are received, no matter what. Please note, this feature is not to be confused with the PayPal® IPN service. PayPal® IPN integration is already built into s2Member and remains active at all times. These Payment Notifications are an added layer of functionality, and they are completely optional; used primarily in affiliate program integration &amp; other back-office routines.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_during_payment_notifications", get_defined_vars ());
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
		echo 'You can input multiple Notification URLs by inserting one per line.<br />' . "\n";
		echo '<textarea name="ws_plugin__s2member_payment_notification_urls" id="ws-plugin--s2member-payment-notification-urls" rows="3" wrap="off">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_urls"]) . '</textarea><br />' . "\n";
		echo 'Payment Notifications take place silently behind-the-scene, using an HTTP connection. Each URL will be notified every time an initial and/or recurring payment occurs.<br /><br />' . "\n";
		echo '<strong>You can also use these special Replacement Codes if you need them:</strong>' . "\n";
		echo '<ul>' . "\n";
		echo '<li><code>%%subscr_id%%</code> = The PayPal® Subscription ID, which remains constant throughout any &amp; all future payments. [ <a href="#" onclick="alert(\'There is one exception. If you are selling Lifetime or Fixed-Term ( non-recurring ) access, using Buy Now functionality; the %%subscr_id%% is actually set to the Transaction ID for the payment.\\n\\nPayPal® does not provide a specific Subscription ID for Buy Now purchases. Since Lifetime &amp; Fixed-Term Subscriptions are NOT recurring ( i.e. there is only ONE payment ), using the Transaction ID as the Subscription ID is a graceful way to deal with this minor conflict.\'); return false;">?</a> ]</li>' . "\n";
		echo '<li><code>%%txn_id%%</code> = The PayPal® unique Transaction ID, which is always unique for each payment received.</li>' . "\n";
		echo '<li><code>%%amount%%</code> = The Amount of the payment. Most affiliate programs calculate commissions from this.</li>' . "\n";
		echo '<li><code>%%first_name%%</code> = The First Name of the Customer who purchased the Membership Subscription.</li>' . "\n";
		echo '<li><code>%%last_name%%</code> = The Last Name of the Customer who purchased the Membership Subscription.</li>' . "\n";
		echo '<li><code>%%full_name%%</code> = The Full Name ( First & Last ) of the Customer who purchased the Membership Subscription.</li>' . "\n";
		echo '<li><code>%%payer_email%%</code> = The Email Address of the Customer who purchased the Membership Subscription.</li>' . "\n";
		echo '<li><code>%%item_number%%</code> = The Item Number ( colon separated <code><em>level:custom_capabilities:fixed term</em></code> ) that the payment is for.</li>' . "\n";
		echo '<li><code>%%item_name%%</code> = The Item Name ( as provided by the <code>desc=""</code> attribute in your Shortcode, which briefly describes the Item Number ).</li>' . "\n";
		echo '</ul>' . "\n";
		echo '<strong>Custom Replacement Codes can also be inserted using these instructions:</strong>' . "\n";
		echo '<ul>' . "\n";
		echo '<li><code>%%cv0%%</code> = The domain of your site, which is passed through the `custom` attribute in your Shortcode.</li>' . "\n";
		echo '<li><code>%%cv1%%</code> = If you need to track additional custom variables, you can pipe delimit them into the `custom` attribute, inside your Shortcode, like this: <code>custom="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3"</code>. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
		echo '</ul>' . "\n";
		echo '<strong>This example uses cv1 to track a User\'s IP address:</strong><br />' . "\n";
		echo '<em>( The IP address could be referenced using <code>%%cv1%%</code> )</em><br />' . "\n";
		echo '<code>custom="' . $_SERVER["HTTP_HOST"] . '|&lt;?php echo $_SERVER["REMOTE_ADDR"]; ?&gt;"</code>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_after_payment_notifications", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_api_ops_page_during_left_sections_display_eot_deletion_notifications", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_before_eot_deletion_notifications", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="EOT/Deletion Notifications">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-eot-deletion-notifications-section">' . "\n";
		echo '<h3>EOT/Deletion Notification URLs ( optional )</h3>' . "\n";
		echo '<p>If you use affiliate software, or have back-office routines that need to be notified whenever Subscriptions have ended ( and a Member is demoted to a Free Subscriber ), or when an account is deleted from the system, you\'ll want to read this section. This is marked `EOT/Deletion`, because the URLs that you list below, will be notified in both cases. EOT = End Of Term. An EOT is triggered <em>immediately</em> when you refund a Customer, when a Customer forces a chargeback to occur, or when a PayPal® Subscription ends naturally ( i.e. expires ), and the PayPal® IPN service sends s2Member a <code>subscr_eot</code> response. Delayed EOTs occur after a cancellation, either as a result of you cancelling a Customer\'s Subscription, or a Customer cancelling their own Subscription through PayPal®. A cancellation usually results in a delayed EOT, because a cancellation does not always warrant an immediate EOT; there could still be time left on their Subscription.</p>' . "\n";
		echo '<p>Manual Deletions will trigger an immediate Notification. If you delete an account manually from within your WordPress® Dashboard, your URLs can be notified automatically through this system. So the two events are an EOT and/or a Manual Deletion. Please note, this feature is not to be confused with the PayPal® IPN service. PayPal® IPN integration is already built into s2Member and remains active at all times. These EOT/Deletion Notifications are an added layer of functionality, and they are completely optional; used primarily in affiliate program integration &amp; other back-office routines.</p>' . "\n";
		echo '<p><em><strong>*Some Hairy Details*</strong> There might be times whenever you notice that a Members\'s Subscription has been cancelled through PayPal®... but, s2Member continues allowing the User  access to your site as a paid Member. Please don\'t be confused by this... in 99.9% of these cases, the reason for this is legitimate. s2Member will only remove the User\'s membership privileges when PayPal® sends a <code>subscr_eot</code> notification via the IPN service, a refund occurs, a chargeback occurs, or when a cancellation occurs - which would later result in a delayed Auto-EOT by s2Member. s2Member will not process an EOT until the User has completely used up the time they paid for. In other words, if a User signs up for a monthly Subscription on Jan 1st, and then cancels their Subscription on Jan 15th; technically, they should still be allowed to access the site for another 15 days, and then on Feb 1st, the time they paid for has completely elapsed. At that time, s2Member will remove their membership privileges; by either demoting them to a Free Subscriber, or deleting their account from the system ( based on your configuration ). s2Member also calculates one extra day ( 24 hours ) into its equation, just to make sure access is not removed sooner than a Customer might expect.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_during_eot_deletion_notifications", get_defined_vars ());
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
		echo 'You can input multiple Notification URLs by inserting one per line.<br />' . "\n";
		echo '<textarea name="ws_plugin__s2member_eot_del_notification_urls" id="ws-plugin--s2member-eot-del-notification-urls" rows="3" wrap="off">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"]) . '</textarea><br />' . "\n";
		echo 'EOT/Deletion Notifications take place silently behind-the-scene, using an HTTP connection. Each URL will be notified every time a Subscription hits an EOT, or is deleted.<br /><br />' . "\n";
		echo '<strong>You can also use these special Replacement Codes if you need them:</strong>' . "\n";
		echo '<ul>' . "\n";
		echo '<li><code>%%subscr_id%%</code> = The PayPal® Subscription ID, which remained constant throughout the lifetime of the membership. [ <a href="#" onclick="alert(\'There is one exception. If you are selling Lifetime or Fixed-Term ( non-recurring ) access, using Buy Now functionality; the %%subscr_id%% is actually set to the original Transaction ID for the purchase.\\n\\nPayPal® does not provide a specific Subscription ID for Buy Now purchases. Since Lifetime &amp; Fixed-Term Subscriptions are NOT recurring ( i.e. there was only ONE payment ), using the Transaction ID as the Subscription ID is a graceful way to deal with this minor conflict.\'); return false;">?</a> ]</li>' . "\n";
		echo '<li><code>%%user_first_name%%</code> = The First Name listed on their User account. This might be different than what is on file at PayPal®.</li>' . "\n";
		echo '<li><code>%%user_last_name%%</code> = The Last Name listed on their User account. This might be different than what is on file at PayPal®.</li>' . "\n";
		echo '<li><code>%%user_full_name%%</code> = The Full Name listed on their User account. This might be different than what is on file at PayPal®.</li>' . "\n";
		echo '<li><code>%%user_email%%</code> = The Email Address associated with their User account. This might be different than what is on file at PayPal®.</li>' . "\n";
		echo '</ul>' . "\n";
		echo '<strong>Custom Replacement Codes can also be inserted using these instructions:</strong>' . "\n";
		echo '<ul>' . "\n";
		echo '<li><code>%%cv0%%</code> = The domain of your site, which is passed through the `custom` attribute in your Shortcode.</li>' . "\n";
		echo '<li><code>%%cv1%%</code> = If you need to track additional custom variables, you can pipe delimit them into the `custom` attribute, inside your Shortcode. like this: <code>custom="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3"</code>. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
		echo '</ul>' . "\n";
		echo '<strong>This example uses cv1 to track a User\'s IP address:</strong><br />' . "\n";
		echo '<em>( The IP address could be referenced using <code>%%cv1%%</code> )</em><br />' . "\n";
		echo '<code>custom="' . $_SERVER["HTTP_HOST"] . '|&lt;?php echo $_SERVER["REMOTE_ADDR"]; ?&gt;"</code>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_after_eot_deletion_notifications", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_api_ops_page_during_left_sections_display_refund_reversal_notifications", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_before_refund_reversal_notifications", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Refund/Reversal Notifications">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-refund-reversal-notifications-section">' . "\n";
		echo '<h3>Refund/Reversal Notification URLs ( optional )</h3>' . "\n";
		echo '<p>If you use affiliate software, or have back-office routines that need to be notified whenever Subscriptions have been refunded or reversed ( i.e. charged back to you ), you\'ll want to read this section. This is marked `Refund/Reversal`, because the URLs that you list below, will ONLY be notified in those specific cases, as opposed to the EOT Notifications, which are all-inclusive. This is very similar to the EOT/Deletion described above. But, there is an important distinction. EOT includes cancellations, expirations, failed payments, refunds, chargebacks, etc, etc. In other words, ANY time a deletion or End Of Term action takes place.</p>' . "\n";
		echo '<p>So the distinction is that Refund/Reversal Notifications are ONLY sent under these specific circumstances: 1. You log into your PayPal® account and refund a payment that is associated with a Subscription. 2. The Customer complains to PayPal® and a chargeback occurs, forcing a Reversal. In both of these cases, an EOT/Deletion Notification will be sent ( as described above ), but since EOT is a more broad Notification, the Refund/Reversal Notification is here so you can nail down specific back-office operations in these two specific scenarios. Please note, this feature is not to be confused with the PayPal® IPN service. PayPal® IPN integration is already built into s2Member and remains active at all times. These Refund/Reversal Notifications are an added layer of functionality, and they are completely optional; used primarily in affiliate program integration &amp; other back-office routines.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_during_refund_reversal_notifications", get_defined_vars ());
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
		echo 'You can input multiple Notification URLs by inserting one per line.<br />' . "\n";
		echo '<textarea name="ws_plugin__s2member_ref_rev_notification_urls" id="ws-plugin--s2member-ref-rev-notification-urls" rows="3" wrap="off">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["ref_rev_notification_urls"]) . '</textarea><br />' . "\n";
		echo 'Refund/Reversal Notifications take place silently behind-the-scene, using an HTTP connection. Each URL will be notified every time a payment is refunded through PayPal® or a chargeback occurs.<br /><br />' . "\n";
		echo '<strong>You can also use these special Replacement Codes if you need them:</strong>' . "\n";
		echo '<ul>' . "\n";
		echo '<li><code>%%subscr_id%%</code> = The PayPal® Subscription ID, which remained constant throughout the lifetime of the membership. [ <a href="#" onclick="alert(\'There is one exception. If you are selling Lifetime or Fixed-Term ( non-recurring ) access, using Buy Now functionality; the %%subscr_id%% is actually set to the original Transaction ID for the purchase.\\n\\nPayPal® does not provide a specific Subscription ID for Buy Now purchases. Since Lifetime &amp; Fixed-Term Subscriptions are NOT recurring ( i.e. there was only ONE payment ), using the Transaction ID as the Subscription ID is a graceful way to deal with this minor conflict.\'); return false;">?</a> ]</li>' . "\n";
		echo '<li><code>%%parent_txn_id%%</code> = The PayPal® Transaction ID, associated with the original payment that is being refunded/reversed.</li>' . "\n";
		echo '<li><code>%%-amount%%</code> = The Negative Amount of the payment, that was refunded or reversed back to the Customer.</li>' . "\n";
		echo '<li><code>%%first_name%%</code> = The First Name of the Customer who purchased the Membership Subscription.</li>' . "\n";
		echo '<li><code>%%last_name%%</code> = The Last Name of the Customer who purchased the Membership Subscription.</li>' . "\n";
		echo '<li><code>%%full_name%%</code> = The Full Name ( First & Last ) of the Customer who purchased the Membership Subscription.</li>' . "\n";
		echo '<li><code>%%payer_email%%</code> = The Email Address of the Customer who purchased the Membership Subscription.</li>' . "\n";
		echo '<li><code>%%item_number%%</code> = The Item Number ( colon separated <em>level:custom_capabilities:fixed term</em> ) that the payment was for.</li>' . "\n";
		echo '<li><code>%%item_name%%</code> = The Item Name ( as provided by the <code>desc=""</code> attribute in your Shortcode, which briefly describes the Item Number ).</li>' . "\n";
		echo '</ul>' . "\n";
		echo '<strong>Custom Replacement Codes can also be inserted using these instructions:</strong>' . "\n";
		echo '<ul>' . "\n";
		echo '<li><code>%%cv0%%</code> = The domain of your site, which is passed through the `custom` attribute in your Shortcode.</li>' . "\n";
		echo '<li><code>%%cv1%%</code> = If you need to track additional custom variables, you can pipe delimit them into the `custom` attribute, inside your Shortcode, like this: <code>custom="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3"</code>. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
		echo '</ul>' . "\n";
		echo '<strong>This example uses cv1 to track a User\'s IP address:</strong><br />' . "\n";
		echo '<em>( The IP address could be referenced using <code>%%cv1%%</code> )</em><br />' . "\n";
		echo '<code>custom="' . $_SERVER["HTTP_HOST"] . '|&lt;?php echo $_SERVER["REMOTE_ADDR"]; ?&gt;"</code>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_after_refund_reversal_notifications", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_api_ops_page_during_left_sections_display_sp_notifications", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_before_sp_notifications", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Specific Post/Page Access Notifications">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-sp-notifications-section">' . "\n";
		echo '<h3>Specific Post/Page Access Notification URLs ( optional )</h3>' . "\n";
		echo '<p>If you use affiliate software, or have back-office routines that need to be notified whenever Specific Post/Page transactions take place, you\'ll want to read this section. This is marked `Specific Post/Page`, because the URLs that you list below, will be notified each time a payment occurs, for access to a Specific Post/Page sale. This is the only Notification that is sent for Specific Post/Page Access. All of the other API Notifications are designed for Membership Level Access. Please note, this feature is not to be confused with the PayPal® IPN service. PayPal® IPN integration is already built into s2Member and remains active at all times. These Payment Notifications are an added layer of functionality, and they are completely optional; used primarily in affiliate program integration &amp; other back-office routines.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_during_sp_notifications", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-sp-notification-urls">' . "\n";
		echo 'Specific Post/Page Notification URLs:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo 'You can input multiple Notification URLs by inserting one per line.<br />' . "\n";
		echo '<textarea name="ws_plugin__s2member_sp_notification_urls" id="ws-plugin--s2member-sp-notification-urls" rows="3" wrap="off">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_notification_urls"]) . '</textarea><br />' . "\n";
		echo 'Specific Post/Page Notifications take place silently behind-the-scene, using an HTTP connection. Each URL will be notified every time a sale occurs.<br /><br />' . "\n";
		echo '<strong>You can also use these special Replacement Codes if you need them:</strong>' . "\n";
		echo '<ul>' . "\n";
		echo '<li><code>%%sp_access_url%%</code> = The full URL ( generated by s2Member ) where the Customer can gain access.</li>' . "\n";
		echo '<li><code>%%sp_access_exp%%</code> = Human readable expiration for <code>%%sp_access_url%%</code>. Ex: <em>( link expires in <code>%%sp_access_exp%%</code> )</em>.</li>' . "\n";
		echo '<li><code>%%txn_id%%</code> = The PayPal® Transaction ID. PayPal® assigns a unique identifier for every purchase.</li>' . "\n";
		echo '<li><code>%%amount%%</code> = The full Amount of the sale. Most affiliate programs calculate commissions from this.</li>' . "\n";
		echo '<li><code>%%first_name%%</code> = The First Name of the Customer who purchased Specific Post/Page Access.</li>' . "\n";
		echo '<li><code>%%last_name%%</code> = The Last Name of the Customer who purchased Specific Post/Page Access.</li>' . "\n";
		echo '<li><code>%%full_name%%</code> = The Full Name ( First & Last ) of the Customer who purchased Specific Post/Page Access.</li>' . "\n";
		echo '<li><code>%%payer_email%%</code> = The Email Address of the Customer who purchased Specific Post/Page Access.</li>' . "\n";
		echo '<li><code>%%item_number%%</code> = The Item Number. Ex: <code><em>sp:13,24,36:72</em></code> ( translates to: <code><em>sp:comma-delimited IDs:expiration hours</em></code> ).</li>' . "\n";
		echo '<li><code>%%item_name%%</code> = The Item Name ( as provided by the <code>desc=""</code> attribute in your Shortcode, which briefly describes the Item Number ).</li>' . "\n";
		echo '</ul>' . "\n";
		echo '<strong>Custom Replacement Codes can also be inserted using these instructions:</strong>' . "\n";
		echo '<ul>' . "\n";
		echo '<li><code>%%cv0%%</code> = The domain of your site, which is passed through the `custom` attribute in your Shortcode.</li>' . "\n";
		echo '<li><code>%%cv1%%</code> = If you need to track additional custom variables, you can pipe delimit them into the `custom` attribute, inside your Shortcode, like this: <code>custom="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3"</code>. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</li>' . "\n";
		echo '</ul>' . "\n";
		echo '<strong>This example uses cv1 to track a User\'s IP address:</strong><br />' . "\n";
		echo '<em>( The IP address could be referenced using <code>%%cv1%%</code> )</em><br />' . "\n";
		echo '<code>custom="' . $_SERVER["HTTP_HOST"] . '|&lt;?php echo $_SERVER["REMOTE_ADDR"]; ?&gt;"</code>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_api_ops_page_during_left_sections_after_sp_notifications", get_defined_vars ());
	}
/**/
do_action ("ws_plugin__s2member_during_api_ops_page_after_left_sections", get_defined_vars ());
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
do_action ("ws_plugin__s2member_during_api_ops_page_before_right_sections", get_defined_vars ());
do_action ("ws_plugin__s2member_during_menu_pages_before_right_sections", get_defined_vars ());
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["upsell-pro"]) ? '<div class="ws-menu-page-others"><a href="' . ws_plugin__s2member_parse_readme_value ("Pro Module / Licensing") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-upsell-pro.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["installation"]) ? '<div class="ws-menu-page-installation"><a href="' . ws_plugin__s2member_parse_readme_value ("Professional Installation URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-installation.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["tools"]) ? '<div class="ws-menu-page-tools"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-tools.png" alt="." /></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["support"]) ? '<div class="ws-menu-page-support"><a href="' . ws_plugin__s2member_parse_readme_value ("Forum URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-support.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["donations"]) ? '<div class="ws-menu-page-donations"><a href="' . ws_plugin__s2member_parse_readme_value ("Donate link") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-donations.jpg" alt="." /></a></div>' . "\n" : '';
/**/
do_action ("ws_plugin__s2member_during_menu_pages_after_right_sections", get_defined_vars ());
do_action ("ws_plugin__s2member_during_api_ops_page_after_right_sections", get_defined_vars ());
/**/
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
/**/
echo '</div>' . "\n";
?>