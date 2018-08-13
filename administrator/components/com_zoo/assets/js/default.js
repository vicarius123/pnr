/* Copyright (C) YOOtheme GmbH, http://www.gnu.org/licenses/gpl.html GNU/GPL */

jQuery(function(t){var i=t('form[name="adminForm"]'),e=t('[name="boxchecked"]:hidden',i);t("#submenu li").addClass(function(){return"item"+(t(this).index()+1)});t("select.auto-submit").bind("change",function(){i.submit()});t("table.stripe tbody tr").addClass(function(t,i){return t%2?"even":"odd"});i.delegate("input.check-all","click",function(n){var a=t(this).is(":checked");var s=t('[name="cid[]"]:checkbox',i).attr("checked",function(t,i){return a});e.val(s.filter(":checked").length)});i.delegate('[name="cid[]"]:checkbox',"click",function(i){var n=parseInt(e.val());e.val(t(this).is(":checked")?n+1:n-1)});i.delegate('table tr a[rel^="task-"]',"click",function(e){e.preventDefault();var n=t(this).closest("tr").find('input[name="cid[]"]').val();t('input[name="task"]',i).val(t(this).attr("rel").replace(/task-/,""));i.append('<input type="hidden" name="cid" value="'+n+'" />');i.submit()});t("#parameter-accordion").accordionMenu({mode:"slide",display:0});t.each(["apply","save","save-new"],function(e,n){var a=t("#toolbar-"+n+" a, #toolbar-"+n+" button");if(a.length){var s=a.attr("onclick").toString().replace(/\n*/gi,"").replace(/.*submitbutton\(['|"](.*)['|"]\).*/g,"$1");a.removeAttr("onclick").bind("click",function(e){var n=t.Event("validate.adminForm");t(this).trigger(n);if(!n.isDefaultPrevented()){i.find(".placeholder:text").val("");submitbutton(s)}})}});t("#nav li.level1 a").each(function(){t(this).attr("title",t.trim(t(this).text()))});if(t("#nav [data-zooversion].active").length){t('<span class="version" />').text("ZOO "+t("#nav [data-zooversion].active").data("zooversion")).appendTo("#nav div.bar")}t("#nav").MenuResize();t.Message=function(i,e){var n=t.parseJSON(i);if(n){if(n.group=="info"){if(e)return;return}else if(n.group=="error"){alert(n.title+"-"+n.text);return}}window.location="index.php"}});(function(t){var i=function(){};t.extend(i.prototype,{name:"MenuResize",initialize:function(i,e){this.options=t.extend({},this.options,e);var n=this;this.nav=i;this.spans=i.find("li.level1 > .level1 > span");this.widths=[],this.padding_lefts=[],this.padding_rights=[];this.spans.each(function(i){n.widths[i]=parseInt(t(this).css("width").replace("px",""));n.padding_lefts[i]=parseInt(t(this).css("padding-left").replace("px",""));n.padding_rights[i]=parseInt(t(this).css("padding-right").replace("px",""))});this.width=0;i.find("li.level1").each(function(){n.width+=t(this).outerWidth(true)});this.initial_width=this.width;this.resizeTabs();t(window).bind("resize",function(){n.resizeTabs()})},resizeTabs:function(){var i=this;var e=this.nav.innerWidth();var n=[],a=[],s=[];this.spans.each(function(t){n[t]=i.widths[t];a[t]=i.padding_lefts[t];s[t]=i.padding_rights[t]});this.width=this.initial_width;while(e<=this.width){var r=0,d=false;this.spans.each(function(t){if(a[t]>0){i.width-=1;a[t]-=1;d=true}if(s[t]>0){i.width-=1;s[t]-=1;d=true}if(n[t]>n[r]){r=t}});if(d===false){this.width-=10;n[r]-=10}}this.spans.each(function(i){if(t(this).css("width")!=n[i]+"px"){t(this).css("width",n[i]+"px")}if(t(this).css("padding-left")!=a[i]+"px"){t(this).css("padding-left",a[i]+"px")}if(t(this).css("padding-right")!=s[i]+"px"){t(this).css("padding-right",s[i]+"px")}})}});t.fn[i.prototype.name]=function(){var e=arguments;var n=e[0]?e[0]:null;return this.each(function(){var a=t(this);if(i.prototype[n]&&a.data(i.prototype.name)&&n!="initialize"){a.data(i.prototype.name)[n].apply(a.data(i.prototype.name),Array.prototype.slice.call(e,1))}else if(!n||t.isPlainObject(n)){var s=new i;if(i.prototype["initialize"]){s.initialize.apply(s,t.merge([a],e))}a.data(i.prototype.name,s)}else{t.error("Method "+n+" does not exist on jQuery."+i.name)}})}})(jQuery);