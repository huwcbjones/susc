<?php

namespace SUSC\Model\Table;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SUSC\Model\Entity\User;

/**
 * Users Model
 *
 * @property ArticlesTable|HasMany $Articles
 * @property GroupsTable|BelongsTo $Group
 * @property |\Cake\ORM\Association\HasMany $KitCompletedOrders
 * @property |\Cake\ORM\Association\HasMany $KitOrders
 * @property AclsTable|BelongsToMany $Acls
 *
 * @method User get($primaryKey, $options = [])
 * @method User newEntity($data = null, array $options = [])
 * @method User[] newEntities(array $data, array $options = [])
 * @method User|bool save(EntityInterface $entity, $options = [])
 * @method User patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method User[] patchEntities($entities, array $data, array $options = [])
 * @method User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('email');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Articles', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('KitCompletedOrders', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('KitOrders', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Groups')
            ->setForeignKey('group_id')
            ->setJoinType('INNER');

        $this->belongsToMany('Acls', ['joinTable' => 'users_acls',])
            ->setForeignKey('user_id')
            ->setTargetForeignKey('acl_id');
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
            ->uuid('group_id')
            ->requirePresence('group_id', 'create')
            ->notEmpty('group_id');

        $validator
            ->requirePresence('email_address', 'create')
            ->notEmpty('email_address')
            ->add('email_address', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');

        $validator
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name');

        $validator
            ->dateTime('activation_date')
            ->allowEmpty('activation_date', 'create');

        $validator
            ->notEmpty('password');

        $validator
            ->allowEmpty('activation_code');

        $validator
            ->boolean('is_enable')
            ->allowEmpty('is_enable', 'create');

        $validator
            ->boolean('is_change_password')
            ->allowEmpty('is_change_password');

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
        $rules->add($rules->isUnique(['email_address']));

        // Add Validation rules to Application rules
        $rules->add(function ($entity) {
            /** @var EntityInterface $entity */
            $data = $entity->extract($this->getSchema()->columns(), true);
            $validator = $this->validator('default');
            $errors = $validator->errors($data, $entity->isNew());
            $entity->errors($errors);

            return empty($errors);
        });

        return $rules;
    }

    public function find($type = 'all', $options = [])
    {
        return parent::find($type, $options)->contain(['Groups', 'Acls']);
    }

    public function findActive(Query $query)
    {
        return $query->where(['is_enable' => true, 'activation_code IS' => null]);
    }

    public function findId(Query $query, array $options = [])
    {
        return $query->where(['id' => $options['id']]);
    }


    public function findEmail(Query $query, array $options = [])
    {
        return $query->where(['email_address' => $options['email_address']]);
    }

    public function findActivationCode(Query $query, array $options = [])
    {
        return $query->where(['activation_code' => $options['activation_code']]);
    }

    public function findPasswordReset(Query $query, array $options = [])
    {
        return $query->where(['reset_code' => $options['reset_code']]);
    }


    public function validationChangePassword(Validator $validator)
    {

        $validator
            ->add('old_password', 'custom', [
                'rule' => function ($value, $context) {
                    $user = $this->get($context['data']['id']);
                    if ($user) {
                        return (new DefaultPasswordHasher)->check($value, $user->password);
                    }
                    return false;
                },
                'message' => 'Old password was incorrect.',
            ])
            ->notEmpty('old_password');

        $validator
            ->add('new_password', [
                'length' => [
                    'rule' => ['minLength', 6],
                    'message' => 'Passwords have to be at least 6 characters.',
                ]
            ])
            ->notEmpty('password');
        $validator
            ->add('conf_password', [
                'match' => [
                    'rule' => ['compareWith', 'new_password'],
                    'message' => 'Passwords do not match!',
                ]
            ]);

        return $validator;
    }

    public function validationChangeEmail(Validator $validator)
    {

        $validator
            ->add('password', 'custom', [
                'rule' => function ($value, $context) {
                    $user = $this->get($context['data']['id']);
                    if ($user) {
                        return (new DefaultPasswordHasher)->check($value, $user->password);
                    }
                    return false;
                },
                'message' => 'Password was incorrect.',
            ])
            ->notEmpty('password');

        $validator
            ->add('new_email_address', 'same-email', [
                'rule' => function ($value, $context) {
                    $user = $this->get($context['data']['id']);
                    if ($user) {
                        return $user->email_address != $value;
                    }
                    return false;
                },
                'message' => 'New email address is the same as the current email address.',
            ])
            ->add('new_email_address', 'valid-email', ['rule' => 'email'])
            ->notEmpty('email');
        $validator
            ->add('conf_email_address', [
                'match' => [
                    'rule' => ['compareWith', 'new_email_address'],
                    'message' => 'Email addresses do not match!',
                ]
            ]);

        return $validator;
    }
}
