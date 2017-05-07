<?php

namespace SUSC\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Kit Model
 *
 * @method \SUSC\Model\Entity\Kit get($primaryKey, $options = [])
 * @method \SUSC\Model\Entity\Kit newEntity($data = null, array $options = [])
 * @method \SUSC\Model\Entity\Kit[] newEntities(array $data, array $options = [])
 * @method \SUSC\Model\Entity\Kit|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SUSC\Model\Entity\Kit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SUSC\Model\Entity\Kit[] patchEntities($entities, array $data, array $options = [])
 * @method \SUSC\Model\Entity\Kit findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class KitTable extends Table
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

        $this->table('kit');
        $this->displayField('title');
        $this->primaryKey('id');

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
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->requirePresence('slug', 'create')
            ->notEmpty('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('image', 'create')
            ->notEmpty('image');

        $validator
            ->decimal('price')
            ->allowEmpty('price');

        $validator
            ->allowEmpty('description');

        $validator
            ->allowEmpty('sizes');

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->isUnique(['slug']));

        return $rules;
    }

    public function findPublished(Query $query)
    {
        return $query->where(['status' => 1]);
    }

    public function findSlug(Query $query, $options = [])
    {
        return $query->where(['slug' => $options['slug']]);
    }

    public function findId(Query $query, $options = [])
    {
        return $query->where(['id' => $options['id']]);
    }
}
