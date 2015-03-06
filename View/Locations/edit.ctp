<script type="text/javascript">
    $(function() {
        $('.locations .submit').hide();
    });
</script>
<div class="locations form">
<?php echo $this->Form->create('Location', array('default' => false, 'targetId' => 'editLocationDialog')); ?>
<?php
      echo $this->Form->hidden('id');
      echo $this->Form->input('name');
?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php echo $this->Session->flash(); ?>
