<?php
namespace App\Test\TestCase\Controller;

use App\Controller\RecipesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\RecipesController Test Case
 *
 * @uses \App\Controller\RecipesController
 */
class RecipesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Recipes',
        'app.Ethnicities',
        'app.BaseTypes',
        'app.Courses',
        'app.PreparationTimes',
        'app.Difficulties',
        'app.Sources',
        'app.Users',
        'app.PreparationMethods',
        'app.Attachments',
        'app.IngredientMappings',
        'app.MealPlans',
        'app.RelatedRecipes',
        'app.Reviews',
        'app.ShoppingListRecipes',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
