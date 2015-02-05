<script type="text/javascript">
    $(function() {
        $('[shop-send]').click(function() {
            var vendorBaseUrl = "http://www.prestofreshgrocery.com/checkout/cart/add/uenc/a/product/";
            $('[product-id]').each(function() {
                var productId = $(this).val();
                var wnd = window.open('http://www.prestofreshgrocery.com/checkout/cart/add/uenc/a/product/' + productId, 'shopping'); 
                console.log("Product Sent:" + productId);
                setTimeout(function() {
                  wnd.close();
                }, 5000);
            })
        });

    });
    
</script>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Shopping List'), array('action' => 'index', $listId), array('class' => 'ajaxNavigation')); ?> </li>
    <li><?php echo $this->Html->link(__('Select Items'), array('action' => 'select', $listId), array('class' => 'ajaxNavigation')); ?> </li>
    <li class="active"><?php echo __('Online');?></li>
</ol>

<label>Select Vendor</label>
<select>
    <option>Prestofresh Grocery</option>
</select>

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
    $vendorId = 13197;
    foreach ($list as $i=>$ingredientType):
        foreach ($ingredientType as $j=>$item) :
            if ($item->removed) continue;
        
    ?>
    <tr row-click>
        <td><input type="checkbox"  list-item/></td>
        <td>
            <a href="#">Add</a>
            <input type="hidden" name="data[VendorMapping][$j][unit_id]" value="<?php echo $item->id;?>"/>
            <input type="text" name="data[VendorMapping][$j][product_id]" value="<?php echo $vendorId;?>" 
                   class="vendor-input" product-id/></td>
        <td><?php echo $this->Fraction->toFraction($item->quantity);?></td>
        <td><?php echo $item->unitName;?></td>
        <td><b><?php echo $item->name;?></b></td>
    </tr>
    <?php 
    $vendorId++;
        endforeach;
    endforeach?>
    </tbody>
</table>
<button class="btn-primary" vendor-save>Save</button>
<button class="btn-primary" shop-send>Send Order</button>

