
<div class="stores index">
    <h2><?php echo __('Stores'); ?></h2>
    <div class="actions">
        <ul>
                <li><?php echo $this->Html->link(__('New Store'), array('action' => 'edit')); ?></li>
        </ul>
    </div>
    <table cellpadding="0" cellspacing="0">
    <tr>
        <th class="actions"><?php echo __('Actions'); ?></th>
        <th><?php echo $this->Paginator->sort('name'); ?></th>
    </tr>
    <?php foreach ($stores as $store): ?>
    <tr>
        <td class="actions">
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $store['Store']['id'])); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $store['Store']['id']), null, __('Are you sure you want to delete # %s?', $store['Store']['id'])); ?>
        </td>
        <td><?php echo $store['Store']['name']; ?>&nbsp;</td>
    </tr>
    <?php endforeach; ?>
    </table>
    <p>
    <?php
    echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}')
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

