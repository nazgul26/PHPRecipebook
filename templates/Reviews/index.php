<?php 
use Cake\Routing\Router;
$baseUrl = Router::url('/');
?>
<script type="text/javascript">
    $(function() {
        $('[add-review]').click(function() {
            ajaxNavigate('<?php echo $baseUrl;?>Reviews/edit/<?php echo $recipeId;?>');
        });
        $('.rateit').rateit();
    });
</script>
<?= $this->Flash->render() ?>

<ol class="breadcrumb">
    <li><?php echo $this->Html->link($recipe->name, array('controller' => 'recipes', 'action' => 'view', $recipeId), array('class' => 'ajaxNavigation')); ?> </li>
    <li class="active"><?php echo __('Reviews');?></li>
</ol>
       
<div class="reviews index">
    <?php foreach ($reviews as $review): ?>
    <div class="reviewCell">
        <div class="rateit" data-rateit-value="<?php echo h($review->rating);?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div> 
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
            echo $this->Html->link(__('Edit'), array('action' => 'edit', $review->recipe_id, $review->id), array('class' => 'ajaxNavigation'));
            echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $recipe->id, $review->id), ['confirm' => __('Are you sure you want to delete # {0}?', $review->id)]);
        }?>
    </div>
    <?php endforeach; ?>
    
    <?php if (count($reviews) == 0) :
        echo __('No one has reviewed this recipe yet. Be the first.');?>
        <br/>
        <br/>
    <?php endif; ?>
    <br/>
    
    <p>
        <?php if ($loggedIn) { ?>
        <a class="btn-primary" add-review><?php echo __('Add your own review...');?></a>
        <?php } else { ?>
            <a add-review href='#'><?php echo __('Sign in to add your own review');?></a>
            <br/><br/>
        <?php }?>
    </p>
    <?php if (count($reviews) > 0) : ?>
        <?= $this->element('pager') ?>
    <?php endif;?>
</div>

