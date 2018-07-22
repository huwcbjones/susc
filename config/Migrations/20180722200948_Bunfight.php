<?php

use Migrations\AbstractMigration;

class Bunfight extends AbstractMigration
{

    public function up()
    {

        $this->table('bunfight_sessions', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('start', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('finish', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('capacity', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('oversubscribe_percentage', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('signups_count', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('bunfight_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'bunfight_id',
                ]
            )
            ->create();

        $this->table('bunfight_signups', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('first_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('last_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('email_address', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('graduation_year', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('bunfight_session_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('consent_to_emails', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'bunfight_session_id',
                ]
            )
            ->create();

        $this->table('bunfight_signups_squads', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('bunfight_signup_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('squad_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'bunfight_signup_id',
                ]
            )
            ->addIndex(
                [
                    'squad_id',
                ]
            )
            ->create();

        $this->table('bunfights', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('email_template', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('squads', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'slug',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('training_sessions', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('squad_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('day', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('start', 'time', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('finish', 'time', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('location', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('notes', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'squad_id',
                ]
            )
            ->create();

        $this->table('bunfight_sessions')
            ->addForeignKey(
                'bunfight_id',
                'bunfights',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->update();

        $this->table('bunfight_signups')
            ->addForeignKey(
                'bunfight_session_id',
                'bunfight_sessions',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->update();

        $this->table('bunfight_signups_squads')
            ->addForeignKey(
                'bunfight_signup_id',
                'bunfight_signups',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->addForeignKey(
                'squad_id',
                'squads',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->update();

        $this->table('training_sessions')
            ->addForeignKey(
                'squad_id',
                'squads',
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
        $this->table('bunfight_sessions')
            ->dropForeignKey(
                'bunfight_id'
            );

        $this->table('bunfight_signups')
            ->dropForeignKey(
                'bunfight_session_id'
            );

        $this->table('bunfight_signups_squads')
            ->dropForeignKey(
                'bunfight_signup_id'
            )
            ->dropForeignKey(
                'squad_id'
            );

        $this->table('training_sessions')
            ->dropForeignKey(
                'squad_id'
            );

        $this->dropTable('bunfight_sessions');

        $this->dropTable('bunfight_signups');

        $this->dropTable('bunfight_signups_squads');

        $this->dropTable('bunfights');

        $this->dropTable('squads');

        $this->dropTable('training_sessions');
    }
}

