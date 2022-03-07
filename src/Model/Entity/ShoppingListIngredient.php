<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShoppingListIngredient Entity
 *
 * @property int $id
 * @property int $shopping_list_id
 * @property int $ingredient_id
 * @property int $unit_id
 * @property string|null $qualifier
 * @property float $quantity
 * @property int|null $user_id
 *
 * @property \App\Model\Entity\ShoppingList $shopping_list
 * @property \App\Model\Entity\Ingredient $ingredient
 * @property \App\Model\Entity\Unit $unit
 * @property \App\Model\Entity\User $user
 */
class ShoppingListIngredient extends Entity
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
    protected $_accessible = [
        'shopping_list_id' => true,
        'ingredient_id' => true,
        'unit_id' => true,
        'qualifier' => true,
        'quantity' => true,
        'user_id' => true,
        'shopping_list' => true,
        'ingredient' => true,
        'unit' => true,
        'user' => true,
    ];
}
