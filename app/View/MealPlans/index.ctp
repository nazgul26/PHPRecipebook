<script type="text/javascript">
    $(function() {
        $('#loadToday').click(function() {
            ajaxGet('MealPlans/index/<?php echo date('m-d-Y');?>');
        });
    });
</script>
<div class="mealPlans index">
	<h2><?php echo __('Meal Plan - Weekly'); ?></h2>
        
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
        <div class="dayHeader"><?php echo $day ?>
        </div>
        <?php endforeach; ?>
        <?php for ($i=0; $i < 7; $i++) : ?>
        <div class="dayContent 
            <?php echo ($i == 6) ? "endOfRow" : "";?> 
            <?php echo ($weekList[$i][1] != $currentMonth) ? "nextMonth" : "";?>
            <?php echo ($weekList[$i][1] == $realMonth && $weekList[$i][0] == $realDay && $weekList[$i][2] == $realYear ) ? "currentDay" : "";?>
        ">
            <a href="#"><?php echo $weekList[$i][0];?></a></div>
        <?php endfor; ?>
        </div>
        <div class="clear"></div>
</div>

