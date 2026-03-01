<?php
$currentRating = isset($review->rating) ? $review->rating : 0;
?>
<script type="text/javascript">
    onAppReady(function() {
        var container = document.querySelector('.rateit');
        if (container) {
            createStarRating(container, {
                value: <?= $currentRating ?>,
                max: 5,
                step: 1,
                readonly: false,
                onRate: function(value) {
                    var input = document.querySelector('input[name="rating"]');
                    if (input) input.value = value;
                }
            });
        }
    });
</script>
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
    <li class="breadcrumb-item"><?= $this->Html->link($recipe->name, array('controller' => 'recipes', 'action' => 'view', $recipeId), array('class' => 'ajaxLink')) ?></li>
    <li class="breadcrumb-item"><?= $this->Html->link(__('Reviews'), array('controller' => 'reviews', 'action' => 'index', $recipeId), array('class' => 'ajaxLink')) ?></li>
    <li class="breadcrumb-item active"><?= __('Add & Edit') ?></li>
</ol>
</nav>

<?= $this->Flash->render() ?>

<h2>
  <?= __('Review: ') . " " . $recipe->name ?>
</h2>

<div class="reviews form">
    <div>
        <label><b>&nbsp;&nbsp;Rating</b></label>
            <div class="rateit"
                 data-rateit-value="<?= $currentRating ?>">
            </div>
    </div>
    <?= $this->Form->create($review, ['name'=>'ReviewEditForm']) ?>
    <?php
    echo $this->Form->hidden('recipe_id');
    echo $this->Form->control('comments', array('type' => 'textarea'));
    echo $this->Form->hidden('id');
    echo $this->Form->hidden('rating');
    ?>
<?= $this->Form->submit(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
