<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

class User extends Entity
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
        'username' => true,
        'password' => true,
        'name' => true,
        'access_level' => true,
        'language' => true,
        'country' => true,
        'created' => true,
        'last_login' => true,
        'email' => true,
        'modified' => true,
        'reset_token' => true,
        'locked' => true,
        'reset_time' => true,
        'meal_plan_start_day' => true,
        'ingredients' => true,
        'meal_plans' => true,
        'recipes' => true,
        'restaurants' => true,
        'reviews' => true,
        'shopping_list_ingredients' => true,
        'shopping_list_recipes' => true,
        'shopping_lists' => true,
        'sources' => true,
        'vendor_products' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected array $_hidden = [
        'password',
    ];

    /**
     * Automatically hash the password when setting it.
     *
     * @param string $password The password to hash.
     * @return string|null
     */
    protected function _setPassword(string $password): ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        return null;
    }
}
