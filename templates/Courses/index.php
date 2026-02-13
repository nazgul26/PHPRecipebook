<script type="text/javascript">
    (function() {
        document.addEventListener("saved.course", function() {
            closeModal('editCourseDialog');
            ajaxGet('courses');
        });
    })();
</script>
<div class="courses index">
	<h2><?= __('Courses') ?></h2>
    <div class="actions-bar">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> ' . __('Add Course'), array('action' => 'edit'), array('escape' => false, 'class' => 'btn btn-primary btn-sm ajaxLink', 'targetId' => 'editCourseDialog')) ?>
    </div>
	<table class="table table-hover table-striped align-middle">
	<thead>
	<tr>
        <th class="actions"><?= __('Actions') ?></th>
        <th><?= $this->Paginator->sort('name') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($courses as $course): ?>
	<tr>
        <td class="actions">
            <?= $this->Html->link(__('Edit'), array('action' => 'edit', $course->id), array('class' => 'ajaxLink', 'targetId' => 'editCourseDialog')) ?>
            <?= $this->Form->postLink(__('Delete'), array('action' => 'delete', $course->id), ['confirm' => __('Are you sure you want to delete {0}?', $course->name)]) ?>
        </td>
        <td><?= h($course->name) ?>&nbsp;</td>
	</tr>
    <?php endforeach; ?>
	</tbody>
	</table>
    <?= $this->element('pager') ?>
</div>
