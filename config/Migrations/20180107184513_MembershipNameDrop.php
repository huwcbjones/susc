<?php
use Migrations\AbstractMigration;

class MembershipNameDrop extends AbstractMigration
{

    public function up()
    {

        $this->table('memberships')
            ->removeColumn('name')
            ->update();
    }

    public function down()
    {

        $this->table('memberships')
            ->addColumn('name', 'string', [
                'after' => 'soton_id',
                'default' => null,
                'length' => 255,
                'null' => false,
            ])
            ->update();
    }
}

