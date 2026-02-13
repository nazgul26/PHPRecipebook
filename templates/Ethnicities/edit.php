<script type="text/javascript">
    (function() {
        var submitEl = document.querySelector('.ethnicities .submit');
        if (submitEl) submitEl.classList.add('d-none');
    })();
</script>
<div class="ethnicities form">
<?= $this->Form->create($ethnicity, array('default' => false, 'targetId' => 'editEthnicityDialog')) ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->control('name');
?>
<?= $this->Form->submit(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
<?= $this->Flash->render() ?>
