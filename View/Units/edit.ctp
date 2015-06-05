<script type="text/javascript">
    $(function() {
        $('.units .submit').hide();
    });
</script>
<div class="units form">
<?php echo $this->Form->create('Unit', array('default' => false, 'targetId' => 'editUnitDialog')); ?>
<?php 
    echo $this->Form->hidden('id');
    echo $this->Form->input('name');
    echo $this->Form->input('abbreviation');
    echo $this->Form->input('system', 
                    array('options' => 
                        array(
                            '0' => __('Unit'), 
                            '1' => __('USA'),
                            '2' => __('Metric')
                            )
                        )
                    );
    echo $this->Form->input('sort_order');
?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php echo $this->Session->flash(); ?>

