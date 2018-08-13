/* Copyright (C) 2007 - 2011 ZOOlanders.com - Inspired by YOOtheme GmbH code */

(function (a) {
    var b = function () {};
    a.extend(b.prototype, {
        name: "ParamElementZoolingual",
        options: {
			msgNoneSelected: 'none',
			msgCheckAllText: 'Check all',
			msgUncheckAllText: 'Uncheck all',
			msgSelectedText: '# of # selected',
			header: true
        },
        initialize: function (b, c) {
            this.options = a.extend({}, this.options, c);
			var d = this,
				op = d.options,
				select = b.find('select.zoolingual'),
				element = select.closest('.element').find('.sort-event');
				
				// edit view
			b.find('.zling-label input').change(function(){
				b.find('.zoolingual-edit').toggle();
			});

			( select.data("initialized-zoolingual") || (select.multiselect({
				header: op.header,
				selectedText: op.msgSelectedText,
				selectedList: 1, // 0-based index
				noneSelectedText: '-- '+op.msgNoneSelected+' --',
				checkAllText: op.msgCheckAllText,
				uncheckAllText: op.msgUncheckAllText,
				height: 108,
				position: {
					my: 'left top',
					at: 'left bottom',
					collision: 'flip'
				},
				click: function(event, ui){
					if (ui.checked){
						element.append('<span class="element-lang '+ui.value+'"></span>');
					} else {
						element.find('span.'+ui.value).remove();
					}
				},
				checkAll: function(event){
					d.checkAll(select, element);
				},
				uncheckAll: function(event){
					element.find('span.element-lang').remove();
				}
			}),
			
			// add lang flags to the Element
			d.checkAll(select, element),
			
			// add lang img on each option
			select.multiselect('widget').find('.ui-multiselect-checkboxes li label input').each(function (){
				a('<span class="element-lang '+a(this).val()+'"></span>').insertAfter(a(this));
			}),
			
			select.data("initialized-zoolingual", !0)) );
		},
		checkAll: function (select, element) {
			element.find('span.element-lang').remove();
			a.makeArray(select.val()).each(function(lang){ // first make sure it's an array
				element.append('<span class="element-lang '+lang+'"></span>');
			})
		}
    });
    a.fn[b.prototype.name] = function () {
        var e = arguments,
            c = e[0] ? e[0] : null;
        return this.each(function () {
            var d = a(this);
            if (b.prototype[c] && d.data(b.prototype.name) && c != "initialize") d.data(b.prototype.name)[c].apply(d.data(b.prototype.name), Array.prototype.slice.call(e, 1));
            else if (!c || a.isPlainObject(c)) {
                var f = new b;
                b.prototype.initialize && f.initialize.apply(f, a.merge([d], e));
                d.data(b.prototype.name, f)
            } else a.error("Method " + c + " does not exist on jQuery." + b.name)
        })
    }
})(jQuery);