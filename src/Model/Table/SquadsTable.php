<?php
namespace SUSC\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Squads Model
 *
 * @property \SUSC\Model\Table\BunfightSignupsTable|\Cake\ORM\Association\BelongsToMany $BunfightSignups
 *
 * @method \SUSC\Model\Entity\Squad get($primaryKey, $options = [])
 * @method \SUSC\Model\Entity\Squad newEntity($data = null, array $options = [])
 * @method \SUSC\Model\Entity\Squad[] newEntities(array $data, array $options = [])
 * @method \SUSC\Model\Entity\Squad|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SUSC\Model\Entity\Squad patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SUSC\Model\Entity\Squad[] patchEntities($entities, array $data, array $options = [])
 * @method \SUSC\Model\Entity\Squad findOrCreate($search, callable $callback = null, $options = [])
 */
class SquadsTable extends Table
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

        $this->setTable('squads');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('BunfightSignups', [
            'foreignKey' => 'squad_id'
        ]);
        $this->hasMany('TrainingSessions', [
            'foreignKey' => 'squad_id'
        ]);
        $this->belongsToMany('BunfightSignups', [
            'foreignKey' => 'squad_id',
            'targetForeignKey' => 'bunfight_signup_id',
            'joinTable' => 'bunfight_signups_squads'
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmpty('name');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->allowEmpty('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('description')
            ->allowEmpty('description');

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
        $rules->add($rules->isUnique(['slug']));

        return $rules;
    }
}
