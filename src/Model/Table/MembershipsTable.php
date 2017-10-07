<?php
namespace SUSC\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Memberships Model
 *
 * @property \SUSC\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \SUSC\Model\Table\MembershipTypesTable|\Cake\ORM\Association\BelongsTo $MembershipTypes
 *
 * @method \SUSC\Model\Entity\Membership get($primaryKey, $options = [])
 * @method \SUSC\Model\Entity\Membership newEntity($data = null, array $options = [])
 * @method \SUSC\Model\Entity\Membership[] newEntities(array $data, array $options = [])
 * @method \SUSC\Model\Entity\Membership|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SUSC\Model\Entity\Membership patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SUSC\Model\Entity\Membership[] patchEntities($entities, array $data, array $options = [])
 * @method \SUSC\Model\Entity\Membership findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MembershipsTable extends Table
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

        $this->setTable('memberships');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('MembershipTypes', [
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
            ->allowEmpty('name');

        $validator
            ->date('date_of_birth')
            ->allowEmpty('date_of_birth');

        $validator
            ->dateTime('paid')
            ->allowEmpty('paid');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['membership_type_id'], 'MembershipTypes'));

        return $rules;
    }
}