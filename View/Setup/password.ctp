<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__d('setup','Setup'), array('action' => 'index')); ?></li>
    <li><?php echo $this->Html->link(__d('setup','Database'), array('action' => 'database')); ?></li>
    <li class="active"><?php echo __d('setup','Admin Password');?></li>
</ol>
<spacer/>
<?php echo $this->Session->flash(); ?>
<p>
    <?php echo __d('setup','Enter a new Administrator password.  This username and password will be used to setup other users');?>
</p>
<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
            <div class="input password">
                <label for="UserPassword1">Username</label>
                <b>admin</b>
            </div>
            <?php
                echo $this->Form->input('password1',array('type'=>'password','label'=>array('text'=>'Password')));
                echo $this->Form->input('password2',array('type'=>'password','label'=>array('text'=>'Confirm password'))); 
                echo $this->Form->input('email'); 
            ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>