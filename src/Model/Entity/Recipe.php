<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Recipe Entity
 *
 * @property int $id
 * @property string $name
 * @property int|null $ethnicity_id
 * @property int|null $base_type_id
 * @property int|null $course_id
 * @property int|null $preparation_time_id
 * @property int|null $difficulty_id
 * @property int|null $serving_size
 * @property string|null $directions
 * @property bool $use_markdown
 * @property string|null $comments
 * @property string|null $source_description
 * @property float|null $recipe_cost
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|resource|null $picture
 * @property string|null $picture_type
 * @property bool $private
 * @property string $system
 * @property int|null $source_id
 * @property int|null $user_id
 * @property int|null $preparation_method_id
 *
 * @property \App\Model\Entity\Ethnicity $ethnicity
 * @property \App\Model\Entity\BaseType $base_type
 * @property \App\Model\Entity\Course $course
 * @property \App\Model\Entity\PreparationTime $preparation_time
 * @property \App\Model\Entity\Difficulty $difficulty
 * @property \App\Model\Entity\Source $source
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\PreparationMethod $preparation_method
 * @property \App\Model\Entity\Attachment[] $attachments
 * @property \App\Model\Entity\IngredientMapping[] $ingredient_mappings
 * @property \App\Model\Entity\MealPlan[] $meal_plans
 * @property \App\Model\Entity\RelatedRecipe[] $related_recipes
 * @property \App\Model\Entity\Review[] $reviews
 * @property \App\Model\Entity\ShoppingListRecipe[] $shopping_list_recipes
 * @property \App\Model\Entity\Tag[] $tags
 * @property string|null $tags_list
 */
class Recipe extends Entity
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
        'ethnicity_id' => true,
        'base_type_id' => true,
        'course_id' => true,
        'preparation_time_id' => true,
        'difficulty_id' => true,
        'serving_size' => true,
        'directions' => true,
        'use_markdown' => true,
        'comments' => true,
        'source_description' => true,
        'recipe_cost' => true,
        'modified' => true,
        'picture' => true,
        'picture_type' => true,
        'private' => true,
        'system_type' => true,
        'source_id' => true,
        'user_id' => true,
        'preparation_method_id' => true,
        'ethnicity' => true,
        'base_type' => true,
        'course' => true,
        'preparation_time' => true,
        'difficulty' => true,
        'source' => true,
        'user' => true,
        'preparation_method' => true,
        'attachments' => true,
        'ingredient_mappings' => true,
        'meal_plans' => true,
        'related_recipes' => true,
        'reviews' => true,
        'shopping_list_recipes' => true,
        'tags' => true,
        'tags_list' => true,
    ];
}
