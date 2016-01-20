<?php echo $this->Session->flash(); ?>
<?php if ($isAdmin) :?>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Users'), array('action' => 'index')); ?></li>
    <li class="active"><?php echo __('Edit');?></li>
</ol>
<?php else : ?>
<h2><?php echo __('Account Settings'); ?></h2>
<?php endif;?>

<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
	<?php
            echo $this->Form->hidden('id');
            echo $this->Form->input('username');
            echo $this->Form->input('name');
            echo $this->Form->input('email');
            echo $this->Form->input('password1',array('type'=>'password','label'=>array('text'=>'Password')));
            echo $this->Form->input('password2',array('type'=>'password','label'=>array('text'=>'Confirm password')));
            if ($isAdmin) {
                echo $this->Form->input('access_level', array('options' => Configure::read('AuthEditRoles')));
            } else {
                echo $this->Form->hidden('access_level');
            }
            echo $this->Form->input('meal_plan_start_day', 
                    array('options' => 
                        array(
                            '0' => __('Sunday'), 
                            '1' => __('Monday'),
                            '2' => __('Tuesday'),
                            '3' => __('Wednesday'),
                            '4' => __('Thursday'),
                            '5' => __('Friday'),
                            '6' => __('Saturday'),
                            )
                        )
                    );
            echo $this->Form->input('language', array('options' => Configure::read('Languages')));
            echo $this->Form->input('country');
            echo $this->Form->input('last_login',array('disabled' => 'disabled'));
            
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>