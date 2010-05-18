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
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member API / Tracking</h2>' . "\n";
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
echo '<div class="ws-menu-page-group" title="Membership Signup Tracking Codes">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-signup-tracking-section">' . "\n";
echo '<h3>Membership Signup Tracking Codes ( optional )</h3>' . "\n";
echo '<p>If you use affiliate software, a list server, tracking codes from advertising networks, or the like; you\'ll want to read this section. The HTML' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["is_wpmu_farm"]) ? ' and/or PHP' : '') . ' code that you enter below, will be loaded up in a web browser, after a Customer returns from a successful Signup through PayPal®. Tracking Codes are only displayed/processed one time for each Customer. s2Member will display your Tracking Codes in one of three possible locations... <strong>1.</strong> If possible, on the Registration Form, after returning from PayPal®. <strong>2.</strong> Otherwise, if possible, on the Login Form after Registration is completed. <strong>3.</strong> Otherwise, in the footer of your WordPress® theme, after the Customer\'s very first Login.</p>' . "\n";
echo '<p>Signup Tracking Codes are displayed for all types of Membership Level Access. Including: Recurring Subscriptions ( with or without a free trial period ), Non-Recurring Subscriptions ( with or without a free trial period ), Lifetime Subscriptions, and even Fixed-Term Subscriptions. All of these are supported by s2Member\'s Button Generator, and all of these are supported here.</p>' . "\n";
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-signup-tracking-codes">' . "\n";
echo 'Integrate Signup Tracking Codes:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<textarea name="ws_plugin__s2member_signup_tracking_codes" id="ws-plugin--s2member-signup-tracking-codes" rows="8" wrap="off" spellcheck="false" style="font-family:Consolas, monospace;">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["signup_tracking_codes"]) . '</textarea><br />' . "\n";
echo 'Any valid XHTML / JavaScript' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["is_wpmu_farm"]) ? ' ( or even PHP )' : '') . ' code will work just fine here. Just try not to put anything here that would actually be visible to the Customer. Things like 1x1 pixel images that load up silently and/or JavaScript tracking routines will be fine. Google® Analytics code works just fine, AdSense® performance tracking, as well as Yahoo® tracking and other affiliate network codes are all OK here.<br /><br />' . "\n";
echo '<strong>You can also use these special replacement codes if you need them:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%subscr_id%% = The PayPal® Subscription ID, which remains constant throughout any &amp; all future payments.</code> [ <a href="#" onclick="alert(\'There is one exception. If you are selling Lifetime or Fixed-Term ( non-recurring ) access, using a Buy It Now button; the %%subscr_id%% is actually set to the Transaction ID for the purchase.\\n\\nPayPal® does not provide a specific Subscription ID for Buy It Now purchases. Since Lifetime &amp; Fixed-Term Subscriptions are NOT recurring ( i.e. there is only ONE payment ), using the Transaction ID as the Subscription ID is a graceful way to deal with this minor conflict.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%initial%% = The Initial Fee charged during signup. If you offered a free trial, this will be 0.</code> [ <a href="#" onclick="alert(\'This will always represent the amount of money the Customer spent, whenever they initially signed up, no matter what. If a Customer signs up, under the terms of a free trial period, this will be 0.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%regular%% = The Regular Amount of the Subscription. This value is always > 0, no matter what.</code> [ <a href="#" onclick="alert(\'This is how much the Subscription costs after an initial period expires. The %%regular%% rate is always > 0. If you did not offer an initial period, %%initial%% and %%regular%% will be equal to the same thing.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%recurring%% = This is the amount that will be charged on a Recurring basis, or 0 if non-Recurring.</code> [ <a href="#" onclick="alert(\'If recurring payments have not been required, this will be equal to 0. That being said, %%regular%% &amp; %%recurring%% are usually the same value. This variable can be used in two different ways. You can use it to determine what the regular recurring rate is, or to determine whether the Subscription will recur or not. If it is going to recur, %%recurring%% will be > 0.\\n\\nThe only time this is NOT equal to the %%regular%% rate, is when recurring payments are not required; and only a one-time regular rate applies.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%first_name%% = The First Name of the Customer who purchased the Membership Subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%last_name%% = The Last Name of the Customer who purchased the Membership Subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%full_name%% = The Full Name ( First & Last ) of the Customer who purchased the Membership Subscription.</code></li>' . "\n";
echo '<li><code>%%payer_email%% = The Email Address of the Customer who purchased the Membership Subscription through PayPal®.</code></li>' . "\n";
echo '<li><code>%%item_number%% = The Item Number ( colon separated <em>level:custom_capabilities:fixed term</em> ) that the Subscription is for.</code></li>' . "\n";
echo '<li><code>%%item_name%% = The Item Name ( in other words, the associated membership Level Label that briefly describes the Item Number ).</code></li>' . "\n";
echo '<li><code>%%initial_term%% = This is the term length of the initial period. This will be a numeric value, followed by a space, then a single letter.</code> [ <a href="#" onclick="alert(\'Here are some examples:\\n\\n%%initial_term%% = 1 D ( this means 1 Day )\\n%%initial_term%% = 1 W ( this means 1 Week )\\n%%initial_term%% = 1 M ( this means 1 Month )\\n%%initial_term%% = 1 Y ( this means 1 Year )\\n\\nThe initial period never recurs, so this only lasts for the term length specified, then it is over. If no initial period was even offered, the value of %%initial_term%% will just be: 0 D, meaning zero days.\'); return false;">?</a> ]</li>' . "\n";
echo '<li><code>%%regular_term%% = This is the term length of the regular period. This will be a numeric value, followed by a space, then a single letter.</code> [ <a href="#" onclick="alert(\'Here are some examples:\\n\\n%%regular_term%% = 1 D ( this means 1 Day )\\n%%regular_term%% = 1 W ( this means 1 Week )\\n%%regular_term%% = 1 M ( this means 1 Month )\\n%%regular_term%% = 1 Y ( this means 1 Year )\\n%%regular_term%% = 1 L ( this means 1 Lifetime )\\n\\nThe regular term is usually recurring. So the regular term value represents the period ( or duration ) of each recurring period. If %%recurring%% = 0, then the regular term only applies once, because it is not recurring. So if it is not recurring, the value of %%regular_term%% simply represents how long their membership privileges are going to last after the %%initial_term%% has expired, if there was an initial term. The value of this variable ( %%regular_term%% ) will never be empty, it will always be at least: 1 D, meaning 1 day. No exceptions.\'); return false;">?</a> ]</li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>Custom replacement codes can also be inserted using these instructions:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%cv0%% = The domain of your site, which is passed through to PayPal® using the `custom` field in your PayPal® Button Code.</code></li>' . "\n";
echo '<li><code>%%cv1%% = If you need to track additional custom variables, you can pipe delimit them into the `custom` field of your Button Code like this: &lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3" /&gt;. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</code></li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>This example uses cv1 to track a User\'s IP address:</strong><br />' . "\n";
echo '<em>( The IP address could be referenced in your Tracking Code using %%cv1%% )</em><br />' . "\n";
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
echo '<div class="ws-menu-page-group" title="Specific Post/Page Tracking Codes">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-sp-tracking-section">' . "\n";
echo '<h3>Tracking Codes For Specific Post/Page Access ( optional )</h3>' . "\n";
echo '<p>If you use affiliate software, a list server, tracking codes from advertising networks, or the like; you\'ll want to read this section. The HTML' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["is_wpmu_farm"]) ? ' and/or PHP' : '') . ' code that you enter below, will be loaded up in a web browser, after a Customer returns from a successful transaction at PayPal®; specifically for Post/Page Access. These Codes are NOT injected for any type of Member Level Access. These are only for Specific Post/Page transactions. The Tracking Codes that you enter below, will be displayed in the footer section of your WordPress® theme, after a Customer returns from PayPal®.</p>' . "\n";
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-sp-tracking-codes">' . "\n";
echo 'Specific Post/Page Tracking Codes:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<textarea name="ws_plugin__s2member_sp_tracking_codes" id="ws-plugin--s2member-sp-tracking-codes" rows="8" wrap="off" spellcheck="false" style="font-family:Consolas, monospace;">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_tracking_codes"]) . '</textarea><br />' . "\n";
echo 'Any valid XHTML / JavaScript' . ((!$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["is_wpmu_farm"]) ? ' ( or even PHP )' : '') . ' code will work just fine here. Just try not to put anything here that would actually be visible to the Customer. Things like 1x1 pixel images that load up silently and/or JavaScript tracking routines will be fine. Google® Analytics code works just fine, AdSense® performance tracking, as well as Yahoo® tracking and other affiliate network codes are all OK here.<br /><br />' . "\n";
echo '<strong>You can also use these special replacement codes if you need them:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%txn_id%% = The PayPal® Transaction ID. PayPal® assigns a unique identifier for every purchase.</code></li>' . "\n";
echo '<li><code>%%amount%% = The full Amount that you charged for Specific Post/Page Access. This value will always be > 0.</code></li>' . "\n";
echo '<li><code>%%first_name%% = The First Name of the Customer who purchased Specific Post/Page Access through PayPal®.</code></li>' . "\n";
echo '<li><code>%%last_name%% = The Last Name of the Customer who purchased Specific Post/Page Access through PayPal®.</code></li>' . "\n";
echo '<li><code>%%full_name%% = The Full Name ( First & Last ) of the Customer who purchased Specific Post/Page Access.</code></li>' . "\n";
echo '<li><code>%%payer_email%% = The Email Address of the Customer who purchased Specific Post/Page Access through PayPal®.</code></li>' . "\n";
echo '<li><code>%%item_number%% = The Item Number. Ex: <em>sp:13,24,36:72</em> ( translates to: <em>sp:comma-delimited IDs:expiration hours</em> ).</code></li>' . "\n";
echo '<li><code>%%item_name%% = The Item Name. In other words, a brief description, detailing what this purchase was for.</code></li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>Custom replacement codes can also be inserted using these instructions:</strong>' . "\n";
echo '<ul>' . "\n";
echo '<li><code>%%cv0%% = The domain of your site, which is passed through to PayPal® using the `custom` field in your PayPal® Button Code.</code></li>' . "\n";
echo '<li><code>%%cv1%% = If you need to track additional custom variables, you can pipe delimit them into the `custom` field of your Button Code like this: &lt;input type="hidden" name="custom" value="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3" /&gt;. You can have an unlimited number of custom variables that track IP addresses, affiliate IDs, etc. In some cases you may need to use PHP code to insert a value into the custom field dynamically. Obviously this is for advanced webmasters, but the functionality has been made available for those who need it.</code></li>' . "\n";
echo '</ul>' . "\n";
echo '<strong>This example uses cv1 to track a User\'s IP address:</strong><br />' . "\n";
echo '<em>( The IP address could be referenced in your Tracking Code using %%cv1%% )</em><br />' . "\n";
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
echo '<div class="ws-menu-page-group" title="Integrating iDevAffiliate® Software">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-idev-section">' . "\n";
echo '<h3>Integrating iDevAffiliate® ( affiliate program management )</h3>' . "\n";
echo '<a href="http://www.idevdirect.com/14200.html" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/idev-logo.gif" class="ws-menu-page-right" style="width:125px; height:125px; border:0;" alt="." /></a>' . "\n";
echo '<p>Adding affiliate tracking software to your site is one of the most effective ways to achieve more sales, more traffic, and more search engine ranking. <a href="http://www.idevdirect.com/14200.html" target="_blank" rel="external">iDevAffiliate®</a> ( an affiliate management portal ), installs in just minutes, and can be integrated seamlessly with s2Member. We recommend <a href="http://www.idevdirect.com/14200.html" target="_blank" rel="external">iDevAffiliate® Standard</a> ( $99 ) because of its proven track record, and its ability to integrate with s2Member using a variety of techniques. The most popular being a Hidden Image Tag.</p>' . "\n";
echo '<p>If you choose to <a href="http://www.idevdirect.com/14200.html" target="_blank" rel="external">install iDevAffiliate®</a>, you will need to configure your <code>iDevAffiliate® -> Shopping Cart Integration</code>. Please choose <code>Generic Tracking Pixel</code>. Then, grab your Hidden Image Tag, and pop the code provided by iDevAffiliate® into the Custom Tracking field at the top of this page. You MUST also add replacement codes to your Hidden Image Tag. To save you some trouble, we\'ve provided two examples below. The first example is for Signup Tracking ( Membership Access ), and the second example is for Specific Post/Page Tracking. The variables are different, depending on which type of transaction you\'re tracking.</p>' . "\n";
echo '<div class="ws-menu-page-hr"></div>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/idev-signup-tracking-code.php"), true) . '</p>' . "\n";
echo '<div class="ws-menu-page-hr"></div>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/idev-sp-tracking-code.php"), true) . '</p>' . "\n";
echo '<div class="ws-menu-page-hr"></div>' . "\n";
echo '<p>Your <code>profile</code> ID will be assigned by iDevAffiliate®. Be sure to replace <code>profile=123</code> with your own profile ID.</p>' . "\n";
echo '<p><em><strong>*Tip*</strong> iDevAffiliate® also provides an alternative method, using a 3rd-party call. The alternative 3rd-party call, could be used with <code>s2Member -> API Notifications.</code> A 3rd-party call, is essentially an HTTP connection that runs silently behind-the-scene, as opposed to being loaded in a browser. It\'s a bit more powerful, but also more advanced.</em></p>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Integrating ShareASale® Tracking">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-shareasale-section">' . "\n";
echo '<h3>Integrating ShareASale® ( affiliate program management )</h3>' . "\n";
echo '<a href="http://www.shareasale.com/merchantsignup.cfm" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/sas-logo.png" class="ws-menu-page-right" style="width:125px; height:125px; border:0;" alt="." /></a>' . "\n";
echo '<p>Established in 2000, <a href="http://www.shareasale.com/merchantsignup.cfm" target="_blank" rel="external">ShareASale®</a> provides award winning technology and service; which will enable you to connect with a network of established affiliates, as well as recruit new ones. Joining ShareASale®, maximizes your ability to reach the greatest number of affiliates, with the least amount of work. At ShareASale®, you\'ll have access to an existing affiliate-base. You place your site on the market, and let their existing affiliates promote your products/services.</p>' . "\n";
echo '<p>If you <a href="http://www.shareasale.com/merchantsignup.cfm" target="_blank" rel="external">become a Merchant at ShareASale®</a>, you will need to configure your <code>ShareASale® -> Sale Tracking</code>. Grab your Hidden Image Tag, and pop the code provided by ShareASale® into the Custom Tracking field at the top of this page. You MUST also add replacement codes to your Hidden Image Tag. To save you some trouble, we\'ve provided two examples below. The first example is for Signup Tracking ( Membership Access ), and the second example is for Specific Post/Page Tracking. The variables are different, depending on which type of transaction you\'re tracking.</p>' . "\n";
echo '<div class="ws-menu-page-hr"></div>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/sas-signup-tracking-code.php"), true) . '</p>' . "\n";
echo '<div class="ws-menu-page-hr"></div>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/sas-sp-tracking-code.php"), true) . '</p>' . "\n";
echo '<div class="ws-menu-page-hr"></div>' . "\n";
echo '<p>Your <code>merchantID</code> will be assigned by ShareASale®. Be sure to replace <code>merchantID=123</code> with the one they assign you.</p>' . "\n";
echo '<p><em><strong>*Tip*</strong> ShareASale® also provides an alternative method, using a 3rd-party call. The alternative 3rd-party call, could be used with <code>s2Member -> API Notifications.</code> A 3rd-party call, is essentially an HTTP connection that runs silently behind-the-scene, as opposed to being loaded in a browser. It\'s a bit more powerful, but also more advanced.</em></p>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Other Tracking Methods Available">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-other-methods-section">' . "\n";
echo '<h3>Other Tracking Methods Are Available ( there\'s always a way )</h3>' . "\n";
echo '<p>Check the s2Member API Notifications panel. You\'ll find additional layers of automation available through the use of the `Signup`, `Registration`, `Payment`, `EOT/Deletion`, `Refund/Reversal`, and `Specific Post/Page` notifications that are available to you through the s2Member API. The s2Member API Notifications make it possible to integrate with 3rd party applications; like list servers, affiliate programs, and other back-office routines; in more advanced ways. Since the s2Member API Notifications operate silently on the back-end, in conjunction with the PayPal® IPN system, they tend to be more reliable and also more versatile. That being said, nothing replaces the simplicity of Tracking Codes. The more advanced API Notifications are NOT always the best tool for the job. For instance, API Notifications will NOT work with Google® Analytics, or 1 pixel &lt;img&gt; tags. They operate silently behind-the-scene, using cURL connections, as opposed to being loaded in a browser.</p>' . "\n";
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
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["installation"]) ? '<div class="ws-menu-page-installation"><a href="' . ws_plugin__s2member_parse_readme_value ("Professional Installation URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-installation.png" alt="." title="Contact PriMoThemes!" /></a></div>' . "\n" : '';
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["tools"]) ? '<div class="ws-menu-page-tools"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-tools.png" alt="." /></div>' . "\n" : '';
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["support"]) ? '<div class="ws-menu-page-support"><a href="' . ws_plugin__s2member_parse_readme_value ("Forum URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-support.png" alt="." /></a></div>' . "\n" : '';
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["donations"]) ? '<div class="ws-menu-page-donations"><a href="' . ws_plugin__s2member_parse_readme_value ("Donate link") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-donations.jpg" alt="." /></a></div>' . "\n" : '';
/**/
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
/**/
echo '</div>' . "\n";
?>