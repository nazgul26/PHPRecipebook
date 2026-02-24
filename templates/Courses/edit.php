<div class="courses form">
<?= $this->Form->create($course, array('default' => false, 'targetId' => 'editCourseDialog')) ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->control('name');
?>
<?= $this->Form->submit(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
<?= $this->Flash->render() ?>
