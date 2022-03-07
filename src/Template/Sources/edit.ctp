<script type="text/javascript">
    $(function() {
        $('.sources .submit').hide();
    });
</script>
<div class="sources form">
<?php echo $this->Form->create($source, array('default' => false, 'targetId' => 'editSourceDialog')); ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->control('name');
?>
<?= $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end(); ?>
</div>
<?= $this->Flash->render() ?>
