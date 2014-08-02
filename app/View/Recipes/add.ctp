<script type="text/javascript">
    $(function() {

    });
</script>
<div class="actions">
	<ul>
            <li><?php echo $this->Html->link(__('Edit Sources'), array('controller' => 'sources', 'action' => 'index'), array('class' => 'ajaxLink', 'targetId' => 'content')); ?>
            <li><?php echo $this->Html->link(__('Import'), array('controller' => 'import'), array('class' => 'ajaxLink', 'targetId' => 'content')); ?></li>
            <li><?php echo $this->Html->link(__('Export'), array('controller' => 'export'), array('class' => 'ajaxLink', 'targetId' => 'content')); ?></li>
            <li><button id="moreActionLinks">More Actions...</button></li>
	</ul>
        <div style="display: none;">
            <ul id="moreActionLinksContent">
                <li><?php echo $this->Html->link(__('Edit Ethnicities'), array('controller' => 'ethnicities', 'action' => 'index'), array('class' => 'ajaxLink', 'targetId' => 'content')); ?> </li>
                <li><?php echo $this->Html->link(__('Edit Base Types'), array('controller' => 'base_types', 'action' => 'index'), array('class' => 'ajaxLink', 'targetId' => 'content')); ?> </li>
                <li><?php echo $this->Html->link(__('Edit Courses'), array('controller' => 'courses', 'action' => 'index'), array('class' => 'ajaxLink', 'targetId' => 'content')); ?> </li>
                <li><?php echo $this->Html->link(__('Edit Preparation Times'), array('controller' => 'preparation_times', 'action' => 'index'), array('class' => 'ajaxLink', 'targetId' => 'content')); ?> </li>
                <li><?php echo $this->Html->link(__('Edit Difficulties'), array('controller' => 'difficulties', 'action' => 'index'), array('class' => 'ajaxLink', 'targetId' => 'content')); ?> </li>
                <li> </li>
            </ul>
        </div>     
</div>
<div class="recipes form">
<?php echo $this->Form->create('Recipe', array('default' => false)); ?>
	<fieldset>
		<legend><?php echo __('Add Recipe'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('ethnicity_id');
		echo $this->Form->input('base_type_id');
		echo $this->Form->input('course_id');
		echo $this->Form->input('preparation_time_id');
		echo $this->Form->input('difficulty_id');
		echo $this->Form->input('serving_size');
		echo $this->Form->input('directions');
		echo $this->Form->input('comments');
		echo $this->Form->input('source_id');
		echo $this->Form->input('source_description');
		echo $this->Form->input('picture');
		echo $this->Form->input('picture_type');
		echo $this->Form->input('private');
		echo $this->Form->input('system');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

