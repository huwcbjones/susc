<?php
namespace SUSC\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Acls Model
 *
 * @property \SUSC\Model\Table\GroupsTable|\Cake\ORM\Association\BelongsToMany $Groups
 * @property \SUSC\Model\Table\UsersTable|\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \SUSC\Model\Entity\Acl get($primaryKey, $options = [])
 * @method \SUSC\Model\Entity\Acl newEntity($data = null, array $options = [])
 * @method \SUSC\Model\Entity\Acl[] newEntities(array $data, array $options = [])
 * @method \SUSC\Model\Entity\Acl|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SUSC\Model\Entity\Acl patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SUSC\Model\Entity\Acl[] patchEntities($entities, array $data, array $options = [])
 * @method \SUSC\Model\Entity\Acl findOrCreate($search, callable $callback = null, $options = [])
 */
class AclsTable extends Table
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

        $this->setTable('acls');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Groups', [
            'foreignKey' => 'acl_id',
            'targetForeignKey' => 'group_id',
            'joinTable' => 'groups_acls'
        ]);
        $this->belongsToMany('Users', [
            'joinTable' => 'users_acls'
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
            ->allowEmpty('description');

        return $validator;
    }
}
