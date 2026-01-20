<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RelatedRecipe Entity
 *
 * @property int $parent_id
 * @property int $recipe_id
 * @property bool|null $required
 * @property int|null $sort_order
 * @property int $id
 *
 * @property \App\Model\Entity\ParentRelatedRecipe $parent_related_recipe
 * @property \App\Model\Entity\Recipe $recipe
 * @property \App\Model\Entity\ChildRelatedRecipe[] $child_related_recipes
 */
class RelatedRecipe extends Entity
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
        'parent_id' => true,
        'recipe_id' => true,
        'required' => true,
        'sort_order' => true,
        'parent_related_recipe' => true,
        'recipe' => true,
        'child_related_recipes' => true,
    ];
}
