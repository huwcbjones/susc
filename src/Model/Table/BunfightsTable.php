<?php
namespace SUSC\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SUSC\Model\Entity\Bunfight;

/**
 * Bunfights Model
 *
 * @property BunfightSessionsTable|HasMany $BunfightSessions
 * @property BunfightSignupsTable|HasMany $BunfightSignups
 *
 * @method Bunfight get($primaryKey, $options = [])
 * @method Bunfight newEntity($data = null, array $options = [])
 * @method Bunfight[] newEntities(array $data, array $options = [])
 * @method Bunfight|bool save(EntityInterface $entity, $options = [])
 * @method Bunfight patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Bunfight[] patchEntities($entities, array $data, array $options = [])
 * @method Bunfight findOrCreate($search, callable $callback = null, $options = [])
 */
class BunfightsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('bunfights');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('BunfightSessions', [
            'foreignKey' => 'bunfight_id'
        ]);
        $this->hasMany('BunfightSignups', [
            'foreignKey' => 'bunfight_id'
        ]);

        $this->addBehavior('CounterCache', [
            'BunfightSignups' => ['signups_count']
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        return $validator;
    }
}
