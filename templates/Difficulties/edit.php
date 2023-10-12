<script type="text/javascript">
    $(function() {
        $('.difficulties .submit').hide();
    });
</script>
<div class="difficulties form">
<?php echo $this->Form->create($difficulty, array('default' => false, 'targetId' => 'editDifficultyDialog')); ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->control('name');
?>
<?= $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end(); ?>
</div>
<?= $this->Flash->render() ?>