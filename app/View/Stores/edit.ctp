<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Stores '), array('action' => 'index'), array('class' => 'ajaxNavigation')); ?> </li>
    <li class="active"><?php echo __('Add & Edit');?></li>
</ol>
<div class="stores form">
<?php echo $this->Form->create('Store'); ?>
    <?php
            echo $this->Form->hidden('id');
            echo $this->Form->input('name', array('escape' => false));
            echo $this->Form->input('layout');
    ?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
