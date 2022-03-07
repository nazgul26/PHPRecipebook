<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PreparationMethodsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PreparationMethodsTable Test Case
 */
class PreparationMethodsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PreparationMethodsTable
     */
    public $PreparationMethods;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PreparationMethods',
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
        $config = TableRegistry::getTableLocator()->exists('PreparationMethods') ? [] : ['className' => PreparationMethodsTable::class];
        $this->PreparationMethods = TableRegistry::getTableLocator()->get('PreparationMethods', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PreparationMethods);

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
}
