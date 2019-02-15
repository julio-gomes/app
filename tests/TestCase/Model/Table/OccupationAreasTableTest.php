<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OccupationAreasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OccupationAreasTable Test Case
 */
class OccupationAreasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OccupationAreasTable
     */
    public $OccupationAreas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.occupation_areas',
        'app.sellers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OccupationAreas') ? [] : ['className' => OccupationAreasTable::class];
        $this->OccupationAreas = TableRegistry::getTableLocator()->get('OccupationAreas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OccupationAreas);

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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
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
