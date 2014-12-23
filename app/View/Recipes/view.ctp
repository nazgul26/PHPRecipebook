<script type="text/javascript">
    $(function() {
        $('#qtipSource').qtip({ // Grab some elements to apply the tooltip to
            content: {
                text: $('#qtipSourceData').html()
            },
            style: { classes: 'qtip-dark' }
        });
    });
    
    function loadImage(imageUrl, caption) {
        console.log("Image Url:" + imageUrl);
        $('#selectedPreviewImage img').attr('src', imageUrl).attr('title', caption);
        return false;
    }
</script>
<div class="recipes view">
    <h2><?php echo __('Recipe'); ?></h2>
        <div class="actions">
            <ul>
                <li><?php echo $this->Html->link(__('Edit Recipe'), array('action' => 'edit', $recipe['Recipe']['id'])); ?></li>
                <li><a href="#" onclick="alert('not done yet.');"><?php echo __('Add to Shopping List');?></a></li>
                <li><a href="#" onclick="alert('not done yet.');"><?php echo __('Print');?></a></li>
                <li><a href="#" onclick="alert('not done yet.');"><?php echo __('eMail');?></a></li>
                <!-- Ratings - Put it on the page somewhere instead of a link -->
                <li><button id="moreActionLinks">More Actions...</button></li>
            </ul>
            <div style="display: none;">
                <ul id="moreActionLinksContent">
                    <li><?php echo $this->Html->link(__('Import'), array('controller' => 'import', 'action' => 'index'), array('class' => 'ajaxNavigation')); ?> </li>
                    <li><?php echo $this->Html->link(__('Export'), array('controller' => 'export', 'action' => 'edit'), array('class' => 'ajaxNavigation')); ?> </li>
                </ul>
            </div> 
        </div>
	<dl class="float50Section">
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['name']); ?>
			&nbsp;
		</dd>
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
			<?php echo h($recipe['Recipe']['serving_size']); ?>
			&nbsp;
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
        
        <div class="float50Section">
            <b><?php echo __('Ingredients'); ?></b>
<pre><?php for ($i = 0; $i < count($recipe['IngredientMapping']); $i++) {
                $quantity = $recipe['IngredientMapping'][$i]['quantity'];
                $unit = $recipe['IngredientMapping'][$i]['Unit']['name'];
                $ingredientName = $recipe['IngredientMapping'][$i]['Ingredient']['name'];
                echo $quantity . " <b>" . $unit . "</b> " . $ingredientName . "<br/>";
            }?>
</pre>
        </div>
        <div class="float50Section" id="imagePreview">
            <?php 
            $imageCount = (isset($recipe) && $recipe['Image'])? count($recipe['Image']) : 0;
            $baseUrl = Router::url('/');
            if ($imageCount > 0) {
                $imageName = $recipe['Image'][0]['attachment'];
                $imageDir = $recipe['Image'][0]['dir'];
                $imagePreview =  preg_replace('/(.*)\.(.*)/i', 'preview_${1}.$2', $imageName);
                $imageCaption = $recipe['Image'][0]['name'];
                
                echo '<a id="selectedPreviewImage" href="#"><img src="' . $baseUrl . 'files/image/attachment/' .  $imageDir . '/' . 
                            $imagePreview . '" title="' . $imageCaption . '"/></a><br/>';
                
                if ($imageCount > 1) {
                    echo "<div id='ImageOptions'>";
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
                    echo "</div>";
                }
            }?>
        </div> 
        <div class="clear"/><br/>    
        <div style="width: 100%;">
            <b><?php echo __('Directions'); ?></b>

            <pre><?php echo h($recipe['Recipe']['directions']); ?></pre>
        </div>
        
        <?php echo h($recipe['Recipe']['picture']); ?>
        <?php echo h($recipe['Recipe']['picture_type']); ?>
</div>
