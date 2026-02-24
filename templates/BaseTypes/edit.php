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
