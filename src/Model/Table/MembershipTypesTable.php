<?php
namespace SUSC\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MembershipTypes Model
 *
 * @property \SUSC\Model\Table\MembershipsTable|\Cake\ORM\Association\HasMany $Memberships
 *
 * @method \SUSC\Model\Entity\MembershipType get($primaryKey, $options = [])
 * @method \SUSC\Model\Entity\MembershipType newEntity($data = null, array $options = [])
 * @method \SUSC\Model\Entity\MembershipType[] newEntities(array $data, array $options = [])
 * @method \SUSC\Model\Entity\MembershipType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SUSC\Model\Entity\MembershipType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SUSC\Model\Entity\MembershipType[] patchEntities($entities, array $data, array $options = [])
 * @method \SUSC\Model\Entity\MembershipType findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MembershipTypesTable extends Table
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

        $this->setTable('membership_types');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Memberships', [
            'foreignKey' => 'membership_type_id'
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
            ->requirePresence('title');

        $validator
            ->allowEmpty('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->decimal('price')
            ->requirePresence('price');

        $validator
            ->allowEmpty('description');

        $validator
            ->boolean('is_enable')
            ->requirePresence('is_enable', 'create')
            ->notEmpty('is_enable');

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
        $rules->add($rules->isUnique(['slug']));

        return $rules;
    }
}
