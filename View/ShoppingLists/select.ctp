<script type="text/javascript">
    $(function() {
        $('[list-item]').click(function() {
            rowClicked($(this));
        });
        $('[row-click]').click(function() {
            $checkBox = $(this).find('input');
            rowClicked($checkBox);
        });
        $('[shop-store]').click(function(event) {
            event.preventDefault();
            loadShoppingStep('instore');
        });
        $('[shop-online]').click(function(event) {
            event.preventDefault();
            loadShoppingStep('online');
        })
    });
    
    function loadShoppingStep(routeName) {
        $('#route').val(routeName);
        $('#ShoppingListSelectForm').prop('action', baseUrl + 'ShoppingLists/' + routeName + "/<?php echo $listId;?>");
        $('#ShoppingListSelectForm').submit();
        return false;
    }
    
    function rowClicked($checkBox) {
        if ($checkBox.prop('checked')) {
            $checkBox.removeAttr('checked');
            $checkBox.parent().parent().removeClass('strikeThrough');
        } else {
            $checkBox.prop('checked', true);
            $checkBox.parent().parent().addClass('strikeThrough');
        }
    }
</script>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Shopping List'), array('action' => 'index', $listId), array('class' => 'ajaxNavigation')); ?> </li>
    <li class="active"><?php echo __('Select Items');?></li>
</ol>
<h2><?php echo __('What Items do you already have?');?></h2>
<br/>
<form id="ShoppingListSelectForm" method="POST" action="">
<input type="hidden" name="route" id="route"/>
<table>
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
        <td><input type="checkbox" name="remove[]" value="<?php echo $i . "-" . $j;?>" list-item/></td>
        <td><?php echo round($item->quantity, 1);?></td>
        <td><?php echo $item->unitName;?></td>
        <td><b><?php echo $item->name;?></b></td>
    </tr>
    <?php 
        endforeach;
    endforeach?>
    </tbody>
</table>
<button class="btn-primary" shop-store>Shop At Store</button>
<button class="btn-primary" shop-online>Shop Online</button>
</form>