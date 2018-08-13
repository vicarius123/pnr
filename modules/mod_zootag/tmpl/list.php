<?php
/**
* @package   ZOO Tag
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// include css
$zoo->document->addStylesheet('mod_zootag:tmpl/list/style.css');

// get page lang 
$lang_for_tags = JFactory::getLanguage();
$lang_for_tags_code = strtolower($lang_for_tags->getTag());

if ($lang_for_tags_code=='en-gb')
{ $eng_page = true; }
else
{ $eng_page = false; }

$count = count($tags);

?>

<?php if ($count) : ?>

<ul class="zoo-list">
	<?php $i = 0; foreach ($tags as $tag) : ?>
	
	<?php $numMatches = preg_match('/^[A-Za-z0-9!@#%$&.]+$/', $tag->name, $matches);

	if ((($numMatches > 0)&&$eng_page)||((!$eng_page)&&($numMatches <= 0))) {
	?>
		<li class="weight<?php echo $tag->weight; ?>">
			<a href="<?php echo JRoute::_($tag->href); ?>"><?php echo $tag->name; ?></a>
		</li>
	<?php
	}
	?>
	
	
	<?php $i++; endforeach; ?>
</ul>

<?php else : ?>
<?php echo JText::_('COM_ZOO_NO_TAGS_FOUND'); ?>
<?php endif;