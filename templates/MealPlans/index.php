<script type="text/javascript">
    setSearchBoxTarget('Recipes');

    document.getElementById('loadToday')?.addEventListener('click', function() {
        ajaxGet('MealPlans/index/<?= date('m-d-Y') ?>');
    });

    document.addEventListener("saved.meal", function() {
        closeModal('editMealDialog');
        ajaxGet('MealPlans/index/<?= $date ?>');
    });
</script>
<h2><?= __('Meal Plan - Weekly') ?></h2>
<div class="actions-bar">
    <?= $this->Html->link('<i class="bi bi-cart-plus"></i> ' . __('Add to Shopping List'), array('action' => 'addToShoppingList', $date), array('escape' => false, 'class' => 'btn btn-primary btn-sm ajaxLink')) ?>
</div>
<div class="mealPlans index">
    <div class="d-flex align-items-center gap-3 mb-3">
        <?= $this->Html->link('<i class="bi bi-chevron-left"></i>',
                array('action' => 'index', $previousWeek[1].'-'.$previousWeek[0].'-'.$previousWeek[2]),
                array('class' => 'ajaxNavigation btn btn-outline-primary btn-sm', 'escape' => false)) ?>

        <strong><?= $startDate ?> - <?= $endDate ?></strong>

        <?= $this->Html->link('<i class="bi bi-chevron-right"></i>',
                array('action' => 'index', $nextWeek[1].'-'.$nextWeek[0].'-'.$nextWeek[2]),
                array('class' => 'ajaxNavigation btn btn-outline-primary btn-sm', 'escape' => false)) ?>
        <button id="loadToday" class="btn btn-outline-primary btn-sm"><?= __('Today') ?></button>
    </div>

    <div id="weeklyContainer">
    <?php
    $day = $startDayOfWeek;
    for ($i=0; $i<7; $i++) : ?>
        <div class="dayHeader"><?= $weekDays[$day] ?></div>
        <?php
		if ($day == 6) $day = 0;
		else $day++;
	endfor;?>

    <?php for ($i=0; $i < 7; $i++) : ?>
    <div class="dayContent
        <?= ($i == 6) ? "endOfRow" : "" ?>
        <?= ($weekList[$i][1] != $currentMonth) ? "nextMonth" : "" ?>
        <?= ($weekList[$i][1] == $realMonth && $weekList[$i][0] == $realDay && $weekList[$i][2] == $realYear ) ? "currentDay" : "" ?>
    ">
        <?php
        $dateIndex = $weekList[$i][2] . "-" . str_pad($weekList[$i][1], 2, "0",STR_PAD_LEFT) . "-" . str_pad($weekList[$i][0], 2, "0",STR_PAD_LEFT);
        echo $this->Html->link($weekList[$i][0], array('action' => 'edit', "undefined", $dateIndex), array('class' => 'ajaxLink', 'targetId' => 'editMealDialog'));?>
        <br/>
        <?php
        if (isset($mealList[$dateIndex])) {
            foreach ($mealList[$dateIndex] as $meal) {
                $mealPlanId = $meal->id;
                $mealName = $meal->recipe->name;
                echo "<div class='mealType mealType" . $meal->meal_name->id . "'>";
                echo $this->Form->postLink('<i class="bi bi-x-circle"></i>', array('action' => 'delete', $mealPlanId), ['escape' => false, 'confirm' => __('Are you sure you want to delete meal "%s"?', $mealName), 'style' => 'float:left; margin-right: 4px;']);
                echo $this->Html->link($mealName, array('action' => 'edit', $mealPlanId, $dateIndex),
                        array('class' => 'ajaxLink', 'targetId' => 'editMealDialog'));
                echo "</div>";
            }
        } ?>
    </div>
    <?php endfor; ?>

    <div class="clear"></div>
</div>
<br/>
<div class="mealLegend">
    <div><strong><?= __('Legend') ?></strong></div>
    <div class="mealType mealType1"><?= __('Breakfast') ?></div>
    <div class="mealType mealType3"><?= __('Lunch') ?></div>
    <div class="mealType mealType5"><?= __('Dinner') ?></div>
    <div class="mealType mealType6"><?= __('Dessert') ?></div>
</div>
