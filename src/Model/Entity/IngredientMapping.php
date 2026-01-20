<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * IngredientMapping Entity
 *
 * @property int $recipe_id
 * @property int $ingredient_id
 * @property float $quantity
 * @property int|null $unit_id
 * @property string|null $qualifier
 * @property bool|null $optional
 * @property int|null $sort_order
 * @property int $id
 * @property string|null $note
 *
 * @property \App\Model\Entity\Recipe $recipe
 * @property \App\Model\Entity\Ingredient $ingredient
 * @property \App\Model\Entity\Unit $unit
 */
class IngredientMapping extends Entity
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
        'recipe_id' => true,
        'ingredient_id' => true,
        'quantity' => true,
        'unit_id' => true,
        'qualifier' => true,
        'optional' => true,
        'sort_order' => true,
        'note' => true,
        'recipe' => true,
        'ingredient' => true,
        'unit' => true,
    ];
}
