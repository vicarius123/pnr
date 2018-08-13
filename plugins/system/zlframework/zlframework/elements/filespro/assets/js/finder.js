(function(b){var g=function(){};b.extend(g.prototype,{name:"FinderPro",initialize:function(c,a){function f(a){a.preventDefault();var e=b(this).closest(".finderpro li",c),h=c;e.length||(e=c);!e.hasClass("file")&&(e.hasClass(d.options.open)&&!e.hasClass("reload")?e.removeClass(d.options.open).children("ul").slideUp():(e.addClass("loading"),b.post(d.options.url+"&method=files",{path:e.data("path"),req_type:e.data("type")||"init"},function(a){e.find("span.zl-loaderhoriz").remove();e.removeClass("loading").addClass(d.options.open);
a.msg?(e.children().remove("ul"),e.append("<ul>").children("ul").append(b("<li>"+a.msg+"</li>"))):(!e.hasClass("reload")||!e.children("ul").length?d.tree(a,e,f):e.children("ul").slideUp(400,function(){e.removeClass("reload");d.tree(a,e,f)}),d.options.filemanager&&(c.data("toolbar-initialized")||(b('<span class="root-folder tools" />').append(b('<span class="zl-btn-small refresh action" title="Refresh" />').bind("click",function(){e.addClass("reload").find("li").addClass("loading");c.trigger("retrieve:finderpro").trigger("retrieve:finderpro")})).append(b('<span class="zl-btn-small plupload action" title="'+
filesPro.translate("Upload files into the main folder")+'" />').bind("click",function(){d.plupload(b(this),"",function(){e.addClass("reload").find("li").addClass("loading");c.trigger("retrieve:finderpro")})})).append(b('<span class="zl-btn-small add action" title="'+filesPro.translate("Create a new folder into the main folder")+'" />').bind("click",function(){d.Prompt(filesPro.translate("Input a name for the new folder"),filesPro.translate("MyFolder"),b(this),function(a){a&&e.find("li").addClass("loading")&&
b.post(d.options.url+"&method=newfolder",{path:"",newfolder:a},function(){e.addClass("reload");c.trigger("retrieve:finderpro")},"json")})})).prependTo(h.closest(".ui-dialog").find(".ui-dialog-titlebar")),c.data("toolbar-initialized",!0)),b(".ui-dialog").find(".tools span").qtip({position:{my:"bottom left",at:"top center"},show:{delay:700},style:"ui-tooltip-custom ui-tooltip-light ui-tooltip-rounded ui-tooltip-dialogue"})))},"json")))}var d=this;this.options=b.extend({url:"",path:"",open:"open",loading:"loading"},
a);c.data("path",this.options.path).bind("retrieve:finderpro",f).trigger("retrieve:finderpro")},tree:function(c,a,f){var d=this;c.length&&(a.children().remove("ul"),a.append("<ul>").children("ul").hide(),b.each(c,function(c,e){a.children("ul").append(b("<li>").append(b('<div class="btns"><a href="#">'+e.name+"</a></div>").append(d.options.filemanager&&b('<span class="tools" />').append("folder"==e.type&&b('<span class="zl-btn-small plupload action" title="'+filesPro.translate("Upload files into this folder")+
'" />').bind("click",function(){var a=b(this);d.plupload(a.closest("li"),e.path,function(){a.closest("li").addClass("reload");a.closest(".finderpro .btns").find("a").trigger("click")})})).append("folder"==e.type&&b('<span class="zl-btn-small add action" title="'+filesPro.translate("Create a new subfolder")+'" />').bind("click",function(){var a=b(this);d.Prompt(filesPro.translate("Input a name for the new folder"),filesPro.translate("MyFolder"),a.closest("li"),function(c){c&&a.closest("li").addClass("reload loading")&&
b.post(d.options.url+"&method=newfolder",{path:e.path,newfolder:c},function(){a.closest(".btns").find("a").trigger("click")},"json")})})).append(b('<span class="zl-btn-small delete action" title="'+filesPro.translate("Delete")+'" />').click(function(){var a=b(this);d.Confirm(filesPro.translate("You are about to delete")+' "'+e.name+'"',a.closest("li"),function(c){c&&a.closest("li").addClass("loading")&&b.post(d.options.url+"&method=delete",{path:e.path},function(){a.closest("li").fadeOut(400,function(){a.closest("li").remove()})},
"json")})})))).addClass(e.type).data("path",e.path).data("type",e.type).data("val",e.val))}),a.find("ul a").bind("click",f),a.children("ul").slideDown())},plupload:function(c,a,f){var d=this,a=b("<div />").appendTo("body").Plupload({url:d.options.url,path:void 0===a?"":a,extensions:d.options.extensions,fileMode:"files",callback:f});b('<a class="plupload_button plupload_cancel ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" />').append(b('<span class="ui-button-icon-primary ui-icon ui-icon-circle-close"></span>')).append(b('<span class="ui-button-text">'+
filesPro.translate("Cancel")+"</span>")).bind("hover",function(){b(this).toggleClass("ui-state-hover")}).bind("click",function(){b(this).closest(".qtip").qtip("hide");d.reset()}).appendTo(a.find(".plupload_buttons"));this.dialogue(a,c,"plupload")},dialogue:function(c,a,f){this.reset();a.find(".btns").first().addClass("action");b(a).qtip({content:{text:c},position:{my:"left bottom",at:"top right",viewport:b(window)},show:{ready:!0,solo:!0,delay:0},hide:!1,style:f+" ui-tooltip-custom ui-tooltip-filespro ui-tooltip-light ui-tooltip-rounded ui-tooltip-dialogue",
events:{render:function(a,c){b("button",c.elements.content).click(c.hide)},hide:function(b,a){a.destroy()}}})},Confirm:function(c,a,f){var c=b("<p />",{text:c}),d=b("<button />",{text:filesPro.translate("Confirm"),click:function(){f(!0);a.closest(".finderpro").find(".btns").removeClass("action")}}),g=b("<button />",{text:filesPro.translate("Cancel"),click:function(){f(!1);a.closest(".finderpro").find(".btns").removeClass("action")}});this.dialogue(c.add(d).add(g),a)},Prompt:function(c,a,f,d){var c=
b("<p />",{text:c}),g=b("<input />",{val:a}),a=b("<button />",{text:filesPro.translate("Confirm"),click:function(){d(g.val());f.closest(".finderpro").find(".btns").removeClass("action")}}),e=b("<button />",{text:filesPro.translate("Cancel"),click:function(){d(null);f.closest(".finderpro").find(".btns").removeClass("action")}});this.dialogue(c.add(g).add(a).add(e),f)},reset:function(){b(".finderpro").find(".btns").removeClass("action");b(".qtip").qtip("hide")}});b.fn[g.prototype.name]=function(){var c=
arguments,a=c[0]?c[0]:null;return this.each(function(){var f=b(this);if(g.prototype[a]&&f.data(g.prototype.name)&&"initialize"!=a)f.data(g.prototype.name)[a].apply(f.data(g.prototype.name),Array.prototype.slice.call(c,1));else if(!a||b.isPlainObject(a)){var d=new g;g.prototype.initialize&&d.initialize.apply(d,b.merge([f],c));f.data(g.prototype.name,d)}else b.error("Method "+a+" does not exist on jQuery."+g.name)})}})(jQuery);
(function(b){var g=function(){};b.extend(g.prototype,{name:"DirectoriesPro",initialize:function(c,a){this.options=b.extend({url:"",title:"Folders",extensions:null,mode:"folder",filemanager:!1},a);var f=this,d=b('<div class="finderpro"><span class="zl-loaderhoriz" /></div>').insertAfter(c).delegate("a","click",function(){d.find("div").removeClass("selected");var a=b(this).parent().addClass("selected").parent();"files"==f.options.mode&&a.hasClass("file")&&c.val(a.data("val"))&&c.trigger("change");"folders"==
f.options.mode&&a.hasClass("folder")&&c.val(a.data("val"))&&c.trigger("change");"both"==f.options.mode&&c.val(a.data("val"))&&c.trigger("change");d.FinderPro("reset")}),g=d.dialog(b.extend({autoOpen:!1,resizable:!1,open:function(){g.position({of:e,my:"left top",at:"right bottom"})},dragStop:function(){b(".qtip").qtip("reposition")},close:function(){b(".qtip").qtip("hide");b(".finderpro .btns").removeClass("action")}},f.options)).dialog("widget"),e=b('<span title="'+f.options.title+'" class="files" />').insertAfter(c).bind("click",
function(){d.dialog(d.dialog("isOpen")?"close":"open");b(this).data("initialized")||d.FinderPro(f.options);b(this).data("initialized",!0)});c.data("icon",e);c.data("dialog",g);b("html").bind("mousedown",function(a){d.dialog("isOpen")&&!e.is(a.target)&&!g.find(a.target).length&&!b(a.target).closest(".qtip").length&&d.dialog("close")})}});b.fn[g.prototype.name]=function(){var c=arguments,a=c[0]?c[0]:null;return this.each(function(){var f=b(this);if(g.prototype[a]&&f.data(g.prototype.name)&&"initialize"!=
a)f.data(g.prototype.name)[a].apply(f.data(g.prototype.name),Array.prototype.slice.call(c,1));else if(!a||b.isPlainObject(a)){var d=new g;g.prototype.initialize&&d.initialize.apply(d,b.merge([f],c));f.data(g.prototype.name,d)}else b.error("Method "+a+" does not exist on jQuery."+g.name)})}})(jQuery);