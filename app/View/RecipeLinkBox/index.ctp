<div id="recipeLinkBox">
    <div id="recipeLinksTitle">Recipe Box</div>
    <div id="recipeLinks">
        <?php echo __('By Course') ;?>
        <ul class="recipeBoxList">
            <?php foreach ($courses as $course) {?>
               <li><a href="Recipes/findByCourse/<?php echo $course['Course']['id'];?>" class="ajaxLink">
               <?php echo $course['Course']['name'];
               if ($course['Course']['count'] > 0) {
                   echo " (" . $course['Course']['count'] . ")";
               }
               echo "</a></li>";
            }?>
        </ul>
        <br/>
        <?php echo __('By Base') ;?>
        <ul class="recipeBoxList">
            <?php foreach ($baseTypes as $base) {?>
               <li><a href="Recipes/findByBase/<?php echo $base['BaseType']['id'];?>" class="ajaxLink">
               <?php echo $base['BaseType']['name'];
               if ($base['BaseType']['count'] > 0) {
                   echo " (" . $base['BaseType']['count'] . ")";
               }
               echo "</a></li>";
            }?>
        </ul>
        <br/>
        <?php echo __('By Prep Method') ;?>
        <ul class="recipeBoxList">
            <?php foreach ($prepMethods as $prepMethod) {?>
               <li><a href="Recipes/findByPrepMethod/<?php echo $prepMethod['PreparationMethod']['id'];?>" class="ajaxLink">
               <?php echo $prepMethod['PreparationMethod']['name'];
               if ($prepMethod['PreparationMethod']['count'] > 0) {
                   echo " (" . $prepMethod['PreparationMethod']['count'] . ")";
               }
               echo "</a></li>";
            }?>
        </ul>
        <br/>
        <?php if ($loggedIn) : ?>
        <div id="addRecipeLink">
            <?php echo $this->Html->link(__('Add A Recipe'), 
                    array('controller' => 'recipes', 'action' => 'edit'), array('class' => 'ajaxNavigation')); 
             ?> 
        </div>
        <?php endif;?>
    </div>
</div>

