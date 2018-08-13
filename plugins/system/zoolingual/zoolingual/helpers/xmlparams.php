<?php
/**
* @package		ZOOlingual
* @author    	ZOOlanders http://www.zoolanders.com
* @copyright 	Copyright (C) JOOlanders SL
* @license   	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class XmlparamsHelper extends AppHelper {

	/**	
	 * This methods adds parameters to any application.xml file
	 * 
	 * @param	Application		the Application object
	 * @param	string			The xml file where the extra application params are stored (absolute path)
	 */
	public function addApplicationParams( &$app, $file )
	{
		// Custom XML File
		$xml = simplexml_load_file( $file );
		
		// Appication XML file
		$old_file = $this->app->path->path( $app->getResource() . $app->metaxml_file );
		$old_xml = simplexml_load_file( $old_file );
		
		// App changed?
		$app_file_changed = false;
		
		// Application is right?
		if ( isset( $xml->application) )
		{
			foreach ( $xml->application as $a )
			{
				// Check the parameter group
				$group = (string) $a->attributes()->group ? (string) $a->attributes()->group : 'all';
				if( $group == 'all' || $group == $app->application_group )
				{
					if ( isset( $a->params ) )
					{
						foreach ( $a->params as $param )
						{
							// Second level grouping	
							$group = (string)$param->attributes()->group ? (string)$param->attributes()->group : '_default';
							$new_params = new SimpleXMLElement('<params></params>');
							$new_params->addAttribute('group', $group);
							
							if(@$old_xml->params)
							{
								$param_added = false;
								// Merge with already existing param groups
								foreach( $old_xml->params as $ops)
								{
									if( (string)$ops->attributes()->group == $group )
									{
										$param_added = true;
										
										// Check for addPath
										if( ($a->params->attributes()->addpath != '') && !($old_xml->params->attributes()->addpath) )
										{
											@$ops->addAttribute('addpath', $a->params->attributes()->addpath);
											$app_file_changed = true;
										}
										
										// Add the parameters for this group
										foreach($param->param as $p)
										{
											// If it doesn't exists already
											if( !count( $ops->xpath("param[@name='".$p->attributes()->name."']" ) )  )
											{
												// Push changes
												$this->appendChild( $ops, $p );												
												$app_file_changed = true;
											}
										}
									}
								}
								
								// Create a new param group if necessary
								if( !$param_added )
								{
									$this->appendChild($old_xml, $param );
									$app_file_changed = true;
								}
							}
						}
					}
				}
			}
		}

		// if any param was added
		if( $app_file_changed )
		{
			// Save the new file and set it as the default one
			$new_file = $this->app->path->path( $app->getResource() ).'/'.JFile::stripExt($app->metaxml_file).'_zoolingual.xml';
			
			// Save the new version
			$data = $old_xml->asXML();
			JFile::write( $new_file, $data);
			
			// set it as the default one
			$app->metaxml_file = JFile::stripExt($app->metaxml_file) . '_zoolingual.xml';
		}	
	}

	/**
	 * Helper method to push simplexmlelements into another simplexmlelement
	 * 
	 * @since 2.5
	 */
	public function appendChild( &$parent, &$child )
	{
		// use dom for this kind of things	
		$domparent = dom_import_simplexml($parent);
		$domchild  = dom_import_simplexml($child);
		
		// Import
		$domchild  = $domparent->ownerDocument->importNode($domchild, TRUE);
		
		// Append
		$domparent->appendChild($domchild);
	}
}