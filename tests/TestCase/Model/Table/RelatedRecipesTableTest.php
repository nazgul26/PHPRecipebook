<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RelatedRecipesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RelatedRecipesTable Test Case
 */
class RelatedRecipesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RelatedRecipesTable
     */
    public $RelatedRecipes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RelatedRecipes',
        'app.Recipes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RelatedRecipes') ? [] : ['className' => RelatedRecipesTable::class];
        $this->RelatedRecipes = TableRegistry::getTableLocator()->get('RelatedRecipes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RelatedRecipes);

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
