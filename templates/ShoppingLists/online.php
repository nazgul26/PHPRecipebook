<?php
use Cake\Routing\Router;
$baseUrl = Router::url('/');

if (isset($selectedVendor)) {
    $vendorHomePage = $selectedVendor->home_url;
    $vendorAddUrl = $selectedVendor->add_url;
    $vendorId = $selectedVendor->id;
}
?>

<script type="text/javascript">
    var TIME_TO_LOAD = 5000;
    var itemToRefresh = null;

    (function() {
        document.addEventListener("saved.product", function() {
            closeModal('editProductDialog');
            var itemId = itemToRefresh.replace('SelectToAdd', '');
            ajaxGet('<?= $baseUrl ?>VendorProducts/refresh/' + itemId, itemToRefresh);
        });

        document.querySelector('[vendor-save]')?.addEventListener('click', function() {
            var form = document.getElementById('ShoppingListForm');
            if (form) form.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
        });

        document.querySelectorAll('[list-item]').forEach(function(el) {
            el.addEventListener('change', function() { rowClicked(this); });
        });

        document.querySelectorAll('.addProduct').forEach(function(el) {
            el.addEventListener('click', function() {
                var elementId = this.id;
                itemToRefresh = elementId.replace('AddProd', 'SelectToAdd');
            });
        });

        document.querySelectorAll('[shop-add]').forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                var vendorAddUrl = "<?= $vendorAddUrl ?? '' ?>";
                var formKey = document.getElementById('ShoppingListsFormkey')?.value;
                var productSelect = this.closest('tr').querySelector('[product-id]');
                var productId = productSelect?.value?.split(";")[0];
                if (productId) {
                    var url = vendorAddUrl.replace("@productId", productId).replace("@formKey", formKey);
                    window.open(url, 'shopping');
                    var cb = this.closest('tr').querySelector('input[type="checkbox"]');
                    if (cb) {
                        cb.checked = true;
                        rowClicked(cb);
                    }
                }
            });
        });

        // Progress bar
        var progressContainer = document.getElementById('progressbar');
        var progressBar = null;

        if (progressContainer) {
            progressBar = createProgressBar(progressContainer);
            progressBar.hide();
        }

        document.querySelector('[shop-all]')?.addEventListener('click', function() {
            TIME_TO_LOAD = parseInt(document.getElementById('ShoppingListsTimeOut')?.value || 5000);
            var timingCount = TIME_TO_LOAD;
            if (progressBar) {
                progressBar.show();
            }
            var wnd = window.open('<?= $vendorHomePage ?? '' ?>', 'shopping');
            var addLinks = document.querySelectorAll('.gridContent a[shop-add]');
            var totalToAdd = 0;
            var currentAddNumber = 0;

            addLinks.forEach(function(link) {
                var productSelect = link.closest('tr').querySelector('[product-id]');
                var productId = productSelect?.value;
                if (productId) {
                    totalToAdd++;
                    setTimeout(function() {
                        document.querySelectorAll('.selectedRow').forEach(function(r) { r.classList.remove('selectedRow'); });
                        link.closest('tr').classList.add('selectedRow');
                        if (progressBar) {
                            progressBar.setMax(totalToAdd);
                            progressBar.setLabel("<?= __('Adding ') ?> " + link.getAttribute('item-name'));
                        }
                        currentAddNumber++;
                        link.click();
                        if (progressBar) progressBar.setValue(currentAddNumber);
                    }, timingCount);
                    timingCount += TIME_TO_LOAD;
                }
            });

            if (progressBar) progressBar.setMax(totalToAdd);

            // Complete
            setTimeout(function() {
                document.querySelectorAll('.selectedRow').forEach(function(r) { r.classList.remove('selectedRow'); });
                if (progressBar) progressBar.setLabel("<?= __('Complete!') ?>");
                setTimeout(function() { window.open('<?= $vendorHomePage ?? '' ?>', 'shopping'); }, TIME_TO_LOAD);
            }, timingCount);
        });
    })();

    function rowClicked(checkBox) {
        if (checkBox.checked) {
            checkBox.closest('tr').classList.add('strikeThrough');
        } else {
            checkBox.closest('tr').classList.remove('strikeThrough');
        }
    }
</script>
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
    <li class="breadcrumb-item"><?= $this->Html->link(__('Shopping List'), array('action' => 'index', $listId), array('class' => 'ajaxLink')) ?></li>
    <li class="breadcrumb-item"><?= $this->Html->link(__('Select Items'), array('action' => 'select', $listId), array('class' => 'ajaxLink')) ?></li>
    <li class="breadcrumb-item active"><?= __('Online') ?></li>
</ol>
</nav>
<div class="actions-bar">
    <?= $this->Html->link(__('Edit Products'),
        array('controller'=>'VendorProducts', 'action' => 'index'),
        array('class' => 'btn btn-outline-primary btn-sm ajaxLink')) ?>
</div>
<?= $this->Form->create(null, ['id'=> 'ShoppingListForm', 'url' => array('controller' => 'ShoppingLists','action' => 'clear')]) ?>
<?= $this->Form->control('vendor_id', array('label'=>'Select Vendor')) ?>
<?= $this->Form->control('formkey', array('label'=>'Form Key')) ?>
<?= $this->Form->control('timeOut', array('label'=>'Time Out', 'default' => '5000')) ?>
<table class="table table-hover align-middle">
    <thead>
    <tr>
        <th></th>
        <th><?= __('Product') ?></th>
        <th><?= __('Quantity') ?></th>
        <th><?= __('Unit') ?></th>
        <th><?= __('Ingredient Name') ?></th>
        <th><?= __('Completed') ?></th>
    </tr>
    </thead>
    <tbody class="gridContent">
    <?php
    $locationName = "";
    $mapIndex = 0;
    foreach ($list as $i=>$ingredientType):
        foreach ($ingredientType as $j=>$item) :
            if ($item->removed) continue;
    ?>
    <tr>
        <td><a href="#" shop-add id="AddItem<?= $item->id ?>" item-name="<?= $item->name ?>" class="btn btn-sm btn-outline-primary"><?= __('Add') ?></a></td>
        <td>
            <select id="SelectToAdd<?= $item->id ?>" class="form-select form-select-sm" product-id>
                <option></option>
                <?php
                $productCode = "";
                if (isset($selectedVendor['VendorProduct'])) {
                    foreach ($selectedVendor['VendorProduct'] as $product) {
                        if ($product['ingredient_id'] == $item->id) {
                            $productCode = $product['code'];
                            $productId = $product['id'];
                            $productName = isset($product['name']) ? $product['name'] : $item->name;
                            ?>
                            <option value="<?= $productCode . ";" . $productId ?>" selected><?= $productName ?> (<?= $productCode ?>)</option>
                            <?php
                        }
                    }
                }
                ?>
            </select>
            <span class="productOptions">
                <?= $this->Html->link(
                    '<i class="bi bi-plus-circle"></i>',
                    array('controller' => 'VendorProducts', 'action' => 'add', $vendorId ?? '', $item->id),
                    array('class' => 'ajaxLink addProduct', 'id' => 'AddProd' . $item->id, 'targetId' => 'editProductDialog','escape' => false)) ?>
            </span>
        </td>
        <td><?= $this->Fraction->toFraction($item->quantity) ?></td>
        <td><?= $item->unitName ?></td>
        <td><strong><?= $item->name ?></strong></td>
        <td><input type="checkbox" list-item class="form-check-input"/></td>
    </tr>
    <?php
        $mapIndex++;
        endforeach;
    endforeach?>
    </tbody>
</table>
<div id="progressbar" class="mb-3"></div>
</form>
<div class="d-flex gap-2">
    <button class="btn btn-primary" shop-all><i class="bi bi-cart-plus"></i> <?= __('Add All') ?></button>
    <button class="btn btn-secondary" vendor-save><i class="bi bi-check-circle"></i> <?= __('Complete') ?></button>
</div>
