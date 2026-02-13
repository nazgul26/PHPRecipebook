<script type="text/javascript">
    (function() {
        var usernameEl = document.getElementById('username');
        if (usernameEl) usernameEl.focus();
    })();
</script>
<div class="users form">
<?= $this->Flash->render() ?>
<?= $this->Form->create(null) ?>
    <fieldset>
        <legend>
            <?= __('Enter your username and password') ?>
        </legend>
        <?= $this->Form->control('username', array('type' => 'text')) ?>
        <?= $this->Form->control('password') ?>
    <?= $this->Html->link(__('Forgot password?'), array('action' => 'reset')) ?>
    </fieldset>

    <?= $this->Form->submit(__('Login')) ?>
    <?= $this->Form->end() ?>
</div>
