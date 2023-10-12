
<ul class="pagination">
<?php
    echo $this->Paginator->prev('< ' . __('previous'), [], null, ['class' => 'prev disabled']);
    echo $this->Paginator->numbers(['separator' => '', 'class'=>'ajaxLink']);
    echo $this->Paginator->next(__('next') . ' >', [], null, ['class' => 'next disabled']);
?>
</ul>