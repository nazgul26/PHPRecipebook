<script type="text/javascript">
    $(function() {
        $(document).off("saved.unit");
        $(document).on("saved.unit", function() {
            $('#editUnitDialog').dialog('close');
            ajaxGet('units');
        }); 
    });
</script>
<div class="units index">
        <h2><?php echo __('Units'); ?></h2>
        <div class="actions">
                <ul>
                        <li><?php echo $this->Html->link(__('Add Unit'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editUnitDialog')); ?></li>
                </ul>
        </div>
        <table cellpadding="0" cellspacing="0">
        <tr>
                <th class="actions"><?php echo __('Actions'); ?></th>
                <th><?php echo $this->Paginator->sort('name'); ?></th>
                <th><?php echo $this->Paginator->sort('abbreviation'); ?></th>
                <th><?php echo $this->Paginator->sort('system_type'); ?></th>
                <th><?php echo $this->Paginator->sort('sort_order'); ?></th>
        </tr>
        <?php foreach ($units as $unit): ?>
        <tr>
                <td class="actions">
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $unit->id), array('class' => 'ajaxLink', 'targetId' => 'editUnitDialog')); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $unit->id), ['confirm' => __('Are you sure you want to delete {0}?', $unit->name)]); ?>
                </td>
                <td><?php echo h($unit->name); ?>&nbsp;</td>
                <td><?php echo h($unit->abbreviation); ?>&nbsp;</td>
                <td><?php echo h($unit->system_type); ?>&nbsp;</td>
                <td><?php echo h($unit->sort_order); ?>&nbsp;</td>
        </tr>
        <?php endforeach; ?>
        </table>
	<?= $this->element('pager') ?>
</div>
