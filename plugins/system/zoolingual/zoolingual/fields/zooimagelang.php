<?php
/**
* @package		ZOOlingual
* @author    	ZOOlanders http://www.zoolanders.com
* @copyright 	Copyright (C) JOOlanders SL
* @license   	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/


	$ctrl_name = $control_name;
	$control_name .= '['.$name.']';

	// load assets
	$this->app->document->addStylesheet('zoolingual:assets/lang.css');
	$this->app->document->addScript('zoolingual:assets/image_lang.js');

	// init var
	$languages =& JFactory::getLanguage()->getKnownLanguages(JPATH_SITE);

	// default admin lang is discarted 
	$params = JComponentHelper::getParams('com_languages');
	$siteDefault_lang = $params->get('site', '');
	unset($languages[$siteDefault_lang]);
	
	$value = $this->app->data->create((array)$value); // converted to object to avoid falase '1' values
	
	// create list of options
	$html = array();
	foreach ($languages as $lang)
	{
		$lang_name = explode(' ', $lang['name']);

		// init vars
		$params = $parent;
		$width 	= $params->getValue($name.'_width');
		$height = $params->getValue($name.'_height');
	
		// create image select html
		$html[] = '<span class="inputlang"><span class="element-lang '.$lang['tag'].'"></span></span>';
		$html[] = '<input class="image-lang-select" type="text" name="'.$control_name.'['.$lang['tag'].']" value="'.$value->get($lang['tag']).'" />';
		$html[] = '<div class="image-measures">';
		$html[] = JText::_('Width').' <input type="text" name="'.$ctrl_name.'['.$name.'_width]'.'['.$lang['tag'].']" value="'.@$width[$lang['tag']].'" style="width:30px;" />';
		$html[] = JText::_('Height').' <input type="text" name="'.$ctrl_name.'['.$name.'_height]'.'['.$lang['tag'].']" value="'.@$height[$lang['tag']].'" style="width:30px;" />';
		$html[] = '</div>';
	}
	
	echo implode("\n", $html);
	
?>