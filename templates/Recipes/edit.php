<?php
use Cake\Routing\Router;

$recipeId = isset($recipe->id) ? $recipe->id : "";
?>

<div class="actions-bar">
    <?php if (isset($recipe->id)) :?>
    <?= $this->Html->link(__('View Recipe'), array('action' => 'view', $recipe->id), ['class' => 'btn btn-outline-primary btn-sm']) ?>
    <?php endif;?>
    <div class="dropdown d-inline-block">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-gear"></i> <?= __('Manage Lists') ?>
        </button>
        <ul class="dropdown-menu">
            <li><?= $this->Html->link(__('Sources'), ['controller' => 'sources', 'action' => 'index'], ['class' => 'dropdown-item ajaxLink']) ?></li>
            <li><?= $this->Html->link(__('Ethnicities'), ['controller' => 'ethnicities', 'action' => 'index'], ['class' => 'dropdown-item ajaxLink']) ?></li>
            <li><?= $this->Html->link(__('Base Types'), ['controller' => 'base_types', 'action' => 'index'], ['class' => 'dropdown-item ajaxLink']) ?></li>
            <li><?= $this->Html->link(__('Courses'), ['controller' => 'courses', 'action' => 'index'], ['class' => 'dropdown-item ajaxLink']) ?></li>
            <li><?= $this->Html->link(__('Preparation Times'), ['controller' => 'preparation_times', 'action' => 'index'], ['class' => 'dropdown-item ajaxLink']) ?></li>
            <li><?= $this->Html->link(__('Difficulties'), ['controller' => 'difficulties', 'action' => 'index'], ['class' => 'dropdown-item ajaxLink']) ?></li>
            <li><?= $this->Html->link(__('Tags'), ['controller' => 'tags', 'action' => 'index'], ['class' => 'dropdown-item ajaxLink']) ?></li>
        </ul>
    </div>
</div>
<div class="recipes form">
<?= $this->Form->create($recipe, array('type' => 'file')) ?>
    <fieldset>
            <legend><?= __('Recipe') ?></legend>
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
            ?>
            <div id="tagsSection" class="mb-3">
                <label for="tagInput" class="form-label"><?= __('Tags') ?></label>
                <div class="d-flex flex-wrap align-items-center gap-1">
                    <span id="tagPills"><?php if (isset($recipe->tags) && !empty($recipe->tags)): ?><?php foreach ($recipe->tags as $tag): ?><span class="tag-pill" data-tag-id="<?= $tag->id ?>"><?= h($tag->name) ?><a href="#" class="remove-tag" title="<?= __('Remove') ?>">&times;</a><input type="hidden" name="tags[_ids][]" value="<?= $tag->id ?>" /></span><?php endforeach; ?><?php endif; ?></span>
                    <input type="text" id="tagInput" class="form-control form-control-sm" style="width: auto; min-width: 150px;" placeholder="<?= __('i.e vegan, kid-friendly') ?>" />
                </div>
                <input type="hidden" name="new_tags" id="newTagsInput" value="" />
            </div>
            <?php
            echo $this->Form->control('course_id', array('empty'=>true));
            echo $this->Form->control('base_type_id', array('empty'=>true));
            echo $this->Form->control('preparation_method_id', array('empty'=>true));
            echo $this->Form->control('ethnicity_id', array('empty'=>true));
            echo $this->Form->control('preparation_time_id', array('empty'=>true));
            echo $this->Form->control('difficulty_id', array('empty'=>true));
            echo $this->Form->control('serving_size');
            /*$imageCount = (isset($recipe) && isset($recipe->attachments))? count($recipe->attachments) : 0;
            $newImageIndex = $imageCount-1;

            echo "<div id='imageSection'>";
            echo $this->Form->control('attachments.'. $newImageIndex . '.attachment', array('type' => 'file', 'label' => 'Add Image', 'required' => false));
            echo $this->Form->control('attachments.'. $newImageIndex . '.name', array('label' => 'Caption', 'required' => false));
            echo $this->Form->hidden('attachment.'. $newImageIndex . '.id');

            echo "<div id='currentImages' class='d-flex flex-wrap gap-3 mt-2'>";
            for ($imageIndex = 0; $imageIndex < $imageCount; $imageIndex++) {
                $imageName = $recipe->attachments[$imageIndex]->attachment;
                $imageDir = "attachment";
                $imageThumb = preg_replace('/(.*)\.(.*)/i', 'thumbnail-${1}.$2', $imageName);
                $imageCaption = $recipe->attachments[$imageIndex]->name;
                $imageId = $recipe->attachments[$imageIndex]->id;
                echo '<div class="recipeImage text-center">';
                echo $this->Form->hidden('Image.' . $imageIndex . '.id');
                echo $this->Form->hidden('Image.' . $imageIndex . '.sort_order');
                echo $this->Html->link(__('Delete'), array('action' => 'deleteAttachment',$recipeId, $imageId), ['class' => 'small']);
                echo '<br/><img src="' . $baseUrl . 'files/Attachments/' . $imageDir . '/' .
                        $imageThumb . '" alt="' . $imageCaption . '" class="rounded mt-1"/>';
                echo "</div>";
            }
            echo "</div>";
            echo "<div class='clear'></div>";
            echo "</div>";*/

            echo $this->Form->control('private', array('options' => array('0' => 'No', '1' => 'Yes')));
            echo $this->Form->control('system_type', array('options' => array('usa' => 'USA', 'metric' => 'Metric')));
            echo $this->Form->hidden('user_id');
            ?>
            <div id="ingredientsSection">
                <h6 class="mb-3"><i class="bi bi-list-check"></i> <?= __('Ingredients') ?></h6>
                <table id="sortableTable1" class="table table-sm">
                <tr class="headerRow">
                    <th style="width: 40px;"></th>
                    <th style="width: 40px;"></th>
                    <th style="width: 40px;"></th>
                    <th><?= __('Quantity') ?></th>
                    <th><?= __('Units') ?></th>
                    <th><?= __('Qualifier') ?></th>
                    <th><?= __('Ingredient') ?> -
                        <?= $this->Html->link(__('add new'), array('controller'=>'ingredients', 'action' => 'edit'),
                                array('class' => 'ajaxLink', 'targetId' => 'editIngredientDialog', 'id'=>'addNewIngredientsLink')) ?>
                    </th>
                    <th><?= __('Optional') ?></th>
                </tr>
                <tbody class="gridContent">
                <?php
                $ingredientCount = (isset($recipe) && isset($recipe->ingredient_mappings))? count($recipe->ingredient_mappings) : 0;
                for ($mapIndex = 0; $mapIndex <= $ingredientCount; $mapIndex++) {
                    $currentSortOrder = __("Unknown");
                    $extraItem = true;
                    $itemId = "";
                    if ($mapIndex < $ingredientCount) {
                        $itemId = $recipe->ingredient_mappings[$mapIndex]->id;
                        $currentSortOrder = $recipe->ingredient_mappings[$mapIndex]->sort_order;
                        $extraItem = false;
                    }
                ?>
                <tr class="<?= ($extraItem) ? "extraItem" : "" ?>">
                    <td>
                        <i class="bi bi-trash icon-action text-danger delete-action"
                           data-ingredient-delete
                           data-item-id="<?= $itemId ?>"
                           title="<?= __('Delete') ?>"></i>
                    </td>
                    <td>
                        <i class="bi bi-arrows-move icon-action move-handle"
                           title="<?= __('Order Ingredient - currently #' . $currentSortOrder) ?>"></i>
                    </td>
                    <td>
                        <i class="bi bi-chat-dots icon-action comment-action"
                           data-row-id="<?= $mapIndex ?>"
                           title="<?= __('Add or edit a note') ?>"></i>
                    </td>
                    <td>
                        <?= $this->Form->hidden('ingredient_mappings.' . $mapIndex . '.id') ?>
                        <?= $this->Form->hidden('ingredient_mappings.' . $mapIndex . '.recipe_id') ?>
                        <?= $this->Form->hidden('ingredient_mappings.' . $mapIndex . '.ingredient_id') ?>
                        <?= $this->Form->hidden('ingredient_mappings.' . $mapIndex . '.sort_order') ?>
                        <?= $this->Form->hidden('ingredient_mappings.' . $mapIndex . '.note') ?>
                        <?= $this->Form->control('ingredient_mappings.' . $mapIndex . '.quantity', array('label' => false, 'type' => 'fraction')) ?></td>
                    <td><?= $this->Form->control('ingredient_mappings.' . $mapIndex . '.unit_id', array('label' => false)) ?></td>
                    <td><?= $this->Form->control('ingredient_mappings.' . $mapIndex . '.qualifier', array('label' => false, 'escape' => false)) ?></td>
                    <td><?= $this->Form->control('ingredient_mappings.' . $mapIndex . '.ingredient.name', array('label' => false, 'escape' => false, 'type' => 'ui-widget')) ?></td>
                    <td><?= $this->Form->control('ingredient_mappings.' . $mapIndex . '.optional', array('label' => false)) ?></td>
                </tr>
                <?php } ?>
                </tbody>
                </table>
                <div id="ingredientDeleteResponse"></div>
                <a href="#" id="AddMoreIngredientsLink" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-circle"></i> <?= __('Add Another Ingredient') ?></a>
            </div>

            <?= $this->Form->control('directions', array('escape' => true, 'rows' => '20', 'cols' => '20', 'id' => 'directions-textarea')) ?>
            <?= $this->Form->control('use_markdown', ['id' => 'use-markdown-toggle']) ?>

            <div id="relatedRecipesSection">
                <h6 class="mb-3"><i class="bi bi-link-45deg"></i> <?= __('Related Recipes') ?></h6>
                <table id="sortableTable2" class="table table-sm">
                <tr class="headerRow">
                    <th style="width: 40px;"></th>
                    <th style="width: 40px;"></th>
                    <th><?= __('Related Recipe Name') ?></th>
                    <th><?= __('Required') ?></th>
                </tr>
                <tbody class="gridContent">
                <?php
                $relatedCount = (isset($recipe) && isset($recipe->related_recipes))? count($recipe->related_recipes) : 0;
                for ($mapIndex = 0; $mapIndex <= $relatedCount; $mapIndex++) {
                    $currentSortOrder = __("Unknown");
                    $extraItem = true;
                    $itemId = "";
                    if ($mapIndex < $relatedCount) {
                        $itemId = $recipe->related_recipes[$mapIndex]->id;
                        $currentSortOrder = $recipe->related_recipes[$mapIndex]->sort_order;
                        $extraItem = false;
                    }
                ?>
                <tr class="<?= ($extraItem) ? "extraItem" : "" ?>">
                    <td>
                        <i class="bi bi-trash icon-action text-danger delete-action"
                           data-item-id="<?= $itemId ?>"
                           title="<?= __('Delete') ?>"></i>
                    </td>
                    <td>
                        <i class="bi bi-arrows-move icon-action move-handle"
                           title="<?= __('Order Recipe - currently #' . $currentSortOrder) ?>"></i>
                    </td>
                    <td>
                        <?= $this->Form->hidden('related_recipes.' . $mapIndex . '.id') ?>
                        <?= $this->Form->hidden('related_recipes.' . $mapIndex . '.parent_id') ?>
                        <?= $this->Form->hidden('related_recipes.' . $mapIndex . '.recipe_id') ?>
                        <?= $this->Form->hidden('related_recipes.' . $mapIndex . '.sort_order') ?>
                        <?= $this->Form->control('related_recipes.' . $mapIndex . '.recipe.name', array('label' => false, 'escape' => false, 'type' => 'ui-widget')) ?></td>
                    <td><?= $this->Form->control('related_recipes.' . $mapIndex . '.required', array('label' => false)) ?></td>
                </tr>
                <?php } ?>
                </tbody>
                </table>
                <div id="recipeDeleteResponse"></div>
                <a href="#" id="AddMoreRelatedRecipesLink" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-circle"></i> <?= __('Add Another Recipe') ?></a>
            </div>
    </fieldset>
    <?= $this->Flash->render() ?>
    <?= $this->Form->submit(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<!-- Note edit modal (inline) -->
<div class="modal fade" id="editNoteDialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= __('Note') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="rowId"/>
                <textarea id="noteText" class="form-control" cols=30 rows=4></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= __('Close') ?></button>
                <button type="button" class="btn btn-primary modal-save-btn"><?= __('Save') ?></button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var recipeId = "<?= $recipeId ?>";
    var newTagNames = [];
    var easyMDE = null;

    onAppReady(function() {
        document.addEventListener("saved.ingredient", function() {
            closeModal('editIngredientDialog');
        });

        // Sortable for ingredients
        var sortable1Body = document.querySelector('#sortableTable1 tbody.gridContent');
        if (sortable1Body) {

            console.log("Sorting of Ingredients - OK");
            Sortable.create(sortable1Body, {
                animation: 150,
                handle: '.move-handle',
                filter: '.extraItem',
                onEnd: function() { reNumberIngredientsTable(); }
            });
        }

        // Sortable for related recipes
        var sortable2Body = document.querySelector('#sortableTable2 tbody.gridContent');
        if (sortable2Body) {
            Sortable.create(sortable2Body, {
                animation: 150,
                handle: '.move-handle',
                filter: '.extraItem',
                onEnd: function() { reNumberRelatedRecipesTable(); }
            });
        }

        // Fraction convert on ingredient quantity change
        document.getElementById('ingredientsSection')?.addEventListener('change', function(e) {
            if (e.target.matches('.fraction input')) {
                fractionConvert(e.target, "<?= __("Entered value is not a number/fraction, please try again.") ?>");
            }
        });

        document.getElementById('AddMoreIngredientsLink')?.addEventListener('click', function(e) {
            e.preventDefault();
            var extras = document.querySelectorAll('#ingredientsSection .extraItem input');
            extras.forEach(function(inp) {
                inp.dispatchEvent(new Event('change', { bubbles: true }));
            });
        });

        document.getElementById('AddMoreRelatedRecipesLink')?.addEventListener('click', function(e) {
            e.preventDefault();
            var extras = document.querySelectorAll('#relatedRecipesSection .extraItem input');
            extras.forEach(function(inp) {
                inp.dispatchEvent(new Event('change', { bubbles: true }));
            });
        });

        // Cleanup on submit
        var submitBtn = document.querySelector('input[type="submit"], button[type="submit"]');
        if (submitBtn) {
            submitBtn.addEventListener('click', function() {
                // Cleanup empty ingredient rows
                document.querySelectorAll('#sortableTable1 tr').forEach(function(row) {
                    var rowIsNull = true;
                    row.querySelectorAll('input').forEach(function(inp) {
                        var itemId = inp.getAttribute('id') || '';
                        if (itemId !== '' &&
                                itemId.indexOf('recipe_id') === -1 &&
                                itemId.indexOf('unit_id') === -1 &&
                                itemId.indexOf('sort_order') === -1 &&
                                itemId.indexOf('optional') === -1 &&
                                inp.value) {
                            rowIsNull = false;
                        }
                    });
                    if (rowIsNull && !row.classList.contains('headerRow')) {
                        row.remove();
                    }
                });

                // Cleanup empty related recipe rows
                document.querySelectorAll('#sortableTable2 tr').forEach(function(row) {
                    var rowIsNull = true;
                    row.querySelectorAll('input').forEach(function(inp) {
                        var itemId = inp.getAttribute('id') || '';
                        if (itemId !== '' &&
                                itemId.indexOf('parent_id') === -1 &&
                                itemId.indexOf('sort_order') === -1 &&
                                itemId.indexOf('required') === -1 && inp.value) {
                            rowIsNull = false;
                        }
                    });
                    if (rowIsNull && !row.classList.contains('headerRow')) {
                        row.remove();
                    }
                });

                reNumberIngredientsTable();
                reNumberRelatedRecipesTable();

                // Remove empty Add Image
                var fileInput = document.querySelector('#imageSection .file input');
                if (fileInput && fileInput.value === "") {
                    var imageId = fileInput.getAttribute('id').replace('Attachment', '');
                    fileInput.remove();
                    var textInput = document.querySelector('#imageSection .text input');
                    if (textInput) textInput.remove();
                    var hiddenId = document.getElementById(imageId + 'Id');
                    if (hiddenId) hiddenId.remove();
                }
                return true;
            });
        }

        initRowCopy('ingredientsSection');
        initRowCopy('relatedRecipesSection');
        initRowDelete();
        initRowNote();
        initIngredientAutoComplete();
        initRelatedAutoCompleted();
        initTagging();
        initMarkdown();
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
        var extras = document.querySelectorAll('#' + gridId + ' .extraItem input');
        extras.forEach(function(inp) {
            inp.removeEventListener('change', inp._copyHandler);
            inp._copyHandler = function() {
                var section = document.getElementById(gridId);
                var extraInputs = section.querySelectorAll('.extraItem input');
                extraInputs.forEach(function(ei) {
                    ei.removeEventListener('change', ei._copyHandler);
                });

                var original = section.querySelector('.extraItem');
                var clonedCopy = original.cloneNode(true);
                clonedCopy.querySelectorAll('input').forEach(function(ci) { ci.value = ''; });
                section.querySelector('.gridContent').appendChild(clonedCopy);
                original.className = '';
                initRowCopy(gridId);
                initRowDelete();
                if (gridId.indexOf('ingredients') > -1) {
                    initIngredientAutoComplete();
                } else {
                    initRelatedAutoCompleted();
                }
            };
            inp.addEventListener('change', inp._copyHandler);
        });
    }

    function initRowNote() {
        document.querySelectorAll('.comment-action').forEach(function(el) {
            el.removeEventListener('click', el._noteHandler);
            el._noteHandler = function() {
                var rowId = this.getAttribute('data-row-id');
                var noteInput = document.querySelector('[name="ingredient_mappings[' + rowId + '][note]"]');
                var oldNote = noteInput ? noteInput.value : '';
                document.getElementById('noteText').value = oldNote;

                var noteModal = document.getElementById('editNoteDialog');
                var modal = bootstrap.Modal.getOrCreateInstance(noteModal);

                // Set up save handler
                var saveBtn = noteModal.querySelector('.modal-save-btn');
                var newSaveBtn = saveBtn.cloneNode(true);
                saveBtn.parentNode.replaceChild(newSaveBtn, saveBtn);
                newSaveBtn.addEventListener('click', function() {
                    var newNote = document.getElementById('noteText').value;
                    if (noteInput) noteInput.value = newNote;
                    modal.hide();
                });

                modal.show();
            };
            el.addEventListener('click', el._noteHandler);
        });
    }

    function initRowDelete() {
        document.querySelectorAll('.delete-action').forEach(function(el) {
            el.removeEventListener('click', el._deleteHandler);
            el._deleteHandler = function() {
                var thisRow = this.closest('tr');
                var inIngredientsSection = !!thisRow.closest('#ingredientsSection');
                var inRelatedRecipesSection = !!thisRow.closest('#relatedRecipesSection');
                var regMatch;

                if (inIngredientsSection) {
                    regMatch = /ingredient_mappings\[\d*\]\[id\]/;
                } else if (inRelatedRecipesSection) {
                    regMatch = /related_recipes\[\d*\]\[id\]/;
                } else {
                    return;
                }

                // Don't delete the last row
                if (!thisRow.nextElementSibling) return;

                var idInputs = Array.from(thisRow.querySelectorAll('input')).filter(function(inp) {
                    return inp.name && inp.name.match(regMatch);
                });
                if (idInputs.length > 0 && idInputs[0].value.length === 0) {
                    thisRow.remove();
                    return;
                }

                if (confirm("<?= __("Are you sure you wish to remove this item?") ?>")) {
                    var itemId = this.getAttribute('data-item-id');
                    if (this.hasAttribute('data-ingredient-delete')) {
                        ajaxGet(baseUrl + "Recipes/RemoveIngredientMapping/" + recipeId + "/" + itemId, "ingredientDeleteResponse");
                    } else {
                        ajaxGet(baseUrl + "Recipes/RemoveRecipeMapping/" + recipeId + "/" + itemId, "recipeDeleteResponse");
                    }
                    thisRow.remove();
                }
            };
            el.addEventListener('click', el._deleteHandler);
        });
    }

    function reNumberIngredientsTable() {
        var i = -1;
        document.querySelectorAll('#sortableTable1 tr').forEach(function(row) {
            row.querySelectorAll('input, select').forEach(function(inp) {
                var nodeName = inp.getAttribute('name');
                if (!nodeName) return;
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
                    inp.value = recipeId;
                }
                else if (nodeName.indexOf("ingredient_id") > -1) {
                    newNodeId = "ingredient-mappings-" + i + "-ingredient_id";
                    newNodeName = "ingredient_mappings[" + i + "][ingredient_id]";
                }
                else if (nodeName.indexOf("sort_order") > -1) {
                    newNodeId = "ingredient-mappings-" + i + "-sort_order";
                    newNodeName = "ingredient_mappings[" + i + "][sort_order]";
                    inp.value = i;
                }
                else if (nodeName.indexOf("optional") > -1) {
                    newNodeId = "ingredient-mappings-" + i + "-optional";
                    newNodeName = "ingredient_mappings[" + i + "][optional]";
                }
                else if (nodeName.indexOf("id") > -1) {
                    newNodeId = "ingredient-mappings-" + i + "-id";
                    newNodeName = "ingredient_mappings[" + i + "][id]";
                } else {
                    return;
                }

                inp.setAttribute('name', newNodeName);
                inp.setAttribute('id', newNodeId);
            });
            i++;
        });
    }

    function reNumberRelatedRecipesTable() {
        var i = -1;
        document.querySelectorAll('#sortableTable2 tr').forEach(function(row) {
            row.querySelectorAll('input, select').forEach(function(inp) {
                var nodeName = inp.getAttribute('name');
                if (!nodeName) return;
                var newNodeName = "";
                var newNodeId = "";

                if (nodeName.indexOf("name") > -1) {
                    newNodeId = "related-recipes-" + i + "-recipe-name";
                    newNodeName = "related_recipes[" + i + "][recipe][name]";
                }
                else if (nodeName.indexOf("required") > -1) {
                    newNodeId = "related-recipes-" + i + "-required";
                    newNodeName = "related_recipes[" + i + "][required]";
                }
                else if (nodeName.indexOf('recipe_id') > -1) {
                    newNodeId = "related-recipes-" + i + "-recipe_id";
                    newNodeName = "related_recipes[" + i + "][recipe_id]";
                }
                else if (nodeName.indexOf('parent_id') > -1) {
                    newNodeId = "related-recipes-" + i + "-parent_id";
                    newNodeName = "related_recipes[" + i + "][parent_id]";
                    inp.value = recipeId;
                }
                else if (nodeName.indexOf("sort_order") > -1) {
                    newNodeId = "related-recipes-" + i + "-sort_order";
                    newNodeName = "related_recipes[" + i + "][sort_order]";
                    inp.value = i;
                }
                else if (nodeName.indexOf("id") > -1) {
                    newNodeId = "related-recipes-" + i + "-id";
                    newNodeName = "related_recipes[" + i + "][id]";
                } else {
                    return;
                }

                inp.setAttribute('name', newNodeName);
                inp.setAttribute('id', newNodeId);
            });
            i++;
        });
    }

    function initAutocomplete(inputType, getUrl, regMatch) {
        var sectionId = "";
        var findInputFilter = "";
        if (inputType == "recipe") {
            sectionId = "#relatedRecipesSection";
            findInputFilter = "input[id$=-recipe_id]";
        } else {
            sectionId = "#ingredientsSection";
            findInputFilter = "input[id$=-ingredient_id]";
        }

        document.querySelectorAll(sectionId + " input[type='ui-widget']").forEach(function(inp) {
            if (inp._autocompleteInit) return;
            inp._autocompleteInit = true;
            inp.type = 'text';

            initVanillaAutocomplete(inp, {
                source: baseUrl + getUrl,
                minLength: 1,
                autoFocus: true,
                select: function(event, ui) {
                    var row = inp.closest('tr');
                    var idField = row.querySelector(findInputFilter);

                    if (!ui.item.id || ui.item.id.length == 0) {
                        inp.value = "";
                        if (idField) idField.value = "";
                    } else {
                        if (idField) idField.value = ui.item.id;
                    }
                    return false;
                },
                change: function(event, ui) {
                    if (ui.item) return;
                    inp.value = "";
                    var row = inp.closest('tr');
                    if (row) {
                        row.querySelectorAll('input').forEach(function(field) {
                            if (field !== inp) field.value = "";
                        });
                    }
                }
            });
        });
    }
</script>

<?php
$this->Html->css('https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css', ['block' => true]);
$this->Html->script('https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js', ['block' => true]);
?>

<script type="text/javascript">
    function initMarkdown() {
        var markdownToggle = document.getElementById('use-markdown-toggle');
        toggleMarkdownEditor();
        markdownToggle.addEventListener('change', toggleMarkdownEditor);  
    }

    function toggleMarkdownEditor() {
        var markdownToggle = document.getElementById('use-markdown-toggle');
        if (markdownToggle && markdownToggle.checked) {
            initEasyMDE();
        } else {
            destroyEasyMDE();
        }
    }

    function initEasyMDE() {
        var directionsTextarea = document.getElementById('directions-textarea');
        if (easyMDE === null && directionsTextarea) {
            easyMDE = new EasyMDE({
                element: directionsTextarea,
                spellChecker: false,
                status: false,
                toolbar: [
                    'bold', 'italic', 'heading', '|',
                    'unordered-list', 'ordered-list', '|',
                    'link', 'quote', 'code', '|',
                    'preview', 'side-by-side', 'fullscreen', '|',
                    'guide'
                ]
            });
        }
    }

    function destroyEasyMDE() {
        if (easyMDE !== null) {
            easyMDE.toTextArea();
            easyMDE = null;
        }
    }

</script>

<script type="text/javascript">
    function initTagging() {
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-tag')) {
                e.preventDefault();
                var pill = e.target.closest('.tag-pill');
                var tagId = pill.dataset.tagId;
                if (!tagId) {
                    var name = pill.textContent.trim().replace(/\u00d7$/, '').trim();
                    newTagNames = newTagNames.filter(function(n) { return n !== name; });
                    updateNewTagsInput();
                }
                pill.remove();
            }
        });

        var tagInput = document.getElementById('tagInput');
        if (tagInput) {
            initVanillaAutocomplete(tagInput, {
                source: baseUrl + 'Tags/autoCompleteSearch',
                minLength: 1,
                autoFocus: false,
                select: function(event, ui) {
                    if (ui.item.create) {
                        addTagPill('', ui.item.create);
                    } else if (ui.item.id) {
                        addTagPill(ui.item.id, ui.item.value);
                    }
                    tagInput.value = '';
                    return false;
                }
            });

            tagInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    var val = this.value.trim();
                    if (val.length > 0) {
                        addTagPill('', val);
                        this.value = '';
                    }
                }
            });
        }
    }

    function updateNewTagsInput() {
        document.getElementById('newTagsInput').value = newTagNames.join(',');
    }

    function isTagAlreadyAdded(tagId, tagName) {
        var found = false;
        document.querySelectorAll('#tagPills .tag-pill').forEach(function(pill) {
            var existingId = pill.dataset.tagId;
            var existingName = pill.textContent.trim().replace(/\u00d7$/, '').trim();
            if ((tagId && existingId == tagId) || (!tagId && existingName.toLowerCase() === tagName.toLowerCase())) {
                found = true;
            }
        });
        return found;
    }

    function addTagPill(tagId, tagName) {
        if (isTagAlreadyAdded(tagId, tagName)) return;

        var pill = document.createElement('span');
        pill.className = 'tag-pill';
        pill.dataset.tagId = tagId || '';
        pill.textContent = tagName + ' ';

        var removeLink = document.createElement('a');
        removeLink.href = '#';
        removeLink.className = 'remove-tag';
        removeLink.title = '<?= __("Remove") ?>';
        removeLink.innerHTML = '&times;';
        pill.appendChild(removeLink);

        if (tagId) {
            var hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'tags[_ids][]';
            hidden.value = tagId;
            pill.appendChild(hidden);
        } else {
            newTagNames.push(tagName);
            updateNewTagsInput();
        }

        document.getElementById('tagPills').appendChild(pill);
    }
</script>
