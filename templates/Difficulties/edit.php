<script type="text/javascript">
    (function() {
        var submitEl = document.querySelector('.difficulties .submit');
        if (submitEl) submitEl.classList.add('d-none');
    })();
</script>
<div class="difficulties form">
<?= $this->Form->create($difficulty, array('default' => false, 'targetId' => 'editDifficultyDialog')) ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->control('name');
?>
<?= $this->Form->submit(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
<?= $this->Flash->render() ?>
