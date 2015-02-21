<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Create Account'); ?></legend>
	<?php
            echo $this->Form->input('username');
            echo $this->Form->input('password1',array('type'=>'password','label'=>array('text'=>'Password')));
            echo $this->Form->input('password2',array('type'=>'password','label'=>array('text'=>'Confirm password')));
            echo $this->Form->input('name');
            echo $this->Form->input('email');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
