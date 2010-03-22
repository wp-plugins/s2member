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
if (realpath(__FILE__) === realpath($_SERVER["SCRIPT_FILENAME"]))
	exit;
/*
Advanced scripting page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value("Plugin URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member Advanced Scripting</h2>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<table class="ws-menu-page-table">' . "\n";
echo '<tbody class="ws-menu-page-table-tbody">' . "\n";
echo '<tr class="ws-menu-page-table-tr">' . "\n";
echo '<td class="ws-menu-page-table-l">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-api-easy-way-section">' . "\n";
echo '<h3>The Extremely Easy Way ( no scripting required )</h3>' . "\n";
echo '<p>From your s2Member General Options panel, you may restrict access to certain Posts, Pages, Tags, Categories, and/or URIs based on a User\'s membership level. The s2Member Options panel makes it easy for you. All you do is type in the basics of what you want to restrict access to, and those sections of your site will be off limits to non-members. That being said, there are times when you might need to have greater control over which portions of your site can be viewed by non-members. This is where advanced scripting comes in.</p>' . "\n";
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-hr ws-plugin--s2member-api-advanced-way-section-hr"></div>' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-api-advanced-way-section">' . "\n";
echo '<h3>The Advanced Way ( some PHP scripting required )</h3>' . "\n";
echo '<p>In an effort to give you even more control over access restrictions, s2Member makes a special PHP function available to you from within WordPress®. The function is named <strong>current_user_can()</strong>. To make use of this function, please follow our PHP code samples below. Using PHP, you can control access to certain portions of your content, and even build conditionals within your content based on a User\'s member level. If you\'re unable to use PHP scripting inside your Posts or Pages, you might want to install this handy plugin ( <a href="http://wordpress.org/extend/plugins/exec-php/" target="_blank">Exec-PHP</a> ).</p>' . "\n";
echo '<p><strong>Here are some examples of how you could use the `current_user_can` function in PHP scripting:</strong></p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/cur-samps.php"), true) . '</p>' . "\n";
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-hr ws-plugin--s2member-api-constants-section-hr"></div>' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-api-constants-section">' . "\n";
echo '<h3>You Also Have Access To PHP Constants ( some PHP scripting required )</h3>' . "\n";
echo '<p>A constant is an identifier ( name ) for a simple value in PHP scripting. Below is a comprehensive list that includes all PHP defined constants that are available to you. All of these Constants are also available through JavaScript as global variables. Example code has been provided in the documenation below. If you\'re a web developer, we suggest using some of these Constants in the creation of the Login Welcome Page described in the s2Member General Options panel. It is not required mind you, but you can get pretty creative with the Login Welcome Page if you know a little PHP. For example, you might use `S2MEMBER_CURRENT_USER_ACCESS_LABEL` to display the type of membership the User currently has. Or you could use `S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL` to provide the user with a really easy way to update their Membership Profile. If you get stuck on this, you might want to check out ELance.com. You can hire a freelancer to do this for you. It\'s about a $100 job. There are many other possibilities available as well; <em>limitless actually!</em></p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_IS_LOGGED_IN</strong> = This will always be (bool) true or false. True if a user is currently logged in with a level of 1 or higher.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_is_logged_in.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_ACCESS_LEVEL</strong> = This will always be (int) -1 thru 4. -1 if not logged in. 0 if logged in without access.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_access_level.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_ACCESS_LABEL</strong> = This will always be a (string). Empty if not logged in.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_access_label.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_SUBSCR_ID</strong> = This will always be a (string). Empty if not logged in.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_subscr_id.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_CUSTOM</strong> = This will always be a (string). Empty if not logged in.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_custom.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_DISPLAY_NAME</strong> = This will always be a (string). Empty if not logged in.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_display_name.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_FIRST_NAME</strong> = This will always be a (string). Empty if not logged in.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_first_name.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_LAST_NAME</strong> = This will always be a (string). Empty if not logged in.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_last_name.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_LOGIN</strong> = This will always be a (string). Empty if not logged in.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_login.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_EMAIL</strong> = This will always be a (string). Empty if not logged in.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_email.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_IP</strong> = This will always be a (string). Empty if browsing anonymously.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_ip.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_ID</strong> = This will always be an (int). However, it will be 0 if not logged in.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_id.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED</strong> = This will always be an (int) value >= 0 where 0 means no access.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_downloads_allowed.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_IS_UNLIMITED</strong> = This will always be (bool) true or false. A value of true means their allowed downloads are >= 999999999, and false means it is not. This is useful if you are allowing unlimited ( 999999999 ) downloads on some membership levels. You can display `Unlimited` instead of a number.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_downloads_allowed_is_unlimited.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY</strong> = This will always be an (int) value >= 0 where 0 means none.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_downloads_currently.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS</strong> = This will always be an (int) value >= 0 where 0 means no access.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_downloads_allowed_days.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL</strong> = This is where a user can modify their profile. ( window.open is suggested ).</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/current_user_profile_modification_page_url.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_URL</strong> = This is the full URL to the Limit Exceeded Page ( informational ).<br />' . "\n";
echo '<strong>S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_ID</strong> = This is the Page ID that was used to generate the full URL.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/file_download_limit_exceeded_page_url.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_URL</strong> = This is the full URL to the Membership Options Page ( the signup page ).<br />' . "\n";
echo '<strong>S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_ID</strong> = This is the Page ID that was used to generate the full URL.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/membership_options_page_url.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LOGIN_WELCOME_PAGE_URL</strong> = This is the full URL to the Login Welcome Page ( the user\'s account page ).<br />' . "\n";
echo '<strong>S2MEMBER_LOGIN_WELCOME_PAGE_ID</strong> = This is the Page ID that was used to generate the full URL.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/login_welcome_page_url.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LOGIN_PAGE_URL</strong> = This is the full URL to the Membership Login Page ( the wordpress login page ).</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/login_page_url.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LOGOUT_PAGE_URL</strong> = This is the full URL to the Membership Logout Page ( the wordpress logout page ).</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/logout_page_url.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL1_LABEL</strong> = This is the (string) label that you created for membership level number 1.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/level1_label.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL2_LABEL</strong> = This is the (string) label that you created for membership level number 2.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/level2_label.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL3_LABEL</strong> = This is the (string) label that you created for membership level number 3.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/level3_label.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL4_LABEL</strong> = This is the (string) label that you created for membership level number 4.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/level4_label.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED</strong> = This is the (int) allowed downloads for level number 1.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/level1_file_downloads_allowed.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED</strong> = This is the (int) allowed downloads for level number 2.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/level2_file_downloads_allowed.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED</strong> = This is the (int) allowed downloads for level number 3.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/level3_file_downloads_allowed.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED</strong> = This is the (int) allowed downloads for level number 4.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/level4_file_downloads_allowed.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED_DAYS</strong> = This is the (int) allowed download days for level number 1.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/level1_file_downloads_allowed_days.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED_DAYS</strong> = This is the (int) allowed download days for level number 2.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/level2_file_downloads_allowed_days.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED_DAYS</strong> = This is the (int) allowed download days for level number 3.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/level3_file_downloads_allowed_days.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED_DAYS</strong> = This is the (int) allowed download days for level number 4.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/level4_file_downloads_allowed_days.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_REG_EMAIL_FROM_NAME</strong> = This is the name that outgoing email messages are sent by.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/reg_email_from_name.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_REG_EMAIL_FROM_EMAIL</strong> = This is the email address that outgoing messages are sent by.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/reg_email_from_email.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_PAYPAL_NOTIFY_URL</strong> = This is the URL on your system that receives PayPal IPN responses.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/paypal_notify_url.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_PAYPAL_RETURN_URL</strong> = This is the URL on your system that receives PayPal return variables.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/paypal_return_url.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_PAYPAL_ENDPOINT</strong> = This is the endpoint domain to the paypal server.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/paypal_endpoint.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_PAYPAL_BUSINESS</strong> = This is the email address that identifies your paypal business.</p>' . "\n";
echo '<p>' . highlight_string(file_get_contents(dirname(__FILE__) . "/con-samps/paypal_business.php"), true) . '</p>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-hr ws-plugin--s2member-api-js-globals-section-hr"></div>' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-api-js-globals-section">' . "\n";
echo '<h3>You Also Have Access To JS Globals ( some scripting required )</h3>' . "\n";
echo '<p>All of the PHP Constants are also available through JavaScript as global variables.</p>' . "\n";
echo '</div>' . "\n";
/**/
echo '</td>' . "\n";
/**/
echo '<td class="ws-menu-page-table-r">' . "\n";
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["tools"]) ? '<div class="ws-menu-page-tools"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-tools.png" alt="." /></div>' . "\n" : '';
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["tips"]) ? '<div class="ws-menu-page-tips"><a href="' . ws_plugin__s2member_parse_readme_value("Customization URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-tips.png" alt="." /></a></div>' . "\n" : '';
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["donations"]) ? '<div class="ws-menu-page-donations"><a href="' . ws_plugin__s2member_parse_readme_value("Donate link") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-donations.jpg" alt="." /></a></div>' . "\n" : '';
/**/
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
/**/
echo '</div>' . "\n";
?>