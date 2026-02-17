<div id="recipeLinkBox">
    <div id="recipeLinksTitle"><?php echo __('Recipe Box')?></div>
    <div id="recipeLinks">
        <?php echo __('By Course') ;?>
        <ul class="recipeBoxList">
            <?php foreach ($courses as $courseKey => $course) {?>
               <li><a href="Recipes/findByCourse/<?php echo $course['id'];?>" class="ajaxLink">
               <?php 
               echo __($courseKey);
               if ($course['count'] > 0) {
                   echo " (" . $course['count'] . ")";
               }
               echo "</a></li>";
            }?>
        </ul>
        <br/>
        <?php echo __('By Base') ;?>
        <ul class="recipeBoxList">
            <?php foreach ($baseTypes as $baseKey => $base) {?>
               <li><a href="Recipes/findByBase/<?php echo $base['id'];?>" class="ajaxLink">
               <?php 
               echo __($baseKey);
               if ($base['count'] > 0) {
                   echo " (" . $base['count'] . ")";
               }
               echo "</a></li>";
            }?>
        </ul>
        <br/>
        <?php echo __('By Prep Method') ;?>
        <ul class="recipeBoxList">
            <?php foreach ($prepMethods as $prepKey => $prepMethod) {?>
               <li><a href="Recipes/findByPrepMethod/<?php echo $prepMethod['id'];?>" class="ajaxLink">
               <?php 
               echo __($prepKey);
               if ($prepMethod['count'] > 0) {
                   echo " (" . $prepMethod['count'] . ")";
               }
               echo "</a></li>";
            }?>
        </ul>
        <br/>
        <?php if ($loggedIn) : ?>
        <div id="addRecipeLink">
            <?php echo $this->Html->link(__('Add A Recipe'), 
                    array('controller' => 'recipes', 'action' => 'edit'), array('class' => 'ajaxLink')); 
             ?> 
        </div>
        <?php endif;?>
    </div>
</div>

