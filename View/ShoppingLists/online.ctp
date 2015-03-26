<?php 
if (isset($selectedVendor['Vendor'])) {
    $vendorHomePage = $selectedVendor['Vendor']['home_url'];
    $vendorAddUrl = $selectedVendor['Vendor']['add_url'];
    $vendorId = $selectedVendor['Vendor']['id'];
}
?>
<script type="text/javascript">
    $(function() {
        $('[vendor-save]').click(function() {
            $('#VendorCompleteForm').submit();
        })
        $('[list-item]').change(function() {
            rowClicked($(this));
        });
        $('[shop-add]').click(function() {
            var vendorAddUrl = "<?php echo $vendorAddUrl;?>";
            $productInput = $(this).siblings('[product-id]').first();
            var productId = $productInput.val();
            //console.log("Click - " + productId);
            if (productId) {
                var wnd = window.open(vendorAddUrl + productId, 'shopping'); 
                $checkBox = $(this).parent().parent().find('input:checkbox');
                $checkBox.prop('checked', true);
                rowClicked($checkBox, $productInput);
            }

            return false;
        });
        
        $('[shop-all]').click(function() {
            var timingCount = 0;
            $('.gridContent a').each(function() {
                //console.log("ID: " + $(this).attr('id'));
                var itemId = "#" + $(this).attr('id');
                $productInput = $(this).siblings('[product-id]').first();
                var productId = $productInput.val();
                if (productId) {
                    timingCount += 5000;
                    //console.log("setting it up: " + timingCount);
                    setTimeout(function(){ 
                        //console.log("click it - " +  $(itemId).attr('id'));
                        $(itemId).click(); 
                    }, timingCount);
                }
            });
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
<br/><br/>
<?php echo $this->Form->create('Vendor', array('action' => 'complete'));?>
<?php echo $this->Form->input('vendor_id',array('label'=>'Select Vendor')); ?>
<table>
    <tr class="headerRow">
        <th><?php echo __('Select');?></th>
        <th><?php echo __('Product / ID');?></th>
        <th><?php echo __('Quantity');?></th>
        <th><?php echo __('Unit');?></th>
        
        <th><?php echo __('Name');?></th>
    </tr>
    <tbody class="gridContent">
    <?php 
    $locationName = "";
    $mapIndex = 0;
    foreach ($list as $i=>$ingredientType):
        foreach ($ingredientType as $j=>$item) :
            if ($item->removed) continue;
      
                $productCode = "";
                $productId = "";
                if (isset($selectedVendor['VendorProduct'])) {
                    foreach ($selectedVendor['VendorProduct'] as $product) {
                        if ($product['ingredient_id'] == $item->id) {
                            $productCode = $product['code'];
                            $productId = $product['id'];
                        }
                    }
                }
    ?>
    <tr row-click>
        <td><input type="checkbox" list-item/></td>
        <td>
            <a href="#" shop-add id="AddItem<?php echo $item->id;?>">Add</a>
            <input type="hidden" name="data[VendorProduct][<?php echo $mapIndex;?>][id]" value="<?php echo $productId;?>"/>
            <input type="hidden" name="data[VendorProduct][<?php echo $mapIndex;?>][vendor_id]" value="<?php echo $vendorId;?>"/>
            <input type="hidden" name="data[VendorProduct][<?php echo $mapIndex;?>][ingredient_id]" value="<?php echo $item->id;?>"/>
            <input type="text" name="data[VendorProduct][<?php echo $mapIndex;?>][code]" value="<?php echo $productCode;?>" 
                   class="vendor-input" autocomplete="off" product-id /></td>
        <td><?php echo $this->Fraction->toFraction($item->quantity);?></td>
        <td><?php echo $item->unitName;?></td>
        <td><b><?php echo $item->name;?></b></td>
    </tr>
    <?php 
        $mapIndex++;
        endforeach;
    endforeach?>
    </tbody>
</table>
</form>
<button class="btn-primary" shop-all><?php echo __('Add All');?></button>
<button class="btn-primary" vendor-save><?php echo __('Complete');?></button>

