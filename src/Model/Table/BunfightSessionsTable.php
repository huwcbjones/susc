<?php
namespace SUSC\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BunfightSessions Model
 *
 * @property \SUSC\Model\Table\BunfightsTable|\Cake\ORM\Association\BelongsTo $Bunfights
 * @property \SUSC\Model\Table\BunfightSignupsTable|\Cake\ORM\Association\HasMany $BunfightSignups
 *
 * @method \SUSC\Model\Entity\BunfightSession get($primaryKey, $options = [])
 * @method \SUSC\Model\Entity\BunfightSession newEntity($data = null, array $options = [])
 * @method \SUSC\Model\Entity\BunfightSession[] newEntities(array $data, array $options = [])
 * @method \SUSC\Model\Entity\BunfightSession|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SUSC\Model\Entity\BunfightSession patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SUSC\Model\Entity\BunfightSession[] patchEntities($entities, array $data, array $options = [])
 * @method \SUSC\Model\Entity\BunfightSession findOrCreate($search, callable $callback = null, $options = [])
 */
class BunfightSessionsTable extends Table
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

        $this->setTable('bunfight_sessions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Bunfights', [
            'foreignKey' => 'bunfight_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('BunfightSignups', [
            'foreignKey' => 'bunfight_session_id'
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
            ->dateTime('start')
            ->allowEmpty('start');

        $validator
            ->dateTime('finish')
            ->allowEmpty('finish');

        $validator
            ->integer('capacity')
            ->allowEmpty('capacity');

        $validator
            ->integer('oversubscribe_percentage')
            ->allowEmpty('oversubscribe_percentage');

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
        $rules->add($rules->existsIn(['bunfight_id'], 'Bunfights'));

        return $rules;
    }

    public function findBunfight(Query $query, $options=[]){
        return $query->where(['bunfight_id' => $options['bunfight_id']]);
    }
}
