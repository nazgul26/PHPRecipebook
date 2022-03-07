
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
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $store->id)); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $store->id), ['confirm' => __('Are you sure you want to delete {0}}?', $store->name)]); ?>
        </td>
        <td><?php echo $store->name; ?>&nbsp;</td>
    </tr>
    <?php endforeach; ?>
    </table>
	<?= $this->element('pager') ?>
</div>

