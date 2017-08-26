<?php
namespace SUSC\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SUSC\Model\Entity\Committee;

/**
 * Committee Model
 *
 * @method Committee get($primaryKey, $options = [])
 * @method Committee newEntity($data = null, array $options = [])
 * @method Committee[] newEntities(array $data, array $options = [])
 * @method Committee|bool save(EntityInterface $entity, $options = [])
 * @method Committee patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Committee[] patchEntities($entities, array $data, array $options = [])
 * @method Committee findOrCreate($search, callable $callback = null, $options = [])
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
