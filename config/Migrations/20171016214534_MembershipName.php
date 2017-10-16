<?php

use Migrations\AbstractMigration;

class MembershipName extends AbstractMigration
{

    public function up()
    {

        $this->table('memberships')
            ->changeColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->update();

        $this->table('memberships')
            ->addColumn('first_name', 'string', [
                'after' => 'name',
                'default' => null,
                'length' => 255,
                'null' => true,
            ])
            ->addColumn('last_name', 'string', [
                'after' => 'first_name',
                'default' => null,
                'length' => 255,
                'null' => true,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('memberships')
            ->changeColumn('name', 'string', [
                'default' => null,
                'length' => 255,
                'null' => true,
            ])
            ->removeColumn('first_name')
            ->removeColumn('last_name')
            ->update();
    }
}

