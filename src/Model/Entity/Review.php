<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Review Entity
 *
 * @property int $recipe_id
 * @property string $comments
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int|null $user_id
 * @property int $id
 * @property int|null $rating
 *
 * @property \App\Model\Entity\Recipe $recipe
 * @property \App\Model\Entity\User $user
 */
class Review extends Entity
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
        'recipe_id' => true,
        'comments' => true,
        'created' => true,
        'user_id' => true,
        'rating' => true,
        'recipe' => true,
        'user' => true,
    ];
}
