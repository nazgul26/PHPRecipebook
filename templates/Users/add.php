<?php 

use Cake\Core\Configure;

?>
<h2><?php echo __('Create New Account'); ?></h2>

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
	?>
	</fieldset>
    <?= $this->Form->submit(__('Submit')); ?>
    <?= $this->Form->end() ?>
</div>

