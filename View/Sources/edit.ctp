<script type="text/javascript">
    $(function() {
        $('.sources .submit').hide();
    });
</script>
<div class="sources form">
<?php echo $this->Form->create('Source', array('default' => false, 'targetId' => 'editSourceDialog')); ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->input('name');
        echo $this->Form->input('description');
        echo $this->Form->input('user_id');
?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php echo $this->Session->flash(); ?>
