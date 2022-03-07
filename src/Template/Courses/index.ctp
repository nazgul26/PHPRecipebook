<script type="text/javascript">
    $(function() {
		$(document).off("saved.course");
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
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $course->id), array('class' => 'ajaxLink', 'targetId' => 'editCourseDialog')); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $course->id), ['confirm' => __('Are you sure you want to delete {0}?', $course->name)]); ?>
            </td>
            <td><?php echo h($course->name); ?>&nbsp;</td>
	</tr>
        <?php endforeach; ?>
	</table>
    <?= $this->element('pager') ?>
</div>
