<script type="text/javascript">
    $(function() {
        $('[list-item]').click(function() {
            rowClicked($(this));
        });
    });
</script>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Shopping List'), array('action' => 'index', $listId), array('class' => 'ajaxNavigation')); ?> </li>
    <li><?php echo $this->Html->link(__('Select Items'), array('action' => 'select', $listId), array('class' => 'ajaxNavigation')); ?> </li>
    <li class="active"><?php echo __('In Store');?></li>
</ol>

<label>Select Store</label>
<select>
    <option>Store A</option>
</select>


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
        <td><input type="checkbox" name="remove[]" value="<?php echo $i . "-" . $j;?>" list-item/></td>
        <td><?php echo $this->Fraction->toFraction($item->quantity);?></td>
        <td><?php echo $item->unitName;?></td>
        <td><b><?php echo $item->name;?></b></td>
    </tr>
    <?php 
        endforeach;
    endforeach?>
    </tbody>
</table>
<button class="btn-primary" shop-print>Print</button>
<button class="btn-primary" shop-done>Complete</button>
