<?php
use Migrations\AbstractSeed;

/**
 * BaseTypes seed.
 */
class BaseTypesSeed extends AbstractSeed
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
    public function run()
    {
        $data = [
            [
                'name' => __('Beef')
            ],
            [
                'name' => __('Bread')
            ],
            [
                'name' => __('Egg')
            ],
            [
                'name' => __('Fruit'),
            ],
            [
                'name' => __('Grain'),
            ],
            [
                'name' => __('Lamb'),
            ],
            [
                'name' => __('Other'),
            ],
            [
                'name' => __('Pasta'),
            ],
            [
                'name' => __('Pork/Ham'),
            ],
            [
                'name' => __('Poultry'),
            ],
            [
                'name' => __('Seafood'),
            ],
            [
                'name' => __('Vegetable'),
            ],
        ];

        $table = $this->table('base_types');
        $table->insert($data)->save();
    }
}
