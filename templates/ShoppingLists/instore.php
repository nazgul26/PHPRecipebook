<script type="text/javascript">
    (function() {
        document.querySelector('[shop-print]')?.addEventListener('click', function(e) {
            e.preventDefault();
            window.print();
        });
        document.querySelector('[shop-done]')?.addEventListener('click', function() {
            document.getElementById('done').value = "1";
            document.getElementById('ShoppingListInstoreForm').dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
        });

        document.getElementById('store-id')?.addEventListener('change', function() {
            document.getElementById('ShoppingListInstoreForm').dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
        });
    })();
</script>
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
    <li class="breadcrumb-item"><?= $this->Html->link(__('Shopping List'), array('action' => 'index', $listId), array('class' => 'ajaxLink')) ?></li>
    <li class="breadcrumb-item"><?= $this->Html->link(__('Select Items'), array('action' => 'select', $listId), array('class' => 'ajaxLink')) ?></li>
    <li class="breadcrumb-item active"><?= __('In Store') ?></li>
</ol>
</nav>
<?= $this->Form->create(null, ['id' => 'ShoppingListInstoreForm']) ?>
<input type="hidden" name="done" id="done" value="0" />
<div id="selectStore">
    <?= $this->Form->control('store_id', array('label'=>'Select Store', 'escape' => false)) ?>
</div>

<?php if (isset($removeIds)) :
    foreach ($removeIds as $id) : ?>
    <input type="hidden" name="remove[]" value="<?= $id ?>" />
<?php endforeach; endif;?>

<table class="table table-hover align-middle" id="instoreShoppingList">
    <thead>
    <tr>
        <th><?= __('Select') ?></th>
        <th><?= __('Quantity') ?></th>
        <th><?= __('Unit') ?></th>
        <th><?= __('Name') ?></th>
    </tr>
    </thead>
    <tbody class="gridContent">
    <?php
    $locationName = "";
    foreach ($list as $i=>$ingredientType):
        foreach ($ingredientType as $j=>$item) :
            if ($item->removed) continue;

            $locationChanged = false;
            if ($locationName != $item->locationName) {
                $locationName = $item->locationName;
                $locationChanged = true;
            }
    ?>
    <?php if ($locationChanged) :?>
        <tr class="storeLocation">
            <td colspan="4"><div><?= $locationName ?></div></td>
        </tr>
    <?php endif;?>

    <tr row-click>
        <td><input type="checkbox" list-item/></td>
        <td><?= $this->Fraction->toFraction($item->quantity) ?></td>
        <td><?= $item->unitName ?></td>
        <td><strong><?= $item->name ?></strong></td>
    </tr>
    <?php
        endforeach;
    endforeach?>
    </tbody>
</table>
<div class="d-flex gap-2">
    <button class="btn btn-primary" shop-print><i class="bi bi-printer"></i> <?= __('Print') ?></button>
    <button class="btn btn-secondary" shop-done><i class="bi bi-check-circle"></i> <?= __('Complete') ?></button>
</div>
</form>
