<?php

use Migrations\AbstractMigration;

class Kit extends AbstractMigration
{

    public function up()
    {
        $this->table('kit_items_orders')
            ->dropForeignKey([], 'primary')
            ->dropForeignKey([], 'kit_items_orders_kit_orders_id_fk')
            ->dropForeignKey([], ' kit_items_orders___fk')
            ->removeIndexByName('kit_id')
            ->update();
        $this->table('kit_orders')
            ->dropForeignKey([], 'kit_orders_ibfk_1')
            ->update();

        $this->table('kit_orders')
            ->removeColumn('order_time')
            ->changeColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->update();

        $this->table('kit_items')
            ->changeColumn('status', 'boolean', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->update();

        $this->table('kit_items_orders')
            ->addColumn('id', 'uuid', [
                'default' => null,
                'length' => null,
                'null' => false,
            ])
            ->addColumn('additional_info', 'string', [
                'after' => 'quantity',
                'default' => null,
                'length' => 255,
                'null' => true,
            ])
            ->addColumn('price', 'decimal', [
                'after' => 'additional_info',
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('subtotal', 'decimal', [
                'after' => 'price',
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('collected', 'datetime', [
                'after' => 'subtotal',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'kit_id',
                ],
                [
                    'name' => 'kit_items_orders_kit_id_index',
                ]
            )
            ->addIndex(
                [
                    'order_id',
                ],
                [
                    'name' => 'kit_items_orders_order_id_index',
                ]
            )
            ->update();

        $this->table('kit_orders')
            ->addColumn('payment', 'string', [
                'after' => 'user_id',
                'default' => null,
                'length' => 10,
                'null' => true,
            ])
            ->addColumn('total', 'decimal', [
                'after' => 'payment',
                'default' => null,
                'null' => true,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('date_ordered', 'timestamp', [
                'after' => 'total',
                'default' => 'CURRENT_TIMESTAMP',
                'length' => null,
                'null' => false,
            ])
            ->addColumn('paid_date', 'datetime', [
                'after' => 'date_ordered',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->addColumn('is_paid', 'boolean', [
                'after' => 'paid_date',
                'default' => '0',
                'length' => null,
                'null' => true,
            ])
            ->update();

        $this->table('kit_items')
            ->addColumn('additional_info', 'integer', [
                'after' => 'status',
                'default' => '0',
                'length' => 4,
                'null' => false,
            ])
            ->addColumn('additional_info_description', 'text', [
                'after' => 'additional_info',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->update();

        $this->table('kit_items_orders')
            ->addForeignKey(
                'kit_id',
                'kit_items',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->addForeignKey(
                'id',
                '',
                '',
                [
                    'update' => '',
                    'delete' => ''
                ]
            )
            ->addForeignKey(
                'order_id',
                'kit_orders',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('kit_orders')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->update();

        $this->dropTable('kit_completed_items_orders');

        $this->dropTable('kit_completed_orders');
    }

    public function down()
    {
        $this->table('kit_items_orders')
            ->dropForeignKey(
                'kit_id'
            )
            ->dropForeignKey(
                'id'
            )
            ->dropForeignKey(
                'order_id'
            );

        $this->table('kit_orders')
            ->dropForeignKey(
                'user_id'
            );

        $this->table('kit_completed_items_orders', ['id' => false, 'primary_key' => ['order_id', 'kit_id']])
            ->addColumn('order_id', 'biginteger', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('kit_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('size', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('quantity', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('price', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('subtotal', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('collected', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'kit_id',
                ]
            )
            ->addIndex(
                [
                    'order_id',
                ]
            )
            ->create();

        $this->table('kit_completed_orders', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'biginteger', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('user_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('ordered', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('kit_completed_items_orders')
            ->addForeignKey(
                'kit_id',
                'kit_items',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->addForeignKey(
                'order_id',
                'kit_completed_orders',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->update();

        $this->table('kit_completed_orders')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->update();

        $this->table('kit_items_orders')
            ->removeIndexByName('kit_items_orders_kit_id_index')
            ->removeIndexByName('kit_items_orders_order_id_index')
            ->update();

        $this->table('kit_items_orders')
            ->removeColumn('id')
            ->removeColumn('additional_info')
            ->removeColumn('price')
            ->removeColumn('subtotal')
            ->removeColumn('collected')
            ->addIndex(
                [
                    'kit_id',
                ],
                [
                    'name' => 'kit_id',
                ]
            )
            ->update();

        $this->table('kit_orders')
            ->addColumn('order_time', 'timestamp', [
                'after' => 'user_id',
                'default' => 'CURRENT_TIMESTAMP',
                'length' => null,
                'null' => false,
            ])
            ->changeColumn('id', 'biginteger', [
                'default' => null,
                'length' => 20,
                'null' => false,
            ])
            ->removeColumn('payment')
            ->removeColumn('total')
            ->removeColumn('date_ordered')
            ->removeColumn('paid_date')
            ->removeColumn('is_paid')
            ->update();

        $this->table('kit_items')
            ->changeColumn('status', 'string', [
                'default' => 'b\'0\'',
                'length' => null,
                'null' => false,
            ])
            ->removeColumn('additional_info')
            ->removeColumn('additional_info_description')
            ->update();

        $this->table('kit_items_orders')
            ->addForeignKey(
                [
                    'order_id',
                    'kit_id',
                ],
                '',
                '',
                [
                    'update' => '',
                    'delete' => ''
                ]
            )
            ->addForeignKey(
                'order_id',
                'kit_orders',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->addForeignKey(
                'kit_id',
                'kit_items',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->update();

        $this->table('kit_orders')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->update();
    }
}

