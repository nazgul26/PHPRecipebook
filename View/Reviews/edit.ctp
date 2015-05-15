<?php
$currentRating = isset($this->request->data['Review']['rating']) ? $this->request->data['Review']['rating'] : 0;
$recipeId = $recipe['Recipe']['id'];
?>
<script type="text/javascript">
    $(function() {
        $('.rateit').rateit();
        $('.rateit').rateit('step', 1);
        $('#ReviewEditForm').submit(function() {
            $('#ReviewRating').val($('.rateit').rateit('value'));
        });
    });
</script>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link($recipe['Recipe']['name'], array('controller' => 'recipes', 'action' => 'view', $recipeId), array('class' => 'ajaxNavigation')); ?> </li>
    <li><?php echo $this->Html->link(__('Reviews'), array('controller' => 'reviews', 'action' => 'index', $recipeId), array('class' => 'ajaxNavigation')); ?> </li>
    <li class="active"><?php echo __('Add & Edit');?></li>
</ol>
       

<h2>
  <?php echo __('Review: ') . " " . $recipe['Recipe']['name'];?>  
</h2>

<div class="reviews form">
    <div>
        <label><b>&nbsp;&nbsp;Rating</b></label>
            <div class="rateit"
                 data-rateit-value="<?php echo $currentRating;?>">
            </div> 
    </div>
    <?php echo $this->Form->create('Review') ?>
    <?php
    echo $this->Form->hidden('recipe_id');
    echo $this->Form->input('comments', array('type' => 'textarea'));
    echo $this->Form->hidden('id');
    echo $this->Form->hidden('rating');
    ?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
