<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VendorProductsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VendorProductsTable Test Case
 */
class VendorProductsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VendorProductsTable
     */
    protected $VendorProducts;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.VendorProducts',
        'app.Ingredients',
        'app.Vendors',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('VendorProducts') ? [] : ['className' => VendorProductsTable::class];
        $this->VendorProducts = $this->getTableLocator()->get('VendorProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->VendorProducts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\VendorProductsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\VendorProductsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
