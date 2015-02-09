<div class="vendors index">
    <h2><?php echo __('Online Grocery Vendors'); ?></h2>
    <div class="actions">
    <ul>
            <li><?php echo $this->Html->link(__('New Vendor'), array('action' => 'edit')); ?></li>
            <li><?php echo $this->Html->link(__('List Vendor Products'), array('controller' => 'vendor_products', 'action' => 'index')); ?> </li>
    </ul>
    </div>
    <table cellpadding="0" cellspacing="0">
    <tr>
        <th class="actions"><?php echo __('Actions'); ?></th>
        <th><?php echo $this->Paginator->sort('name'); ?></th>
        <th><?php echo $this->Paginator->sort('home_url'); ?></th>
    </tr>
    <?php foreach ($vendors as $vendor): ?>
    <tr>
        <td class="actions">
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $vendor['Vendor']['id'])); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $vendor['Vendor']['id']), null, __('Are you sure you want to delete # %s?', $vendor['Vendor']['id'])); ?>
        </td>
        <td><?php echo h($vendor['Vendor']['name']); ?>&nbsp;</td>
        <td><?php echo h($vendor['Vendor']['home_url']); ?>&nbsp;</td>
    </tr>
    <?php endforeach; ?>
    </table>
    <p>
    <?php
    echo $this->Paginator->counter(array(
    'format' => __('Page {:page} of {:pages}')
    ));
    ?>	</p>
    <div class="paging">
    <?php
            echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
    </div>
</div>

