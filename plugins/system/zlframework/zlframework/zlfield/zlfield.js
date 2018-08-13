/* ===================================================
 * ZLfield
 * https://zoolanders.com/extensions/zlframework
 * ===================================================
 * Copyright (C) JOOlanders SL 
 * http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 * ========================================================== */
(function ($) {
	var Plugin = function(){};
	Plugin.prototype = $.extend(Plugin.prototype, {
		name: 'ZLfield',
		options: {
			url: '',
			type: '',
			enviroment: ''
		},
		initialize: function(body, options) {
			this.options = $.extend({}, this.options, options);
			var $this = this;

			// on save/apply no initialized inputs are removed
			$('#toolbar-apply, #toolbar-save').click(function(){
				$('.zlfield input').each(function(){
					$(this).val() || $(this).remove();
				});
				return true;
			});

			$(document).ready(function()
			{
				// set element actions when added to a type
				$('.col-left ul.element-list').on('element.added', function(event, element){ 
					// set action
					$this.actions($(element));
				});

				// set element actions on sorting or added to a position
				$('ul.ui-sortable').on('sortstop', function(event, ui)
				{
					// Placeholders - Control name must be updated dinamically on each reorder or assignment
					var b = RegExp(/(elements\[[a-z0-9_-]+\])|(positions\[[a-z0-9_-]+\]\[[0-9]+\])/);
					$("#assign-elements ul.element-list:not(.unassigned)").each(function () {
						var c = "positions[" + $(this).data("position") + "]";
						$(this).children().each(function (d) {
							$(this).find("[data-control^=positions], [data-control^=elements]").each(function () {
								$(this).attr("data-control", "tmp" + $(this).attr("data-control").replace(b, c + "[" + d + "]"))
							})
						})
					});
					b = RegExp(/^tmp/);
					$("#assign-elements ul.element-list").find("[data-control^=tmp]").each(function () {
						$(this).attr("data-control", $(this).attr("data-control").replace(b, ""))
					}); // Placeholders END
	
					// set action
					$this.actions(ui.item);
				});

				// init actions
				$this.initActions();
			});
		},

		/* 
		 * initModules - init ZL Field on Modules
		 */
		initActions: function() {
			var $this = this,
				env = $this.options.enviroment;

			// init on Position view
			(env == 'type-positions' || env == 'type-edit') && 
			$('.col-left ul.ui-sortable > li.element').each(function(){
				$(this).parent().trigger('sortstop', { item: $(this) });
			});

			// init Core Elements on Edit view
			(env == 'type-edit') &&
			$('.col-left .core-element-configuration .element-list > li.element').each(function(){
				$this.actions($(this));
			});

			// init on Item Edit view
			env == 'item-edit' && $('.item-edit .creation-form .zlfield-main').each(function(){
				$this.actions($(this));
			});

			// init on Module view
			env == 'module' && $('form#module-form ul.adminformlist .zlfield-main').each(function(){
				// add Class for specific styling
				$(this).parent('li').addClass('zlfield-module');

				// call actions
				$this.actions($(this));
			})

			// init on App Config view
			env == 'app-config' && $('.col-right .zlfield-main').each(function(){
				// call actions
				$this.actions($(this));
			})
		},

		/* 
		 * Actions - set ZL Field actions
		 */
		actions: function($dom) {
			var $this = this;

			// only once or when insisted
			if (!$dom.data('zlfield-actions-init'))
			{
				/* 
				 * Fields Help Tips
				 */
				$dom.find('.qTipHelp').each(function(){
					var $qtip = $(this);
					$qtip.qtip({
						overwrite: false,
						content: {
							text: $qtip.find('.qtip-content')
						},
						position: {
							my: 'bottom center',
							at: 'top center',
							viewport: $(window)
						},
						show: {
							solo: true,
							delay: 300
						},
						hide: {
							fixed: true,
							delay: 300
						},
						style: 'ui-tooltip-light ui-tooltip-zlparam'
					});
				}); // Fields Help Tips END


				/* 
				 * Fields Select Expand
				 */
				$dom.find('.zl-select-expand').each(function(){
					var $expand = $(this);
					$expand.click(function(){
						$(this).prev().height(150);
						$(this).remove();
					}).qtip({
						overwrite: false,
						content: {
							text: $expand.data('zl-qtip')
						},
						position: {
							at: 'right top',
							my: 'left bottom'
						},
						show: {
							solo: true,
							delay: 600
						},
						hide: {
							delay: 0
						},
						style: 'ui-tooltip-light ui-tooltip-zlparam'
					});
				}); // Fields Select Expand END


				/* 
				 * Password Field
				 */
				$('#toolbar-apply, #toolbar-save').on('mousedown', function(){
					$dom.find('.row[data-type=password] .zl-field input').each(function(){
						$(this).val('zl-decrypted['+$(this).val()+']');
					});
				})


				/* 
				 * Override Field
				 */
				$dom.find('.zl-state').each(function(){
					var $checkbox = $(this).find('input'),
						$row = $checkbox.closest('.row');

					$checkbox.bind('change', function(){
						var checkd = $(this).attr('checked') == 'checked'; // it is checked?

						if (checkd){
							$row.removeClass('zl-disabled')
							$row.find('.zl-field').children().removeAttr('disabled');
						} else {
							$row.addClass('zl-disabled')
							$row.find('.zl-field').children().attr('disabled', true);
						}
					});
				}); // Override Field END


				/* 
				 * Override Field Tooltip
				 */
				$dom.find('.zl-state input').each(function(){
					var $checkbox = $(this);
					$checkbox.qtip({
						content: {
							text: 'Override this field' // default text
						},
						position: {
							at: 'left top',
							my: 'right bottom',
							effect: false
						},
						show: {
							target: $checkbox.closest('.row'),
							solo: true,
							delay: 200
						},
						hide: {
							target: $checkbox.closest('.row'),
							delay: 0
						},
						style: 'ui-tooltip-light ui-tooltip-zlparam',
						events: {
							show: function(event, api) {
								($checkbox.attr('checked') == 'checked') && event.preventDefault(); // Stop it!

								// hide if checkbox checked
								$checkbox.bind('change', function(){
									api.hide();
								});

								// Update the content of the tooltip on each show
								api.set('content.text', $checkbox.parent().attr('tooltip'));
							}
						}
					});
				}); // Override Field Tooltip END


				/* 
				 * Toggle Fields
				 */
				$dom.find('.zltoggle-btn').each(function(){
					var toggle = $(this),
						content = toggle.next();
					// set action
					toggle.find('.tg-open').bind('click', function(){
						toggle.toggleClass('open') && content.show();
					});
					toggle.find('.tg-close').bind('click', function(){
						toggle.toggleClass('open') && content.hide();
					});
				}); // Toggle Fields END


				/* 
				 * Dependents - Fields are shown/hidden depending on other fields values
				 */
				$dom.find('[data-dependents]').each(function(){
					var a = $(this),
						b = a.data("dependents").replace(/ /g, '').split('|'), // remove empty spaces and split into rules
						ph = a.closest('.zlfield.placeholder .wrapper, .zlfield.placeholder').first();

					b.each(function(val) // for each rule
					{
						var c = val.split('!>'),
							m = c.length == 2 ? '!>' : '>'; // mode
							c = m == '>' ? val.split('>') : c, // second split if necesary
							d = c[0].split(','), // dependents array
							e = c[1].replace('NONE', ''); // dependent option

						// if select
						(a.data("type") == 'select' || a.data("type") == 'itemLayoutList' || a.data("type") == 'layout' || a.data("type") == 'apps' || a.data("type") == 'types' || a.data("type") == 'elements' || a.data("type") == 'modulelist' || a.data("type") == 'separatedby') 
						&& d.each(function(val) // for each dependent of the option
						{
							var dep = ph.find('[data-id="'+val+'"]').data('e', e).data('m', m).hide();

							a.find('.zl-field select').bind('change', function(){
								var e = dep.data('e'), // dependent value
									m = dep.data('m'), // dependent mode
									selection = $.makeArray($(this).val()), // for multiselect compatibility
									match = 0; // by default no match

								if (e && e.match(/OR/g)){
									$.each(selection, function(index, value){ // for each selected value
										var re = new RegExp(value, 'g');
										( (m == '!>' && !e.match(re)) || (m == '>' && e.match(re)) ) && (match = 1);
										// check mode and Select value, mark any match
									})
								} else if (e && e.match(/AND/g)){
									$.each(selection, function(index, value){ // for each selected value
										( (m == '!>' && value != e) || (m == '>' && value == e) ) && (match = 1);
										// check mode and Select value, mark any match
									})
								} else {
									$.each(selection, function(index, value){ // for each selected value
										( (m == '!>' && value != e) || (m == '>' && value == e) ) && (match = 1);
										// check mode and Select value, mark any match
									})
								}
								
								// if match Show, otherwise Hide
								match && dep.slideDown('fast') || dep.slideUp('fast');
							}).trigger('change');
						});
						
						// if checkbox
						(a.data("type") == 'checkbox') && d.each(function(val)
						{
							var dep = ph.find('[data-id="'+val+'"]').hide();
							a.find('.zl-field input').bind('change', function(){
								var checkd = $(this).attr('checked') == 'checked'; // it is checked?
								
								( (m == '!>' && !checkd) || (m == '>' && checkd) ) && dep.slideDown('fast') || dep.slideUp('fast');
								// check mode and Checkbox state, then slide Up or Down
							}).trigger('change');
						});

						// if radio
						(a.data("type") == 'radio') && d.each(function(val)
						{
							var option = e, // it must be declared local to avoid some weard issue that changes true string values to 1 number value
								dep = ph.find('[data-id="'+val+'"]').hide();
							a.find('.zl-field input').bind('change', function()
							{
								var checkd = $(this).attr('checked') == 'checked', // it is checked?
									match = 0, // by default no match
									value = $(this).attr('value');

								if(checkd) // proceed only if it's the checked input
								{
									if (option && option.match(/OR/g)){
										var re = new RegExp(value, 'g');
										( (m == '!>' && !option.match(re)) || (m == '>' && option.match(re)) ) && (match = 1);
										// check mode, value and check state for multiple values, mark any match
									}
									else
									{
										( (m == '!>' && value != option && checkd) || (m == '>' && value == option && checkd) && checkd) && (match = 1);
										// check mode, value and check state, mark any match
									}

									// if match Show, otherwise Hide
									match && dep.slideDown('fast') || dep.slideUp('fast');
								}

							}).trigger('change');
						});
						
						// if text
						(a.data("type") == 'text') && d.each(function(val)
						{
							var dep = ph.find('[data-id="'+val+'"]').hide();
							a.find('.zl-field input').on('keyup change', function(){
								var filled = $(this).val() != ''; // has text?
								
								( (m == '!>' && !filled) || (m == '>' && filled) ) && dep.slideDown('fast') || dep.slideUp('fast');
								// check mode and Input state, then slide Up or Down
							}).trigger('change');
						});
					});
				}); // Dependents END


				/* 
				 * Relies On - Fields are loaded depending on other fields values
				 */
				$dom.find('[data-relieson]').each(function(){
					var placeholder = $(this), // placeholder
						b = placeholder.data('relieson'),
						c = placeholder.parents('.placeholder').find('[data-id="'+b.id+'"]'), // find the parent field
						select = c.find('select');
						
					// on select change
					select.on('change', function()
					{
						var val  = $(this).val() ? $(this).val() : '',
							ac   = $(this).closest('.zl-field'), // activity holder
							json = b.json, // convert json string to object
							ctrl  = placeholder.attr('data-control'), // field ctrl
							args = $(this).closest('.zlfield-main').attr('data-ajaxargs'),
							psv  = b.psv, // parents values
							pid  = b.id;

						// add current value to parents array
						psv[b.id] = val;

						// peform ajax request
						ac.append($('<span class="activity zl-loader">'));
						$.getJSON(b.url, {task: 'loadfield', json:json, ctrl:ctrl, psv:psv, pid:pid, node:null, args:args, ajaxcall:true, enviroment:$this.options.enviroment}, function(data){
							ac.find('.activity').remove();

							// set data
							placeholder.slideUp('fast', function()
							{
								// remove old html
								placeholder.empty(); 

								// set new html if any
								data && data.result && placeholder.html('<div class="loaded-fields">'+data.result+'</div>');
								
								// init ZL Field Actions on the new fields
								$this.actions(placeholder.find('> .loaded-fields'));

								// show the new content
								placeholder.slideDown('fast');

								// trigger custom event for noticing the field was loaded
								select.trigger('loaded.zlfield');
							});
						})
					});
				}); // Relies On END


				/* 
				 * Load Field
				 */
				$dom.find('.load-field-btn').on('click', function(event){
					event.preventDefault();

					var $button = $(this),
						$wrapper = $button.parent('.zlfield-main'),
						$zlfield = $wrapper.data('ajaxargs');

					// add loading indicator
					$button.find('span').addClass('zlux-loader-raw');

					$.ajax({
						url : $this.options.url,
						type : 'POST',
						data: {
							task: 'loadZLfield',
							group: $zlfield.group,
							type: $this.options.type,
							control_name: $zlfield.control_name,
							json_path: $zlfield.json_path,
							element_id: $zlfield.element_id,
							element_type: $zlfield.element_type,
							enviroment: $zlfield.enviroment,
							node: $zlfield.node
						},
						success : function(data) {
							data = $.parseJSON(data);

							$wrapper.fadeOut('fast', function(){
								// set results
								$(this).html(data.result);

								// apply ZL Field Actions
								$this.actions($wrapper);

								// show the new content
								$wrapper.fadeIn('slow');
							});
						}
					});
				}); // Load Field

			$dom.data('zlfield-actions-init', !0)}
		}
	});
	// Don't touch
	$.fn[Plugin.prototype.name] = function() {
		var args   = arguments;
		var method = args[0] ? args[0] : null;
		return this.each(function() {
			var element = $(this);
			if (Plugin.prototype[method] && element.data(Plugin.prototype.name) && method != 'initialize') {
				element.data(Plugin.prototype.name)[method].apply(element.data(Plugin.prototype.name), Array.prototype.slice.call(args, 1));
			} else if (!method || $.isPlainObject(method)) {
				var plugin = new Plugin();
				if (Plugin.prototype['initialize']) {
					plugin.initialize.apply(plugin, $.merge([element], args));
				}
				element.data(Plugin.prototype.name, plugin);
			} else {
				$.error('Method ' +  method + ' does not exist on jQuery.' + Plugin.name);
			}
		});
	};
})(jQuery);