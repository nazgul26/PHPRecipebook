<div class="units form">
<?= $this->Form->create($unit, array('default' => false, 'targetId' => 'editUnitDialog')) ?>
<?php
    echo $this->Form->hidden('id');
    echo $this->Form->control('name');
    echo $this->Form->control('abbreviation');
    echo $this->Form->control('system_type',
                    ['options' =>
                        [
                            '0' => __('Unit'),
                            '1' => __('USA'),
                            '2' => __('Metric')
                        ]
                    ]
                    );
    echo $this->Form->control('sort_order');
?>
<?= $this->Form->submit(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
<?= $this->Flash->render() ?>
