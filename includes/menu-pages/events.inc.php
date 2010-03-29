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
Flow of events page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member Flow Of Events</h2>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<table class="ws-menu-page-table">' . "\n";
echo '<tbody class="ws-menu-page-table-tbody">' . "\n";
echo '<tr class="ws-menu-page-table-tr">' . "\n";
echo '<td class="ws-menu-page-table-l">' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="The Registration Process">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-registration-process-section">' . "\n";
echo '<h3>The Subscription Registration Process</h3>' . "\n";
echo '<p>1. Internet Users will go to your Membership Options Page ( which you\'ll need to configure on the s2Member General Options panel ). On this Membership Options Page, that YOU will create in WordPress®, you\'ll insert the PayPal® Subscription Buttons that were generated for you by s2Member.</p>' . "\n";
echo '<p>2. An Internet User will click on a PayPal® Subscription Button from your Membership Options Page. They will be transferred over to PayPal® in order to agree to your membership terms and pricing. You can customize the Checkout Page Style, Pricing, Payment Periods, and more whenever you generate your PayPal® Buttons through s2Member.</p>' . "\n";
echo '<p>3. Once a User has completed the Subscription Signup Process at PayPal®, they\'ll be returned to your site, where they\'ll be activated by s2Member instantly, and given the opportunity to register a Username &amp; Password for their membership on the next page ( note: they\'ll be allowed to register a Username &amp; Password, even if you\'ve set \'Anyone Can Register\' to `Off` in your General WordPress® options, because s2Member identifies the user as having paid for membership access through PayPal® ). s2Member will also send the User an email with instructions on how to register their Username &amp; Password, just in case they missed the instructions after checkout. That email will be sent to their PayPal® email address. And it will be sent even if they never returned to your site after checkout for some reason. Much of this is handled through the PayPal® IPN service behind the scenes, where PayPal® and s2Member communicate with each other.</p>' . "\n";
echo '<p>4. Once a User has completed checkout and registered a Username &amp; Password, they\'ll be able to login. The first page they\'ll see after logging in, will be your Login Welcome Page ( which you\'ll need to configure on the s2Member General Options panel ). Your Login Welcome Page can contain whatever you like. Feel free to be creative whenever you create this Page in WordPress®.</p>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Subscription Cancellations">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-automation-process-section">' . "\n";
echo '<h3>Subscription Cancellations / Expirations / Terminations</h3>' . "\n";
echo '<p>You\'ll be happy to know that s2Member handles cancellations, expirations, failed payments ( more than 2 in a row ), terminations ( e.g. refunds &amp; chargebacks ) for you automatically. If you log into your PayPal® account and cancel a User\'s subscription, or, if the User logs into their PayPal® account and cancels their own subscription, s2Member will be notified of these important changes and react accordingly through the PayPal® IPN service that runs silently behind the scenes. The PayPal® IPN service will notify s2Member whenever a User\'s payments have been failing ( more than 2 times in a row ), and/or whenever a User\'s subscription has expired for any reason. Even refunds &amp; chargeback reversals are supported through the IPN service. If you issue a refund to an unhappy customer through PayPal®, s2Member will be notified, and the account for that customer will be deleted automagically. The communication from PayPal® -> s2Member is seamless. You may also want to check the s2Member API Options panel. You\'ll find additional layers of automation available through the use of the `Signup`, `Payment`, `EOT/Deletion` and `Refund/Reversal` notifications that are available to you through the s2Member API. These make it easy to integrate with 3rd party applications like affiliate programs and other back-office routines.</p>' . "\n";
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-hr ws-plugin--s2member-automation-hairy-details-section-hr"></div>' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-automation-hairy-details-section">' . "\n";
echo '<h3>Subscription Cancellations / Some Hairy Details With Dates</h3>' . "\n";
echo '<p>There might be times whenever you notice that a User\'s subscription has been cancelled through PayPal®... but, s2Member continues to allow the User to access your site as a paid member. Please don\'t be confused by this... in 99.9% of these cases, the reason for this is legitimate. s2Member will only remove the User\'s membership privileges when PayPal® sends the SUBSCR_EOT notification via the IPN service. PayPal® will sometimes wait to send this SUBSCR_EOT notification until the User has completely used up the time they paid for. In other words, if a User signs up for a monthly subscription on Jan 1st, and then cancels their subscription on Jan 15th; technically, they should still be allowed to access the site for another 15 days, and then on Feb 1st, the time they paid for has completely elapsed and PayPal® will send the SUBSCR_EOT notification to s2Member. At that time, s2Member will remove their membership privileges by deleting their account from the system automatically.</p>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Upgrading/Downgrading Accounts">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-upgrading-downgrading-section">' . "\n";
echo '<h3>Upgrading And/Or Downgrading User Accounts</h3>' . "\n";
echo '<p>s2Member builds upon existing functionality offered through WordPress® Roles and Capabilities. From your WordPress® Dashboard, go to: Users -> Authors &amp; Users. You can use the bulk actions to modify User access levels all at once, or click on an individual User account to modify only their specific access level. If you want to temporarily demote a user so that they cannot access membership priveledges, set their Role to Subscriber. When you\'re ready to give them their membership priviledges back, change their Role back to one of the s2Member levels. NOTE: All financial details, such as pricing, trial periods, subscription lengths, refunds, and other customer service issues should be handled by YOU, through your PayPal® account, and NOT through WordPress®. Feel free to modify your Users\' Subscription via PayPal® as often as you like. s2Member will be notified through the PayPal® IPN service behind the scenes automatically. For example... If you log into PayPal® and cancel a User\'s paid Subscription, s2Member will be notified by PayPal® behind the scenes, and s2Member will remove their membership priviledges at the correct point in time. That being said, if you log into your WordPress® Dashboard and delete a User account, you will still need to log into PayPal® and cancel the billing for the account you deleted. In other words, s2Member can be notified automatically about actions you take inside PayPal\'s interface, but PayPal® cannot be notified of actions you take inside your WordPress® Dashboard, at least not in an automated fashion, as that would create a security issue for PayPal® users. So automation works seamlessly from PayPal® -> to s2Member, but not the other way around.</p>' . "\n";
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-hr ws-plugin--s2member-subscription-modification-section-hr"></div>' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-subscription-modification-section">' . "\n";
echo '<h3>Giving Members The Ability To Modify Their Subscription</h3>' . "\n";
echo '<p>Using the PayPal® Subscription Buttons that were generated for you by s2Member, look for this input variable ( modify=0 ) and change that to ( modify=2 ). Now you can simply provide your Subscription Modification Buttons to existing members wherever you feel they would be appropriate on your site. We suggest placing these on the Login Welcome Page that you create in WordPress®, that way they\'re not available to the general public, only to members who are logged in. When an existing member clicks one of these Subscription Modification Buttons, they\'ll be taken to PayPal® just like they would if they were setting up a new account. But, once they actually get logged in over at PayPal®, the flow of events that occur next will be slightly different than they are normally. The Subscription Modification Buttons cause their system to react differently.</p>' . "\n";
echo '<p>When you send a member to PayPal® using a Subscription Modification Button, instead of being able to signup for a new membership, PayPal® will provide them with the ability to upgrade and/or downgrade their existing membership with you, by allowing them to switch to the one that was specified in the Subscription Modification Button. PayPal® handles this nicely, and you\'ll be happy to know that s2Member has been pre-configured to deal with this scenario as well so that everything remains automated. Their Membership Access Level will either be promoted or demoted based on the actions they took at PayPal® during the modification process. Once a user completes their Subscription Modification at PayPal®, they\'ll be brought back to the Login Welcome Page instead of to the registration screen like they would if they had just signed up.</p>' . "\n";
echo '<p>Now, that was pretty easy. However, there are situations when this will NOT work using the ( modify=2 ) solution. For example, if you offer your visitors a subscription option that does NOT recur, then PayPal® will not allow them to modify to a different plan that you offer, because there is no recurring payment associated with the existing subscription they have with you. Another example is when you have a member who WAS setup to recur, but their subscription has expired or been cancelled; so it is no longer recurring. In other words, PayPal® will ONLY play nice on the ( modify=2 ) approach, if the existing subscription ( the one that needs to be modified ) is still active and setup to recur. Luckily, this is usually not a problem, because in most cases a modification is being requested to adjust a monthly or yearly fee, not to stop or start anything.</p>' . "\n";
echo '<p>In those rare cases when you need to send an existing Customer over to PayPal® and have them signup for a new ( different ) subscription, without needing to re-register for a new account, you can add the following two variables to your Button Code. Add ( on0 = Update Subscription ID ), and set ( os0 = [Their existing Subscription ID] ). Adding these two `special` input variables will allow s2Member to work seamlessly with PayPal® after they signup. Instead of asking them to re-register for a new account, s2Member will update their existing account and provide responses similar to what you would see using the ( modify=2 ) approach.</p>' . "\n";
echo '<p>In that scenario, when you need to send an existing Customer over to PayPal® and have them signup for a new ( different ) subscription, without forcing them to re-register for a new account afterward, you can add the following two variables to your Button Code. Add ( on0 = "Update Subscription ID" ), and set ( os0 = "[Their existing Subscription ID]" ). Adding these two additional input variables will allow s2Member to work seamlessly with PayPal® after they signup. Instead of asking them to re-register for a new account, s2Member will update their existing account and provide responses similar to what you would see using the ( modify=2 ) approach. You can use the s2Member Constants in PHP to access any users\' Subscription ID. We have provided an example below.</p>' . "\n";
echo '<p><strong>S2MEMBER_CURRENT_USER_SUBSCR_ID</strong> = their existing subscription ID</p>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/con-samps/current_user_subscr_id.php"), true) . '</p>' . "\n";
echo '<div class="ws-menu-page-hr"></div>' . "\n";
echo '<p>' . highlight_string (file_get_contents (dirname (__FILE__) . "/mod-samps.php"), true) . '</p>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
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