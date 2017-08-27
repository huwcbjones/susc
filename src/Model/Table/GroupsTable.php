<?php
namespace SUSC\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Groups Model
 *
 * @property \SUSC\Model\Table\AclsTable|\Cake\ORM\Association\BelongsToMany $Acls
 *
 * @method \SUSC\Model\Entity\Group get($primaryKey, $options = [])
 * @method \SUSC\Model\Entity\Group newEntity($data = null, array $options = [])
 * @method \SUSC\Model\Entity\Group[] newEntities(array $data, array $options = [])
 * @method \SUSC\Model\Entity\Group|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SUSC\Model\Entity\Group patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SUSC\Model\Entity\Group[] patchEntities($entities, array $data, array $options = [])
 * @method \SUSC\Model\Entity\Group findOrCreate($search, callable $callback = null, $options = [])
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
}
