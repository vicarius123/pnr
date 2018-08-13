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
 * Class JBModelElementRange
 */
class JBModelElementRange extends JBModelElement
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
        return $this->_getWhere($value, $elementId);
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
        return $this->_getWhere($value, $elementId);
    }

    /**
     * Prepare value
     * @param array|string $value
     * @param bool $exact
     * @return array|mixed
     */
    protected function _prepareValue($value, $exact = false)
    {
        if ($this->_isDate($value)) {
            $values = $value['range-date'];
        } else {
            $values = $value['range'];
        }

        if (!is_array($values)) {
            $values = explode('/', $values);
        }

        if ($this->_isDate($value)) {

            $values = array(
                $this->app->jbdate->toMysql($values[0]),
                $this->app->jbdate->toMysql($values[1]),
            );

        } else {

            $values = array(
                JString::trim($values[0]),
                JString::trim($values[1])
            );
        }

        if ($values[0] === '' && $values[1] === '') {
            return array();
        }

        return $values;
    }

    /**
     * Check is value is date
     * @param $value
     * @return bool
     */
    protected function _isDate($value)
    {
        return isset($value['range-date']);
    }

    /**
     * Get where conditions
     * @param $values
     * @param $elementId
     * @return array|null
     */
    protected function _getWhere($values, $elementId)
    {
        $isDate = $this->_isDate($values);
        $values = $this->_prepareValue($values);

        $where = array();

        if (!empty($values)) {

            if (strlen($values[0]) == 0 && strlen($values[1]) == 0) {
                return null;
            }

            $clearElementId = $this->_jbtables->getFieldName($elementId, $isDate ? 'd' : 'n');

            if ($isDate) {

                if (!empty($values[0]) && empty($values[1])) {
                    $where[] = "tIndex." . $clearElementId . " >= STR_TO_DATE('" . $values[0] . "', '%Y-%m-%d %H:%i:%s')";

                } elseif (empty($values[0]) && !empty($values[1])) {
                    $where[] = "tIndex." . $clearElementId . " <= STR_TO_DATE('" . $values[1] . "', '%Y-%m-%d %H:%i:%s')";

                } else {
                    $where[] = "tIndex." . $clearElementId
                        . " BETWEEN STR_TO_DATE('" . $values[0] . "', '%Y-%m-%d %H:%i:%s')"
                        . " AND STR_TO_DATE('" . $values[1] . "', '%Y-%m-%d %H:%i:%s')";
                }

            } else {

                if (strlen($values[0]) != 0) {
                    $where[] = 'tIndex.' . $clearElementId . ' >= ' . (float)$values[0];
                }

                if (strlen($values[1]) != 0) {
                    $where[] = 'tIndex.' . $clearElementId . ' <= ' . (float)$values[1];
                }
            }

            return $where;
        }

        return null;
    }
}
