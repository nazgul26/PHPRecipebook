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
