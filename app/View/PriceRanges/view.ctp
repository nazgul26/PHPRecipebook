<div class="priceRanges view">
<h2><?php echo __('Price Range'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($priceRange['PriceRange']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($priceRange['PriceRange']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Price Range'), array('action' => 'edit', $priceRange['PriceRange']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Price Range'), array('action' => 'delete', $priceRange['PriceRange']['id']), null, __('Are you sure you want to delete # %s?', $priceRange['PriceRange']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Price Ranges'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Price Range'), array('action' => 'add')); ?> </li>
	</ul>
</div>
