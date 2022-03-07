<script type="text/javascript">
    $(function() {
        $(document).on("saved.source", function() {
            $('#editSourceDialog').dialog('close');
            ajaxGet('sources');
        }); 
    });
</script>
<div class="sources index">
	<h2><?php echo __('Sources'); ?></h2>
        <div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add Source'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editSourceDialog')); ?></li>
	</ul>
</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
	</tr>
	<?php foreach ($sources as $source): ?>
	<tr>
            <td class="actions">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $source->id), array('class' => 'ajaxLink', 'targetId' => 'editSourceDialog')); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $source->id), ['confirm' => __('Are you sure you want to delete %s?', $source->name)]); ?>
            </td>
            <td><?php echo h($source->name); ?>&nbsp;</td>
	</tr>
        <?php endforeach; ?>
	</table>
	<?= $this->element('pager') ?>
</div>
