<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VendorProduct Entity
 *
 * @property int $id
 * @property int $ingredient_id
 * @property int $vendor_id
 * @property string|null $code
 * @property int|null $user_id
 * @property string|null $name
 *
 * @property \App\Model\Entity\Ingredient $ingredient
 * @property \App\Model\Entity\Vendor $vendor
 * @property \App\Model\Entity\User $user
 */
class VendorProduct extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'ingredient_id' => true,
        'vendor_id' => true,
        'code' => true,
        'user_id' => true,
        'name' => true,
        'ingredient' => true,
        'vendor' => true,
        'user' => true,
    ];
}
