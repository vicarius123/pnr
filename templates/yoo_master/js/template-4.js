homeP = false;
winH = 0;
newsPage = 2;

(function($){

	$(document).ready(function() {
	
		if ($('.home').length > 0)
		{
			homeP = true;
		}
		
		function langSwitcher() {
			$('.lang-switcher-link').click(function(e) {
				e.preventDefault();
				var link = $(this).attr('href');
				$(this).toggleClass('right');
				setTimeout(
				  function() 
				  { window.location.href = link; }, 500);
			});
		}		
		langSwitcher();		
		function reset() {
			winH = $(window).height();
			var winW = $(window).width();
			if (homeP)
			{
				
				var vidWid = $('#home-vid').width(),
					vidHei = $('#home-vid').height();
				if ((winW >= vidWid - 10)||(winW <= vidWid + 10))
				{
					$('#home-vid').css('width', winW + 'px');
					$('#home-vid').css('height', 'auto');
					vidHei = $('#home-vid').height();
					if (winH > vidHei)
					{
						$('#home-vid').css('width', 'auto');
						$('#home-vid').css('height', '100%');
					}
				}
				else
				{
					$('#home-vid').css('width', 'auto');
					$('#home-vid').css('height', '100%');
				}
			}
		}
		
		function jbSubmissionMakePlaceholder() {
/*
			$('.jbbasket-submission input[type="text"]').each(function(index) {
				var placeholder = $(this).val();
				$(this).val('');
				$(this).attr('placeholder', placeholder);
			});
*/		
	
			$('.jbbasket-submission textarea').each(function(index) {
				var placeholder = $(this).attr('value');
				if (placeholder.length < 14)
				{
					$(this).attr('value', '');
					$(this).attr('placeholder', placeholder);
				}
				
			});
			
			
			$('.jbprice-count-order .minus').click(function(e) {
				e.preventDefault();
				
				var newVal = parseInt($(this).parent().children('.input-quantity').val());
				if (newVal)
				{
					newVal = newVal - 1;
					$(this).parent().children('.input-quantity').val(newVal).change();
				}
				
			});
			$('.jbprice-count-order .plus').click(function(e) {
				e.preventDefault();
				var newVal = parseInt($(this).parent().children('.input-quantity').val()) + 1;
				$(this).parent().children('.input-quantity').val(newVal).change();
			});
		}
		
		function jbSubmissionTranslatePlaceholder() {
			$('input[name="elements[895edd20-a44c-4d46-b5c4-edff2d4e9978][0][value]"]').attr('placeholder', 'Name');
			$('input[name="elements[de283275-7b3c-4fb2-a508-32a5246530b2][0][value]"]').attr('placeholder', 'Phone');
			$('input[name="elements[f5895ad2-6256-4f9c-ab7d-07590691527b][0][value]"]').attr('placeholder', 'Metro station');
			$('input[name="elements[054e91ab-2ece-4deb-980a-52a1f8121402][0][value]"]').attr('placeholder', 'Street');
			$('input[name="elements[124a587b-2f0d-4e2c-a542-de5c3b0bc7c7][0][value]"]').attr('placeholder', 'House');
			$('input[name="elements[6b148f28-a240-4afb-b50f-14d1ce21b9d5][0][value]"]').attr('placeholder', 'KorpusStr');
			$('input[name="elements[e7af878c-726e-42c0-9184-ab18498b7ab2][0][value]"]').attr('placeholder', 'Porch');
			$('input[name="elements[fafaad36-a25c-4d81-9e0f-8611e85c2c26][0][value]"]').attr('placeholder', 'Floor');
			$('input[name="elements[3d88645f-d397-49e4-ba1c-507bddd2e595][0][value]"]').attr('placeholder', 'Apartment');
			$('input[name="elements[63cc1d0d-8baa-4f8c-9384-f3b9840f2282][0][value]"]').attr('placeholder', 'Intercom');
			
			$('textarea[name="elements[30d8f45f-8f08-4559-bc9b-402bee90a9c7][0][value]"]').attr('placeholder', 'Note');
			
			$('label[for="elements[ac8ba47b-f73a-4960-822e-2e9c47964479][option][]0"]').html('Need cutlery');
			$('label[for="elements[ac8ba47b-f73a-4960-822e-2e9c47964479][option][]1"]').html('Need short change');
			
			
		}
		
		function moveBasketRoundCount() {
			$('.mod-jb-zoo-top').appendTo($('.menu-dropdown .item107'));
			$('.mod-jb-zoo-top').appendTo($('.menu-dropdown .item134'));
			var default_menu_link = '/menu/';
			var order_link = $('.jbzoo-basket-wraper .add-to-cart').attr('href');
			if (order_link)
			{
				$('.item107 a.level1, .item114 a.level1').attr('href', order_link);
				$('.item134 a.level1, .item145 a.level1').attr('href', order_link);
			}
			
			else
			{
				$('.item114 a.level1').attr('href', default_menu_link);
				$('.item145 a.level1').attr('href', default_menu_link);
			}
			$('.jsAddToCart').click(function(e) {
				var order_link = $('.jbzoo-basket-wraper .add-to-cart').attr('href');
				if (order_link)
				{
					$('.item107 a.level1').attr('href', order_link);
				}
			});
		}
		
		function allFiledsRequiredTurnOff() {
			if ($('#bfPage1').css('display') == 'none')
			{
				$('.bfPage-bl').css('display', 'none');
			}
		}
		
		function galleryToggler() {
			$('.slider-toggler').click(function() {
				$(this).addClass('active');
				$('.news-gallery-slider').addClass('active');
				$('.wall-toggler').removeClass('active');
				$('.news-gallery-wall').removeClass('active');
			});
			$('.wall-toggler').click(function() {
				$(this).addClass('active');
				$('.news-gallery-wall').addClass('active');
				$('.slider-toggler').removeClass('active');
				$('.news-gallery-slider').removeClass('active');
			});
		}
		
		function ajaxNews() {
			var thisUrl = document.URL;
			if (thisUrl.substring(thisUrl.length-1) == "/")
			{
				thisUrl = thisUrl.substring(0, thisUrl.length-1);
			}
			
			$('#ajax-btn').click( function() {
				var ajaxUrl = thisUrl + '/' + newsPage;
				$.ajax({
					url: ajaxUrl,
					type: 'POST',
					context: document.body,
					cache: false
				}).done(function(data) {
					var startPos = data.indexOf(data),
						newData = data.split('<div class="items '),
						newdata2 = newData[1].split('<div class="pagination"'),
						curHtml = $('#ajax-result').html(),
						newHtml = curHtml + '<div class="items ' + newdata2[0];
					
					$('#ajax-result').html(newHtml);
					console.log(ajaxUrl);
				});
				newsPage = newsPage + 1;
			});
			
		}

// function to add on/off toggler for home video sound		
		function makeOnOffSoundForVideo() {
			$('#toolbar .float-right').append('<div class="video-sound off"></div>');
			
			$('.video-sound').on('click', function() {
				$(this).toggleClass('off');
				if( $("#home-vid").prop('muted') ) {
					$("#home-vid").prop('muted', false);
				}
				else {
					$("#home-vid").prop('muted', true);
				}
			});
			
		}
		
		if ($('.home').length > 0) {
			makeOnOffSoundForVideo();
		}		
		
		if ($('#contacts-map').length > 0)
		{
			var firstMap, secondMap;

			function initFirstMap () {
				firstMap = new ymaps.Map('contacts-map', {
					center: [55.761773,37.635700],
					zoom: 16
				});
				var firstPlacemark = new ymaps.Placemark([55.761915,37.635534], {}, {
					preset: 'islands#circleDotIcon',
					iconColor: '#1faee9'
				});
/*				
				var myPlacemark = new ymaps.Placemark([55.761915,37.635534], {}, {
					iconLayout: 'default#image',
					iconImageHref: '/templates/yoo_master/images/map-pin.png',
					iconImageSize: [30, 46],
					iconImageOffset: [0, 0]
				});
*/				
				firstMap.controls.remove('typeSelector').remove('trafficControl').remove('searchControl');
				firstMap.geoObjects.add(firstPlacemark);
			}
			ymaps.ready(initFirstMap);
		}
		if ($('#contacts2-map').length > 0)
		{
			function initSecondMap () {
				secondMap = new ymaps.Map('contacts2-map', {
					center: [55.747118,37.567075],
					zoom: 15
				});
				var secondPlacemark = new ymaps.Placemark([55.747774,37.566925], {}, {
					preset: 'islands#circleDotIcon',
					iconColor: '#1faee9'
				});
				
				secondMap.controls.remove('typeSelector').remove('trafficControl').remove('searchControl');
				secondMap.geoObjects.add(secondPlacemark);
			}
			ymaps.ready(initSecondMap);
		}
		
		if ($('.bfFormDiv select').length > 0)
		{
		
			$('.bfFormDiv select').change(function () {
				if($(this).val() == 'placeholder')
				{
					$(this).addClass('placeholder');
				}
				else
				{
					$(this).removeClass('placeholder');
				}
			});

			$('.bfFormDiv select').change();

			$(".bfFormDiv select option[value='placeholder']").addClass('placeholder');
			$(".bfFormDiv select option[value='placeholder']").attr('disabled', 'disabled');
		}
		
		if ($('.jbbasket-submission').length > 0)
		{
			jbSubmissionMakePlaceholder();
			if ($('#page').hasClass('en-gb'))
			{ jbSubmissionTranslatePlaceholder(); }
		}
		if ($('.jbzoo-basket-wraper').length > 0)
		{
			moveBasketRoundCount();
		}
		
		if ($('#bfPage2').length > 0)
		{
			allFiledsRequiredTurnOff();
		}
		
		if ($('.gallery-toggler').length > 0)
		{
			galleryToggler();
		}
		
		if ($('#ajax-btn').length > 0)
		{
			ajaxNews();
		}
		
		$('#ff_elem39, #ff_elem98, #ff_elem178, #ff_elem157, input[name="elements[de283275-7b3c-4fb2-a508-32a5246530b2][0][value]"]').inputmask("mask", {"mask": "+7 (999) 999-99-99"});
		
		reset();
		
		$(window).resize(function() 
		{ reset(); });
			
		$(window).bind( 'orientationchange', function(e)
		{ reset(); });

		var config = $('body').data('config') || {};
		$('.menu-sidebar').accordionMenu({ mode:'slide' });
//		$('#menu').dropdownMenu({ mode: 'slide', dropdownSelector: 'div.dropdown'});
		$('a[href="#page"]').smoothScroller({ duration: 500 });
//		$('article[data-permalink]').socialButtons(config);

	

	});

	$.onMediaQuery('(min-width: 960px)', {
		init: function() {
			if (!this.supported) this.matches = true;
		},
		valid: function() {
			$.matchWidth('grid-block', '.grid-block', '.grid-h').match();
			$.matchHeight('main', '#maininner, #sidebar-a, #sidebar-b').match();
			$.matchHeight('top-a', '#top-a .grid-h', '.deepest').match();
			$.matchHeight('top-b', '#top-b .grid-h', '.deepest').match();
			$.matchHeight('bottom-a', '#bottom-a .grid-h', '.deepest').match();
			$.matchHeight('bottom-b', '#bottom-b .grid-h', '.deepest').match();
			$.matchHeight('innertop', '#innertop .grid-h', '.deepest').match();
			$.matchHeight('innerbottom', '#innerbottom .grid-h', '.deepest').match();
		},
		invalid: function() {
			$.matchWidth('grid-block').remove();
			$.matchHeight('main').remove();
			$.matchHeight('top-a').remove();
			$.matchHeight('top-b').remove();
			$.matchHeight('bottom-a').remove();
			$.matchHeight('bottom-b').remove();
			$.matchHeight('innertop').remove();
			$.matchHeight('innerbottom').remove();
		}
	});
	
	$.onMediaQuery('(min-width: 480px)', {
		init: function() {
			if (!this.supported) this.matches = true;
		},
		valid: function() {
//			$.matchHeight('teaser-item-title', '.jbzoo-item .item-title').match();
			$.matchHeight('news-item-img-height', '.jbzoo-item-news.jbzoo-item-teaser').match();
			$.matchHeight('news-item-height', '.jbzoo-app-novosti .items .width33').match();
		},
		invalid: function() {
//			$.matchHeight('teaser-item-title').remove();
			$.matchHeight('news-item-img-height').remove();
			$.matchHeight('news-item-height').remove();
		}
	});

	var pairs = [];

	$.onMediaQuery('(min-width: 480px) and (max-width: 959px)', {
		valid: function() {
			$.matchHeight('sidebars', '.sidebars-2 #sidebar-a, .sidebars-2 #sidebar-b').match();
			pairs = [];
			$.each(['.sidebars-1 #sidebar-a > .grid-box', '.sidebars-1 #sidebar-b > .grid-box', '#top-a .grid-h', '#top-b .grid-h', '#bottom-a .grid-h', '#bottom-b .grid-h', '#innertop .grid-h', '#innerbottom .grid-h'], function(i, selector) {
				for (var i = 0, elms = $(selector), len = parseInt(elms.length / 2); i < len; i++) {
					var id = 'pair-' + pairs.length;
					$.matchHeight(id, [elms.get(i * 2), elms.get(i * 2 + 1)], '.deepest').match();
					pairs.push(id);
				}
			});
		},
		invalid: function() {
			$.matchHeight('sidebars').remove();
			$.each(pairs, function() { $.matchHeight(this).remove(); });
		}
	});
	
	$.onMediaQuery('(min-width: 481px) and (max-width: 1200px)', {
		valid: function() {
			$.matchHeight('teaser-item-title', '.jbzoo-item .item-title').match();
		},
		invalid: function() {
			$.matchHeight('teaser-item-title').remove();
		}
	});	

	$.onMediaQuery('(max-width: 767px)', {
		valid: function() {
			var header = $('#header-responsive');
			if (!header.length) {
				header = $('<div id="header-responsive"/>').prependTo('#header');
				$('#logo').clone().removeAttr('id').addClass('logo').appendTo(header);
				$('.searchbox').first().clone().removeAttr('id').appendTo(header);
				$('.mod-phone').clone().prependTo($('#toolbar .float-right'));
				$('#toolbar').clone().removeAttr('id').addClass('toolbar').appendTo(header);
				$('#menu').responsiveMenu().next().addClass('menu-responsive').appendTo(header);
				if (!$('.home-addr').length > 0)
				{
					$('#search .street-table-cell:first-child span a').text('Звонить в кафе на Чистых');
					$('#search .street-table-cell:last-child span a').text('Звонить в кафе на Киевской');
					$('#search .street-table-cell:first-child span').clone().addClass('home-addr').appendTo('#header .float-right ');
					$('#search .street-table-cell:last-child span').clone().addClass('home-addr').appendTo('#header .float-right ');
					
					
					//$('#search .street a').clone().addClass('home-addr').appendTo('#header .float-right ');
				}
				
			}
		},
		invalid: function() {
//			$('.home-addr').remove();
		}
	});

})(jQuery);