<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vendor Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $home_url
 * @property string|null $add_url
 * @property string|null $request_type
 * @property string|null $format
 *
 * @property \App\Model\Entity\VendorProduct[] $vendor_products
 */
class Vendor extends Entity
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
        'home_url' => true,
        'add_url' => true,
        'request_type' => true,
        'format' => true,
        'vendor_products' => true,
    ];
}
