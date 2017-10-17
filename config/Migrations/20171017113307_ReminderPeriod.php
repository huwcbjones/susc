<?php

use Migrations\AbstractMigration;

class ReminderPeriod extends AbstractMigration
{

    public function up()
    {

        $this->table('memberships')
            ->addColumn('last_reminder', 'datetime', [
                'after' => 'is_cancelled',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->update();

        $this->table('orders')
            ->addColumn('last_reminder', 'datetime', [
                'after' => 'is_cancelled',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('memberships')
            ->removeColumn('last_reminder')
            ->update();

        $this->table('orders')
            ->removeColumn('last_reminder')
            ->update();
    }
}

