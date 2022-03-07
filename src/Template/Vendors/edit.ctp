<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Online Grocery Vendors'), array('action' => 'index'), array('class' => 'ajaxNavigation')); ?> </li>
    <li class="active"><?php echo __('Add & Edit');?></li>
</ol>
<div class="vendors form">
<?php echo $this->Form->create('Vendor'); ?>
    <?php
            echo $this->Form->input('id');
            echo $this->Form->input('name');
            echo $this->Form->input('home_url');
            echo $this->Form->input('add_url');
    ?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
