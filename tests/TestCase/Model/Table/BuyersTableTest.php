<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BuyersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BuyersTable Test Case
 */
class BuyersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BuyersTable
     */
    public $Buyers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.buyers',
        'app.persons',
        'app.branch_of_activities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Buyers') ? [] : ['className' => BuyersTable::class];
        $this->Buyers = TableRegistry::getTableLocator()->get('Buyers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Buyers);

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
