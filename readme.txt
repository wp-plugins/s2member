=== s2Member ( Membership w/ PayPal® Integration ) also works w/ BuddyPress ===

Version: 2.8.8
Stable tag: 2.8.8
Framework: WS-P-2.1

WordPress Compatible: yes
BuddyPress Compatible: yes
WordPress MU Compatible: soon
MU Blog Farm Compatible: soon

Tested up to: 2.9
Requires at least: 2.8.4
Requires: WordPress® 2.8.4+, PHP 5.2+

Copyright: © 2009 WebSharks, Inc.
License: GNU General Public License
Contributors: WebSharks, PriMoThemes
Author URI: http://www.primothemes.com/
Author: PriMoThemes.com / WebSharks, Inc.
Donate link: http://www.primothemes.com/donate/

Plugin Name: s2Member
Professional Installation URI: http://www.primothemes.com/support/
Plugin URI: http://www.primothemes.com/post/s2member-membership-plugin-with-paypal/
Customization URI: http://www.primothemes.com/post/s2member-membership-plugin-with-paypal/#comments
Description: Empowers WordPress® with membership capabilities. Integrates seamlessly with PayPal®. Also compatible with the BuddyPress plugin for WP.
Tags: membership, members, member, register, signup, paypal, pay pal, s2member, subscriber, members only, buddypress, buddy press, buddy press compatible, shopping cart, checkout, api, options panel included, websharks framework, w3c validated code, multi widget support, includes extensive documentation, highly extensible

s2Member is a full-featured membership management system for WordPress®. It empowers WordPress® with membership capabilities, integrating seamlessly with PayPal®. s2Member is also compatible with BuddyPress.

== Installation ==

1. Upload the `/s2member` folder to your `/wp-content/plugins/` directory.
2. Activate the plugin through the `Plugins` menu in WordPress®.
3. Navigate to the `s2Member Options` panel for configuration details.

***Special instructions for WordPress® MU:** If you're installing this plugin on WordPress® MU, and you run a Blog Farm ( e.g. you give away free blogs to the public ), you should create a file in this plugin's directory, and name it: `wpmu.farm`. When this plugin is running under WordPress® MU, and that file ( `wpmu.farm` ) is present, the plugin will disable PHP code evaluation on data provided by the user, and it will tell the plugin to mutate itself ( including its menus ) for compatiblity with public Blog Farms. You don't need to do this unless you run a public Blog Farm. If you're running the standard version of WordPress®, or you run WordPress® MU to host your own sites, you can safely skip this step.*

***Security On WordPress® MU Blog Farms:** This plugin is currently released as NOT having compatiblity with MU Blog Farms. This is because s2Member provides a configuration panel for protected file downloads, and also a programming API that makes PHP Constants and other routines available to advanced users. For these reasons, it is not a good idea to make s2Member available for use within a public Blog Farm. That being said, if you want to use the `wpmu.farm` file & tweak the code a little, you might be able to tune things in. -- If you're running the standard version of WordPress®, or you run WordPress® MU to host your own sites, you can safely ignore this warning.*

== Description ==

s2Member is a robust/powerful ( and free ) membership management system for WordPress®. s2Member integrates seamlessly with PayPal® ( very easy ), and fully supports recurring billing, with the ability to track affiliate commissions on a recurring basis. s2Member supports custom Pages for registration ( including Custom Registration Fields ), account access, and a whole lot more.

s2Member supports up to four primary Membership Levels, and unlimited Custom Capability Packages. This allows you to create an unlimited number of Membership Packages, all with different Capabilities and prices. You can label your primary Membership Levels anything you like. The defaults are Bronze, Silver, Gold, and Platinum.

s2Member allows you to protect Pages, Posts, Tags, Categories, URIs, URI word fragments, Single-Page Access, and even portions of content within Pages/Posts/themes/plugins. Everything is configurable through the s2Member Options Panel. This makes s2Member VERY easy to integrate into any WordPress®-powered site. With s2Member, you can also protect downloadable files, using special restrictions on how many downloads can occur within a certain amount of time; all based on Membership Level.

Each Membership Level can have different restrictions, and you could even integrate Conditionals within your content based on Member Level. Advanced code samples are provided under `s2Member -> API Scripting -> Advanced Conditionals`. s2Member has been fully integrated with the Roles &amp; Capabilities that are already built into WordPress®. No new tables :-) It is designed to be completely seamless, without code bloat. We've carefully structured the entire framework, in order to maximize s2Member's ability to operate with other plugins installed. For instance, s2Member is compatible with BuddyPress!

New! - Now you can sell Single-Page Access too, using "Buy Now" buttons. Further details are provided under `s2Member -> PayPal® Buttons`.

== Screenshots ==

1. s2Member / Screenshot #1
2. s2Member / Screenshot #2
3. s2Member / Screenshot #3
4. s2Member / Screenshot #4
5. s2Member / Screenshot #5
6. s2Member / Screenshot #6
7. s2Member / Screenshot #7
8. s2Member / Screenshot #8
9. s2Member / Screenshot #9
10. s2Member / Screenshot #10

== Frequently Asked Questions ==

= Does the PayPal integration work right-out-of-the-box? =
Yes, it can even generate your PayPal® Subscription Buttons for you. Everything is fully integrated. You even get to create your own Pages within WordPress® to handle Membership Options, the Login Welcome Page, etc. For advanced webmasters, there are scripting techniques that are documented as well. These will help you further develop your site and tailor it to meet your specific needs. s2Member API Scripting is NOT required however.

= How many Membership Levels are supported? =
s2Member supports up to 4 Primary Membership Levels, and unlimited Custom Capabilities. This allows you to create an unlimited number of Membership Packages, all with different Capabilities and prices. You can label your Membership Levels anything you like. The defaults are Bronze, Silver, Gold, Platinum. s2Member also makes it possible to sell an unlimited number of Single-Page Access Links using "Buy Now" buttons. Further details are provided under `s2Member -> PayPal® Buttons`.

= Does s2Member utilize the PayPal® IPN system? =
Yes, s2Member supports automation of account activation, welcome emails, confirmations, renewals, de-activation, refunds, etc. The integration with PayPal® is seamless. s2Member even provides API Notifications, which are an added layer of functionality. These are not to be confused with the IPN service. s2Member API Notifications make it easier to integrate back-office routines, affiliate programs, list servers, or any other 3rd-party application that should react to certain events.

= Does s2Member support PayPal Auto-Return w/Payment Data Transfer? =
Yes, s2Member will work with PayPal® Auto-Return/PDT (Payment Data Transfer) `On`, and also with Auto-Return/PDT `Off`. If you enable Auto-Return, you MUST also enable PDT and enter your Identity Token. If one is enabled, the other must also be enabled. There is a place to enter your PayPal® Identity Token for PDT under `s2Member -> PayPal® Options`. You'll also find some additional instructions there.

= Does s2Member install any new database tables? =
No, s2Member has been fully integrated with the Roles &amp; Capabilities that are already built into WordPress®. It is designed to be completely seamless, without code bloat. We've carefully structured the entire framework, in order to maximize s2Member's ability to operate with other plugins installed. For instance, s2Member is compatible with BuddyPress!

= How does s2Member protect content from public access? =
s2Member allows you to protect Pages, Posts, Tags, Categories, URIs, URI word fragments, Single-Page Access ( Buy Now! ), and even portions of content within Pages/Posts. Everything is configurable through the s2Member Options Panel. This makes s2Member VERY easy to integrate into any WordPress®-powered site. With s2Member, you can also protect downloadable files, using special restrictions on how many downloads can occur within a certain amount of time; all based on Membership Level. Each Membership Level can have different restrictions, and you could even integrate Conditionals within your content based on Member Level. Advanced code samples are provided under `s2Member -> API Scripting -> Advanced Conditionals`.

= Does s2Member provide an API that I can connect to? =
Yes, s2Member provides many *Advanced Scripting* techniques that are fully documented within its Option Panels. Code samples are provided for everything. There are several API functions that you can use, along with s2Member API Constants. This allows you to access many parts of its functionality, as well as specific Member information. Theme designers are welcome to integrate their themes/plugins with s2Member using the code samples that we provide under `s2Member -> API Scripting`. s2Member even provides API Notifications, which are an added layer of functionality. These are not to be confused with the IPN service. s2Member API Notifications make it easier to integrate back-office routines, affiliate programs, list servers, or any other 3rd-party application that should react to certain events.

= Is s2Member compatible with Quick Cache or WP Super Cache? =
Yes, there were some bugs in the beginning, but they have been fixed now. Both Quick Cache and WP Super Cache will remain compatible with s2Member. We have integrated two internal constants that prevent these plugins from caching important Members Only areas of your site, no matter what your cache configuration might be. The two Constants are: `DONOTCACHEPAGE` and `QUICK_CACHE_ALLOWED = false`. We recommend Quick Cache over WP Super Cache simply because we actually developed Quick Cache and we have done more extensive testing with the s2Member/Quick-Cache combination.

= Is s2Member compatible with the BuddyPress plugin for WordPress? =
Yes it is. In fact, we must say... the s2Member/BuddyPress combination is just awesome. These two plugins running together make all sorts of things possible.

= Do you take feature requests for future versions of s2Member? =
We welcome any and all [contributions](http://www.primothemes.com/donate/) so that s2Member may remain publicly available. If you contribute more than $200, your feature requests will be given high priority, and you will also receive 5 WordPress® themes ( of your choosing ) from PriMoThemes.com.

= Do you offer professional installation for s2Member? =
Yes, please contact [PriMoThemes.com](http://www.primothemes.com/contact/) for assistance.

= Is there a discussion forum for s2Member? =
Yes. In the form of comments on [this page](http://www.primothemes.com/post/s2member-membership-plugin-with-paypal/).

== Changelog ==

= 2.8.8 =
* Integration instructions for iDevAffiliate® and ShareASale® are now available under: `s2Member -> API Tracking`.
* Fixed a bug in the new Email Confirmation template for Single-Page Access. The replacement code: %%access_url%% has been changed to %%sp_access_url%%. This was a typo. The variable remains the same as it was, but the typo in the default template was corrected.
* Added a new replacement code to the Single-Page Email Confirmation template. See: `s2Member -> PayPal® Options -> Single-Page`. The new replacement code is: %%sp_access_exp%%, indicating a human readable duration for link validity.
* High priority bug fixed with s2Member Hook/Filter on Login Design. This bug was just introduced in v2.8.7. This bug was preventing a customized Login Design from being displayed properly. Corrected in v2.8.8.
* Bug fix in PayPal® Button Generator. The modify="" parameter was being set to a value of "1" in some rare cases, depending on button configuration. It should always default to a value of "0", and only be set to a value of "1" or "2" whenever a Subscription Modification Button is being generated. This bug was introduced in v2.8.6. Corrected in v2.8.8.

= 2.8.7 =
* Over 100 WordPress® Hooks and Filters have been added to the s2Member framework. In addition to its API Constants, s2Member now makes several Hooks/Filters available throughout its framework. This makes it possible to build onto ( or even modify ) s2Member in lots of different ways. If you need to add custom processing routines, modify the behavior of existing processing routines, or tinker with things otherwise; you should use API Hooks/Filters. API Hooks &amp; Filters, give you the ability to "hook into", and/or "filter" processing routines, with files/functions of your own; instead of editing the s2Member plugin files directly. If you don't use a Hook/Filter, and instead, you edit the plugin files for s2Member, you'll have to merge all of your changes every time a new version of s2Member is released.
* You can now set a custom expiration time for Single-Page Access links. Instead of the default 72 hours, you may now choose an option that works best for your site. Anywhere from 2 hours, up to 5 years.

= 2.8.6 =
* Powerful new feature! - s2Member now supports unlimited Custom Capabilities. This allows you to create an unlimited number of Membership Packages, all with different Capabilities ( customized specifically for what your site offers ). Custom Capabilities can also be configured on a per-User basis through your WordPress® Dashboard, under `Users`. For further details, see: `s2Member -> API Scripting -> Custom Capability Packages`.
* Powerful new feature! - Now you can sell Single-Page Access too, using "Buy Now" buttons. Single-Page Access works independently from Member Level Access. That is, you can sell an unlimited number of Pages using "Buy Now" Buttons, and your Customers will NOT be required to have a Membership Account with your site in order to receive access. If they are already a Member, that's fine, but they won't need to be. Further details are provided under `s2Member -> PayPal® Buttons`.
* MailChimp® integration. s2Member can now be integrated with MailChimp®. MailChimp® is an email marketing service. MailChimp® makes it easy to send email newsletters to your Customers, manage your MailChimp® subscriber lists, and track campaign performance. Although s2Member can be integrated with almost ANY list server, we highly recommend MailChimp®; because of their powerful API for MailChimp® services. In future versions of s2Member, we plan to build additional features into s2Member that work with, and extend, MailChimp® services.
* AWeber® integration. As a secondary option, s2Member can also be integrated with AWeber®. AWeber® is an email marketing service. Whether you're looking to get your first email campaign off the ground, or you're a seasoned veteran who wants to dig into advanced tools like detailed email web analytics, activity based segmentation, geo-targeting and broadcast split-testing, AWeber's got just what you need to make email marketing work for you.
* Bug fix. Some of the %%replacement_codes%% for email messages were returning URL-encoded values. Replacement codes DO return URL-encoded values for API Notifications, because those are designed for use within URLs. However, they should NOT be encoded for email messages. This has been corrected in s2Member v2.8.6.
* Bug fix. `S2MEMBER_LOGIN_WELCOME_PAGE_URL` was missing in the s2Member JavaScript API. This has been corrected in s2Member v2.8.6.
* Important change. The API Constant: `S2MEMBER_CURRENT_USER_FIELDS` is now a JSON-encoded array, rather than a serialized array. Check `s2Member -> API Scripting` for code samples. This makes `S2MEMBER_CURRENT_USER_FIELDS` compatible with the PHP API, and also with the s2Member JavaScript API. In PHP, use `json_decode()` instead of `unserialize()`.
* Important change. The API Constant: `S2MEMBER_CURRENT_USER_IS_LOGGED_IN` works a little bit differently than it has in previous versions. Starting with s2Member v2.8.6, you should change any existing references to: `S2MEMBER_CURRENT_USER_IS_LOGGED_IN`, into this new API Constant: `S2MEMBER_CURRENT_USER_IS_LOGGED_IN_AS_MEMBER`. These two API Constants are documented under `s2Member -> API Scripting`. We're not getting rid of `S2MEMBER_CURRENT_USER_IS_LOGGED_IN` ( it's still useful ), but it does work a bit differently than it has in previous versions. Check the documentation if you're unsure, and we're sorry for the change-up.
* Under `s2Member -> General Options`, there is a new configuration option for Profile Modifications.
* Under `s2Member -> PayPal® Options`, there is a new configuration option for EOT behavior.
* The `s2Member -> API Tracking` field for Signup Confirmation, now supports PHP code too!
* The PayPal® Button Generator for s2Member, now supports Subscription Modification Buttons.
* The PayPal® Button Generator for s2Member, now supports Subscription Cancellation Buttons.
* A new s2Member API Notification event has been added for Single-Page Access.
* The PayPal® Button Generator for s2Member, now supports "Buy Now" Buttons.
* A new s2Member API Notification event has been added for Registrations.
* We've added a new Quick Start Guide for site owners.
* Documentation and code samples updated throughout.
* Support for WordPress® MU has been dropped, for now. Once WP 3.0 is released, we will come back to this. If anyone can help contribute to this effort, I would be very appreciative.

= 2.8.5 =
* Bug fix. A bug was causing the First &amp; Last Name of a new User to be excluded whenever a new User was created manually through the WordPress® Dashboard by an Administrator. This bug was first introduced in v2.8.2 and has now been resolved in v2.8.5.
* Internal references to `?s2AC` and `?s2ABC` have been removed. These have been deprecated since v1.6 anyway. They have now been removed completely in favor of `qcAC` and `qcABC`. These two variables are ONLY used internally, in order to provide compatibility with the Quick Cache plugin for WordPress®. This will have no impact on existing installations of s2Member; UNLESS you're using the Quick Cache plugin. If you ARE using the Quick Cache plugin, you should make sure that you're using Quick Cache 2.1.4+ for the highest level of compatibility with s2Member.

= 2.8.4 =
* A new option was added under `s2Member -> General Options -> De-Activation Safeguards`. This new option allows you to disable the de-activation routines for the s2Member plugin, so that s2Member Roles, Capabilities, and your Configuration Options will be preserved in case s2Member is de-activated inadvertently. We recommend that you Safeguard all s2Member data on your system; so please have a look at this new option.
* A bug was found in the Shortcode processor, related specifically to Buy Now buttons for Lifetime access. This bug has been corrected in s2Member v2.8.4.
* Stable tag updated in support of tagged releases within the repository at WordPress.org.

= 2.8.3 =
* A bug was found in the PayPal Button Generator, including the Shortcode processor. This has been resolved in v2.8.3. It was related to regex parsing. More specifically, it was related to Unix-style newlines vs. Windows-style newlines. For some site owners ( depending on how certain files were uploaded to their server ), this was resulting in an error at checkout that read "A1, P1, T1"; Invalid Trial. This bug has been corrected by modifying the regex parsing routines so that they're no longer dependent on multiline mode /m. The file `/button.html` has also been converted to Unix format to match the rest of the s2Member files.
* The action priority has been raised to (1) for `template_redirect` hooks inside `hooks.inc.php`. These hooks are responsible for access control routines that protect Pages, Posts, Tags, Categories, and URIs. This increase in the action priority gives s2Member greater compatibility with BuddyPress and other plugins that attempt to use `template_redirect` as a hook into their application. A plugin such as s2Member should always be given top priority in this chain of events, because it is protecting content from public access.

= 2.8.2 =
* Bug fix. A bug was found &amp; resolved in the activation/de-activation routines for s2Member. This bug was first introduced in the initial release of s2Member v2.8.0, and has been resolved in this release ( v2.8.2 ). This bug was preventing the s2Member Roles from being created properly on some WordPress® installations.
* Dependency on the pluggable function `wp_new_user_notification()` has been dropped, making s2Member compatible with MailPress and other plugins that need `wp_new_user_notification()`. Some site owners were encountering conflicts specifically with MailPress. This issue has been resolved in s2Member v2.8.2. s2Member now uses a work-around that bypasses the need for `wp_new_user_notification()`.
* A new configuration option has been added to `s2Member -> General Options -> Login Welcome Page`. This new configuration option, makes it possible for you to redirect Members to a Special URL after logging in ( and not just to a WordPress® Page ). For example, you could now have Members redirected to their BuddyPress profile after logging in, or to ANY other URL for that matter.
* Default values for the Login Welcome Page &amp; Membership Options Page are now empty when s2Member is first installed. Site owners just getting started with s2Member will appreciate this, because this tends to be less confusing if you're configuring s2Member for the first time.

= 2.8.1 =
* The PayPal® Button Generator now provides built-in JavaScript validation; preventing invalid Trial subscription configurations that could potentially cause `A1, P1, T1 errors` at checkout.
* The new Shortcode Format for PayPal Buttons is now the default format. The more advanced version ( the full Button Code ) is still made available; but only for theme designers and plugin developers.
* The resulting PayPal Button Code is now W3C compliant under XHTML Strict mode.

= 2.8 =
* s2Member now supports Custom Fields, and ALSO *required* Custom Fields. If you would like to make specific fields *required* during registration, you can! See: `s2Member->General Options->Custom Registration Fields`.
* Your Custom Fields are now visible inside `WordPress® -> under Users`. With s2Member installed, you'll now have the ability to view &amp; manipulate Custom Fields from your WordPress® Dashboard. In previous versions of s2Member, this information could only be obtained through the s2Member API. Version 2.8 makes everything available inside the WordPress® UI now. We also have plans to build onto this functionality in the next release. A CSV export would be nice, and also a history of file downloads. These are coming soon. Waiting for additional contributors.
* The `S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL` ( which is a PHP Constant included with the s2Member API ), has been updated to support *required* Custom Fields. It has also been updated to support IFRAME implementations. Documentation and code samples for IFRAME implementation are available under `s2Member->API Scripting->Constants`.
* Support for Content Dripping has been added in s2Member v2.8. Please see: `s2Member->API Scripting->Content Dripping`. Two new API Constants make this possible. These are `S2MEMBER_CURRENT_USER_REGISTRATION_DAYS` and `S2MEMBER_CURRENT_USER_REGISTRATION_TIME`. If you're dripping content, you should use `S2MEMBER_CURRENT_USER_REGISTRATION_DAYS`, it's easier.
* s2Member v2.8 includes support for Free Subscribers ( without going through PayPal® ). See: `s2Member->General Options->Login Welcome Page->Allow Free Subscribers`. You can now allow Users to register for FREE, and then upgrade them later using the instructions provided under `s2Member->Flow Of Events->Upgrading`.
* The PayPal® Button Generator has been improved significantly. It now supports MANY new options for Subscription Lengths. All the way up to 5 years &amp; also Lifetime Access.
* The PayPal® Button Generator now supports LIFETIME Subscriptions using `Buy It Now` buttons. Just choose `Lifetime` from the drop-down menu. This allows you to charge a Customer ONCE, and they'll never expire. It also makes the checkout experience more user-friendly, whenever your intention is to provide them lifetime access; as opposed to a specific number of days/weeks/months/years with recurring charges. s2Member now supports all of these methods.
* The PayPal® Button Generator now supports over 20 different international currencies.
* The PayPal® Button Generator now provides an alternative `Shortcode` method of insertion into Posts/Pages. If you were having problems associated with the Visual Editor for WordPress® ( i.e. raw code getting corrupted ), please use the new alternative format. This new format is made available after you click `Generate`. The Shortcode syntax is a more elegant solution than the Raw HTML plugin many of you were forced to use in previous versions of s2Member. The Alternative Shortcode syntax is every bit as powerful, without the headaches. The Shortcode syntax is also compatible with WordPress® MU filters.
* Under `s2Member->General Options->Login Customizations`, you can now use a wider Logo Image, which automatically forces the Login/Registration forms to become wider overall. This adds a nice touch whenever you're using lots of Custom Fields. Otherwise you'll end up with a tall/narrow stack of form fields that really does not look nice :-). Try using a Logo Image about 550px wide.
* Documentation updated throughout. Many files modified. Some minor changes in the menu structure and naming conventions. Stay tuned! Have fun, and make some money!
* Please thank [Jennifer Stuart](http://scriptygoddess.com/) for a generous donation that helped make s2Member v2.8 possible.
* Also thank Stree Overlord with LARGE Inc. for his generous contribution that helped make s2Member v2.8 possible.
* Also thank Martin B. for his donation too. You'll find him the Comment threads. Say thanks!
* For more info, feature requests, etc; Visit: http://www.primothemes.com/post/s2member-membership-plugin-with-paypal/

= 2.7.2 =
* WebSharks Framework for Plugins has been updated to P-2.1.
* The s2Member file download headers (`file-download-access.inc.php`) has been updated to support CGI/FastCGI implementations. s2Member has been tested with HostGator, BlueHost, (mt)MediaTemple (gs) and (dv), The Rackspace Cloud, and several dedicated servers running with Apache; including support for both `mod_php` and also `CGI/FastCGI` implementations. s2Member should work fine with any Apache/PHP combination. Please report all bugs to <primothemes@websharks-inc.com>.

= 2.7.1 =
* A bug in Custom Registration Fields has been corrected. This bug was introduced in v2.7, and has been corrected in v2.7.1. This bug was causing a mysterious [Empty Registration Field](http://www.primothemes.com/post/s2member-membership-plugin-with-paypal/comment-page-3/#comment-312) to appear on the form; when a new Customer registers their Username. Please thank [Jeffrey Nichols](http://jeffreyanichols.com/) for reporting this important issue.

= 2.7 =
* s2Member is now compatible with BuddyPress :-) And I must say... the s2Member/BuddyPress combination is just awesome. These two plugins running together make all sorts of things possible.
* A decision has been made to release this version, and future versions of s2Member as open source. We originally had plans to release this version privately as s2Member Pro. Instead, we've decided to keep future versions of s2Member licensed as GPL, and allow s2Member to be used freely by the entire WP community. We welcome any and all [contributions](http://www.primothemes.com/donate/) so that s2Member may remain publicly available. If you contribute more than `200.00`, your feature requests will be given high priority, and you will also receive 5 WordPress® themes ( of your choosing ) from PriMoThemes.com, along with a PriMoThemes.com T-shirt, and special credits in the next release of s2Member.
* All Option Panels have been given a makeover. The General Options Panel now includes a new section that provides you with the ability to collect and reference Custom Fields during user registration. The s2Member registration form now includes fields for First Name &amp; Last Name by default. These are the default, built-in Custom Fields.
* The Profile Modification Page ( `S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL` ), has been updated to support the new Custom Fields added to the General Options.
* A new PHP Constant has been added to the s2Member API ( `S2MEMBER_CURRENT_USER_FIELDS` ). Documentation for this PHP Constant is available under `s2Member -> Advanced Scripting`. This provides programmatic access to all fields, including Custom Fields.
* The PayPal® Button Generator that is built into s2Member, now supports both recurring and NON-recurring charges with various membership subscription terms. s2Member has always supported ANY type of PayPal subscription, whether it be recurring or non-recurring. However, this update makes it possible for you to configure additional options using the Button Generator, instead of having to tweak the code it generates manually.
* There is a new section under `s2Member -> PayPal® Options` that provides you with several tools to help you customize the Signup Confirmation email Subject Line and Message Body templates.
* Support for Custom Payment Pages has been improved, along with further documentation built into the PayPal® Button Generator. Click the [?] icons for additional details about how to brand Custom Payment Pages for checkout.
* Under `s2Member -> General Options -> Login/Registration Design` we've added some easy-to-use buttons that open your Media Library ( then press Insert to save time ); this allows you to pull images out of your Media Library easily.
* Multiple files updated. The most significant changes were in: `/includes/hooks.inc.php, /includes/profile.inc.php, /functions/register-access.inc.php, /functions/profile-modifications.inc.php, /functions/constants.inc.php, /menu-pages/buttons.inc.php, /menu-pages/menu-pages.js`.
* Coming soon... in v2.8 we will be including some pre-built templates that will further assist you in creating your Membership Options Page and Login Welcome Page for s2Member. If you don't know any PHP at all, and you are totally confused by the s2Member API instructions, these pre-built templates will help kick start your experience with s2Member. Stay tuned for the latest. We also have plans to release WP themes that are pre-integrated with s2Member in creative ways.
* Please thank [Greg Eland](http://gregeland.com/) for a generous contribution that made s2Member v2.7 possible.

= 2.6 =
* The security-enabled directory that protects downloadable files, has been moved outside the main plugin folder, and into a new directory `wp-content/plugins/s2member-files`. If you're using a previous version of s2Member to protect files inside the old directory `wp-content/plugins/s2member/files/`, you will need to move them into the new directory.

 s2Member will attempt to create this new directory for you automatically. However, if your `wp-content/plugins` directory is not writable, s2Member will fail silently, and you'll need to create that directory yourself. A warning will be displayed inside your WordPress® Dashboard, on the `Download Options` page if the security-enabled directory ( `s2member-files` ) is non-existent or unprotected. Instructions will be provided at that time about how to create this directory manually.

 It should also be noted... any of your existing links that use the `?s2member_file_download` variable will remain unaffected by this change. You can leave those links the way they are, just move your files into the new directory and you're good.
* The `File Download Options` page has been cleaned up a bit, and some additional instruction has been added to this configuration page.
* Enhanced logging routines for PayPal® IPN connections and sub-routines. Added PayPal® Return logging routines. Both of these logs can be turned on/off under `PayPal® Options`.
* Added some additional instructions to the `PayPal® Options` page, detailing step-by-step how to enable PayPal® IPN reporting, and optional Auto-Return w/ Payment Data Transfer.

= 2.5 =
* Bug fixed in PayPal® IPN routine. This bug was related to alias email addresses being paid through PayPal®, but then the primary (business) email address being returned in the IPN response. This bug was affecting some users who have multiple email addresses associated with a single PayPal® account. If they decided to use a non-Primary address with s2Member, it was causing a conflict. The validation routines have been corrected so that this is no longer an issue. One of the symptoms of this bug, was a simple Thank-you message after checkout, and a redirect to the login screen instead of to the registration page. Bug resolved.
* Another minor bug was found in the IPN routine. The IPN routine was not utilizing the `Email From Name` set in the `s2Member General Options`. A cleaning routine was completely losing the name field on one particular sub-routine associated with subscription signups. This bug has also been corrected.
* Files modified: `/functions/paypal-return.inc.php`, `/functions/paypal-notify.inc.php`, `/functions/email-hacks.inc.php` renamed to `email-configs.inc.php`.

= 2.4 =
* Fixed a bug in the PayPal® IPN and Auto-Return routines where it was possible for a conflict to arise whenever a subscription modification from one of these two routines jumped ahead of the other. This bug would have only affected site owners that were using the advanced `on0` and `os0` variables to allow members to upgrade from one membership level to another. This advanced technique is described in greater detail on the `Flow Of Events` page under `s2Member Options`.
* Applied the use of `add_query_arg()` ( a native WordPress® function ) to redirection after a successful signup. Some site owners reported problems with the `?action=register` parameter not being passed through correctly. The `add_query_arg()` function handles the `?` vs. `&` appendages more reliably.
* Added a fallback to the PayPal® IPN sub-routine for email receipts. By default, s2Member uses tinyURL.com to compress the longer URL into an email-friendly format. This new fallback will revert to using the longer version when/if tinyURL.com becomes temporarily unavailable for some reason.

= 2.3 =
* Fixed a bug related to compatiblity with `WP Super Cache` and the more modern `Quick Cache` plugin. We recommend `Quick Cache` because there has been more extensive testing performed with `Quick Cache`. That being said, s2Member should work fine with either of them installed. s2Member is compatible with both of these plugins. s2Member will prevent protected areas of your site from being cached by these plugins. To maximize compatiblity, please make sure that you're using friendly Permalinks; which is recommended anyway if you're using a caching plugin of any kind.
* Renamed `api-constants.inc.php` to just `constants.inc.php`.
* Renamed `nocache-headers.inc.php` to just `nocache.inc.php`.
* Modified `hooks.inc.php` to reflect these changes.

= 2.2 =
* Further optimized API routines that provide access to PHP Constants. Reduced queries from five down to just one.
* Fixed Tag Level Access issue; related to tag/slug conversion in the `General Options Panel`. This was not really a bug, but it was confusing to people, because tags were being converted to slugs automatically. This still happens internally, but they are no longer auto-converted within the `General Options Panel` because it was too confusing to site owners. If you are/were protecting certain tags, those tags will continue to be protected. This change will have NO impact on existing installations of s2Member.

= 2.1 =
* Re-organized core framework. Updated to: P-2.0.
* Updated to support WP 2.9+.

= 2.0 =
* Two new options were added for login screen customization. s2Member now supports the ability to modify the shadow and text colors too.
* A new internal filter was added to suppress systematic use pages; such as the Login Welcome Page and Download Limit Exceeded Page from search results. These pages are always protected anyway, but s2Member now filters them from on-site search listings as well, just to prevent them from popping up and causing confusion.
* Added some additional inline documentation for the option panels.
* Replaced deprecated `split()` function with `preg_split()`.

= 1.9 =
* Minor bug fixed in JavaScript API. Some constants were empty ( non-zero ) when downloads were disabled.
* Added some additional API Constants for Page IDs. These are intended to supplement the existing Page URLs.

= 1.8 =
* I broke the options panel down into smaller sub-sections because things were getting too crowded all on one page.
* A new API has been added that provides extended notifications for affiliate program integration and other back-office routines.
* Support for refunds and reversals ( e.g. charge backs ) has been added to the IPN integration making it 100% seamless now!
* Pixel Tracking has been added to support AdSense / Yahoo / Google Analytics and other tracking codes & marketing campaigns.
* Additional documentation has been added along side or beneath each option; which helps to further clarify any confusion.

= 1.7 =
* JavaScript prompts for (Protected File Download Confirmation) are now issued by s2Member in an intuitive way. Check your options panel under File Download Restrictions for notes on this topic.
* Added a new PHP Constant: `S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_IS_UNLIMITED`. Check the Advanced Scripting page in your Dashboard for further details.
* In the options panel, support was added for category level restrictions, tag level restrictions, and URI level restrictions.
* All of the PHP runtime Constants for advanced scripting have been made available through a new JavaScript API as well.
* Bug fix: `s2member_file_download` counters were counting the same file more than once. This has been corrected.

= 1.6 =
* Upgraded to fully support WP 2.8.4. Slight tweaks. Nothing major.
* Added a `Flow Of Events` page that provides additional documentation & explanations.
* Added optional support for PayPal Auto-Return with PDT ( Payment Data Transfer ).

= 1.5 =
* You can now customize the Login / Registration Pages with your bg & logo.
* Added support for affiliate program tracking with optional custom fields.
* Added support for recurring commission processing for affiliates.

= 1.4 =
* Added file download limitations, restrictions and .htaccess protection.
* Corrected a bug with 404 errors on files that were not available.
* Added support / compatibility for WP Super Cache & Quick Cache.

= 1.3 =
* Added full support for PayPal IPN scripting automation.
* Added additional documentation & code samples for advanced scripting.
* Added `s2member_xencrypt()` & `s2member_xdecrypt()` functions to the API.

= 1.2 =
* Added more code samples w/ PHP Constants for advanced scripting.
* Added support for custom labels on different membership levels.
* You can now customize the From: `"Name" <address>` used in emails.

= 1.1 =
* Updated to a more seamless integration with WP Roles & Capabilities.
* Added ways to easily protect Pages, Posts and conditional content.
* Advanced scripting now makes `current_user_can()` available.

= 1.0 =
* Initial release.