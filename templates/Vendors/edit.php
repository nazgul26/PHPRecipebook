<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Online Grocery Vendors'), array('action' => 'index'), array('class' => 'ajaxNavigation')); ?> </li>
    <li class="active"><?php echo __('Add & Edit');?></li>
</ol>
<div class="vendors form">
<?php echo $this->Form->create('Vendor'); ?>
    <?php
            echo $this->Form->hidden('id');
            echo $this->Form->control('name');
            echo $this->Form->control('home_url');
            echo $this->Form->control('add_url');
    ?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
