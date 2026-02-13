<nav aria-label="breadcrumb">
<ol class="breadcrumb">
    <li class="breadcrumb-item"><?= $this->Html->link(__('Online Grocery Vendors'), array('action' => 'index'), array('class' => 'ajaxNavigation')) ?></li>
    <li class="breadcrumb-item active"><?= __('Add & Edit') ?></li>
</ol>
</nav>
<div class="vendors form">
<?= $this->Form->create('Vendor') ?>
    <?php
            echo $this->Form->hidden('id');
            echo $this->Form->control('name');
            echo $this->Form->control('home_url');
            echo $this->Form->control('add_url');
    ?>
<?= $this->Form->submit(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
