<div class="import index">
    <h2><?php echo __('Import Recipes'); ?></h2>
    <p><?= __('To import a meal master format file, browse for it and press submit to import.  Duplicate recipes names will not be imported.')?>
    <div class="notice">
            <?= __('Imported ingredients that do not exactly match existing ingredient names will be created as new ingredients.')?>
    </div>
    <?= $this->Form->create('MealMaster') ?>
    <?= $this->Form->hidden('id') ?>
    <?= $this->Form->file('name')?>
    <?= $this->Form->end(__('Submit')) ?>
</div>
<?php echo $this->Session->flash(); ?>
