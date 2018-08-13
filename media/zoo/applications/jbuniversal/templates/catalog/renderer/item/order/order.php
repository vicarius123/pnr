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


$this->app->jbassets->jqueryAccordion();

?>

<div class="basket-info jsBasketInfo bfQuickMode">

    
	<div class="bfNoSection">
		<div class="bfClearfix">
		<?php if ($this->checkPosition('name')) : ?>
			<span class="bfElemWrap bfLabelLeft width33 first">
					<?php echo $this->renderPosition('name', array('style' => 'order.block')); ?>
			</span>
		<?php endif; ?>
		<?php if ($this->checkPosition('phone')) : ?>
			<span class="bfElemWrap bfLabelLeft width33">
					<?php echo $this->renderPosition('phone', array('style' => 'order.block')); ?>
			</span>
		<?php endif; ?>
		<?php if ($this->checkPosition('mail')) : ?>
			<span class="bfElemWrap bfLabelLeft width33 last">
					<?php echo $this->renderPosition('mail', array('style' => 'order.block')); ?>
			</span>
		<?php endif; ?>
		</div>
	</div>
	<div class="bfNoSection">
		<div class="bfClearfix">
		<?php if ($this->checkPosition('metro')) : ?>
			<span class="bfElemWrap bfLabelLeft width33 first">
					<?php echo $this->renderPosition('metro', array('style' => 'order.block')); ?>
			</span>
		<?php endif; ?>
		<?php if ($this->checkPosition('street')) : ?>
			<span class="bfElemWrap bfLabelLeft width66 last">
					<?php echo $this->renderPosition('street', array('style' => 'order.block')); ?>
			</span>
		<?php endif; ?>
		</div>
	</div>
	
	<div class="bfNoSection">
		<div class="bfClearfix">
			<span class="bfElemWrap bfLabelLeft width33 first">
				<?php if ($this->checkPosition('dom')) : ?>
					<span class="bfElemWrap bfLabelLeft width50 first">
							<?php echo $this->renderPosition('dom', array('style' => 'order.block')); ?>
					</span>	
				<?php endif; ?>
				<?php if ($this->checkPosition('stroenie')) : ?>
					<span class="bfElemWrap bfLabelLeft width50 last">
							<?php echo $this->renderPosition('stroenie', array('style' => 'order.block')); ?>
					</span>			
				<?php endif; ?>
			</span>
			<span class="bfElemWrap bfLabelLeft width33">
				<?php if ($this->checkPosition('podiezd')) : ?>
					<span class="bfElemWrap bfLabelLeft width50 first">
							<?php echo $this->renderPosition('podiezd', array('style' => 'order.block')); ?>
					</span>
				<?php endif; ?>
				<?php if ($this->checkPosition('etaj')) : ?>
					<span class="bfElemWrap bfLabelLeft width50 last">
							<?php echo $this->renderPosition('etaj', array('style' => 'order.block')); ?>
					</span>
				<?php endif; ?>
			</span>
			<span class="bfElemWrap bfLabelLeft width33 last">
				<?php if ($this->checkPosition('kvartira')) : ?>
					<span class="bfElemWrap bfLabelLeft width50 first">
							<?php echo $this->renderPosition('kvartira', array('style' => 'order.block')); ?>
					</span>
				<?php endif; ?>
				<?php if ($this->checkPosition('domofon')) : ?>
					<span class="bfElemWrap bfLabelLeft width50 last">
							<?php echo $this->renderPosition('domofon', array('style' => 'order.block')); ?>
					</span>
				<?php endif; ?>
			</span>
		</div>
	</div>
	
	<div class="bfNoSection">
		<div class="bfClearfix">
		<?php if ($this->checkPosition('dop-options')) : ?>
			<span class="bfElemWrap bfLabelLeft width33 checkboxes-container first">
					<?php echo $this->renderPosition('dop-options', array('style' => 'order.block')); ?>
			</span>
		<?php endif; ?>
		<?php if ($this->checkPosition('primechanie')) : ?>
			<span class="bfElemWrap bfLabelLeft width66 last">
					<?php echo $this->renderPosition('primechanie', array('style' => 'order.block')); ?>
			</span>
		<?php endif; ?>
		</div>
	</div>
	
	
	<?php if ($this->checkPosition('billing')) : ?>
            <div class="helping-hidden">
                <?php echo $this->renderPosition('billing', array('style' => 'order.block')); ?>
            </div>
    <?php endif; ?>
</div>
