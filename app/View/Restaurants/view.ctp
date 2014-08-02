<div class="restaurants view">
<h2><?php echo __('Restaurant'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Street'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['street']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zip'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['zip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Country'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['country']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hours'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['hours']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Picture'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['picture']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Picture Type'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['picture_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Menu Text'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['menu_text']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comments'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['comments']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price Ranges'); ?></dt>
		<dd>
			<?php echo $this->Html->link($restaurant['PriceRanges']['name'], array('controller' => 'price_ranges', 'action' => 'view', $restaurant['PriceRanges']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Delivery'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['delivery']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Carry Out'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['carry_out']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dine In'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['dine_in']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Credit'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['credit']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Website'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['website']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($restaurant['User']['name'], array('controller' => 'users', 'action' => 'view', $restaurant['User']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Restaurant'), array('action' => 'edit', $restaurant['Restaurant']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Restaurant'), array('action' => 'delete', $restaurant['Restaurant']['id']), null, __('Are you sure you want to delete # %s?', $restaurant['Restaurant']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Restaurants'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Restaurant'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Price Ranges'), array('controller' => 'price_ranges', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Price Ranges'), array('controller' => 'price_ranges', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
