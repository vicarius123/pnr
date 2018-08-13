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
 * Class JBUpdateHelper
 */
class JBUpdateHelper extends AppHelper
{

    static $isMessageShow = false;

    /**
     * Check for update JBZoo
     * @return array
     */
    public function checkNewVersion()
    {
        $curApp = $this->app->zoo->getApplication();
        if ($curApp->getGroup() == JBZOO_APP_GROUP) {

            $response = $curApp->checkupd(true);

            if (isset($response['update_message']) && !empty($response['update_message'])) {
                if (defined('JBZOO_CONFIG_SHOWUPDATE') && JBZOO_CONFIG_SHOWUPDATE == '1') {
                    $this->_showMessage($response['update_message']);
                }
            }
        }
    }

    /**
     * Show update message
     */
    protected function _showMessage($message)
    {
        if (
            $this->app->jbrequest->is('option', 'com_zoo')
            &&
            !(preg_match('#^jb#', $this->app->jbrequest->getCtrl())
                || self::$isMessageShow
                || $this->app->jbrequest->isAjax()
            )
        ) {
            $this->app->jbnotify->notice($message);
            self::$isMessageShow = true;
        }

    }

}
