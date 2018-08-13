<?php
/**
* @package		ZOOlingual
* @author    	ZOOlanders http://www.zoolanders.com
* @copyright 	Copyright (C) JOOlanders SL
* @license   	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

	$control_name .= '['.$name.']';
	
	$this->app->document->addStylesheet('zoolingual:assets/lang.css');

	// init var
	$languages =& JFactory::getLanguage()->getKnownLanguages(JPATH_SITE);
	
	// default admin lang is discarted 
	$params = JComponentHelper::getParams('com_languages');
	$siteDefault_lang = $params->get('site', '');
	unset($languages[$siteDefault_lang]);
	
	$value = $this->app->data->create((array)$value); // converted to object to avoid falase '1' values
	
	// create list of options
	$html = array();
	if (count($languages)) foreach ($languages as $lang) {
		$lang_name = explode(' ', $lang['name']);
		$line = '<span class="inputlang"><textarea name="'.$control_name.'['.$lang['tag'].']">'.$value->get($lang['tag']).'</textarea>';
		$line .= '<span class="element-lang '.$lang['tag'].'"></span></span>';
		$html[] = $line;
	}
	else 
	{
		echo JText::_('PLG_ZOOLINGUAL_NO_EXTRA_LANGUAGES');
	}
	
	echo implode( "<br />", $html);
?>