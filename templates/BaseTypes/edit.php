<script type="text/javascript">
    (function() {
        var submitEl = document.querySelector('.baseTypes .submit');
        if (submitEl) submitEl.classList.add('d-none');
    })();
</script>
<div class="baseTypes form">
<?= $this->Form->create($baseType, array('default' => false, 'targetId' => 'editBaseTypeDialog')) ?>
<?php
    echo $this->Form->hidden('id');
    echo $this->Form->control('name');
?>
<?= $this->Form->submit(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
<?= $this->Flash->render() ?>
