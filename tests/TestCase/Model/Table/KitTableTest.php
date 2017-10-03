<?php
namespace SUSC\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * SUSC\Model\Table\KitTable Test Case
 */
class KitTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \SUSC\Model\Table\KitTable
     */
    public $Kit;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.kit'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Kit') ? [] : ['className' => 'SUSC\Model\Table\KitTable'];
        $this->Kit = TableRegistry::get('Kit', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Kit);

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
