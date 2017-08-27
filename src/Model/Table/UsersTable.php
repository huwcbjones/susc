<?php

namespace SUSC\Model\Table;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SUSC\Model\Entity\User;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Articles
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
        $this->belongsTo('Groups')
            ->setJoinType('LEFT')
            ->setForeignKey('gid');
        $this->setDisplayField('email');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Articles', [
            'foreignKey' => 'user_id'
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
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        $validator
            ->requirePresence('email_address', 'create')
            ->notEmpty('email_address');

        $validator
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');

        $validator
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name');

        $validator
            ->dateTime('activation_date')
            ->requirePresence('activation_date', 'create')
            ->notEmpty('activation_date');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->boolean('is_active')
            ->requirePresence('is_active', 'create')
            ->notEmpty('is_active');

        $validator
            ->boolean('is_enable')
            ->requirePresence('is_enable', 'create')
            ->notEmpty('is_enable');

        $validator
            ->boolean('change_password')
            ->requirePresence('change_password', 'create')
            ->notEmpty('change_password');

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

    public function findActive(Query $query)
    {
        return $query->where(['is_enable' => true, 'is_active' => true]);
    }

    public function findId(Query $query, array $options = [])
    {
        return $query->where(['id' => $options['id']]);
    }

    public function findUsername(Query $query, array $options = [])
    {
        return $query->where(['username' => $options['username']]);
    }

    public function findEmail(Query $query, array $options = [])
    {
        return $query->where(['email_address' => $options['email']]);
    }

    public function validationChangePassword(Validator $validator)
    {

        $validator
            ->add('old_password', 'custom', [
                'rule' => function ($value, $context) {
                    $user = $this->get($context['data']['id']);
                    if ($user) {
                        if ((new DefaultPasswordHasher)->check($value, $user->password)) {
                            return true;
                        }
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
                        if ((new DefaultPasswordHasher)->check($value, $user->password)) {
                            return true;
                        }
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
