<?php
namespace SUSC\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RegistrationCodes Model
 *
 * @property \SUSC\Model\Table\GroupsTable|\Cake\ORM\Association\BelongsTo $Groups
 *
 * @method \SUSC\Model\Entity\RegistrationCode get($primaryKey, $options = [])
 * @method \SUSC\Model\Entity\RegistrationCode newEntity($data = null, array $options = [])
 * @method \SUSC\Model\Entity\RegistrationCode[] newEntities(array $data, array $options = [])
 * @method \SUSC\Model\Entity\RegistrationCode|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SUSC\Model\Entity\RegistrationCode patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SUSC\Model\Entity\RegistrationCode[] patchEntities($entities, array $data, array $options = [])
 * @method \SUSC\Model\Entity\RegistrationCode findOrCreate($search, callable $callback = null, $options = [])
 */
class RegistrationCodesTable extends Table
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

        $this->setTable('registration_codes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id',
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
            ->allowEmpty('id', 'create');

        $validator
            ->dateTime('valid_from')
            ->allowEmpty('valid_from');

        $validator
            ->dateTime('valid_to')
            ->allowEmpty('valid_to');

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
        $rules->add($rules->existsIn(['group_id'], 'Groups'));

        return $rules;
    }

    public function find($type = 'all', $options = [])
    {
        return parent::find($type, $options)->contain(['Groups']);
    }


}
