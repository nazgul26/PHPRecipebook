<div class="preparationTimes form">
<?php echo $this->Form->create('PreparationTime'); ?>
	<fieldset>
		<legend><?php echo __('Add Preparation Time'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Preparation Times'), array('action' => 'index')); ?></li>
	</ul>
</div>
