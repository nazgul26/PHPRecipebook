<?php
use Cake\Routing\Router;

$recipeId = isset($recipe->id) ? $recipe->id : "";
?>
<script type="text/javascript">
    var recipeId = "<?php echo $recipeId;?>";
            
    $(function() {
        $(document).off("saved.ingredient");
        $(document).on("saved.ingredient", function() {
            $('#editIngredientDialog').dialog('close');
        });
        
        $("#sortableTable1 tbody.gridContent").sortable({
            items: "tr:not(.extraItem)",
            stop: function( event, ui ) { 
                reNumberIngredientsTable();}
        });
        $("#sortableTable2 tbody.gridContent").sortable({
            items: "tr:not(.extraItem)",
            stop: function( event, ui ) { 
                reNumberRelatedRecipesTable();}
        });
        
        $('#ingredientsSection').on("change", ".fraction input", function() {
            fractionConvert($(this), "<?php echo __("Entered value is not a number/fraction, please try again.");?>");
        });
        
        $('#AddMoreIngredientsLink').click(function() {
            $('#ingredientsSection .extraItem input').change();
            return false;
        });
        $('#AddMoreRelatedRecipesLink').click(function() {
            $('#relatedRecipesSection .extraItem input').change();
            return false;
        });

        $('input[type="submit"]').click(function() {
            // cleanup extra items not entered.  This is needed to prevent empty items from
            //  being added.  Also helps with validation on items.
            $("#sortableTable1 tr").each(function() {
                var rowIsNull = true;
                $(this).find('input').each(function() {
                    var itemId = $(this).attr('id');
                    if (itemId != "" && 
                            itemId.indexOf('recipe_id') === -1 && 
                            itemId.indexOf('unit_id') === -1 && 
                            itemId.indexOf('sort_order') === -1 &&
                            itemId.indexOf('optional') === -1 &&
                            $(this).val()) {
                        rowIsNull = false;
                        //console.log("Ingredient Input: " + $(this).attr('id') + "=" + $(this).val() + " Which is SET");
                    }
                });
                if (rowIsNull && !$(this).hasClass('headerRow')) {
                    $(this).remove();
                }
            });
            // Cleanup extra related recipes not set.
            $("#sortableTable2 tr").each(function() {
                var rowIsNull = true;
                $(this).find('input').each(function() {
                    var itemId = $(this).attr('id');
                    if (itemId != "" && 
                            itemId.indexOf('parent_id') === -1 && 
                            itemId.indexOf('sort_order') === -1 && 
                            itemId.indexOf('required') === -1 && $(this).val()) {
                        //console.log("Related Input: " + $(this).attr('id') + "=" + $(this).val() + " Which is SET");
                        rowIsNull = false;
                    }
                });
                if (rowIsNull && !$(this).hasClass('headerRow')) {
                    $(this).remove();
                }
            });
            reNumberIngredientsTable();
            reNumberRelatedRecipesTable();
            
            // Remove Add Image
            if ($('#imageSection .file input').val() === "") {
                var imageId = $('#imageSection .file input').attr('id').replace('Attachment', '');
                $('#imageSection .file input').remove();
                $('#imageSection .text input').remove();
                $('#' + imageId + 'Id').remove();
            }
            return true;
        });
        
        initRowCopy('ingredientsSection');
        initRowCopy('relatedRecipesSection');
        initRowDelete();
        initRowNote();
        initIngredientAutoComplete();
        initRelatedAutoCompleted();
    });
    
    function initIngredientAutoComplete() {
        reNumberIngredientsTable();
        initAutocomplete("ingredient", "Ingredients/autoCompleteSearch", /IngredientMapping\d*IngredientId/);
    }
    
    function initRelatedAutoCompleted() {
        reNumberRelatedRecipesTable();
        initAutocomplete("recipe", "Recipes/autoCompleteSearch", /RelatedRecipe\d*RecipeId/);
    }
    
    function initRowCopy(gridId) {
        $('#' + gridId + ' .extraItem input').each(function() {
            $(this).off('change');
            $(this).change(function() {
               $('#' + gridId + ' .extraItem input').off('change');
               $original = $('#' + gridId +' .extraItem');
               $clonedCopy = $original.clone();
               $clonedCopy.find('input').val('');
               $clonedCopy.appendTo('#' + gridId + ' .gridContent');
               $original.attr('class', '');
               initRowCopy(gridId);
               initRowDelete();
               if (gridId.indexOf('ingredients') > -1) {
                   initIngredientAutoComplete();
               } else {
                   initRelatedAutoCompleted();
               }
            });
        });
    }

    function initRowNote() {
        $('.commentIcon').off('click');
        $('.commentIcon').click(function() {
           var rowId = $(this).attr('rowId');
           var oldNote =  $('[name="ingredient_mappings[' + rowId + '][note]"]').val();
           $('#noteText').val(oldNote);

           $('#editNoteDialog').dialog({
            buttons: { 
                        "Save": function() { 
                            var newNote = $('#noteText').val();
                            $('[name="ingredient_mappings[' + rowId + '][note]"]').val(newNote);
                            $(this).dialog('close');
                        },
                        "Close": function() { $(this).dialog('close'); } 
                    }
                });
            $('#editNoteDialog').dialog('open');
        });
    }
    
    function initRowDelete() {
        console.log("doing row delete init");
        $('.deleteIcon').off('click');
        $('.deleteIcon').click(function() {
            // TODO: if count of TR = 1 then just blank the row and re-number

           var thisRow = $(this).closest('tr');

           // Determine which section we are in when the delete icon is clicked
           var inIngredientsSection = thisRow.parents('#ingredientsSection').length;
           var InRelatedRecipesSection = thisRow.parents('#relatedRecipesSection').length;           

            if (inIngredientsSection) {
               regMatch = /ingredient_mappings\[\d*\]\[id\]/;
            } else if (InRelatedRecipesSection) {
               regMatch = /related_recipes\[\d*\]\[id\]/;
            } else {
               return;  // Not good if we get here
            }  
            
            // Don't delete the last table row
            if (thisRow.is(":last-child")) {
                return;
            }

            // Just remove the table row and nothing else, if the IngredientMapping*Id field is blank.
            // Should we prompt for these since there is no change to the persistant data?
            if (thisRow
                 .find('input')
                 .filter(function() { return this.name.match(regMatch);})[0]
                 .value.length == 0) {
              thisRow.remove();
              return;
            }

            if (confirm("<?php echo __("Are you sure you wish to remove this item?");?>")) {
                var itemId = $(this).attr('itemId');        
                if ($(this).is("[ingredient-delete]")) {
                    ajaxGet(baseUrl + "Recipes/RemoveIngredientMapping/" + recipeId + "/" + itemId, "ingredientDeleteResponse");
                } else {
                    ajaxGet(baseUrl + "Recipes/RemoveRecipeMapping/" + recipeId + "/" + itemId, "recipeDeleteResponse");
                }
                thisRow.remove();
            }
        });
    }
    
    function reNumberIngredientsTable() {
        var i = -1;
        var tableSelector = "#sortableTable1";
        $(tableSelector).find("tr").each(function () {
            $(this).find(":input").each(function() {
                    var nodeName = $(this).attr('name');
                    var newNodeName = "";
                    var newNodeId = "";
                    
                    if (nodeName.indexOf("quantity") > -1) {
                        newNodeId = "ingredient-mappings-" + i + "-quantity";
                        newNodeName = "ingredient_mappings[" + i + "][quantity]";
                    }
                    else if (nodeName.indexOf("unit_id") > -1) { 
                        newNodeId = "ingredient-mappings-" + i + "-unit_id";
                        newNodeName = "ingredient_mappings[" + i + "][unit_id]";
                    }
                    else if (nodeName.indexOf("qualifier") > -1) { 
                        newNodeId = "ingredient-mappings-" + i + "-qualifier";
                        newNodeName = "ingredient_mappings[" + i + "][qualifier]";
                    }
                    else if (nodeName.indexOf("note") > -1) { 
                        newNodeId = "ingredient-mappings-" + i + "-note";
                        newNodeName = "ingredient_mappings[" + i + "][note]";
                    }
                    else if (nodeName.indexOf("[ingredient][name]") > -1) { 
                        newNodeId = "ingredient-mappings-" + i + "-ingredient-name";
                        newNodeName = "ingredient_mappings[" + i + "][ingredient][name]";
                    }
                    else if (nodeName.indexOf("recipe_id") > -1) { 
                        newNodeId = "ingredient-mappings-" + i + "-recipe_id";
                        newNodeName = "ingredient_mappings[" + i + "][recipe_id]";
                        $(this).val(recipeId);
                    }
                    else if (nodeName.indexOf("ingredient_id") > -1) { 
                        newNodeId = "ingredient-mappings-" + i + "-ingredient_id";
                        newNodeName = "ingredient_mappings[" + i + "][ingredient_id]";
                    }
                    else if (nodeName.indexOf("sort_order") > -1) {
                        newNodeId = "ingredient-mappings-" + i + "-sort_order";
                        newNodeName = "ingredient_mappings[" + i + "][sort_order]";
                        $(this).val(i);
                    }
                    else if (nodeName.indexOf("optional") > -1) {
                        newNodeId = "ingredient-mappings-" + i + "-optional";
                        newNodeName = "ingredient_mappings[" + i + "][optional]";  
                    }
                    else if (nodeName.indexOf("id") > -1) { 
                        newNodeId = "ingredient-mappings-" + i + "-id";
                        newNodeName = "ingredient_mappings[" + i + "][id]";
                    } else {
                        console.error("NO Match in ingredient node:" +nodeName);
                        return;
                    }

                    $(this).attr('name', newNodeName);
                    $(this).attr('id', newNodeId);
            });
            i++;
        });
    }
    
    function reNumberRelatedRecipesTable() {
        var i = -1;
        var tableSelector = "#sortableTable2";
        $(tableSelector).find("tr").each(function () {
            $(this).find(":input").each(function() {
                    var nodeName = $(this).attr('name');
                    var newNodeName = "";
                    var newNodeId = "";
                    
                    if (nodeName.indexOf("name") > -1)
                    {
                        newNodeId = "related-recipes-" + i + "-recipe-name";
                        newNodeName = "related_recipes[" + i + "][recipe][name]";
                    }
                    else if (nodeName.indexOf("required") > -1) { 
                        newNodeId = "related-recipes-" + i + "-required";
                        newNodeName = "related_recipes[" + i + "][required]";
                    }
                    else if (nodeName.indexOf('recipe_id') > -1)
                    {
                        newNodeId = "related-recipes-" + i + "-recipe_id";
                        newNodeName = "related_recipes[" + i + "][recipe_id]";
                    }
                    else if (nodeName.indexOf('parent_id') > -1)
                    {
                        newNodeId = "related-recipes-" + i + "-parent_id";
                        newNodeName = "related_recipes[" + i + "][parent_id]";
                        $(this).val(recipeId);
                    }
                    else if (nodeName.indexOf("sort_order") > -1) { 
                        newNodeId = "related-recipes-" + i + "-sort_order";
                        newNodeName = "related_recipes[" + i + "][sort_order]";
                        $(this).val(i);
                    }
                    else if (nodeName.indexOf("id") > -1) { 
                        newNodeId = "related-recipes-" + i + "-id";
                        newNodeName = "related_recipes[" + i + "][id]";
                    } else {
                        console.error("NO Match in recipe node:" +nodeName);
                        return;
                    }
                    
                    $(this).attr('name', newNodeName);
                    $(this).attr('id', newNodeId);
            });
            i++;
        });
    }

    /**
     * Initialize the autocomplete functionality for input fields with an id of itemName
     * @param {string} sectionId - The id of the section with the autocomplete fields that we want to have autocomplete enabled
     * @param {string} getUrl - The URL used when performing autocomplete search
     * @param {regex} regMatch - The regex pattern used to find the hidden <input> to store the ui.item.id or clear its value
     */    
    function initAutocomplete(inputType, getUrl, regMatch)
    {
        var sectionId = "";
        var findInputFilter = "";
        if (inputType == "recipe") {
            sectionId = "#relatedRecipesSection";
            findInputFilter = "input[id$=-recipe_id]"
        } else {
            sectionId = "#ingredientsSection";
            findInputFilter = "input[id$=-ingredient_id]"
        }

        $(sectionId).find("input[type='ui-widget']").each(function() {
            $(this).autocomplete({
                source: baseUrl + getUrl,
                minLength: 1,
                html: true,
                autoFocus: true,
                select: function(event, ui) {
                    var inputField = $(this);
                    var inputFieldId = $(this)
                          .closest('tr')
                          .find(findInputFilter);
                    
                    // Check if the item selected in the list has an ID.  If it doesn't, then it is "No results for '%s' found"
                    if (ui.item.id.length == 0) {
                       inputField.val("");
                       inputFieldId.val("");
                    } else {
                       inputFieldId.val(ui.item.id);
                    }
                },
                change: function(event, ui) {
                  // The ingredient should have already triggered the autocomplete.select event.  Nothing to do.
                  if (ui.item) {
                    return;
                  }

                  // This occurs when someone enters a value in the autocomplete field, but it doesn't match one of the results.  So clear everything.
                  var inputField = $(this);
                  var inputFieldId = $(this)
                          .closest('tr')
                          .find('input');

                  inputField.val("");
                  inputFieldId.val("");
                }
            });
        });
    }
</script>

<div class="actions">
	<ul>
            <?php if (isset($recipe['Recipe']['id'])) :?>
            <li><?php echo $this->Html->link(__('View Recipe'), array('action' => 'view', $recipe->id)); ?></li>
            <?php endif;?>
            <li><?php echo $this->Html->link(__('Edit Sources'), array('controller' => 'sources', 'action' => 'index'), array('class' => 'ajaxLink', 'targetId' => 'content')); ?>
            <li><button id="moreActionLinks">More Actions...</button></li>
	</ul>
        <div style="display: none;">
            <ul id="moreActionLinksContent">
                <li><?php echo $this->Html->link(__('Edit Ethnicities'), array('controller' => 'ethnicities', 'action' => 'index'), array('class' => 'ajaxLink', 'targetId' => 'content')); ?> </li>
                <li><?php echo $this->Html->link(__('Edit Base Types'), array('controller' => 'base_types', 'action' => 'index'), array('class' => 'ajaxLink', 'targetId' => 'content')); ?> </li>
                <li><?php echo $this->Html->link(__('Edit Courses'), array('controller' => 'courses', 'action' => 'index'), array('class' => 'ajaxLink', 'targetId' => 'content')); ?> </li>
                <li><?php echo $this->Html->link(__('Edit Preparation Times'), array('controller' => 'preparation_times', 'action' => 'index'), array('class' => 'ajaxLink', 'targetId' => 'content')); ?> </li>
                <li><?php echo $this->Html->link(__('Edit Difficulties'), array('controller' => 'difficulties', 'action' => 'index'), array('class' => 'ajaxLink', 'targetId' => 'content')); ?> </li>
                <li> </li>
            </ul>
        </div>     
</div>
<div class="recipes form">
<?php echo $this->Form->create($recipe, array('type' => 'file')); ?>
    <fieldset>
            <legend><?php echo __('Recipe'); ?></legend>
            <?php
            $baseUrl = Router::url('/');
            echo $this->Form->hidden('id');
            echo $this->Form->control('name');
            echo $this->Form->control('comments', array('escape' => true, 'rows' => '2'));
            echo $this->Form->control('source_id', 
                    array('empty'=>true, 
                        'after' => $this->Html->link(__('Edit'), 
                            array('controller' => 'sources', 'action' => 'index'), 
                            array('class' => 'nagivationLink', 'targetId' => 'content', 'id' => 'sourcesEditLink'))));
            echo $this->Form->control('source_description');
            echo $this->Form->control('course_id', array('empty'=>true));
            echo $this->Form->control('base_type_id', array('empty'=>true));
            echo $this->Form->control('preparation_method_id', array('empty'=>true));
            echo $this->Form->control('ethnicity_id', array('empty'=>true));
            echo $this->Form->control('preparation_time_id', array('empty'=>true));
            echo $this->Form->control('difficulty_id', array('empty'=>true));
            echo $this->Form->control('serving_size');
            $imageCount = (isset($recipe) && isset($recipe->attachments))? count($recipe->attachments) : 0;
            $newImageIndex = $imageCount-1;

            echo "<div id='imageSection'>";
            echo $this->Form->control('attachments.'. $newImageIndex . '.attachment', array('type' => 'file', 'label' => 'Add Image'));
            echo $this->Form->control('attachments.'. $newImageIndex . '.name', array('label' => 'Caption'));
            echo $this->Form->hidden('attachment.'. $newImageIndex . '.id');

            echo "<div id='currentImages'>";
            for ($imageIndex = 0; $imageIndex < $imageCount; $imageIndex++) {

                $imageName = $recipe->attachments[$imageIndex]->attachment;
                $imageDir = $recipe->attachments[$imageIndex]->dir;
                $imageThumb =  preg_replace('/(.*)\.(.*)/i', 'thumb_${1}.$2', $imageName);
                $imageCaption = $recipe->attachments[$imageIndex]->name;
                $imageId = $recipe->attachments[$imageIndex]->id;
                echo '<div class="recipeImage">';
                echo $this->Form->hidden('Image.' . $imageIndex . '.id');
                echo $this->Form->hidden('Image.' . $imageIndex . '.sort_order');
                echo $this->Html->link(__('Delete'), array('action' => 'deleteAttachment',$recipeId, $imageId));
                echo '<img src="' . $baseUrl . 'files/image/attachment/' .  $imageDir . '/' . 
                        $imageThumb . '" alt="' . $imageCaption . '"/>';

                echo "</div>";
            }
            echo "</div>";
            echo "<div class='clear'></div>";
            echo "</div>";

            echo $this->Form->control('private', array('options' => array('0' => 'No', '1' => 'Yes')));
            echo $this->Form->control('system_type', array('options' => array('usa' => 'USA', 'metric' => 'Metric')));
            echo $this->Form->hidden('user_id');
            ?>
            <div id="ingredientsSection">
                <table id="sortableTable1">
                <tr class="headerRow">
                    <th class="deleteIcon"></th>
                    <th class="moveIcon"></th>
                    <th class="commentIcon"></th>
                    <th><?php echo __('Quantity');?></th>
                    <th><?php echo __('Units');?></th>
                    <th><?php echo __('Qualifier');?></th>
                    <th><?php echo __('Ingredient') . " - ";?>
                        <?php echo $this->Html->link(__('add new'), array('controller'=>'ingredients', 'action' => 'edit'), 
                                array('class' => 'ajaxLink', 'targetId' => 'editIngredientDialog', 'id'=>'addNewIngredientsLink'));?>
                    </th>
                    <th><?php echo __('Optional');?></th>
                </tr>
                <tbody class="gridContent">
                <?php 
                $ingredientCount = (isset($recipe) && isset($recipe->ingredient_mappings))? count($recipe->ingredient_mappings) : 0;
                for ($mapIndex = 0; $mapIndex <= $ingredientCount; $mapIndex++) {
                    $currentSortOrder = __("Unknown");
                    $extraItem = true;
                    $itemId = "";
                    if ($mapIndex < $ingredientCount)
                    {
                        $itemId = $recipe->ingredient_mappings[$mapIndex]->id;
                        $currentSortOrder = $recipe->ingredient_mappings[$mapIndex]->sort_order;
                        $extraItem = false;
                    }       
                ?>
                <tr class="<?php echo ($extraItem) ? "extraItem" : ""?>">
                    <td>
                        <div class="ui-state-default ui-corner-all deleteIcon" 
                             ingredient-delete 
                             itemId="<?php echo $itemId;?>" 
                             title="<?php echo __('Delete'); ?>">
                            <span class="ui-icon ui-icon-trash"></span>
                        </div>
                    </td>
                    <td>
                        <div class="ui-state-default ui-corner-all moveIcon" title="<?php echo __('Order Ingredient - currently #' . $currentSortOrder );?>">
                            <span class="ui-icon ui-icon-arrow-4"></span>
                        </div>
                    </td>
                    <td>
                        <div class="ui-state-default ui-corner-all commentIcon" 
                            rowId="<?php echo $mapIndex;?>" 
                            title="<?php echo __('Add or edit a note' );?>">
                            <span class="ui-icon ui-icon-comment"></span>
                        </div>
                    </td>
                    <td>
                        <?php echo $this->Form->hidden('ingredient_mappings.' . $mapIndex . '.id'); ?>
                        <?php echo $this->Form->hidden('ingredient_mappings.' . $mapIndex . '.recipe_id'); ?>
                        <?php echo $this->Form->hidden('ingredient_mappings.' . $mapIndex . '.ingredient_id'); ?>
                        <?php echo $this->Form->hidden('ingredient_mappings.' . $mapIndex . '.sort_order'); ?>
                        <?php echo $this->Form->hidden('ingredient_mappings.' . $mapIndex . '.note'); ?>

                        <?php echo $this->Form->control('ingredient_mappings.' . $mapIndex . '.quantity', array('label' => false, 'type' => 'fraction')); ?></td>
                    <td><?php echo $this->Form->control('ingredient_mappings.' . $mapIndex . '.unit_id', array('label' => false)); ?></td>
                    <td><?php echo $this->Form->control('ingredient_mappings.' . $mapIndex . '.qualifier', array('label' => false, 'escape' => false)); ?></td>
                    <td><?php echo $this->Form->control('ingredient_mappings.' . $mapIndex . '.ingredient.name', array('label' => false, 'escape' => false, 'type' => 'ui-widget')); ?></td>
                    <td><?php echo $this->Form->control('ingredient_mappings.' . $mapIndex . '.optional', array('label' => false)); ?></td> 
                </tr>

                <?php } ?>
                </tbody>
                </table>

                <div id="ingredientDeleteResponse"></div>
                <a href="#" id="AddMoreIngredientsLink"><?php echo __('Add Another Ingredient');?></a>
            </div>
            <?php 
            echo $this->Form->control('directions', array('escape' => true, 'rows' => '20', 'cols' => '20'));
            ?>
            
            <div id="relatedRecipesSection">
                <table id="sortableTable2">
                <tr class="headerRow">
                    <th class="deleteIcon"></th><th class="moveIcon"></th>
                    <th><?php echo __('Related Recipe Name');?></th>
                    <th><?php echo __('Required');?></th>
                </tr>
                <tbody class="gridContent">
                <?php 
                $relatedCount = (isset($recipe) && isset($recipe->related_recipes) )? count($recipe->related_recipes) : 0;
                for ($mapIndex = 0; $mapIndex <= $relatedCount; $mapIndex++) {
                    $currentSortOrder = __("Unknown");
                    $extraItem = true;
                    if ($mapIndex < $relatedCount)
                    {
                        $itemId = $recipe->related_recipes[$mapIndex]->id;
                        $currentSortOrder = $recipe->related_recipes[$mapIndex]->sort_order;
                        $extraItem = false;
                    }
                       
                ?>
                <tr class="<?php echo ($extraItem) ? "extraItem" : ""?>">
                    <td>
                        <div class="ui-state-default ui-corner-all deleteIcon" 
                             itemId="<?php echo $itemId;?>"
                             title="<?php echo __('Delete'); ?>">
                            <span class="ui-icon ui-icon-trash"></span>
                        </div>
                    </td>
                    <td>
                        <div class="ui-state-default ui-corner-all moveIcon" title="<?php echo __('Order Recipe - currently #' . $currentSortOrder);?>">
                            <span class="ui-icon ui-icon-arrow-4"></span>
                        </div>
                    </td>
                    <td>
                        <?php echo $this->Form->hidden('related_recipes.' . $mapIndex . '.id'); ?>
                        <?php echo $this->Form->hidden('related_recipes.' . $mapIndex . '.parent_id'); ?>
                        <?php echo $this->Form->hidden('related_recipes.' . $mapIndex . '.recipe_id'); ?>
                        <?php echo $this->Form->hidden('related_recipes.' . $mapIndex . '.sort_order'); ?>
                        <?php echo $this->Form->control('related_recipes.' . $mapIndex . '.recipe.name', array('label' => false, 'escape' => false, 'type' => 'ui-widget')); ?></td>
                    <td><?php echo $this->Form->control('related_recipes.' . $mapIndex . '.required', array('label' => false)); ?></td> 
                </tr>
                <?php } ?>
                </tbody>
                </table>
                <div id="recipeDeleteResponse"></div>
                <a href="#" id="AddMoreRelatedRecipesLink"><?php echo __('Add Another Recipe');?></a>
            </div>
    </fieldset>
    <?= $this->Flash->render() ?>
    <?= $this->Form->submit(__('Submit')); ?>
    <?php echo $this->Form->end(); ?>
</div>

<div id="editNoteDialog" class="dialog" width="300" height="200" title="<?php echo __('Note');?>">
    <input type="hidden" id="rowId"/>
    <textarea id="noteText" cols=30 rows=4>
    </textarea>
</div>