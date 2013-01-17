=== s2Member® Framework (Member Roles, Capabilities, Membership, PayPal Members) ===

<<<<<<< .mine
Version: 130116
Stable tag: 130116
=======
Version: 121213
Stable tag: 121213
>>>>>>> .r654027

SSL Compatible: yes
bbPress® Compatible: yes
WordPress® Compatible: yes
BuddyPress® Compatible: yes
WP® Multisite Compatible: yes
Multisite Blog Farm Compatible: yes

PayPal® Standard Compatible: yes
PayPal® Pro Compatible: yes w/s2Member® Pro
Authorize.Net® Compatible: yes w/s2Member® Pro
Google® Checkout Compatible: yes w/s2Member® Pro
ClickBank® Compatible: yes w/s2Member® Pro

<<<<<<< .mine
Tested up to: 3.6-alpha
=======
Tested up to: 3.5
>>>>>>> .r654027
Requires at least: 3.2

Copyright: © 2009 WebSharks, Inc.
License: GNU General Public License
Contributors: WebSharks

Author: s2Member® / WebSharks, Inc.
Author URI: http://www.s2member.com/
Donate link: http://www.s2member.com/donate/

Text Domain: s2member
Domain Path: /includes/translations

Plugin Name: s2Member® Framework
Forum URI: http://www.s2member.com/forums/
Plugin URI: http://www.s2member.com/framework/
Privacy URI: http://www.s2member.com/privacy/
Video Tutorials: http://www.s2member.com/videos/
Pro Module / Home Page: http://www.s2member.com/
Pro Module / Prices: http://www.s2member.com/prices/
Pro Module / Auto-Update URL: http://www.s2member.com/
PayPal Pro Integration: http://www.s2member.com/videos/ED70D90C6749DA3D/
Professional Installation URI: http://www.s2member.com/professional-installation/

Description: s2Member®, a powerful (free) membership plugin for WordPress®. Protect/secure members only content with roles/capabilities.
Tags: s2, s2member, s2 member, membership, users, user, members, member, subscribers, subscriber, members only, roles, capabilities, capability, register, signup, paypal, paypal pro, pay pal, authorize, authorize.net, google checkout, clickbank, click bank, buddypress, buddy press, bbpress, bb press, shopping cart, cart, checkout, ecommerce

s2Member®, a powerful (free) membership plugin for WordPress®. Protect/secure members only content with roles/capabilities.

== Installation ==

**NOTE:** Please do NOT use the WordPress® forums to seek company support. Support for s2Member® is handled in [our own support forums](http://www.s2member.com/forums/).

= s2Member® is very easy to install (instructions) =
1. Upload the `/s2member` folder to your `/wp-content/plugins/` directory.
2. Activate the plugin through the `Plugins` menu in WordPress®.
3. Navigate to the `s2Member Options` panel for configuration details.

= See Also (s2Member.com) =
[Detailed installation/upgrade instructions](http://www.s2member.com/framework/#!s2_tab_jump=s2-framework-install-update).

= Is s2Member compatible with Multisite Networking? =
Yes. s2Member and s2Member Pro, are also both compatible with Multisite Networking. After you enable Multisite Networking, install the s2Member plugin. Then navigate to `s2Member -> Multisite (Config)` in the Dashboard on your Main Site.

== Description ==

**NOTE:** Please do NOT use the WordPress® forums to seek company support. Support for s2Member® is handled in [our own support forums](http://www.s2member.com/forums/).

[youtube http://www.youtube.com/watch?v=neGsNjWhOBs /]

The s2Member® Framework (free) integrates with PayPal® Website Payments Standard (also free), and fully supports recurring billing. s2Member supports custom Pages for registration (including Custom Registration/Profile Fields), account access, and a lot more. s2Member is compatible with Multisite Networking too, and even with BuddyPress and bbPress. With the s2Member® Pro add-on (an optional paid upgrade), you can add support for unlimited Membership Levels, PayPal® Website Payments Pro (w/ Pro Forms to facilitate on-site credit card processing), Authorize.Net® (also with Pro Forms), Google® Checkout, ClickBank®, advanced User Import/Export tools, the ability to use Coupon Codes, and many other enhancements. Videos available at: [s2Member.com / Videos](http://www.s2member.com/videos/).

s2Member supports Free Subscribers (at Level #0), and up to four primary Membership Levels [1-4] (unlimited with s2Member® Pro). You can label your Membership Levels anything you like. The defaults are Free, Bronze, Silver, Gold, and Platinum. s2Member also supports an unlimited number of Custom Capability Packages. Custom Capabilities are an easy way to extend s2Member in creative ways. Custom Capabilities allow you to create an unlimited number of Membership Packages, all with different Capabilities and prices.

s2Member allows you to protect Pages, Posts, Tags, Categories, URIs, URI word fragments, URI Replacement Codes for BuddyPress, Specific Post/Page "Buy Now" Access, and even portions of content within Posts/Pages/themes/plugins. All settings are configurable through the s2Member Options panel. This makes s2Member VERY easy to integrate into any site powered by WordPress®. With s2Member, you can also protect downloadable files, using restrictions to control how many downloads can occur within a certain amount of time; all based on Membership Level or even Custom Capabilities. sMember® can even integrate with Amazon® S3 and CloudFront (optional) for serving protected audio/video streams over an RTMP protocol.

You can learn more about s2Member® at [s2Member.com](http://www.s2member.com/).

== Frequently Asked Questions ==

**NOTE:** Please do NOT use the WordPress® forums to seek company support. Support for s2Member® is handled in [our own support forums](http://www.s2member.com/forums/).

= Please check the following s2Member® resources: =
* s2Member FAQs: http://www.s2member.com/faqs/
* Knowledge Base: http://www.s2member.com/kb/
* Video Tutorials: http://www.s2member.com/videos/
* Support Forums: http://www.s2member.com/forums/
* Codex: http://www.s2member.com/codex/

= Translating s2Member® =
Please see [this FAQ entry](http://www.s2member.com/faqs/#s2-faqs-translations)

== Upgrade Notice ==

<<<<<<< .mine
= v130116 =
=======
= v121213 =
>>>>>>> .r654027
Maintenance release. Upgrade immediately.

== Changelog ==

<<<<<<< .mine
= v130116 =
* **(Maintenance Release) Upgrade immediately.**
* **Compatibility (Issue #39)** Updated codes samples for JW Player®, to include the `mp4:` prefix when implementing RTMP streams against MP4 video files. Discussed in [this thread](http://www.s2member.com/forums/topic/cloudfront-subfolder-streaming-error/#post-35750).
* **Compatibility (Issue #51)** Updated Payflow® API to support recurring billing every six months. Discussed in [this thread](http://www.s2member.com/forums/topic/payflow-error-6-month-recurring-membership/#post-36053).
* **Bug Fix (Issue #69)** Updated multisite user imporation routine, to support a specific scenario not covered under WordPress v3.5. Discussed in [this thread](http://www.s2member.com/forums/topic/users-on-multisite/).
* **Feature Improvement (Issue #71)** s2Member® has been updated to support byte-range requests with it's default local file storage engine, served from the `/s2member-files/` directory. s2Member® has always supported byte-range requests when integrated with Amazon® CloudFront. Now it supports byte-range requests in it's default local storage engine too. This will improve compatibility with mobile devices, iTunes™  and other devices that use byte-range requests. Discussed in [this thread](http://www.s2member.com/forums/topic/any-way-to-set-accept-ranges-for-downloads/#post-15871).

= v121213 =
* **(Maintenance Release) Upgrade immediately.**
* **Updated for compatibility with WordPress® v3.5. Backward compatibility remains for previous versions of WordPress®, as far back as WordPress® v3.2.**
* (s2Member Pro) **Bug Fix**. An issue first introduced in s2Member® Pro v120517 where we fixed problems with the `maxlength` attribute in Authorize.Net Pro Forms, left a remaining problem. The State/Province field in the Billing Address section of a Pro Form, since s2Member® Pro v120517, has only accepted 2 characters when it should have been capable of accepting up to 40 characters. Fixed in this release.
* (s2Member / s2Member Pro) **Compatibility**. s2Member's Multsite Network patches now support `/wp-login.php` in WordPress® v3.5. Discussed in [this thread](http://www.s2member.com/forums/topic/fyi-wpmu-3-5-wp-login-php-file-not-verified/#post-34457).
* (s2Member / s2Member Pro) **Compatibility**. s2Member's login customizations for `/wp-login.php` have been tweaked to support WordPress® v3.5.
* (s2Member / s2Member Pro) **Checksums**. Each copy of s2Member® and s2Member® Pro now include a `checksum.txt` file in their root plugin directory. This file is used by server-scanning tools provided by WebSharks, Inc. This file simply serves to identify the state of the file structure upon each official release of the software.
* (s2Member Pro) **Bug Fix**. Free Registration Pro Forms submitted without having payment gateway API credentials configured within s2Member® resulted in an on-site error message when there should NOT be one (because a site owner is dealing with Free Registration only in this scenario). Fixed in this release.

= v121204 =
* **(Maintenance Release) Upgrade immediately.**
* (s2Member / s2Member Pro) **Bug Fix**. An issue with long billing agreement descriptions under PayPal® Pro (Payflow® Edition) accounts, when coupon codes were being used by customers, was addressed in this release. Symptoms of this bug were errors in s2Member® log files from the Payflow® API, with error code: `11581-Profile description is invalid`. Caused by undocumented length requirements for the billing agreement description under the Payflow® API. Fixed in this release. Discussed in [this thread](http://www.s2member.com/forums/topic/error-generic-processor-error-11581/page/2/#post-33477).
* (s2Member / s2Member Pro) **Compatibility**. Updated JW Player code samples for compatibility with JW Player v6. Discussed in [this thread](http://www.s2member.com/forums/topic/jw-player-rtmp-streaming-mp4-amazon-s3/page/2/#post-32074).

= v121201 =
* **(Maintenance Release) Upgrade immediately.**
* (s2Member / s2Member Pro) **Bug Fix**. Support Rep Cristián Lávaque found a bug in the behavior of s2Member’s Alternative View Restrictions, associated with Category listings in custom menu widgets. Fixed in this release. Discussed in [this thread](http://www.s2member.com/forums/topic/welcome-page-title-shows-but-no-content/page/2/#post-29802).
* (s2Member Pro) **Feature Enhancement**. s2Member Pro Forms integrated ONLY with PayPal Express Checkout (`accept="paypal" accept_via_paypal="paypal"`), will no longer display a Billing Method section on the Pro Form, as it's not necessary (there's only one possible option in this case, and it's already depicted by the PayPal button at the bottom of the Pro Form). Many site owners had implemented CSS hacks to hide this section of a Pro Form configured this way, based on [this FAQ article](http://www.s2member.com/faqs/#s2-faqs-paypal-pro-not-required). This hack is no longer necessary - starting with this release.
* (s2Member Pro) **Bug Fix**. s2Member Pro Forms integrated with Payflow Recurring Billing via PayPal Express Checkout were failing against some accounts with an erroneous error #10422 related to an invalid funding source. With some help from other site owners and the assistance of PayPal technical support, the underlying issue has been fixed in this release. Discussed in [this thread](http://www.s2member.com/forums/topic/paypal-error-36-transaction-failed/page/2/#post-31490).
* (s2Member Pro) **Compatiblity**. ccBill Buttons can now be generated for amounts exceeding $100.00, so long as prior ccBill approval is obtained from ccBill merchant support. Discussed in [this thread](http://www.s2member.com/forums/topic/cc-bill-button-increase-dollar-amount/#post-31636).
* (s2Member/s2Member Pro) **Compatiblity**. Updated to support Dynamic Roles introduced in bbPress® v2.2. Discussed in [this thread](http://www.s2member.com/forums/topic/dont-upgrade-to-bbpress-2-2/#post-32523).
* (s2Member Pro) **Authorize.Net**. True montly billing instead of every 30 days. Fixed in this release. Discussed in [this thread](http://www.s2member.com/forums/topic/1-month-recurring-billing-instead-of-30-days/#post-30420).

=======
= v121213 =
* **(Maintenance Release) Upgrade immediately.**
* **Updated for compatibility with WordPress® v3.5. Backward compatibility remains for previous versions of WordPress®, as far back as WordPress® v3.2.**
* (s2Member Pro) **Bug Fix**. An issue first introduced in s2Member® Pro v120517 where we fixed problems with the `maxlength` attribute in Authorize.Net Pro Forms, left a remaining problem. The State/Province field in the Billing Address section of a Pro Form, since s2Member® Pro v120517, has only accepted 2 characters when it should have been capable of accepting up to 40 characters. Fixed in this release.
* (s2Member / s2Member Pro) **Compatibility**. s2Member's Multsite Network patches now support `/wp-login.php` in WordPress® v3.5. Discussed in [this thread](http://www.s2member.com/forums/topic/fyi-wpmu-3-5-wp-login-php-file-not-verified/#post-34457).
* (s2Member / s2Member Pro) **Compatibility**. s2Member's login customizations for `/wp-login.php` have been tweaked to support WordPress® v3.5.
* (s2Member / s2Member Pro) **Checksums**. Each copy of s2Member® and s2Member® Pro now include a `checksum.txt` file in their root plugin directory. This file is used by server-scanning tools provided by WebSharks, Inc. This file simply serves to identify the state of the file structure upon each official release of the software.
* (s2Member Pro) **Bug Fix**. Free Registration Pro Forms submitted without having payment gateway API credentials configured within s2Member® resulted in an on-site error message when there should NOT be one (because a site owner is dealing with Free Registration only in this scenario). Fixed in this release.

= v121204 =
* **(Maintenance Release) Upgrade immediately.**
* (s2Member / s2Member Pro) **Bug Fix**. An issue with long billing agreement descriptions under PayPal® Pro (Payflow® Edition) accounts, when coupon codes were being used by customers, was addressed in this release. Symptoms of this bug were errors in s2Member® log files from the Payflow® API, with error code: `11581-Profile description is invalid`. Caused by undocumented length requirements for the billing agreement description under the Payflow® API. Fixed in this release. Discussed in [this thread](http://www.s2member.com/forums/topic/error-generic-processor-error-11581/page/2/#post-33477).
* (s2Member / s2Member Pro) **Compatibility**. Updated JW Player code samples for compatibility with JW Player v6. Discussed in [this thread](http://www.s2member.com/forums/topic/jw-player-rtmp-streaming-mp4-amazon-s3/page/2/#post-32074).

= v121201 =
* **(Maintenance Release) Upgrade immediately.**
* (s2Member / s2Member Pro) **Bug Fix**. Support Rep Cristián Lávaque found a bug in the behavior of s2Member’s Alternative View Restrictions, associated with Category listings in custom menu widgets. Fixed in this release. Discussed in [this thread](http://www.s2member.com/forums/topic/welcome-page-title-shows-but-no-content/page/2/#post-29802).
* (s2Member Pro) **Feature Enhancement**. s2Member Pro Forms integrated ONLY with PayPal Express Checkout (`accept="paypal" accept_via_paypal="paypal"`), will no longer display a Billing Method section on the Pro Form, as it's not necessary (there's only one possible option in this case, and it's already depicted by the PayPal button at the bottom of the Pro Form). Many site owners had implemented CSS hacks to hide this section of a Pro Form configured this way, based on [this FAQ article](http://www.s2member.com/faqs/#s2-faqs-paypal-pro-not-required). This hack is no longer necessary - starting with this release.
* (s2Member Pro) **Bug Fix**. s2Member Pro Forms integrated with Payflow Recurring Billing via PayPal Express Checkout were failing against some accounts with an erroneous error #10422 related to an invalid funding source. With some help from other site owners and the assistance of PayPal technical support, the underlying issue has been fixed in this release. Discussed in [this thread](http://www.s2member.com/forums/topic/paypal-error-36-transaction-failed/page/2/#post-31490).
* (s2Member Pro) **Compatiblity**. ccBill Buttons can now be generated for amounts exceeding $100.00, so long as prior ccBill approval is obtained from ccBill merchant support. Discussed in [this thread](http://www.s2member.com/forums/topic/cc-bill-button-increase-dollar-amount/#post-31636).
* (s2Member/s2Member Pro) **Compatiblity**. Updated to support Dynamic Roles introduced in bbPress® v2.2. Discussed in [this thread](http://www.s2member.com/forums/topic/dont-upgrade-to-bbpress-2-2/#post-32523).
* (s2Member Pro) **Authorize.Net**. True montly billing instead of every 30 days. Fixed in this release. Discussed in [this thread](http://www.s2member.com/forums/topic/1-month-recurring-billing-instead-of-30-days/#post-30420).

>>>>>>> .r654027
= v121023 =
* **(Maintenance Release) Upgrade immediately.**
* (s2Member / s2Member Pro) **Bug Fix**. A bug related to s2Member's `is_site_root()` method, when fancy permalinks are NOT in use; has been corrected for compatibility with the latest version of WordPress. Please see [this thread](http://www.s2member.com/forums/topic/new-custom-field-default-not-on-old-users/#post-28792) for futher details.
* (s2Member Pro) **Import/Export Bug Fix**. An issue related to RFC guidelines for escape sequences in CSV files has been addressed in this release. Please see [this thread](http://www.s2member.com/forums/topic/new-custom-field-default-not-on-old-users/#post-28792) for futher details.
* (s2Member Pro) **ccBill® DataLink Integration**. DataLink integration with ccBill® was updated for improved compatibility across multiple ccBill® sub-accounts.
* (s2Member Pro) **ccBill® DataLink Integration**. DataLink integration with ccBill® was updated for improved compatibility w/ ccBill® servers running on MST timezone.
* (s2Member/s2Member Pro) **API Function**. A new API Function was added. See: `s2member_login_ips_for($username)`. Please check the [s2Member® Codex](http://www.s2member.com/codex/stable/s2member/api_functions/package-summary/) for documentation. [This thread](http://www.s2member.com/forums/topic/s2member-restriction-options-unique-ip/#post-20562) may also be of some assistance.
* (s2Member/s2Member Pro) **404 Error (Bug Fix)**. A former dependency on `l10n.js` from the WordPress® core is no longer necessary. This old dependency has been removed to prevent 404 errors in the latest versions of WordPress®. Please check [this thread](http://www.s2member.com/forums/topic/wordpress-i10n-file-404-from-s2member/#post-20567) for further details.
* (s2Member Pro) **reCAPTCHA® Bug Fix**. A bug sometimes causing failed reCAPTCHA® responses after PayPal® Express Checkout has been corrected in this release. This occurred during certain scenarios, whenever reCAPTCHA® was enabled for checkout forms, and PayPal Express Checkout was selected as the payment method of choice.
* (s2Member Pro) **ccBill® DataLink Integration**. DataLink integration with ccBill® was modified to prevent dates in the future from being requested from the DataLink API. ccBill® was responding to some DataLink requests with a failed authentication, which were caused by dates/times in the future; according to MST on the ccBill® side of things.

= v120703 =
* **(Maintenance Release) Upgrade immediately.**
* (s2Member/s2Member Pro) **Payflow® Express Checkout**. An issue related to Express Checkout (when using the Payflow® API), has been corrected in this release. A bug in previous releases, was causing error messages under certain circumstances that read `Field format error: Invalid PayerID`.
* (s2Member/s2Member Pro) **WordPress® v3.4**. Standards compliance. Routine maintenance. Re-confirmed compatibility with WordPress® v3.4.

= v120622 =
* **(Maintenance Release) Upgrade immediately.**
* (s2Member/s2Member Pro) **WordPress® v3.4**. Confirmed compatibility with WordPress® v3.4.
* (s2Member/s2Member Pro) **Currency Conversion**. This release updates s2Member's currency conversion API, which is powered by Google®. Please see [this thread](http://www.s2member.com/forums/topic/paypal-agreecontinue-sends-to-memb-options/#post-16972) for further details.
* (s2Member/s2Member Pro) **Payflow® Bug Fix**. This release addresses a bug that existed in s2Member's Payflow® integration with Express Checkout. Resolved in this release. Please see [this thread](http://www.s2member.com/forums/topic/cant-do-recurring-billing-via-paypal-payflow/#post-16966) for further details.
* (s2Member/s2Member Pro) **Character Encoding**. This release fixes a big in s2Member's character encoding conversion, for IPN responses received from PayPal®. This releases also fixes an issue specifically with the pound sterling symbol `£`, which was causing some transient IPN data to become corrupted, under the right scenario.

= v120608 =
* **(Maintenance Release) Upgrade immediately.**
* (s2Member/s2Member Pro) **WordPress® v3.4**. Updated for compatibility with the coming release of [WordPress® v3.4](http://wordpress.org/news/2012/06/wordpress-3-4-release-candidate-2/). Additional details available [here](http://wordpress.org/news/2012/06/wordpress-3-4-release-candidate-2/).
* (s2Member/s2Member Pro) **Payflow® Bug Fix**. This release addresses two bugs that existed in s2Member's Payflow® integration. Resolved in this release. Please see [this thread](http://www.s2member.com/forums/topic/transactions-not-going-through/#post-15896) for further details.
* (s2Member Pro) **PayPal® Express Checkout**. This release enables "PayPal Account Optional" for PayPal® Express Checkout, via s2Member Pro Forms. In other words, this release makes the PayPal® Express Checkout option through Pro Forms, behave more like a standard PayPal® Button; where a customer is not always required to have a PayPal® account during checkout. This functionality is enabled automatically, there's nothing you need to change in your s2Member® integration. However, we do suggest that you turn "PayPal Account Optional" (on) inside your PayPal® account. Please see [this thread](http://www.s2member.com/forums/topic/paypal-express-for-paypal-pro-user/#post-15892) for further details.
* (s2Member) **Documentation**. Code samples for Content Dripping have been updated in the Dashboard, in order to correct a date comparison snippet, which was WRONG. Please check your Dashboard under: `s2Member® -> API Scripting -> Content Dripping -> Example #2`, for the updated code sample.

= v120601 =
* **(Maintenance Release) Upgrade immediately.**
* (s2Member Pro) **ClickBank® Button Shortcodes**. This release works around a bug that has been discovered on the ClickBank® side of things, when a `+` character appears in the `desc=""` attribute of your ClickBank® Button Shortcode. Resolved in this release. Please see [this thread](http://www.s2member.com/forums/topic/clickbank-output-url/#post-15166) for further details.
* (s2Member Pro) **Payflow® Daily Recurrence (Limitation)**. PayPal® Pro accounts with the Payflow® Edition API, are NOT capable of charging on a `daily` recurring basis. Previous releases of s2Member® Pro mistakenly documented this as being possible. Resolved in this release. PayPal® Pro accounts operating with the Payflow® Edition (and integrated with s2Member®), are only capable of charging recurring fees on the following schedules: `weekly, bi-weekly, monthly, quarterly, or yearly`. This is in large part, a limitation in the Payflow® API, which we hope will be resolved by PayPal® in a future version. Please feel free to contact PayPal® if you'd like to vote for this feature! This limitation does NOT affect existing PayPal® Pro accounts operating exclusively under the PayPal® Pro API (e.g. without Payflow®).
* (s2Member Pro) **New ccBill® Shortcodes**. s2Member® Pro now includes two new Shortcode Attributes for ccBill® payment button integrations. These include: `sub_account` and `form`. Making it possible to integrate a single installation of s2Member® Pro with multiple ccBill® sub-accounts, and/or multiple ccBill® forms (as they exist in your ccBill® account). For further details, please read the Shortcode documentation, found in your Dashboard under: `s2Member® -> ccBill® Buttons -> Shortcode Attributes (Explained)`.
* (s2Member/s2Member Pro) **Bug Fix**. A bug related to inaccurate role assignment, under certain scenarios (for administrative accounts). Resolved in this release. Please see [this thread](http://www.s2member.com/forums/topic/inaccurate-role-assignment-in-s2member-pro/#post-14122) for further details.

= v120517 =
* **(Maintenance Release) Upgrade immediately.**
* (s2Member Pro) **PayPal® Pro Forms**. This release removes all limitations on the maximum length of an initial trial/period. It is now possible to offer any number of days/weeks/months/years for free, or at a different initial rate.
* (s2Member Pro) **Authorize.Net® Bug Fix**. Max length (i.e. `maxlength=""`) adjusted in Pro Forms integrating with Authorize.Net. Transactions were sometimes failing due to character length restrictions imposed by the Authorize.Net® API. Fixed in this release. Please see [this thread](http://www.s2member.com/forums/topic/customer-charged-but-not-given-access/#post-13454) for further details.
* (s2Member/s2Member Pro) **JW Player® Code Samples**. Updated code samples for JW Player®, to reduce the possibility of a namespace conflict in configuration variables. For further details, please check [this thread](http://www.s2member.com/forums/topic/jw-player-new-code-conflict/#post-13819).

= v120514 =
* **(Maintenance Release) Upgrade immediately.**
* (s2Member Pro) **Payflow® API Support**. s2Member® Pro now supports PayPal® Pro accounts operating with the Payflow® edition. It is now possible to process recurring payments through newer PayPal® Pro accounts (e.g. those which may use the new Payflow® API for recurring billing). Please note, this feature should ONLY be used by site owners with a brand new PayPal® Pro account, which has Recurring Billing service enabled under the Payflow® edition. Site owners with existing PayPal® Pro accounts are NOT impacted by this feature, nor should they attempt to use this feature. For further details, please check your Dashboard under: `s2Member® -> PayPal® Options -> Payflow® Account Details`.
* (s2Member Pro) **Authorize.Net® Shortcode Attribute**. A new Shortcode Attribute `rrt=""`, is available for Authorize.Net® Pro Forms. For further details, please check your Dashboard under: `s2Member® -> Authorize.Net® Forms -> Shortcode Attributes (Explained)`.
* (s2Member Pro) **Authorize.Net® Bug Fix**. Transactions were sometimes failing due to character length restrictions imposed by the Authorize.Net® API. Fixed in this release. Please see [this thread](http://www.s2member.com/forums/topic/customer-charged-but-not-given-access/#post-13454) for further details.
* (s2Member/s2Member Pro) **Remote Request Hook**. A few developers requested this. A new WordPress® Hook was added to s2Member's remote connection routine. Search s2Member's source code for Hook name: `ws_plugin__s2member_before_wp_remote_request`.
* (s2Member Framework) **PayPal® Buttons**. Restrictions limiting the number of days/weeks/months/years allowed in recurring periods for a PayPal® Button have been increased. Max days was increased from `7` to `90`, weeks remains at `52` max, months is up from `12` to `24` max; years increased from `1`, up to `5` years max. This change impacts PayPal® Standard Buttons only, and does NOT affect Pro Forms, which operate on restrictions imposed by the PayPal® Pro API (and these are slightly different).
* (s2Member/s2Member Pro) **JW Player® Code Samples**. Updated code samples for JW Player®. For further details, please check your Dashboard under: `s2Member® -> Download Options -> JW Player® Code Samples`.

= v120309 =
* (s2Member Pro) **ccBill® Cancellations**. It's now possible for s2Member to pull ccBill® "cancellation" events, from the ccBill® DataLink Service Suite. For further details and configuration options, please check this section of your Dashboard: `s2Member -> ccBill Options -> DataLink Integration`.
* (s2Member/s2Member Pro) **Bug fix**. Some PHP installations running in safe mode were experiencing `400 Bad Request` errors whenever s2Member's Amazon® CloudFront configuration routines for file downloads were processed. Fixed in this release.

= v120308 =
* (s2Member/s2Member Pro) **Custom Registration/Profile Fields**. Now possible to create a Custom Field that's always hidden, during both registration and any future Profile edits (e.g. for administrative purposes only).
* (s2Member/s2Member Pro) **Compatibility**. Minor updates for compatibility with the coming release of WordPress® v3.4.
* (s2Member Pro) **Bug fix**. Broken link in UI leading to: `s2m-pro-extras.zip`. Corrected in this release.

= v120301 =
* (s2Member Pro) **ClickBank**. Bug fix in call to `http_build_query()` related to `arg_separator`. This affected installations of PHP with something other than a default INI value for argument separators. Fixed in this release for better compatibility.
* (s2Member/s2Member Pro) **File downloads**. Bug fix in s2Member's handling of the `"file_storage"` parameter to API Function `s2member_file_download_url()`. Fixed in this release.

= v120219 =
* (s2Member) **File downloads**. s2Member's `.htaccess` rules updated to also support older versions of the Apache 1.x series. However, we still recommend that you run s2Member® with Apache 2.0 or higher. Or, with another modern web server that's Apache-compatible, such as [LiteSpeed](http://litespeedtech.com/).
* (s2Member) **Link updates**. Some of the documentation built into the s2Member® plugin contained links which were outdated after our recent move to the new [s2Member.com](http://www.s2member.com/). These links have now been updated within the plugin.
* (s2Member) **New video tutorial**. [s2Member® Intros, Framework and Pro](http://www.s2member.com/videos/85E41C40550808C2/)
* (s2Member) **New video tutorial**. [s2Member® File Downloads, Complete Series / From Basics On Up](http://www.s2member.com/videos/7547A199A4385310/)
* (s2Member) **New video tutorial**. [s2Member® File Downloads, Amazon S3/CloudFront/JW Player](http://www.s2member.com/videos/BD496E5F2CCAB12A/)
* (s2Member) **New video tutorial**. [s2Member® File Downloads, Remote Auth/Podcasting](http://www.s2member.com/videos/71F49478D6983A9C/)
* (s2Member) **New video tutorial**. [s2Member® File Downloads, GZIP Conflicts?](http://www.s2member.com/videos/038A4033A8D2A2EB/)
* (s2Member) **New video tutorial**. [s2Member®, Using The PayPal Sandbox](http://www.s2member.com/videos/A7AEF89D281A75A0/)

= v120213 =
* (s2Member) **File downloads**. GZIP conflicts can now been resolved for file downloads. s2Member now introduces an `.htaccess` rewrite rule, which is automatically installed during activation and/or a future upgrade of the s2Member® Framework plugin. These rewrite rules are installed into your root `.htaccess` file for WordPress (if it's writable). If your `.htaccess` file is not writable, you will get a warning in your `s2Member -> Download Options` panel.

 For further details, please check your Dashboard under: `s2Member -> Download Options -> Preventing GZIP Conflicts`. Or see [this KB article](http://www.s2member.com/kb/resolving-problems-with-file-downloads/).
* (s2Member) **Optimization**. Slow query w/ memory issues during activation on a Multisite Network with over 30K Users/Members. Fixed in this release.
* (s2Member) **Compatibility**. Litespeed web server compatibility added to all areas of s2Member. A few `mod_rewrite` tweaks were needed. Fixed in this release.
* (s2Member) **Bug fix**. Automatic list transitioning issue, which was affected by Payment Button integrations where s2Member's Auto-Return handler was getting in the way. Fixed in this release.
* (s2Member/s2Member Pro) **Bug fix.** Due to an issue that once existed in releases of s2Member prior to v110927, s2Member's Auto EOT System was sometimes failing to succeed in cases where no IPN Signup Vars could be found (but only for Members who originally joined under a release of s2Member prior to v110927). s2Member v120213 resolves this elusive bug with a built-in workaround (i.e. a built-in default value in the code), specifically for this scenario.
* (s2Member Pro) **Bug fix.** If Membership Levels were changed with s2Member Pro via `/wp-config.php` using `define("MEMBERSHIP_LEVELS", 1)` or similar; s2Member was failing to cleanup all unused Capabilities in the `wp_user_roles` array, which may have been associated with previously used Membership Levels. This had no harmful side effects, but it was a bug nevertheless. Upgrading to the latest installation of s2Member automatically cleans up any Capabilities this bug left behind. New installations of s2Member will not be affected by this at all.
* (s2Member/s2Member Pro) **Routine maintenance.** Overall review of the codebase, security review, general code cleanup and maintenance.
* (s2Member) **New website.** A new website has been launched for s2Member. Please see: [s2Member.com](http://www.s2member.com/)
* **Coming soon.** Work continues on the next generation of s2Member®.

= v111220 - 1.0 =
* ... trimmed away at v111220.
* Initial release: v1.0.