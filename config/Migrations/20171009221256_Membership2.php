<?php

use Migrations\AbstractMigration;

class Membership2 extends AbstractMigration
{

    public function up()
    {

        $this->table('memberships')
            ->addColumn('modified', 'datetime', [
                'after' => 'created',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->addColumn('is_cancelled', 'boolean', [
                'after' => 'paid',
                'default' => '0',
                'length' => null,
                'null' => true,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('memberships')
            ->removeColumn('modified')
            ->removeColumn('is_cancelled')
            ->update();
    }
}

