<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShoppingListIngredientsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShoppingListIngredientsTable Test Case
 */
class ShoppingListIngredientsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ShoppingListIngredientsTable
     */
    public $ShoppingListIngredients;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ShoppingListIngredients',
        'app.ShoppingLists',
        'app.Ingredients',
        'app.Units',
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
        $config = TableRegistry::getTableLocator()->exists('ShoppingListIngredients') ? [] : ['className' => ShoppingListIngredientsTable::class];
        $this->ShoppingListIngredients = TableRegistry::getTableLocator()->get('ShoppingListIngredients', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShoppingListIngredients);

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
