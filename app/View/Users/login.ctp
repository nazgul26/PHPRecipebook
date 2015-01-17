<div class="users form">
<?php echo $this->Session->flash(); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend>
            <?php echo __('Enter your username and password'); ?>
        </legend>
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
    ?>
    <?php echo $this->Html->link(__('Forgot password?'), array('action' => 'reset')); ?>   
    </fieldset>
<?php echo $this->Form->end(__('Login')); ?>
</div>