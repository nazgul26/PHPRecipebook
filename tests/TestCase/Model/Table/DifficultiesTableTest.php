<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DifficultiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DifficultiesTable Test Case
 */
class DifficultiesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DifficultiesTable
     */
    public $Difficulties;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Difficulties',
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
        $config = TableRegistry::getTableLocator()->exists('Difficulties') ? [] : ['className' => DifficultiesTable::class];
        $this->Difficulties = TableRegistry::getTableLocator()->get('Difficulties', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Difficulties);

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
