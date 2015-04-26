<div class="import index">
    <h2><?php echo __('Import Recipes'); ?></h2>
    <p><?php echo __('To import a meal master format file, browse for it and press submit to import.  Duplicate recipes names will not be imported.')?>
    <div class="notice">
            <?php echo __('Imported ingredients that do not exactly match existing ingredient names will be created as new ingredients.')?>
    </div>
    <?php echo $this->Form->create('MealMaster', array('type' => 'file')) ?>
    <?php echo $this->Form->hidden('id') ?>
    <?php echo $this->Form->file('mm_file')?>
    <?php echo $this->Form->end(__('Submit')) ?>
</div>
<?php echo $this->Session->flash(); ?>
