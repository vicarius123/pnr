<?php
/**
* @package   Widgetkit
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$css_classes  = ($params->get('corners', 'square') == 'round') ? 'round ' : '';
$css_classes .= ($params->get('effect') == 'zoom') ? 'zoom ' : '';
$css_classes .= ($params->get('margin')) ? 'margin ' : '';

$id = $this->identifier.'-'.uniqid();
$count = 1;
$count_last = 1;
$max_count = 3;
$firstlast = '';
$lastlast = '';
$images_count = count($thumbs);
?>
<div class="zoo-gallery" id="<?php echo $id; ?>">
	<div class="zoo-gallery-wall clearfix <?php echo $css_classes; ?>">

		<?php foreach ($thumbs as $image) : ?>

			<?php

				$lightbox  = '';
				$spotlight = '';
				$overlay   = '';

				/* Prepare Spotlight */
				if ($params->get('effect') == 'spotlight') {
					if ($params->get('spotlight_effect') && $params->get('spotlight_caption')) {
						$spotlight = 'data-spotlight="effect:'.$params->get('spotlight_effect').'"';
						$overlay = '<div class="overlay">'.$image['name'].'</div>';
					} else {
						$spotlight = 'data-spotlight="on"';
					}
				}

				/* Prepare Lightbox */
				if ($params->get('lightbox_group')) {
					$lightbox = 'data-lightbox="group:'.$this->identifier.'"';
				}

				if ($params->get('lightbox_caption')) {
					$lightbox .= ' title=""';
				}
				
				switch ($count) {
					case 1:
						$firstlast = ' first';
						break;
					case 3:
						$firstlast = ' last';
						break;
					default:
					   $firstlast = '';
				}
				
				switch ($count_last) {
					case ($images_count):
					case ($images_count-1):
					case ($images_count-2):
						$lastlast = ' last-last';
						break;
					default:
					   $lastlast = '';
				}				

				/* Prepare Image */
				$content = '<img src="'.$image['thumb'].'" width="'.$image['thumb_width'].'" height="'.$image['thumb_height'].'" alt="" />'.$overlay;
				
				$count++;
				$count_last++;
				if ($count > $max_count)
				{
					$count = 1;
				}
			?>

			<div class="zoo-gallery-item width33 float-left<? echo $firstlast; ?><? echo $lastlast; ?>"><a class="thumb" href="<?php echo $image['img']; ?>" <?php echo $lightbox; ?> <?php echo $spotlight; ?>><?php echo $content; ?></a></div>

		<?php endforeach; ?>

	</div>
</div>
<?php
	if ($params->get('effect') == 'opacity') {
		$this->app->document->addScriptDeclaration(sprintf("jQuery(function($) { $('%s').opacity(); });", '#'.$id .' .thumb'));
	}
