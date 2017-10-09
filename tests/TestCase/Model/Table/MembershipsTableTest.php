<?php
namespace SUSC\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use SUSC\Model\Table\MembershipsTable;

/**
 * SUSC\Model\Table\MembershipsTable Test Case
 */
class MembershipsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \SUSC\Model\Table\MembershipsTable
     */
    public $Memberships;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.memberships',
        'app.users',
        'app.articles',
        'app.orders',
        'app.items_orders',
        'app.items',
        'app.processed_orders',
        'app.groups',
        'app.acls',
        'app.groups_acls',
        'app.users_acls',
        'app.students',
        'app.sotons',
        'app.membership_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Memberships') ? [] : ['className' => MembershipsTable::class];
        $this->Memberships = TableRegistry::get('Memberships', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Memberships);

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
