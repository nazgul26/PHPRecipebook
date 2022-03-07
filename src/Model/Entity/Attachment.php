<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Attachment Entity
 *
 * @property int $id
 * @property int $recipe_id
 * @property string $name
 * @property string $attachment
 * @property string|null $dir
 * @property string|null $type
 * @property int|null $size
 * @property int|null $sort_order
 *
 * @property \App\Model\Entity\Recipe $recipe
 */
class Attachment extends Entity
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
        'name' => true,
        'attachment' => true,
        'dir' => true,
        'type' => true,
        'size' => true,
        'sort_order' => true,
        'recipe' => true,
    ];
}
