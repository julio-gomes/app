<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BranchOfActivitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BranchOfActivitiesTable Test Case
 */
class BranchOfActivitiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BranchOfActivitiesTable
     */
    public $BranchOfActivities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.branch_of_activities',
        'app.buyers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('BranchOfActivities') ? [] : ['className' => BranchOfActivitiesTable::class];
        $this->BranchOfActivities = TableRegistry::getTableLocator()->get('BranchOfActivities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BranchOfActivities);

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
