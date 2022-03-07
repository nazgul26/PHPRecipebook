<script type="text/javascript">
    $(function() {
        $('.baseTypes .submit').hide();
    });
 </script>
<div class="baseTypes form">
<?php echo $this->Form->create($baseType, array('default' => false, 'targetId' => 'editBaseTypeDialog')); ?>
<?php
    echo $this->Form->hidden('id');
    echo $this->Form->input('name');
?>
<?= $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end(); ?>
</div>
<?= $this->Flash->render() ?>
