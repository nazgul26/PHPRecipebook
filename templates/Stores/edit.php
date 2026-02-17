<nav aria-label="breadcrumb">
<ol class="breadcrumb">
    <li class="breadcrumb-item"><?= $this->Html->link(__('Stores'), array('action' => 'index'), array('class' => 'ajaxLink')) ?></li>
    <li class="breadcrumb-item active"><?= __('Add & Edit') ?></li>
</ol>
</nav>
<div class="stores form">
<?= $this->Form->create($store) ?>
    <?php
            echo $this->Form->hidden('id');
            echo $this->Form->control('name', array('escape' => false));
            echo $this->Form->control('layout');
    ?>
    <?= $this->Form->submit(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
<?= $this->Flash->render() ?>
