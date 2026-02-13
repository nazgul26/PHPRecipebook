
<nav aria-label="Page navigation">
<ul class="pagination">
<?php
    echo $this->Paginator->prev('< ' . __('previous'));
    echo $this->Paginator->numbers(['separator' => '']);
    echo $this->Paginator->next(__('next') . ' >');
?>
</ul>
</nav>
