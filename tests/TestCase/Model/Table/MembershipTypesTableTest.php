<?php
namespace SUSC\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use SUSC\Model\Table\MembershipTypesTable;

/**
 * SUSC\Model\Table\MembershipTypesTable Test Case
 */
class MembershipTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \SUSC\Model\Table\MembershipTypesTable
     */
    public $MembershipTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.membership_types',
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
        'app.sotons'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MembershipTypes') ? [] : ['className' => MembershipTypesTable::class];
        $this->MembershipTypes = TableRegistry::get('MembershipTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MembershipTypes);

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
