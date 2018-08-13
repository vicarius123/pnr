<?php
/**
* @package		ZOOlingual
* @author    	ZOOlanders http://www.zoolanders.com
* @copyright 	Copyright (C) JOOlanders SL
* @license   	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class LangHelper extends AppHelper {

	/*
		Function: checkLang
			Checks if the element should render based on the current site language.
			The Element language have preference over the position language.
			
		Variables:
			lang_el - element language
			lang_po - element position language
			
		Return :
			false - the element will be rendered
			true - will not
	*/
	public function checkLang($languages = array())
	{
		// if no selection made render the element
		if ( empty($languages) ) { return true; }

		$current_lang = $this->getCurrentLanguage();	

		foreach ($languages as $lang){
			if ($lang == $current_lang) {
				return true;
			}
		}
		
		return null;
	}
	
	/*
		Function: getCurrentLanguage
			retrieves the current language
			
		Return :
			string - the current language in en-GB format
	*/
	public function getCurrentLanguage()
	{
		$current_lang = '';
		if ($this->app->joomla->isVersion('1.5')) {
			$current_lang = JFactory::getLanguage()->_lang;
		} else {
			$current_lang = JFactory::getLanguage()->get('tag');
		}
	
		return $current_lang;
	}
	
	/*
		Function: isCurrentLanguage
			check if some of the passed languages is the current language
			
		Return :
			boolean - true if it is
	*/
	public function isCurrentLanguage($languages = array())
	{
		settype($languages, 'array');
		foreach ($languages as $lang){
			if ($this->getCurrentLanguage() == $lang) {
				return true;
			}
		}
	
		return false;
	}
	
	/*
		Function: checkGroup
			check if any of the group should be render with current lang but has no value
			
		Return :
			boolean - true if it is
	*/
	public static function checkGroup($item, $elements = array())
	{
		settype($elements, 'array');
		foreach ($elements as $element)
		{
			if($item && $element = $item->getElement($element)) {
				$el_languages = $element->config->find('zoolingual._languages', array());
				if ($this->isCurrentLanguage($el_languages) && !$element->hasValue()){
					return true;
				}
			}
		}
	
		return false;
	}
}