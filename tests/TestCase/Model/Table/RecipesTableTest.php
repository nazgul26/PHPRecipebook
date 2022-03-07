<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RecipesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RecipesTable Test Case
 */
class RecipesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RecipesTable
     */
    public $Recipes;

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
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Recipes') ? [] : ['className' => RecipesTable::class];
        $this->Recipes = TableRegistry::getTableLocator()->get('Recipes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Recipes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
