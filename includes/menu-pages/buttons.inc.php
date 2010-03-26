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
Button generating page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member PayPal® Subscription Buttons</h2>' . "\n";
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
		echo '<div class="ws-menu-page-group" title="PayPal® Button For Level #1 Subscriptions">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-button-code-1-section">' . "\n";
		echo '<h3>Button Code Generator For Level #1 Subscriptions</h3>' . "\n";
		echo '<p>Very simple. All you do is customize the form fields provided, for each Membership Level that you plan to offer. Then press (Generate Button Code). These special subscription buttons are customized to work with s2Member seamlessly. User accounts will be activated instantly, in an automated fashion. When you, or a User, cancels their membership, or fails to make payments on time, s2Member will automatically terminate their membership privileges using automated routines. s2Member makes extensive use of the PayPal® IPN service, which receives updates directly from PayPal® behind the scenes.</p>' . "\n";
		echo '<p><em>* Buttons are NOT saved here. This is only a Button Generator. Once you\'ve generated your Button, copy/paste it into your Membership Options Page. If you lose your Button Code, you\'ll need to come back &amp; regenerate a new one. If you\'re currently in Sandbox testing mode, please remember to come back and regenerate new Buttons once you go live.</em></p>' . "\n";
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-level1-button">' . "\n";
		echo 'Button Code<br />For Level #1:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-level1-button-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<p>I\'ll offer the first <input type="text" id="ws-plugin--s2member-level1-trial-period" value="0" size="2" /> <select id="ws-plugin--s2member-level1-trial-term"><option value="D" selected="selected">Days</option><option value="W">Weeks</option><option value="M">Months</option></select> free.</p>' . "\n";
		echo '<p>Then, I want to charge: $<input type="text" id="ws-plugin--s2member-level1-amount" value="0.01" size="4" /> / <select id="ws-plugin--s2member-level1-term"><option value="W">Weekly ( recurring charge, for ongoing access )</option><option value="M" selected="selected">Monthly ( recurring charge, for ongoing access )</option><option value="Y">Yearly ( recurring charge, for ongoing access )</option><option value="W-NR">One Time ( for 1 week access, non-recurring )</option><option value="M-NR" selected="selected">One Time ( for 1 month access, non-recurring )</option><option value="Y-NR">One Time ( for 1 year access, non-recurring )</option></select></p>' . "\n";
		echo '<p>Checkout Page Style [<a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. Once you\\\'ve created a Custom Page Style at PayPal®, you can enter that Page Style here.\'); return false;">?</a>]: <input type="text" id="ws-plugin--s2member-level1-page-style" value="paypal" size="10" /> <input type="button" value="Generate Button Code" onclick="ws_plugin__s2member_paypalButtonGenerate(1);" /></p>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<textarea id="ws-plugin--s2member-level1-button" rows="8" wrap="off">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (__FILE__) . "/button.html"));
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
		echo 'Paste this code into your Membership Options Page.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Button For Level #2 Subscriptions">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-button-code-2-section">' . "\n";
		echo '<h3>Button Code Generator For Level #2 Subscriptions</h3>' . "\n";
		echo '<p>Very simple. All you do is customize the form fields provided, for each Membership Level that you plan to offer. Then press (Generate Button Code). These special subscription buttons are customized to work with s2Member seamlessly. User accounts will be activated instantly, in an automated fashion. When you, or a User, cancels their membership, or fails to make payments on time, s2Member will automatically terminate their membership privileges using automated routines. s2Member makes extensive use of the PayPal® IPN service, which receives updates directly from PayPal® behind the scenes.</p>' . "\n";
		echo '<p><em>* Buttons are NOT saved here. This is only a Button Generator. Once you\'ve generated your Button, copy/paste it into your Membership Options Page. If you lose your Button Code, you\'ll need to come back &amp; regenerate a new one. If you\'re currently in Sandbox testing mode, please remember to come back and regenerate new Buttons once you go live.</em></p>' . "\n";
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-level2-button">' . "\n";
		echo 'Button Code<br />For Level #2:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-level2-button-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<p>I\'ll offer the first <input type="text" id="ws-plugin--s2member-level2-trial-period" value="0" size="2" /> <select id="ws-plugin--s2member-level2-trial-term"><option value="D" selected="selected">Days</option><option value="W">Weeks</option><option value="M">Months</option></select> free.</p>' . "\n";
		echo '<p>Then, I want to charge: $<input type="text" id="ws-plugin--s2member-level2-amount" value="0.01" size="4" /> / <select id="ws-plugin--s2member-level2-term"><option value="W">Weekly ( recurring charge, for ongoing access )</option><option value="M" selected="selected">Monthly ( recurring charge, for ongoing access )</option><option value="Y">Yearly ( recurring charge, for ongoing access )</option><option value="W-NR">One Time ( for 1 week access, non-recurring )</option><option value="M-NR" selected="selected">One Time ( for 1 month access, non-recurring )</option><option value="Y-NR">One Time ( for 1 year access, non-recurring )</option></select></p>' . "\n";
		echo '<p>Checkout Page Style [<a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. Once you\\\'ve created a Custom Page Style at PayPal®, you can enter that Page Style here.\'); return false;">?</a>]: <input type="text" id="ws-plugin--s2member-level2-page-style" value="paypal" size="10" /> <input type="button" value="Generate Button Code" onclick="ws_plugin__s2member_paypalButtonGenerate(2);" /></p>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<textarea id="ws-plugin--s2member-level2-button" rows="8" wrap="off">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (__FILE__) . "/button.html"));
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
		echo 'Paste this code into your Membership Options Page.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Button For Level #3 Subscriptions">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-button-code-3-section">' . "\n";
		echo '<h3>Button Code Generator For Level #3 Subscriptions</h3>' . "\n";
		echo '<p>Very simple. All you do is customize the form fields provided, for each Membership Level that you plan to offer. Then press (Generate Button Code). These special subscription buttons are customized to work with s2Member seamlessly. User accounts will be activated instantly, in an automated fashion. When you, or a User, cancels their membership, or fails to make payments on time, s2Member will automatically terminate their membership privileges using automated routines. s2Member makes extensive use of the PayPal® IPN service, which receives updates directly from PayPal® behind the scenes.</p>' . "\n";
		echo '<p><em>* Buttons are NOT saved here. This is only a Button Generator. Once you\'ve generated your Button, copy/paste it into your Membership Options Page. If you lose your Button Code, you\'ll need to come back &amp; regenerate a new one. If you\'re currently in Sandbox testing mode, please remember to come back and regenerate new Buttons once you go live.</em></p>' . "\n";
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-level3-button">' . "\n";
		echo 'Button Code<br />For Level #3:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-level3-button-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<p>I\'ll offer the first <input type="text" id="ws-plugin--s2member-level3-trial-period" value="0" size="2" /> <select id="ws-plugin--s2member-level3-trial-term"><option value="D" selected="selected">Days</option><option value="W">Weeks</option><option value="M">Months</option></select> free.</p>' . "\n";
		echo '<p>Then, I want to charge: $<input type="text" id="ws-plugin--s2member-level3-amount" value="0.01" size="4" /> / <select id="ws-plugin--s2member-level3-term"><option value="W">Weekly ( recurring charge, for ongoing access )</option><option value="M" selected="selected">Monthly ( recurring charge, for ongoing access )</option><option value="Y">Yearly ( recurring charge, for ongoing access )</option><option value="W-NR">One Time ( for 1 week access, non-recurring )</option><option value="M-NR" selected="selected">One Time ( for 1 month access, non-recurring )</option><option value="Y-NR">One Time ( for 1 year access, non-recurring )</option></select></p>' . "\n";
		echo '<p>Checkout Page Style [<a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. Once you\\\'ve created a Custom Page Style at PayPal®, you can enter that Page Style here.\'); return false;">?</a>]: <input type="text" id="ws-plugin--s2member-level3-page-style" value="paypal" size="10" /> <input type="button" value="Generate Button Code" onclick="ws_plugin__s2member_paypalButtonGenerate(3);" /></p>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<textarea id="ws-plugin--s2member-level3-button" rows="8" wrap="off">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (__FILE__) . "/button.html"));
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
		echo 'Paste this code into your Membership Options Page.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Button For Level #4 Subscriptions">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-button-code-4-section">' . "\n";
		echo '<h3>Button Code Generator For Level #4 Subscriptions</h3>' . "\n";
		echo '<p>Very simple. All you do is customize the form fields provided, for each Membership Level that you plan to offer. Then press (Generate Button Code). These special subscription buttons are customized to work with s2Member seamlessly. User accounts will be activated instantly, in an automated fashion. When you, or a User, cancels their membership, or fails to make payments on time, s2Member will automatically terminate their membership privileges using automated routines. s2Member makes extensive use of the PayPal® IPN service, which receives updates directly from PayPal® behind the scenes.</p>' . "\n";
		echo '<p><em>* Buttons are NOT saved here. This is only a Button Generator. Once you\'ve generated your Button, copy/paste it into your Membership Options Page. If you lose your Button Code, you\'ll need to come back &amp; regenerate a new one. If you\'re currently in Sandbox testing mode, please remember to come back and regenerate new Buttons once you go live.</em></p>' . "\n";
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-level4-button">' . "\n";
		echo 'Button Code<br />For Level #4:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-level4-button-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<p>I\'ll offer the first <input type="text" id="ws-plugin--s2member-level4-trial-period" value="0" size="2" /> <select id="ws-plugin--s2member-level4-trial-term"><option value="D" selected="selected">Days</option><option value="W">Weeks</option><option value="M">Months</option></select> free.</p>' . "\n";
		echo '<p>Then, I want to charge: $<input type="text" id="ws-plugin--s2member-level4-amount" value="0.01" size="4" /> / <select id="ws-plugin--s2member-level4-term"><option value="W">Weekly ( recurring charge, for ongoing access )</option><option value="M" selected="selected">Monthly ( recurring charge, for ongoing access )</option><option value="Y">Yearly ( recurring charge, for ongoing access )</option><option value="W-NR">One Time ( for 1 week access, non-recurring )</option><option value="M-NR" selected="selected">One Time ( for 1 month access, non-recurring )</option><option value="Y-NR">One Time ( for 1 year access, non-recurring )</option></select></p>' . "\n";
		echo '<p>Checkout Page Style [<a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. Once you\\\'ve created a Custom Page Style at PayPal®, you can enter that Page Style here.\'); return false;">?</a>]: <input type="text" id="ws-plugin--s2member-level4-page-style" value="paypal" size="10" /> <input type="button" value="Generate Button Code" onclick="ws_plugin__s2member_paypalButtonGenerate(4);" /></p>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<textarea id="ws-plugin--s2member-level4-button" rows="8" wrap="off">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (__FILE__) . "/button.html"));
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
		echo 'Paste this code into your Membership Options Page.' . "\n";
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
	echo '<p>Please configure the s2Member PayPal® Options first. Once your PayPal® Options have been properly configured, return to this page &amp; generate your PayPal® subscription button(s).</p>' . "\n";
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