<?php
use Cake\Routing\Router;
$baseUrl = Router::url('/');
?>
<script type="text/javascript">
    (function() {
        // Update modal title
        var modalTitle = document.querySelector('#editMealDialog .modal-title');
        if (modalTitle) modalTitle.textContent = 'Meal - <?= $mealDate ?>';

        var recipeInput = document.getElementById('recipeAutocomplete');
        if (recipeInput) {
            initVanillaAutocomplete(recipeInput, {
                source: "<?= $baseUrl ?>Recipes/autoCompleteSearch",
                minLength: 1,
                autoFocus: true,
                select: function(event, ui) {
                    document.querySelector('input[name="recipe_id"]').value = ui.item.id;
                    document.querySelector('input[name="servings"]').value = ui.item.servings;
                    var info = document.getElementById('recipeServingInfo');
                    if (info) {
                        info.innerHTML = "<?= __('recipe serves') ?>: " + ui.item.servings;
                        info.style.display = 'block';
                    }
                    scaleServingsByDays();
                    return false;
                }
            });
        }

        document.getElementById('MealPlanDays')?.addEventListener('change', scaleServingsByDays);
    })();

    function scaleServingsByDays() {
        var daysEl = document.getElementById('MealPlanDays');
        var servingsEl = document.getElementById('MealPlanServings');
        if (!daysEl || !servingsEl) return;
        var days = daysEl.value;
        var servings = servingsEl.value;
        var calculatedServings = servings/days;
        if (calculatedServings > 1) {
            servingsEl.value = servings/days;
        } else {
            servingsEl.value = 1;
        }
    }
</script>

<div class="mealPlans form">
<?= $this->Form->create($mealPlan, ['default' => false, 'targetId' => 'editMealDialog']) ?>
<?php
    echo $this->Form->hidden('id');
    echo $this->Form->control('meal_name_id');
?>
<div class="mb-3">
    <label for="recipeAutocomplete" class="form-label"><?= __('Recipe') ?></label>
    <input type="text"
           class="form-control"
           id="recipeAutocomplete"
           placeholder="<?= __('Enter Recipe Name') ?>"
           value="<?= (isset($mealPlan->recipe->name) ? $mealPlan->recipe->name : "") ?>"/>
    <div id="recipeServingInfo" class="form-text" style="display: none;"></div>
</div>

<?php
    echo $this->Form->hidden('recipe_id');
    echo $this->Form->control('mealday', ['default' => $mealPlan->mealday]);
    echo $this->Form->control('servings');
    echo $this->Form->control('days', array('default' => 1, 'type' => 'number'));
    echo $this->Form->control('skip', ['label' => __('Every other day'), 'type' => 'checkbox', 'default' => true]);
?>
    <?php if (isset($mealPlan->recipe->id)):?>
    <div class="mt-3 d-flex gap-2">
        <?= $this->Html->link(__('View'), array('controller'=>'recipes', 'action' => 'view', $mealPlan->recipe->id), ['class' => 'btn btn-sm btn-outline-primary']) ?>
        <?= $this->Html->link(__('Edit'), array('controller'=>'recipes', 'action' => 'edit', $mealPlan->recipe->id), ['class' => 'btn btn-sm btn-outline-primary']) ?>
    </div>
    <?php endif;?>
<?= $this->Form->submit(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
<?= $this->Flash->render() ?>
