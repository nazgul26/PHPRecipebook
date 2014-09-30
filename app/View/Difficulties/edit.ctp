<script type="text/javascript">
    $(function() {
        $('.difficulties .submit').hide();
    });
</script>
<div class="difficulties form">
<?php echo $this->Form->create('Difficulty', array('default' => false, 'targetId' => 'editDifficultyDialog')); ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->input('name');
?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php echo $this->Session->flash(); ?>
