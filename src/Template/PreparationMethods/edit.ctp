<script type="text/javascript">
    $(function() {
        $('.preparationMethods .submit').hide();
    });
</script>
<div class="preparationMethods form">
<?php echo $this->Form->create($preparationMethod, array('default' => false, 'targetId' => 'editPrepMethodDialog')); ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->input('name');
?>
<?= $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end(); ?>
</div>
<?= $this->Flash->render() ?>
