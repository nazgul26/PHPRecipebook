<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RestaurantsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RestaurantsTable Test Case
 */
class RestaurantsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RestaurantsTable
     */
    public $Restaurants;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Restaurants',
        'app.PriceRanges',
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
        $config = TableRegistry::getTableLocator()->exists('Restaurants') ? [] : ['className' => RestaurantsTable::class];
        $this->Restaurants = TableRegistry::getTableLocator()->get('Restaurants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Restaurants);

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
