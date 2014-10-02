<script type="text/javascript">
    $(function() {
        $('.preparationMethods .submit').hide();
    });
</script>
<div class="preparationMethods form">
<?php echo $this->Form->create('PreparationMethod', array('default' => false, 'targetId' => 'editPrepMethodDialog')); ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->input('name');
?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php echo $this->Session->flash(); ?>
