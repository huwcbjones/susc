<?php
use Migrations\AbstractMigration;

class GroupAclsTable extends AbstractMigration
{

    public function up()
    {
        $this->table('groups_acls', ['id'=> 'id'])
            ->dropForeignKey('group_id')
            ->dropForeignKey('acl_id')
            ->removeIndex(['group_id', 'acl_id'])
            ->removeIndex(['acl_id'])
            ->update();

        $this->table('groups_acls')
            ->addColumn('id', 'uuid', [
                'default' => null,
                'length' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'acl_id',
                ],
                [
                    'name' => 'groups_acls_acl_id_index',
                ]
            )
            ->update();

        $this->table('groups_acls')
            ->addForeignKey(
                'group_id',
                'groups',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'acl_id',
                'acls',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();
    }

    public function down()
    {
        $this->table('groups_acls')
            ->dropForeignKey(
                'id'
            )
            ->dropForeignKey(
                'acl_id'
            );

        $this->table('groups_acls')
            ->removeIndexByName('groups_acls_acl_id_index')
            ->update();

        $this->table('groups_acls')
            ->removeColumn('id')
            ->addIndex(
                [
                    'group_id',
                    'acl_id',
                ],
                [
                    'name' => 'groups_acls_group_id_acl_id_pk',
                    'unique' => true,
                ]
            )
            ->addIndex(
                [
                    'acl_id',
                ],
                [
                    'name' => 'groups_acls_acls_id_fk',
                ]
            )
            ->addIndex(
                [
                    'group_id',
                ],
                [
                    'name' => 'groups_acls_group_id_index',
                ]
            )
            ->update();

        $this->table('groups_acls')
            ->addForeignKey(
                'acl_id',
                'acls',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->update();
    }
}

