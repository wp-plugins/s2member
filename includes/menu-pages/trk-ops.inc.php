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
API Tracking page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member API / Tracking</h2>' . "\n";
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
echo '<div class="ws-menu-page-group" title="Pixel Tracking Code Snippets">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-pixel-tracking-section">' . "\n";
echo '<h3>Pixel Tracking Codes ( optional, these will be injected into the Signup Confirmation Page )</h3>' . "\n";
echo '<p>If you use affiliate software, have tracking codes from advertising networks, or the like, you\'ll want to read this section. The HTML code that you enter below, will be loaded up in a web browser, whenever a Customer lands on the Signup Confirmation Page after checkout. The s2Member Signup Confirmation Page ( also known as a Thank-You Page ), is really just a blank page that alerts the Customer via JavaScript. It says: `Thank You! Your membership has been approved.`. Then it says: `The next step is to Register a Username. Please click OK to be redirected.`. After they\'ve clicked OK on this alert, and after everything ( if there is anything ) on the blank page has finished loading, they\'ll be redirected to the Registration system, where they will be able to setup their Username and login for the first time. This process has been fully automated, very simple.</p>' . "\n";
echo '<p>Now, if you want to track the performance of your marketing efforts using Google® Analytics, affiliate software or advertising networks, you can place the code for those in the field below. All of the code in the field below, will be injected into the Signup Confirmation Page, between the <code>&lt;body&gt;&lt;/body&gt;</code> tags. After everything in your code has finished loading, the new Member will be redirected to the Registration system, so they can setup their Username and login. In other words, the Signup Confirmation Page ensures that all 1x1 pixel images and/or other data from your Pixel Tracking Code ( in the field below ) has finished loading, before it redirects the Member away from the page. This way you can be sure that all of your tracking statistics, and other efforts, remain accurate. This is handled through the magic of the <code>window.onload</code> event, compatible in all major browsers.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-signup-pixel-tracking-codes">' . "\n";
echo 'Pixel Tracking Codes:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<textarea name="ws_plugin__s2member_signup_pixel_tracking_codes" id="ws-plugin--s2member-signup-pixel-tracking-codes" rows="8">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_pixel_tracking_codes"]) . '</textarea><br />' . "\n";
echo 'Any valid XHTML or JavaScript code will work just fine here. Just try not to put anything here that would actually be visible to the user. They won\'t see it anyway, because they\'re going to be redirected as soon as it loads up. Things like 1x1 pixel images that load up silently and/or JavaScript tracking routines will be fine though. Google® Analytics code works just fine, AdSense® performance tracking, as well as Yahoo® tracking and other affiliate network codes are all OK here.<br /><br />' . "\n";
echo '<strong>You can also use these special replacement codes if you need them:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%subscr_id%% = The PayPal® Subscription ID, which remains constant throughout any &amp; all future payments.</code> [ <a href="#" onclick="alert(\'There is one exception. If you are selling Lifetime ( non-recurring ) access, using a Buy It Now button; the %%subscr_id%% is actually set to the Transaction ID for the purchase.\\n\\nPayPal® does not provide a specific Subscription ID for Buy It Now purchases. Since Lifetime subscriptions are NOT recurring ( i.e. there is only ONE payment ), using the Transaction ID as the Subscription ID is a graceful way to deal with this minor conflict.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%initial%% = The initial fee charged during signup, in USD. If you offered a free trial, this will be 0.</code> [ <a href="#" onclick="alert(\'If no initial period was offered or required, this initial amount will be equal to the regular subscription rate. In other words, this will always represent the amount of money the customer spent whenever they signed up, no matter what.\\n\\nIf a user signs up under the terms of a free trial period, this will be 0. So be careful using this value with 3rd party affiliate integrations because a $0 sale amount could cause havoc. If you have a lot of trouble, try using the more advanced `Payment` notifications available in the API Notifications panel for s2Member.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%first_name%% = The first name of the customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%last_name%% = The last name of the customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%full_name%% = The full name ( first & last ) of the customer who purchased the membership subscription.</code></li>' . "\n";
echo '<li><code>%%payer_email%% = The email address of the customer who purchased the membership subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%item_number%% = The item number ( in other words, the membership level: 1, 2, 3 or 4 ) that the subscription is for.</code></li>' . "\n";
echo '<li><code>%%item_name%% = The item name ( in other words, the associated membership level label that briefly describes the item number ).</code></li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>Custom replacement codes can also be inserted using these instructions:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%cv0%% = The domain of your site, which is passed through to PayPal® using the `custom` field in your PayPal® button code.</code></li>' . "\n";
echo '<li><code>%%cv1%% = If you need to track additional custom variables, you can pipe delimit them into the `custom` field of your button code like this: &lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3" /&gt;. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</code></li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>This example uses cv1 to track a user\'s IP address:</strong><br />' . "\n";
echo '<em>( The IP address can be referenced in your Pixel Code using %%cv1%% )</em><br />' . "\n";
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
echo '<div class="ws-menu-page-group" title="Other Methods Available">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-other-methods-section">' . "\n";
echo '<h3>Other Methods Are Available As Well</h3>' . "\n";
echo '<p>You may also want to check the s2Member API Notifications panel. You\'ll find additional layers of automation available through the use of the `Signup`, `Payment`, `EOT/Deletion` and `Refund/Reversal` notifications that are available to you through the s2Member API. These make it easy to integrate with 3rd party applications like affiliate programs and other back-office routines. Since the s2Member API Notifications operate silently on the back-end, in conjunction with the PayPal® IPN system, they tend to be more reliable and also more versatile. That being said, nothing really replaces the simplicity of using Pixel Tracking, and the s2Member API Notifications are not necessarily the best tool for the job in all cases. For instance, API Notifications will NOT work with Google® Analytics, or 1 pixel &lt;img&gt; tags. They operate silently behind-the-scenes, using cURL connections, as opposed to being loaded in a browser.</p>' . "\n";
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