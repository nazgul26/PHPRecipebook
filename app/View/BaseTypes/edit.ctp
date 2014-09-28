<script type="text/javascript">
    $(function() {
        $('.baseTypes .submit').hide();
    });
 </script>
<div class="baseTypes form">
<?php echo $this->Form->create('BaseType', array('default' => false, 'targetId' => 'editBaseTypeDialog')); ?>
<?php
    echo $this->Form->hidden('id');
    echo $this->Form->input('name');
?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
 <?php echo $this->Session->flash(); ?>
