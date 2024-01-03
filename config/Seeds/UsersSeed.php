<?php
use Migrations\AbstractSeed;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run() : void
    {
        $data = [
            [
                'username' => 'admin',
                'password' => (new DefaultPasswordHasher)->hash('passwd'),
                'name' => 'Administrator',
                'access_level' => '90',
                'language' => 'en',
                'country' => 'us',
                'created' => '2003-03-09 00:00:00',
                'last_login' => '2014-06-17 00:00:00',
                'email' => 'admin@phprecipebook',
                'id' => '1',
                'modified' => '2015-02-22 02:34:56',
                'reset_token' => NULL,
                'locked' => '0',
                'reset_time' => '2015-01-19 01:49:51',
                'meal_plan_start_day' => '6',
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
