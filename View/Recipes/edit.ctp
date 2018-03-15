<?php
$recipeId = isset($recipe['Recipe']['id']) ? $recipe['Recipe']['id'] : "";
?>
<script type="text/javascript">
    var recipeId = "<?php echo $recipeId;?>";
            
    $(function() {
        $(document).off("savedIngredient.editRecipe");
        $(document).on("savedIngredient.editRecipe", function() {
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
                            itemId.indexOf('RecipeId') === -1 && 
                            itemId.indexOf('UnitId') === -1 && 
                            itemId.indexOf('SortOrder') === -1 &&
                            itemId.indexOf('Optional') === -1 &&
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
                    if (itemId != "" && itemId.indexOf('ParentId') === -1 && 
                            itemId.indexOf('SortOrder') === -1 && 
                            itemId.indexOf('Required') === -1 && $(this).val()) {
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
        initAutocomplete("IngredientName", "IngredientId", "Ingredients/autoCompleteSearch.json", /IngredientMapping\d*IngredientId/);
    }
    
    function initRelatedAutoCompleted() {
        reNumberRelatedRecipesTable();
        initAutocomplete("RelatedName", "RecipeId", "Recipes/autoCompleteSearch.json", /RelatedRecipe\d*RecipeId/);
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
           var oldNote =  $('#IngredientMapping' + rowId + 'Note').val();
           $('#noteText').val(oldNote);
           //$('#noteText').val(oldNote);

           $('#editNoteDialog').dialog({
            buttons: { 
                        "Save": function() { 
                            var newNote = $('#noteText').val();
                            $('#IngredientMapping' + rowId + 'Note').val(newNote);
                            $(this).dialog('close');
                        },
                        "Close": function() { $(this).dialog('close'); } 
                    }
                });
            $('#editNoteDialog').dialog('open');
        });
    }
    
    function initRowDelete() {
        $('.deleteIcon').off('click');
        $('.deleteIcon').click(function() {
            // TODO: if count of TR = 1 then just blank the row and re-number

           var thisRow = $(this).closest('tr');

           // Determine which section we are in when the delete icon is clicked
           var inIngredientsSection = thisRow.parents('#ingredientsSection').length;
           var InRelatedRecipesSection = thisRow.parents('#relatedRecipesSection').length;           

            if (inIngredientsSection) {
               regMatch = /IngredientMapping\d*Id/;
            } else if (InRelatedRecipesSection) {
               regMatch = /RelatedRecipe\d*Id/;
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
                 .filter(function() { return this.id.match(regMatch);})[0]
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
                    var nodeName = $(this).attr('id');
                    var newNodeName = "";
                    var newNodeId = "";
                    
                    if (nodeName.indexOf("Quantity") > -1) {
                        newNodeId = "IngredientMapping" + i + "Quantity";
                        newNodeName = "data[IngredientMapping][" + i + "][quantity]";
                    }
                    else if (nodeName.indexOf("UnitId") > -1) { 
                        newNodeId = "IngredientMapping" + i + "UnitId";
                        newNodeName = "data[IngredientMapping][" + i + "][unit_id]";
                    }
                    else if (nodeName.indexOf("Qualifier") > -1) { 
                        newNodeId = "IngredientMapping" + i + "Qualifier";
                        newNodeName = "data[IngredientMapping][" + i + "][qualifier]";
                    }
                    else if (nodeName.indexOf("Note") > -1) { 
                        newNodeId = "IngredientMapping" + i + "Note";
                        newNodeName = "data[IngredientMapping][" + i + "][note]";
                    }
                    else if (nodeName.indexOf("IngredientName") > -1) { 
                        newNodeId = "IngredientMapping" + i + "IngredientName";
                        newNodeName = "data[IngredientMapping][" + i + "][Ingredient][name]";
                    }
                    else if (nodeName.indexOf("RecipeId") > -1) { 
                        newNodeId = "IngredientMapping" + i + "RecipeId";
                        newNodeName = "data[IngredientMapping][" + i + "][recipe_id]";
                        var recipeId = $('#RecipeId').val();
                        $(this).val(recipeId);
                    }
                    else if (nodeName.indexOf("IngredientId") > -1) { 
                        newNodeId = "IngredientMapping" + i + "IngredientId";
                        newNodeName = "data[IngredientMapping][" + i + "][ingredient_id]";
                    }
                    else if (nodeName.indexOf("SortOrder") > -1) {
                        newNodeId = "IngredientMapping" + i + "SortOrder";
                        newNodeName = "data[IngredientMapping][" + i + "][sort_order]";
                        $(this).val(i);
                    }
                    else if (nodeName.indexOf("Optional") > -1) {
                        newNodeId = "IngredientMapping" + i + "Optional";
                        newNodeName = "data[IngredientMapping][" + i + "][optional]";  
                    }
                    else if (nodeName.indexOf("Id") > -1) { 
                        newNodeId = "IngredientMapping" + i + "Id";
                        newNodeName = "data[IngredientMapping][" + i + "][id]";
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
                    var nodeName = $(this).attr('id');
                    var newNodeName = "";
                    var newNodeId = "";
                    
                    if (nodeName.indexOf("RelatedName") > -1)
                    {
                        newNodeId = "RelatedRecipe" + i + "RelatedName";
                        newNodeName = "data[RelatedRecipe][" + i + "][Related][name]";
                    }
                    else if (nodeName.indexOf("Required") > -1) { 
                        newNodeId = "RelatedRecipe" + i + "Required";
                        newNodeName = "data[RelatedRecipe][" + i + "][required]";
                    }
                    else if (nodeName.indexOf('RecipeId') > -1)
                    {
                        newNodeId = "RelatedRecipe" + i + "RecipeId";
                        newNodeName = "data[RelatedRecipe][" + i + "][recipe_id]";
                    }
                    else if (nodeName.indexOf('ParentId') > -1)
                    {
                        newNodeId = "RelatedRecipe" + i + "ParentId";
                        newNodeName = "data[ParentId][" + i + "][parent_id]";
                        var recipeId = $('#RecipeId').val();
                        $(this).val(recipeId);
                    }
                    else if (nodeName.indexOf("SortOrder") > -1) { 
                        newNodeId = "RelatedRecipe" + i + "SortOrder";
                        newNodeName = "data[RelatedRecipe][" + i + "][sort_order]";
                        $(this).val(i);
                    }
                    else if (nodeName.indexOf("Id") > -1) { 
                        newNodeId = "RelatedRecipe" + i + "Id";
                        newNodeName = "data[RelatedRecipe][" + i + "][id]";
                    }
                        
                    $(this).attr('name', newNodeName);
                    $(this).attr('id', newNodeId);
            });
            i++;
        });
    }

    /**
     * Initialize the autocomplete functionality for input fields with an id of itemName
     * @param {string} itemName - The id of the <input> fields that we want to have autocomplete enabled
     * @param {string} itemId - Does not appear to be used in this function
     * @param {string} getUrl - The URL used when performing autocomplete search
     * @param {regex} regMatch - The regex pattern used to find the hidden <input> to store the ui.item.id or clear its value
     */    
    function initAutocomplete(itemName, itemId, getUrl, regMatch)
    {
        $(".ui-widget").find("input[id$='" + itemName + "']").each(function() {
            $(this).autocomplete({
                source: baseUrl + getUrl,
                minLength: 1,
                html: true,
                autoFocus: true,
                select: function(event, ui) {
                    var inputField = $(this);
                    var inputFieldId = $(this)
                          .closest('tr')
                          .find('input')
                          .filter(function() { return this.id.match(regMatch);});

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
                          .find('input')
                          .filter(function() { return this.id.match(regMatch);});

                  inputField.val("");
                  inputFieldId.val("");
                }
            });
        });
    }
</script>
<?php //echo $this->element('sql_dump'); ?>

<div class="actions">
	<ul>
            <?php if (isset($recipe['Recipe']['id'])) :?>
            <li><?php echo $this->Html->link(__('View Recipe'), array('action' => 'view', $recipe['Recipe']['id'])); ?></li>
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
<?php echo $this->Form->create('Recipe', array('type' => 'file')); ?>
    <fieldset>
            <legend><?php echo __('Recipe'); ?></legend>
            <?php
            $baseUrl = Router::url('/');
            echo $this->Form->hidden('id');
            echo $this->Form->input('name');
            echo $this->Form->input('comments', array('escape' => true, 'rows' => '2'));
            echo $this->Form->input('source_id', 
                    array('empty'=>true, 
                        'after' => $this->Html->link(__('Edit'), 
                            array('controller' => 'sources', 'action' => 'index'), 
                            array('class' => 'nagivationLink', 'targetId' => 'content', 'id' => 'sourcesEditLink'))));
            echo $this->Form->input('source_description');
            echo $this->Form->input('course_id', array('empty'=>true));
            echo $this->Form->input('base_type_id', array('empty'=>true));
            echo $this->Form->input('preparation_method_id', array('empty'=>true));
            echo $this->Form->input('ethnicity_id', array('empty'=>true));
            echo $this->Form->input('preparation_time_id', array('empty'=>true));
            echo $this->Form->input('difficulty_id', array('empty'=>true));
            echo $this->Form->input('serving_size');
            $imageCount = (isset($recipe) && isset($recipe['Image']))? count($recipe['Image']) : 0;
  
            echo "<div id='imageSection'>";
            echo $this->Form->input('Image.' . $imageCount . '.attachment', array('type' => 'file', 'label' => 'Add Image'));
            echo $this->Form->input('Image.' . $imageCount . '.name', array('label' => 'Caption'));
            echo $this->Form->hidden('Image.' . $imageCount . '.id');

            echo "<div id='currentImages'>";
            for ($imageIndex = 0; $imageIndex < $imageCount; $imageIndex++) {

                $imageName = $recipe['Image'][$imageIndex]['attachment'];
                $imageDir = $recipe['Image'][$imageIndex]['dir'];
                $imageThumb =  preg_replace('/(.*)\.(.*)/i', 'thumb_${1}.$2', $imageName);
                $imageCaption = $recipe['Image'][$imageIndex]['name'];
                $imageId = $recipe['Image'][$imageIndex]['id'];
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

            echo $this->Form->input('private', array('options' => array('0' => 'No', '1' => 'Yes')));
            echo $this->Form->input('system', array('options' => array('usa' => 'USA', 'metric' => 'Metric')));
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
                $ingredientCount = (isset($recipe) && isset($recipe['IngredientMapping']))? count($recipe['IngredientMapping']) : 0;
                for ($mapIndex = 0; $mapIndex <= $ingredientCount; $mapIndex++) {
                    $currentSortOrder = __("Unknown");
                    $extraItem = true;
                    $itemId = "";
                    if ($mapIndex < $ingredientCount)
                    {
                        $itemId = $recipe['IngredientMapping'][$mapIndex]['id'];
                        $currentSortOrder = $recipe['IngredientMapping'][$mapIndex]['sort_order'];
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
                        <?php echo $this->Form->hidden('IngredientMapping.' . $mapIndex . '.id'); ?>
                        <?php echo $this->Form->hidden('IngredientMapping.' . $mapIndex . '.recipe_id'); ?>
                        <?php echo $this->Form->hidden('IngredientMapping.' . $mapIndex . '.ingredient_id'); ?>
                        <?php echo $this->Form->hidden('IngredientMapping.' . $mapIndex . '.sort_order'); ?>
                        <?php echo $this->Form->hidden('IngredientMapping.' . $mapIndex . '.note'); ?>

                        <?php echo $this->Form->input('IngredientMapping.' . $mapIndex . '.quantity', array('label' => false, 'type' => 'fraction')); ?></td>
                    <td><?php echo $this->Form->input('IngredientMapping.' . $mapIndex . '.unit_id', array('label' => false)); ?></td>
                    <td><?php echo $this->Form->input('IngredientMapping.' . $mapIndex . '.qualifier', array('label' => false, 'escape' => false)); ?></td>
                    <td><?php echo $this->Form->input('IngredientMapping.' . $mapIndex . '.Ingredient.name', array('label' => false, 'escape' => false, 'type' => 'ui-widget')); ?></td>
                    <td><?php echo $this->Form->input('IngredientMapping.' . $mapIndex . '.optional', array('label' => false)); ?></td> 
                </tr>

                <?php } ?>
                </tbody>
                </table>

                <div id="ingredientDeleteResponse"></div>
                <a href="#" id="AddMoreIngredientsLink"><?php echo __('Add Another Ingredient');?></a>
            </div>
            <?php 
            echo $this->Form->input('directions', array('escape' => true, 'rows' => '20', 'cols' => '20'));
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
                $relatedCount = (isset($recipe) && isset($recipe['RelatedRecipe']) )? count($recipe['RelatedRecipe']) : 0;
                for ($mapIndex = 0; $mapIndex <= $relatedCount; $mapIndex++) {
                    $currentSortOrder = __("Unknown");
                    $extraItem = true;
                    if ($mapIndex < $relatedCount)
                    {
                        $itemId = $recipe['RelatedRecipe'][$mapIndex]['id'];
                        $currentSortOrder = $recipe['RelatedRecipe'][$mapIndex]['sort_order'];
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
                        <?php echo $this->Form->hidden('RelatedRecipe.' . $mapIndex . '.id'); ?>
                        <?php echo $this->Form->hidden('RelatedRecipe.' . $mapIndex . '.parent_id'); ?>
                        <?php echo $this->Form->hidden('RelatedRecipe.' . $mapIndex . '.recipe_id'); ?>
                        <?php echo $this->Form->hidden('RelatedRecipe.' . $mapIndex . '.sort_order'); ?>
                        <?php echo $this->Form->input('RelatedRecipe.' . $mapIndex . '.Related.name', array('label' => false, 'escape' => false, 'type' => 'ui-widget')); ?></td>
                    <td><?php echo $this->Form->input('RelatedRecipe.' . $mapIndex . '.required', array('label' => false)); ?></td> 
                </tr>
                <?php } ?>
                </tbody>
                </table>
                <div id="recipeDeleteResponse"></div>
                <a href="#" id="AddMoreRelatedRecipesLink"><?php echo __('Add Another Recipe');?></a>
            </div>
    </fieldset>
<?php echo $this->Session->flash(); ?> 
<?php echo $this->Form->end(__('Submit')); ?>
</div>

<div id="editNoteDialog" class="dialog" width="300" height="200" title="<?php echo __('Note');?>">
    <input type="hidden" id="rowId"/>
    <textarea id="noteText" cols=30 rows=4>
    </textarea>
</div>