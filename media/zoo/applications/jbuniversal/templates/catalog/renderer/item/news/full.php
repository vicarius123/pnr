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
<div class="news-title-date">
<?php if ($this->checkPosition('title')) : ?>
    <h1 class="title"><?php echo $this->renderPosition('title'); ?></h1>
<?php endif; ?>

<?php if ($this->checkPosition('date')) : ?>
    <div class="news-date"><?php echo $this->renderPosition('date'); ?></div>
<?php endif; ?>
</div>

<?php if ($this->checkPosition('tags')) : ?>
    <div class="news-tags"><?php echo $this->renderPosition('tags'); ?></div>
<?php endif; ?>

<div class="gallery-toggler">
<div class="slider-toggler active">
	<div class="slider-toggler-square"></div>
</div>
<div class="wall-toggler">
	<div class="wall-toggler-square wts1"></div>
	<div class="wall-toggler-square wts2"></div>
	<div class="wall-toggler-square wts3"></div>
	<div class="wall-toggler-square wts4"></div>
</div>
</div>

<?php if ($this->checkPosition('text')) : ?>
    <div class="text"><?php echo $this->renderPosition('text'); ?></div>
<?php endif; ?>

<?php if ($this->checkPosition('prevnext')) : ?>
    <div class="prevnext"><?php echo $this->renderPosition('prevnext'); ?></div>
<?php endif; ?>

<?php if ($this->checkPosition('gallery-slider')) : ?>
    <div class="news-gallery news-gallery-slider active">
        <?php echo $this->renderPosition('gallery-slider'); ?>
    </div>
<?php endif; ?>

<?php if ($this->checkPosition('gallery-wall')) : ?>
    <div class="news-gallery news-gallery-wall">
        <?php echo $this->renderPosition('gallery-wall'); ?>
    </div>
<?php endif; ?>

<div class="clr"></div>
