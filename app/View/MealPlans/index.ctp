<div class="mealPlans index">
	<h2><?php echo __('Meal Plan - Weekly'); ?></h2>
        <br/>
        <div id="weeklyContainer"/>
	<?php foreach ($weekDays as $day): ?>
        <div class="dayHeader"><?php echo $day ?>
        </div>
        <?php endforeach; ?>
        <?php for ($i=1; $i < 8; $i++) : ?>
        <div class="dayContent <?php echo ($i == 7) ? "endOfRow" : "";?>"><a href="#"><?php echo $i;?></a></div>
        <?php endfor; ?>
        </div>
        <div class="clear"></div>
</div>

