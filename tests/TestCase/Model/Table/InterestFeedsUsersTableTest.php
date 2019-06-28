<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InterestFeedsUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InterestFeedsUsersTable Test Case
 */
class InterestFeedsUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InterestFeedsUsersTable
     */
    public $InterestFeedsUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.interest_feeds_users',
        'app.feeds',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('InterestFeedsUsers') ? [] : ['className' => InterestFeedsUsersTable::class];
        $this->InterestFeedsUsers = TableRegistry::getTableLocator()->get('InterestFeedsUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InterestFeedsUsers);

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
