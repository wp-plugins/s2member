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
PayPal® Button Generating page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member / PayPal® Button Codes</h2>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<table class="ws-menu-page-table">' . "\n";
echo '<tbody class="ws-menu-page-table-tbody">' . "\n";
echo '<tr class="ws-menu-page-table-tr">' . "\n";
echo '<td class="ws-menu-page-table-l">' . "\n";
/**/
if (get_option ("ws_plugin__s2member_configured") && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"])
	{
		echo '<form method="post" name="ws_plugin__s2member_buttons_form" id="ws-plugin--s2member-buttons-form">' . "\n";
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Buttons For Level #1 Access">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-button-code-1-section">' . "\n";
		echo '<h3>Button Code Generator For Level #1 Access</h3>' . "\n";
		echo '<p>Very simple. All you do is customize the form fields provided, for each Membership Level that you plan to offer. Then press (Generate Button Code). These special PayPal® Buttons are customized to work with s2Member seamlessly. Member accounts will be activated instantly, in an automated fashion. When you, or a Member, cancels their membership, or fails to make payments on time, s2Member will automatically terminate their membership privileges. s2Member makes extensive use of the PayPal® IPN service. s2Member receives updates from PayPal® behind-the-scene.</p>' . "\n";
		echo '<p><em>* Buttons are NOT saved here. This is only a Button Generator. Once you\'ve generated your Button, copy/paste it into your Membership Options Page. If you lose your Button Code, you\'ll need to come back &amp; re-generate a new one. If you\'re in Sandbox Test-Mode, and you\'re NOT using the Shortcode Format, please remember to come back and re-generate your Buttons before you go live.</em></p>' . "\n";
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-level1-shortcode">' . "\n";
		echo 'Button Code<br />For Level #1:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-level1-button-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<p id="ws-plugin--s2member-level1-trial-line">I\'ll offer the first <input type="text" id="ws-plugin--s2member-level1-trial-period" value="0" size="2" /> <select id="ws-plugin--s2member-level1-trial-term"><option value="D" selected="selected">Days</option><option value="W">Weeks</option><option value="M">Months</option><option value="Y">Years</option></select> free.</p>' . "\n";
		echo '<p><span id="ws-plugin--s2member-level1-trial-then">Then, </span>I want to charge: $<input type="text" id="ws-plugin--s2member-level1-amount" value="0.01" size="4" /> / <select id="ws-plugin--s2member-level1-term"><optgroup label="Recurring Subscriptions"><option value="1-D-1">Daily ( recurring charge, for ongoing access )</option><option value="1-W-1">Weekly ( recurring charge, for ongoing access )</option><option value="1-M-1" selected="selected">Monthly ( recurring charge, for ongoing access )</option><option value="3-M-1">Quarterly ( recurring charge, for ongoing access )</option><option value="1-Y-1">Yearly ( recurring charge, for ongoing access )</option></optgroup><optgroup label="Days / Non-Recurring"><option value="1-D-0">One Time ( for 1 day access, non-recurring )</option><option value="2-D-0">One Time ( for 2 day access, non-recurring )</option><option value="3-D-0">One Time ( for 3 day access, non-recurring )</option><option value="4-D-0">One Time ( for 4 day access, non-recurring )</option><option value="5-D-0">One Time ( for 5 day access, non-recurring )</option><option value="6-D-0">One Time ( for 6 day access, non-recurring )</option></optgroup><optgroup label="Weeks / Non-Recurring"><option value="1-W-0">One Time ( for 1 week access, non-recurring )</option><option value="2-W-0">One Time ( for 2 week access, non-recurring )</option><option value="3-W-0">One Time ( for 3 week access, non-recurring )</option></optgroup><optgroup label="Months / Non-Recurring"><option value="1-M-0">One Time ( for 1 month access, non-recurring )</option><option value="2-M-0">One Time ( for 2 month access, non-recurring )</option><option value="3-M-0">One Time ( for 3 month access, non-recurring )</option><option value="4-M-0">One Time ( for 4 month access, non-recurring )</option><option value="5-M-0">One Time ( for 5 month access, non-recurring )</option><option value="6-M-0">One Time ( for 6 month access, non-recurring )</option></optgroup><optgroup label="Years / Non-Recurring"><option value="1-Y-0">One Time ( for 1 year access, non-recurring )</option><option value="2-Y-0">One Time ( for 2 year access, non-recurring )</option><option value="3-Y-0">One Time ( for 3 year access, non-recurring )</option><option value="4-Y-0">One Time ( for 4 year access, non-recurring )</option><option value="5-Y-0">One Time ( for 5 year access, non-recurring )</option></optgroup><optgroup label="Lifetime / Buy Now / Non-Recurring / No Trial"><option value="1-L-0">Buy Now ( for lifetime access, no-trial, non-recurring )</option></optgroup></select></p>' . "\n";
		echo '<p>Checkout Page Style <a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. You can add your own header image and color selection to the checkout form. Once you\\\'ve created a Custom Page Style at PayPal®, you can enter that Page Style here.\'); return false;">[?]</a>: <input type="text" id="ws-plugin--s2member-level1-page-style" value="paypal" size="18" /> <select id="ws-plugin--s2member-level1-currency"><optgroup label="Currency"><option value="USD" title="U.S. Dollar">USD</option><option value="AUD" title="Australian Dollar">AUD</option><option value="BRL" title="Brazilian Real">BRL</option><option value="CAD" title="Canadian Dollar">CAD</option><option value="CZK" title="Czech Koruna">CZK</option><option value="DKK" title="Danish Krone">DKK</option><option value="EUR" title="Euro">EUR</option><option value="HKD" title="Hong Kong Dollar">HKD</option><option value="HUF" title="Hungarian Forint">HUF</option><option value="ILS" title="Israeli New Sheqel">ILS</option><option value="JPY" title="Japanese Yen">JPY</option><option value="MYR" title="Malaysian Ringgit">MYR</option><option value="MXN" title="Mexican Peso">MXN</option><option value="NOK" title="Norwegian Krone">NOK</option><option value="NZD" title="New Zealand Dollar">NZD</option><option value="PHP" title="Philippine Peso">PHP</option><option value="PLN" title="Polish Zloty">PLN</option><option value="GBP" title="Pound Sterling">GBP</option><option value="SGD" title="Singapore Dollar">SGD</option><option value="SEK" title="Swedish Krona">SEK</option><option value="CHF" title="Swiss Franc">CHF</option><option value="TWD" title="Taiwan New Dollar">TWD</option><option value="THB" title="Thai Baht">THB</option><option value="USD" title="U.S. Dollar">USD</option></optgroup></select> <input type="button" value="Generate Button Code" onclick="ws_plugin__s2member_paypalButtonGenerate(\'level1\');" class="button-primary" /></p>' . "\n";
		echo '<p>Custom Capabilities ( comma delimited ) <a href="#" onclick="alert(\'Optional. This is VERY advanced. For full details, see:\\ns2Member -> API Scripting -> Custom Capabilities.\'); return false;">[?]</a> <input type="text" id="ws-plugin--s2member-level1-ccaps" size="40" maxlength="125" /></p>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<strong>WordPress® Shortcode:</strong> ( recommended for both the WordPress® Visual &amp; HTML Editors )<br />' . "\n";
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/shortcodes/shortcode.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%domain%%/", strtolower ($_SERVER["HTTP_HOST"]), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", "1", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_label"], $ws_plugin__s2member_temp_s);
		echo '<input id="ws-plugin--s2member-level1-shortcode" type="text" value="' . format_to_edit ($ws_plugin__s2member_temp_s) . '" onclick="this.select ();" /><br /><br />' . "\n";
		echo '<strong>Resulting PayPal® Button Code:</strong> ( ultimately, your Shortcode will produce this snippet )<br />' . "\n";
		echo '<textarea id="ws-plugin--s2member-level1-button" rows="8" wrap="off" onclick="this.select ();">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/button.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%endpoint%%/", (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com"), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%paypal_business%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"], $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_label"], $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%cancel_return%%/", get_bloginfo ("url"), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%notify_url%%/", get_bloginfo ("url") . "/?s2member_paypal_notify=1", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%return%%/", get_bloginfo ("url") . "/?s2member_paypal_return=1", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%domain%%/", strtolower ($_SERVER["HTTP_HOST"]), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", "1", $ws_plugin__s2member_temp_s);
		echo format_to_edit ($ws_plugin__s2member_temp_s);
		echo '</textarea><br />' . "\n";
		echo '&uarr; Use this more advanced Code if you\'re building a theme or plugin that integrates with s2Member.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Buttons For Level #2 Access">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-button-code-2-section">' . "\n";
		echo '<h3>Button Code Generator For Level #2 Access</h3>' . "\n";
		echo '<p>Very simple. All you do is customize the form fields provided, for each Membership Level that you plan to offer. Then press (Generate Button Code). These special PayPal® Buttons are customized to work with s2Member seamlessly. Member accounts will be activated instantly, in an automated fashion. When you, or a Member, cancels their membership, or fails to make payments on time, s2Member will automatically terminate their membership privileges. s2Member makes extensive use of the PayPal® IPN service. s2Member receives updates from PayPal® behind-the-scene.</p>' . "\n";
		echo '<p><em>* Buttons are NOT saved here. This is only a Button Generator. Once you\'ve generated your Button, copy/paste it into your Membership Options Page. If you lose your Button Code, you\'ll need to come back &amp; re-generate a new one. If you\'re in Sandbox Test-Mode, and you\'re NOT using the Shortcode Format, please remember to come back and re-generate your Buttons before you go live.</em></p>' . "\n";
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-level2-shortcode">' . "\n";
		echo 'Button Code<br />For Level #2:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-level2-button-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<p id="ws-plugin--s2member-level2-trial-line">I\'ll offer the first <input type="text" id="ws-plugin--s2member-level2-trial-period" value="0" size="2" /> <select id="ws-plugin--s2member-level2-trial-term"><option value="D" selected="selected">Days</option><option value="W">Weeks</option><option value="M">Months</option><option value="Y">Years</option></select> free.</p>' . "\n";
		echo '<p><span id="ws-plugin--s2member-level2-trial-then">Then, </span>I want to charge: $<input type="text" id="ws-plugin--s2member-level2-amount" value="0.01" size="4" /> / <select id="ws-plugin--s2member-level2-term"><optgroup label="Recurring Subscriptions"><option value="1-D-1">Daily ( recurring charge, for ongoing access )</option><option value="1-W-1">Weekly ( recurring charge, for ongoing access )</option><option value="1-M-1" selected="selected">Monthly ( recurring charge, for ongoing access )</option><option value="3-M-1">Quarterly ( recurring charge, for ongoing access )</option><option value="1-Y-1">Yearly ( recurring charge, for ongoing access )</option></optgroup><optgroup label="Days / Non-Recurring"><option value="1-D-0">One Time ( for 1 day access, non-recurring )</option><option value="2-D-0">One Time ( for 2 day access, non-recurring )</option><option value="3-D-0">One Time ( for 3 day access, non-recurring )</option><option value="4-D-0">One Time ( for 4 day access, non-recurring )</option><option value="5-D-0">One Time ( for 5 day access, non-recurring )</option><option value="6-D-0">One Time ( for 6 day access, non-recurring )</option></optgroup><optgroup label="Weeks / Non-Recurring"><option value="1-W-0">One Time ( for 1 week access, non-recurring )</option><option value="2-W-0">One Time ( for 2 week access, non-recurring )</option><option value="3-W-0">One Time ( for 3 week access, non-recurring )</option></optgroup><optgroup label="Months / Non-Recurring"><option value="1-M-0">One Time ( for 1 month access, non-recurring )</option><option value="2-M-0">One Time ( for 2 month access, non-recurring )</option><option value="3-M-0">One Time ( for 3 month access, non-recurring )</option><option value="4-M-0">One Time ( for 4 month access, non-recurring )</option><option value="5-M-0">One Time ( for 5 month access, non-recurring )</option><option value="6-M-0">One Time ( for 6 month access, non-recurring )</option></optgroup><optgroup label="Years / Non-Recurring"><option value="1-Y-0">One Time ( for 1 year access, non-recurring )</option><option value="2-Y-0">One Time ( for 2 year access, non-recurring )</option><option value="3-Y-0">One Time ( for 3 year access, non-recurring )</option><option value="4-Y-0">One Time ( for 4 year access, non-recurring )</option><option value="5-Y-0">One Time ( for 5 year access, non-recurring )</option></optgroup><optgroup label="Lifetime / Buy Now / Non-Recurring / No Trial"><option value="1-L-0">Buy Now ( for lifetime access, no-trial, non-recurring )</option></optgroup></select></p>' . "\n";
		echo '<p>Checkout Page Style <a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. You can add your own header image and color selection to the checkout form. Once you\\\'ve created a Custom Page Style at PayPal®, you can enter that Page Style here.\'); return false;">[?]</a>: <input type="text" id="ws-plugin--s2member-level2-page-style" value="paypal" size="18" /> <select id="ws-plugin--s2member-level2-currency"><optgroup label="Currency"><option value="USD" title="U.S. Dollar">USD</option><option value="AUD" title="Australian Dollar">AUD</option><option value="BRL" title="Brazilian Real">BRL</option><option value="CAD" title="Canadian Dollar">CAD</option><option value="CZK" title="Czech Koruna">CZK</option><option value="DKK" title="Danish Krone">DKK</option><option value="EUR" title="Euro">EUR</option><option value="HKD" title="Hong Kong Dollar">HKD</option><option value="HUF" title="Hungarian Forint">HUF</option><option value="ILS" title="Israeli New Sheqel">ILS</option><option value="JPY" title="Japanese Yen">JPY</option><option value="MYR" title="Malaysian Ringgit">MYR</option><option value="MXN" title="Mexican Peso">MXN</option><option value="NOK" title="Norwegian Krone">NOK</option><option value="NZD" title="New Zealand Dollar">NZD</option><option value="PHP" title="Philippine Peso">PHP</option><option value="PLN" title="Polish Zloty">PLN</option><option value="GBP" title="Pound Sterling">GBP</option><option value="SGD" title="Singapore Dollar">SGD</option><option value="SEK" title="Swedish Krona">SEK</option><option value="CHF" title="Swiss Franc">CHF</option><option value="TWD" title="Taiwan New Dollar">TWD</option><option value="THB" title="Thai Baht">THB</option><option value="USD" title="U.S. Dollar">USD</option></optgroup></select> <input type="button" value="Generate Button Code" onclick="ws_plugin__s2member_paypalButtonGenerate(\'level2\');" class="button-primary" /></p>' . "\n";
		echo '<p>Custom Capabilities ( comma delimited ) <a href="#" onclick="alert(\'Optional. This is VERY advanced. For full details, see:\\ns2Member -> API Scripting -> Custom Capabilities.\'); return false;">[?]</a> <input type="text" id="ws-plugin--s2member-level2-ccaps" size="40" maxlength="125" /></p>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<strong>WordPress® Shortcode:</strong> ( recommended for both the WordPress® Visual &amp; HTML Editors )<br />' . "\n";
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/shortcodes/shortcode.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%domain%%/", strtolower ($_SERVER["HTTP_HOST"]), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", "2", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"], $ws_plugin__s2member_temp_s);
		echo '<input id="ws-plugin--s2member-level2-shortcode" type="text" value="' . format_to_edit ($ws_plugin__s2member_temp_s) . '" onclick="this.select ();" /><br /><br />' . "\n";
		echo '<strong>Resulting PayPal® Button Code:</strong> ( ultimately, your Shortcode will produce this snippet )<br />' . "\n";
		echo '<textarea id="ws-plugin--s2member-level2-button" rows="8" wrap="off" onclick="this.select ();">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/button.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%endpoint%%/", (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com"), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%paypal_business%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"], $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"], $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%cancel_return%%/", get_bloginfo ("url"), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%notify_url%%/", get_bloginfo ("url") . "/?s2member_paypal_notify=1", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%return%%/", get_bloginfo ("url") . "/?s2member_paypal_return=1", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%domain%%/", strtolower ($_SERVER["HTTP_HOST"]), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", "2", $ws_plugin__s2member_temp_s);
		echo format_to_edit ($ws_plugin__s2member_temp_s);
		echo '</textarea><br />' . "\n";
		echo '&uarr; Use this more advanced Code if you\'re building a theme or plugin that integrates with s2Member.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Buttons For Level #3 Access">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-button-code-3-section">' . "\n";
		echo '<h3>Button Code Generator For Level #3 Access</h3>' . "\n";
		echo '<p>Very simple. All you do is customize the form fields provided, for each Membership Level that you plan to offer. Then press (Generate Button Code). These special PayPal® Buttons are customized to work with s2Member seamlessly. Member accounts will be activated instantly, in an automated fashion. When you, or a Member, cancels their membership, or fails to make payments on time, s2Member will automatically terminate their membership privileges. s2Member makes extensive use of the PayPal® IPN service. s2Member receives updates from PayPal® behind-the-scene.</p>' . "\n";
		echo '<p><em>* Buttons are NOT saved here. This is only a Button Generator. Once you\'ve generated your Button, copy/paste it into your Membership Options Page. If you lose your Button Code, you\'ll need to come back &amp; re-generate a new one. If you\'re in Sandbox Test-Mode, and you\'re NOT using the Shortcode Format, please remember to come back and re-generate your Buttons before you go live.</em></p>' . "\n";
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-level3-shortcode">' . "\n";
		echo 'Button Code<br />For Level #3:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-level3-button-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<p id="ws-plugin--s2member-level3-trial-line">I\'ll offer the first <input type="text" id="ws-plugin--s2member-level3-trial-period" value="0" size="2" /> <select id="ws-plugin--s2member-level3-trial-term"><option value="D" selected="selected">Days</option><option value="W">Weeks</option><option value="M">Months</option><option value="Y">Years</option></select> free.</p>' . "\n";
		echo '<p><span id="ws-plugin--s2member-level3-trial-then">Then, </span>I want to charge: $<input type="text" id="ws-plugin--s2member-level3-amount" value="0.01" size="4" /> / <select id="ws-plugin--s2member-level3-term"><optgroup label="Recurring Subscriptions"><option value="1-D-1">Daily ( recurring charge, for ongoing access )</option><option value="1-W-1">Weekly ( recurring charge, for ongoing access )</option><option value="1-M-1" selected="selected">Monthly ( recurring charge, for ongoing access )</option><option value="3-M-1">Quarterly ( recurring charge, for ongoing access )</option><option value="1-Y-1">Yearly ( recurring charge, for ongoing access )</option></optgroup><optgroup label="Days / Non-Recurring"><option value="1-D-0">One Time ( for 1 day access, non-recurring )</option><option value="2-D-0">One Time ( for 2 day access, non-recurring )</option><option value="3-D-0">One Time ( for 3 day access, non-recurring )</option><option value="4-D-0">One Time ( for 4 day access, non-recurring )</option><option value="5-D-0">One Time ( for 5 day access, non-recurring )</option><option value="6-D-0">One Time ( for 6 day access, non-recurring )</option></optgroup><optgroup label="Weeks / Non-Recurring"><option value="1-W-0">One Time ( for 1 week access, non-recurring )</option><option value="2-W-0">One Time ( for 2 week access, non-recurring )</option><option value="3-W-0">One Time ( for 3 week access, non-recurring )</option></optgroup><optgroup label="Months / Non-Recurring"><option value="1-M-0">One Time ( for 1 month access, non-recurring )</option><option value="2-M-0">One Time ( for 2 month access, non-recurring )</option><option value="3-M-0">One Time ( for 3 month access, non-recurring )</option><option value="4-M-0">One Time ( for 4 month access, non-recurring )</option><option value="5-M-0">One Time ( for 5 month access, non-recurring )</option><option value="6-M-0">One Time ( for 6 month access, non-recurring )</option></optgroup><optgroup label="Years / Non-Recurring"><option value="1-Y-0">One Time ( for 1 year access, non-recurring )</option><option value="2-Y-0">One Time ( for 2 year access, non-recurring )</option><option value="3-Y-0">One Time ( for 3 year access, non-recurring )</option><option value="4-Y-0">One Time ( for 4 year access, non-recurring )</option><option value="5-Y-0">One Time ( for 5 year access, non-recurring )</option></optgroup><optgroup label="Lifetime / Buy Now / Non-Recurring / No Trial"><option value="1-L-0">Buy Now ( for lifetime access, no-trial, non-recurring )</option></optgroup></select></p>' . "\n";
		echo '<p>Checkout Page Style <a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. You can add your own header image and color selection to the checkout form. Once you\\\'ve created a Custom Page Style at PayPal®, you can enter that Page Style here.\'); return false;">[?]</a>: <input type="text" id="ws-plugin--s2member-level3-page-style" value="paypal" size="18" /> <select id="ws-plugin--s2member-level3-currency"><optgroup label="Currency"><option value="USD" title="U.S. Dollar">USD</option><option value="AUD" title="Australian Dollar">AUD</option><option value="BRL" title="Brazilian Real">BRL</option><option value="CAD" title="Canadian Dollar">CAD</option><option value="CZK" title="Czech Koruna">CZK</option><option value="DKK" title="Danish Krone">DKK</option><option value="EUR" title="Euro">EUR</option><option value="HKD" title="Hong Kong Dollar">HKD</option><option value="HUF" title="Hungarian Forint">HUF</option><option value="ILS" title="Israeli New Sheqel">ILS</option><option value="JPY" title="Japanese Yen">JPY</option><option value="MYR" title="Malaysian Ringgit">MYR</option><option value="MXN" title="Mexican Peso">MXN</option><option value="NOK" title="Norwegian Krone">NOK</option><option value="NZD" title="New Zealand Dollar">NZD</option><option value="PHP" title="Philippine Peso">PHP</option><option value="PLN" title="Polish Zloty">PLN</option><option value="GBP" title="Pound Sterling">GBP</option><option value="SGD" title="Singapore Dollar">SGD</option><option value="SEK" title="Swedish Krona">SEK</option><option value="CHF" title="Swiss Franc">CHF</option><option value="TWD" title="Taiwan New Dollar">TWD</option><option value="THB" title="Thai Baht">THB</option><option value="USD" title="U.S. Dollar">USD</option></optgroup></select> <input type="button" value="Generate Button Code" onclick="ws_plugin__s2member_paypalButtonGenerate(\'level3\');" class="button-primary" /></p>' . "\n";
		echo '<p>Custom Capabilities ( comma delimited ) <a href="#" onclick="alert(\'Optional. This is VERY advanced. For full details, see:\\ns2Member -> API Scripting -> Custom Capabilities.\'); return false;">[?]</a> <input type="text" id="ws-plugin--s2member-level3-ccaps" size="40" maxlength="125" /></p>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<strong>WordPress® Shortcode:</strong> ( recommended for both the WordPress® Visual &amp; HTML Editors )<br />' . "\n";
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/shortcodes/shortcode.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%domain%%/", strtolower ($_SERVER["HTTP_HOST"]), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", "3", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_label"], $ws_plugin__s2member_temp_s);
		echo '<input id="ws-plugin--s2member-level3-shortcode" type="text" value="' . format_to_edit ($ws_plugin__s2member_temp_s) . '" onclick="this.select ();" /><br /><br />' . "\n";
		echo '<strong>Resulting PayPal® Button Code:</strong> ( ultimately, your Shortcode will produce this snippet )<br />' . "\n";
		echo '<textarea id="ws-plugin--s2member-level3-button" rows="8" wrap="off" onclick="this.select ();">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/button.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%endpoint%%/", (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com"), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%paypal_business%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"], $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_label"], $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%cancel_return%%/", get_bloginfo ("url"), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%notify_url%%/", get_bloginfo ("url") . "/?s2member_paypal_notify=1", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%return%%/", get_bloginfo ("url") . "/?s2member_paypal_return=1", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%domain%%/", strtolower ($_SERVER["HTTP_HOST"]), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", "3", $ws_plugin__s2member_temp_s);
		echo format_to_edit ($ws_plugin__s2member_temp_s);
		echo '</textarea><br />' . "\n";
		echo '&uarr; Use this more advanced Code if you\'re building a theme or plugin that integrates with s2Member.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Buttons For Level #4 Access">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-button-code-4-section">' . "\n";
		echo '<h3>Button Code Generator For Level #4 Access</h3>' . "\n";
		echo '<p>Very simple. All you do is customize the form fields provided, for each Membership Level that you plan to offer. Then press (Generate Button Code). These special PayPal® Buttons are customized to work with s2Member seamlessly. Member accounts will be activated instantly, in an automated fashion. When you, or a Member, cancels their membership, or fails to make payments on time, s2Member will automatically terminate their membership privileges. s2Member makes extensive use of the PayPal® IPN service. s2Member receives updates from PayPal® behind-the-scene.</p>' . "\n";
		echo '<p><em>* Buttons are NOT saved here. This is only a Button Generator. Once you\'ve generated your Button, copy/paste it into your Membership Options Page. If you lose your Button Code, you\'ll need to come back &amp; re-generate a new one. If you\'re in Sandbox Test-Mode, and you\'re NOT using the Shortcode Format, please remember to come back and re-generate your Buttons before you go live.</em></p>' . "\n";
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-level4-shortcode">' . "\n";
		echo 'Button Code<br />For Level #4:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-level4-button-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<p id="ws-plugin--s2member-level4-trial-line">I\'ll offer the first <input type="text" id="ws-plugin--s2member-level4-trial-period" value="0" size="2" /> <select id="ws-plugin--s2member-level4-trial-term"><option value="D" selected="selected">Days</option><option value="W">Weeks</option><option value="M">Months</option><option value="Y">Years</option></select> free.</p>' . "\n";
		echo '<p><span id="ws-plugin--s2member-level4-trial-then">Then, </span>I want to charge: $<input type="text" id="ws-plugin--s2member-level4-amount" value="0.01" size="4" /> / <select id="ws-plugin--s2member-level4-term"><optgroup label="Recurring Subscriptions"><option value="1-D-1">Daily ( recurring charge, for ongoing access )</option><option value="1-W-1">Weekly ( recurring charge, for ongoing access )</option><option value="1-M-1" selected="selected">Monthly ( recurring charge, for ongoing access )</option><option value="3-M-1">Quarterly ( recurring charge, for ongoing access )</option><option value="1-Y-1">Yearly ( recurring charge, for ongoing access )</option></optgroup><optgroup label="Days / Non-Recurring"><option value="1-D-0">One Time ( for 1 day access, non-recurring )</option><option value="2-D-0">One Time ( for 2 day access, non-recurring )</option><option value="3-D-0">One Time ( for 3 day access, non-recurring )</option><option value="4-D-0">One Time ( for 4 day access, non-recurring )</option><option value="5-D-0">One Time ( for 5 day access, non-recurring )</option><option value="6-D-0">One Time ( for 6 day access, non-recurring )</option></optgroup><optgroup label="Weeks / Non-Recurring"><option value="1-W-0">One Time ( for 1 week access, non-recurring )</option><option value="2-W-0">One Time ( for 2 week access, non-recurring )</option><option value="3-W-0">One Time ( for 3 week access, non-recurring )</option></optgroup><optgroup label="Months / Non-Recurring"><option value="1-M-0">One Time ( for 1 month access, non-recurring )</option><option value="2-M-0">One Time ( for 2 month access, non-recurring )</option><option value="3-M-0">One Time ( for 3 month access, non-recurring )</option><option value="4-M-0">One Time ( for 4 month access, non-recurring )</option><option value="5-M-0">One Time ( for 5 month access, non-recurring )</option><option value="6-M-0">One Time ( for 6 month access, non-recurring )</option></optgroup><optgroup label="Years / Non-Recurring"><option value="1-Y-0">One Time ( for 1 year access, non-recurring )</option><option value="2-Y-0">One Time ( for 2 year access, non-recurring )</option><option value="3-Y-0">One Time ( for 3 year access, non-recurring )</option><option value="4-Y-0">One Time ( for 4 year access, non-recurring )</option><option value="5-Y-0">One Time ( for 5 year access, non-recurring )</option></optgroup><optgroup label="Lifetime / Buy Now / Non-Recurring / No Trial"><option value="1-L-0">Buy Now ( for lifetime access, no-trial, non-recurring )</option></optgroup></select></p>' . "\n";
		echo '<p>Checkout Page Style <a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. You can add your own header image and color selection to the checkout form. Once you\\\'ve created a Custom Page Style at PayPal®, you can enter that Page Style here.\'); return false;">[?]</a>: <input type="text" id="ws-plugin--s2member-level4-page-style" value="paypal" size="18" /> <select id="ws-plugin--s2member-level4-currency"><optgroup label="Currency"><option value="USD" title="U.S. Dollar">USD</option><option value="AUD" title="Australian Dollar">AUD</option><option value="BRL" title="Brazilian Real">BRL</option><option value="CAD" title="Canadian Dollar">CAD</option><option value="CZK" title="Czech Koruna">CZK</option><option value="DKK" title="Danish Krone">DKK</option><option value="EUR" title="Euro">EUR</option><option value="HKD" title="Hong Kong Dollar">HKD</option><option value="HUF" title="Hungarian Forint">HUF</option><option value="ILS" title="Israeli New Sheqel">ILS</option><option value="JPY" title="Japanese Yen">JPY</option><option value="MYR" title="Malaysian Ringgit">MYR</option><option value="MXN" title="Mexican Peso">MXN</option><option value="NOK" title="Norwegian Krone">NOK</option><option value="NZD" title="New Zealand Dollar">NZD</option><option value="PHP" title="Philippine Peso">PHP</option><option value="PLN" title="Polish Zloty">PLN</option><option value="GBP" title="Pound Sterling">GBP</option><option value="SGD" title="Singapore Dollar">SGD</option><option value="SEK" title="Swedish Krona">SEK</option><option value="CHF" title="Swiss Franc">CHF</option><option value="TWD" title="Taiwan New Dollar">TWD</option><option value="THB" title="Thai Baht">THB</option><option value="USD" title="U.S. Dollar">USD</option></optgroup></select> <input type="button" value="Generate Button Code" onclick="ws_plugin__s2member_paypalButtonGenerate(\'level4\');" class="button-primary" /></p>' . "\n";
		echo '<p>Custom Capabilities ( comma delimited ) <a href="#" onclick="alert(\'Optional. This is VERY advanced. For full details, see:\\ns2Member -> API Scripting -> Custom Capabilities.\'); return false;">[?]</a> <input type="text" id="ws-plugin--s2member-level4-ccaps" size="40" maxlength="125" /></p>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<strong>WordPress® Shortcode:</strong> ( recommended for both the WordPress® Visual &amp; HTML Editors )<br />' . "\n";
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/shortcodes/shortcode.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%domain%%/", strtolower ($_SERVER["HTTP_HOST"]), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", "4", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_label"], $ws_plugin__s2member_temp_s);
		echo '<input id="ws-plugin--s2member-level4-shortcode" type="text" value="' . format_to_edit ($ws_plugin__s2member_temp_s) . '" onclick="this.select ();" /><br /><br />' . "\n";
		echo '<strong>Resulting PayPal® Button Code:</strong> ( ultimately, your Shortcode will produce this snippet )<br />' . "\n";
		echo '<textarea id="ws-plugin--s2member-level4-button" rows="8" wrap="off" onclick="this.select ();">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/button.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%endpoint%%/", (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com"), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%paypal_business%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"], $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_label"], $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%cancel_return%%/", get_bloginfo ("url"), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%notify_url%%/", get_bloginfo ("url") . "/?s2member_paypal_notify=1", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%return%%/", get_bloginfo ("url") . "/?s2member_paypal_return=1", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%domain%%/", strtolower ($_SERVER["HTTP_HOST"]), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", "4", $ws_plugin__s2member_temp_s);
		echo format_to_edit ($ws_plugin__s2member_temp_s);
		echo '</textarea><br />' . "\n";
		echo '&uarr; Use this more advanced Code if you\'re building a theme or plugin that integrates with s2Member.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Subscr Modification Buttons">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-modification-section">' . "\n";
		echo '<h3>Button Code Generator For Subscription Modifications</h3>' . "\n";
		echo '<p>If you\'d like to give your Members ( and/or your Free Subscribers ) the ability to modify their billing plan, by switching to a more expensive option, or a less expensive option; generate a new PayPal® Modification Button here. Configure the updated Level, pricing, terms, etc. Then, make that new Modification Button available to Members who are logged into their existing account with you. For example, you might want to insert a "Level #2" Upgrade Button into your Login Welcome Page, which would up-sell existing Level #1 Members to a more expensive plan that you offer.</p>' . "\n";
		echo '<p><em><strong>*Modification Process*</strong> When you send a Member to PayPal® using a Subscription Modification Button, PayPal® will ask them to login. Once they\'re logged in, instead of being able to signup for a new membership, PayPal® will provide them with the ability to upgrade and/or downgrade their existing membership with you, by allowing them to switch to the Membership Plan that was specified in the Subscription Modification Button. PayPal® handles this nicely, and you\'ll be happy to know that s2Member has been pre-configured to deal with this scenario as well, so that everything remains automated. Their Membership Access Level will either be promoted, or demoted, based on the actions they took at PayPal® during the modification process. Once an existing Member completes their Subscription Modification at PayPal®, they\'ll be brought back to their Login Welcome Page, instead of the registration screen.</em></p>' . "\n";
		echo '<p><em><strong>*Also Works For Free Subscribers*</strong> Although a Free Subscriber does not have an existing PayPal® subscription, s2Member is capable of adapting to this scenario gracefully. Just make sure that your existing Free Subscribers ( the ones who wish to upgrade ) pay for their Membership through a Modification Button generated by s2Member. That will allow them to continue using their existing account with you. In other words, they can keep their existing Username ( and anything already associated with that Username ), rather than being forced to re-register after checkout.</em></p>' . "\n";
		echo '<p><em><strong>*Make It More User-Friendly*</strong> You can make the Subscription Modification Process, more user-friendly, by setting up a <a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. You can add your own header image and color selection to the checkout form. Once you\\\'ve created a Custom Page Style at PayPal®, you can tell s2Member to use that Page Style whenever you generate your Button Code.\'); return false;">Custom Page Style at PayPal®</a>, specifically for Subscription Modification Buttons. Use a custom header image, with a brief explanation to the Customer. Something like, "Log into PayPal®", "You can Modify your Subscription!".</em></p>' . "\n";
		echo '<p><em>* Buttons are NOT saved here. This is only a Button Generator. Once you\'ve generated your Button, copy/paste it into your Login Welcome Page, or wherever you feel it would be most appropriate. If you lose your Button Code, you\'ll need to come back &amp; re-generate a new one. If you\'re in Sandbox Test-Mode, and you\'re NOT using the Shortcode Format, please remember to come back and re-generate your Buttons before you go live.</em></p>' . "\n";
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-modification-shortcode">' . "\n";
		echo 'Button Code<br />For Modifications:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-modification-button-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<p>Modification: <select id="ws-plugin--s2member-modification-level"><optgroup label="Level #1"><option value="upgrade:1">&uarr; Upgrade To Level #1</option><option value="downgrade:1">&darr; Downgrade To Level #1</option></optgroup><optgroup label="Level #2"><option value="upgrade:2" selected="selected">&uarr; Upgrade To Level #2</option><option value="downgrade:2">&darr; Downgrade To Level #2</option></optgroup><optgroup label="Level #3"><option value="upgrade:3">&uarr; Upgrade To Level #3</option><option value="downgrade:3">&darr; Downgrade To Level #3</option></optgroup><optgroup label="Level #4"><option value="upgrade:4">&uarr; Upgrade To Level #4</option></optgroup></select></p>' . "\n";
		echo '<p id="ws-plugin--s2member-modification-trial-line">I\'ll offer the first <input type="text" id="ws-plugin--s2member-modification-trial-period" value="0" size="2" /> <select id="ws-plugin--s2member-modification-trial-term"><option value="D" selected="selected">Days</option><option value="W">Weeks</option><option value="M">Months</option><option value="Y">Years</option></select> free.</p>' . "\n";
		echo '<p><span id="ws-plugin--s2member-modification-trial-then">Then, </span>I want to charge: $<input type="text" id="ws-plugin--s2member-modification-amount" value="0.01" size="4" /> / <select id="ws-plugin--s2member-modification-term"><optgroup label="Recurring Subscriptions"><option value="1-D-1">Daily ( recurring charge, for ongoing access )</option><option value="1-W-1">Weekly ( recurring charge, for ongoing access )</option><option value="1-M-1" selected="selected">Monthly ( recurring charge, for ongoing access )</option><option value="3-M-1">Quarterly ( recurring charge, for ongoing access )</option><option value="1-Y-1">Yearly ( recurring charge, for ongoing access )</option></optgroup><optgroup label="Days / Non-Recurring"><option value="1-D-0">One Time ( for 1 day access, non-recurring )</option><option value="2-D-0">One Time ( for 2 day access, non-recurring )</option><option value="3-D-0">One Time ( for 3 day access, non-recurring )</option><option value="4-D-0">One Time ( for 4 day access, non-recurring )</option><option value="5-D-0">One Time ( for 5 day access, non-recurring )</option><option value="6-D-0">One Time ( for 6 day access, non-recurring )</option></optgroup><optgroup label="Weeks / Non-Recurring"><option value="1-W-0">One Time ( for 1 week access, non-recurring )</option><option value="2-W-0">One Time ( for 2 week access, non-recurring )</option><option value="3-W-0">One Time ( for 3 week access, non-recurring )</option></optgroup><optgroup label="Months / Non-Recurring"><option value="1-M-0">One Time ( for 1 month access, non-recurring )</option><option value="2-M-0">One Time ( for 2 month access, non-recurring )</option><option value="3-M-0">One Time ( for 3 month access, non-recurring )</option><option value="4-M-0">One Time ( for 4 month access, non-recurring )</option><option value="5-M-0">One Time ( for 5 month access, non-recurring )</option><option value="6-M-0">One Time ( for 6 month access, non-recurring )</option></optgroup><optgroup label="Years / Non-Recurring"><option value="1-Y-0">One Time ( for 1 year access, non-recurring )</option><option value="2-Y-0">One Time ( for 2 year access, non-recurring )</option><option value="3-Y-0">One Time ( for 3 year access, non-recurring )</option><option value="4-Y-0">One Time ( for 4 year access, non-recurring )</option><option value="5-Y-0">One Time ( for 5 year access, non-recurring )</option></optgroup><optgroup label="Lifetime / Buy Now / Non-Recurring / No Trial"><option value="1-L-0">Buy Now ( for lifetime access, no-trial, non-recurring )</option></optgroup></select></p>' . "\n";
		echo '<p>Checkout Page Style <a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. You can add your own header image and color selection to the checkout form. Once you\\\'ve created a Custom Page Style at PayPal®, you can enter that Page Style here.\'); return false;">[?]</a>: <input type="text" id="ws-plugin--s2member-modification-page-style" value="paypal" size="18" /> <select id="ws-plugin--s2member-modification-currency"><optgroup label="Currency"><option value="USD" title="U.S. Dollar">USD</option><option value="AUD" title="Australian Dollar">AUD</option><option value="BRL" title="Brazilian Real">BRL</option><option value="CAD" title="Canadian Dollar">CAD</option><option value="CZK" title="Czech Koruna">CZK</option><option value="DKK" title="Danish Krone">DKK</option><option value="EUR" title="Euro">EUR</option><option value="HKD" title="Hong Kong Dollar">HKD</option><option value="HUF" title="Hungarian Forint">HUF</option><option value="ILS" title="Israeli New Sheqel">ILS</option><option value="JPY" title="Japanese Yen">JPY</option><option value="MYR" title="Malaysian Ringgit">MYR</option><option value="MXN" title="Mexican Peso">MXN</option><option value="NOK" title="Norwegian Krone">NOK</option><option value="NZD" title="New Zealand Dollar">NZD</option><option value="PHP" title="Philippine Peso">PHP</option><option value="PLN" title="Polish Zloty">PLN</option><option value="GBP" title="Pound Sterling">GBP</option><option value="SGD" title="Singapore Dollar">SGD</option><option value="SEK" title="Swedish Krona">SEK</option><option value="CHF" title="Swiss Franc">CHF</option><option value="TWD" title="Taiwan New Dollar">TWD</option><option value="THB" title="Thai Baht">THB</option><option value="USD" title="U.S. Dollar">USD</option></optgroup></select> <input type="button" value="Generate Button Code" onclick="ws_plugin__s2member_paypalButtonGenerate(\'modification\');" class="button-primary" /></p>' . "\n";
		echo '<p>Custom Capabilities ( comma delimited ) <a href="#" onclick="alert(\'Optional. This is VERY advanced. For full details, see:\\ns2Member -> API Scripting -> Custom Capabilities.\'); return false;">[?]</a> <input type="text" id="ws-plugin--s2member-modification-ccaps" size="40" maxlength="125" /></p>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<strong>WordPress® Shortcode:</strong> ( recommended for both the WordPress® Visual &amp; HTML Editors )<br />' . "\n";
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/shortcodes/shortcode.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/\/]$/", 'mb="1" /]', $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%domain%%/", strtolower ($_SERVER["HTTP_HOST"]), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", "2", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"], $ws_plugin__s2member_temp_s);
		echo '<input id="ws-plugin--s2member-modification-shortcode" type="text" value="' . format_to_edit ($ws_plugin__s2member_temp_s) . '" onclick="this.select ();" /><br /><br />' . "\n";
		echo '<strong>Resulting PayPal® Button Code:</strong> ( ultimately, your Shortcode will produce this snippet )<br />' . "\n";
		echo '<textarea id="ws-plugin--s2member-modification-button" rows="8" wrap="off" onclick="this.select ();">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/button.html"));
		$ws_plugin__s2member_temp_s = preg_replace ('/name\="modify" value\="(.*?)"/', 'name="modify" value="1"', $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%endpoint%%/", (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com"), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%paypal_business%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"], $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"], $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%cancel_return%%/", get_bloginfo ("url"), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%notify_url%%/", get_bloginfo ("url") . "/?s2member_paypal_notify=1", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%return%%/", get_bloginfo ("url") . "/?s2member_paypal_return=1", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%domain%%/", strtolower ($_SERVER["HTTP_HOST"]), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", "2", $ws_plugin__s2member_temp_s);
		echo format_to_edit ($ws_plugin__s2member_temp_s);
		echo '</textarea><br />' . "\n";
		echo '&uarr; Use this more advanced Code if you\'re building a theme or plugin that integrates with s2Member.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Subscr Cancellation Buttons">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-cancellation-section">' . "\n";
		echo '<h3>One Button Does It All For Cancellations ( copy/paste )</h3>' . "\n";
		echo '<p>Since every paid Membership is associated with a PayPal® Subscription; and every PayPal® Subscription is associated with a PayPal® Account; your Members will always have a PayPal® Account of their own, which is tied to their Membership with you. So... a Member can simply log into their own PayPal® account and cancel their subscription(s) with you at anytime, all on their own. However, some Customers do not realize this. So, if you would like to make it clearer ( easier ) for Members to cancel their own subscription(s), you can provide this Cancellation Button for them on your Login Welcome Page, or somewhere in the support section of your website. Note... you don\'t have to use this Cancellation Button at all, if you don\'t want to. It\'s completely optional.</p>' . "\n";
		echo '<p><em><strong>*Cancellation Process*</strong> Very simple. A Member clicks the Cancellation Button. PayPal® asks them to log into their PayPal® account. Once they\'re logged in, PayPal® will display a list of all active subscriptions they have with you. They choose which ones they want to cancel, and s2Member is notified silently behind-the-scene, through the PayPal® IPN service.</em></p>' . "\n";
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-cancellation-shortcode">' . "\n";
		echo 'Button Code<br />For Cancellations:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-cancellation-button-prev">' . "\n";
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/c-button.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%endpoint%%/", (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com"), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%paypal_business%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"], $ws_plugin__s2member_temp_s);
		echo preg_replace ("/\<a/", '<a target="_blank"', $ws_plugin__s2member_temp_s);
		echo '</div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<p>No configuration necessary.</p>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<strong>WordPress® Shortcode:</strong> ( recommended for both the WordPress® Visual &amp; HTML Editors )<br />' . "\n";
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/shortcodes/c-shortcode.html"));
		echo '<input id="ws-plugin--s2member-cancellation-shortcode" type="text" value="' . format_to_edit ($ws_plugin__s2member_temp_s) . '" onclick="this.select ();" /><br /><br />' . "\n";
		echo '<strong>Resulting PayPal® Button Code:</strong> ( ultimately, your Shortcode will produce this snippet )<br />' . "\n";
		echo '<textarea id="ws-plugin--s2member-cancellation-button" rows="8" wrap="off" onclick="this.select ();">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/c-button.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%endpoint%%/", (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com"), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%paypal_business%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"], $ws_plugin__s2member_temp_s);
		echo format_to_edit ($ws_plugin__s2member_temp_s);
		echo '</textarea><br />' . "\n";
		echo '&uarr; Use this more advanced Code if you\'re building a theme or plugin that integrates with s2Member.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Single-Page &quot;Buy Now&quot; Access">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-sp-section">' . "\n";
		echo '<h3>Button Code Generator For Single-Page Buy Now Buttons</h3>' . "\n";
		echo '<p>s2Member now supports an additional layer of functionality ( very powerful ), which allows you to sell access to specific Pages that you\'ve created in WordPress®. Single-Page Access works independently from Member Level Access. That is, you can sell an unlimited number of Pages using "Buy Now" Buttons, and your Customers will NOT be required to have a Membership Account with your site in order to receive access. If they are already a Member, that\'s fine, but they won\'t need to be. In other words, Customers will NOT need to login, just to receive access to the Single-Page they purchased access to. s2Member will immediately redirect the Customer to the Single-Page after checkout is completed successfully. An email is also sent to the Customer with a link ( see: <code>s2Member -> PayPal® Options -> Single-Page Email</code> ). Authentication is handled automatically through self-expiring links, good for 72 hours by default.</p>' . "\n";
		echo '<p>Single-Page Access, is sort of like selling a product. Only, instead of shipping anything to the Customer, you just give them access to a specific Page on your site; one that you created in WordPress®. A Single-Page that is protected by s2Member, might contain a download link for your eBook, access to file &amp; music downloads, access to additional support services, and the list goes on and on. The possibilities with this are endless; as long as your digital product can be delivered through access to a WordPress® Page that you\'ve created. To protect Single-Pages, please see: <code>s2Member -> General Options -> Single-Page Access Restrictions</code>. Once you\'ve configured your Single-Page Restrictions, those Pages will be available in the drop-down menu below.</p>' . "\n";
		echo '<p>Very simple. All you do is customize the form fields provided, for each Page that you plan to sell. Then press (Generate Button Code). These special PayPal® Buttons are customized to work with s2Member seamlessly.</p>' . "\n";
		echo '<p><em>* Buttons are NOT saved here. This is only a Button Generator. Once you\'ve generated your Button, copy/paste it into your WordPress® Editor, wherever you feel it would be most appropriate. If you lose your Button Code, you\'ll need to come back &amp; re-generate a new one. If you\'re in Sandbox Test-Mode, and you\'re NOT using the Shortcode Format, please remember to come back and re-generate your Buttons before you go live.</em></p>' . "\n";
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-sp-shortcode">' . "\n";
		echo 'Button Code<br />Single-Page Access:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-sp-button-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<p><select id="ws-plugin--s2member-sp-page">' . "\n";
		echo '<option value="">&mdash; Select A Protected Single-Page &mdash;</option>' . "\n";
		/**/
		$ws_plugin__s2member_temp_s_pages = ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["single_pages"]) ?/**/
		array_merge ((array)get_pages ("include=" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["single_pages"])) : array ();
		/**/
		foreach (($ws_plugin__s2member_temp_a = $ws_plugin__s2member_temp_s_pages) as $ws_plugin__s2member_temp_o)
			if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"])
				if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
					if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"])
						if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/,/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_pages"])))
							if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/,/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_pages"])))
								if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/,/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_pages"])))
									if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/,/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_pages"])))
										echo '<option value="' . esc_attr ($ws_plugin__s2member_temp_o->ID) . '">' . esc_html ($ws_plugin__s2member_temp_o->post_title) . '</option>' . "\n";
		/**/
		echo '</select></p>' . "\n";
		echo '<p>Description: <input type="text" id="ws-plugin--s2member-sp-desc" value="" size="68" /></p>' . "\n";
		echo '<p>I want to charge: $<input type="text" id="ws-plugin--s2member-sp-amount" value="0.01" size="4" /> / <select id="ws-plugin--s2member-sp-hours"><optgroup label="Expires In Hours"><option value="2">Buy Now ( Single-Page Link, valid for 2 hours )</option><option value="4">Buy Now ( Single-Page Link, valid for 4 hours )</option><option value="6">Buy Now ( Single-Page Link, valid for 6 hours )</option><option value="8">Buy Now ( Single-Page Link, valid for 8 hours )</option><option value="10">Buy Now ( Single-Page Link, valid for 10 hours )</option><option value="12">Buy Now ( Single-Page Link, valid for 12 hours )</option></optgroup><optgroup label="Expires In Days"><option value="24">Buy Now ( Single-Page Link, valid for 1 day )</option><option value="48">Buy Now ( Single-Page Link, valid for 2 days )</option><option value="72" selected="selected">Buy Now ( Single-Page Link, valid for 3 days )</option><option value="96">Buy Now ( Single-Page Link, valid for 4 days )</option><option value="120">Buy Now ( Single-Page Link, valid for 5 days )</option><option value="144">Buy Now ( Single-Page Link, valid for 6 days )</option></optgroup><optgroup label="Expires In Weeks"><option value="168">Buy Now ( Single-Page Link, valid for 1 week )</option><option value="336">Buy Now ( Single-Page Link, valid for 2 weeks )</option><option value="504">Buy Now ( Single-Page Link, valid for 3 weeks )</option></optgroup><optgroup label="Expires In Months"><option value="720">Buy Now ( Single-Page Link, valid for 1 month )</option><option value="1440">Buy Now ( Single-Page Link, valid for 2 months )</option><option value="2190">Buy Now ( Single-Page Link, valid for 3 months )</option><option value="4380">Buy Now ( Single-Page Link, valid for 6 months )</option></optgroup><optgroup label="Expires In Years"><option value="8760">Buy Now ( Single-Page Link, valid for 1 year )</option><option value="17520">Buy Now ( Single-Page Link, valid for 2 years )</option><option value="26280">Buy Now ( Single-Page Link, valid for 3 years )</option><option value="35040">Buy Now ( Single-Page Link, valid for 4 years )</option><option value="43800">Buy Now ( Single-Page Link, valid for 5 years )</option></optgroup></select></p>' . "\n";
		echo '<p>Checkout Page Style <a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. You can add your own header image and color selection to the checkout form. Once you\\\'ve created a Custom Page Style at PayPal®, you can enter that Page Style here.\'); return false;">[?]</a>: <input type="text" id="ws-plugin--s2member-sp-page-style" value="paypal" size="18" /> <select id="ws-plugin--s2member-sp-currency"><optgroup label="Currency"><option value="USD" title="U.S. Dollar">USD</option><option value="AUD" title="Australian Dollar">AUD</option><option value="BRL" title="Brazilian Real">BRL</option><option value="CAD" title="Canadian Dollar">CAD</option><option value="CZK" title="Czech Koruna">CZK</option><option value="DKK" title="Danish Krone">DKK</option><option value="EUR" title="Euro">EUR</option><option value="HKD" title="Hong Kong Dollar">HKD</option><option value="HUF" title="Hungarian Forint">HUF</option><option value="ILS" title="Israeli New Sheqel">ILS</option><option value="JPY" title="Japanese Yen">JPY</option><option value="MYR" title="Malaysian Ringgit">MYR</option><option value="MXN" title="Mexican Peso">MXN</option><option value="NOK" title="Norwegian Krone">NOK</option><option value="NZD" title="New Zealand Dollar">NZD</option><option value="PHP" title="Philippine Peso">PHP</option><option value="PLN" title="Polish Zloty">PLN</option><option value="GBP" title="Pound Sterling">GBP</option><option value="SGD" title="Singapore Dollar">SGD</option><option value="SEK" title="Swedish Krona">SEK</option><option value="CHF" title="Swiss Franc">CHF</option><option value="TWD" title="Taiwan New Dollar">TWD</option><option value="THB" title="Thai Baht">THB</option><option value="USD" title="U.S. Dollar">USD</option></optgroup></select> <input type="button" value="Generate Button Code" onclick="ws_plugin__s2member_paypalSpButtonGenerate();" class="button-primary" /></p>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<strong>WordPress® Shortcode:</strong> ( recommended for both the WordPress® Visual &amp; HTML Editors )<br />' . "\n";
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/shortcodes/sp-shortcode.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%domain%%/", strtolower ($_SERVER["HTTP_HOST"]), $ws_plugin__s2member_temp_s);
		echo '<input id="ws-plugin--s2member-sp-shortcode" type="text" value="' . format_to_edit ($ws_plugin__s2member_temp_s) . '" onclick="this.select ();" /><br /><br />' . "\n";
		echo '<strong>Resulting PayPal® Button Code:</strong> ( ultimately, your Shortcode will produce this snippet )<br />' . "\n";
		echo '<textarea id="ws-plugin--s2member-sp-button" rows="8" wrap="off" onclick="this.select ();">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/sp-button.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%endpoint%%/", (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com"), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%paypal_business%%/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"], $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%cancel_return%%/", get_bloginfo ("url"), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%notify_url%%/", get_bloginfo ("url") . "/?s2member_paypal_notify=1", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%return%%/", get_bloginfo ("url") . "/?s2member_paypal_return=1", $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%domain%%/", strtolower ($_SERVER["HTTP_HOST"]), $ws_plugin__s2member_temp_s);
		echo format_to_edit ($ws_plugin__s2member_temp_s);
		echo '</textarea><br />' . "\n";
		echo '&uarr; Use this more advanced Code if you\'re building a theme or plugin that integrates with s2Member.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<h3>Single-Page Link Generator ( for Customer Service )</h3>' . "\n";
		echo '<p>s2Member automatically generates Single-Page Links for your Customers after checkout, and also sends them a link in a Confirmation Email. However, if you ever need to deal with a Customer Service issue that requires a new Single-Page Link to be created, you can use this tool for that.</p>' . "\n";
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<p><select id="ws-plugin--s2member-sp-link-page">' . "\n";
		echo '<option value="">&mdash; Select A Protected Single-Page &mdash;</option>' . "\n";
		/**/
		foreach (($ws_plugin__s2member_temp_a = $ws_plugin__s2member_temp_s_pages) as $ws_plugin__s2member_temp_o)
			if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"])
				if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
					if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"])
						if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/,/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_pages"])))
							if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/,/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_pages"])))
								if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/,/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_pages"])))
									if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/,/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_pages"])))
										echo '<option value="' . esc_attr ($ws_plugin__s2member_temp_o->ID) . '">' . esc_html ($ws_plugin__s2member_temp_o->post_title) . '</option>' . "\n";
		/**/
		echo '</select> <select id="ws-plugin--s2member-sp-link-hours"><optgroup label="Hours"><option value="2">valid for 2 hours</option><option value="4">valid for 4 hours</option><option value="6">valid for 6 hours</option><option value="8">valid for 8 hours</option><option value="10">valid for 10 hours</option><option value="12">valid for 12 hours</option></optgroup><optgroup label="Days"><option value="24">valid for 1 day</option><option value="48">valid for 2 days</option><option value="72" selected="selected">valid for 3 days</option><option value="96">valid for 4 days</option><option value="120">valid for 5 days</option><option value="144">valid for 6 days</option></optgroup><optgroup label="Weeks"><option value="168">valid for 1 week</option><option value="336">valid for 2 weeks</option><option value="504">valid for 3 weeks</option></optgroup><optgroup label="Months"><option value="720">valid for 1 month</option><option value="1440">valid for 2 months</option><option value="2190">valid for 3 months</option><option value="4380">valid for 6 months</option></optgroup><optgroup label="Years"><option value="8760">valid for 1 year</option><option value="17520">valid for 2 years</option><option value="26280">valid for 3 years</option><option value="35040">valid for 4 years</option><option value="43800">valid for 5 years</option></optgroup></select> <input type="button" value="Generate Link" onclick="ws_plugin__s2member_paypalSpLinkGenerate();" class="button-primary" /> <img id="ws-plugin--s2member-sp-link-loading" src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/ajax-loader.gif" alt="" style="display:none;" /></p>' . "\n";
		/**/
		echo '<p id="ws-plugin--s2member-sp-link" style="font-family:Consolas, monospace; display:none;"></p>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		echo '</form>' . "\n";
	}
else /* They need to first configure the options. */
	echo '<p>Please configure the s2Member PayPal® Options first. Once your PayPal® Options have been properly configured, return to this page &amp; generate your PayPal® Button(s).</p>' . "\n";
/**/
echo '</td>' . "\n";
/**/
echo '<td class="ws-menu-page-table-r">' . "\n";
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["installation"]) ? '<div class="ws-menu-page-installation"><a href="' . ws_plugin__s2member_parse_readme_value ("Professional Installation URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-installation.png" alt="." title="Contact PriMoThemes!" /></a></div>' . "\n" : '';
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["tools"]) ? '<div class="ws-menu-page-tools"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-tools.png" alt="." /></div>' . "\n" : '';
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["support"]) ? '<div class="ws-menu-page-support"><a href="' . ws_plugin__s2member_parse_readme_value ("Forum URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-support.png" alt="." /></a></div>' . "\n" : '';
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