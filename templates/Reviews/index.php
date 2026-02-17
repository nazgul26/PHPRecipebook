<?php
use Cake\Routing\Router;
$baseUrl = Router::url('/');
?>
<script type="text/javascript">
    (function() {
        document.querySelectorAll('[add-review]').forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                ajaxNavigate('<?= $baseUrl ?>Reviews/edit/<?= $recipeId ?>');
            });
        });

        document.querySelectorAll('.rateit').forEach(function(el) {
            var value = parseFloat(el.getAttribute('data-rateit-value')) || 0;
            createStarRating(el, {
                value: value,
                max: 5,
                readonly: true
            });
        });
    })();
</script>
<?= $this->Flash->render() ?>

<nav aria-label="breadcrumb">
<ol class="breadcrumb">
    <li class="breadcrumb-item"><?= $this->Html->link($recipe->name, array('controller' => 'recipes', 'action' => 'view', $recipeId), array('class' => 'ajaxLink')) ?></li>
    <li class="breadcrumb-item active"><?= __('Reviews') ?></li>
</ol>
</nav>

<div class="reviews index">
    <?php foreach ($reviews as $review): ?>
    <div class="reviewCell">
        <div class="rateit" data-rateit-value="<?= h($review->rating) ?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
        <?php if (isset($review->user->name)) {
            echo __('By') . ' ';
            echo $review->user->name . ' ';
            echo __('on') . ' ';
            echo $this->Time->nice($review->created);
        } else {
            echo __('By Anonymous on Unknown Date');
        }
        ?>
        <br/>
        <div class="reviewComment">
            <?php if (isset($review->comments)) {
                echo h($review->comments);
            } else {
                echo __('No comments');
            }
            ?>
        </div>
        <?php if ($isEditor || ($loggedIn && $loggedInuserId == $review['User']['id'])) {
            echo $this->Html->link(__('Edit'), array('action' => 'edit', $review->recipe_id, $review->id), array('class' => 'ajaxLink'));
            echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $recipe->id, $review->id), ['confirm' => __('Are you sure you want to delete # {0}?', $review->id)]);
        }?>
    </div>
    <?php endforeach; ?>

    <?php if (count($reviews) == 0) :
        echo __('No one has reviewed this recipe yet. Be the first.');?>
        <br/>
        <br/>
    <?php endif; ?>

    <p>
        <?php if ($loggedIn) { ?>
        <a class="btn btn-primary" add-review><?= __('Add your own review...') ?></a>
        <?php } else { ?>
            <a add-review href='#'><?= __('Sign in to add your own review') ?></a>
            <br/><br/>
        <?php }?>
    </p>
    <?php if (count($reviews) > 0) : ?>
        <?= $this->element('pager') ?>
    <?php endif;?>
</div>
