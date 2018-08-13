<?php
/**
* @package		ZOOlingual
* @author    	ZOOlanders http://www.zoolanders.com
* @copyright 	Copyright (C) JOOlanders SL
* @license   	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class plgSystemZoolingual extends JPlugin
{
	public $joomla;
	public $app;
	
	/**
	 * onAfterInitialise handler
	 *
	 * Adds ZOO event listeners
	 *
	 * @access	public
	 * @return null
	 */
	function onAfterInitialise()
	{
		// Get Joomla instances
		$this->joomla = JFactory::getApplication();
		$jlang = JFactory::getLanguage();
		
		// load default and current language
		$jlang->load('plg_system_zoolingual', JPATH_ADMINISTRATOR, 'en-GB', true);
		$jlang->load('plg_system_zoolingual', JPATH_ADMINISTRATOR, null, true);

		// check dependences
		if (!defined('ZLFW_DEPENDENCIES_CHECK_OK')){
			$this->checkDependencies();
			return; // abort
		}

		// Get the ZOO App instance
		$this->app = App::getInstance('zoo');
		
		// register plugin path
		if ( $path = $this->app->path->path( 'root:plugins/system/zoolingual/zoolingual' ) ) {
			$this->app->path->register($path, 'zoolingual');
		}
		
		// register helper
		if ( $path = $this->app->path->path( 'zoolingual:helpers/' ) ) {
			$this->app->path->register($path, 'helpers');
			$this->app->loader->register('LangHelper', 'helpers:lang.php');
			
			// overide AliasHelper for Alias purposes
			$this->app->loader->register('AliasHelper', 'helpers:alias.php');
		}
		
		// register fields
		if ( $path = $this->app->path->path( 'zoolingual:fields/' ) ) {
			$this->app->path->register($path, 'fields');
		}
		
		// Register Events
		$this->app->event->dispatcher->connect('element:beforedisplay', array($this, 'beforeElementDisplay'));
		$this->app->event->dispatcher->connect('element:beforesubmissiondisplay', array($this, 'beforeElementDisplay'));
		
		$this->app->event->dispatcher->connect('element:afteredit', array($this, 'afterEdit'));
		$this->app->event->dispatcher->connect('element:configparams', array($this, 'addElementConfig'));
		$this->app->event->dispatcher->connect('element:configform', array($this, 'configForm'));
		if(!strstr(JRequest::getVar('controller'), 'submission')) // only if not submission
			$this->app->event->dispatcher->connect('application:init', array($this, 'appXml'));
		$this->app->event->dispatcher->connect('category:init', array($this, 'categoryInit'));
		$this->app->event->dispatcher->connect('item:init', array($this, 'itemInit'));
		$this->app->event->dispatcher->connect('submission:init', array($this, 'submissionInit'));
	}
	
	/**
	 * Change the element name when displayed for editing
	 */
	public function afterEdit($event)
	{
		$element = $event->getSubject();

		if ($languages = $element->config->find('zoolingual._languages', 0)) {
			$this->app->document->addStylesheet('zoolingual:assets/lang.css');

			$lang_html = '';
			foreach ($languages as $lang) {
				$lang_html .= '<br /><span class="element-lang '.$lang.'"></span>';
			}
			
			$html = $event['html'];
			$html[1] = '<strong'.$event['description'].'>'.$event['name'].$lang_html.'</strong>';
			
			// set the $vent after modifying the html
			$event['html'] = $html;
		}
	}
	
	/**
	 * Check the language before displaying the element
	 */
	public function beforeElementDisplay($event)
	{
		$item 	 = $event->getSubject();
		$element = $event['element'];
		$config  = $element->config;
		$params	 = $this->app->data->create($event['params']);
		$isCore  = $element->getGroup() == 'Core';

/* 		if ($this->app->lang->checkGroup($item, $config->get('group_elms', ''))){
			// any of the group should be render with current lang but has no value?
			$event['render'] = true; // then render our default element
		} else {
		 */
			// values
			$languages = $config->find('zoolingual._languages', array());
			$overide = $params->find('zoolingual._overided', 0);
			
			// overide values if is the case
			if ($overide || $isCore){
				$languages = $params->find('zoolingual._languages', array());
			}

			// avoid rendering if result is false
			if(!$this->app->lang->checkLang($languages)){
				$event['render'] = false;
			}
		
		//}
	}
	
	/**
	 * Add language parameter to the form
	 */
	public function configForm( $event, $arguments = array( ) )
	{
		$config = $event['form'];
		
		// add XML params path
		$config->addElementPath($this->app->path->path('zoolingual:fields'));
	}
	
	/**
	 * Add Application Parameters on the fly
	 */
	public function appXml( $event, $arguments = array( ) )
	{
		// init vars
		$app = $event->getSubject();

		// Call the helper method
		$file = $this->app->path->path('zoolingual:application.xml');
		
		$this->app->xmlparams->addApplicationParams( $app, $file );
		$params = $app->getParams();
		
		// Current Language
		$lang = $this->app->lang->getCurrentLanguage();
	
		// only on site
		if(JFactory::getApplication()->isSite()){
		
			// Name Translation
			$name_translations = $params->get('content.title_translation', array());
			if( count( $name_translations ) )
			{
				if( array_key_exists($lang, $name_translations))
				{
					if( strlen($name_translations[$lang]) )
					{
						$params->set('content.title', $name_translations[$lang]);
					}
				}
			}
			
			// Subtitle Translation
			$sub_translations = $params->get('content.subtitle_translation', array());
			if( count( $sub_translations ) )
			{
				if( array_key_exists($lang, $sub_translations))
				{
					if( strlen($sub_translations[$lang]) )
					{
						$params->set('content.subtitle', $sub_translations[$lang]);
					}
				}
			}
			
			// Description Translation
			$desc_translations = $params->get('content.desc_translation', array());
			if( count( $desc_translations ) )
			{
				if( array_key_exists($lang, $desc_translations))
				{
					if( strlen($desc_translations[$lang]) )
					{
						$app->description = $desc_translations[$lang];
					}
				}
			}
			
			// Image Translation
			$image_translations = $params->get('content.image_translation', array());
			if( count( $image_translations ) )
			{
				if( array_key_exists($lang, $image_translations))
				{
					if( strlen($image_translations[$lang]) )
					{
						$params->set('content.image', $image_translations[$lang]);
					}
				}
			}
			
			// Image width Translation
			$image_width_translations = $params->get('content.image_translation_width', array());
			if( count( $image_width_translations ) )
			{
				if( array_key_exists($lang, $image_width_translations))
				{
					if( strlen($image_width_translations[$lang]) )
					{
						$params->set('content.image_width', $image_width_translations[$lang]);
					}
				}
			}

			// Image height Translation
			$image_height_translations = $params->get('content.image_translation_height', array());
			if( count( $image_height_translations ) )
			{
				if( array_key_exists($lang, $image_height_translations))
				{
					if( strlen($image_height_translations[$lang]) )
					{
						$params->set('content.image_height', $image_height_translations[$lang]);
					}
				}
			}
			
			// Items Titles Translation
			$items_title_translation = (array)$params->get('content.items_title_translation', array());
			if( count( $items_title_translation ) )
			{
				if( array_key_exists($lang, $items_title_translation))
				{
					if( strlen($items_title_translation[$lang]) )
					{
						$params->set('content.items_title', $items_title_translation[$lang]);
					}
				}
			}
			
			// Categories Titles Translation
			$categories_title_translation = (array)$params->get('content.categories_title_translation', array());
			if( count( $categories_title_translation ) )
			{
				if( array_key_exists($lang, $categories_title_translation))
				{
					if( strlen($categories_title_translation[$lang]) )
					{
						$params->set('content.categories_title', $categories_title_translation[$lang]);
					}
				}
			}
			
			// Application name translation
			$name_translations = $params->get('config.name_translation', array());
			if( count( $name_translations ) )
			{
				if( array_key_exists($lang, $name_translations))
				{
					if( strlen($name_translations[$lang]) )
					{
						$app->name = $name_translations[$lang];
					}
				}
			}
			
			// Application slug translation
			$alias_translations = $params->get('config.alias_translation', array());
			if( count( $alias_translations ) )
			{
				if( array_key_exists($lang, $alias_translations))
				{
					if( strlen($alias_translations[$lang]) )
					{
						$app->alias = $alias_translations[$lang];
					}
				}
			}
		}
	}
	
	/**
	 * Check the language before displaying the category, and translate it if necessary
	 */
	public function categoryInit($event, $arguments = array())
	{
		// Only on site side
		if( $this->joomla->isSite() )
		{
			$category = $event->getSubject();
			
			// Parameters
			$params = $category->getParams();
			
			// Current Language
			$lang = $this->app->lang->getCurrentLanguage();
			
			// Name Translation
			$name_translations = $params->get('content.name_translation', array());
			if( count( $name_translations ) )
			{
				if( array_key_exists($lang, $name_translations))
				{
					if( strlen($name_translations[$lang]) )
					{
						$category->name = $name_translations[$lang];
					}
				}
			}
			
			// Alias Translation
			$alias_translations = $params->get('content.alias_translation', array());
			if( count( $alias_translations ) )
			{
				if( array_key_exists($lang, $alias_translations))
				{
					if( strlen($alias_translations[$lang]) )
					{
						$category->alias = $alias_translations[$lang];
					}
				}
			}
			
			// Description
			$desc_translations = $params->get('content.desc_translation', array());
			if( count( $desc_translations ) )
			{
				if( array_key_exists($lang, $desc_translations))
				{
					if( strlen($desc_translations[$lang]) )
					{
						$category->description = $desc_translations[$lang];
					}
				}
			}
			
			// Teaser Description
			$desc_translations = $params->get('content.teaser_desc_translation', array());
			if( count( $desc_translations ) )
			{
				if( array_key_exists($lang, $desc_translations))
				{
					if( strlen($desc_translations[$lang]) )
					{
						$category->getParams()->set('content.teaser_description', $desc_translations[$lang] );
					}
				}
			}
			
			// Categories Title
			$desc_translations = $params->get('content.cat_title_translation', array());
			if( count( $desc_translations ) )
			{
				if( array_key_exists($lang, $desc_translations))
				{
					if( strlen($desc_translations[$lang]) )
					{
						$category->getParams()->set('content.categories_title', $desc_translations[$lang] );
					}
				}
			}
			
			// Items Title
			$desc_translations = $params->get('content.item_title_translation', array());
			if( count( $desc_translations ) )
			{
				if( array_key_exists($lang, $desc_translations))
				{
					if( strlen($desc_translations[$lang]) )
					{
						$category->getParams()->set('content.items_title', $desc_translations[$lang] );
					}
				}
			}
			
			// Sub Headline Title
			$sub_translations = $params->get('content.sub_headline_translation', array());
			if( count( $sub_translations ) )
			{
				if( array_key_exists($lang, $sub_translations))
				{
					if( strlen($sub_translations[$lang]) )
					{
						$category->getParams()->set('content.sub_headline', $sub_translations[$lang] );
					}
				}
			}
			
			// Teaser Image 
			$timage_translations = $params->get('content.teaser_image_translation', array());
			if( count( $timage_translations ) )
			{
				if( array_key_exists($lang, $timage_translations))
				{
					if( strlen($timage_translations[$lang]) )
					{
						$category->getParams()->set('content.teaser_image', $timage_translations[$lang] );
					}
				}
			}
			
			// Teaser Image Width
			$timagew_translations = $params->get('content.teaser_image_translation_width', array());
			if( count( $timagew_translations ) )
			{
				if( array_key_exists($lang, $timagew_translations))
				{
					if( strlen($timagew_translations[$lang]) )
					{
						$category->getParams()->set('content.teaser_image_width', $timagew_translations[$lang] );
					}
				}
			}
			
			// Teaser Image Height
			$timageh_translations = $params->get('content.teaser_image_translation_height', array());
			if( count( $timageh_translations ) )
			{
				if( array_key_exists($lang, $timageh_translations))
				{
					if( strlen($timageh_translations[$lang]) )
					{
						$category->getParams()->set('content.teaser_image_height', $timageh_translations[$lang] );
					}
				}
			}
			
			// Image 
			$image_translations = $params->get('content.image_translation', array());
			if( count( $image_translations ) )
			{
				if( array_key_exists($lang, $image_translations))
				{
					if( strlen($image_translations[$lang]) )
					{
						$category->getParams()->set('content.image', $image_translations[$lang] );
					}
				}
			}
			
			// Image Width
			$imagew_translations = $params->get('content.image_translation_width', array());
			if( count( $imagew_translations ) )
			{
				if( array_key_exists($lang, $imagew_translations))
				{
					if( strlen($imagew_translations[$lang]) )
					{
						$category->getParams()->set('content.image_width', $imagew_translations[$lang] );
					}
				}
			}
			
			// Image Height
			$imageh_translations = $params->get('content.image_translation_height', array());
			if( count( $imageh_translations ) )
			{
				if( array_key_exists($lang, $imageh_translations))
				{
					if( strlen($imageh_translations[$lang]) )
					{
						$category->getParams()->set('content.image_height', $imageh_translations[$lang] );
					}
				}
			}

			// Meta Title
			$metaTitle_translations = $params->get('content.meta_title_translation', array());
			if( count( $metaTitle_translations ) )
			{
				if( array_key_exists($lang, $metaTitle_translations))
				{
					if( strlen($metaTitle_translations[$lang]) )
					{
						$category->getParams()->set('metadata.title', $metaTitle_translations[$lang] );
					}
				}
			}
			
			// Meta Description
			$metaDescription_translations = $params->get('content.meta_description_translation', array());
			if( count( $metaDescription_translations ) )
			{
				if( array_key_exists($lang, $metaDescription_translations))
				{
					if( strlen($metaDescription_translations[$lang]) )
					{
						$category->getParams()->set('metadata.description', $metaDescription_translations[$lang] );
					}
				}
			}
						
			// Meta Keywords
			$metaKeywords_translations = $params->get('content.meta_keywords_translation', array());
			if( count( $metaKeywords_translations ) )
			{
				if( array_key_exists($lang, $metaKeywords_translations))
				{
					if( strlen($metaKeywords_translations[$lang]) )
					{
						$category->getParams()->set('metadata.keywords', $metaKeywords_translations[$lang] );
					}
				}
			}

		}		
	}

	/**
	 * Check the language before displaying the item, and translate it if necessary
	 */
	public function itemInit($event, $arguments = array())
	{
		$task = JRequest::getVar('task', '');
		$method = JRequest::getVar('method', '');
		
		// Only on site side
		if( $this->joomla->isSite())
		{
			// NOT ON SUBMISSION / COMMENT SAVE AND UNSUBSCRIBE TO AVOID SWITCHING NAME ISSUE
			// ALSO NOT IN DOWNLOAD - DOWNLOAD PRO - RATING TO AVOID NAME SWITCHING ISSUE
			$methods_not_allowed = array('reset', 'vote', 'download');
			$tasks_not_allowed = array('submission', 'unsubscribe', 'save');
			if( in_array($task, $tasks_not_allowed) ||   ($task == 'callelement' && in_array($method, $methods_not_allowed)) ) 
			{
				return;
			}
			
			$item = $event->getSubject();
			
			// Parameters
			$params = $item->getParams();
			
			// Current Language
			$lang = $this->app->lang->getCurrentLanguage();
			
			// Name Translation
			$name_translations = $params->get('content.name_translation', array());
			if( count( $name_translations ) )
			{
				if( array_key_exists($lang, $name_translations))
				{
					if( strlen($name_translations[$lang]) )
					{
						$item->name = $name_translations[$lang];
					}
				}
			}
			
			// Alias
			$desc_translations = $params->get('content.alias_translation', array());
			if( count( $desc_translations ) )
			{
				if( array_key_exists($lang, $desc_translations))
				{
					if( strlen($desc_translations[$lang]) )
					{
						$item->alias = $desc_translations[$lang];
					}
				}
			}

			// Meta Title
			$desc_translations = $params->get('content.metatitle_translation', array());
			if( count( $desc_translations ) )
			{
				if( array_key_exists($lang, $desc_translations))
				{
					if( strlen($desc_translations[$lang]) )
					{
						$item->getParams()->set('metadata.title', $desc_translations[$lang] );
					}
				}
			}

			// Meta Desc
			$desc_translations = $params->get('content.metadesc_translation', array());
			if( count( $desc_translations ) )
			{
				if( array_key_exists($lang, $desc_translations))
				{
					if( strlen($desc_translations[$lang]) )
					{
						$item->getParams()->set('metadata.description', $desc_translations[$lang] );
					}
				}
			}
			
			// Meta Keys
			$desc_translations = $params->get('content.metakeywords_translation', array());
			if( count( $desc_translations ) )
			{
				if( array_key_exists($lang, $desc_translations))
				{
					if( strlen($desc_translations[$lang]) )
					{
						$item->getParams()->set('metadata.keywords', $desc_translations[$lang] );
					}
				}
			}
		}
	}

	/**
	 * Check the language before displaying the submission, and translate it if necessary
	 */
	public function submissionInit($event, $arguments = array()) {

		// Only on site side
		if( $this->joomla->isSite() )
		{
			$submission = $event->getSubject();
			
			// Parameters
			$params = $submission->getParams();
			
			// Current Language
			$lang = $this->app->lang->getCurrentLanguage();
			
			// Name Translation
			$name_translations = $params->get('config.name_translation', array());
			if( count( $name_translations ) )
			{
				if( array_key_exists($lang, $name_translations))
				{
					if( strlen($name_translations[$lang]) )
					{
						$submission->name = $name_translations[$lang];
					}
				}
			}
		}
	}
	
	/** 
	 * New method for adding params to the element
	 * @since 2.5
	 */
	public function addElementConfig($event)
	{
		$element = $event->getSubject();
		
		// Custom Params File
		$file = $this->app->path->path( 'zoolingual:element.xml');
		$xml = simplexml_load_file( $file );

		// Old params
		$params = $event->getReturnValue();
		// add new params from custom params file
		$params[] = $xml->asXML();

		$event->setReturnValue($params);
	}

	/*
	 *  checkDependencies
	 */
	public function checkDependencies()
	{
		if($this->joomla->isAdmin())
		{
			// if ZLFW not enabled
			if(!JPluginHelper::isEnabled('system', 'zlframework') || !JComponentHelper::getComponent('com_zoo', true)->enabled) {
				$this->joomla->enqueueMessage(JText::_('PLG_ZOOLINGUAL_ZLFW_MISSING'), 'notice');
			} else {
				// load zoo
				require_once(JPATH_ADMINISTRATOR.'/components/com_zoo/config.php');

				// fix plugins ordering
				$zoo = App::getInstance('zoo');
				$zoo->loader->register('ZlfwHelper', 'root:plugins/system/zlframework/zlframework/helpers/zlfwhelper.php');
				$zoo->zlfw->checkPluginOrder('zoofilter');
			}
		}
	}
}