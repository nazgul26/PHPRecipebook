<div class="shoppingList form">
<?php echo $this->Form->create('ShoppingList'); ?>
	<fieldset>
		<legend><?php echo __('Shopping List'); ?></legend>
	<?php
		echo $this->Form->hidden('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
