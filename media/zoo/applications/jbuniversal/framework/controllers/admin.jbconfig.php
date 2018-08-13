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

if (JFile::exists($this->app->path->path('jbapp:config') . '/yml_config.php')) {
    require $this->app->path->path('jbapp:config') . '/yml_config.php';
}
/**
 * Class JBToolsJBuniversalController
 * JBZoo tools controller for back-end
 */
class JBConfigJBuniversalController extends JBUniversalController
{
    /**
     * Index page
     */
    public function index()
    {
        $this->renderView();
    }

    /**
     * Index page
     */
    public function yandexYml()
    {
        if (JFile::exists($this->app->path->path('jbapp:config') . '/yml_config.php')) {
            $this->post                              = $this->app->jbconfig->getList();
            $this->post['JBZOO_CONFIG_YML_TYPE']     = explode(':', $this->post['JBZOO_CONFIG_YML_TYPE']);
            $this->post['JBZOO_CONFIG_YML_APP_LIST'] = explode(':', $this->post['JBZOO_CONFIG_YML_APP_LIST']);
        } else {
            $this->post = '';
        }
        $this->renderView();
    }

    /**
     * Save JBZoo Config file
     */
    public function saveConfigYml()
    {
        $configPath = $this->app->path->path('jbapp:config') . '/yml_config.php';

        if (empty($_POST['jbzooform']['JBZOO_CONFIG_YML_APP_LIST']) || empty($_POST['jbzooform']['JBZOO_CONFIG_YML_TYPE'])) {
            $this->setRedirect($this->app->jbrouter->admin(array('task' => 'yandexyml')), JText::_('JBZOO_CONFIG_NO_SAVED'));
        }

        $_POST['jbzooform']['JBZOO_CONFIG_YML_APP_LIST'] = implode(':', $_POST['jbzooform']['JBZOO_CONFIG_YML_APP_LIST']);
        $_POST['jbzooform']['JBZOO_CONFIG_YML_TYPE']     = implode(':', $_POST['jbzooform']['JBZOO_CONFIG_YML_TYPE']);

        $this->app->jbconfig->saveToFile($_POST['jbzooform'], $configPath);

        $this->setRedirect($this->app->jbrouter->admin(array('task' => 'yandexyml')), JText::_('JBZOO_CONFIG_SAVED'));
    }

    /**
     * Save JBZoo Config file
     */
    public function saveConfig()
    {
        $configPath = $this->app->path->path('jbapp:config') . '/config.php';
        $this->app->jbconfig->saveToFile($_POST['jbzooform'], $configPath);

        $this->setRedirect($this->app->jbrouter->admin(array('task' => 'index')), JText::_('JBZOO_CONFIG_SAVED'));
    }

}
