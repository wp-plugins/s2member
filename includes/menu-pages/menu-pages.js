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
				return($(this).attr ('rel')) ? true : false; /* Must have rel targeting an input id. */
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
		$('form#ws-plugin--s2member-buttons-form select#ws-plugin--s2member-level1-term').change (function()
			{
				var trialDisabled = ($(this).val ().split ('-')[1].replace (/[^A-Z]/g, '') === 'L') ? 'disabled' : '';
				$('p#ws-plugin--s2member-level1-trial-line').css ('display', (trialDisabled ? 'none' : ''));
				$('span#ws-plugin--s2member-level1-trial-then').css ('display', (trialDisabled ? 'none' : ''));
			});
		/**/
		$('form#ws-plugin--s2member-buttons-form select#ws-plugin--s2member-level2-term').change (function()
			{
				var trialDisabled = ($(this).val ().split ('-')[1].replace (/[^A-Z]/g, '') === 'L') ? 'disabled' : '';
				$('p#ws-plugin--s2member-level2-trial-line').css ('display', (trialDisabled ? 'none' : ''));
				$('span#ws-plugin--s2member-level2-trial-then').css ('display', (trialDisabled ? 'none' : ''));
			});
		/**/
		$('form#ws-plugin--s2member-buttons-form select#ws-plugin--s2member-level3-term').change (function()
			{
				var trialDisabled = ($(this).val ().split ('-')[1].replace (/[^A-Z]/g, '') === 'L') ? 'disabled' : '';
				$('p#ws-plugin--s2member-level3-trial-line').css ('display', (trialDisabled ? 'none' : ''));
				$('span#ws-plugin--s2member-level3-trial-then').css ('display', (trialDisabled ? 'none' : ''));
			});
		/**/
		$('form#ws-plugin--s2member-buttons-form select#ws-plugin--s2member-level4-term').change (function()
			{
				var trialDisabled = ($(this).val ().split ('-')[1].replace (/[^A-Z]/g, '') === 'L') ? 'disabled' : '';
				$('p#ws-plugin--s2member-level4-trial-line').css ('display', (trialDisabled ? 'none' : ''));
				$('span#ws-plugin--s2member-level4-trial-then').css ('display', (trialDisabled ? 'none' : ''));
			});
		/**/
		ws_plugin__s2member_paypalButtonGenerate = function(level) /* Handles PayPal® Button Generation. */
			{
				var code = $('#ws-plugin--s2member-level' + level + '-button');
				var shortCode = '[s2Member-PayPal-Button %%attrs%% /]', shortCodeAttrs = '', shortCodeMesg = '';
				/**/
				var trialPeriod = $('#ws-plugin--s2member-level' + level + '-trial-period').val ().replace (/[^0-9]/g, '');
				var trialTerm = $('#ws-plugin--s2member-level' + level + '-trial-term').val ().replace (/[^A-Z]/g, '');
				var regAmount = $('#ws-plugin--s2member-level' + level + '-amount').val ().replace (/[^0-9\.]/g, '');
				var regPeriod = $('#ws-plugin--s2member-level' + level + '-term').val ().split ('-')[0].replace (/[^0-9]/g, '');
				var regTerm = $('#ws-plugin--s2member-level' + level + '-term').val ().split ('-')[1].replace (/[^A-Z]/g, '');
				var regRecur = $('#ws-plugin--s2member-level' + level + '-term').val ().split ('-')[2].replace (/[^0-1]/g, '');
				var pageStyle = $.trim ($('#ws-plugin--s2member-level' + level + '-page-style').val ().replace (/["']/g, ''));
				var currencyCode = $('#ws-plugin--s2member-level' + level + '-currency').val ().replace (/[^A-Z]/g, '');
				trialPeriod = (regTerm === 'L') ? '0' : trialPeriod; /* Lifetime access is NOT compatible w/trials. */
				/**/
				code.val (code.val ().replace (/\<\!--(\<input type\="hidden" name\="(amount|modify|src|sra|a1|p1|t1|a3|p3|t3)" value\="(.*?)"\>)--\>$/gm, "$1"));
				(parseInt(trialPeriod) <= 0) ? code.val (code.val ().replace (/(\<input type\="hidden" name\="(a1|p1|t1)" value\="(.*?)"\>)$/gm, "<!--$1-->")) : null;
				(regTerm === 'L') ? code.val (code.val ().replace (/(\<input type\="hidden" name\="cmd" value\=")(.*?)("\>)$/gm, "$1_xclick$3")) : null;
				(regTerm === 'L') ? code.val (code.val ().replace (/(\<input type\="hidden" name\="(modify|src|sra|a1|p1|t1|a3|p3|t3)" value\="(.*?)"\>)$/gm, "<!--$1-->")) : null;
				(regTerm !== 'L') ? code.val (code.val ().replace (/(\<input type\="hidden" name\="cmd" value\=")(.*?)("\>)$/gm, "$1_xclick-subscriptions$3")) : null;
				(regTerm !== 'L') ? code.val (code.val ().replace (/(\<input type\="hidden" name\="amount" value\="(.*?)"\>)$/gm, "<!--$1-->")) : null;
				/**/
				code.val (code.val ().replace (/name\="currency_code" value\="(.*?)"/, 'name="currency_code" value="' + currencyCode + '"'));
				code.val (code.val ().replace (/name\="amount" value\="(.*?)"/, 'name="amount" value="' + regAmount + '"'));
				code.val (code.val ().replace (/name\="src" value\="(.*?)"/, 'name="src" value="' + regRecur + '"'));
				code.val (code.val ().replace (/name\="p1" value\="(.*?)"/, 'name="p1" value="' + trialPeriod + '"'));
				code.val (code.val ().replace (/name\="t1" value\="(.*?)"/, 'name="t1" value="' + trialTerm + '"'));
				code.val (code.val ().replace (/name\="a3" value\="(.*?)"/, 'name="a3" value="' + regAmount + '"'));
				code.val (code.val ().replace (/name\="p3" value\="(.*?)"/, 'name="p3" value="' + regPeriod + '"'));
				code.val (code.val ().replace (/name\="t3" value\="(.*?)"/, 'name="t3" value="' + regTerm + '"'));
				code.val (code.val ().replace (/name\="page_style" value\="(.*?)"/, 'name="page_style" value="' + pageStyle + '"'));
				/**/
				shortCodeAttrs += 'level="' + level + '" ps="' + pageStyle + '" cc="' + currencyCode + '" on0="" os0="" modify="0" custom="<?php echo $_SERVER["HTTP_HOST"]; ?>"';
				shortCodeAttrs += ' tp="' + trialPeriod + '" tt="' + trialTerm + '" ra="' + regAmount + '" rp="' + regPeriod + '" rt="' + regTerm + '" rr="' + regRecur + '"';
				shortCode = shortCode.replace (/%%attrs%%/, shortCodeAttrs).replace (/"/g, '&quot;');
				/**/
				shortCodeMesg += '* <strong>&darr; Alternate Shortcode Format:</strong> ( recommended for the WordPress® Visual Editor )<br />';
				shortCodeMesg += '<input type="text" value="' + shortCode + '" style="font-family:monospace; width:99%;" onclick="this.select ();" />';
				$('div#ws-plugin--s2member-level' + level + '-shortcode-mesg').html (shortCodeMesg);
				/**/
				$('#ws-plugin--s2member-level' + level + '-button-prev').html (code.val ().replace (/\<form/, '<form target="_blank"'));
				/**/
				alert('Your Button Code for Membership Level #' + level + ' has been generated. Please copy/paste the code into your Membership Options Page.');
				/**/
				code.each (function() /* Focus and select the code. */
					{
						this.focus (), this.select ();
					});
				/**/
				return false;
			};
	});