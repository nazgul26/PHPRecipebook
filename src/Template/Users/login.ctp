<script type="text/javascript">
    $(function() {
        $('#username').focus();
    });
</script>
<div class="users form">
<?= $this->Flash->render() ?>
<?php echo $this->Form->create(null); ?>
    <fieldset>
        <legend>
            <?php echo __('Enter your username and password'); ?>
        </legend>
        <?php echo $this->Form->control('username', array('type' => 'text'));
        echo $this->Form->control('password');
    ?>
    <?php echo $this->Html->link(__('Forgot password?'), array('action' => 'reset')); ?>   
    </fieldset>

    <?= $this->Form->submit(__('Login')); ?>
    <?= $this->Form->end() ?>
</div>
