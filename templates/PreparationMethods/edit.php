<div class="preparationMethods form">
<?= $this->Form->create($preparationMethod, array('default' => false, 'targetId' => 'editPrepMethodDialog')) ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->control('name');
?>
<?= $this->Form->submit(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
<?= $this->Flash->render() ?>
