<?php
/**
* @package   yoo_master
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// generate css for layout
$css[] = sprintf('.wrapper { max-width: %dpx; }', $this['config']->get('template_width'));

// generate css for 3-column-layout
$sidebar_a       = '';
$sidebar_b       = '';
$maininner_width = 100;
$sidebar_a_width = intval($this['config']->get('sidebar-a_width'));
$sidebar_b_width = intval($this['config']->get('sidebar-b_width'));
$sidebar_classes = "";
$rtl             = $this['config']->get('direction') == 'rtl';
$body_config	 = array();

// set widths
if ($this['modules']->count('sidebar-a')) {
	$sidebar_a = $this['config']->get('sidebar-a'); 
	$maininner_width -= $sidebar_a_width;
	$css[] = sprintf('#sidebar-a { width: %d%%; }', $sidebar_a_width);
}

if ($this['modules']->count('sidebar-b')) {
	$sidebar_b = $this['config']->get('sidebar-b'); 
	$maininner_width -= $sidebar_b_width;
	$css[] = sprintf('#sidebar-b { width: %d%%; }', $sidebar_b_width);
}

$css[] = sprintf('#maininner { width: %d%%; }', $maininner_width);

// all sidebars right
if (($sidebar_a == 'right' || !$sidebar_a) && ($sidebar_b == 'right' || !$sidebar_b)) {
	$sidebar_classes .= ($sidebar_a) ? 'sidebar-a-right ' : '';
	$sidebar_classes .= ($sidebar_b) ? 'sidebar-b-right ' : '';

// all sidebars left
} elseif (($sidebar_a == 'left' || !$sidebar_a) && ($sidebar_b == 'left' || !$sidebar_b)) {
	$sidebar_classes .= ($sidebar_a) ? 'sidebar-a-left ' : '';
	$sidebar_classes .= ($sidebar_b) ? 'sidebar-b-left ' : '';
	$css[] = sprintf('#maininner { float: %s; }', $rtl ? 'left' : 'right');

// sidebar-a left and sidebar-b right
} elseif ($sidebar_a == 'left') {
	$sidebar_classes .= 'sidebar-a-left sidebar-b-right ';
	$css[] = '#maininner, #sidebar-a { position: relative; }';
	$css[] = sprintf('#maininner { %s: %d%%; }', $rtl ? 'right' : 'left', $sidebar_a_width);
	$css[] = sprintf('#sidebar-a { %s: -%d%%; }', $rtl ? 'right' : 'left', $maininner_width);

// sidebar-b left and sidebar-a right
} elseif ($sidebar_b == 'left') {
	$sidebar_classes .= 'sidebar-a-right sidebar-b-left ';
	$css[] = '#maininner, #sidebar-a, #sidebar-b { position: relative; }';
	$css[] = sprintf('#maininner, #sidebar-a { %s: %d%%; }', $rtl ? 'right' : 'left', $sidebar_b_width);
	$css[] = sprintf('#sidebar-b { %s: -%d%%; }', $rtl ? 'right' : 'left', $maininner_width + $sidebar_a_width);
}

// number of sidebars
if ($sidebar_a && $sidebar_b) {
	$sidebar_classes .= 'sidebars-2 ';
} elseif ($sidebar_a || $sidebar_b) {
	$sidebar_classes .= 'sidebars-1 ';
}

// generate css for dropdown menu
foreach (array(1 => '.dropdown', 2 => '.columns2', 3 => '.columns3', 4 => '.columns4') as $i => $class) {
	$css[] = sprintf('#menu %s { width: %dpx; }', $class, $i * intval($this['config']->get('menu_width')));
}

$http  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$browser = strtolower($_SERVER['HTTP_USER_AGENT']);

// load css
if (strpos($browser,'mac os') !== false)
{ $this['asset']->addFile('css', 'css:pfdintextcomppro-light.css'); }
else if ((strpos($browser,'msie') !== false)||(strpos($browser,'rv:11.0') !== false))
{ $this['asset']->addFile('css', $http.'://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&subset=latin,cyrillic'); }
else
{ $this['asset']->addFile('css', 'css:pfdintextcomppro.css'); }
$this['asset']->addFile('css', 'css:base.css');
$this['asset']->addFile('css', 'css:layout.css');
$this['asset']->addFile('css', 'css:menus.css');
$this['asset']->addString('css', implode("\n", $css));
$this['asset']->addFile('css', 'css:modules.css');
$this['asset']->addFile('css', 'css:tools.css');
$this['asset']->addFile('css', 'css:system.css');
$this['asset']->addFile('css', 'css:custom-8.css');
if ((strpos($browser,'msie') !== false)||(strpos($browser,'rv:11.0') !== false))
{ $this['asset']->addFile('css', 'css:ie.css'); }
$this['asset']->addFile('css', 'css:responsive-5.css');
$this['asset']->addFile('css', 'css:print.css');

// set body css classes
$body_classes  = $sidebar_classes.' ';
$body_classes .= $this['system']->isBlog() ? 'isblog ' : 'noblog ';
$body_classes .= $this['config']->get('page_class');

$browser = strtolower($_SERVER['HTTP_USER_AGENT']);

//different browsers and OS
if (strpos($browser,'firefox') !== false) {
	$body_classes .= ' firefox';
}
if (strpos($browser,'msie') !== false) {
	$body_classes .= ' ie';
}
if ((strpos($browser,'safari') !== false)&&(strpos($browser,'chrome') == false)) {
	$body_classes .= ' safari';
}
if (strpos($browser,'webkit') !== false) {
	$body_classes .= ' webkit';
}
if (strpos($browser,'android') !== false) {
	$body_classes .= ' android';
}
if (strpos($browser,'mac os') !== false) {
	$body_classes .= ' mac-os';
}
if ((strpos($browser,'ipad') !== false)||(strpos($browser,'ipod') !== false)||(strpos($browser,'iphone') !== false)) {
	$body_classes .= ' ios';
}

$lang_for_map = JFactory::getLanguage();
$lang_for_map_code = $lang_for_map->getTag();

$body_classes .= ' '.strtolower($lang_for_map_code);


$this['config']->set('body_classes', $body_classes);



$this['config']->set('body_config', json_encode($body_config));

// add javascripts
$this['asset']->addFile('js', 'js:warp.js');
$this['asset']->addFile('js', 'js:responsive.js');
$this['asset']->addFile('js', 'js:accordionmenu.js');
$this['asset']->addFile('js', '//api-maps.yandex.ru/2.1/?lang='.$lang_for_map_code.'" type="text/javascript"');
$this['asset']->addFile('js', 'js:jquery.inputmask.js');
$this['asset']->addFile('js', 'js:template-4.js');

// internet explorer
if ($this['useragent']->browser() == 'msie') {

	// add conditional comments
	$head[] = sprintf('<!--[if lte IE 8]><script src="%s"></script><![endif]-->', $this['path']->url('js:html5.js'));

}

// add $head
if (isset($head)) {
	$this['template']->set('head', implode("\n", $head));
}