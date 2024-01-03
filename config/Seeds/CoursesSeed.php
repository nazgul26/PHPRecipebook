<?php
use Migrations\AbstractSeed;

/**
 * Courses seed.
 */
class CoursesSeed extends AbstractSeed
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
            ['name' => __('Breakfast')],
            ['name' => __('Snack')],
            ['name' => __('Lunch')],
            ['name' => __('Appetizer')],
            ['name' => __('Side Dish')],
            ['name' => __('Entree')],
            ['name' => __('Dessert')],
            ['name' => __('Beverage')]
        ];

        $table = $this->table('courses');
        $table->insert($data)->save();
    }
}
