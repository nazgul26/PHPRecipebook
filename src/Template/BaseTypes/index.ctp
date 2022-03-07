<script type="text/javascript">
    $(function() {
        $(document).off("saved.baseType");
        $(document).on("saved.baseType", function() {
            $('#editBaseTypeDialog').dialog('close');
            ajaxGet('BaseTypes');
        });
    });
</script>
<div class="baseTypes index">
	<h2><?php echo __('Base Types'); ?></h2>
        <div class="actions">
            <ul>
                    <li><?php echo $this->Html->link(__('Add Base Type'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editBaseTypeDialog')); ?></li>
            </ul>
        </div>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
	</tr>
	<?php foreach ($baseTypes as $baseType): ?>
	<tr>
            <td class="actions">
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $baseType->id), array('class' => 'ajaxLink', 'targetId' => 'editBaseTypeDialog')); ?>
                <?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $baseType->id],['confirm' => __('Are you sure you want to delete {0}?', $baseType->name)]); ?>
            </td>
            <td><?php echo h($baseType->name); ?>&nbsp;</td>
	</tr>
        <?php endforeach; ?>
	</table>
    <?= $this->element('pager') ?>
</div>

