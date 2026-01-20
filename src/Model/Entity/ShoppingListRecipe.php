<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShoppingListRecipe Entity
 *
 * @property int $id
 * @property int $shopping_list_id
 * @property int $recipe_id
 * @property int|null $servings
 * @property int|null $user_id
 *
 * @property \App\Model\Entity\ShoppingList $shopping_list
 * @property \App\Model\Entity\Recipe $recipe
 * @property \App\Model\Entity\User $user
 */
class ShoppingListRecipe extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected array $_accessible = [
        'shopping_list_id' => true,
        'recipe_id' => true,
        'servings' => true,
        'user_id' => true,
        'shopping_list' => true,
        'recipe' => true,
        'user' => true,
    ];
}
