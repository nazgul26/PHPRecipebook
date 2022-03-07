<script type="text/javascript">
    $(function() {
        $(document).off("saved.preparationTime");
        $(document).on("saved.preparationTime", function() {
            $('#editPrepTimeDialog').dialog('close');
            ajaxGet('preparation-times');
        });
    });
</script>
<div class="preparationTimes index">
	<h2><?php echo __('Preparation Times'); ?></h2>
        <div class="actions">
	<ul>
            <li><?php echo $this->Html->link(__('Add Preparation Time'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editPrepTimeDialog')); ?></li>
	</ul>
        </div>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
	</tr>
	<?php foreach ($preparationTimes as $preparationTime): ?>
	<tr>
            <td class="actions">
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $preparationTime->id), array('class' => 'ajaxLink', 'targetId' => 'editPrepTimeDialog')); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $preparationTime->id), ['confirm' => __('Are you sure you want to delete {0}?', $preparationTime->name)]); ?>
            </td>
            <td><?php echo h($preparationTime->name); ?>&nbsp;</td>
	</tr>
        <?php endforeach; ?>
	</table>
	<?= $this->element('pager') ?>
</div>
