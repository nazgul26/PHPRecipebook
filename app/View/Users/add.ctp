<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password', array('required' => true));
		echo $this->Form->input('name');
                echo $this->Form->input('email');
		echo $this->Form->input('access_level');
		echo $this->Form->input('language');
		echo $this->Form->input('country');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
