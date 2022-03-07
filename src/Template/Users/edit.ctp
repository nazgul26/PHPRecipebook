<?php 

use Cake\Core\Configure;

if ($isAdmin) :?>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Users'), array('action' => 'index')); ?></li>
    <li class="active"><?php echo __('Edit');?></li>
</ol>
<?php else : ?>
<h2><?php echo __('Account Settings'); ?></h2>
<?php endif;?>

<div class="users form">
<?php echo $this->Form->create($user); ?>
	<fieldset>
	<?php
            echo $this->Form->hidden('id');
            echo $this->Form->control('username');
            echo $this->Form->control('name');
            echo $this->Form->control('email');
            echo $this->Form->control('password1',array('type'=>'password','label'=>array('text'=>'Password')));
            echo $this->Form->control('password2',array('type'=>'password','label'=>array('text'=>'Confirm password')));
            if ($isAdmin) {
                echo $this->Form->control('access_level', array('options' => Configure::read('AuthEditRoles')));
            } else {
                echo $this->Form->hidden('access_level');
            }
            echo $this->Form->control('meal_plan_start_day', 
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
            echo $this->Form->control('language', array('options' => Configure::read('Languages')));
            echo $this->Form->control('country');
            echo $this->Form->control('last_login',array('disabled' => 'disabled'));
            
	?>
	</fieldset>
    <?= $this->Form->submit(__('Submit')); ?>
    <?= $this->Form->end() ?>
</div>

