<script type="text/javascript">
    $(function() {
        setSearchBoxTarget('Locations');
        
        $(document).off("saved.location");
        $(document).on("saved.location", function() {
            $('#editLocationDialog').dialog('close');
            ajaxGet('locations');
        }); 
    });
</script>
<div class="locations index">
	<h2><?php echo __('Locations'); ?></h2>
        <div class="actions">
            <ul>
                    <li><?php echo $this->Html->link(__('New Location'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editLocationDialog')); ?></li>
            </ul>
        </div>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
	</tr>
	<?php foreach ($locations as $location): ?>
	<tr>
            <td class="actions">
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $location->id),['class' => 'ajaxLink', 'targetId' => 'editLocationDialog']); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $location->id), ['confirm'=> __('Are you sure you want to delete "{0}"?', $location->name)]); ?>
            </td>
            <td><?php echo h($location->name); ?>&nbsp;</td>

	</tr>
<?php endforeach; ?>
	</table>
	<?= $this->element('pager') ?>
</div>
