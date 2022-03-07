<?php echo $this->Session->flash(); ?>
<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
            <legend><?php echo __('Reset Password'); ?></legend>
            <?php echo __("Enter a new password to reset the account '") . $user['User']['username'];?>'<br/><br/>
            <?php
                echo $this->Form->input('password1',array('required' => true, 'type'=>'password','label'=>array('text'=>'Password')));
                echo $this->Form->input('password2',array('required' => true, 'type'=>'password','label'=>array('text'=>'Confirm password')));
                echo $this->Form->hidden('token', array('default' => $token));
            ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>