<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BaseTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BaseTypesTable Test Case
 */
class BaseTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BaseTypesTable
     */
    public $BaseTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.BaseTypes',
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
        $config = TableRegistry::getTableLocator()->exists('BaseTypes') ? [] : ['className' => BaseTypesTable::class];
        $this->BaseTypes = TableRegistry::getTableLocator()->get('BaseTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BaseTypes);

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
