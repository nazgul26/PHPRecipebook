<script type="text/javascript">
    $(function() {
        $('.courses .submit').hide();
    });
</script>
<div class="courses form">
<?php echo $this->Form->create('Course', array('default' => false, 'targetId' => 'editCourseDialog')); ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->input('name');
?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php echo $this->Session->flash(); ?>
