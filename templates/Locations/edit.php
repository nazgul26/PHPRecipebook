<script type="text/javascript">
    (function() {
        var submitEl = document.querySelector('.locations .submit');
        if (submitEl) submitEl.classList.add('d-none');
    })();
</script>
<div class="locations form">
<?= $this->Form->create($location, array('default' => false, 'targetId' => 'editLocationDialog')) ?>
<?php
      echo $this->Form->hidden('id');
      echo $this->Form->control('name');
?>
<?= $this->Form->submit(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
<?= $this->Flash->render() ?>
