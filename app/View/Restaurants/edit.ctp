<div class="restaurants form">
<?php echo $this->Form->create('Restaurant'); ?>
	<fieldset>
		<legend><?php echo __('Edit Restaurant'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('street');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('zip');
		echo $this->Form->input('country');
		echo $this->Form->input('phone');
		echo $this->Form->input('hours');
		echo $this->Form->input('picture');
		echo $this->Form->input('picture_type');
		echo $this->Form->input('menu_text');
		echo $this->Form->input('comments');
		echo $this->Form->input('price_ranges_id');
		echo $this->Form->input('delivery');
		echo $this->Form->input('carry_out');
		echo $this->Form->input('dine_in');
		echo $this->Form->input('credit');
		echo $this->Form->input('website');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Restaurant.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Restaurant.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Restaurants'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Price Ranges'), array('controller' => 'price_ranges', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Price Ranges'), array('controller' => 'price_ranges', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
