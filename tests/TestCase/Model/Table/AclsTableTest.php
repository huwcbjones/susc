<?php
namespace SUSC\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use SUSC\Model\Table\AclsTable;

/**
 * SUSC\Model\Table\AclsTable Test Case
 */
class AclsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \SUSC\Model\Table\AclsTable
     */
    public $Acls;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.acls',
        'app.groups',
        'app.groups_acls',
        'app.users',
        'app.articles',
        'app.users_acls'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Acls') ? [] : ['className' => AclsTable::class];
        $this->Acls = TableRegistry::get('Acls', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Acls);

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
