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
 * Class JBConfigHelper
 */
class JBConfigHelper extends AppHelper
{
    /**
     * @var string
     */
    protected $_configPattern = '#JBZOO_CONFIG_*#i';

    /**
     * @return array
     */
    public function getList()
    {
        $const = get_defined_constants(true);

        $result = array();
        foreach ($const['user'] as $key => $value) {
            if (preg_match($this->_configPattern, $key)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Save file
     * @param array $params
     * @param $path
     * @return bool
     */
    public function saveToFile(array $params, $path)
    {
        $fileTemplate = array(
            '<?php',
            '/**',
            ' * JBZoo App is universal Joomla CCK, application for YooTheme Zoo component',
            ' *',
            ' * @package     jbzoo',
            ' * @version     2.x Pro',
            ' * @author      JBZoo App http://jbzoo.com',
            ' * @copyright   Copyright (C) JBZoo.com,  All rights reserved.',
            ' * @license     http://jbzoo.com/license-pro.php JBZoo Licence',
            ' */',
            '',
            '// no direct access',
            'defined(\'_JEXEC\') or die(\'Restricted access\');',
            '',
            '',
        );

        foreach ($params as $key => $value) {

            $constName = JString::strtoupper($key);
            $value     = str_replace('\'', "\\'", $value);

            $fileTemplate[] = 'define(\'' . $constName . '\', \'' . $value . '\');';
        }

        $fileTemplate[] = '';

        $fileContent = implode("\n", $fileTemplate);

        if (JFile::exists($path)) {
            JFile::delete($path);
        }

        if (!JFile::write($path, $fileContent)) {
            $this->app->jbnotify->warning('The file is not created, check file permissions for JBZoo directory');

            return false;
        }

        return true;
    }

}
