<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

/**
 * The helper class for alias handling.
 *
 * @package Component.Helpers
 * @since 2.0
 */
class AliasHelper extends AppHelper {

	protected $_helper = array();

	/**
	 * Retrieve AppAlias with table set
	 *
	 * @param string $name Table name to set
	 *
	 * @return AppAlias the alias helper for given table
	 *
	 * @since 2.0
	 */
	public function __get($name) {

		if (!isset($this->_helper[$name])) {

			if (!$table = $this->app->table->$name) {
				throw new AliasHelperException(sprintf('Table class (%s) not found', $name));
			}

			$this->_helper[$name] = $this->app->object->create('AppAlias', array($this->app, $table));
		}
		return $this->_helper[$name];
	}


}

class AppAlias {

	/**
	 * Reference to the global App object
	 *
	 * @var App
	 * @since 1.0.0
	 */
	public $app;

	/**
	 * Contains an instance of an AppTable object
	 *
	 * @var AppTable
	 * @since 2.0
	 */
	protected $_table;

	public function __construct($app, $table) {
		$this->app = $app;
		$this->_table = $table;
	}


	/**
	 * Translate object id to alias.
	 *
	 * @param string $id The object id
	 *
	 * @return string|null The object alias if found
	 *
	 * @since 2.0
	 */
	public function translateIDToAlias($id) {

		if (!is_numeric($id)) {
			return null;
		}

		if ($this->_table->has($id)) {
			return $this->_table->get($id)->alias;
		}

		// init vars
		$db = $this->app->database;

		// search alias
		$query = 'SELECT alias'
				.' FROM '.$this->_table->name
				.' WHERE id = '.$db->Quote($id)
				.' LIMIT 1';

		return $db->queryResult($query);
	}

	/**
	 * Translate object alias to id.
	 *
	 * @param string $alias The object alias
	 *
	 * @return string The object id if found, or 0
	 *
	 * @since 2.0
	 */
	public function translateAliasToID($alias) {

		// init vars
		$db = $this->app->database;

		// search alias
		$query = 'SELECT id'
				.' FROM '.$this->_table->name
				.' WHERE alias = '.$db->Quote($alias)
				.' LIMIT 1';

		/** ZOOlingual Start **/
		// check default alias
		

		if ($id = $db->queryResult($query)){
			return $id; 
		} else {
			// if not found, search into translated ones
			$lang = $this->app->lang->getCurrentLanguage();
			$query = 'SELECT id'
					 .' FROM '.$this->_table->name
					 // .' WHERE params REGEXP '.$db->Quote('(("content.alias_translation":)( )*(.)*( )*("'.$lang.'":)( )*("'.$alias.'"))')
					 .' WHERE params REGEXP '.$db->Quote('(("content.alias_translation":)( )*(.)*( )*("[a-z]*-[A-Z]*":)( )*("'.$alias.'"))')
					 .' LIMIT 1';

			// UNICODE: TODO - $str = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'self::replace_unicode_escape_sequence', $alias);

			return $db->queryResult($query);
		}
		/** ZOOlingual End **/

		return $db->queryResult($query);
	}

	function replace_unicode_escape_sequence($match){
    	return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
	}


	/**
	 * Get unique object alias.
	 *
	 * @param string $id The object id
	 * @param string $alias The object alias
	 *
	 * @return string The unique object alias string
	 *
	 * @since 2.0
	 */
	public function getUniqueAlias($id, $alias = '') {

		if (empty($alias) && $id) {
			$alias = JFilterOutput::stringURLSafe($this->_table->get($id)->name);
		}

		if (!empty($alias)) {
			$i = 2;
			$new_alias = $alias;
			while ($this->checkAliasExists($new_alias, $id)) {
				$new_alias = $alias.'-'.$i++;
			}
			return $new_alias;
		}

		return $alias;
	}

	/**
	 * Method to check if an alias already exists.
	 *
	 * @param string $alias The object alias
	 * @param string $id The object id
	 *
	 * @return string The object id if found, or 0
	 *
	 * @since 2.0
	 */
	public function checkAliasExists($alias, $id = 0) {

		$xid = intval($this->translateAliasToID($alias));
		if ($xid && $xid != intval($id)) {
			return true;
		}

		return false;
	}

}

/**
 * AliasHelperException identifies an Exception in the AliasHelper class
 * @see AliasHelper
 */
class AliasHelperException extends AppException {}