jQuery(document).ready(function(b){b("div#ws-menu-page-js-c-w").hide();b(window).resize(tb_position=function(){var c=(b(window).width()>720)?720:b(window).width(),e=b(window).height(),d=(b("body.admin-bar").length)?28:0;b("#TB_window").css({width:c-50+"px",height:e-45-d+"px",top:25+d+"px","margin-top":0,"margin-left":"-"+parseInt(((c-50)/2),10)+"px"});b("#TB_ajaxContent").css({width:c-50+"px",height:e-75-d+"px",margin:0,padding:0})});var a=b("div.ws-menu-page-group");a.each(function(e){var g=b(this),d="<ins>+</ins>",f=g,h=b.trim(f.attr("title"));var c=b('<div class="ws-menu-page-group-header">'+d+h+"</div>");c.css({"z-index":100-e});c.insertBefore(f),f.hide(),c.click(function(){var k=b(this),j=b("ins",k),i=k.next();if(i.css("display")==="none"){k.addClass("open"),j.html("-"),i.show()}else{k.removeClass("open"),j.html("+"),i.hide()}return false});if(a.length>1&&e===0){b('<div class="ws-menu-page-groups-show">+</div>').insertBefore(c).click(function(){b("div.ws-menu-page-group-header").each(function(){var k=b(this),j=b("ins",k),i=k.next();k.addClass("open"),j.html("-"),i.show();return});return false});b('<div class="ws-menu-page-groups-hide">-</div>').insertBefore(c).click(function(){b("div.ws-menu-page-group-header").each(function(){var k=b(this),j=b("ins",k),i=k.next();k.removeClass("open"),j.html("+"),i.hide();return});return false})}if(f.attr("default-state")==="open"){c.trigger("click")}return});if(a.length>1){b("div.ws-menu-page-group-header:first").css({"margin-right":"140px"});b("div.ws-menu-page-group:first").css({"margin-right":"145px"})}b("div.ws-menu-page-r-group-header").click(function(){var d=b(this),c=d.next("div.ws-menu-page-r-group");if(c.css("display")==="none"){b("ins",d).html("-"),d.addClass("open"),c.show()}else{b("ins",d).html("+"),d.removeClass("open");c.hide()}return false});b("div.ws-menu-page-group-header:first, div.ws-menu-page-r-group-header:first").css({"margin-top":"0"});b("div.ws-menu-page-group > div.ws-menu-page-section:first-child > h3").css({"margin-top":"0"});b("div.ws-menu-page-readme > div.readme > div.section:last-child").css({"border-bottom-width":"0"});b("input.ws-menu-page-media-btn").filter(function(){return(b(this).attr("rel"))?true:false}).click(function(){var c=b(this);window.send_to_editor=function(g){var h,f,d=b.trim(c.attr("rel"));if(d&&(h=b("input#"+d)).length>0){var e=h.css("background-color"),i=b.trim(b(g).attr("src"));i=(!i)?b.trim(b("img",g).attr("src")):i;h.val(i),h.css({"background-color":"#FFFFCC"}),setTimeout(function(){h.css({"background-color":e})},2000);tb_remove();return}else{if(d&&(f=b("textarea#"+d)).length>0){var e=f.css("background-color"),i=b.trim(b(g).attr("src"));i=(!i)?b.trim(b("img",g).attr("src")):i;f.val(b.trim(f.val())+"\n"+i),f.css({"background-color":"#FFFFCC"}),setTimeout(function(){f.css({"background-color":e})},2000);tb_remove();return}}};tb_show("","./media-upload.php?type=image&TB_iframe=true");return false});b("form#ws-updates-form").submit(function(){var c="";if(!b.trim(b("input#ws-updates-fname").val())){c+="First Name missing, please try again.\n\n"}if(!b.trim(b("input#ws-updates-lname").val())){c+="Last Name missing, please try again.\n\n"}if(!b.trim(b("input#ws-updates-email").val())){c+="Email missing, please try again.\n\n"}else{if(!b("input#ws-updates-email").val().match(/^([a-z_~0-9\+\-]+)(((\.?)([a-z_~0-9\+\-]+))*)(@)([a-z0-9]+)(((-*)([a-z0-9]+))*)(((\.)([a-z0-9]+)(((-*)([a-z0-9]+))*))*)(\.)([a-z]{2,6})$/i)){c+="Invalid email address, please try again.\n\n"}}if(c=b.trim(c)){alert("— Oops, you missed something: —\n\n"+c);return false}return true})});