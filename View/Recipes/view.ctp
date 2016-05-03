<?php 
$recipeId = $recipe['Recipe']['id'];
$scale = 1; // default no scaling
$numberOfReviews = 0;
$averageRating = 0;
if (isset($servings)) {
    $scale = $servings / $recipe['Recipe']['serving_size'];
} else {
    $servings = $recipe['Recipe']['serving_size'];
}

if (isset($recipe['Review'])) {
    $numberOfReviews = count($recipe['Review']);
    if ($numberOfReviews > 0) {
        foreach ($recipe['Review'] as $review) {
            $averageRating += $review['rating'];
        }
        $averageRating = $averageRating / $numberOfReviews;
    }
}
?>
<script type="text/javascript">
    $(function() {
        $('#qtipSource').qtip({ // Grab some elements to apply the tooltip to
            content: {
                text: $('#qtipSourceData').html()
            },
            style: { classes: 'qtip-dark' }
        });
        
        $('#viewRefresh').click(function() {
            var newServings = $('#viewServings').val();
            ajaxNavigate("recipes/view/<?php echo $recipeId;?>/" + newServings);
            return false;
        })
        
        $('#doubleRefresh').click(function() {
            var newServings = $('#viewServings').val() * 2;
            ajaxNavigate("recipes/view/<?php echo $recipeId;?>/" + newServings);
            return false;
        })
        
        $('.rateit').rateit();
    });
    
    function loadImage(imageUrl, caption) {
        $('#selectedRecipeImage img').attr('src', imageUrl).attr('title', caption);
        return false;
    }
</script>
<div class="recipes view">
    <h2><?php echo h($recipe['Recipe']['name']); ?></h2>
        <div class="rateit" 
             data-rateit-value="<?php echo $averageRating;?>" 
             title="<?php echo __("$averageRating out of 5 stars");?>"
             data-rateit-ispreset="true" 
             data-rateit-readonly="true">
        </div> 
        <?php echo $this->Html->link($numberOfReviews . ' ' . __('Review(s)'), array('controller'=>'reviews', 'action' => 'index', $recipeId)); ?>
        <div class="actions">
            <ul>
                <?php if ($loggedIn):?>
                <li><?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $recipeId)); ?></li>
                <li><?php echo $this->Html->link(__('Add Review'), array('controller'=>'reviews', 'action' => 'edit', $recipeId)); ?></li>
                <li><?php echo $this->Html->link(__('Add to shopping list'), array('controller' => 'shoppingLists', 'action' => 'addRecipe', 0, $recipeId, $servings)); ?></li>
                <?php endif;?>
                <li><a href="#" onclick="window.print();"><?php echo __('Print');?></a></li>
                <?php if ($loggedIn) :?>
                <li><button id="moreActionLinks">More Actions...</button></li>
                <?php endif;?>
            </ul>
            <div style="display: none;">
                <ul id="moreActionLinksContent">
                    <li><?php echo $this->Html->link(__('Import'), array('controller' => 'import', 'action' => 'index'), array('class' => 'ajaxNavigation')); ?> </li>
                    <li><?php echo $this->Html->link(__('Export'), array('controller' => 'export', 'action' => 'edit'), array('class' => 'ajaxNavigation')); ?> </li>
                </ul>
            </div> 
        </div>
	<dl class="float50Section">
		<dt><?php echo __('Ethnicity'); ?></dt>
		<dd>
                        <?php echo h($recipe['Ethnicity']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Base Type'); ?></dt>
		<dd>
                        <?php echo h($recipe['BaseType']['name']); ?>
                        &nbsp;
		</dd>
		<dt><?php echo __('Course'); ?></dt>
		<dd>
			<?php echo h($recipe['Course']['name']); ?>
                        &nbsp;
		</dd>
		<dt><?php echo __('Preparation Time'); ?></dt>
		<dd>
			<?php echo h($recipe['PreparationTime']['name']); ?>
                        &nbsp;
		</dd>
		<dt><?php echo __('Difficulty'); ?></dt>
		<dd>
			<?php echo h($recipe['Difficulty']['name']); ?>
                        &nbsp;
		</dd>
		<dt><?php echo __('Serving Size'); ?></dt>
		<dd>
                    <input type="text" id="viewServings" value="<?php echo $servings;?>"/>
                    <a id="viewRefresh" href="#"><?php echo __('Refresh');?></a> /
                    <a id="doubleRefresh" href="#"><?php echo __('Double it');?></a>
		</dd>
        </dl>

        <dl class="float50Section">
		<dt><?php echo __('Comments'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['comments']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Source'); ?></dt>
		<dd>
                    <a href="#" onclick="return false;" id="qtipSource"><?php echo $recipe['Source']['name'];?></a>
                    <div id="qtipSourceData" class="hide">
                        <?php echo $recipe['Source']['description'];?>
                    </div>
                    &nbsp;
		</dd>
		<dt><?php echo __('Source Description'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['source_description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Modified'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
                    <?php echo h($recipe['User']['name']); ?>
		</dd>
	</dl>
        
        <div class="clear"/><br/>
        <hr/>
        <br/>
            <?php 
                $imageCount = (isset($recipe) && $recipe['Image'])? count($recipe['Image']) : 0;
                if ($imageCount > 0) {
                    echo '<div class="float50Section">';

                } else {
                    echo  '<div style="width: 100%;">';
                }
            ?>
            <b><?php echo __('Ingredients'); ?></b>
            <pre><?php for ($i = 0; $i < count($recipe['IngredientMapping']); $i++) {
                            $quantity = $recipe['IngredientMapping'][$i]['quantity'];
                            if (isset($scale)) $quantity *= $scale;
                            $quantity = $this->Fraction->toFraction($quantity);
                            $unit = $recipe['IngredientMapping'][$i]['Unit']['name'];
                            $ingredientName = $recipe['IngredientMapping'][$i]['Ingredient']['name'];
                            $qualifier = $recipe['IngredientMapping'][$i]['qualifier'];
                            $optional = $recipe['IngredientMapping'][$i]['optional'] ? __('(optional)') : "";
                            echo "$quantity $unit $qualifier $ingredientName <i>$optional</i><br/>";
                        }?>
            </pre>
        </div>
        <div class="float50Section" id="imagePreview">
            <?php 
            $baseUrl = Router::url('/');
            if ($imageCount > 0) {
                $imageName = $recipe['Image'][0]['attachment'];
                $imageDir = $recipe['Image'][0]['dir'];
                $imagePreview =  preg_replace('/(.*)\.(.*)/i', 'preview_${1}.$2', $imageName);
                $imageCaption = $recipe['Image'][0]['name'];
                
                echo "<div id='selectedRecipeImage'>";
                echo '<a href="#"><img src="' . $baseUrl . 'files/image/attachment/' .  $imageDir . '/' . 
                            $imagePreview . '" title="' . $imageCaption . '"/></a><br/>';
                echo "</div>";
                echo "<div id='previewImageOptions'>";
                if ($imageCount > 1) {
                    
                    for ($imageIndex = 0; $imageIndex < $imageCount; $imageIndex++) {
                        $imageName = $recipe['Image'][$imageIndex]['attachment'];
                        $imageDir = $recipe['Image'][$imageIndex]['dir'];
                        $imageThumb =  preg_replace('/(.*)\.(.*)/i', 'thumb_${1}.$2', $imageName);
                        $imagePreview =  preg_replace('/(.*)\.(.*)/i', 'preview_${1}.$2', $imageName);
                        $imageCaption = $recipe['Image'][$imageIndex]['name'];
                        
                        $previewUrl = $baseUrl . 'files/image/attachment/' .  $imageDir . '/' . $imagePreview;
                        echo '<a href="#" onclick=\'loadImage("' . $previewUrl. '", "'. $imageCaption . '");\'><img src="' . $baseUrl . 'files/image/attachment/' .  $imageDir . '/' . 
                                $imageThumb . '" title="' . $imageCaption . '"/></a>';
                    }
                    
                }
                echo "</div>";
            }?>
        </div> 
        <div class="clear"/><br/>    
        <div style="width: 100%;">
            <b><?php echo __('Directions'); ?></b>

            <pre><?php echo h($recipe['Recipe']['directions']); ?></pre>
        </div>
        
        <?php foreach ($recipe['RelatedRecipe'] as $related) :?>
            <div class="clear"/><br/> 
            <div class="relatedRecipe">
                <span>
                <?php echo $this->Html->link($related['Related']['name'], array('controller' => 'recipes', 'action' => 'view', $related['recipe_id']), 
                                array('class' => 'ajaxNavigationLink')); ?>
                        (<?php echo $related['required'] == "1" ? "required" : __('optional');?>)
                </span>   
                <div class="float50Section">
                    <b><?php echo __('Ingredients'); ?></b>
                    
                    <pre><?php for ($i = 0; $i < count($related['Related']['IngredientMapping']); $i++) {
                            $quantity = $related['Related']['IngredientMapping'][$i]['quantity'];
                            if (isset($scale)) $quantity *= $scale;
                            $quantity = $this->Fraction->toFraction($quantity);
                            $unit = $related['Related']['IngredientMapping'][$i]['Unit']['name'];
                            $ingredientName = $related['Related']['IngredientMapping'][$i]['Ingredient']['name'];
                            echo $quantity . " " . $unit . " " . $ingredientName . "<br/>";
                        }?></pre>
                </div>
                <div class="float50Section">
                    <!-- placeholder for related recipe image -->
                </div>
                <div class="clear"/><br/>    
                <div style="width: 100%;">
                    <b><?php echo __('Directions'); ?></b>
                    <pre><?php echo $related['Related']['directions'];?></pre>
                </div>
            </div>
        <?php endforeach; ?>
        </pre>
</div>
