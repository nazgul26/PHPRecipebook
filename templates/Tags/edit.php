<script type="text/javascript">
    (function() {
        var submitEl = document.querySelector('.tags .submit');
        if (submitEl) submitEl.classList.add('d-none');
    })();
</script>

<div class="tags form">
<?= $this->Form->create($tag, array('default' => false, 'targetId' => 'editTagDialog')) ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->control('name');
        echo $this->Form->hidden('user_id');
?>
<?= $this->Form->submit(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
<?= $this->Flash->render() ?>
