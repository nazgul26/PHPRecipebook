<?php 
use Cake\Routing\Router;

$recipeId = $recipe->id;
$scale = 1; // default no scaling
$numberOfReviews = 0;
$averageRating = 0;
if (isset($servings)) {
    $scale = $servings / $recipe->serving_size;
} else {
    $servings = $recipe->serving_size;
}

if (isset($recipe->reviews)) {
    $numberOfReviews = count($recipe->reviews);
    if ($numberOfReviews > 0) {
        foreach ($recipe->reviews as $review) {
            $averageRating += $review->rating;
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
    <h2><?php echo h($recipe->name); ?></h2>
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
                        <?php echo h($recipe->ethnicity->name); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Base Type'); ?></dt>
		<dd>
                        <?php echo h($recipe->base_type->name); ?>
                        &nbsp;
		</dd>
		<dt><?php echo __('Course'); ?></dt>
		<dd>
			<?php echo h($recipe->course->name); ?>
                        &nbsp;
		</dd>
		<dt><?php echo __('Preparation Time'); ?></dt>
		<dd>
			<?php echo h($recipe->preparation_time->name); ?>
                        &nbsp;
		</dd>
		<dt><?php echo __('Difficulty'); ?></dt>
		<dd>
			<?php echo h($recipe->difficulty->name); ?>
                        &nbsp;
		</dd>
		<dt><?php echo __('Serving Size'); ?></dt>
		<dd>
            <div>
            <input type="text" id="viewServings" value="<?php echo $servings;?>"/>
            
            <a id="doubleRefresh" title="<?php echo __('Double it');?>" href="#">x 2</a>

            <a id="viewRefresh" href="#">
                <?php echo __('Refresh');?></a>
            </div>
		</dd>
        </dl>

        <dl class="float50Section">
		<dt><?php echo __('Comments'); ?></dt>
		<dd>
			<?php echo h($recipe->comments); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tags'); ?></dt>
		<dd>
            <?php
                if (!empty($recipe->tags)) {
                    $tagNames = [];
                    foreach ($recipe->tags as $tag) {
                        $tagNames[] = $tag->name;
                    }
                    echo h(implode(', ', $tagNames));
                }
            ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Source'); ?></dt>
		<dd>
            <?php if (isset($recipe->source)) { ?>
                    <a href="#" onclick="return false;" id="qtipSource"><?php echo $recipe->source->name;?></a>
                    <div id="qtipSourceData" class="hide">
                        <?php echo $recipe->source->description;?>
                    </div>
                    &nbsp;
            <?php } ?>
		</dd>
		<dt><?php echo __('Source Description'); ?></dt>
		<dd>
			<?php echo h($recipe->source_description); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Modified'); ?></dt>
		<dd>
			<?php echo h($recipe->modified); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
                    <?php echo h($recipe->user->name); ?>
		</dd>
	</dl>
        
        <div class="clear"/><br/>
        <hr/>
        <br/>
            <?php 
                $imageCount = (isset($recipe) && $recipe->attachments)? count($recipe->attachments) : 0;
                if ($imageCount > 0) {
                    echo '<div class="float50Section">';

                } else {
                    echo  '<div style="width: 100%;">';
                }
            ?>
            <b><?php echo __('Ingredients'); ?></b>
            <table>
                <?php for ($i = 0; $i < count($recipe->ingredient_mappings); $i++) :
                            $quantity = $recipe->ingredient_mappings[$i]->quantity;
                            if ($quantity) {
                                if (isset($scale)) $quantity *= $scale;
                                $quantity = $this->Fraction->toFraction($quantity);
                                $unit = $recipe->ingredient_mappings[$i]->unit->abbreviation;
                            } else {
                                $quantity = '';
                                $unit = '';
                            }
                            $ingredientName = $recipe->ingredient_mappings[$i]->ingredient->name;
                            $qualifier = $recipe->ingredient_mappings[$i]->qualifier;
                            $note = $recipe->ingredient_mappings[$i]->note;
                            $optional = $recipe->ingredient_mappings[$i]->optional ? __('(optional)') : "";
                ?>
                <tr>
                    <td class="ingredientViewUnit"><?php echo "$quantity $unit";?></td>
                    <td><?php echo "$qualifier <b>$ingredientName</b> <i>$optional</i> ";?></td>
                    <td>
                        <?php if ($note) :?>
                        <div class="alert alert-info" role="alert"><?php echo "$note"; ?></div>
                        <?php endif;?>
                    </td>
                    
                </tr>
                <?php endfor; ?>
            </table>
        </div>
        <div class="float50Section" id="imagePreview">
            <?php 
            $baseUrl = Router::url('/');
            if ($imageCount > 0) {
                $imageName = $recipe->attachments[0]->attachment;
                //$imageDir = $recipe->attachments[0]->dir;
                $imagePreview =  preg_replace('/(.*)\.(.*)/i', '${1}.$2', $imageName);
                $imageCaption = $recipe->attachments[0]->name;
                
                echo "<div id='selectedRecipeImage'>";
                echo '<a href="#"><img src="' . $baseUrl . 'files/Attachments/attachment/' . 
                            $imagePreview . '" title="' . $imageCaption . '"/></a><br/>';
                echo "</div>";
                echo "<div id='previewImageOptions'>";
                if ($imageCount > 1) {
                    
                    for ($imageIndex = 0; $imageIndex < $imageCount; $imageIndex++) {
                        $imageName = $recipe->attachments[$imageIndex]->attachment;
                        //$imageDir = "attachment";$recipe->attachments[$imageIndex]->dir;
                        $imageThumb =  preg_replace('/(.*)\.(.*)/i', 'thumbnail-${1}.$2', $imageName);
                        $imagePreview =  preg_replace('/(.*)\.(.*)/i', '${1}.$2', $imageName);
                        $imageCaption = $recipe->attachments[$imageIndex]['name'];
                        
                        $previewUrl = $baseUrl . 'files/Attachments/attachment/' . $imagePreview;
                        $thumbailUrl = $baseUrl . 'files/Attachments/attachment/' . $imageThumb;
                        echo '<a href="#" onclick=\'loadImage("' . $previewUrl. '", "'. $imageCaption . '");\'><img src="' . $thumbailUrl . '" title="' . $imageCaption . '"/></a>';
                    }
                    
                }
                echo "</div>";
            }?>
        </div> 
        <div class="clear"/><br/>    
        <div style="width: 100%;">
            <b><?php echo __('Directions'); ?></b>

            <?php if ($recipe->use_markdown): ?>
                <div class="markdown-content">
                    <?= $this->Markdown->render($recipe->directions) ?>
                </div>
            <?php else: ?>
                <pre><?php echo h($recipe->directions); ?></pre>
            <?php endif; ?>
        </div>
        
        <?php foreach ($recipe->related_recipes as $related) :?>
            <div class="clear"/><br/> 
            <div class="relatedRecipe">
                <span>
                <?php echo $this->Html->link($related->recipe->name, array('controller' => 'recipes', 'action' => 'view', $related->recipe_id), 
                                array('class' => 'ajaxNavigationLink')); ?>
                        (<?php echo $related->required == "1" ? "required" : __('optional');?>)
                </span>   
                <div class="float50Section">
                    <b><?php echo __('Ingredients'); ?></b>
                    
                    <table>
                    <?php for ($i = 0; $i < count($related->recipe->ingredient_mappings); $i++) :
                            $quantity = $related->recipe->ingredient_mappings[$i]->quantity;
                            if (isset($scale)) $quantity *= $scale;
                            $quantity = $this->Fraction->toFraction($quantity);
                            $unit = $related->recipe->ingredient_mappings[$i]->unit->abbreviation;
                            $ingredientName = $related->recipe->ingredient_mappings[$i]->ingredient->name; 
                            $qualifier = $related->recipe->ingredient_mappings[$i]->qualifier;
                            $optional = $related->recipe->ingredient_mappings[$i]->optional ? __('(optional)') : "";
                        ?>
                        <tr>
                            <td class="ingredientViewUnit"><?php echo "$quantity $unit";?></td>
                            <td><?php echo "$qualifier <b>$ingredientName</b> <i>$optional</i>";?></td>
                            <td>
                                <?php if ($note) :?>
                                <div class="alert alert-info" role="alert"><?php echo "$note"; ?></div>
                                <?php endif;?>
                            </td>
                        </tr>
                    <?php endfor;?>
                    </table>
                </div>
                <div class="float50Section">
                    <!-- placeholder for related recipe image -->
                </div>
                <div class="clear"/><br/>
                <div style="width: 100%;">
                    <b><?php echo __('Directions'); ?></b>
                    <?php if ($related->recipe->use_markdown): ?>
                        <div class="markdown-content">
                            <?= $this->Markdown->render($related->recipe->directions) ?>
                        </div>
                    <?php else: ?>
                        <pre><?php echo h($related->recipe->directions);?></pre>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        </pre>
</div>
