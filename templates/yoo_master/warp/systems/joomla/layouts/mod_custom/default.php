<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die;

?>

<?php if ($params->get('backgroundimage')) : ?>

<div class="mod-backround" style="background:url(<?php echo $params->get('backgroundimage');?>)  no-repeat center center scroll; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;" >
<?php echo $module->content;?>
</div>

<?php else : ?>

<?php echo $module->content;?>

<?php endif;