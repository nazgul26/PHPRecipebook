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
    foreach ($list as $ingredientType) {
        foreach ($ingredientType as $item) {
    ?>
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