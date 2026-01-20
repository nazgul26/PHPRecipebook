<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MealPlan Entity
 *
 * @property \Cake\I18n\FrozenDate $mealday
 * @property int $meal_name_id
 * @property int $recipe_id
 * @property int $servings
 * @property int|null $user_id
 * @property int $id
 *
 * @property \App\Model\Entity\MealName $meal_name
 * @property \App\Model\Entity\Recipe $recipe
 * @property \App\Model\Entity\User $user
 */
class MealPlan extends Entity
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
        'mealday' => true,
        'meal_name_id' => true,
        'recipe_id' => true,
        'servings' => true,
        'user_id' => true,
        'meal_name' => true,
        'recipe' => true,
        'user' => true,
    ];
}
