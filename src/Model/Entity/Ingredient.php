<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ingredient Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $location_id
 * @property int|null $unit_id
 * @property bool|null $solid
 * @property string|null $system
 * @property int|null $user_id
 * @property int|null $core_ingredient_id
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Unit $unit
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\CoreIngredient $core_ingredient
 * @property \App\Model\Entity\IngredientMapping[] $ingredient_mappings
 * @property \App\Model\Entity\ShoppingListIngredient[] $shopping_list_ingredients
 * @property \App\Model\Entity\VendorProduct[] $vendor_products
 */
class Ingredient extends Entity
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
        'name' => true,
        'description' => true,
        'location_id' => true,
        'unit_id' => true,
        'solid' => true,
        'system_type' => true,
        'user_id' => true,
        'location' => true,
        'unit' => true,
        'user' => true,
        'ingredient_mappings' => true,
        'shopping_list_ingredients' => true,
        'vendor_products' => true,
    ];
}
