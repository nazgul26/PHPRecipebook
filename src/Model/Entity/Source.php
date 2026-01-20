<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Source Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $user_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Recipe[] $recipes
 */
class Source extends Entity
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
        'description' => true,
        'user_id' => true,
        'user' => true,
        'recipes' => true,
    ];
}
