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
            echo $this->Form->input('language', array('options' => Configure::read('Languages')));
            echo $this->Form->input('copy', array(
                'type' => 'checkbox', 
                'checked'=>true,
                'label'=>array('text'=>'Create with default ingredients')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
