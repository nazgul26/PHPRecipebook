<div class="priceRanges form">
<?php echo $this->Form->create('PriceRange'); ?>
	<fieldset>
		<legend><?php echo __('Edit Price Range'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('PriceRange.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('PriceRange.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Price Ranges'), array('action' => 'index')); ?></li>
	</ul>
</div>
