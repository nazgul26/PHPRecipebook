<?php 

$baseUrl = Router::url('/');

if (isset($selectedVendor['Vendor'])) {
    $vendorHomePage = $selectedVendor['Vendor']['home_url'];
    $vendorAddUrl = $selectedVendor['Vendor']['add_url'];
    $vendorId = $selectedVendor['Vendor']['id'];
}
?>

<script type="text/javascript">
    //var TIME_TO_LOAD = 5000;
    var itemToRefresh = null;
    
    $(function() {
        $(document).off("saved.product");
        $(document).on("saved.product", function() {
            $('#editProductDialog').dialog('close');
            var itemId = itemToRefresh.replace('SelectToAdd', '');
            ajaxGet('<?php echo $baseUrl;?>VendorProducts/refresh/' + itemId, itemToRefresh);
        });
        
        $('[vendor-save]').click(function() {
            $('#ShoppingListsClearForm').submit();
        })
        $('[list-item]').change(function() {
            rowClicked($(this));
        });
        
        $('.addProduct').click(function() {
            var elementId = $(this).attr('id');
            itemToRefresh = elementId.replace('AddProd', 'SelectToAdd');
        });
           
        $('[shop-add]').click(function() {
            var vendorAddUrl = "<?php echo $vendorAddUrl;?>";
            var formKey = $("#ShoppingListsFormkey").val();
            $productInput = $(this).parent().parent().find('[product-id]').first();
            var productId = $productInput.val().split(";")[0];
            if (productId) {
                var vendorAddUrl = vendorAddUrl.replace("@productId", productId);
                vendorAddUrl = vendorAddUrl.replace("@formKey", formKey);
                var wnd = window.open(vendorAddUrl, 'shopping'); 
                $checkBox = $(this).parent().parent().find('input:checkbox');
                $checkBox.prop('checked', true);
                rowClicked($checkBox, $productInput);
            }

            return false;
        });
        
        var progressbar = $("#progressbar");
        var progressLabel = $(".progress-label");
        var currentAddItem = "";
        var currentAddNumber = 0;
        var totalToAdd = 0;
        
        progressbar.hide();
        progressbar.progressbar({
            value: false,
            change: function() {
                progressLabel.text("<?php echo __('Adding ');?> " + currentAddItem );
            },
            complete: function() {
                $('.selectedRow').removeClass('selectedRow');
                progressLabel.text("<?php echo __('Complete!');?>");
                setTimeout(function(){ window.open('<?php echo $vendorHomePage;?>', 'shopping'); }, $('#ShoppingListsTimeOut').val());
            }
        });
            
        $('[shop-all]').click(function() {
            var timingCount = $('#ShoppingListsTimeOut').val();
            progressbar.show();
            // Start loading the window now
            var wnd = window.open('<?php echo $vendorHomePage;?>', 'shopping'); 
            $('.gridContent a[shop-add]').each(function() {
                var itemId = "#" + $(this).attr('id');
                $productInput = $(this).parent().parent().find('[product-id]').first();
                var productId = $productInput.val();
                if (productId) {
                    // Add each item, with timing between
                    totalToAdd++;
                    setTimeout(function(){
                        $('.selectedRow').removeClass('selectedRow');
                        $(itemId).parent().parent().addClass('selectedRow');
                        currentAddItem = $(itemId).attr('item-name');
                        currentAddNumber++;
                        $(itemId).click(); 
                        progressbar.progressbar( "value", currentAddNumber );
                    }, timingCount);
                    timingCount += $('#ShoppingListsTimeOut').val();
                }
            });
            progressbar.progressbar("option", "max", totalToAdd);
        });
    });
    
    function rowClicked($checkBox) {
        if ($checkBox.prop('checked')) {
            $checkBox.parent().parent().addClass('strikeThrough');
        } else {
            $checkBox.parent().parent().removeClass('strikeThrough');
        }
    }
    
</script>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Shopping List'), array('action' => 'index', $listId), array('class' => 'ajaxNavigation')); ?> </li>
    <li><?php echo $this->Html->link(__('Select Items'), array('action' => 'select', $listId), array('class' => 'ajaxNavigation')); ?> </li>
    <li class="active"><?php echo __('Online');?></li>
</ol>
<div class="actions">
    <ul>
            <li><?php echo $this->Html->link(__('Edit Products'), 
                array(
                    'controller'=>'VendorProducts',
                    'action' => 'index'), 
                array('class' => 'ajaxNavigation')); ?></li>
    </ul>
</div>
<?php echo $this->Form->create('ShoppingLists', array('url' => array('controller' => 'ShoppingLists','action' => 'clear')));?>
<?php echo $this->Form->input('vendor_id',array('label'=>'Select Vendor')); ?>
<?php echo $this->Form->input('formkey',array('label'=>'Form Key')); ?>
<?php echo $this->Form->input('timeOut',array('label'=>'Time Out', 'default' => '5000')); ?>
<table>
    <tr class="headerRow">
        <th></th>
        <th><?php echo __('Product');?></th>
        <th><?php echo __('Quantity');?></th>
        <th><?php echo __('Unit');?></th>
        <th><?php echo __('Ingredient Name');?></th>
        <th><?php echo __('Completed');?></th>
    </tr>
    <tbody class="gridContent">
    <?php 
    $locationName = "";
    $mapIndex = 0;
    foreach ($list as $i=>$ingredientType):
        foreach ($ingredientType as $j=>$item) :
            if ($item->removed) continue;
    ?>
    <tr row-click>
        <td><a href="#" shop-add id="AddItem<?php echo $item->id;?>" item-name="<?php echo $item->name;?>"><?php echo __('Add');?></a></td>
        <td>    
            <select id="SelectToAdd<?php echo $item->id;?>" class="vendor-input" product-id>
                <option></option>
                <?php 
                $productCode = "";
                $productId = "";
                $productName = "";
                if (isset($selectedVendor['VendorProduct'])) {
                    foreach ($selectedVendor['VendorProduct'] as $product) {
                        if ($product['ingredient_id'] == $item->id) {
                            $productCode = $product['code'];
                            $productId = $product['id'];
                            $productName = isset($product['name']) ? $product['name'] : $item->name;
                            ?>
                            <option value="<?php echo $productCode . ";" . $productId;?>" selected><?php echo $productName;?> (<?php echo $productCode;?>)</option>
                            <?php
                        }
                    }
                } 
                ?>
            </select>
            
            <span class="productOptions">
                <?php echo $this->Html->link(
                    $this->Html->image("add.png", array('title' => "Add More items for this ingredient", 'alt' => 'Add')), 
                    array('controller' => 'VendorProducts', 'action' => 'add', $vendorId, $item->id), 
                    array('class' => 'ajaxLink addProduct', 'id' => 'AddProd' . $item->id, 'targetId' => 'editProductDialog','escape' => false)); ?>
            </span>

        </td>
        <td><?php echo $this->Fraction->toFraction($item->quantity);?></td>
        <td><?php echo $item->unitName;?></td>
        <td><b><?php echo $item->name;?></b></td>
        <td><input type="checkbox" list-item/></td>
    </tr>
    <?php 
        $mapIndex++;
        endforeach;
    endforeach?>
    </tbody>
</table>
<div id="progressbar"><div class="progress-label" id="progressName"></div></div>
</form>
<button class="btn-primary" shop-all><?php echo __('Add All');?></button>
<button class="btn-primary" vendor-save><?php echo __('Complete');?></button>

