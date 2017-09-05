<?php
namespace SUSC\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use SUSC\Model\Table\UsersTable;

/**
 * SUSC\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \SUSC\Model\Table\UsersTable
     */
    public $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        'app.articles',
        'app.acls',
        'app.groups',
        'app.groups_acls',
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
        $config = TableRegistry::exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = TableRegistry::get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Users);

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

    /**
     * Test findActive method
     *
     * @return void
     */
    public function testFindActive()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findId method
     *
     * @return void
     */
    public function testFindId()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findUsername method
     *
     * @return void
     */
    public function testFindUsername()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findEmail method
     *
     * @return void
     */
    public function testFindEmail()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationChangePassword method
     *
     * @return void
     */
    public function testValidationChangePassword()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationChangeEmail method
     *
     * @return void
     */
    public function testValidationChangeEmail()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
