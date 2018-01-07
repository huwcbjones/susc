<?php
use Migrations\AbstractMigration;

class KitItemsExtras extends AbstractMigration
{

    public function up()
    {

        $this->table('items')
            ->removeIndexByName('kit_items_slug_uindex')
            ->update();

        $this->table('items')
            ->changeColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->changeColumn('slug', 'string', [
                'default' => null,
                'limit' => 190,
                'null' => true,
            ])
            ->changeColumn('image', 'integer', [
                'default' => '0',
                'limit' => 4,
                'null' => false,
            ])
            ->changeColumn('status', 'boolean', [
                'default' => '0',
                'limit' => null,
                'null' => true,
            ])
            ->changeColumn('additional_info', 'boolean', [
                'default' => '0',
                'limit' => null,
                'null' => true,
            ])
            ->changeColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->changeColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->update();
        $this->table('items_orders')
            ->dropForeignKey([], 'items_orders_processed_orders_id_fk')
            ->dropForeignKey([], 'kit_items_orders_kit_items_id_fk')
            ->dropForeignKey([], 'kit_items_orders_kit_orders_id_fk')
            ->removeIndexByName('items_orders_processed_order_index')
            ->removeIndexByName('kit_items_orders_kit_id_index')
            ->removeIndexByName('kit_items_orders_order_id_index')
            ->update();

        $this->table('items_orders')
            ->changeColumn('order_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->changeColumn('item_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->changeColumn('size', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->changeColumn('quantity', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->changeColumn('price', 'decimal', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->changeColumn('subtotal', 'decimal', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->update();
        $this->table('orders')
            ->dropForeignKey([], 'kit_orders_users_id_fk')
            ->removeIndexByName('user_id')
            ->update();

        $this->table('orders')
            ->changeColumn('id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->changeColumn('user_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->changeColumn('placed', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->changeColumn('is_cancelled', 'boolean', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->update();
        $this->table('processed_orders')
            ->dropForeignKey([], 'processed_orders_users_id_fk')
            ->update();
       ;

        $this->table('items')
            ->addColumn('instock', 'boolean', [
                'after' => 'sizes',
                'default' => '1',
                'length' => null,
                'null' => true,
            ])
            ->addColumn('UNTIL', 'datetime', [
                'after' => 'additional_info_description',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->addColumn('FROM', 'datetime', [
                'after' => 'modified',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->update();

        $this->table('items_orders')
            ->addIndex(
                [
                    'item_id',
                ],
                [
                    'name' => 'items_orders_item_id_index',
                ]
            )
            ->addIndex(
                [
                    'order_id',
                ],
                [
                    'name' => 'items_orders_order_id_index',
                ]
            )
            ->addIndex(
                [
                    'processed_order_id',
                ],
                [
                    'name' => 'items_orders_processed_order_id_index',
                ]
            )
            ->update();

        $this->table('orders')
            ->addIndex(
                [
                    'user_id',
                ],
                [
                    'name' => 'orders_user_id_index',
                ]
            )
            ->update();

        $this->table('items_orders')
            ->addForeignKey(
                'item_id',
                'items',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->addForeignKey(
                'order_id',
                'orders',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'processed_order_id',
                'processed_orders',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('processed_orders')
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

    public function down()
    {

        $this->table('items_orders')
            ->dropForeignKey(
                'item_id'
            )
            ->dropForeignKey(
                'order_id'
            )
            ->dropForeignKey(
                'processed_order_id'
            );

        $this->table('processed_orders')
            ->dropForeignKey(
                'user_id'
            );


        $this->table('items')
            ->changeColumn('title', 'string', [
                'default' => null,
                'length' => 255,
                'null' => false,
            ])
            ->changeColumn('slug', 'string', [
                'default' => null,
                'length' => 190,
                'null' => false,
            ])
            ->changeColumn('image', 'boolean', [
                'default' => '0',
                'length' => null,
                'null' => false,
            ])
            ->changeColumn('status', 'boolean', [
                'default' => '0',
                'length' => null,
                'null' => false,
            ])
            ->changeColumn('additional_info', 'integer', [
                'default' => '0',
                'length' => 4,
                'null' => false,
            ])
            ->changeColumn('created', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'length' => null,
                'null' => false,
            ])
            ->changeColumn('modified', 'timestamp', [
                'default' => '0000-00-00 00:00:00',
                'length' => null,
                'null' => false,
            ])
             ->removeColumn('instock')
            ->removeColumn('UNTIL')
            ->removeColumn('FROM')
            ->addIndex(
                [
                    'slug',
                ],
                [
                    'name' => 'kit_items_slug_uindex',
                    'unique' => true,
                ]
            )
            ->update();

        $this->table('items_orders')
            ->removeIndexByName('items_orders_item_id_index')
            ->removeIndexByName('items_orders_order_id_index')
            ->removeIndexByName('items_orders_processed_order_id_index')
            ->update();

        $this->table('items_orders')
            ->changeColumn('order_id', 'biginteger', [
                'default' => null,
                'length' => 20,
                'null' => false,
            ])
            ->changeColumn('item_id', 'uuid', [
                'default' => null,
                'length' => null,
                'null' => false,
            ])
            ->changeColumn('size', 'string', [
                'default' => null,
                'length' => 255,
                'null' => false,
            ])
            ->changeColumn('quantity', 'integer', [
                'default' => null,
                'length' => 11,
                'null' => false,
            ])
            ->changeColumn('price', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->changeColumn('subtotal', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addIndex(
                [
                    'processed_order_id',
                ],
                [
                    'name' => 'items_orders_processed_order_index',
                ]
            )
            ->addIndex(
                [
                    'item_id',
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


        $this->table('orders')
            ->removeIndexByName('orders_user_id_index')
            ->update();

        $this->table('orders')
            ->changeColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'length' => 20,
                'null' => false,
            ])
            ->changeColumn('user_id', 'uuid', [
                'default' => null,
                'length' => null,
                'null' => false,
            ])
            ->changeColumn('placed', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'length' => null,
                'null' => false,
            ])
            ->changeColumn('is_cancelled', 'boolean', [
                'default' => '0',
                'length' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_id',
                ],
                [
                    'name' => 'user_id',
                ]
            )
            ->update();



        $this->table('orders')
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

        $this->table('processed_orders')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'SET_NULL'
                ]
            )
            ->update();
    }
}

