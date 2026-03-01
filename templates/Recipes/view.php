<?php
use Cake\Routing\Router;

$recipeId = $recipe->id;
$scale = 1;
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
    onAppReady(function() {
        // Star rating (read-only)
        var ratingEl = document.getElementById('recipeRating');
        if (ratingEl) {
            createStarRating(ratingEl, {
                value: <?= $averageRating ?>,
                readonly: true
            });
        }

        // Source tooltip using Bootstrap popover
        var sourceEl = document.getElementById('qtipSource');
        if (sourceEl) {
            var sourceData = document.getElementById('qtipSourceData');
            if (sourceData) {
                new bootstrap.Popover(sourceEl, {
                    content: sourceData.innerHTML,
                    html: true,
                    trigger: 'click',
                    placement: 'bottom'
                });
            }
        }

        document.getElementById('viewRefresh')?.addEventListener('click', function(e) {
            e.preventDefault();
            var newServings = document.getElementById('viewServings').value;
            ajaxNavigate("recipes/view/<?= $recipeId ?>/" + newServings);
        });

        document.getElementById('doubleRefresh')?.addEventListener('click', function(e) {
            e.preventDefault();
            var newServings = document.getElementById('viewServings').value * 2;
            ajaxNavigate("recipes/view/<?= $recipeId ?>/" + newServings);
        });
    });

    function loadImage(imageUrl, caption) {
        var img = document.querySelector('#selectedRecipeImage img');
        if (img) {
            img.setAttribute('src', imageUrl);
            img.setAttribute('title', caption);
        }
        return false;
    }
</script>
<div class="recipes view recipe-view">
    <h2><?= h($recipe->name) ?></h2>
    <div class="d-flex align-items-center gap-3 mb-3">
        <div id="recipeRating"></div>
        <?= $this->Html->link($numberOfReviews . ' ' . __('Review(s)'), array('controller'=>'reviews', 'action' => 'index', $recipeId)) ?>
    </div>

    <div class="actions-bar">
        <?php if ($loggedIn):?>
        <?= $this->Html->link('<i class="bi bi-pencil"></i> ' . __('Edit'), array('action' => 'edit', $recipeId), ['escape' => false, 'class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Html->link('<i class="bi bi-chat-dots"></i> ' . __('Add Review'), array('controller'=>'reviews', 'action' => 'edit', $recipeId), ['escape' => false, 'class' => 'btn btn-outline-primary btn-sm']) ?>
        <?= $this->Html->link('<i class="bi bi-cart-plus"></i> ' . __('Add to shopping list'), array('controller' => 'shoppingLists', 'action' => 'addRecipe', 0, $recipeId, $servings), ['escape' => false, 'class' => 'btn btn-outline-primary btn-sm']) ?>
        <?php endif;?>
        <a href="#" onclick="window.print(); return false;" class="btn btn-outline-primary btn-sm"><i class="bi bi-printer"></i> <?= __('Print') ?></a>
        <?php if ($loggedIn) :?>
        <div class="dropdown d-inline-block">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-three-dots"></i> <?= __('More') ?>
            </button>
            <ul class="dropdown-menu">
                <li><?= $this->Html->link('<i class="bi bi-download me-1"></i>' . __('Import'), ['controller' => 'import', 'action' => 'index'], ['escape' => false, 'class' => 'dropdown-item ajaxLink']) ?></li>
                <li><?= $this->Html->link('<i class="bi bi-upload me-1"></i>' . __('Export'), ['controller' => 'export', 'action' => 'edit'], ['escape' => false, 'class' => 'dropdown-item ajaxLink']) ?></li>
            </ul>
        </div>
        <?php endif;?>
    </div>

    <div class="row">
        <div class="col-md-6">
            <dl>
                <dt><?= __('Ethnicity') ?></dt>
                <dd><?= h($recipe->ethnicity->name) ?>&nbsp;</dd>
                <dt><?= __('Base Type') ?></dt>
                <dd><?= h($recipe->base_type->name) ?>&nbsp;</dd>
                <dt><?= __('Course') ?></dt>
                <dd><?= h($recipe->course->name) ?>&nbsp;</dd>
                <dt><?= __('Preparation Time') ?></dt>
                <dd><?= h($recipe->preparation_time->name) ?>&nbsp;</dd>
                <dt><?= __('Difficulty') ?></dt>
                <dd><?= h($recipe->difficulty->name) ?>&nbsp;</dd>
                <dt><?= __('Serving Size') ?></dt>
                <dd>
                    <div class="d-flex align-items-center gap-2">
                        <input type="text" id="viewServings" class="form-control form-control-sm" style="width: 4rem;" value="<?= $servings ?>"/>
                        <a id="doubleRefresh" title="<?= __('Double it') ?>" href="#" class="btn btn-sm btn-outline-primary">x 2</a>
                        <a id="viewRefresh" href="#" class="btn btn-sm btn-primary"><?= __('Refresh') ?></a>
                    </div>
                </dd>
            </dl>
        </div>
        <div class="col-md-6">
            <dl>
                <dt><?= __('Comments') ?></dt>
                <dd><?= h($recipe->comments) ?>&nbsp;</dd>
                <dt><?= __('Source') ?></dt>
                <dd>
                    <?php if (isset($recipe->source)) { ?>
                        <a href="#" id="qtipSource" class="text-decoration-underline"><?= $recipe->source->name ?></a>
                        <div id="qtipSourceData" class="d-none">
                            <?= $recipe->source->description ?>
                        </div>
                    <?php } ?>
                    &nbsp;
                </dd>
                <dt><?= __('Source Description') ?></dt>
                <dd><?= h($recipe->source_description) ?>&nbsp;</dd>
                <dt><?= __('Last Modified') ?></dt>
                <dd><?= h($recipe->modified) ?>&nbsp;</dd>
                <dt><?= __('User') ?></dt>
                <dd><?= h($recipe->user->name) ?></dd>
            </dl>
        </div>
    </div>

    <?php if (!empty($recipe->tags)): ?>
    <div class="mb-3">
        <strong><?= __('Tags') ?></strong>
        <?php foreach ($recipe->tags as $tag): ?>
            <?= $this->Html->link(h($tag->name),
                ['controller' => 'Recipes', 'action' => 'findByTag', $tag->id],
                ['class' => 'tag-label']) ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <hr/>

    <div class="row mt-3">
        <?php
            $imageCount = (isset($recipe) && $recipe->attachments)? count($recipe->attachments) : 0;
            $colClass = $imageCount > 0 ? 'col-md-6' : 'col-12';
        ?>
        <div class="<?= $colClass ?>">
            <h5><i class="bi bi-list-check"></i> <?= __('Ingredients') ?></h5>
            <table class="ingredients-table">
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
                    <td class="ingredientViewUnit"><?= "$quantity $unit" ?></td>
                    <td><?= "$qualifier <b>$ingredientName</b> <i>$optional</i> " ?></td>
                    <td>
                        <?php if ($note) :?>
                        <div class="alert alert-info py-1 px-2 mb-0 small" role="alert"><?= "$note" ?></div>
                        <?php endif;?>
                    </td>
                </tr>
                <?php endfor; ?>
            </table>
        </div>
        <?php if ($imageCount > 0): ?>
        <div class="col-md-6" id="imagePreview">
            <?php
            $baseUrl = Router::url('/');
            $imageName = $recipe->attachments[0]->attachment;
            $imagePreview = preg_replace('/(.*)\.(.*)/i', '${1}.$2', $imageName);
            $imageCaption = $recipe->attachments[0]->name;

            echo "<div id='selectedRecipeImage' class='mb-3'>";
            echo '<img src="' . $baseUrl . 'files/Attachments/attachment/' .
                        $imagePreview . '" title="' . $imageCaption . '" class="img-fluid rounded" style="max-height: 300px;"/>';
            echo "</div>";
            echo "<div id='previewImageOptions' class='d-flex flex-wrap gap-2'>";
            if ($imageCount > 1) {
                for ($imageIndex = 0; $imageIndex < $imageCount; $imageIndex++) {
                    $imageName = $recipe->attachments[$imageIndex]->attachment;
                    $imageThumb = preg_replace('/(.*)\.(.*)/i', 'thumbnail-${1}.$2', $imageName);
                    $imagePreview = preg_replace('/(.*)\.(.*)/i', '${1}.$2', $imageName);
                    $imageCaption = $recipe->attachments[$imageIndex]['name'];

                    $previewUrl = $baseUrl . 'files/Attachments/attachment/' . $imagePreview;
                    $thumbailUrl = $baseUrl . 'files/Attachments/attachment/' . $imageThumb;
                    echo '<a href="#" onclick=\'loadImage("' . $previewUrl. '", "'. $imageCaption . '"); return false;\'><img src="' . $thumbailUrl . '" title="' . $imageCaption . '" class="rounded" style="height: 55px;"/></a>';
                }
            }
            echo "</div>";
            ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="clear"></div>
    <div class="mt-4">
        <h5><i class="bi bi-journal-text"></i> <?= __('Directions') ?></h5>
        <?php if ($recipe->use_markdown): ?>
            <div class="markdown-content">
                <?= $this->Markdown->render($recipe->directions) ?>
            </div>
        <?php else: ?>
            <pre class="p-3 bg-light rounded"><?= h($recipe->directions) ?></pre>
        <?php endif; ?>
    </div>

    <?php foreach ($recipe->related_recipes as $related) :?>
        <div class="mt-4">
            <div class="relatedRecipe">
                <span>
                <?= $this->Html->link($related->recipe->name, array('controller' => 'recipes', 'action' => 'view', $related->recipe_id),
                                array('class' => 'ajaxLink')) ?>
                        (<?= $related->required == "1" ? "required" : __('optional') ?>)
                </span>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <strong><?= __('Ingredients') ?></strong>
                        <table class="ingredients-table">
                        <?php for ($i = 0; $i < count($related->recipe->ingredient_mappings); $i++) :
                            $quantity = $related->recipe->ingredient_mappings[$i]->quantity;
                            if (isset($scale)) $quantity *= $scale;
                            $quantity = $this->Fraction->toFraction($quantity);
                            $unit = $related->recipe->ingredient_mappings[$i]->unit->abbreviation;
                            $ingredientName = $related->recipe->ingredient_mappings[$i]->ingredient->name;
                            $qualifier = $related->recipe->ingredient_mappings[$i]->qualifier;
                            $optional = $related->recipe->ingredient_mappings[$i]->optional ? __('(optional)') : "";
                            $note = isset($related->recipe->ingredient_mappings[$i]->note) ? $related->recipe->ingredient_mappings[$i]->note : '';
                            ?>
                            <tr>
                                <td class="ingredientViewUnit"><?= "$quantity $unit" ?></td>
                                <td><?= "$qualifier <b>$ingredientName</b> <i>$optional</i>" ?></td>
                                <td>
                                    <?php if ($note) :?>
                                    <div class="alert alert-info py-1 px-2 mb-0 small" role="alert"><?= "$note" ?></div>
                                    <?php endif;?>
                                </td>
                            </tr>
                        <?php endfor;?>
                        </table>
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <div class="mt-2">
                    <strong><?= __('Directions') ?></strong>
                    <?php if ($related->recipe->use_markdown): ?>
                        <div class="markdown-content">
                            <?= $this->Markdown->render($related->recipe->directions) ?>
                        </div>
                    <?php else: ?>
                        <pre class="p-3 bg-light rounded"><?= h($related->recipe->directions) ?></pre>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
