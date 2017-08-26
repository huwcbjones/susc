<?php
namespace SUSC\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Committee Model
 *
 * @method \SUSC\Model\Entity\Committee get($primaryKey, $options = [])
 * @method \SUSC\Model\Entity\Committee newEntity($data = null, array $options = [])
 * @method \SUSC\Model\Entity\Committee[] newEntities(array $data, array $options = [])
 * @method \SUSC\Model\Entity\Committee|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SUSC\Model\Entity\Committee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SUSC\Model\Entity\Committee[] patchEntities($entities, array $data, array $options = [])
 * @method \SUSC\Model\Entity\Committee findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CommitteeTable extends Table
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

        $this->setTable('committee');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('position')
            ->requirePresence('position', 'create')
            ->notEmpty('position');

        $validator
            ->requirePresence('role', 'create')
            ->notEmpty('role');

        $validator
            ->requirePresence('image', 'create')
            ->notEmpty('image');

        $validator
            ->boolean('published')
            ->requirePresence('published', 'create')
            ->notEmpty('published');

        return $validator;
    }

    public function findPublished(Query $query)
    {
        return $query->where(['status' => true]);
    }
}
