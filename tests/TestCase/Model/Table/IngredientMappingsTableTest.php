<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IngredientMappingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IngredientMappingsTable Test Case
 */
class IngredientMappingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\IngredientMappingsTable
     */
    public $IngredientMappings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.IngredientMappings',
        'app.Recipes',
        'app.Ingredients',
        'app.Units',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('IngredientMappings') ? [] : ['className' => IngredientMappingsTable::class];
        $this->IngredientMappings = TableRegistry::getTableLocator()->get('IngredientMappings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IngredientMappings);

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
