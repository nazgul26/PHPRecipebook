<script type="text/javascript">
    $(function() {
        $('.locations .submit').hide();
    });
</script>
<div class="locations form">
<?php echo $this->Form->create($location, array('default' => false, 'targetId' => 'editLocationDialog')); ?>
<?php
      echo $this->Form->hidden('id');
      echo $this->Form->control('name');
?>
	</fieldset>
<?= $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end(); ?>
</div>
<?= $this->Flash->render() ?>
