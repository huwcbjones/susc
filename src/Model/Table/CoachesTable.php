<?php
namespace SUSC\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Coaches Model
 *
 * @method \SUSC\Model\Entity\Coach get($primaryKey, $options = [])
 * @method \SUSC\Model\Entity\Coach newEntity($data = null, array $options = [])
 * @method \SUSC\Model\Entity\Coach[] newEntities(array $data, array $options = [])
 * @method \SUSC\Model\Entity\Coach|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SUSC\Model\Entity\Coach patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SUSC\Model\Entity\Coach[] patchEntities($entities, array $data, array $options = [])
 * @method \SUSC\Model\Entity\Coach findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CoachesTable extends Table
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

        $this->setTable('coaches');
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
            ->integer('display_order')
            ->requirePresence('display_order', 'create')
            ->notEmpty('display_order');

        $validator
            ->requirePresence('bio', 'create')
            ->notEmpty('bio');

        $validator
            ->allowEmpty('contact');

        $validator
            ->requirePresence('image', 'create')
            ->notEmpty('image');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }

    public function findPublished(Query $query)
    {
        return $query->where(['status' => true]);
    }
}
