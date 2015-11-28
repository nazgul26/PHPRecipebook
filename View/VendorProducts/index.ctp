<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Online Grocery Vendors '), array('controller'=>'vendors', 'action' => 'index'), array('class' => 'ajaxNavigation')); ?> </li>
    <li class="active"><?php echo __('Products');?></li>
</ol>
<div class="vendorProducts index">
        <div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New Vendor Product'), array('action' => 'edit')); ?></li>
	</ul>
        </div>
        
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('code'); ?></th>
            <th><?php echo $this->Paginator->sort('ingredient_id'); ?></th>
            <th><?php echo $this->Paginator->sort('vendor_id'); ?></th>
            
	</tr>
	<?php foreach ($vendorProducts as $vendorProduct): ?>
	<tr>
            <td class="actions">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $vendorProduct['VendorProduct']['id'])); ?>
                    <?php 
                        $deleteText = (isset($vendorProduct['VendorProduct']['name']) ?
                                __('Are you sure you want to delete \'%s\'?', $vendorProduct['VendorProduct']['name']) :
                                __('Are you sure you want to delete the selected product?'));
                        echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $vendorProduct['VendorProduct']['id']), null, $deleteText); ?>
            </td>
            <td><?php echo h($vendorProduct['VendorProduct']['name']); ?>&nbsp;</td>
            <td><?php echo h($vendorProduct['VendorProduct']['code']); ?>&nbsp;</td>
            <td>
                <?php echo $this->Html->link($vendorProduct['Ingredient']['name'], array('controller' => 'ingredients', 'action' => 'view', $vendorProduct['Ingredient']['id'])); ?>
            </td>
            <td>
                <?php echo $this->Html->link($vendorProduct['Vendor']['name'], array('controller' => 'vendors', 'action' => 'view', $vendorProduct['Vendor']['id'])); ?>
            </td>
	</tr>
        <?php endforeach; ?>
	</table>
	<p>
	<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}')));?></p>
	<div class="paging">
	<?php
            echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>

