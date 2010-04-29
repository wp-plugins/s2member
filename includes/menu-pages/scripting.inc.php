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
API Scripting page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member API / Scripting</h2>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<table class="ws-menu-page-table">' . "\n";
echo '<tbody class="ws-menu-page-table-tbody">' . "\n";
echo '<tr class="ws-menu-page-table-tr">' . "\n";
echo '<td class="ws-menu-page-table-l">' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="The Extremely Easy Way">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-api-easy-way-section">' . "\n";
echo '<h3>The Extremely Easy Way ( no scripting required )</h3>' . "\n";
echo '<p>From your s2Member General Options Panel, you may restrict access to certain Posts, Pages, Tags, Categories, and/or URIs based on a Member\'s Level. The s2Member Options Panel makes it easy for you. All you do is type in the basics of what you want to restrict access to, and those sections of your site will be off limits to non-Members. That being said, there are times when you might need to have greater control over which portions of your site can be viewed by non-Members, or Members at different Levels. This is where API Scripting with Advanced Conditionals comes in.</p>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Using Advanced Conditionals">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-api-advanced-way-section">' . "\n";
echo '<h3>The Advanced Way ( some PHP scripting required )</h3>' . "\n";
echo '<p>In an effort to give you even more control over access restrictions, s2Member makes some PHP functions, and also some PHP Constants, available to you from within WordPress®. In this section, we\'ll demonstrate two functions: <strong><code>is_user_logged_in()</code></strong> &amp; <strong><code>current_user_can()</code></strong>. To make use of these functions, please follow our PHP code samples below. Using PHP, you can control access to certain portions of your content, and even build Advanced Conditionals within your content, based on a Members\'s Level. In order to use PHP scripting inside your Posts/Pages, you\'ll need to install this handy plugin ( <a href="http://wordpress.org/extend/plugins/exec-php/" target="_blank" rel="xlink">Exec-PHP</a> ).</p>' . "\n";
echo '<p><strong>Example #1:</strong> Full access for anyone that is logged in.</strong></p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/is-user-logged-in.php"), true) . '</p>' . "\n";
echo '<p><strong>Example #2:</strong> Full access for any Member with a Level >= 1.</strong></p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-can-full-access.php"), true) . '</p>' . "\n";
echo '<p><strong>Example #3:</strong> Specific content for each different Member Level.</strong></p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-can-specific-content.php"), true) . '</p>' . "\n";
echo '<p><strong>Example #4:</strong> Uses s2Member API Constants, instead of functions.</strong></p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-can-constants-1.php"), true) . '</p>' . "\n";
echo '<p><strong>Example #5:</strong> Uses s2Member API Constants, instead of functions.</strong></p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-can-constants-2.php"), true) . '</p>' . "\n";
echo '<p><strong>Membership Levels provide incremental access:</strong></p>' . "\n";
echo '<p>* A Member with Level 4 access, will also be able to access Levels 1, 2 &amp; 3.<br />* A Member with Level 3 access, will also be able to access Levels 1 &amp; 2.<br />* A Member with Level 2 access, will also be able to access Level 1.<br />* A Member with Level 1 access, will ONLY be able to access Level 1.</p>' . "\n";
echo '<p><em>* WordPress® Administrators, Editors, Authors, and Contributors have Level 4 access, with respect to s2Member. All of their other Roles/Capabilities are left untouched.</em></p>' . "\n";
echo '<p><em>* WordPress® Subscribers are NOT allowed Membership access, with respect to s2Member. They must be promoted to a Member. However, if you set `Allow Free Subscribers` to <code>Yes</code>, then Free Subscribers WILL be allowed to access your Login Welcome Page, <strong>but that is all</strong>. See `s2Member -> General Options -> Login Welcome Page` to learn more about this option. If you would like to extend additional access to Free Subscribers ( and/or other Levels ), use the examples above, to customize your Login Welcome Page; based on Membership Level.</em></p>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Packaging Custom Capabilities">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-custom-capabilities-section">' . "\n";
echo '<h3>Packaging Together Custom Capabilities w/ Membership</h3>' . "\n";
echo '<p>Using the PayPal® Button Generator for s2Member, you can add Custom Capabilities in comma delimited format. s2Member builds upon existing functionality offered by WordPress® Roles/Capabilities. s2Member supports up to four Primary Roles ( i.e. s2Member Levels 1-4 ). Each s2Member Level provides <code>current_user_can("access_s2member_level1"), 2, 3, 4</code>. These are the default Capabilities that come with each Membership Level. Now... If you\'d like to package together some variations of each Membership Level that you\'re selling, you can! All you do is add some Custom Capabilities whenever you create your PayPal® Button Code ( <em>there is a field in the Button Generator where you can enter Custom Capabilities</em> ). You can sell membership packages that come with Custom Capabilities, and even with custom prices.</p>' . "\n";
echo '<p>Custom Capabilities are an extension to a feature that already exists in WordPress®. The <code>current_user_can()</code> function, can be used to test for these additional Capabilities that you allow. Whenever a Member completes the checkout process, after having purchased a Membership from you ( one that included Custom Capabilities ), s2Member will add those Custom Capabilities to the account for that specific Member.</p>' . "\n";
echo '<p>Custom Capabilities are always prepended with <code>access_s2member_ccap_</code>. You fill in the last part, with ONLY lowercase alpha-numerics and/or underscores. For example, let\'s say you want to sell Membership Level #1, as is. But, you also want to sell a slight variation of Membership Level #1, that includes the ability to access the Music &amp; Video sections of your site. So, instead of selling this additional access under a whole new Membership Level, you could just sell a modified version of Membership Level #1. Add the the Custom Capabilities: <code>music,videos</code>. Once a Member has these Capabilities, you can test for these Capabilities using <code>current_user_can("access_s2member_ccap_music")</code> and <code>current_user_can("access_s2member_ccap_videos")</code>.</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>Custom Capabilities:</strong> ( music,videos ):</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-can-ccaps-1.php"), true) . '</p>' . "\n";
/**/
echo '<p><strong>Custom Capabilities:</strong> ( ebooks,reports,tips ):</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-can-ccaps-2.php"), true) . '</p>' . "\n";
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p>The important thing to realize, is that Custom Capabilities, are just that. They\'re custom. s2Member only deals with the default Capabilities that it uses. If you start using Custom Capabilities, you MUST use Advanced Conditionals ( <em>i.e. the <code>current_user_can()</code> function</em> ) to test for them. Either in your theme files, or in Posts/Pages using the <a href="http://wordpress.org/extend/plugins/exec-php/" target="_blank" rel="xlink">Exec-PHP</a> plugin.</p>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="s2Member Content Dripping">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-api-advanced-dripping-section">' . "\n";
echo '<h3>Dripping Content ( some PHP scripting required )</h3>' . "\n";
echo '<p>Content Dripping is the gradual, pre-scheduled release of premium website content to paying Members. This has become increasingly popular, because it allows older Members; those who have paid you more, due to recurring charges; to acquire access to more content progressively; based on their original registration date. It also gives you ( as the site owner ), the ability to launch multiple membership site portals, operating on autopilot, without any direct day-to-day involvement in a content release process. This requires some PHP scripting. In order to use PHP scripting inside your Posts/Pages, you\'ll need to install this handy plugin ( <a href="http://wordpress.org/extend/plugins/exec-php/" target="_blank" rel="xlink">Exec-PHP</a> ).</p>' . "\n";
echo '<p><strong>To drip content, use <code>S2MEMBER_CURRENT_USER_REGISTRATION_DAYS</code>:</strong></p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-registration-days-dripping.php"), true) . '</p>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Member Profile Modifications">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-profile-modifications-section">' . "\n";
echo '<h3>Giving Members The Ability To Modify Their Profile</h3>' . "\n";
echo '<p>s2Member can be configured to redirect Members away from the <a href="profile.php" target="_blank" rel="xlink">default Profile Editing Panel</a> that is built into WordPress®. <em>See: <code>s2Member -> General Options -> Profile Modifications</code>.</em> When/if a Member attempts to access the default Profile Editing Panel, they\'ll instead, be redirected to the Login Welcome Page that you\'ve configured through s2Member. <strong>Why would I redirect?</strong> Unless you\'ve made some drastic modifications to your WordPress® installation, the default Profile Editing Panel that ships with WordPress®, is NOT really suited for public access, even by a Member.</p>' . "\n";
echo '<p>So instead of using this default Profile Editing Panel; s2Member creates an added layer of functionality, on top of WordPress®. It does this by providing you ( as the site owner ), with the ability to send your Members to a <a href="' . get_bloginfo ("url") . '/?s2member_profile=1" target="_blank" rel="xlink">special Stand-Alone page</a>, where your Members can modify their entire Profile, including all Custom Fields, and their Password. This special Stand-Alone Editing Panel, has been designed ( with a bare-bones format ), intentionally. This makes it possible for you to <a href="#" onclick="if(!window.open(\'' . get_bloginfo ("url") . '/?s2member_profile=1\', \'_popup\', \'height=350,width=400,left=100,screenX=100,top=100,screenY=100, location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1\')) alert(\'Please disable popup blockers and try again!\'); return false;" rel="xlink">open it up in a popup window</a>, or embed it into your Login Welcome Page using an IFRAME. Code samples are provided below.</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL</strong> = URL to a Stand-Alone Profile Editing Panel.</p>' . "\n";
echo '<p>Copy &amp; Paste one of the code snippets below, into your Login Welcome Page, so Members can click a link to Edit their Profile. This requires some PHP scripting. In order to use PHP scripting inside your Posts/Pages, you\'ll need to install this handy plugin ( <a href="http://wordpress.org/extend/plugins/exec-php/" target="_blank" rel="xlink">Exec-PHP</a> ).</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>Code Sample #1</strong> ( standard link tag ):</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-1.php"), true) . '</p>' . "\n";
/**/
echo '<p><strong>Code Sample #2</strong> ( open the link in a popup window ):</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-2.php"), true) . '</p>' . "\n";
/**/
echo '<p><strong>Code Sample #3</strong> ( embed the form into a Post/Page using an IFRAME tag ):</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-3.php"), true) . '</p>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="s2Member PHP/API Constants">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-api-constants-section">' . "\n";
echo '<h3>You Have Access To PHP Constants ( some PHP scripting required )</h3>' . "\n";
echo '<p>A Constant, is an identifier ( name ) for a simple value in PHP scripting. Below is a comprehensive list that includes all of the PHP defined Constants available to you. All of these Constants are also available through JavaScript as Global Variables. Example code has been provided in the documentation below. If you\'re a web developer, we suggest using some of these Constants in the creation of your Login Welcome Page; which is described in the s2Member General Options Panel. It is not required mind you, but you can get pretty creative with the Login Welcome Page, if you know a little PHP.</p>' . "\n";
echo '<p>For example, you might use `S2MEMBER_CURRENT_USER_ACCESS_LABEL` to display the type of membership the Customer has. Or, you could use `S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL` to provide Customers\' with an easy way to update their Membership Profile. If you get stuck on this, you might want to check out Elance.com. You can hire a freelancer to do this for you. It\'s about a $100 job. There are many other possibilities; <em>limitless actually!</em></p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p>Before you read any further, you should install this handy plugin: <a href="http://wordpress.org/extend/plugins/exec-php/" target="_blank" rel="xlink">Exec-PHP</a>.<br />' . "\n";
echo 'You\'ll need to have this plugin installed to use PHP code in Posts/Pages.</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_IS_LOGGED_IN</strong><br />This will always be (bool) true or false. True if a User/Member is currently logged in with an Access Level >= 0.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-is-logged-in.php"), true) . '</p>' . "\n";
echo '<p><em>See <code>S2MEMBER_CURRENT_USER_ACCESS_LEVEL</code> below for a full explanation.</em></p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_IS_LOGGED_IN_AS_MEMBER</strong><br />This will always be (bool) true or false. True if a Member is currently logged in with an Access Level >= 1.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-is-logged-in-as-member.php"), true) . '</p>' . "\n";
echo '<p><em>See <code>S2MEMBER_CURRENT_USER_ACCESS_LEVEL</code> below for a full explanation.</em></p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_ACCESS_LEVEL</strong><br />This will always be (int) -1 thru 4. -1 if not logged in. 0 if logged in as a Free Subscriber.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-access-level.php"), true) . '</p>' . "\n";
echo '<p><strong>Membership Levels provide incremental access:</strong></p>' . "\n";
echo '<p>* A Member with Level 4 access, will also be able to access Levels 1, 2 &amp; 3.<br />* A Member with Level 3 access, will also be able to access Levels 1 &amp; 2.<br />* A Member with Level 2 access, will also be able to access Level 1.<br />* A Member with Level 1 access, will ONLY be able to access Level 1.</p>' . "\n";
echo '<p><em>* WordPress® Administrators, Editors, Authors, and Contributors have Level 4 access, with respect to s2Member. All of their other Roles/Capabilities are left untouched.</em></p>' . "\n";
echo '<p><em>* WordPress® Subscribers are NOT allowed Membership access, with respect to s2Member. They must be promoted to a Member. However, if you set `Allow Free Subscribers` to <code>Yes</code>, then Free Subscribers WILL be allowed to access your Login Welcome Page, <strong>but that is all</strong>. See `s2Member -> General Options -> Login Welcome Page` to learn more about this option. If you would like to extend additional access to Free Subscribers ( and/or other Levels ), see: <code>s2Member -> API Scripting -> Advanced Conditionals</code>, for details on how to customize your Login Welcome Page with Conditionals; based on Membership Level.</em></p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_ACCESS_LABEL</strong><br />This will always be a (string). Empty if not logged in.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-access-label.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_SUBSCR_ID</strong><br />This will always be a (string). Empty if not logged in.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-subscr-id.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_CUSTOM</strong><br />This will always be a (string). Empty if not logged in.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-custom.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_REGISTRATION_TIME</strong><br />This will always be an (int); in the form of a Unix timestamp. 0 if not logged in. This holds the recorded time at which the Member originally registered their Username for access to your site. This is useful if you want to drip content over an extended period of time, based on how long someone has been a Member.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-registration-time.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_REGISTRATION_DAYS</strong><br />This will always be an (int). 0 if not logged in. This is the number of days that have passed since the Member originally registered their Username for access to your site. This is useful if you want to drip content over an extended period of time, based on how long someone has been a Member.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-registration-days.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_DISPLAY_NAME</strong><br />This will always be a (string). Empty if not logged in.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-display-name.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_FIRST_NAME</strong><br />This will always be a (string). Empty if not logged in.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-first-name.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_LAST_NAME</strong><br />This will always be a (string). Empty if not logged in.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-last-name.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_LOGIN</strong><br />This will always be a (string). Empty if not logged in.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-login.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_EMAIL</strong><br />This will always be a (string). Empty if not logged in.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-email.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_IP</strong><br />This will always be a (string). Empty if browsing anonymously.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-ip.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_ID</strong><br />This will always be an (int). However, it will be 0 if not logged in.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-id.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_FIELDS</strong><br />This will always be a JSON encoded array, in (string) format. An empty JSON encoded array, in (string) format, if not logged in. This JSON encoded array will contain the following fields: <code>id, ip, email, login, first_name, last_name, display_name, subscr_id, custom</code>. If you\'ve configured additional Custom Fields, those Custom Fields will also be added to this array. For example, if you configured the Custom Field: <code>Street Address</code>, it would be included in this array as: <code>street_address</code>. Custom Field references are converted to lowercase format, and spaces are replaced by underscores. You can do <code>print_r(json_decode(S2MEMBER_CURRENT_USER_FIELDS, true));</code> to get a full list for testing.</p>' . "\n";
if (defined ("BP_VERSION"))
	echo '<p><em class="ws-menu-page-error">* Custom Fields are N/A when running together with BuddyPress. Instead, use <code>BuddyPress -> Profile Field Setup</code>.</em></p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-fields.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED</strong><br />This will always be an (int) value >= 0 where 0 means no access.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-downloads-allowed.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_IS_UNLIMITED</strong><br />This will always be (bool) true or false. A value of true means their allowed downloads are >= 999999999, and false means it is not. This is useful if you are allowing unlimited ( 999999999 ) downloads on some membership levels. You can display `Unlimited` instead of a number.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-downloads-allowed-is-unlimited.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY</strong><br />This will always be an (int) value >= 0 where 0 means none.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-downloads-currently.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS</strong><br />This will always be an (int) value >= 0 where 0 means no access.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-downloads-allowed-days.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL</strong><br />This is where a Member can modify their Profile.</p>' . "\n";
echo '<p><strong>Code Sample #1</strong> ( standard link ):</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-1.php"), true) . '</p>' . "\n";
echo '<p><strong>Code Sample #2</strong> ( open the link in a popup window ):</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-2.php"), true) . '</p>' . "\n";
echo '<p><strong>Code Sample #3</strong> ( embed the form into a Post/Page using an IFRAME tag ):</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-3.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_URL</strong><br />This is the full URL to the Limit Exceeded Page ( informational ).</p>' . "\n";
echo '<p><strong>S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_ID</strong><br />This is the Page ID that was used to generate the full URL.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/file-download-limit-exceeded-page-url.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_URL</strong><br />This is the full URL to the Membership Options Page ( the signup page ).</p>' . "\n";
echo '<p><strong>S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_ID</strong><br />This is the Page ID that was used to generate the full URL.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/membership-options-page-url.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LOGIN_WELCOME_PAGE_URL</strong><br />This is the full URL to the Login Welcome Page ( the user\'s account page ). * This could also be the full URL to a Special Redirection URL ( if you configured one ). See <code>s2Member -> General Options -> Login Welcome Page</code>.</p>' . "\n";
echo '<p><strong>S2MEMBER_LOGIN_WELCOME_PAGE_ID</strong><br />This is the Page ID that was used to generate the full URL. * In the case of a Special Redirection URL, this ID is not really applicable.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/login-welcome-page-url.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LOGIN_PAGE_URL</strong><br />This is the full URL to the Membership Login Page ( the WordPress® login page ).</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/login-page-url.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LOGOUT_PAGE_URL</strong><br />This is the full URL to the Membership Logout Page ( the WordPress® logout page ).</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/logout-page-url.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL1_LABEL</strong><br />This is the (string) Label that you created for Membership Level 1.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/level1-label.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL2_LABEL</strong><br />This is the (string) Label that you created for Membership Level 2.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/level2-label.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL3_LABEL</strong><br />This is the (string) Label that you created for Membership Level 3.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/level3-label.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL4_LABEL</strong><br />This is the (string) Label that you created for Membership Level 4.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/level4-label.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED</strong><br />This is the (int) allowed downloads for Level 1.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/level1-file-downloads-allowed.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED</strong><br />This is the (int) allowed downloads for Level 2.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/level2-file-downloads-allowed.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED</strong><br />This is the (int) allowed downloads for Level 3.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/level3-file-downloads-allowed.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED</strong><br />This is the (int) allowed downloads for Level 4.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/level4-file-downloads-allowed.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED_DAYS</strong><br />This is the (int) allowed download days for Level 1.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/level1-file-downloads-allowed-days.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED_DAYS</strong><br />This is the (int) allowed download days for Level 2.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/level2-file-downloads-allowed-days.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED_DAYS</strong><br />This is the (int) allowed download days for Level 3.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/level3-file-downloads-allowed-days.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED_DAYS</strong><br />This is the (int) allowed download days for Level 4.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/level4-file-downloads-allowed-days.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_REG_EMAIL_FROM_NAME</strong><br />This is the Name that outgoing email messages are sent by.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/reg-email-from-name.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_REG_EMAIL_FROM_EMAIL</strong><br />This is the Email Address that outgoing messages are sent by.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/reg-email-from-email.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_PAYPAL_NOTIFY_URL</strong><br />This is the URL on your system that receives PayPal® IPN responses.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/paypal-notify-url.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_PAYPAL_RETURN_URL</strong><br />This is the URL on your system that receives PayPal® return variables.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/paypal-return-url.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_PAYPAL_ENDPOINT</strong><br />This is the Endpoint Domain to the PayPal® server.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/paypal-endpoint.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_PAYPAL_BUSINESS</strong><br />This is the Email Address that identifies your PayPal® Business.</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/paypal-business.php"), true) . '</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p><strong>S2MEMBER_CURRENT_USER_VALUE_FOR_PP_ON0</strong><br />This auto-fills the <code>on0</code> value in PayPal® Button Codes.<br />If a Button Code is presented to a logged-in Member, this will auto-fill the value for the <code>on0</code> input variable, with the string: <code>"Updating Subscr"</code>. Otherwise, it will be an empty string.</p>' . "\n";
echo '<p><strong>S2MEMBER_CURRENT_USER_VALUE_FOR_PP_OS0</strong><br />This auto-fills the <code>os0</code> value in PayPal® Button Codes.<br />If a Button Code is presented to a logged-in Member, this will auto-fill the value for the <code>os0</code> input variable, with the value of <code>S2MEMBER_CURRENT_USER_SUBSCR_ID</code>. Otherwise, it will be an empty string.</p>' . "\n";
echo '<p>These two Constants are special. They are used by the PayPal® Button Generator for s2Member. This is how s2Member identifies an existing Member ( and/or a Free Subscriber ), who is already logged in when they click a PayPal® Modification Button that was generated for you by s2Member. Instead of forcing a Member ( and/or a Free Subscriber ) to re-register for a new account, s2Member can identify their existing account, and update it, according to the modified terms in your Button Code. These three Button Code parameters: <code>on0, os0, modify</code>, work together in harmony. If you\'re using the Shortcode Format for PayPal® Buttons ( recommended ), you won\'t even see these, because they\'re added internally by the Shortcode processor. Anyway, they\'re just documented here for clarity; you probably won\'t use these directly; the Button Code Generator pops them in.</p>' . "\n";
echo '<p><em>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-value-for-pp-on0-os0.php"), true) . '</em></p>' . "\n";
echo '<p>If you\'d like to give your Members ( and/or your Free Subscribers ) the ability to modify their billing plan, by switching to a more expensive option, or a less expensive option; generate a new PayPal® Modification Button, using the s2Member PayPal® Button Generator. Configure the updated Level, pricing, terms, etc. Then, make that new Modification Button available to Members who are logged into their existing account with you. For example, you might want to insert a "Level #2" Upgrade Button into your Login Welcome Page, which would up-sell existing Level #1 Members to a more expensive plan that you offer.</p>' . "\n";
echo '<p><em><strong>*Modification Process*</strong> When you send a Member to PayPal® using a Subscription Modification Button, PayPal® will ask them to login. Once they\'re logged in, instead of being able to signup for a new membership, PayPal® will provide them with the ability to upgrade and/or downgrade their existing membership with you, by allowing them to switch to the Membership Plan that was specified in the Subscription Modification Button. PayPal® handles this nicely, and you\'ll be happy to know that s2Member has been pre-configured to deal with this scenario as well, so that everything remains automated. Their Membership Access Level will either be promoted, or demoted, based on the actions they took at PayPal® during the modification process. Once an existing Member completes their Subscription Modification at PayPal®, they\'ll be brought back to their Login Welcome Page, instead of the registration screen.</em></p>' . "\n";
echo '<p><em><strong>*Also Works For Free Subscribers*</strong> Although a Free Subscriber does not have an existing PayPal® subscription, s2Member is capable of adapting to this scenario gracefully. Just make sure that your existing Free Subscribers ( the ones who wish to upgrade ) pay for their Membership through a Modification Button generated by s2Member. That will allow them to continue using their existing account with you. In other words, they can keep their existing Username ( and anything already associated with that Username ), rather than being forced to re-register after checkout.</em></p>' . "\n";
echo '<p><em><strong>*Make It More User-Friendly*</strong> You can make the Subscription Modification Process, more user-friendly, by setting up a <a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. You can add your own header image and color selection to the checkout form. Once you\\\'ve created a Custom Page Style at PayPal®, you can tell s2Member to use that Page Style whenever you generate your Button Code. See: s2Member® -> PayPal Buttons.\'); return false;">Custom Page Style at PayPal®</a>, specifically for Subscription Modification Buttons. Use a custom header image, with a brief explanation to the Customer. Something like, "Log into PayPal®", "You can Modify your Subscription!".</em></p>' . "\n";
echo '<p><em><strong>*Conditional Upgrades*</strong> You could also use the API Constant <code>S2MEMBER_CURRENT_USER_ACCESS_LEVEL</code> to build Conditionals that display a specific Modification Button, based on the Membership Level of the currently logged-in Member. This can help you maximize your marketing efforts. In other words, instead of just throwing a single Modification Button out there to everyone, get specific if you need to!</em></p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-access-level-conditional-upgrades.php"), true) . '</p>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="s2Member JS/API Globals">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-api-js-globals-section">' . "\n";
echo '<h3>You Also Have Access To JS Globals ( some JavaScript knowledge required )</h3>' . "\n";
echo '<p>All of the PHP Constants, are also available through JavaScript, as Global Variables ( with the exact same names/types as their PHP counterparts ). s2Member automatically loads it\'s compressed JavaScript API ( only 2kbs ) into your theme for WordPress®. s2Member is very intelligent about the way it loads ( and maintains ) it\'s JavaScript API. You can rely on the JavaScript Globals, the same way you rely on PHP Constants.</p>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
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