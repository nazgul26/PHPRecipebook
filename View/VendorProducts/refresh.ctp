<?php //echo //$this->element('sql_dump'); ?>

<?php 
$ingredientId = $this->request->data[0]['VendorProduct']['ingredient_id'];
?>

<select id="SelectedToAdd<?php echo $ingredientId;?>" class="vendor-input" product-id>
    <option></option>
<?php
$productCode = "";
$productId = "";
$productName = "";
                
foreach ($this->request->data as $item) {
    $productCode = $item['VendorProduct']['code'];
    $productId = $item['VendorProduct']['id'];
    $productName = $item['VendorProduct']['name'];
    ?>
    <option value="<?php echo $productCode + ";" + $productId;?>" selected><?php echo $productName;?> (<?php echo $productCode;?>)</option>
    <?php
}
?>
</select>
