<script type="text/javascript">
    $(function() {
        $('.restaurants .submit').hide();
    });
</script>
<div class="restaurants form">
<?php echo $this->Form->create($restaurant, ['default' => false, 'targetId' => 'editRestaurantDialog']); ?>
<?php
        echo $this->Form->input('id');
        echo $this->Form->input('name');
        echo $this->Form->input('street');
        echo $this->Form->input('city');
        echo $this->Form->input('state');
        echo $this->Form->input('zip');
        echo $this->Form->input('country');
        echo $this->Form->input('phone');
        echo $this->Form->input('hours');
        echo $this->Form->input('picture');
        echo $this->Form->input('picture_type');
        echo $this->Form->input('menu_text');
        echo $this->Form->input('comments');
        echo $this->Form->input('price_range_id');
        echo $this->Form->input('delivery');
        echo $this->Form->input('carry_out');
        echo $this->Form->input('dine_in');
        echo $this->Form->input('credit');
        echo $this->Form->input('website');
        echo $this->Form->input('user_id');
?>
<?= $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end(); ?>
</div>
<?= $this->Flash->render() ?>
