<div class="sources form">
<?= $this->Form->create($source, array('default' => false, 'targetId' => 'editSourceDialog')) ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->control('name');
?>
<?= $this->Form->submit(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
<?= $this->Flash->render() ?>
