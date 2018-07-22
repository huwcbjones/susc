<?php
namespace SUSC\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TrainingSessions Model
 *
 * @property \SUSC\Model\Table\SquadsTable|\Cake\ORM\Association\BelongsTo $Squads
 *
 * @method \SUSC\Model\Entity\TrainingSession get($primaryKey, $options = [])
 * @method \SUSC\Model\Entity\TrainingSession newEntity($data = null, array $options = [])
 * @method \SUSC\Model\Entity\TrainingSession[] newEntities(array $data, array $options = [])
 * @method \SUSC\Model\Entity\TrainingSession|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SUSC\Model\Entity\TrainingSession patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SUSC\Model\Entity\TrainingSession[] patchEntities($entities, array $data, array $options = [])
 * @method \SUSC\Model\Entity\TrainingSession findOrCreate($search, callable $callback = null, $options = [])
 */
class TrainingSessionsTable extends Table
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

        $this->setTable('training_sessions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Squads', [
            'foreignKey' => 'squads_id',
            'joinType' => 'INNER'
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
            ->scalar('day')
            ->maxLength('day', 8)
            ->allowEmpty('day');

        $validator
            ->time('start')
            ->requirePresence('start', 'create')
            ->notEmpty('start');

        $validator
            ->time('finish')
            ->requirePresence('finish', 'create')
            ->notEmpty('finish');

        $validator
            ->scalar('location')
            ->maxLength('location', 255)
            ->requirePresence('location', 'create')
            ->notEmpty('location');

        $validator
            ->scalar('notes')
            ->allowEmpty('notes');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['squads_id'], 'Squads'));

        return $rules;
    }
}
