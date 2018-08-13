<?php
/**
 * JBZoo App is universal Joomla CCK, application for YooTheme Zoo component
 *
 * @package     jbzoo
 * @version     2.x Pro
 * @author      JBZoo App http://jbzoo.com
 * @copyright   Copyright (C) JBZoo.com,  All rights reserved.
 * @license     http://jbzoo.com/license-pro.php JBZoo Licence
 * @coder       Denis Smetannikov <denis@jbzoo.com>
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


$this->app->jbdebug->mark('layout::subcategory_columns::start');

$lang_for_pdf = JFactory::getLanguage();
$lang_code_for_pdf = strtolower($lang_for_pdf->getTag());

if ($lang_code_for_pdf == 'ru-ru')
{ 
	$pdf_menu_link = $this->_application->params->get('global.additional.pdf-menu');
	$pdf_drink_menu_link = $this->_application->params->get('global.additional.pdf-drink-menu');
}
else
{
	$pdf_menu_link = $this->_application->params->get('global.additional.pdf-menu-en');
	$pdf_drink_menu_link = $this->_application->params->get('global.additional.pdf-drink-menu-en');
}

if ($vars['count']) {

    $count = $vars['count'];

    echo '<div class="subcategories subcategory-col-' . $vars['cols_num'] . '">';

    $j = 0;
    $t = 0;
	$eo = 1;
    foreach ($vars['objects'] as $object) {

        $first = ($j == 0) ? ' first' : '';
        $last  = ($j == $count - 1) ? ' last' : '';
		$evodd = ($eo == 2) ? ' even' : ' odd';
        
        switch ($t) {
			case ($count - 3):
				$last_last = ' last-line';
				break;
			case ($count - 2):
				$last_last = ' last-line';
				break;
			case ($count - 1):
				$last_last = ' last-line';
				break;
			default:
				$last_last = '';
			break;
		}
        
        $j++;
        $t++;
		$eo++;
		
		if ($eo == 3) {$eo = 1;}

        $isLast = $j % $vars['cols_num'] == 0 && $vars['cols_order'] == 0;

        if ($isLast) {
            $last .= ' last';
        }

        echo '<div class="rborder float-left column width' . intval(100 / $vars['cols_num']) . $evodd . $first . $last . $last_last . '">' . $object
            . '</div>';

        if ($isLast) {
            echo '<div class="clear clr"></div>';
            $j = 0;
        }
    }

    echo '<div class="clear clr"></div>';
    echo '</div>';

}
if (!empty($pdf_menu_link)) {

	echo '<hr class="jbzoo-hr">';
	echo '<a class="pdfmenu-link" target="_blank" href="'.$pdf_menu_link.'">'.JText::_('JBZOO_PDF_MENU').'</a>';
	
	if (!empty($pdf_drink_menu_link)) {
		echo '<a class="pdfmenu-link" target="_blank" href="'.$pdf_drink_menu_link.'">'.JText::_('JBZOO_PDF_DRINK_MENU').'</a>';
	}
	echo '<a class="pdfmenu-link" target="_blank" href="/images/OM_menu_CN.pdf">下载PDF菜单</a>';
}

$this->app->jbdebug->mark('layout::subcategory_columns::finish');
