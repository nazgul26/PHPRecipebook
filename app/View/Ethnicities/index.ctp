<script type="text/javascript">
    $(function() {   
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
            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $ethnicity['Ethnicity']['id']), array('class' => 'ajaxLink', 'targetId' => 'editEthnicityDialog')); ?>
            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $ethnicity['Ethnicity']['id']), null, __('Are you sure you want to delete %s?', $ethnicity['Ethnicity']['name'])); ?>
        </td>
        <td><?php echo h($ethnicity['Ethnicity']['name']); ?>&nbsp;</td>
    </tr>
    <?php endforeach; ?>
    </table>
    <p>
    <?php
    echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}')));
    ?>	</p>
    <div class="paging">
    <?php
            echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
    </div>
</div>
