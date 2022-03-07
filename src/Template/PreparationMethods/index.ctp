<script type="text/javascript">
    $(function() {
        $(document).off("saved.preparationMethod");
        $(document).on("saved.preparationMethod", function() {
            $('#editPrepMethodDialog').dialog('close');
            ajaxGet('preparation-methods');
        });
    });
</script>
<div class="preparationMethods index">
	<h2><?php echo __('Preparation Methods'); ?></h2>
        <div class="actions">
	<ul>
            <li><?php echo $this->Html->link(__('Add Preparation Method'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editPrepMethodDialog')); ?></li>
	</ul>
        </div>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>		
	</tr>
	<?php foreach ($preparationMethods as $preparationMethod): ?>
	<tr>
            <td class="actions">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $preparationMethod->id), ['class' => 'ajaxLink', 'targetId' => 'editPrepMethodDialog']); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $preparationMethod->id), ['confirm' => __('Are you sure you want to delete {0}?', $preparationMethod->name)]); ?>
            </td>
            <td><?php echo h($preparationMethod->name); ?>&nbsp;</td>
	</tr>
        <?php endforeach; ?>
	</table>
	<?= $this->element('pager') ?>
</div>

