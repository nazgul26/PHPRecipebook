<script type="text/javascript">
    $(function() {
        setSearchBoxTarget('Restaurants');
        
        $(document).on("saved.restaurant", function() {
            $('#editRestaurantDialog').dialog('close');
            ajaxGet('restaurants');
        });
    });
</script>
<div class="restaurants index">
	<h2><?php echo __('Restaurants'); ?></h2>
        <?php if ($loggedIn): ?>
        <div class="actions">
            <ul>
                <li><?php echo $this->Html->link(__('Add Restaurant'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editRestaurantDialog'));?></li>
                <li><button id="moreActionLinks">More Actions...</button></li>
            </ul>
            <div style="display: none;">
                <ul id="moreActionLinksContent">
                    <li><?php echo $this->Html->link(__('List Price Ranges'), array('controller' => 'price_ranges', 'action' => 'index'), array('class' => 'ajaxNavigationLink')); ?> </li>
                    <li><?php echo $this->Html->link(__('New Price Ranges'), array('controller' => 'price_ranges', 'action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editPriceRangesDialog')); ?> </li>
                </ul>
            </div> 
        </div>
        <?php endif;?>
	<table cellpadding="0" cellspacing="0">
	<tr>
        <?php if ($loggedIn  && ($isAdmin || $loggedInuserId == $recipe['User']['id'])):?>
            <th class="actions"><?php echo __('Actions'); ?></th>
        <?php endif;?>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('street'); ?></th>
            <th><?php echo $this->Paginator->sort('city'); ?></th>
            <th><?php echo $this->Paginator->sort('state'); ?></th>
            <th><?php echo $this->Paginator->sort('zip'); ?></th>
            <th><?php echo $this->Paginator->sort('country'); ?></th>
            <th><?php echo $this->Paginator->sort('phone'); ?></th>
            <th><?php echo $this->Paginator->sort('hours'); ?></th>
            <th><?php echo $this->Paginator->sort('comments'); ?></th>
            <th><?php echo $this->Paginator->sort('user_id'); ?></th>
            
	</tr>
	<?php foreach ($restaurants as $restaurant): ?>
	<tr>
            <?php if ($loggedIn  && ($isAdmin || $loggedInuserId == $recipe['User']['id'])):?>
            <td class="actions">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $restaurant['Restaurant']['id']), array('class' => 'ajaxLink', 'targetId' => 'editRestaurantDialog')); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $restaurant['Restaurant']['id']), null, __('Are you sure you want to delete # %s?', $restaurant['Restaurant']['id'])); ?>
            </td>
            <?php endif;?>
            <td><?php echo $restaurant['Restaurant']['name']; ?>&nbsp;</td>
            <td><?php echo h($restaurant['Restaurant']['street']); ?>&nbsp;</td>
            <td><?php echo h($restaurant['Restaurant']['city']); ?>&nbsp;</td>
            <td><?php echo h($restaurant['Restaurant']['state']); ?>&nbsp;</td>
            <td><?php echo h($restaurant['Restaurant']['zip']); ?>&nbsp;</td>
            <td><?php echo h($restaurant['Restaurant']['country']); ?>&nbsp;</td>
            <td><?php echo h($restaurant['Restaurant']['phone']); ?>&nbsp;</td>
            <td><?php echo $restaurant['Restaurant']['hours']; ?>&nbsp;</td>
            <td><?php echo $restaurant['Restaurant']['comments']; ?>&nbsp;</td>
            <td>
            <?php 
            if ($isAdmin) { 
                echo $this->Html->link($restaurant['User']['name'], array('controller' => 'users', 'action' => 'view', $restaurant['User']['id']));
            } else {
                echo $restaurant['User']['name'];
            }?>
            </td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}')));?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
