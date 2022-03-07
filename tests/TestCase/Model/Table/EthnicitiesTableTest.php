<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EthnicitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EthnicitiesTable Test Case
 */
class EthnicitiesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EthnicitiesTable
     */
    public $Ethnicities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Ethnicities',
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
        $config = TableRegistry::getTableLocator()->exists('Ethnicities') ? [] : ['className' => EthnicitiesTable::class];
        $this->Ethnicities = TableRegistry::getTableLocator()->get('Ethnicities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Ethnicities);

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
