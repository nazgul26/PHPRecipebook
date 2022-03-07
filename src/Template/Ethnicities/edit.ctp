<script type="text/javascript">
    $(function() {
        $('.ethnicities .submit').hide();
    });
</script>
<div class="ethnicities form">
<?php echo $this->Form->create($ethnicity, array('default' => false, 'targetId' => 'editEthnicityDialog')); ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->input('name');
?>
<?= $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end(); ?>
</div>
<?= $this->Flash->render() ?>
