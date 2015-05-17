<?php 
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
<?php echo $this->Session->flash(); ?>

<ol class="breadcrumb">
    <li><?php echo $this->Html->link($recipe['Recipe']['name'], array('controller' => 'recipes', 'action' => 'view', $recipeId), array('class' => 'ajaxNavigation')); ?> </li>
    <li class="active"><?php echo __('Reviews');?></li>
</ol>
       
<div class="reviews index">
    <?php foreach ($reviews as $review): ?>
    <div class="reviewCell">
        <div class="rateit" data-rateit-value="<?php echo h($review['Review']['rating']);?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div> 
        <?php if (isset($review['User']['name'])) {
            echo __('By') . ' ';
            echo $review['User']['name'] . ' ';
            echo __('on') . ' ';
            echo $this->Time->niceShort($review['Review']['created']);
        } else {
            echo __('By Anonymous on Unknown Date');   
        }
        ?>
        <br/>
        <div class="reviewComment">
            <?php if (isset($review['Review']['comments'])) {
                echo h($review['Review']['comments']); 
            } else {
                echo __('No comments');
            }
            ?>
        </div>
        <?php if ($isEditor || ($loggedIn && $loggedInuserId == $review['User']['id'])) {
            echo $this->Html->link(__('Edit'), array('action' => 'edit', $review['Review']['recipe_id'], $review['Review']['id']), array('class' => 'ajaxNavigation'));
            echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $review['Review']['id']), null, __('Are you sure you want to delete this review?'));
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
    <p><?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}')));?></p>
    <div class="paging">
    <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
    </div>
    <?php endif;?>
</div>

