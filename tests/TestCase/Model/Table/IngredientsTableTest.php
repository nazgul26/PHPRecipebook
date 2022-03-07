<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IngredientsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IngredientsTable Test Case
 */
class IngredientsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\IngredientsTable
     */
    public $Ingredients;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Ingredients',
        'app.Locations',
        'app.Units',
        'app.Users',
        'app.CoreIngredients',
        'app.IngredientMappings',
        'app.ShoppingListIngredients',
        'app.VendorProducts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Ingredients') ? [] : ['className' => IngredientsTable::class];
        $this->Ingredients = TableRegistry::getTableLocator()->get('Ingredients', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Ingredients);

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
