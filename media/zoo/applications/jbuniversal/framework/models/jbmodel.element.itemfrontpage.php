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


/**
 * Class JBModelElementItemfrontpage
 */
class JBModelElementItemfrontpage extends JBModelElement
{

    /**
     * Set AND element conditions
     * @param JBDatabaseQuery $select
     * @param string $elementId
     * @param string|array $value
     * @param int $i
     * @param bool $exact
     * @return JBDatabaseQuery
     */
    public function conditionAND(JBDatabaseQuery $select, $elementId, $value, $i = 0, $exact = false)
    {
        return $this->_getWhere($value);
    }

    /**
     * Set OR element conditions
     * @param JBDatabaseQuery $select
     * @param string $elementId
     * @param string|array $value
     * @param int $i
     * @param bool $exact
     * @return array
     */
    public function conditionOR(JBDatabaseQuery $select, $elementId, $value, $i = 0, $exact = false)
    {
        return $this->_getWhere($value);
    }

    /**
     * Get where conditions
     * @param $value
     * @return string
     */
    /**
     * Get where conditions
     * @param $value
     * @return string
     */
    protected function _getWhere($value)
    {
        if ((int)$value) {
            $rows = $this->_getItemIdsByCategoryIds((int)$value);
            if (!empty($rows)) {
                return array('tItem.id IN (' . implode(',', $rows) . ')');
            }

            return array();
        }

        return array();
    }

    /**
     * Get ItemId's by categoriesId's
     * @return array|JObject
     */
    protected function _getItemIdsByCategoryIds()
    {
        $select = $this->_getSelect()
            ->select('tCategoryItem.item_id')
            ->from(ZOO_TABLE_CATEGORY_ITEM . ' AS tCategoryItem')
            ->innerJoin(ZOO_TABLE_ITEM . ' AS tItem ON tItem.id = tCategoryItem.item_id')
            ->where('tCategoryItem.category_id = 0')
            ->where('tItem.application_id = ?', $this->_applicationId);

        $result = $this->fetchList($select);

        return $result;
    }

}
