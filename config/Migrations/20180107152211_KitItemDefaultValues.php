<?php
use Migrations\AbstractMigration;

class KitItemDefaultValues extends AbstractMigration
{

    public function up()
    {

        $this->table('items')
            ->changeColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->changeColumn('slug', 'string', [
                'default' => null,
                'limit' => 190,
                'null' => false,
            ])
            ->changeColumn('image', 'boolean', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->changeColumn('price', 'decimal', [
                'default' => '0.00',
                'limit' => 10,
                'null' => false,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('items')
            ->changeColumn('title', 'string', [
                'default' => null,
                'length' => 255,
                'null' => true,
            ])
            ->changeColumn('slug', 'string', [
                'default' => null,
                'length' => 190,
                'null' => true,
            ])
            ->changeColumn('image', 'integer', [
                'default' => '0',
                'length' => 4,
                'null' => false,
            ])
            ->changeColumn('price', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 10,
                'scale' => 2,
            ])
            ->update();
    }
}

