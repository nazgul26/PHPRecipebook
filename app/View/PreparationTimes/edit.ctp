<script type="text/javascript">
    $(function() {
        $('.preparationTimes .submit').hide();
    });
</script>
<div class="preparationTimes form">
<?php echo $this->Form->create('PreparationTime', array('default' => false, 'targetId' => 'editPrepTimeDialog')); ?>
<?php
        echo $this->Form->input('id');
        echo $this->Form->input('name');
?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php echo $this->Session->flash(); ?>
