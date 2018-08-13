jQuery(function (b) {
    var f = location.href.match(/^(.+)administrator\/index\.php.*/i)[1];
    b("input.image-lang-select").each(function (c) {
        var a = b(this),
            d = "image-lang-select-" + c;
        c = b('<button type="button">').text("Select Image").insertAfter(a);
        var e = b("<span>").addClass("image-lang-cancel").insertAfter(a),
            g = b("<div>").addClass("image-lang-preview").insertAfter(c);
        a.attr("id", d);
        a.val() && b("<img>").attr("src", f + a.val()).appendTo(g);
        e.click(function () {
            a.val("");
            g.empty()
        });
        c.click(function (h) {
            h.preventDefault();
            SqueezeBox.fromElement(this, {
                handler: "iframe",
                url: "index.php?option=com_media&view=images&tmpl=component&e_name=" + d,
                size: {
                    x: 600,
                    y: 415
                }
            })
        })
    });
    if (b.isFunction(window.jInsertEditorText)) window.insertTextOld = window.jInsertEditorText;
    window.jInsertEditorText = function (c, a) {
        if (a.match(/^image-lang-select-/)) {
            var d = b("#" + a),
                e = c.match(/src="([^\"]*)"/)[1];
            d.parent().find("div.image-lang-preview").html(c).find("img").attr("src", f + e);
            d.val(e)
        } else b.isFunction(window.insertTextOld) && window.insertTextOld(c, a)
    }
});