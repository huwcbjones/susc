<?php
use Migrations\AbstractMigration;

class KitColour extends AbstractMigration
{

    public function up()
    {
        $this->table('items')
            ->addColumn('colours', 'string', [
                'after' => 'sizes',
                'default' => null,
                'length' => 255,
                'null' => true,
            ])
            ->update();

        $this->table('items_orders')
            ->addColumn('colour', 'string', [
                'after' => 'size',
                'default' => null,
                'length' => 255,
                'null' => true,
            ])
            ->update();

    }

    public function down()
    {
        $this->table('items')
            ->removeColumn('colours')
            ->update();

        $this->table('items_orders')
            ->removeColumn('colour')
            ->update();

    }
}

