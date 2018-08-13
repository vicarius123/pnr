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


$imageAlign = $this->app->jbitem->getMediaAlign($item, $layout);
?>
<?php if ($this->checkPosition('date')) : ?>
    <div class="date"><?php echo $this->renderPosition('date'); ?></div>
<?php endif; ?>

<?php if ($this->checkPosition('title')) : ?>
    <h3 class="title-news-blog-item"><?php echo $this->renderPosition('title'); ?></h3>
<?php endif; ?>

<?php if ($this->checkPosition('image')) : ?>
    <div class="image">
        <?php echo $this->renderPosition('image'); ?>
    </div>
<?php endif; ?>

<?php if ($this->checkPosition('tags')) : ?>
    <div class="tags"><?php echo $this->renderPosition('tags'); ?></div>
<?php endif; ?>

<div class="clr"></div>
