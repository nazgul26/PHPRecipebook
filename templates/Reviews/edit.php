<?php
$currentRating = isset($review->rating) ? $review->rating : 0;
?>
<script type="text/javascript">
    $(function() {
        $('.rateit').rateit();
        $('.rateit').rateit('step', 1);
        $('.rateit').bind('rated', function (event, value) { 
            $('input[name="rating"]').val(value);
        });
    });
</script>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link($recipe->name, array('controller' => 'recipes', 'action' => 'view', $recipeId), array('class' => 'ajaxNavigation')); ?> </li>
    <li><?php echo $this->Html->link(__('Reviews'), array('controller' => 'reviews', 'action' => 'index', $recipeId), array('class' => 'ajaxNavigation')); ?> </li>
    <li class="active"><?php echo __('Add & Edit');?></li>
</ol>
       
<?= $this->Flash->render() ?>

<h2>
  <?php echo __('Review: ') . " " . $recipe->name;?>  
</h2>

<div class="reviews form">
    <div>
        <label><b>&nbsp;&nbsp;Rating</b></label>
            <div class="rateit"
                 data-rateit-value="<?php echo $currentRating;?>">
            </div> 
    </div>
    <?php echo $this->Form->create($review, ['name'=>'ReviewEditForm']) ?>
    <?php
    echo $this->Form->hidden('recipe_id');
    echo $this->Form->control('comments', array('type' => 'textarea'));
    echo $this->Form->hidden('id');
    echo $this->Form->hidden('rating');
    ?>
<?= $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end(); ?>
</div>
