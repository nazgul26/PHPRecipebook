<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShoppingList $shoppingList
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $shoppingList->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $shoppingList->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Shopping Lists'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shopping List Ingredients'), ['controller' => 'ShoppingListIngredients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Shopping List Ingredient'), ['controller' => 'ShoppingListIngredients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shopping List Recipes'), ['controller' => 'ShoppingListRecipes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Shopping List Recipe'), ['controller' => 'ShoppingListRecipes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="shoppingLists form large-9 medium-8 columns content">
    <?= $this->Form->create($shoppingList) ?>
    <fieldset>
        <legend><?= __('Edit Shopping List') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
