<?php
namespace SUSC\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bunfights Model
 *
 * @property \SUSC\Model\Table\BunfightSessionsTable|\Cake\ORM\Association\HasMany $BunfightSessions
 *
 * @method \SUSC\Model\Entity\Bunfight get($primaryKey, $options = [])
 * @method \SUSC\Model\Entity\Bunfight newEntity($data = null, array $options = [])
 * @method \SUSC\Model\Entity\Bunfight[] newEntities(array $data, array $options = [])
 * @method \SUSC\Model\Entity\Bunfight|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SUSC\Model\Entity\Bunfight patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SUSC\Model\Entity\Bunfight[] patchEntities($entities, array $data, array $options = [])
 * @method \SUSC\Model\Entity\Bunfight findOrCreate($search, callable $callback = null, $options = [])
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
