<script type="text/javascript">
    $(function() {
        $('[list-item]').click(function() {
            rowClicked($(this));
        });
        $('[row-click]').click(function() {
            console.log("clicked");
            $checkBox = $(this).find('input');
            rowClicked($checkBox);
        });
        
    });
    
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
<?php //echo $this->element('sql_dump'); ?>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Shopping List'), array('action' => 'index'), array('class' => 'ajaxNavigation')); ?> </li>
    <li class="active"><?php echo __('Select Items');?></li>
</ol>
<h2><?php echo __('What Items do you already have?');?></h2>
<br/>


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
    foreach ($list as $ingredientType) {
        foreach ($ingredientType as $item) {
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
    <?php } 
    }?>
    </tbody>
</table>
<button class="btn-primary">Shop At Store</button>
<button class="btn-primary">Shop Online</button>