<?php
namespace SUSC\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MembershipsFixture
 *
 */
class MembershipsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'student_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'soton_id' => ['type' => 'string', 'fixed' => true, 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'date_of_birth' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'membership_type_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'paid' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'memberships_user_id_index' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'memberships_membership_type_id_index' => ['type' => 'index', 'columns' => ['membership_type_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'memberships_membership_types_id_fk' => ['type' => 'foreign', 'columns' => ['membership_type_id'], 'references' => ['membership_types', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
            'memberships_users_id_fk' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_unicode_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => '39dbd333-712f-4500-8942-0a3c8d7c633b',
            'user_id' => 'c8d30752-e4e9-49de-8476-cfbde911ead1',
            'student_id' => 1,
            'soton_id' => 'Lorem ipsum dolor ',
            'name' => 'Lorem ipsum dolor sit amet',
            'date_of_birth' => '2017-10-05',
            'membership_type_id' => '4b22b96c-907e-4ea5-9d9b-c2f3c7482452',
            'created' => '2017-10-05 16:26:28',
            'paid' => '2017-10-05 16:26:28'
        ],
    ];
}
