<script type="text/javascript">
    $(function() {
        $('#loadToday').click(function() {
            ajaxGet('MealPlans/index/<?php echo date('m-d-Y');?>');
        });
    });
</script>
<div class="mealPlans index">
	<h2><?php echo __('Meal Plan - Weekly'); ?></h2>
<pre>
<?php echo print_r($mealList);?>
</pre>
        <?php echo $this->element('sql_dump'); ?>
        <?php echo $this->Html->link('<', 
                array('action' => 'index', $previousWeek[1].'-'.$previousWeek[0].'-'.$previousWeek[2]), 
                array('class' => 'ajaxNavigation calendarNavigation')); ?>
                    
        <?php echo $startDate;?> - <?php echo $endDate;?>
        
        <?php echo $this->Html->link('>', 
                array('action' => 'index', $nextWeek[1].'-'.$nextWeek[0].'-'.$nextWeek[2]), 
                array('class' => 'ajaxNavigation calendarNavigation')); ?>
        <button id="loadToday"><?php echo __('Today');?></button>
        
        <br/><br/>
        <div id="weeklyContainer">
	<?php foreach ($weekDays as $day): ?>
        <div class="dayHeader">
            <?php echo $day;?>
        </div>
        <?php endforeach; ?>
        <?php for ($i=0; $i < 7; $i++) : ?>
        <div class="dayContent 
            <?php echo ($i == 6) ? "endOfRow" : "";?> 
            <?php echo ($weekList[$i][1] != $currentMonth) ? "nextMonth" : "";?>
            <?php echo ($weekList[$i][1] == $realMonth && $weekList[$i][0] == $realDay && $weekList[$i][2] == $realYear ) ? "currentDay" : "";?>
        ">
            <?php echo $this->Html->link($weekList[$i][0], array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editMealDialog'));?>
            <br/>
                <?php 
                $dateIndex = $weekList[$i][2] . "-" . str_pad($weekList[$i][1], 2, "0",STR_PAD_LEFT) . "-" . str_pad($weekList[$i][0], 2, "0",STR_PAD_LEFT);
                if (isset($mealList[$dateIndex])) {
                echo $mealList[$dateIndex]["Recipe"]["name"];
            } ?>
        </div>
        <?php endfor; ?>
        
        <div class="clear"></div>
</div>

