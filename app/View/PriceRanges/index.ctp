<script type="text/javascript">
    $(function() {
        $(document).on("saved.priceRange", function() {
            $('#editPriceRangesDialog').dialog('close');
            ajaxGet('price_ranges');
        });
    });
</script>

<div class="priceRanges index">
	<h2><?php echo __('Price Ranges'); ?></h2>
        
        <div class="actions">
	<ul>
            <li><?php echo $this->Html->link(__('New Price Range'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editPriceRangesDialog'));?></li>
	</ul>
        </div>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
	</tr>
	<?php foreach ($priceRanges as $priceRange): ?>
	<tr>
            <td class="actions">
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $priceRange['PriceRange']['id']),array('class' => 'ajaxLink', 'targetId' => 'editPriceRangesDialog')); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $priceRange['PriceRange']['id']), null, __('Are you sure you want to delete # %s?', $priceRange['PriceRange']['id'])); ?>
            </td>
            <td><?php echo h($priceRange['PriceRange']['name']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
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
