<?php
namespace SUSC\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
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
            //->setAlias('GroupParent')
            ->setForeignKey('parent')
            ->setProperty('parent_id');

        $this->belongsToMany('Acls', [
            'foreignKey' => 'group_id',
            'targetForeignKey' => 'acl_id',
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

        return $validator;
    }

    public function find($type = 'all', $options = [])
    {
        return parent::find($type, $options)->contain(['Acls']);
    }
}
