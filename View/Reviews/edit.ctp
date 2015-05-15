<?php
$currentRating = isset($this->request->data['rating']) ? $this->request->data['rating'] : 0;
?>
<script type="text/javascript">
    $(function() {
        $('.rateit').rateit();
    });
</script>
<h2>
  <?php echo __('Review: ') . " " . $recipe['Recipe']['name'];?>  
</h2>

<div class="reviews form">
    <div>
        <label><b>&nbsp;&nbsp;Rating</b></label>
            <div class="rateit"></div> 
    </div>
    <?php echo $this->Form->create('Review') ?>
    <?php
    echo $this->Form->hidden('recipe_id');
    echo $this->Form->input('comments', array('type' => 'textarea'));
    echo $this->Form->hidden('id');
    ?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
