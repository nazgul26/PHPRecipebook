<script type="text/javascript">
    $(function() {
        $(document).on("saved.course", function() {
            $('#editCourseDialog').dialog('close');
            ajaxGet('courses');
        }); 
    });
</script>
<div class="courses index">
	<h2><?php echo __('Courses'); ?></h2>
        <div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add Course'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editCourseDialog')); ?></li>
	</ul>
</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
	</tr>
	<?php foreach ($courses as $course): ?>
	<tr>
            <td class="actions">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $course['Course']['id']), array('class' => 'ajaxLink', 'targetId' => 'editCourseDialog')); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $course['Course']['id']), null, __('Are you sure you want to delete %s?', $course['Course']['name'])); ?>
            </td>
            <td><?php echo h($course['Course']['name']); ?>&nbsp;</td>
	</tr>
        <?php endforeach; ?>
	</table>
	<p>
	<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}')	));	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
