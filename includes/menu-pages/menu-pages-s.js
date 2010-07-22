/*
Copyright: © 2009 WebSharks, Inc. ( coded in the USA )
<mailto:support@websharks-inc.com> <http://www.websharks-inc.com/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/
/*
These routines are all specific to this software.
*/
jQuery (document).ready (function($)
	{
		var esc_attr = esc_html = function(str) /* Convert special characters. */
			{
				return String (str).replace (/"/g, '&quot;').replace (/\</g, '&lt;').replace (/\>/g, '&gt;');
			};
		/**/
		if (location.href.match (/page\=ws-plugin--s2member-options/))
			{
				ws_plugin__s2member_generateSecurityKey = function() /* Generates a unique Security Key. */
					{
						var mt_rand = function(min, max) /* The PHP equivalent to mt_rand(). */
							{
								min = (arguments.length < 1) ? 0 : min;
								max = (arguments.length < 2) ? 2147483647 : max;
								/**/
								return Math.floor (Math.random () * (max - min + 1)) + min;
							};
						/**/
						var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
						for (var i = 0, key = ''; i < 56; i++) key += chars.substr (mt_rand (0, chars.length - 1), 1);
						/**/
						$ ('input#ws-plugin--s2member-sec-encryption-key').val (key);
						/**/
						return false;
					};
				/**/
				ws_plugin__s2member_enableSecurityKey = function() /* Allow Security Key editing?? */
					{
						if (confirm ('Edit Key? Are you sure?\nThis could break your installation!\n\n*Note* If you\'ve been testing s2Member, feel free to change this Key before you go live. Just don\'t go live, and then change it. You\'ll have some very unhappy Customers. Data corruption WILL occur!\n\nFor your safety, s2Member keeps a history of the last 10 Keys that you\'ve used. If you get yourself into a real situation, s2Member will let you revert back to a previous Key.'))
							$ ('input#ws-plugin--s2member-sec-encryption-key').attr ('disabled', false);
						/**/
						return false;
					};
				/**/
				ws_plugin__s2member_securityKeyHistory = function() /* Displays history of Keys. */
					{
						$ ('div#ws-plugin--s2member-sec-encryption-key-history').toggle ();
						/**/
						return false;
					};
			}
		/**/
		else if (location.href.match (/page\=ws-plugin--s2member-paypal-ops/))
			{
				$ ('select#ws-plugin--s2member-auto-eot-system-enabled').change (function()
					{
						var $this = $ (this), val = $this.val ();
						var $viaCron = $ ('p#ws-plugin--s2member-auto-eot-system-enabled-via-cron');
						/**/
						if (val == 2) /* Display Cron instructions. */
							$viaCron.show ()
						else /* Hide instructions. */
							$viaCron.hide ();
					});
			}
		/**/
		else if (location.href.match (/page\=ws-plugin--s2member-els-ops/))
			{
				$ ('select#ws-plugin--s2member-custom-reg-opt-in').change (function()
					{
						var $this = $ (this), val = $this.val ();
						var $rows = $ ('tr.ws-plugin--s2member-custom-reg-opt-in-label-row');
						var $prevImg = $ ('img.ws-plugin--s2member-custom-reg-opt-in-label-prev-img');
						/**/
						if (val <= 0) /* Checkbox disabled. */
							$rows.css ('display', 'none'), $prevImg.attr ('src', $prevImg.attr ('src').replace (/\/checked\.png$/, '/unchecked.png'));
						/**/
						else if (val == 1) /* Enabled, checked by default. */
							$rows.css ('display', ''), $prevImg.attr ('src', $prevImg.attr ('src').replace (/\/unchecked\.png$/, '/checked.png'));
						/**/
						else if (val == 2) /* Enabled, unchecked by default. */
							$rows.css ('display', ''), $prevImg.attr ('src', $prevImg.attr ('src').replace (/\/checked\.png$/, '/unchecked.png'));
					});
			}
		/**/
		else if (location.href.match (/page\=ws-plugin--s2member-paypal-buttons/))
			{
				$ ('select#ws-plugin--s2member-level1-term, select#ws-plugin--s2member-level2-term, select#ws-plugin--s2member-level3-term, select#ws-plugin--s2member-level4-term, select#ws-plugin--s2member-modification-term').change (function()
					{
						var button = this.id.replace (/^ws-plugin--s2member-(.+?)-term$/g, '$1');
						var trialDisabled = ($ (this).val ().split ('-')[2].replace (/[^0-1BN]/g, '') === 'BN') ? 1 : 0;
						$ ('p#ws-plugin--s2member-' + button + '-trial-line').css ('display', (trialDisabled ? 'none' : ''));
						$ ('span#ws-plugin--s2member-' + button + '-trial-then').css ('display', (trialDisabled ? 'none' : ''));
						$ ('span#ws-plugin--s2member-' + button + '-20p-rule').css ('display', (trialDisabled ? 'none' : ''));
						(trialDisabled) ? $ ('input#ws-plugin--s2member-' + form + '-trial-period').val (0) : null;
					});
				/**/
				$ ('input#ws-plugin--s2member-level1-ccaps, input#ws-plugin--s2member-level2-ccaps, input#ws-plugin--s2member-level3-ccaps, input#ws-plugin--s2member-level4-ccaps, input#ws-plugin--s2member-modification-ccaps').keyup (function()
					{
						this.value = $.trim ($.trim (this.value).replace (/[ \-]/g, '_').replace (/[^A-Z_0-9,]/gi, '').toLowerCase ());
					});
				/**/
				ws_plugin__s2member_paypalButtonGenerate = function(button) /* Handles PayPal® Button Generation. */
					{
						var shortCodeTemplate = '[s2Member-PayPal-Button %%attrs%% image="default" /]', shortCodeTemplateAttrs = '', labels = {};
						/**/
						labels['level0'] = '<?php echo ws_plugin__s2member_esc_sq ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_label"]); ?>';
						labels['level1'] = '<?php echo ws_plugin__s2member_esc_sq ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_label"]); ?>';
						labels['level2'] = '<?php echo ws_plugin__s2member_esc_sq ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"]); ?>';
						labels['level3'] = '<?php echo ws_plugin__s2member_esc_sq ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_label"]); ?>';
						labels['level4'] = '<?php echo ws_plugin__s2member_esc_sq ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_label"]); ?>';
						/**/
						var shortCode = $ ('input#ws-plugin--s2member-' + button + '-shortcode');
						var code = $ ('textarea#ws-plugin--s2member-' + button + '-button');
						var modLevel = $ ('select#ws-plugin--s2member-modification-level');
						/**/
						var level = (button === 'modification') ? modLevel.val ().split (':', 2)[1] : button.replace (/^level/, '');
						var label = labels['level' + level].replace (/"/g, ""); /* Labels may NOT contain any double-quotes. */
						var trialPeriod = $ ('input#ws-plugin--s2member-' + button + '-trial-period').val ().replace (/[^0-9]/g, '');
						var trialTerm = $ ('select#ws-plugin--s2member-' + button + '-trial-term').val ().replace (/[^A-Z]/g, '');
						var regAmount = $ ('input#ws-plugin--s2member-' + button + '-amount').val ().replace (/[^0-9\.]/g, '');
						var regPeriod = $ ('select#ws-plugin--s2member-' + button + '-term').val ().split ('-')[0].replace (/[^0-9]/g, '');
						var regTerm = $ ('select#ws-plugin--s2member-' + button + '-term').val ().split ('-')[1].replace (/[^A-Z]/g, '');
						var regRecur = $ ('select#ws-plugin--s2member-' + button + '-term').val ().split ('-')[2].replace (/[^0-1BN]/g, '');
						var pageStyle = $.trim ($ ('input#ws-plugin--s2member-' + button + '-page-style').val ().replace (/"/g, ''));
						var currencyCode = $ ('select#ws-plugin--s2member-' + button + '-currency').val ().replace (/[^A-Z]/g, '');
						var cCaps = $.trim ($.trim ($ ('input#ws-plugin--s2member-' + button + '-ccaps').val ()).replace (/[ \-]/g, '_').replace (/[^A-Z_0-9,]/gi, '').toLowerCase ());
						trialPeriod = (regRecur === 'BN') ? '0' : trialPeriod; /* Lifetime ( 1-L-BN ) and Buy Now ( BN ) access is NOT compatible w/ free trials. */
						var levelCcapsPer = (regRecur === 'BN' && regTerm !== 'L') ? level + ':' + cCaps + ':' + regPeriod + ' ' + regTerm : level + ':' + cCaps;
						levelCcapsPer = levelCcapsPer.replace (/\:+$/g, ''); /* Clean any trailing separators from this string. */
						/**/
						if (trialTerm === 'D' && trialPeriod > 7) /* Some validation on the Trial Period. Max days: 7. */
							{
								alert ('Oops, a slight problem:\n\nMaximum Free Days is: 7.\nIf you want to offer more than 7 days free, please choose Weeks or Months from the drop-down.');
								return false;
							}
						else if (trialTerm === 'W' && trialPeriod > 52) /* Some validation on the Trial Period. 52 max. */
							{
								alert ('Oops, a slight problem:\n\nMaximum Free Weeks is: 52.\nIf you want to offer more than 52 weeks free, please choose Months from the drop-down.');
								return false;
							}
						else if (trialTerm === 'M' && trialPeriod > 12) /* Some validation on the Trial Period. 12 max. */
							{
								alert ('Oops, a slight problem:\n\nMaximum Free Months is: 12.\nIf you want to offer more than 12 months free, please choose Years from the drop-down.');
								return false;
							}
						else if (trialTerm === 'Y' && trialPeriod > 1) /* 1 year max for PayPal®. */
							{
								alert ('Oops, a slight problem:\n\nMax Trial Period Years is: 1. *This is a PayPal® limitation.');
								return false;
							}
						else if (!regAmount || isNaN (regAmount) || regAmount < 0.01)
							{
								alert ('Oops, a slight problem:\n\nAmount must be >= 0.01');
								return false;
							}
						else if (regAmount > 10000.00) /* $10,000.00 maximum. */
							{
								alert ('Oops, a slight problem:\n\nMaximum amount is: 10000.00');
								return false;
							}
						/**/
						code.val (code.val ().replace (/ \<\!--(\<input type\="hidden" name\="(amount|src|sra|a1|p1|t1|a3|p3|t3)" value\="(.*?)" \/\>)--\>/g, " $1"));
						(parseInt (trialPeriod) <= 0) ? code.val (code.val ().replace (/ (\<input type\="hidden" name\="(a1|p1|t1)" value\="(.*?)" \/\>)/g, " <!--$1-->")) : null;
						(regRecur === 'BN') ? code.val (code.val ().replace (/ (\<input type\="hidden" name\="cmd" value\=")(.*?)(" \/\>)/g, " $1_xclick$3")) : null;
						(regRecur === 'BN') ? code.val (code.val ().replace (/ (\<input type\="hidden" name\="(src|sra|a1|p1|t1|a3|p3|t3)" value\="(.*?)" \/\>)/g, " <!--$1-->")) : null;
						(regRecur !== 'BN') ? code.val (code.val ().replace (/ (\<input type\="hidden" name\="cmd" value\=")(.*?)(" \/\>)/g, " $1_xclick-subscriptions$3")) : null;
						(regRecur !== 'BN') ? code.val (code.val ().replace (/ (\<input type\="hidden" name\="amount" value\="(.*?)" \/\>)/g, " <!--$1-->")) : null;
						/**/
						shortCodeTemplateAttrs += 'level="' + esc_attr (level) + '" ccaps="' + esc_attr (cCaps) + '" desc="' + esc_attr (label) + '" ps="' + esc_attr (pageStyle) + '" cc="' + esc_attr (currencyCode) + '" custom="<?php echo esc_attr ($_SERVER["HTTP_HOST"]); ?>"';
						shortCodeTemplateAttrs += ' tp="' + esc_attr (trialPeriod) + '" tt="' + esc_attr (trialTerm) + '" ra="' + esc_attr (regAmount) + '" rp="' + esc_attr (regPeriod) + '" rt="' + esc_attr (regTerm) + '" rr="' + esc_attr (regRecur) + '"';
						shortCodeTemplateAttrs += (button === 'modification') ? ' modify="1"' : ''; /* For Modification Buttons. */
						shortCode.val (shortCodeTemplate.replace (/%%attrs%%/, shortCodeTemplateAttrs));
						/**/
						code.val (code.val ().replace (/ name\="item_name" value\="(.*?)"/, ' name="item_name" value="' + esc_attr (label) + '"'));
						code.val (code.val ().replace (/ name\="item_number" value\="(.*?)"/, ' name="item_number" value="' + esc_attr (levelCcapsPer) + '"'));
						code.val (code.val ().replace (/ name\="page_style" value\="(.*?)"/, ' name="page_style" value="' + esc_attr (pageStyle) + '"'));
						code.val (code.val ().replace (/ name\="currency_code" value\="(.*?)"/, ' name="currency_code" value="' + esc_attr (currencyCode) + '"'));
						code.val (code.val ().replace (/ name\="custom" value\="(.*?)"/, ' name="custom" value="<?php echo esc_attr ($_SERVER["HTTP_HOST"]); ?>"'));
						code.val (code.val ().replace (/ name\="modify" value\="(.*?)"/, ' name="modify" value="' + ( (button === 'modification') ? '1' : '0') + '"'));
						code.val (code.val ().replace (/ name\="amount" value\="(.*?)"/, ' name="amount" value="' + esc_attr (regAmount) + '"'));
						code.val (code.val ().replace (/ name\="src" value\="(.*?)"/, ' name="src" value="' + esc_attr (regRecur) + '"'));
						code.val (code.val ().replace (/ name\="p1" value\="(.*?)"/, ' name="p1" value="' + esc_attr (trialPeriod) + '"'));
						code.val (code.val ().replace (/ name\="t1" value\="(.*?)"/, ' name="t1" value="' + esc_attr (trialTerm) + '"'));
						code.val (code.val ().replace (/ name\="a3" value\="(.*?)"/, ' name="a3" value="' + esc_attr (regAmount) + '"'));
						code.val (code.val ().replace (/ name\="p3" value\="(.*?)"/, ' name="p3" value="' + esc_attr (regPeriod) + '"'));
						code.val (code.val ().replace (/ name\="t3" value\="(.*?)"/, ' name="t3" value="' + esc_attr (regTerm) + '"'));
						/**/
						$ ('div#ws-plugin--s2member-' + button + '-button-prev').html (code.val ().replace (/\<form/, '<form target="_blank"').replace (/\<\?php echo S2MEMBER_CURRENT_USER_VALUE_FOR_PP_(ON0|OS0); \?\>/g, ''));
						/**/
						(button === 'modification') ? alert ('Your Modification Button has been generated.\nPlease copy/paste the Shortcode Format into your Login Welcome Page, or wherever you feel it would be most appropriate.') : alert ('Your Button has been generated.\nPlease copy/paste the Shortcode Format into your Membership Options Page.');
						/**/
						shortCode.each (function() /* Focus and select the recommended Shortcode. */
							{
								this.focus (), this.select ();
							});
						/**/
						return false;
					};
				/**/
				ws_plugin__s2member_paypalSpButtonGenerate = function() /* Handles PayPal® Button Generation for Specific Post/Page Access. */
					{
						var shortCodeTemplate = '[s2Member-PayPal-Button %%attrs%% image="default" /]', shortCodeTemplateAttrs = '';
						/**/
						var shortCode = $ ('input#ws-plugin--s2member-sp-shortcode');
						var code = $ ('textarea#ws-plugin--s2member-sp-button');
						/**/
						var leading = $ ('select#ws-plugin--s2member-sp-leading-id').val ().replace (/[^0-9]/g, '');
						var additionals = $ ('select#ws-plugin--s2member-sp-additional-ids').val () || [];
						var hours = $ ('select#ws-plugin--s2member-sp-hours').val ().replace (/[^0-9]/g, '');
						var regAmount = $ ('input#ws-plugin--s2member-sp-amount').val ().replace (/[^0-9\.]/g, '');
						var desc = $.trim ($ ('input#ws-plugin--s2member-sp-desc').val ().replace (/"/g, ''));
						var pageStyle = $.trim ($ ('input#ws-plugin--s2member-sp-page-style').val ().replace (/"/g, ''));
						var currencyCode = $ ('select#ws-plugin--s2member-sp-currency').val ().replace (/[^A-Z]/g, '');
						/**/
						if (!leading) /* Must have a Leading Post/Page ID to work with. Otherwise, Link generation will fail. */
							{
								alert ('Oops, a slight problem:\n\nPlease select a Leading Post/Page.\n\n*Tip* If there are no Posts/Pages in the menu, it\'s because you\'ve not configured s2Member for Specific Post/Page Access yet. See: s2Member -> General Options -> Specific Post/Page Access Restrictions.');
								return false;
							}
						else if (!regAmount || isNaN (regAmount) || regAmount < 0.01)
							{
								alert ('Oops, a slight problem:\n\nAmount must be >= 0.01');
								return false;
							}
						else if (regAmount > 10000.00) /* $10,000.00 maximum. */
							{
								alert ('Oops, a slight problem:\n\nMaximum amount is: 10000.00');
								return false;
							}
						else if (!desc) /* Each Button should have a Description. */
							{
								alert ('Oops, a slight problem:\n\nPlease type a Description for this Button.');
								return false;
							}
						/**/
						for (var i = 0, ids = leading; i < additionals.length; i++)
							if (additionals[i] && additionals[i] !== leading)
								ids += ',' + additionals[i];
						/**/
						var spIdsHours = 'sp:' + ids + ':' + hours; /* Combined sp:ids:expiration hours. */
						/**/
						shortCodeTemplateAttrs += 'ids="' + esc_attr (ids) + '" exp="' + esc_attr (hours) + '" desc="' + esc_attr (desc) + '" ps="' + esc_attr (pageStyle) + '" cc="' + esc_attr (currencyCode) + '"';
						shortCodeTemplateAttrs += ' custom="<?php echo esc_attr ($_SERVER["HTTP_HOST"]); ?>" ra="' + esc_attr (regAmount) + '" sp="1"';
						shortCode.val (shortCodeTemplate.replace (/%%attrs%%/, shortCodeTemplateAttrs));
						/**/
						code.val (code.val ().replace (/ name\="item_name" value\="(.*?)"/, ' name="item_name" value="' + esc_attr (desc) + '"'));
						code.val (code.val ().replace (/ name\="item_number" value\="(.*?)"/, ' name="item_number" value="' + esc_attr (spIdsHours) + '"'));
						code.val (code.val ().replace (/ name\="page_style" value\="(.*?)"/, ' name="page_style" value="' + esc_attr (pageStyle) + '"'));
						code.val (code.val ().replace (/ name\="currency_code" value\="(.*?)"/, ' name="currency_code" value="' + esc_attr (currencyCode) + '"'));
						code.val (code.val ().replace (/ name\="custom" value\="(.*?)"/, ' name="custom" value="<?php echo esc_attr ($_SERVER["HTTP_HOST"]); ?>"'));
						code.val (code.val ().replace (/ name\="amount" value\="(.*?)"/, ' name="amount" value="' + esc_attr (regAmount) + '"'));
						/**/
						$ ('div#ws-plugin--s2member-sp-button-prev').html (code.val ().replace (/\<form/, '<form target="_blank"'));
						/**/
						alert ('Your Button has been generated.\nPlease copy/paste the Shortcode Format into your Membership Options Page.');
						/**/
						shortCode.each (function() /* Focus and select the recommended Shortcode. */
							{
								this.focus (), this.select ();
							});
						/**/
						return false;
					};
				/**/
				ws_plugin__s2member_paypalSpLinkGenerate = function() /* Handles PayPal® Link Generation. */
					{
						var leading = $ ('select#ws-plugin--s2member-sp-link-leading-id').val ().replace (/[^0-9]/g, '');
						var additionals = $ ('select#ws-plugin--s2member-sp-link-additional-ids').val () || [];
						var hours = $ ('select#ws-plugin--s2member-sp-link-hours').val ().replace (/[^0-9]/g, '');
						var $link = $ ('p#ws-plugin--s2member-sp-link'), $loading = $ ('img#ws-plugin--s2member-sp-link-loading');
						/**/
						if (!leading) /* Must have a Leading Post/Page ID to work with. Otherwise, Link generation will fail. */
							{
								alert ('Oops, a slight problem:\n\nPlease select a Leading Post/Page.\n\n*Tip* If there are no Posts/Pages in the menu, it\'s because you\'ve not configured s2Member for Specific Post/Page Access yet. See: s2Member -> General Options -> Specific Post/Page Access Restrictions.');
								return false;
							}
						/**/
						for (var i = 0, ids = leading; i < additionals.length; i++)
							if (additionals[i] && additionals[i] !== leading)
								ids += ',' + additionals[i];
						/**/
						$link.hide (), $loading.show (), $.post (ajaxurl, {action: 's2member_sp_access_link', s2member_sp_access_link: '<?php echo ws_plugin__s2member_esc_sq (wp_create_nonce ("ws-plugin--s2member-sp-access-link")); ?>', s2member_sp_access_link_ids: ids, s2member_sp_access_link_hours: hours}, function(response)
							{
								$link.show ().html ('<a href="' + esc_attr (response) + '" target="_blank" rel="external">' + esc_html (response) + '</a>'), $loading.hide ();
							});
						/**/
						return false;
					};
			}
	});