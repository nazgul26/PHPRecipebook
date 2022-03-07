<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MealNamesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MealNamesTable Test Case
 */
class MealNamesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MealNamesTable
     */
    public $MealNames;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MealNames',
        'app.MealPlans',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MealNames') ? [] : ['className' => MealNamesTable::class];
        $this->MealNames = TableRegistry::getTableLocator()->get('MealNames', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MealNames);

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
