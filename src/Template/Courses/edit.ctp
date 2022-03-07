<script type="text/javascript">
    $(function() {
        $('.courses .submit').hide();
    });
</script>
<div class="courses form">
<?php echo $this->Form->create($course, array('default' => false, 'targetId' => 'editCourseDialog')); ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->input('name');
?>
<?= $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end(); ?>
</div>
<?= $this->Flash->render() ?>
