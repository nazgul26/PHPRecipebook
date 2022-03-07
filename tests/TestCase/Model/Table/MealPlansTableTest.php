<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MealPlansTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MealPlansTable Test Case
 */
class MealPlansTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MealPlansTable
     */
    public $MealPlans;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MealPlans',
        'app.MealNames',
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
        $config = TableRegistry::getTableLocator()->exists('MealPlans') ? [] : ['className' => MealPlansTable::class];
        $this->MealPlans = TableRegistry::getTableLocator()->get('MealPlans', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MealPlans);

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
