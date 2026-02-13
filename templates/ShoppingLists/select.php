<script type="text/javascript">
    (function() {
        document.querySelectorAll('[list-item]').forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.stopPropagation();
                rowClicked(this);
            });
        });
        document.querySelectorAll('[row-click]').forEach(function(el) {
            el.addEventListener('click', function() {
                var cb = this.querySelector('input');
                if (cb) rowClicked(cb);
            });
        });
        document.querySelector('[shop-store]')?.addEventListener('click', function() {
            loadShoppingStep('instore');
        });
        document.querySelector('[shop-online]')?.addEventListener('click', function() {
            loadShoppingStep('online');
        });
    })();

    function loadShoppingStep(routeName) {
        document.getElementById('route').value = routeName;
        var form = document.querySelector('form');
        form.setAttribute('action', baseUrl + 'ShoppingLists/' + routeName + "/<?= $listId ?>");
        form.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
        return false;
    }

    function rowClicked(checkBox) {
        if (checkBox.checked) {
            checkBox.checked = false;
            checkBox.closest('tr').classList.remove('strikeThrough');
        } else {
            checkBox.checked = true;
            checkBox.closest('tr').classList.add('strikeThrough');
        }
    }
</script>
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
    <li class="breadcrumb-item"><?= $this->Html->link(__('Shopping List'), array('action' => 'index', $listId), array('class' => 'ajaxNavigation')) ?></li>
    <li class="breadcrumb-item active"><?= __('Select Items') ?></li>
</ol>
</nav>
<h2><?= __('What Items do you already have?') ?></h2>
<?= $this->Form->create() ?>
<input type="hidden" name="route" id="route"/>
<table class="table table-hover align-middle">
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

    <tr row-click style="cursor: pointer;">
        <td><input type="checkbox" name="remove[]" value="<?= $i . "-" . $j ?>" list-item/></td>
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
    <button class="btn btn-primary" shop-store><i class="bi bi-shop"></i> <?= __('Shop At Store') ?></button>
    <button class="btn btn-secondary" shop-online><i class="bi bi-globe"></i> <?= __('Shop Online') ?></button>
</div>
</form>
