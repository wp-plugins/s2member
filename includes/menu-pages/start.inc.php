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
Flow Of Events page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . esc_attr (c_ws_plugin__s2member_readmes::parse_readme_value ("Plugin URI")) . '" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/brand-light.png" alt="." /></a></div>s2Member / Quick-Start Guide</h2>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<table class="ws-menu-page-table">' . "\n";
echo '<tbody class="ws-menu-page-table-tbody">' . "\n";
echo '<tr class="ws-menu-page-table-tr">' . "\n";
echo '<td class="ws-menu-page-table-l">' . "\n";
/**/
do_action ("ws_plugin__s2member_during_start_page_before_left_sections", get_defined_vars ());
/**/
if (apply_filters ("ws_plugin__s2member_during_start_page_during_left_sections_display_video_tutorials", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_before_video_tutorials", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Video Tutorials ( recommended )" style="padding-top:5px;">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-registration-process-section">' . "\n";
		echo '<p><embed type="application/x-shockwave-flash" src="//www.youtube.com/p/A40AFC154461862E?version=3&hd=1&fs=1&rel=0" width="100%" height="550" allowscriptaccess="always" allowfullscreen="true"></embed></p>' . "\n";
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_during_video_tutorials", get_defined_vars ());
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_after_video_tutorials", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_start_page_during_left_sections_display_registration_process", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_before_registration_process", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="The Registration Process">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-registration-process-section">' . "\n";
		echo '<h3>The Subscription Signup/Registration Process</h3>' . "\n";
		echo '<p>1. Internet Users will go to your Membership Options Page ( which you\'ll need to configure on the s2Member General Options panel ). On this Membership Options Page, that YOU will create in WordPress®, you\'ll insert the PayPal® Subscription Buttons that were generated for you by s2Member.</p>' . "\n";
		echo '<p>2. An Internet User will click on a PayPal® Subscription Button from your Membership Options Page. They will be transferred over to PayPal® in order to agree to your Membership terms and pricing. You can customize the Checkout Page Style, Pricing, Payment Periods, and more - whenever you generate your PayPal® Buttons through s2Member.</p>' . "\n";
		echo '<p>3. Once a User has completed the Subscription Signup Process at PayPal®, they\'ll be returned to your site, where they\'ll be activated by s2Member instantly, and given the opportunity to register a Username &amp; Password for their Membership. ( Note: they\'ll be allowed to register a Username &amp; Password, even if you\'ve set \'Anyone Can Register\' to `Off` in your General WordPress® options; because s2Member identifies the User as having paid for Membership access through PayPal® ).</p>' . "\n";
		echo '<p>s2Member will also send the User an email with instructions on how to register their Username &amp; Password, just in case they missed the instructions after checkout. That email will be sent to their PayPal® email address. Much of this is handled through the PayPal® IPN service behind-the-scene, where PayPal® and s2Member communicate with each other.</p>' . "\n";
		echo '<p>4. Once a User has completed checkout and registered a Username &amp; Password, they\'ll be able to login. The first page they\'ll see after logging in, will be your Login Welcome Page ( which you\'ll need to configure on the s2Member General Options panel ). Your Login Welcome Page can contain whatever you like. You\'ll need to design this Page in WordPress®, and be creative!</p>' . "\n";
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_during_registration_process", get_defined_vars ());
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_after_registration_process", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_start_page_during_left_sections_display_log_reg_form", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_before_log_reg_form", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Your Login/Registration Form">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-login-reg-form-section">' . "\n";
		echo '<h3>Your Login/Registration Form ( already built-in )</h3>' . "\n";
		echo '<p>s2Member uses the existing WordPress® Login/Registration system. This is the same Login/Registration Form that you use to access your WP® Dashboard. However, with s2Member installed, your Login/Registration Forms can be customized <em>( re-branded )</em>. <em>See: <code>s2Member -> General Options -> Login/Registration Design</code>.</em> You can make the default Login/Registration Forms match your WordPress® theme design; by changing the background color/image, your logo image, add Custom Fields, and more<em>!</em></p>' . "\n";
		echo '<p>Since s2Member uses the default Login/Registration system for WordPress®, s2Member is also compatible with themes, and other plugins ( such as BuddyPress ). If your theme has a login form built-in already, chances are, it\'s perfectly compatible with s2Member. There are also many plugins available that are designed to place login forms into your Sidebar; and many of those are also compatible with s2Member\'s integration.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_during_log_reg_form", get_defined_vars ());
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_after_log_reg_form", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_start_page_during_left_sections_display_login_welcome_page", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_before_login_welcome_page", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Your Login Welcome Page">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-login-welcome-page-section">' . "\n";
		echo '<h3>Your Login Welcome Page ( you create this in WordPress® )</h3>' . "\n";
		echo '<p>YOU, will create this special Page in WordPress®. This is a "Page", not a Post. This is the first page Members will see after logging into your site. You should go ahead and create an empty Page now, before you start configuring everything. Title it: <code>My Login Welcome Page</code>, and then click Publish. Once you have your s2Member -> General Options configured, and you\'ve got a good understanding for how things work, go back and customize the title and content for this Page. You\'ll want to be creative with your Login Welcome Page. However, you should configure your General Options first, and test things out. That way you\'ll understand why this Page is important.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_during_login_welcome_page", get_defined_vars ());
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_after_login_welcome_page", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_start_page_during_left_sections_display_membership_options_page", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_before_membership_options_page", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Your Membership Options Page">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-membership-options-page-section">' . "\n";
		echo '<h3>Your Membership Options Page ( you create this in WordPress® )</h3>' . "\n";
		echo '<p>YOU, will create this special Page in WordPress®. This is a "Page", not a Post. s2Member comes with a PayPal® Button Generator. You will generate PayPal® Buttons with s2Member, for each Membership Level that you plan to offer. Those buttons will be inserted into your Membership Options Page. If a User in the general public, attempts to access an area of your site that is being protected by s2Member ( based on your configuration ), s2Member will redirect the User to your Membership Options Page, where they can signup through PayPal® and become a Member.</p>' . "\n";
		echo '<p>You should go ahead and create an empty Page now, before you start configuring everything. Title it: <code>My Membership Options Page</code>, and then click Publish. Once you have your s2Member -> General Options configured, and you\'ve got a good understanding for how things work, go back and customize the title and content for this Page. You\'ll want to be creative with your Membership Options Page. However, you should configure your General Options first, and test things out. That way you\'ll understand why this Page is important.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_during_membership_options_page", get_defined_vars ());
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_after_membership_options_page", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_start_page_during_left_sections_display_general_options", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_before_general_options", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Your s2Member -> General Options">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-general-options-section">' . "\n";
		echo '<h3>Your s2Member -> General Options ( basic configuration )</h3>' . "\n";
		echo '<p>Once you have a Login Welcome Page, and a Membership Options Page. Go to: <code>s2Member -> General Options</code>.</p>' . "\n";
		echo '<p>From your s2Member General Options Panel, you may restrict access to certain Posts, Pages, Tags, Categories, and/or URIs based on a Member\'s Level. The s2Member Options Panel makes it easy for you. All you do is type in the basics of what you want to restrict access to, and those sections of your site will be off limits to non-Members.' . ( (!is_multisite () || !c_ws_plugin__s2member_utils_conds::is_multisite_farm () || is_main_site ()) ? ' That being said, there are times when you might need to have greater control over which portions of your site can be viewed by non-Members, or Members at different Levels. This is where API Scripting with Conditionals comes in. <em>For more information, see: <code>s2Member -> API Scripting</code></em>.' : '') . '</p>' . "\n";
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_during_general_options", get_defined_vars ());
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_after_general_options", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_start_page_during_left_sections_display_automation_process", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_before_automation_process", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Subscription Cancellations">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-automation-process-section">' . "\n";
		echo '<h3>Subscription Cancellations / Expirations / Terminations</h3>' . "\n";
		echo '<p>You\'ll be happy to know that s2Member handles cancellations, expirations, failed payments, terminations ( e.g. refunds &amp; chargebacks ) for you automatically. If you log into your PayPal® account and cancel a Member\'s Subscription, or, if the Member logs into their PayPal® account and cancels their own Subscription, s2Member will be notified of these important changes and react accordingly through the PayPal® IPN service that runs silently behind-the-scene.</p>' . "\n";
		echo '<p>The PayPal® IPN service will notify s2Member whenever a Member\'s payments have been failing, and/or whenever a Member\'s Subscription has expired for any reason. Even refunds &amp; chargeback reversals are supported through the IPN service. If you issue a refund to an unhappy Customer through PayPal®, s2Member will be notified, and the account for that Customer will either be demoted to a Free Subscriber, or deleted automatically ( based on your configuration ). The communication from PayPal® -> s2Member is seamless.</p>' . "\n";
		echo '<p><em><strong>*Some Hairy Details*</strong> There might be times whenever you notice that a Member\'s Subscription has been cancelled through PayPal®... but, s2Member continues allowing the User  access to your site as a paid Member. Please don\'t be confused by this... in 99.9% of these cases, the reason for this is legitimate. s2Member will only remove the User\'s Membership privileges when an EOT ( End Of Term ) is processed, a refund occurs, a chargeback occurs, or when a cancellation occurs - which would later result in a delayed Auto-EOT by s2Member. s2Member will not process an EOT until the User has completely used up the time they paid for. In other words, if a User signs up for a monthly Subscription on Jan 1st, and then cancels their Subscription on Jan 15th; technically, they should still be allowed to access the site for another 15 days, and then on Feb 1st, the time they paid for has completely elapsed. At that time, s2Member will remove their Membership privileges; by either demoting them to a Free Subscriber, or deleting their account from the system ( based on your configuration ). s2Member also calculates one extra day ( 24 hours ) into its equation, just to make sure access is not removed sooner than a Customer might expect.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_during_automation_process", get_defined_vars ());
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_after_automation_process", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_start_page_during_left_sections_display_upgrading_downgrading", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_before_upgrading_downgrading", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Upgrading/Downgrading Accounts">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-upgrading-downgrading-section">' . "\n";
		echo '<h3>Upgrading And/Or Downgrading User Accounts</h3>' . "\n";
		echo '<p>s2Member builds upon existing functionality offered through WordPress® Roles and Capabilities. From your WordPress® Dashboard, go to: <code>Users</code>. You can use bulk actions to modify Member Access Levels all at once, or click on an individual Member account to modify only their specific Access Level. If you want to temporarily demote a Member so they cannot access Membership privileges, set their Role to Subscriber. When you\'re ready to give them their Membership privileges back, change their Role back to one of the s2Member Levels.</p>' . "\n";
		echo '<p>All financial details, such as pricing, trial periods, subscription lengths, refunds, and other Customer service issues; should be handled by YOU, through your PayPal® account, and NOT through WordPress®. Feel free to modify your Members\' Subscriptions via PayPal® as often as you like. s2Member will be notified through the PayPal® IPN service behind-the-scene automatically. For example... If you log into PayPal® and cancel a Member\'s paid Subscription, s2Member will be notified by PayPal® behind-the-scene, and s2Member will remove their Membership privileges at the correct point in time.</p>' . "\n";
		echo '<p>That being said, if you log into your WordPress® Dashboard and delete a Member\'s account, you will still need to log into PayPal® and cancel billing for the account you deleted. In other words, s2Member can be notified automatically about actions you take inside PayPal\'s interface, but PayPal® CANNOT be notified of actions you take inside your WordPress® Dashboard. At least, not in an automated fashion, as that would create a security issue for PayPal®. So... automation works seamlessly from PayPal® -> to s2Member, but NOT the other way around.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_during_upgrading_downgrading", get_defined_vars ());
		echo '</div>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr ws-plugin--s2member-subscription-modification-section-hr"></div>' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-subscription-modification-section">' . "\n";
		echo '<h3>Giving Members The Ability To Modify Their Own Subscription</h3>' . "\n";
		echo '<p>If you\'d like to give your Members ( and/or your Free Subscribers ) the ability to modify their billing plan, by switching to a more expensive option, or a less expensive option; generate a new PayPal® Modification Button, using the s2Member PayPal® Button Generator. Configure the updated Level, pricing, terms, etc. Then, make that new Modification Button available to Members who are logged into their existing account with you. For example, you might want to insert a "Level #2" Upgrade Button into your Login Welcome Page, which would up-sell existing Level #1 Members to a more expensive plan that you offer.</p>' . "\n";
		echo '<p><em><strong>*Modification Process*</strong> When you send a Member to PayPal® using a Subscription Modification Button, PayPal® will ask them to login. Once they\'re logged in, instead of being able to signup for a new Membership, PayPal® will provide them with the ability to upgrade and/or downgrade their existing Membership with you, by allowing them to switch to the Membership Plan that was specified in the Subscription Modification Button. PayPal® handles this nicely, and you\'ll be happy to know that s2Member has been pre-configured to deal with this scenario as well, so that everything remains automated. Their Membership Access Level will either be promoted, or demoted, based on the actions they took at PayPal® during the modification process. Once an existing Member completes their Subscription Modification at PayPal®, they\'ll be brought back to their Login Welcome Page, instead of sending them to a registration screen.</em></p>' . "\n";
		echo '<p><em><strong>*Also Works For Free Subscribers*</strong> Although a Free Subscriber does not have an existing PayPal® Subscription, s2Member is capable of adapting to this scenario gracefully. Just make sure that your existing Free Subscribers ( the ones who wish to upgrade ) pay for their Membership through a Modification Button generated by s2Member. That will allow them to continue using their existing account with you. In other words, they can keep their existing Username ( and anything already associated with that Username ), rather than being forced to re-register after checkout.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_before_upgrading_downgrading_modifications", get_defined_vars ());
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_after_upgrading_downgrading", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_start_page_during_left_sections_display_reg_before_checkout", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_before_reg_before_checkout", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Registration Before Checkout?">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-reg-before-checkout-section">' . "\n";
		echo '<h3>Registration Before Checkout? ( reversing the process )</h3>' . "\n";
		echo '<p>By default, s2Member will send a Customer directly to PayPal®, and only after checkout is completed does the Customer have the ability to register a Username/Password for access to your site. This process works very well in most cases, and it has the benefit of increasing conversion rates; because there are fewer obstacles for the Customer on their way to the actual checkout process at PayPal®.</p>' . "\n";
		echo '<p>That being said, we believe the "ideal" approach is a combined Checkout/Registration process; in just one simple step ( available with s2Member Pro via PayPal® Pro integration ). But even with PayPal® Standard integration, there is a way to accomplish (registration before checkout), thereby reversing the process — if you prefer it that way. This is accomplished by turning Open Registration <code>(on)</code>, and then making a PayPal® Button available to Free Subscribers at Level #0. In other words, you can let visitors register for free at Level #0, then charge them for access to higher Member Levels [1-4]. For further details, please check your WordPress® Dashboard under: <code>s2Member -> General Options -> Open Registration</code>. If you\'re running a Multisite Network, see: <code>s2Member -> Multisite (Config) -> Registration Configuration</code>.</p>' . "\n";
		echo '<p><em>s2Member\'s Simple Conditionals can help you further integrate this process, by allowing you to integrate a special PayPal® Button on your Login Welcome Page; one that will be seen only by Free Subscribers at Level #0. Please check your WordPress® Dashboard under: <code>s2Member -> API Scripting -> Simple Conditionals</code>. We also suggest reading over the documentation on PayPal® Modification Buttons. See: <code>s2Member -> PayPal® Buttons -> Subscription Modifications</code>.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_during_reg_before_checkout", get_defined_vars ());
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_start_page_during_left_sections_after_reg_before_checkout", get_defined_vars ());
	}
/**/
do_action ("ws_plugin__s2member_during_start_page_after_left_sections", get_defined_vars ());
/**/
echo '</td>' . "\n";
/**/
echo '<td class="ws-menu-page-table-r">' . "\n";
/**/
do_action ("ws_plugin__s2member_during_start_page_before_right_sections", get_defined_vars ());
do_action ("ws_plugin__s2member_during_menu_pages_before_right_sections", get_defined_vars ());
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["upsell-pro"]) ? '<div class="ws-menu-page-others"><a href="' . esc_attr (c_ws_plugin__s2member_readmes::parse_readme_value ("Pro Module / Prices")) . '" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/brand-upsell-pro.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["installation"]) ? '<div class="ws-menu-page-installation"><a href="' . esc_attr (c_ws_plugin__s2member_readmes::parse_readme_value ("Professional Installation URI")) . '" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/brand-installation.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["tools"]) ? '<div class="ws-menu-page-tools"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/brand-tools.png" alt="." /></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["videos"]) ? '<div class="ws-menu-page-videos"><a href="' . esc_attr (c_ws_plugin__s2member_readmes::parse_readme_value ("Video Tutorials")) . '" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/brand-videos.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["support"]) ? '<div class="ws-menu-page-support"><a href="' . esc_attr (c_ws_plugin__s2member_readmes::parse_readme_value ("Forum URI")) . '" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/brand-support.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["donations"]) ? '<div class="ws-menu-page-donations"><a href="' . esc_attr (c_ws_plugin__s2member_readmes::parse_readme_value ("Donate link")) . '" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/brand-donations.jpg" alt="." /></a></div>' . "\n" : '';
/**/
do_action ("ws_plugin__s2member_during_menu_pages_after_right_sections", get_defined_vars ());
do_action ("ws_plugin__s2member_during_start_page_after_right_sections", get_defined_vars ());
/**/
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
/**/
echo '</div>' . "\n";
?>