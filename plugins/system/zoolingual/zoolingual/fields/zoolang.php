<?php
/**
* @package		ZOOlingual
* @author    	ZOOlanders http://www.zoolanders.com
* @copyright 	Copyright (C) JOOlanders SL
* @license   	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

	$element = $parent->element;
	$config  = $element->config;
	$params  = $this->app->parameterform->convertParams($parent);
	$isCore  = $element->getGroup() == 'Core';
	$isAssignment = JRequest::getVar('task', '') == 'assignelements' || JRequest::getVar('task', '') == 'assignsubmission';
	
	// values
	$lang_value = $config->find($name . '._languages', array());
	$overide = $params->find($name . '._overided', 0);
	
	// overide values if is the case
	if ($isAssignment && ($overide || $isCore)){
		$lang_value = $params->find($name . '._languages', array());
	}
	
	$this->app->document->addStylesheet('zoolingual:assets/lang.css');
	$this->app->document->addScript('zoolingual:assets/select/jquery.multiselect.min.js');
	$this->app->document->addScript('zoolingual:assets/select/fields.zoolingual.js');

	// init var
	$html = array();
	$tip = '';
	$languages = JFactory::getLanguage()->getKnownLanguages(JPATH_SITE);
	$tipClass = ($config->find($name . '._languages', 0) ? ' hasTip': '');
	
	// create fields
	$field_id = str_replace(array('[', ']'), '', $control_name).'_zoolingual';
	$html[] = '<div id="'.$field_id.'" class="zl-field">';
	
		// Tip if inherited
		if($inh_lang = $config->find($name . '._languages', 0)){
			$listLang = array();
			foreach($inh_lang as $lang){
				$lang =& JFactory::getLanguage()->getMetadata($lang);
				$lang_name = explode(' ', $lang['name']);
				$listLang[] = $lang_name[0];
			}
			$listLang = implode("<br/>", $listLang);
			$tip = JText::_('Languages Inherited').'::'.$listLang;
		}

		if ($isAssignment && !$isCore){
			// checkbox overide
			$id = "{$control_name}[{$name}][_overided]";
			$html[] = '<div class="row cat zling-label">';
				$html[] = '<span title="'.$tip.'" class="lang-msg '.$tipClass.'" >'.($config->find($name . '._languages', 0) ? JText::sprintf('%s Languages inherited', count($config->find($name . '._languages'))) : JText::_('No Languages inherited')).'</span>'
						. '<input type="checkbox" id="' .$id .'" name="' .$id .'" ' . ($params->find($name . '._overided', false) ? 'checked="checked"' : '') . ' />'
						. '<label for="'.$id.'">' . JText::_('Overide Options') . '</label>';
			$html[] = '</div>';
		}
		
		// if levels not defined AND no overides, hide options
		// using class row brakes the lang UI
		$html[] = '<div class="zoolingual-edit" '. (!$overide && !$isCore && $isAssignment ? 'style="display: none;"' : '') .'>';
	
			// create select
			$options = array();
			foreach ($languages as $lang) {
				$lang_name = explode(' ', $lang['name']);
				$options[] = JHTML::_('select.option', $lang['tag'], $lang_name[0]);
			}

			$attributes = 'class="zoolingual" multiple=multiple" size="5" style="width: 200px"';
			$html[] = JHTML::_('select.genericlist', $options,  "{$control_name}[{$name}][_languages][]", $attributes, 'value', 'text', $lang_value);
			
		$html[] = '</div>';
	
	$html[] = '</div>';
	
	// js
	$javascript = "jQuery('#$field_id').ParamElementZoolingual({ msgNoneSelected: '".JText::_('PLG_ZOOLINGUAL_ZL_NONE')."', msgCheckAllText: '".JText::_('PLG_ZOOLINGUAL_CHECK_ALL')."', msgUncheckAllText: '".JText::_('PLG_ZOOLINGUAL_UNCHECK_ALL')."', msgSelectedText: '". JText::_('PLG_ZOOLINGUAL_MSG_SELECTED') ."', header: true });";
	$html[] = "<script type=\"text/javascript\">\n// <!--\n$javascript\n// -->\n</script>\n";
	
	echo implode("\n", $html);

?>