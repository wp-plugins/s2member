jQuery(document).ready(function(c){var b='<?php echo c_ws_plugin__s2member_utils_conds::bp_is_installed ("query-active-plugins") ? "1" : ""; ?>';var a='<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (c_ws_plugin__s2member_utils_dirs::basename_dir_app_data ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])); ?>';var d=[];if(S2MEMBER_CURRENT_USER_IS_LOGGED_IN&&S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY<S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED){c('a[href*="s2member_file_download="], a[href*="/s2member-files/"], a[href^="s2member-files/"], a[href*="/'+a.replace(/([\:\.\[\]])/g,"\\$1")+'/"], a[href^="'+a.replace(/([\:\.\[\]])/g,"\\$1")+'/"]').click(function(){if(!this.href.match(/s2member[_\-]file[_\-]download[_\-]key[\=\-].+/i)){var e='<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Confirm File Download —", "s2member-front", "s2member")); ?>\n\n';e+=c.sprintf('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("You`ve downloaded %s protected %s in the last %s.", "s2member-front", "s2member")); ?>',S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY,((S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY===1)?'<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("file", "s2member-front", "s2member")); ?>':'<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("files", "s2member-front", "s2member")); ?>'),((S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS===1)?'<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("24 hours", "s2member-front", "s2member")); ?>':c.sprintf('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("%s days", "s2member-front", "s2member")); ?>',S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS)))+"\n\n";e+=(S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_IS_UNLIMITED)?'<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("You`re entitled to UNLIMITED downloads though ( so, no worries ).", "s2member-front", "s2member")); ?>':c.sprintf('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("You`re entitled to %s unique %s %s.", "s2member-front", "s2member")); ?>',S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED,((S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED===1)?'<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("download", "s2member-front", "s2member")); ?>':'<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("downloads", "s2member-front", "s2member")); ?>'),((S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS===1)?'<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("each day", "s2member-front", "s2member")); ?>':c.sprintf('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("every %s-day period", "s2member-front", "s2member")); ?>',S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS)));if((this.href.match(/s2member[_\-]skip[_\-]confirmation/i)&&!this.href.match(/s2member[_\-]skip[_\-]confirmation[\=\-](0|no|false)/i))||confirm(e)){if(c.inArray(this.href,d)===-1){S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY++,d.push(this.href)}return true}else{return false}}else{return true}})}if(!location.href.match(/\/wp-admin(\/|\?|$)/)){c("input#ws-plugin--s2member-profile-password1, input#ws-plugin--s2member-profile-password2").keyup(function(){ws_plugin__s2member_passwordStrength(c("input#ws-plugin--s2member-profile-login"),c("input#ws-plugin--s2member-profile-password1"),c("input#ws-plugin--s2member-profile-password2"),c("div#ws-plugin--s2member-profile-password-strength"))});c("form#ws-plugin--s2member-profile").submit(function(){var g=this,f="",e="",k="";var i=c("input#ws-plugin--s2member-profile-password1",g);var h=c("input#ws-plugin--s2member-profile-password2",g);var j=c("input#ws-plugin--s2member-profile-submit",g);c(":input",g).each(function(){var l=c.trim(c(this).attr("id")).replace(/-[0-9]+$/g,"");if(l&&(f=c.trim(c('label[for="'+l+'"]',g).first().children("strong").first().text().replace(/[\r\n\t]+/g," ")))){if(e=ws_plugin__s2member_validationErrors(f,this,g)){k+=e+"\n\n"}}});if(k=c.trim(k)){alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>\n\n'+k);return false}else{if(c.trim(i.val())&&c.trim(i.val())!==c.trim(h.val())){alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>\n\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Passwords do not match up. Please try again.", "s2member-front", "s2member")); ?>');return false}else{if(c.trim(i.val())&&c.trim(i.val()).length<6){alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>\n\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Password MUST be at least 6 characters. Please try again.", "s2member-front", "s2member")); ?>');return false}}}ws_plugin__s2member_animateProcessing(j);return true})}if(location.href.match(/\/wp-signup\.php/)){c("div#content > div.mu_register > form#setupform").submit(function(){var g=this,f="",e="",i="";c("input#user_email",g).attr("data-expected","email");var h=c('p.submit input[type="submit"]',g);c("input#user_name, input#user_email, input#blogname, input#blog_title, input#captcha_code",g).attr({"aria-required":"true"});c(":input",g).each(function(){var j=c.trim(c(this).attr("id")).replace(/-[0-9]+$/g,"");if(j&&(f=c.trim(c('label[for="'+j+'"]',g).first().text().replace(/[\r\n\t]+/g," ")))){if(e=ws_plugin__s2member_validationErrors(f,this,g)){i+=e+"\n\n"}}});if(i=c.trim(i)){alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>\n\n'+i);return false}ws_plugin__s2member_animateProcessing(h);return true})}if(location.href.match(/\/wp-login\.php/)){c("input#ws-plugin--s2member-custom-reg-field-user-pass1, input#ws-plugin--s2member-custom-reg-field-user-pass2").keyup(function(){ws_plugin__s2member_passwordStrength(c("input#user_login"),c("input#ws-plugin--s2member-custom-reg-field-user-pass1"),c("input#ws-plugin--s2member-custom-reg-field-user-pass2"),c("div#ws-plugin--s2member-custom-reg-field-user-pass-strength"))});c("div#login > form#registerform input#wp-submit").attr("tabindex","1000");c("div#login > form#registerform").submit(function(){var g=this,f="",e="",k="";c("input#user_email",g).attr("data-expected","email");var j=c('input#ws-plugin--s2member-custom-reg-field-user-pass1[aria-required="true"]',g);var h=c("input#ws-plugin--s2member-custom-reg-field-user-pass2",g);var i=c("input#wp-submit",g);c("input#user_login, input#user_email, input#captcha_code",g).attr({"aria-required":"true"});c(":input",g).each(function(){var l=c.trim(c(this).attr("id")).replace(/-[0-9]+$/g,"");if(c.inArray(l,["user_login","user_email","captcha_code"])!==-1){if((f=c.trim(c(this).parent("label").text().replace(/[\r\n\t]+/g," ")))){if(e=ws_plugin__s2member_validationErrors(f,this,g)){k+=e+"\n\n"}}}else{if(l&&(f=c.trim(c('label[for="'+l+'"]',g).first().children("span").first().text().replace(/[\r\n\t]+/g," ")))){if(e=ws_plugin__s2member_validationErrors(f,this,g)){k+=e+"\n\n"}}}});if(k=c.trim(k)){alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>\n\n'+k);return false}else{if(j.length&&c.trim(j.val())!==c.trim(h.val())){alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>\n\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Passwords do not match up. Please try again.", "s2member-front", "s2member")); ?>');return false}else{if(j.length&&c.trim(j.val()).length<6){alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>\n\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Password MUST be at least 6 characters. Please try again.", "s2member-front", "s2member")); ?>');return false}}}ws_plugin__s2member_animateProcessing(i);return true})}if(location.href.match(/\/wp-admin\/(user\/)?profile\.php/)){c("form#your-profile").submit(function(){var g=this,f="",e="",h="";c("input#email",g).attr("data-expected","email");c(':input[id^="ws-plugin--s2member-profile-"]',g).each(function(){var i=c.trim(c(this).attr("id")).replace(/-[0-9]+$/g,"");if(i&&(f=c.trim(c('label[for="'+i+'"]',g).first().text().replace(/[\r\n\t]+/g," ")))){if(e=ws_plugin__s2member_validationErrors(f,this,g)){h+=e+"\n\n"}}});if(h=c.trim(h)){alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>\n\n'+h);return false}return true})}if(b){c("body.registration form div#ws-plugin--s2member-custom-reg-fields-4bp-section").closest("form").submit(function(){var g=this,f="",e="",h="";c("input#signup_email",g).attr("data-expected","email");c("input#signup_username, input#signup_email, input#signup_password, input#field_1",g).attr({"aria-required":"true"});c(":input",g).each(function(){var i=c.trim(c(this).attr("id")).replace(/-[0-9]+$/g,"");if(i&&(f=c.trim(c('label[for="'+i+'"]',g).first().text().replace(/[\r\n\t]+/g," ")))){if(e=ws_plugin__s2member_validationErrors(f,this,g)){h+=e+"\n\n"}}});if(h=c.trim(h)){alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>\n\n'+h);return false}return true});c("body.logged-in.profile.profile-edit :input.ws-plugin--s2member-profile-field-4bp").closest("form").submit(function(){var g=this,f="",e="",h="";c("input#field_1",g).attr({"aria-required":"true"});c(":input",g).each(function(){var i=c.trim(c(this).attr("id")).replace(/-[0-9]+$/g,"");if(i&&(f=c.trim(c('label[for="'+i+'"]',g).first().text().replace(/[\r\n\t]+/g," ")))){if(e=ws_plugin__s2member_validationErrors(f,this,g)){h+=e+"\n\n"}}});if(h=c.trim(h)){alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>\n\n'+h);return false}return true})}ws_plugin__s2member_passwordStrength=function(f,h,g,e){if(f instanceof jQuery&&h instanceof jQuery&&g instanceof jQuery&&e instanceof jQuery&&typeof passwordStrength==="function"&&typeof pwsL10n==="object"){e.removeClass("ws-plugin--s2member-password-strength-short ws-plugin--s2member-password-strength-bad ws-plugin--s2member-password-strength-good ws-plugin--s2member-password-strength-strong ws-plugin--s2member-password-strength-mismatch");switch(passwordStrength(h.val(),f.val(),g.val())){case 1:e.addClass("ws-plugin--s2member-password-strength-short").html(pwsL10n["short"]);break;case 2:e.addClass("ws-plugin--s2member-password-strength-bad").html(pwsL10n.bad);break;case 3:e.addClass("ws-plugin--s2member-password-strength-good").html(pwsL10n.good);break;case 4:e.addClass("ws-plugin--s2member-password-strength-strong").html(pwsL10n.strong);break;case 5:e.addClass("ws-plugin--s2member-password-strength-mismatch").html(pwsL10n.mismatch);break;default:e.addClass("ws-plugin--s2member-password-strength-short").html(pwsL10n["short"])}}return};ws_plugin__s2member_validationErrors=function(q,p,f,l,k){if(typeof q==="string"&&q&&typeof p==="object"&&typeof f==="object"){if(typeof p.tagName==="string"&&p.tagName.match(/^(input|textarea|select)$/i)&&!p.disabled){var s=p.tagName.toLowerCase(),o=c(p),n=c.trim(o.attr("type")).toLowerCase(),e=c.trim(o.attr("name")),r=o.val();var l=(typeof l==="boolean")?l:(o.attr("aria-required")==="true"),k=(typeof k==="string")?k:c.trim(o.attr("data-expected"));var j=('<?php echo strlen($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_force_personal_emails"]); ?>'>0)?true:false;var h=new RegExp('^(<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (implode ("|", preg_split ("/[\r\n\t ;,]+/", preg_quote ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_force_personal_emails"], "/")))); ?>)@',"i");if(s==="input"&&n==="checkbox"&&e.match(/\[\]$/)){if(typeof p.id==="string"&&p.id.match(/-0$/)){if(l&&!c('input[name="'+e.replace(/([\[\]])/g,"$1")+'"]:checked',f).length){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please check at least one of the boxes.", "s2member-front", "s2member")); ?>'}}}else{if(s==="input"&&n==="checkbox"){if(l&&!p.checked){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Required. This box must be checked.", "s2member-front", "s2member")); ?>'}}else{if(s==="input"&&n==="radio"){if(typeof p.id==="string"&&p.id.match(/-0$/)){if(l&&!c('input[name="'+e.replace(/([\[\]])/g,"$1")+'"]:checked',f).length){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please select one of the options.", "s2member-front", "s2member")); ?>'}}}else{if(s==="select"&&o.attr("multiple")){if(l&&(!(r instanceof Array)||!r.length)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please select at least one of the options.", "s2member-front", "s2member")); ?>'}}else{if(typeof r!=="string"||(l&&!(r=c.trim(r)).length)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("This is a required field, please try again.", "s2member-front", "s2member")); ?>'}else{if((r=c.trim(r)).length&&((s==="input"&&n.match(/^(text|password)$/i))||s==="textarea")&&typeof k==="string"&&k.length){if(k==="numeric-wp-commas"&&(!r.match(/^[0-9\.,]+$/)||isNaN(r.replace(/,/g,"")))){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be numeric ( with or without decimals, commas allowed ).", "s2member-front", "s2member")); ?>'}else{if(k==="numeric"&&(!r.match(/^[0-9\.]+$/)||isNaN(r))){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be numeric ( with or without decimals, no commas ).", "s2member-front", "s2member")); ?>'}else{if(k==="integer"&&(!r.match(/^[0-9]+$/)||isNaN(r))){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be an integer ( a whole number, without any decimals ).", "s2member-front", "s2member")); ?>'}else{if(k==="integer-gt-0"&&(!r.match(/^[0-9]+$/)||isNaN(r)||r<=0)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be an integer > 0 ( whole number, no decimals, greater than 0 ).", "s2member-front", "s2member")); ?>'}else{if(k==="float"&&(!r.match(/^[0-9\.]+$/)||!r.match(/[0-9]/)||!r.match(/\./)||isNaN(r))){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a float ( floating point number, decimals required ).", "s2member-front", "s2member")); ?>'}else{if(k==="float-gt-0"&&(!r.match(/^[0-9\.]+$/)||!r.match(/[0-9]/)||!r.match(/\./)||isNaN(r)||r<=0)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a float > 0 ( floating point number, decimals required, greater than 0 ).", "s2member-front", "s2member")); ?>'}else{if(k==="date"&&!r.match(/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a date ( required date format: dd/mm/yyyy ).", "s2member-front", "s2member")); ?>'}else{if(k==="email"&&!r.match(/^([a-z_~0-9\+\-]+)(((\.?)([a-z_~0-9\+\-]+))*)(@)([a-z0-9]+)(((-*)([a-z0-9]+))*)(((\.)([a-z0-9]+)(((-*)([a-z0-9]+))*))*)(\.)([a-z]{2,6})$/i)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a valid email address.", "s2member-front", "s2member")); ?>'}else{if(k==="email"&&j&&r.match(h)){return q+"\n"+c.sprintf('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please use a personal email address.\nAddresses like <%s@> are problematic.", "s2member-front", "s2member")); ?>',r.split("@")[0])}else{if(k==="url"&&!r.match(/^http(s?)\:\/\/(.{5,})$/i)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a full URL ( starting with http or https ).", "s2member-front", "s2member")); ?>'}else{if(k==="domain"&&!r.match(/^([a-z0-9]+)(((-*)([a-z0-9]+))*)(((\.)([a-z0-9]+)(((-*)([a-z0-9]+))*))*)(\.)([a-z]{2,6})$/i)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a domain name ( domain name only, without http ).", "s2member-front", "s2member")); ?>'}else{if(k==="phone"&&(!r.match(/^[0-9 \(\)\-]+$/)||r.replace(/[^0-9]/g,"").length!==10)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a phone # ( 10 digits w/possible hyphens,spaces,brackets ).", "s2member-front", "s2member")); ?>'}else{if(k==="uszip"&&!r.match(/^[0-9]{5}(-[0-9]{4})?$/)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a US zipcode ( 5-9 digits w/possible hyphen ).", "s2member-front", "s2member")); ?>'}else{if(k==="cazip"&&!r.match(/^[0-9A-Z]{3}( ?)[0-9A-Z]{3}$/i)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a Canadian zipcode ( 6 alpha-numerics w/possible space ).", "s2member-front", "s2member")); ?>'}else{if(k==="uczip"&&!r.match(/^[0-9]{5}(-[0-9]{4})?$/)&&!r.match(/^[0-9A-Z]{3}( ?)[0-9A-Z]{3}$/i)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a zipcode ( either a US or Canadian zipcode ).", "s2member-front", "s2member")); ?>'}else{if(k.match(/^alphanumerics-spaces-punctuation-([0-9]+)(-e)?$/)&&!r.match(/^[a-z 0-9,\.\/\?\:;"'\{\}\[\]\|\\\+\=_\-\(\)\*&\^%\$#@\!`~]+$/i)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please use alphanumerics, spaces & punctuation only.", "s2member-front", "s2member")); ?>'}else{if(k.match(/^alphanumerics-spaces-([0-9]+)(-e)?$/)&&!r.match(/^[a-z 0-9]+$/i)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please use alphanumerics & spaces only.", "s2member-front", "s2member")); ?>'}else{if(k.match(/^alphanumerics-punctuation-([0-9]+)(-e)?$/)&&!r.match(/^[a-z0-9,\.\/\?\:;"'\{\}\[\]\|\\\+\=_\-\(\)\*&\^%\$#@\!`~]+$/i)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please use alphanumerics & punctuation only ( no spaces ).", "s2member-front", "s2member")); ?>'}else{if(k.match(/^alphanumerics-([0-9]+)(-e)?$/)&&!r.match(/^[a-z0-9]+$/i)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please use alphanumerics only ( no spaces/punctuation ).", "s2member-front", "s2member")); ?>'}else{if(k.match(/^alphabetics-([0-9]+)(-e)?$/)&&!r.match(/^[a-z]+$/i)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please use alphabetics only ( no digits/spaces/punctuation ).", "s2member-front", "s2member")); ?>'}else{if(k.match(/^numerics-([0-9]+)(-e)?$/)&&!r.match(/^[0-9]+$/i)){return q+'\n<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please use numeric digits only.", "s2member-front", "s2member")); ?>'}else{if(k.match(/^(any|alphanumerics-spaces-punctuation|alphanumerics-spaces|alphanumerics-punctuation|alphanumerics|alphabetics|numerics)-([0-9]+)(-e)?$/)){var m=k.split("-"),g=Number(m[1]),i=(m.length>2&&m[2]==="e")?true:false;if(i&&r.length!==g){return q+"\n"+c.sprintf('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be exactly %s %s.", "s2member-front", "s2member")); ?>',g,((m[0]==="numerics")?((g===1)?'<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("digit", "s2member-front", "s2member")); ?>':'<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("digits", "s2member-front", "s2member")); ?>'):((g===1)?'<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("character", "s2member-front", "s2member")); ?>':'<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("characters", "s2member-front", "s2member")); ?>')))}else{if(r.length<g){return q+"\n"+c.sprintf('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be at least %s %s.", "s2member-front", "s2member")); ?>',g,((m[0]==="numerics")?((g===1)?'<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("digit", "s2member-front", "s2member")); ?>':'<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("digits", "s2member-front", "s2member")); ?>'):((g===1)?'<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("character", "s2member-front", "s2member")); ?>':'<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("characters", "s2member-front", "s2member")); ?>')))}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}return""};ws_plugin__s2member_animateProcessingConfig={originalText:"",interval:null,speed:100},ws_plugin__s2member_animateProcessing=function(f,e){if(f instanceof jQuery){if(e){clearInterval(ws_plugin__s2member_animateProcessingConfig.interval);if(ws_plugin__s2member_animateProcessingConfig.originalText){f.val(ws_plugin__s2member_animateProcessingConfig.originalText)}return}f.first().each(function(){var j=c(this),h=0,g="r",k=[".","..","..."];ws_plugin__s2member_animateProcessingConfig.originalText=j.val();clearInterval(ws_plugin__s2member_animateProcessingConfig.interval);ws_plugin__s2member_animateProcessingConfig.interval=setInterval(function(){if(g==="r"){if(h+1<=k.length-1){h=h+1,g="r"}else{h=h-1,g="l"}}else{if(g==="l"){if(h-1>=0){h=h-1,g="l"}else{h=h+1,g="r"}}}for(var m=k[h],i=k[h].length;i<k.length;i++){m+=" "}j.val('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Processing", "s2member-front", "s2member")); ?>'+m)},ws_plugin__s2member_animateProcessingConfig.speed)})}}});