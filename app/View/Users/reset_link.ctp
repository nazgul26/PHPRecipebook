<?php echo $this->Session->flash(); ?>
<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Reset Password'); ?></legend>
	<?php
		echo $this->Form->input('password', array('required' => true, 'label' => 'New Password'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>