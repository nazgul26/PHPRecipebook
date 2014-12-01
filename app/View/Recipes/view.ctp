<div class="recipes view">
    <h2><?php echo __('Recipe'); ?></h2>
        <div class="actions">
            <ul>
                <li><?php echo $this->Html->link(__('Edit Recipe'), array('action' => 'edit', $recipe['Recipe']['id'])); ?></li>
                <li><a href="#" onclick="alert('done yet.');"><?php echo __('Add to Shopping List');?></a></li>
                <li><a href="#" onclick="alert('done yet.');"><?php echo __('Print');?></a></li>
                <li><a href="#" onclick="alert('done yet.');"><?php echo __('eMail');?></a></li>
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
	<dl class="floatSections">
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

        <dl class="floatSections">
		<dt><?php echo __('Comments'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['comments']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Source'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recipe['Source']['name'], array('controller' => 'sources', 'action' => 'view', $recipe['Source']['id'])); ?>
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
			<?php echo $this->Html->link($recipe['User']['name'], array('controller' => 'users', 'action' => 'view', $recipe['User']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
        
        <div class="clear"/><br/>
        
        <div>
            <b><?php echo __('Ingredients'); ?></b>
<pre><?php for ($i = 0; $i < count($recipe['IngredientMapping']); $i++) {
                $quantity = $recipe['IngredientMapping'][$i]['quantity'];
                $unit = $recipe['IngredientMapping'][$i]['Unit']['name'];
                $ingredientName = $recipe['IngredientMapping'][$i]['Ingredient']['name'];
                echo $quantity . " <b>" . $unit . "</b> " . $ingredientName . "<br/>";
            }?>
</pre>
        </div>
        <br/>     
        <div>
            <b><?php echo __('Directions'); ?></b>

            <pre><?php echo h($recipe['Recipe']['directions']); ?></pre>
        </div>
        
        <?php echo h($recipe['Recipe']['picture']); ?>
        <?php echo h($recipe['Recipe']['picture_type']); ?>
</div>
