<?php
use Cake\Routing\Router;

$recipeId = isset($recipe->id) ? $recipe->id : "";
$baseUrl = Router::url('/');
?>

<div class="actions-bar">
    <?php if (isset($recipe->id)) :?>
    <?= $this->Html->link(__('View Recipe'), ['action' => 'view', $recipe->id], ['class' => 'btn btn-outline-primary btn-sm']) ?>
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
<?= $this->Form->create($recipe, ['type' => 'file', 'id' => 'recipeEditForm']) ?>
    <?= $this->Form->hidden('id') ?>
    <?= $this->Form->hidden('user_id') ?>

    <!-- Sticky tab navigation with always-visible Save button -->
    <div class="recipe-editor-nav">
        <ul class="nav nav-tabs" id="recipeTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-details-btn" data-bs-toggle="tab" data-bs-target="#tab-details" type="button" role="tab" aria-selected="true">
                    <i class="bi bi-card-text"></i><span> <?= __('Details') ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-classify-btn" data-bs-toggle="tab" data-bs-target="#tab-classify" type="button" role="tab" aria-selected="false">
                    <i class="bi bi-tags"></i><span> <?= __('Classify') ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-ingredients-btn" data-bs-toggle="tab" data-bs-target="#tab-ingredients" type="button" role="tab" aria-selected="false">
                    <i class="bi bi-list-check"></i><span> <?= __('Ingredients') ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-directions-btn" data-bs-toggle="tab" data-bs-target="#tab-directions" type="button" role="tab" aria-selected="false">
                    <i class="bi bi-pencil-square"></i><span> <?= __('Directions') ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-media-btn" data-bs-toggle="tab" data-bs-target="#tab-media" type="button" role="tab" aria-selected="false">
                    <i class="bi bi-images"></i><span> <?= __('Media') ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-related-btn" data-bs-toggle="tab" data-bs-target="#tab-related" type="button" role="tab" aria-selected="false">
                    <i class="bi bi-link-45deg"></i><span> <?= __('Related') ?></span>
                </button>
            </li>
        </ul>
        <div class="recipe-save-area">
            <button type="submit" class="btn btn-primary btn-sm" id="mainSaveBtn"><?= __('Save Recipe') ?></button>
        </div>
    </div>

    <?= $this->Flash->render() ?>

    <!-- Tab content -->
    <div class="tab-content recipe-tab-content" id="recipeTabContent">

        <!-- DETAILS -->
        <div class="tab-pane fade show active" id="tab-details" role="tabpanel" aria-labelledby="tab-details-btn">
            <?php
            echo $this->Form->control('name');
            echo $this->Form->control('comments', ['escape' => true, 'rows' => '3']);
            echo $this->Form->control('source_id',
                ['empty' => true,
                 'after' => $this->Html->link(__('Edit'),
                    ['controller' => 'sources', 'action' => 'index'],
                    ['class' => 'nagivationLink', 'targetId' => 'content', 'id' => 'sourcesEditLink'])]);
            echo $this->Form->control('source_description');
            echo $this->Form->control('private', ['options' => ['0' => 'No', '1' => 'Yes']]);
            echo $this->Form->control('system_type', ['options' => ['usa' => 'USA', 'metric' => 'Metric']]);
            ?>
        </div>

        <!-- CLASSIFY -->
        <div class="tab-pane fade" id="tab-classify" role="tabpanel" aria-labelledby="tab-classify-btn">
            <div id="tagsSection" class="mb-3">
                <label for="tagInput" class="form-label"><?= __('Tags') ?></label>
                <div class="d-flex flex-wrap align-items-center gap-1">
                    <span id="tagPills"><?php if (isset($recipe->tags) && !empty($recipe->tags)): ?><?php foreach ($recipe->tags as $tag): ?><span class="tag-pill" data-tag-name="<?= h($tag->name) ?>"><?= h($tag->name) ?><a href="#" class="remove-tag" title="<?= __('Remove') ?>">&times;</a></span><?php endforeach; ?><?php endif; ?></span>
                    <span style="position: relative; display: inline-block;">
                        <input type="text" id="tagInput" class="form-control form-control-sm" style="width: auto; min-width: 150px;" placeholder="<?= __('i.e vegan, kid-friendly') ?>" />
                    </span>
                </div>
                <input type="hidden" name="tags_list" id="tagsListInput" value="<?= h($recipe->tags_list ?? '') ?>" />
            </div>
            <div class="classify-grid">
                <?php
                echo $this->Form->control('course_id', ['empty' => true]);
                echo $this->Form->control('base_type_id', ['empty' => true]);
                echo $this->Form->control('preparation_method_id', ['empty' => true]);
                echo $this->Form->control('ethnicity_id', ['empty' => true]);
                echo $this->Form->control('preparation_time_id', ['empty' => true]);
                echo $this->Form->control('difficulty_id', ['empty' => true]);
                echo $this->Form->control('serving_size');
                ?>
            </div>
        </div>

        <!-- INGREDIENTS -->
        <div class="tab-pane fade" id="tab-ingredients" role="tabpanel" aria-labelledby="tab-ingredients-btn">
            <div id="ingredientsSection">
                <table id="sortableTable1" class="table table-sm table-borderless">
                <tr class="headerRow">
                    <th style="width: 40px;"></th>
                    <th style="width: 40px;"></th>
                    <th style="width: 40px;"></th>
                    <th><?= __('Quantity') ?></th>
                    <th><?= __('Units') ?></th>
                    <th><?= __('Qualifier') ?></th>
                    <th><?= __('Ingredient') ?></th>
                    <th><?= __('Optional') ?></th>
                </tr>
                <tbody class="gridContent">
                <?php
                $ingredientCount = (isset($recipe) && isset($recipe->ingredient_mappings)) ? count($recipe->ingredient_mappings) : 0;
                for ($mapIndex = 0; $mapIndex <= $ingredientCount; $mapIndex++) {
                    $currentSortOrder = __("Unknown");
                    $extraItem = true;
                    $itemId = "";
                    $noteValue = "";
                    if ($mapIndex < $ingredientCount) {
                        $itemId = $recipe->ingredient_mappings[$mapIndex]->id;
                        $currentSortOrder = $recipe->ingredient_mappings[$mapIndex]->sort_order;
                        $noteValue = $recipe->ingredient_mappings[$mapIndex]->note ?? "";
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
                        <i class="bi <?= !empty($noteValue) ? 'bi-chat-dots-fill' : 'bi-chat-dots' ?> icon-action comment-action"
                           data-row-id="<?= $mapIndex ?>"
                           title="<?= __('Add or edit a note') ?>"></i>
                    </td>
                    <td>
                        <?= $this->Form->hidden('ingredient_mappings.' . $mapIndex . '.id') ?>
                        <?= $this->Form->hidden('ingredient_mappings.' . $mapIndex . '.recipe_id') ?>
                        <?= $this->Form->hidden('ingredient_mappings.' . $mapIndex . '.ingredient_id') ?>
                        <?= $this->Form->hidden('ingredient_mappings.' . $mapIndex . '.sort_order') ?>
                        <?= $this->Form->hidden('ingredient_mappings.' . $mapIndex . '.note') ?>
                        <?= $this->Form->control('ingredient_mappings.' . $mapIndex . '.quantity', ['label' => false, 'type' => 'fraction']) ?></td>
                    <td><?= $this->Form->control('ingredient_mappings.' . $mapIndex . '.unit_id', ['label' => false]) ?></td>
                    <td><?= $this->Form->control('ingredient_mappings.' . $mapIndex . '.qualifier', ['label' => false, 'escape' => false]) ?></td>
                    <td><?= $this->Form->control('ingredient_mappings.' . $mapIndex . '.ingredient.name', ['label' => false, 'escape' => false, 'type' => 'ui-widget']) ?></td>
                    <td><?= $this->Form->control('ingredient_mappings.' . $mapIndex . '.optional', ['label' => false]) ?></td>
                </tr>
                <?php } ?>
                </tbody>
                </table>
                <div id="ingredientDeleteResponse"></div>
                <a href="#" id="AddMoreIngredientsLink" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-circle"></i> <?= __('Add Another Ingredient') ?></a>
                &nbsp;<?= $this->Html->link(__('Add Source Ingredient'), ['controller' => 'ingredients', 'action' => 'edit'],
                    ['class' => 'ajaxLink btn btn-sm btn-outline-secondary', 'targetId' => 'editIngredientDialog', 'id' => 'addNewIngredientsLink']) ?>
            </div>
        </div>

        <!-- DIRECTIONS -->
        <div class="tab-pane fade" id="tab-directions" role="tabpanel" aria-labelledby="tab-directions-btn">
            <?= $this->Form->control('directions', ['escape' => true, 'rows' => '22', 'cols' => '20', 'id' => 'directions-textarea', 'label' => false]) ?>
            <?= $this->Form->control('use_markdown', ['id' => 'use-markdown-toggle']) ?>
        </div>

        <!-- MEDIA -->
        <div class="tab-pane fade" id="tab-media" role="tabpanel" aria-labelledby="tab-media-btn">
            <?php
            $imageCount = (isset($recipe) && isset($recipe->attachments)) ? count($recipe->attachments) : 0;
            $newImageIndex = $imageCount;
            ?>

            <?php if ($imageCount > 0): ?>
            <h6 class="mb-3 text-muted text-uppercase" style="font-size:0.75rem;letter-spacing:0.08em;"><?= __('Current Images') ?></h6>
            <div id="currentImages" class="media-gallery mb-4">
            <?php for ($imageIndex = 0; $imageIndex < $imageCount; $imageIndex++):
                $imageName = $recipe->attachments[$imageIndex]->attachment;
                if (!is_string($imageName)) continue;
                $imageCaption = $recipe->attachments[$imageIndex]->name;
                $imageId = $recipe->attachments[$imageIndex]->id;
            ?>
                <div class="media-image-card">
                    <?= $this->Form->hidden('attachments.' . $imageIndex . '.id') ?>
                    <div class="media-image-wrap">
                        <img src="<?= $baseUrl ?>files/Attachments/attachment/<?= h($imageName) ?>" alt="<?= h($imageCaption) ?>"/>
                        <?= $this->Html->link('<i class="bi bi-trash3"></i>', ['action' => 'deleteAttachment', $recipeId, $imageId],
                            ['class' => 'media-delete-btn', 'escape' => false, 'title' => __('Delete image'),
                             'onclick' => "return confirm('" . __('Are you sure you want to delete this image?') . "');"]) ?>
                    </div>
                    <?= $this->Form->text('attachments.' . $imageIndex . '.name', [
                        'value' => $imageCaption,
                        'class' => 'media-caption-input',
                        'placeholder' => __('Caption'),
                        'aria-label' => __('Caption'),
                        'required' => true,
                    ]) ?>
                </div>
            <?php endfor; ?>
            </div>
            <?php endif; ?>

            <h6 class="mb-3 text-muted text-uppercase" style="font-size:0.75rem;letter-spacing:0.08em;"><?= __('Add Image') ?></h6>
            <div id="newImageSection">
                <div class="media-upload-zone" id="mediaUploadZone" role="button" tabindex="0" aria-label="<?= __('Upload image') ?>">
                    <i class="bi bi-cloud-arrow-up media-upload-icon"></i>
                    <p class="media-upload-text mb-1"><?= __('Drag & drop an image here, or click to browse') ?></p>
                    <small class="text-muted"><?= __('JPG, PNG, GIF') ?></small>
                    <?= $this->Form->file('attachments.' . $newImageIndex . '.attachment',
                        ['id' => 'attachments-' . $newImageIndex . '-attachment', 'accept' => 'image/*', 'class' => 'media-file-input']) ?>
                </div>

                <div id="mediaPreviewArea" class="media-preview-area d-none">
                    <img id="mediaPreviewImg" src="" alt="<?= __('Preview') ?>" class="media-preview-img"/>
                    <div>
                        <div id="mediaPreviewName" class="fw-semibold small mb-2"></div>
                        <button type="button" id="mediaClearBtn" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> <?= __('Remove') ?>
                        </button>
                    </div>
                </div>

                <div class="mt-3">
                    <?= $this->Form->control('attachments.' . $newImageIndex . '.name', ['label' => __('Caption'), 'required' => false, 'id' => 'newImageCaption']) ?>
                </div>
            </div>
        </div>

        <!-- RELATED RECIPES -->
        <div class="tab-pane fade" id="tab-related" role="tabpanel" aria-labelledby="tab-related-btn">
            <div id="relatedRecipesSection">
                <table id="sortableTable2" class="table table-sm table-borderless">
                <tr class="headerRow">
                    <th style="width: 40px;"></th>
                    <th style="width: 40px;"></th>
                    <th><?= __('Related Recipe Name') ?></th>
                    <th><?= __('Required') ?></th>
                </tr>
                <tbody class="gridContent">
                <?php
                $relatedCount = (isset($recipe) && isset($recipe->related_recipes)) ? count($recipe->related_recipes) : 0;
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
                        <?= $this->Form->control('related_recipes.' . $mapIndex . '.recipe.name', ['label' => false, 'escape' => false, 'type' => 'ui-widget']) ?></td>
                    <td><?= $this->Form->control('related_recipes.' . $mapIndex . '.required', ['label' => false]) ?></td>
                </tr>
                <?php } ?>
                </tbody>
                </table>
                <div id="recipeDeleteResponse"></div>
                <a href="#" id="AddMoreRelatedRecipesLink" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-circle"></i> <?= __('Add Another Recipe') ?></a>
            </div>
        </div>

    </div><!-- /tab-content -->

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
    var easyMDE = null;

    onAppReady(function() {
        document.addEventListener("saved.ingredient", function() {
            closeModal('editIngredientDialog');
        });

        // Sortable for ingredients
        var sortable1Body = document.querySelector('#sortableTable1 tbody.gridContent');
        if (sortable1Body) {
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
            if (e.target.matches('input[type="fraction"]')) {
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
        document.getElementById('mainSaveBtn')?.addEventListener('click', function() {
            cleanupBeforeSubmit();
        });

        // EasyMDE: defer initialization until the Directions tab is shown
        document.getElementById('tab-directions-btn')?.addEventListener('shown.bs.tab', function() {
            var markdownToggle = document.getElementById('use-markdown-toggle');
            if (markdownToggle?.checked && easyMDE === null) {
                initEasyMDE();
            }
        });

        // Highlight any tabs that received validation errors, jump to the first
        markTabsWithErrors();

        initRowCopy('ingredientsSection');
        initRowCopy('relatedRecipesSection');
        initRowDelete();
        initRowNote();
        initIngredientAutoComplete();
        initRelatedAutoCompleted();
        initTagging();
        initMarkdown();
        initMediaUpload();
    });

    function markTabsWithErrors() {
        var firstErrorPane = null;
        document.querySelectorAll('.tab-pane').forEach(function(pane) {
            var hasErrors = pane.querySelector('.is-invalid') !== null;
            var btn = document.querySelector('[data-bs-target="#' + pane.id + '"]');
            if (btn && hasErrors) {
                if (!btn.querySelector('.tab-error-dot')) {
                    var dot = document.createElement('span');
                    dot.className = 'tab-error-dot';
                    btn.appendChild(dot);
                }
                if (!firstErrorPane) firstErrorPane = pane;
            }
        });
        if (firstErrorPane) {
            var btn = document.querySelector('[data-bs-target="#' + firstErrorPane.id + '"]');
            if (btn) bootstrap.Tab.getOrCreateInstance(btn).show();
        }
    }

    function cleanupBeforeSubmit() {
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

        // Remove new image fields if no file was selected
        var fileInput = document.querySelector('#newImageSection input[type="file"]');
        if (fileInput && fileInput.value === "") {
            document.getElementById('newImageSection')?.querySelectorAll('input').forEach(function(inp) { inp.remove(); });
        }
    }

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

                var saveBtn = noteModal.querySelector('.modal-save-btn');
                var newSaveBtn = saveBtn.cloneNode(true);
                saveBtn.parentNode.replaceChild(newSaveBtn, saveBtn);
                newSaveBtn.addEventListener('click', function() {
                    var newNote = document.getElementById('noteText').value;
                    if (noteInput) noteInput.value = newNote;
                    el.classList.toggle('bi-chat-dots-fill', newNote.trim().length > 0);
                    el.classList.toggle('bi-chat-dots', newNote.trim().length === 0);
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
                } else if (nodeName.indexOf("unit_id") > -1) {
                    newNodeId = "ingredient-mappings-" + i + "-unit_id";
                    newNodeName = "ingredient_mappings[" + i + "][unit_id]";
                } else if (nodeName.indexOf("qualifier") > -1) {
                    newNodeId = "ingredient-mappings-" + i + "-qualifier";
                    newNodeName = "ingredient_mappings[" + i + "][qualifier]";
                } else if (nodeName.indexOf("note") > -1) {
                    newNodeId = "ingredient-mappings-" + i + "-note";
                    newNodeName = "ingredient_mappings[" + i + "][note]";
                } else if (nodeName.indexOf("[ingredient][name]") > -1) {
                    newNodeId = "ingredient-mappings-" + i + "-ingredient-name";
                    newNodeName = "ingredient_mappings[" + i + "][ingredient][name]";
                } else if (nodeName.indexOf("recipe_id") > -1) {
                    newNodeId = "ingredient-mappings-" + i + "-recipe_id";
                    newNodeName = "ingredient_mappings[" + i + "][recipe_id]";
                    inp.value = recipeId;
                } else if (nodeName.indexOf("ingredient_id") > -1) {
                    newNodeId = "ingredient-mappings-" + i + "-ingredient_id";
                    newNodeName = "ingredient_mappings[" + i + "][ingredient_id]";
                } else if (nodeName.indexOf("sort_order") > -1) {
                    newNodeId = "ingredient-mappings-" + i + "-sort_order";
                    newNodeName = "ingredient_mappings[" + i + "][sort_order]";
                    inp.value = i;
                } else if (nodeName.indexOf("optional") > -1) {
                    newNodeId = "ingredient-mappings-" + i + "-optional";
                    newNodeName = "ingredient_mappings[" + i + "][optional]";
                } else if (nodeName.indexOf("id") > -1) {
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
                } else if (nodeName.indexOf("required") > -1) {
                    newNodeId = "related-recipes-" + i + "-required";
                    newNodeName = "related_recipes[" + i + "][required]";
                } else if (nodeName.indexOf('recipe_id') > -1) {
                    newNodeId = "related-recipes-" + i + "-recipe_id";
                    newNodeName = "related_recipes[" + i + "][recipe_id]";
                } else if (nodeName.indexOf('parent_id') > -1) {
                    newNodeId = "related-recipes-" + i + "-parent_id";
                    newNodeName = "related_recipes[" + i + "][parent_id]";
                    inp.value = recipeId;
                } else if (nodeName.indexOf("sort_order") > -1) {
                    newNodeId = "related-recipes-" + i + "-sort_order";
                    newNodeName = "related_recipes[" + i + "][sort_order]";
                    inp.value = i;
                } else if (nodeName.indexOf("id") > -1) {
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
                        inp.value = ui.item.value || ui.item.label || '';
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

    function initMediaUpload() {
        var zone       = document.getElementById('mediaUploadZone');
        var fileInput  = document.querySelector('#newImageSection input[type="file"]');
        var caption    = document.getElementById('newImageCaption');
        var preview    = document.getElementById('mediaPreviewArea');
        var previewImg = document.getElementById('mediaPreviewImg');
        var previewName = document.getElementById('mediaPreviewName');
        var clearBtn   = document.getElementById('mediaClearBtn');

        if (!zone || !fileInput) return;

        zone.addEventListener('click', function() { fileInput.click(); });
        zone.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); fileInput.click(); }
        });

        zone.addEventListener('dragover', function(e) { e.preventDefault(); zone.classList.add('drag-over'); });
        zone.addEventListener('dragleave', function(e) { if (!zone.contains(e.relatedTarget)) zone.classList.remove('drag-over'); });
        zone.addEventListener('drop', function(e) {
            e.preventDefault();
            zone.classList.remove('drag-over');
            var files = e.dataTransfer.files;
            if (files.length > 0) {
                var dt = new DataTransfer();
                dt.items.add(files[0]);
                fileInput.files = dt.files;
                showPreview(files[0]);
            }
        });

        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) showPreview(fileInput.files[0]);
        });

        clearBtn?.addEventListener('click', function() {
            fileInput.value = '';
            preview.classList.add('d-none');
            zone.classList.remove('d-none');
            if (caption) { caption.required = false; caption.value = ''; }
        });

        function showPreview(file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewName.textContent = file.name;
                preview.classList.remove('d-none');
                zone.classList.add('d-none');
                if (caption) caption.required = true;
            };
            reader.readAsDataURL(file);
        }
    }

    function initMarkdown() {
        var markdownToggle = document.getElementById('use-markdown-toggle');
        if (!markdownToggle) return;

        // Only auto-initialize if the Directions tab is already active (e.g. after error redirect)
        var directionsPane = document.getElementById('tab-directions');
        if (directionsPane?.classList.contains('active') && markdownToggle.checked) {
            initEasyMDE();
        }

        markdownToggle.addEventListener('change', function() {
            if (document.getElementById('tab-directions')?.classList.contains('active')) {
                toggleMarkdownEditor();
            }
        });
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

    function initTagging() {
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-tag')) {
                e.preventDefault();
                e.target.closest('.tag-pill').remove();
                updateTagsList();
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

    function updateTagsList() {
        var names = [];
        document.querySelectorAll('#tagPills .tag-pill').forEach(function(pill) {
            var name = pill.dataset.tagName;
            if (name) names.push(name);
        });
        document.getElementById('tagsListInput').value = names.join(',');
    }

    function isTagAlreadyAdded(tagId, tagName) {
        var found = false;
        document.querySelectorAll('#tagPills .tag-pill').forEach(function(pill) {
            if ((pill.dataset.tagName || '').toLowerCase() === tagName.toLowerCase()) {
                found = true;
            }
        });
        return found;
    }

    function addTagPill(tagId, tagName) {
        if (isTagAlreadyAdded(tagId, tagName)) return;

        var pill = document.createElement('span');
        pill.className = 'tag-pill';
        pill.dataset.tagName = tagName;
        pill.textContent = tagName + ' ';

        var removeLink = document.createElement('a');
        removeLink.href = '#';
        removeLink.className = 'remove-tag';
        removeLink.title = '<?= __("Remove") ?>';
        removeLink.innerHTML = '&times;';
        pill.appendChild(removeLink);

        document.getElementById('tagPills').appendChild(pill);
        updateTagsList();
    }
</script>
