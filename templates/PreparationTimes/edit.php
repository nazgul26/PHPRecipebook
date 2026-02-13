<script type="text/javascript">
    (function() {
        var submitEl = document.querySelector('.preparationTimes .submit');
        if (submitEl) submitEl.classList.add('d-none');
    })();
</script>
<div class="preparationTimes form">
<?= $this->Form->create($preparationTime, array('default' => false, 'targetId' => 'editPrepTimeDialog')) ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->control('name');
?>
<?= $this->Form->submit(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
<?= $this->Flash->render() ?>
