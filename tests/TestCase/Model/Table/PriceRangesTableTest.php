<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PriceRangesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PriceRangesTable Test Case
 */
class PriceRangesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PriceRangesTable
     */
    public $PriceRanges;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PriceRanges',
        'app.Restaurants',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PriceRanges') ? [] : ['className' => PriceRangesTable::class];
        $this->PriceRanges = TableRegistry::getTableLocator()->get('PriceRanges', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PriceRanges);

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
