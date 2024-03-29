<script type="text/javascript">
    $(function() {
        $('[shop-print]').click(function() {
            window.print();
            return false;
        });
        $('[shop-done]').click(function() {
            $('#done').val("1");
            $('#ShoppingListInstoreForm').submit();
        });
        
        $('#store-id').change(function() {
            $('#ShoppingListInstoreForm').submit();
        });
    });
</script>
<?php //echo $this->element('sql_dump'); ?>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Shopping List'), array('action' => 'index', $listId), array('class' => 'ajaxNavigation')); ?> </li>
    <li><?php echo $this->Html->link(__('Select Items'), array('action' => 'select', $listId), array('class' => 'ajaxNavigation')); ?> </li>
    <li class="active"><?php echo __('In Store');?></li>
</ol>
<?php echo $this->Form->create(null, [ 'id' => 'ShoppingListInstoreForm']);?>
<input type="hidden" name="done" id="done" value="0" />
<div id="selectStore">
    <?php echo $this->Form->control('store_id',array('label'=>'Select Store', 'escape' => false)); ?>
</div>

<?php if (isset($removeIds)) :
    foreach ($removeIds as $id) : ?>
    <input type="hidden" name="remove[]" value="<?php echo $id;?>" />
<?php endforeach; endif;?>
    
<table id="instoreShoppingList">
    <tr class="headerRow">
        <th><?php echo __('Select');?></th>
        <th><?php echo __('Quantity');?></th>
        <th><?php echo __('Unit');?></th>
        
        <th><?php echo __('Name');?></th>
    </tr>
    <tbody class="gridContent">
    <?php 
    $locationName = "";
    foreach ($list as $i=>$ingredientType):
        foreach ($ingredientType as $j=>$item) :
            if ($item->removed) {
                continue;
            }
            
            $locationChanged = false;
            if ($locationName != $item->locationName) {
                $locationName = $item->locationName;
                $locationChanged = true;
            }
    ?>
    <?php if ($locationChanged) :?>
        <tr class="storeLocation">
            <td colspan="4"><div><?php echo ($locationChanged) ? $locationName : "";?></div></td>
        </tr>
    <?php endif;?>
        
    <tr row-click>
        <td><input type="checkbox" list-item/></td>
        <td><?php echo $this->Fraction->toFraction($item->quantity);?></td>
        <td><?php echo $item->unitName;?></td>
        <td><b><?php echo $item->name;?></b></td>
    </tr>
    <?php 
        endforeach;
    endforeach?>
    </tbody>
</table>
<button class="btn-primary" shop-print><?php echo __('Print');?></button>
<button class="btn-primary" shop-done><?php echo __('Complete');?></button>
</form>