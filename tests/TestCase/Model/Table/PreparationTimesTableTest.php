<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PreparationTimesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PreparationTimesTable Test Case
 */
class PreparationTimesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PreparationTimesTable
     */
    public $PreparationTimes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PreparationTimes',
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
        $config = TableRegistry::getTableLocator()->exists('PreparationTimes') ? [] : ['className' => PreparationTimesTable::class];
        $this->PreparationTimes = TableRegistry::getTableLocator()->get('PreparationTimes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PreparationTimes);

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
