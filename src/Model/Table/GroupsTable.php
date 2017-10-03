<?php
namespace SUSC\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SUSC\Model\Entity\Group;

/**
 * Groups Model
 *
 * @property GroupsTable|BelongsTo $Group
 * @property AclsTable|BelongsToMany $Acls
 *
 * @method Group get($primaryKey, $options = [])
 * @method Group newEntity($data = null, array $options = [])
 * @method Group[] newEntities(array $data, array $options = [])
 * @method Group|bool save(EntityInterface $entity, $options = [])
 * @method Group patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Group[] patchEntities($entities, array $data, array $options = [])
 * @method Group findOrCreate($search, callable $callback = null, $options = [])
 */
class GroupsTable extends Table
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

        $this->setTable('groups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasOne('Groups')
            ->setForeignKey('parent_id');

        $this->hasMany('Users')
            ->setForeignKey('group_id');

        $this->belongsToMany('Acls', [
            'joinTable' => 'groups_acls'
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
            ->boolean('is_enable')
            ->allowEmpty('is_enable', 'create');

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
        $rules->add($rules->isUnique(['name']));

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
        return parent::find($type, $options)->contain(['Acls']);
    }
}
