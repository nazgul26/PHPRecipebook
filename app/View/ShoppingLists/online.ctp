<?php 
if (isset($selectedVendor['Vendor'])) {
    $vendorHomePage = $selectedVendor['Vendor']['home_url'];
    $vendorAddUrl = $selectedVendor['Vendor']['add_url'];
    $vendorId = $selectedVendor['Vendor']['id'];
}
?>
<script type="text/javascript">
    $(function() {
        $('[row-click]').click(function() {
            $checkBox = $(this).find('input');
            $productInput = $(this).find('[product-id]').first();
            rowClicked($checkBox, $productInput);
        });
        $('[shop-add]').click(function() {
            var vendorAddUrl = "<?php echo $vendorAddUrl;?>";
            $productInput = $(this).siblings('[product-id]').first();
            var productId = $productInput.val();
            var wnd = window.open(vendorAddUrl + productId, 'shopping'); 
            console.log("Product Sent:" + productId);
            $checkBox = $(this).parent().parent().find('input:checkbox');
            rowClicked($checkBox, $productInput);
            return false;
        });
    });
    
    function rowClicked($checkBox, $productInput) {
        if ($checkBox.prop('checked')) {
            $checkBox.removeAttr('checked');
            $checkBox.parent().parent().removeClass('strikeThrough');
            $productInput.removeClass('disabled');
        } else {
            $checkBox.prop('checked', true);
            $checkBox.parent().parent().addClass('strikeThrough');
            $productInput.addClass('disabled');
        }
    }
    
</script>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Shopping List'), array('action' => 'index', $listId), array('class' => 'ajaxNavigation')); ?> </li>
    <li><?php echo $this->Html->link(__('Select Items'), array('action' => 'select', $listId), array('class' => 'ajaxNavigation')); ?> </li>
    <li class="active"><?php echo __('Online');?></li>
</ol>
<?php echo $this->Form->input('vendor_id',array('label'=>'Select Vendor')); ?>
<br/><br/>
<?php echo $this->Form->create('Vendor', array('action' => 'complete'));?>
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
            <a href="#" shop-add>Add</a>
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
<button class="btn-primary" vendor-save><?php echo __('Complete');?></button>
</form>

