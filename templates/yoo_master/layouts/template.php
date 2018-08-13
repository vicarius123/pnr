<?php
	/**
		* @package   yoo_master
		* @author    YOOtheme http://www.yootheme.com
		* @copyright Copyright (C) YOOtheme GmbH
		* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
	*/

	// get template configuration
	include($this['path']->path('layouts:template.config.php'));
	if(!isset($_COOKIE['full'])) {

		$ua = strtolower($_SERVER['HTTP_USER_AGENT']);

		if(stripos($ua,'android') !== false && stripos($ua,'linux') !== false) {
			//header("Location: /mob.php");
		}if(stripos($ua,'iphone') !== false){
			//header("Location: /mob.php");
		}

		if(stripos($ua,'windows') !== false){
			//header("Location: /popup.php");
		}
		if(stripos($ua,'macintosh') !== false){
			//header("Location: /popup.php");
		}
	}
?>
<!DOCTYPE HTML>
<html lang="<?php echo $this['config']->get('language'); ?>" dir="<?php echo $this['config']->get('direction'); ?>">

	<head>
		<meta name="format-detection" content="telephone=yes"/>
		<?php echo $this['template']->render('head'); ?>
		<script>

			(function() {

				var _fbq = window._fbq || (window._fbq = []);

				if (!_fbq.loaded) {

					var fbds = document.createElement('script');

					fbds.async = true;

					fbds.src = '//connect.facebook.net/en_US/fbds.js';

					var s = document.getElementsByTagName('script')[0];

					s.parentNode.insertBefore(fbds, s);

					_fbq.loaded = true;

				}

			})();

			window._fbq = window._fbq || [];

			window._fbq.push(['track', '6027715780496', {'value':'0.00','currency':'RUB'}]);
		</script>
		<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6027715780496&amp;cd[value]=0.00&amp;cd[currency]=RUB&amp;noscript=1" /></noscript>
	</head>

	<body id="page" class="page <?php echo $this['config']->get('body_classes'); ?>">
		<!-- Google Tag Manager -->
		<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KS62XB"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-KS62XB');</script>
		<!-- End Google Tag Manager -->
		<div id="background">
			<?php if ($this['modules']->count('background')) : ?>
			<?php echo $this['modules']->render('background'); ?>
			<?php endif; ?>
		</div>

		<?php if ($this['modules']->count('absolute')) : ?>
		<div id="absolute">
			<?php echo $this['modules']->render('absolute'); ?>
		</div>
		<?php endif; ?>
		<div id="all-top">
			<div class="wrapper clearfix">

				<header id="header">

					<?php if ($this['modules']->count('toolbar-l + toolbar-r') || $this['config']->get('date')) : ?>
				<div id="toolbar" class="clearfix">

				<?php if ($this['modules']->count('toolbar-l') || $this['config']->get('date')) : ?>
				<div class="float-left">

				<?php if ($this['config']->get('date')) : ?>
				<time datetime="<?php echo $this['config']->get('datetime'); ?>"><?php echo $this['config']->get('actual_date'); ?></time>
				<?php endif; ?>

				<?php echo $this['modules']->render('toolbar-l'); ?>

				</div>
				<?php endif; ?>

				<?php if ($this['modules']->count('toolbar-r')) : ?>
				<div class="float-right"><?php echo $this['modules']->render('toolbar-r'); ?></div>
				<?php endif; ?>

				</div>
				<?php endif; ?>

				<?php if ($this['modules']->count('headerbar')) : ?>
				<div id="headerbar" class="clearfix">
				<?php echo $this['modules']->render('headerbar'); ?>
				</div>
				<?php endif; ?>

				<?php if ($this['modules']->count('logo + menu + search')) : ?>
				<div id="menubar" class="clearfix">
				<?php if ($this['modules']->count('logo')) : ?>
				<a id="logo" href="<?php echo $this['config']->get('site_url'); ?>"><?php echo $this['modules']->render('logo'); ?></a>
				<?php endif; ?>

				<?php if ($this['modules']->count('search')) : ?>
				<div id="search"><?php echo $this['modules']->render('search'); ?></div>
				<?php endif; ?>

				<?php if ($this['modules']->count('menu')) : ?>
				<nav id="menu"><?php echo $this['modules']->render('menu'); ?></nav>
				<?php endif; ?>

				</div>
				<?php endif; ?>

				</header>

				<?php if ($this['modules']->count('banner')) : ?>

				<div id="banner">
				<div id="banner-arrow">
				</div>
				<div id="banner-inside">
				<?php echo $this['modules']->render('banner'); ?>
				</div>
				</div>

				<?php endif; ?>

				<?php if ($this['modules']->count('top-a')) : ?>
				<section id="top-a" class="grid-block"><?php echo $this['modules']->render('top-a', array('layout'=>$this['config']->get('top-a'))); ?></section>
				<?php endif; ?>

				<?php if ($this['modules']->count('top-b')) : ?>
				<section id="top-b" class="grid-block"><?php echo $this['modules']->render('top-b', array('layout'=>$this['config']->get('top-b'))); ?></section>
				<?php endif; ?>

				<?php if ($this['modules']->count('innertop + innerbottom + sidebar-a + sidebar-b') || $this['config']->get('system_output')) : ?>
				<div id="main" class="grid-block">

				<div id="maininner" class="grid-box">

				<?php if ($this['modules']->count('innertop')) : ?>
				<section id="innertop" class="grid-block"><?php echo $this['modules']->render('innertop', array('layout'=>$this['config']->get('innertop'))); ?></section>
				<?php endif; ?>

				<?php if ($this['modules']->count('breadcrumbs')) : ?>
				<section id="breadcrumbs"><?php echo $this['modules']->render('breadcrumbs'); ?></section>
				<?php endif; ?>

				<?php if ($this['config']->get('system_output')) : ?>
				<section id="content" class="grid-block"><?php echo $this['template']->render('content'); ?></section>
				<?php endif; ?>

				<?php if ($this['modules']->count('innerbottom')) : ?>
				<section id="innerbottom" class="grid-block"><?php echo $this['modules']->render('innerbottom', array('layout'=>$this['config']->get('innerbottom'))); ?></section>
				<?php endif; ?>

				</div>
				<!-- maininner end -->

				<?php if ($this['modules']->count('sidebar-a')) : ?>
				<aside id="sidebar-a" class="grid-box"><?php echo $this['modules']->render('sidebar-a', array('layout'=>'stack')); ?></aside>
				<?php endif; ?>

				<?php if ($this['modules']->count('sidebar-b')) : ?>
				<aside id="sidebar-b" class="grid-box"><?php echo $this['modules']->render('sidebar-b', array('layout'=>'stack')); ?></aside>
				<?php endif; ?>

				</div>
				<?php endif; ?>
				<!-- main end -->

				<?php if ($this['modules']->count('bottom-a')) : ?>
				<section id="bottom-a" class="grid-block"><?php echo $this['modules']->render('bottom-a', array('layout'=>$this['config']->get('bottom-a'))); ?></section>
				<?php endif; ?>

				<?php if ($this['modules']->count('bottom-b')) : ?>
				<section id="bottom-b" class="grid-block"><?php echo $this['modules']->render('bottom-b', array('layout'=>$this['config']->get('bottom-b'))); ?></section>
				<?php endif; ?>

				</div>
				</div>
				<?php if ($this['modules']->count('footer + debug') || $this['config']->get('warp_branding') || $this['config']->get('totop_scroller')) : ?>
				<footer id="footer">
				<div class="wrapper clearfix">
				<?php
				echo $this['modules']->render('footer', array('layout'=>'foot'));
				echo $this['modules']->render('debug');
				?>
				</div>
				</footer>
				<?php endif; ?>

				<?php echo $this->render('footer'); ?>
				<script>

				var new_url = window.location.pathname;
				var m_width = jQuery(document).width();
				if( (m_width <='900') && ( (new_url == '/rus/') || new_url == '/eng/')){
				console.log(new_url);
				window.location.replace("https://cafeodessa.ru/rus/menu");

				}

				</script>

				<noscript><div><img src="https://mc.yandex.ru/watch/31550113" style="position:absolute; left:-9999px;" alt="" /></div></noscript>


				<!-- Smartomato Widget -->

				<script>
				(function($) {
				$(function() {
				$('a.jsAddToCart').each(function(i,v) {
				$(v).after(v.outerHTML);
				$(v).closest('.jbprice-buttons').siblings('.jbprice-count').remove();
				$(v).remove();
				})
				})
				})(jQuery);
				</script>

				<!-- Smartomato Widget -->
				</body>
				</html>
