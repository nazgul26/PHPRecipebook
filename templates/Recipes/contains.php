<?php 
use Cake\Routing\Router;
$baseUrl = Router::url('/');
?>
<?php //echo $this->element('sql_dump'); ?>

<script type="text/javascript">
    $(function() {
        setSearchBoxTarget('Recipes');
        
        $('#addIngredientAutocomplete').autocomplete({
            source: "<?php echo $baseUrl; ?>Ingredients/autoCompleteSearch",
            minLength: 1,
            html: true,
            select: function(event, ui) {
                $('#placeHolderRow').hide();
                $('.gridContent').append('<tr><td>' + ui.item.value + '<input type="hidden" name="data[]" value="' + ui.item.id + '"/></td></tr>');
                $(this).val('');
                return false;
            }
        });
        
        $('[clear-list]').click(function() {
        console.log('going to clear list');
            $('.gridContent > tr').remove();
        });
    });
</script>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Recipes'), array('action' => 'index')); ?> </li>
    <li class="active"><?php echo __('Find By Ingredient(s)');?></li>
</ol>

<h2><?php echo __('Enter the ingredients');?></h2>
<div class="containsForm form">
<?php echo $this->Form->create($shoppingList); ?>
    <fieldset class="addShoppingListItem">
        <span><?php echo __('Search');?></span>
        <input type="text" class="ui-widget" id="addIngredientAutocomplete"/>
    </fieldset>
    
    <table>
        <tr class="headerRow">
            <th><?php echo __('Ingredient Name');?></th>
        </tr>
        <tbody class="gridContent">
            <tr id="placeHolderRow">
                <td><i><?php echo __('No ingredients selected');?></i></td>
            </tr>
        </tbody>
    </table>
    
    <button class="btn-primary"><?php echo __('Search');?></button>
    <a href="#" clear-list><?php echo __('Clear');?></a>
    
</form>

<?php if (isset($recipes)) :?>
<br/>

<h3><?php echo __('Recipes found');?></h3>
<hr/>
    </h4>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo __('# of Matches');?></th>
	</tr>
	<?php foreach ($recipes as $recipe): ?>
	<tr>
            <td class="actions">
                <?php if (isset($recipe->private) && $recipe->private == 'true' && $loggedInuserId != $recipe->user->id && !$isEditor) {
                    echo __('(private)');
                } else {
                    echo $this->Html->link(__('View'), array('action' => 'view', $recipe->id), array('class' => 'ajaxNavigation')); 
                }
                if ($loggedIn  && ($isAdmin || $loggedInuserId == $recipe->user->id)):?>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $recipe->id), array('class' => 'ajaxNavigation')); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $recipe->id), ['confirm' => __('Are you sure you want to delete {0}?', $recipe->name)]); ?>
                <?php endif;?>
            </td>
            <td><?php echo h($recipe->name); ?>&nbsp;</td>
            <td><?php echo $recipe->matches;?></td>
	</tr>
<?php endforeach; endif; ?>
