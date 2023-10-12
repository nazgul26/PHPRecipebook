<script type="text/javascript">
    $(function() {
        $('.preparationTimes .submit').hide();
    });
</script>
<div class="preparationTimes form">
<?php echo $this->Form->create($preparationTime, array('default' => false, 'targetId' => 'editPrepTimeDialog')); ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->control('name');
?>
<?= $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end(); ?>
</div>
<?= $this->Flash->render() ?>
