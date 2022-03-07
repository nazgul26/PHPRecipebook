<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShoppingListRecipesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShoppingListRecipesTable Test Case
 */
class ShoppingListRecipesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ShoppingListRecipesTable
     */
    public $ShoppingListRecipes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ShoppingListRecipes',
        'app.ShoppingLists',
        'app.Recipes',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ShoppingListRecipes') ? [] : ['className' => ShoppingListRecipesTable::class];
        $this->ShoppingListRecipes = TableRegistry::getTableLocator()->get('ShoppingListRecipes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShoppingListRecipes);

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
