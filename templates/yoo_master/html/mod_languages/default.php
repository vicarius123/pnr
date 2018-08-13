<?php
defined('_JEXEC') or die;
$i = 1;
$right_class = '';
?>

<?php foreach ($list as $language) : ?>
		<?php
		if (!($language->active))
		{
			$link = $language->link;
			if ($i == 1)
			{
				$right_class = ' right';
			}
		}
		$i++;
		?>
<?php endforeach;?>
<div class="mod-languages<?php echo $moduleclass_sfx ?>">
	<a dir="ltr" class="lang-switcher-link<?=$right_class;?>" href="<?=$link;?>">
		<div class="lang-rus">Рус</div>
		<div id="lang-switcher"> <div id="lang-switcher-button"></div></div>
		<div class="lang-eng">Eng</div>
	</a>
</div>