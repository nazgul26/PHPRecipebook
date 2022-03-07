<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Restaurant Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $street
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip
 * @property string|null $phone
 * @property string|null $hours
 * @property string|resource|null $picture
 * @property string|null $picture_type
 * @property string|null $menu_text
 * @property string|null $comments
 * @property int|null $price_range_id
 * @property bool|null $delivery
 * @property bool|null $carry_out
 * @property bool|null $dine_in
 * @property bool|null $credit
 * @property int|null $user_id
 * @property string|null $website
 * @property string|null $country
 *
 * @property \App\Model\Entity\PriceRange $price_range
 * @property \App\Model\Entity\User $user
 */
class Restaurant extends Entity
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
        'street' => true,
        'city' => true,
        'state' => true,
        'zip' => true,
        'phone' => true,
        'hours' => true,
        'picture' => true,
        'picture_type' => true,
        'menu_text' => true,
        'comments' => true,
        'price_range_id' => true,
        'delivery' => true,
        'carry_out' => true,
        'dine_in' => true,
        'credit' => true,
        'user_id' => true,
        'website' => true,
        'country' => true,
        'price_range' => true,
        'user' => true,
    ];
}
