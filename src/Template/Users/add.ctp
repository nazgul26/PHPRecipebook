<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Ingredients'), ['controller' => 'Ingredients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ingredient'), ['controller' => 'Ingredients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Meal Plans'), ['controller' => 'MealPlans', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Meal Plan'), ['controller' => 'MealPlans', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Recipes'), ['controller' => 'Recipes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Recipe'), ['controller' => 'Recipes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Restaurants'), ['controller' => 'Restaurants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Restaurant'), ['controller' => 'Restaurants', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Reviews'), ['controller' => 'Reviews', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Review'), ['controller' => 'Reviews', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shopping List Ingredients'), ['controller' => 'ShoppingListIngredients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Shopping List Ingredient'), ['controller' => 'ShoppingListIngredients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shopping List Recipes'), ['controller' => 'ShoppingListRecipes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Shopping List Recipe'), ['controller' => 'ShoppingListRecipes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shopping Lists'), ['controller' => 'ShoppingLists', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Shopping List'), ['controller' => 'ShoppingLists', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sources'), ['controller' => 'Sources', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Source'), ['controller' => 'Sources', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Vendor Products'), ['controller' => 'VendorProducts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Vendor Product'), ['controller' => 'VendorProducts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->control('username');
            echo $this->Form->control('password');
            echo $this->Form->control('name');
            echo $this->Form->control('access_level');
            echo $this->Form->control('language');
            echo $this->Form->control('country');
            echo $this->Form->control('last_login', ['empty' => true]);
            echo $this->Form->control('email');
            echo $this->Form->control('reset_token');
            echo $this->Form->control('locked');
            echo $this->Form->control('reset_time', ['empty' => true]);
            echo $this->Form->control('meal_plan_start_day');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
