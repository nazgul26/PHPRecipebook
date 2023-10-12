<script type="text/javascript">
    $(function() {   
        $(document).off("saved.ethnicity");
        $(document).on("saved.ethnicity", function() {
            $('#editEthnicityDialog').dialog('close');
            ajaxGet('ethnicities');
        });
        
    });
</script>
<div class="ethnicities index">
    <h2><?php echo __('Ethnicities'); ?></h2>
    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('Add Ethnicity'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editEthnicityDialog'));?></li>
        </ul>
    </div>
    <table cellpadding="0" cellspacing="0">
    <tr>
        <th class="actions"><?php echo __('Actions'); ?></th>
        <th><?php echo $this->Paginator->sort('name'); ?></th>
    </tr>
    <?php foreach ($ethnicities as $ethnicity): ?>
    <tr>
        <td class="actions">
            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $ethnicity->id), array('class' => 'ajaxLink', 'targetId' => 'editEthnicityDialog')); ?>
            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $ethnicity->id), ['confirm' => __('Are you sure you want to delete {0}?', $ethnicity->name)]); ?>
        </td>
        <td><?php echo h($ethnicity->name); ?>&nbsp;</td>
    </tr>
    <?php endforeach; ?>
    </table>
    <?= $this->element('pager') ?>
</div>
