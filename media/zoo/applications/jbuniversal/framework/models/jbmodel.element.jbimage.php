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
 * Class JBModelElementJBImage
 */
class JBModelElementJBImage extends JBModelElement
{

    const IMAGE_EXISTS    = '__IMAGE_EXISTS__';
    const IMAGE_NO_EXISTS = '__IMAGE_NO_EXISTS__';

    /**
     * @param array|string $value
     * @param bool $exact
     * @return array|mixed
     */
    protected function _prepareValue($value, $exact = false)
    {
        if (self::IMAGE_EXISTS != $value && self::IMAGE_NO_EXISTS != $value) {
            return array();
        }

        return parent::_prepareValue($value, $exact);
    }

}
