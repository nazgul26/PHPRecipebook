<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Unit Entity
 *
 * @property int $id
 * @property string $name
 * @property string $abbreviation
 * @property int $system
 * @property int $sort_order
 *
 * @property \App\Model\Entity\IngredientMapping[] $ingredient_mappings
 * @property \App\Model\Entity\Ingredient[] $ingredients
 * @property \App\Model\Entity\ShoppingListIngredient[] $shopping_list_ingredients
 */
class Unit extends Entity
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
        'abbreviation' => true,
        'system_type' => true,
        'sort_order' => true,
        'ingredient_mappings' => true,
        'ingredients' => true,
        'shopping_list_ingredients' => true,
    ];
}
