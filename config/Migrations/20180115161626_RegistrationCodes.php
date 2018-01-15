<?php
use Migrations\AbstractMigration;

class RegistrationCodes extends AbstractMigration
{

    public function up()
    {

        $this->table('registration_codes')
            ->addColumn('enabled', 'boolean', [
                'after' => 'group_id',
                'default' => '0',
                'length' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'after' => 'enabled',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'after' => 'created',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->update();
    }

    public function down()
    {
        $this->table('registration_codes')
            ->removeColumn('enabled')
            ->removeColumn('created')
            ->removeColumn('modified')
            ->update();
    }
}

