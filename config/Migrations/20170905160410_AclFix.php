<?php

use Migrations\AbstractMigration;

class AclFix extends AbstractMigration
{

    public function up()
    {
        $this->table('groups_acls')
            ->dropForeignKey([], 'primary')
            ->update();
        $this->table('users_acls')
            ->dropForeignKey([], 'primary')
            ->update();

        $this->table('acls')
            ->changeColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->update();

        $this->table('users')
            ->changeColumn('is_active', 'boolean', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->changeColumn('is_enable', 'boolean', [
                'default' => '1',
                'limit' => null,
                'null' => false,
            ])
            ->changeColumn('is_change_password', 'boolean', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->update();

        $this->table('static_content', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('key', 'string', [
                'default' => null,
                'limit' => 190,
                'null' => false,
            ])
            ->addColumn('value', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'key',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('groups_acls')
            ->addColumn('id', 'uuid', [
                'default' => null,
                'length' => null,
                'null' => false,
            ])
            ->update();

        $this->table('users_acls')
            ->addColumn('id', 'uuid', [
                'default' => null,
                'length' => null,
                'null' => false,
            ])
            ->update();

        $this->table('acls')
            ->addColumn('name', 'string', [
                'after' => 'id',
                'default' => null,
                'length' => 255,
                'null' => true,
            ])
            ->addIndex(
                [
                    'id',
                ],
                [
                    'name' => 'acls_id_index',
                ]
            )
            ->update();

        $this->table('groups')
            ->addColumn('created', 'datetime', [
                'after' => 'name',
                'default' => null,
                'length' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'after' => 'created',
                'default' => 'CURRENT_TIMESTAMP',
                'length' => null,
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'after' => 'modified',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->addColumn('is_enable', 'boolean', [
                'after' => 'description',
                'default' => '1',
                'length' => null,
                'null' => true,
            ])
            ->update();

        $this->table('groups_acls')
            ->addForeignKey(
                'id',
                '',
                '',
                [
                    'update' => '',
                    'delete' => ''
                ]
            )
            ->update();

        $this->table('users_acls')
            ->addForeignKey(
                'id',
                '',
                '',
                [
                    'update' => '',
                    'delete' => ''
                ]
            )
            ->update();

        $this->dropTable('scontent');
    }

    public function down()
    {
        $this->table('groups_acls')
            ->dropForeignKey(
                'id'
            );

        $this->table('users_acls')
            ->dropForeignKey(
                'id'
            );

        $this->table('scontent', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('key', 'string', [
                'default' => null,
                'limit' => 190,
                'null' => false,
            ])
            ->addColumn('value', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'key',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('groups_acls')
            ->removeColumn('id')
            ->update();

        $this->table('users_acls')
            ->removeColumn('id')
            ->update();

        $this->table('acls')
            ->removeIndexByName('acls_id_index')
            ->update();

        $this->table('acls')
            ->changeColumn('description', 'string', [
                'default' => null,
                'length' => 255,
                'null' => true,
            ])
            ->removeColumn('name')
            ->update();

        $this->table('groups')
            ->removeColumn('created')
            ->removeColumn('modified')
            ->removeColumn('description')
            ->removeColumn('is_enable')
            ->update();

        $this->table('users')
            ->changeColumn('is_active', 'string', [
                'default' => 'b\'0\'',
                'length' => null,
                'null' => false,
            ])
            ->changeColumn('is_enable', 'string', [
                'default' => 'b\'1\'',
                'length' => null,
                'null' => false,
            ])
            ->changeColumn('is_change_password', 'string', [
                'default' => 'b\'0\'',
                'length' => null,
                'null' => false,
            ])
            ->update();

        $this->table('groups_acls')
            ->addForeignKey(
                [
                    'group_id',
                    'acl_id',
                ],
                '',
                '',
                [
                    'update' => '',
                    'delete' => ''
                ]
            )
            ->update();

        $this->table('users_acls')
            ->addForeignKey(
                [
                    'user_id',
                    'acl_id',
                ],
                '',
                '',
                [
                    'update' => '',
                    'delete' => ''
                ]
            )
            ->update();

        $this->dropTable('static_content');
    }
}

