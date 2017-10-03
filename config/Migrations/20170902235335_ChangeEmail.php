<?php

use Migrations\AbstractMigration;

class ChangeEmail extends AbstractMigration
{

    public function up()
    {

        $this->table('users')
            ->addColumn('new_email', 'string', [
                'after' => 'reset_code_date',
                'default' => null,
                'length' => 190,
                'null' => true,
            ])
            ->addColumn('new_email_code', 'string', [
                'after' => 'new_email',
                'default' => null,
                'length' => 80,
                'null' => true,
            ])
            ->addColumn('new_email_code_date', 'datetime', [
                'after' => 'new_email_code',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('users')
            ->removeColumn('new_email')
            ->removeColumn('new_email_code')
            ->removeColumn('new_email_code_date')
            ->update();
    }
}

