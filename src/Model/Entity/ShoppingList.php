<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShoppingList Entity
 *
 * @property int $id
 * @property string $name
 * @property int|null $user_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\ShoppingListIngredient[] $shopping_list_ingredients
 * @property \App\Model\Entity\ShoppingListRecipe[] $shopping_list_recipes
 */
class ShoppingList extends Entity
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
        'name' => true,
        'user_id' => true,
        'user' => true,
        'shopping_list_ingredients' => true,
        'shopping_list_recipes' => true,
    ];
}
