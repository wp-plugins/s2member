/*
Copyright: © 2009 WebSharks, Inc. ( coded in the USA )
<mailto:support@websharks-inc.com> <http://www.websharks-inc.com/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/
jQuery(document).ready (function($)
	{
		/*
		These routines address common layout styles for menu pages.
		*/
		$('div.ws-menu-page-group').each (function(index)
			{
				var ins = '<ins>+</ins>', group = $(this), title = group.attr ('title');
				/**/
				var header = $('<div class="ws-menu-page-group-header">' + ins + title + '</div>');
				/**/
				header.css ({'z-index': 100 - index}); /* Stack them sequentially, top to bottom. */
				/**/
				header.insertBefore (group), group.hide (), header.click (function()
					{
						var ins = $('ins', this), group = $(this).next ();
						/**/
						if (group.css ('display') === 'none')
							{
								$(this).addClass ('open'), ins.html ('-'), group.show ();
							}
						else
							{
								$(this).removeClass ('open'), ins.html ('+'), group.hide ();
							}
						/**/
						return false;
					});
				if (index === 0) /* These are the buttons for showing/hiding all groups. */
					{
						$('<div class="ws-menu-page-groups-show">+</div>').insertBefore (header).click (function()
							{
								$('div.ws-menu-page-group-header').each (function()
									{
										var ins = $('ins', this), group = $(this).next ();
										/**/
										$(this).addClass ('open'), ins.html ('-'), group.show ();
										/**/
										return;
									});
								/**/
								return false;
							});
						$('<div class="ws-menu-page-groups-hide">-</div>').insertBefore (header).click (function()
							{
								$('div.ws-menu-page-group-header').each (function()
									{
										var ins = $('ins', this), group = $(this).next ();
										/**/
										$(this).removeClass ('open'), ins.html ('+'), group.hide ();
										/**/
										return;
									});
								/**/
								return false;
							});
					}
				/**/
				if (group.attr ('default-state') === 'open')
					header.trigger ('click');
				/**/
				return;
			});
		/**/
		$('div.ws-menu-page-hr:first').css ({'margin-top': '10px', 'margin-bottom': '20px'});
		/**/
		$('div.ws-menu-page-section:first > h3').css ({'margin-top': '0'});
		/**/
		$('div.ws-menu-page-group > div.ws-menu-page-section:first-child > h3').css ({'margin-top': '0'});
		$('div.ws-menu-page-group-header:first').css ({'margin-top': '0', 'margin-right': '140px'});
		$('div.ws-menu-page-group:first').css ({'margin-right': '145px'});
		/**/
		$('div.ws-menu-page-readme > div.readme > div.section:last-child').css ({'border-bottom-width': '0'});
		/**/
		$('input.ws-menu-page-media-btn').filter (function() /* Only those that have a rel attribute. */
			{
				return ($(this).attr ('rel')) ? true : false; /* Must have rel targeting an input id. */
			})/**/
		.click (function() /* Attach click events to media buttons with send_to_editor(). */
			{
				$this = $(this), window.send_to_editor = function(html)
					{
						var $inp, $txt; /* Looking for input|textarea. */
						/**/
						if (($inp = $('input#' + $this.attr ('rel'))).length > 0)
							{
								var oBg = $inp.css ('background-color'), src = $.trim ($(html).attr ('src'));
								src = (!src) ? $.trim ($('img', html).attr ('src')) : src;
								/**/
								$inp.val (src), $inp.css ({'background-color': '#FFFFCC'}), setTimeout(function()
									{
										$inp.css ({'background-color': oBg});
									}, 2000);
								/**/
								tb_remove ();
								/**/
								return;
							}
						else if (($txt = $('textarea#' + $this.attr ('rel'))).length > 0)
							{
								var oBg = $txt.css ('background-color'), src = $.trim ($(html).attr ('src'));
								src = (!src) ? $.trim ($('img', html).attr ('src')) : src;
								/**/
								$txt.val ($.trim ($txt.val ()) + '\n' + src), $txt.css ({'background-color': '#FFFFCC'}), setTimeout(function()
									{
										$txt.css ({'background-color': oBg});
									}, 2000);
								/**/
								tb_remove ();
								/**/
								return;
							}
					};
				/**/
				tb_show('', './media-upload.php?type=image&TB_iframe=true');
				/**/
				return false;
			});
		/*
		These routines are all specific to this software.
		*/
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
						for (var i = 0, key = ''; i < 56; i++) key += chars.substr (mt_rand(0, chars.length - 1), 1);
						/**/
						$('input#ws-plugin--s2member-sec-encryption-key').val (key);
						/**/
						return false;
					};
				/**/
				ws_plugin__s2member_enableSecurityKey = function() /* Allow Security Key editing?? */
					{
						if (confirm('Edit Key? Are you sure?\nThis could break your installation!\n\n*Note* If you\'ve been testing s2Member, feel free to change this Key before you go live. Just don\'t go live, and then change it. You\'ll have some very unhappy Customers. Data corruption WILL occur!\n\nFor your safety, s2Member keeps a history of the last 10 Keys that you\'ve used. If you get yourself into a real situation, s2Member will let you revert back to a previous Key.'))
							$('input#ws-plugin--s2member-sec-encryption-key').attr ('disabled', false);
						/**/
						return false;
					};
				/**/
				ws_plugin__s2member_securityKeyHistory = function() /* Displays history of Keys. */
					{
						$('div#ws-plugin--s2member-sec-encryption-key-history').toggle ();
						/**/
						return false;
					};
			}
		/**/
		else if (location.href.match (/page\=ws-plugin--s2member-buttons/))
			{
				$('select#ws-plugin--s2member-level1-term, select#ws-plugin--s2member-level2-term, select#ws-plugin--s2member-level3-term, select#ws-plugin--s2member-level4-term, select#ws-plugin--s2member-modification-term').change (function()
					{
						var button = this.id.replace (/^ws-plugin--s2member-(.+?)-term$/g, '$1');
						var trialDisabled = ($(this).val ().split ('-')[1].replace (/[^A-Z]/g, '') === 'L') ? 'disabled' : '';
						$('p#ws-plugin--s2member-' + button + '-trial-line').css ('display', (trialDisabled ? 'none' : ''));
						$('span#ws-plugin--s2member-' + button + '-trial-then').css ('display', (trialDisabled ? 'none' : ''));
					});
				/**/
				$('input#ws-plugin--s2member-level1-ccaps, input#ws-plugin--s2member-level2-ccaps, input#ws-plugin--s2member-level3-ccaps, input#ws-plugin--s2member-level4-ccaps, input#ws-plugin--s2member-modification-ccaps').keyup (function()
					{
						this.value = $.trim ($.trim (this.value).replace (/[ \-]/g, '_').replace (/[^A-Z_0-9,]/gi, '').toLowerCase ());
					});
				/**/
				ws_plugin__s2member_paypalButtonGenerate = function(button) /* Handles PayPal® Button Generation. */
					{
						var shortCodeTemplate = '[s2Member-PayPal-Button %%attrs%% /]', shortCodeTemplateAttrs = '', labels = {};
						/**/
						labels['level1'] = '<?php echo ws_plugin__s2member_esc_sq ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_label"]); ?>';
						labels['level2'] = '<?php echo ws_plugin__s2member_esc_sq ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"]); ?>';
						labels['level3'] = '<?php echo ws_plugin__s2member_esc_sq ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_label"]); ?>';
						labels['level4'] = '<?php echo ws_plugin__s2member_esc_sq ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_label"]); ?>';
						/**/
						var shortCode = $('input#ws-plugin--s2member-' + button + '-shortcode');
						var code = $('textarea#ws-plugin--s2member-' + button + '-button');
						var modLevel = $('select#ws-plugin--s2member-modification-level');
						/**/
						var level = (button === 'modification') ? modLevel.val ().split (':', 2)[1] : button.replace (/^level/, '');
						var label = labels['level' + level].replace (/"/g, "'"); /* Label cannot contain double-quotes. */
						var trialPeriod = $('input#ws-plugin--s2member-' + button + '-trial-period').val ().replace (/[^0-9]/g, '');
						var trialTerm = $('select#ws-plugin--s2member-' + button + '-trial-term').val ().replace (/[^A-Z]/g, '');
						var regAmount = $('input#ws-plugin--s2member-' + button + '-amount').val ().replace (/[^0-9\.]/g, '');
						var regPeriod = $('select#ws-plugin--s2member-' + button + '-term').val ().split ('-')[0].replace (/[^0-9]/g, '');
						var regTerm = $('select#ws-plugin--s2member-' + button + '-term').val ().split ('-')[1].replace (/[^A-Z]/g, '');
						var regRecur = $('select#ws-plugin--s2member-' + button + '-term').val ().split ('-')[2].replace (/[^0-1]/g, '');
						var pageStyle = $.trim ($('input#ws-plugin--s2member-' + button + '-page-style').val ().replace (/"/g, ''));
						var currencyCode = $('select#ws-plugin--s2member-' + button + '-currency').val ().replace (/[^A-Z]/g, '');
						var cCaps = $.trim ($.trim ($('input#ws-plugin--s2member-' + button + '-ccaps').val ()).replace (/[ \-]/g, '_').replace (/[^A-Z_0-9,]/gi, '').toLowerCase ());
						var levelCcaps = (cCaps) ? level + ':' + cCaps : level; /* This is the combination string with custom capabilities attached to the end. */
						trialPeriod = (regTerm === 'L') ? '0' : trialPeriod; /* Lifetime access is NOT compatible w/trials. With lifetime access, the trialPeriod is always 0. */
						/**/
						if (trialTerm === 'D' && trialPeriod > 90) /* Some validation on the trial period. Max days: 90. */
							alert('* WARNING: Maximum Free Days is: 90.\nIf you want to offer more than 90 days free, please choose Weeks or Months from the drop-down.'), trialPeriod = 90;
						else if (trialTerm === 'W' && trialPeriod > 52) /* Some validation on the trial period. 52 max. */
							alert('* WARNING: Maximum Free Weeks is: 52.\nIf you want to offer more than 52 weeks free, please choose Months from the drop-down.'), trialPeriod = 52;
						else if (trialTerm === 'M' && trialPeriod > 24) /* Some validation on the trial period. 24 max. */
							alert('* WARNING: Maximum Free Months is: 24.\nIf you want to offer more than 24 months free, please choose Years from the drop-down.'), trialPeriod = 24;
						else if (trialTerm === 'Y' && trialPeriod > 5) /* 5 years max. */
							alert('* WARNING: Maximum Free Years is: 5.'), trialPeriod = 5;
						/**/
						code.val (code.val ().replace (/ \<\!--(\<input type\="hidden" name\="(amount|src|sra|a1|p1|t1|a3|p3|t3)" value\="(.*?)" \/\>)--\>/g, " $1"));
						(parseInt(trialPeriod) <= 0) ? code.val (code.val ().replace (/ (\<input type\="hidden" name\="(a1|p1|t1)" value\="(.*?)" \/\>)/g, " <!--$1-->")) : null;
						(regTerm === 'L') ? code.val (code.val ().replace (/ (\<input type\="hidden" name\="cmd" value\=")(.*?)(" \/\>)/g, " $1_xclick$3")) : null;
						(regTerm === 'L') ? code.val (code.val ().replace (/ (\<input type\="hidden" name\="(src|sra|a1|p1|t1|a3|p3|t3)" value\="(.*?)" \/\>)/g, " <!--$1-->")) : null;
						(regTerm !== 'L') ? code.val (code.val ().replace (/ (\<input type\="hidden" name\="cmd" value\=")(.*?)(" \/\>)/g, " $1_xclick-subscriptions$3")) : null;
						(regTerm !== 'L') ? code.val (code.val ().replace (/ (\<input type\="hidden" name\="amount" value\="(.*?)" \/\>)/g, " <!--$1-->")) : null;
						/**/
						shortCodeTemplateAttrs += 'level="' + level + '" ccaps="' + cCaps + '" desc="' + label + '" ps="' + pageStyle + '" cc="' + currencyCode + '" custom="<?php echo $_SERVER["HTTP_HOST"]; ?>"';
						shortCodeTemplateAttrs += ' tp="' + trialPeriod + '" tt="' + trialTerm + '" ra="' + regAmount + '" rp="' + regPeriod + '" rt="' + regTerm + '" rr="' + regRecur + '"';
						shortCodeTemplateAttrs += (button === 'modification') ? ' mb="1"' : ''; /* For modification buttons. */
						shortCode.val (shortCodeTemplate.replace (/%%attrs%%/, shortCodeTemplateAttrs));
						/**/
						code.val (code.val ().replace (/ name\="item_name" value\="(.*?)"/, ' name="item_name" value="' + label + '"'));
						code.val (code.val ().replace (/ name\="item_number" value\="(.*?)"/, ' name="item_number" value="' + levelCcaps + '"'));
						code.val (code.val ().replace (/ name\="page_style" value\="(.*?)"/, ' name="page_style" value="' + pageStyle + '"'));
						code.val (code.val ().replace (/ name\="currency_code" value\="(.*?)"/, ' name="currency_code" value="' + currencyCode + '"'));
						code.val (code.val ().replace (/ name\="custom" value\="(.*?)"/, ' name="custom" value="<?php echo $_SERVER["HTTP_HOST"]; ?>"'));
						code.val (code.val ().replace (/ name\="modify" value\="(.*?)"/, ' name="modify" value="' + ((button === 'modification') ? '1' : '0') + '"'));
						code.val (code.val ().replace (/ name\="amount" value\="(.*?)"/, ' name="amount" value="' + regAmount + '"'));
						code.val (code.val ().replace (/ name\="src" value\="(.*?)"/, ' name="src" value="' + regRecur + '"'));
						code.val (code.val ().replace (/ name\="p1" value\="(.*?)"/, ' name="p1" value="' + trialPeriod + '"'));
						code.val (code.val ().replace (/ name\="t1" value\="(.*?)"/, ' name="t1" value="' + trialTerm + '"'));
						code.val (code.val ().replace (/ name\="a3" value\="(.*?)"/, ' name="a3" value="' + regAmount + '"'));
						code.val (code.val ().replace (/ name\="p3" value\="(.*?)"/, ' name="p3" value="' + regPeriod + '"'));
						code.val (code.val ().replace (/ name\="t3" value\="(.*?)"/, ' name="t3" value="' + regTerm + '"'));
						/**/
						$('div#ws-plugin--s2member-' + button + '-button-prev').html (code.val ().replace (/\<form/, '<form target="_blank"').replace (/\<\?php echo S2MEMBER_CURRENT_USER_VALUE_FOR_PP_(ON0|OS0); \?\>/, ''));
						/**/
						if (button === 'modification')
							alert('Your Modification Button has been generated.\nPlease copy/paste the Shortcode Format into your Login Welcome Page, or wherever you feel it would be most appropriate.');
						else
							alert('Your Codes for Membership Level #' + level + ' have been generated. Please copy/paste the Shortcode Format into your Membership Options Page.');
						/**/
						shortCode.each (function() /* Focus and select the recommended Shortcode. */
							{
								this.focus (), this.select ();
							});
						/**/
						return false;
					};
				/**/
				ws_plugin__s2member_paypalSpButtonGenerate = function() /* Handles PayPal® Button Generation for Single-Page access. */
					{
						var shortCodeTemplate = '[s2Member-PayPal-Button %%attrs%% /]', shortCodeTemplateAttrs = '';
						/**/
						var shortCode = $('input#ws-plugin--s2member-sp-shortcode');
						var code = $('textarea#ws-plugin--s2member-sp-button');
						/**/
						var page = $('select#ws-plugin--s2member-sp-page').val ().replace (/[^0-9]/g, '');
						var hours = $('select#ws-plugin--s2member-sp-hours').val ().replace (/[^0-9]/g, '');
						var desc = $.trim ($('input#ws-plugin--s2member-sp-desc').val ().replace (/"/g, ''));
						/**/
						if (!page) /* Must have a Page ID to work with. Otherwise, the purchase would fail. */
							{
								alert('Please select a Page from the drop-down.\n\nIf there are no Pages in the drop-down menu, it\'s because you\'ve not configured s2Member for Single-Page Access yet. See: s2Member -> General Options -> Single-Page Access Restrictions.');
								return false;
							}
						else if (!desc) /* Each Single-Page purchase should have a description. */
							{
								alert('Please type a description for this purchase.');
								return false;
							}
						/**/
						var regAmount = $('input#ws-plugin--s2member-sp-amount').val ().replace (/[^0-9\.]/g, '');
						var pageStyle = $.trim ($('input#ws-plugin--s2member-sp-page-style').val ().replace (/"/g, ''));
						var currencyCode = $('select#ws-plugin--s2member-sp-currency').val ().replace (/[^A-Z]/g, '');
						/**/
						shortCodeTemplateAttrs += 'page="' + page + '" exp="' + hours + '" desc="' + desc + '" ps="' + pageStyle + '" cc="' + currencyCode + '"';
						shortCodeTemplateAttrs += ' custom="<?php echo $_SERVER["HTTP_HOST"]; ?>" ra="' + regAmount + '" sp="1"';
						shortCode.val (shortCodeTemplate.replace (/%%attrs%%/, shortCodeTemplateAttrs));
						/**/
						code.val (code.val ().replace (/ name\="item_name" value\="(.*?)"/, ' name="item_name" value="' + desc + '"'));
						code.val (code.val ().replace (/ name\="item_number" value\="(.*?)"/, ' name="item_number" value="sp:' + page + ':' + hours + '"'));
						code.val (code.val ().replace (/ name\="page_style" value\="(.*?)"/, ' name="page_style" value="' + pageStyle + '"'));
						code.val (code.val ().replace (/ name\="currency_code" value\="(.*?)"/, ' name="currency_code" value="' + currencyCode + '"'));
						code.val (code.val ().replace (/ name\="custom" value\="(.*?)"/, ' name="custom" value="<?php echo $_SERVER["HTTP_HOST"]; ?>"'));
						code.val (code.val ().replace (/ name\="amount" value\="(.*?)"/, ' name="amount" value="' + regAmount + '"'));
						/**/
						$('div#ws-plugin--s2member-sp-button-prev').html (code.val ().replace (/\<form/, '<form target="_blank"'));
						/**/
						alert('Your Codes have been generated.\nPlease copy/paste the Shortcode Format into your Membership Options Page.');
						/**/
						shortCode.each (function() /* Focus and select the recommended Shortcode. */
							{
								this.focus (), this.select ();
							});
						/**/
						return false;
					};
				/**/
				ws_plugin__s2member_paypalSpLinkGenerate = function() /* Handles PayPal® Link Generation for Single-Page access. */
					{
						var page = $('select#ws-plugin--s2member-sp-link-page').val ().replace (/[^0-9]/g, '');
						var hours = $('select#ws-plugin--s2member-sp-link-hours').val ().replace (/[^0-9]/g, '');
						var $link = $('p#ws-plugin--s2member-sp-link'), $loading = $('img#ws-plugin--s2member-sp-link-loading');
						/**/
						if (!page) /* Must have a Page ID to work with. Otherwise, link generation would fail. */
							{
								alert('Please select a Page from the drop-down.\n\nIf there are no Pages in the drop-down menu, it\'s because you\'ve not configured s2Member for Single-Page Access yet. See: s2Member -> General Options -> Single-Page Access Restrictions.');
								return false;
							}
						/**/
						$link.hide (), $loading.show (), $.post (ajaxurl, {action: 's2member_sp_access_link', s2member_sp_access_link: '<?php echo ws_plugin__s2member_esc_sq (wp_create_nonce ("ws-plugin--s2member-sp-access-link")); ?>', s2member_sp_access_link_page: page, s2member_sp_access_link_hours: hours}, function(response)
							{
								$link.show ().html ('<a href="' + response + '" target="_blank" rel="xlink">' + response + '</a>'), $loading.hide ();
							});
						/**/
						return false;
					};
			}
	});