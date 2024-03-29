<?php

namespace SUSC\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SUSC\Model\Entity\Item;

/**
 * KitItems Model
 *
 * @method Item get($primaryKey, $options = [])
 * @method Item newEntity($data = null, array $options = [])
 * @method Item[] newEntities(array $data, array $options = [])
 * @method Item|bool save(EntityInterface $entity, $options = [])
 * @method Item patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Item[] patchEntities($entities, array $data, array $options = [])
 * @method Item findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ItemsTable extends Table
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

        $this->setTable('items');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('ItemsOrders', [
            'joinType' => 'LEFT'
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
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->requirePresence('slug', 'create')
            ->notEmpty('slug');

        $validator
            ->allowEmpty('image');

        $validator
            ->decimal('price')
            ->allowEmpty('price');

        $validator
            ->allowEmpty('description');

        $validator
            ->allowEmpty('sizes');

        $validator
            ->boolean('status')
            ->allowEmpty('status');

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
        return $rules;
    }

    public function find($type = 'all', $options = [])
    {
        $options['order']['title'] = 'ASC';
        return parent::find($type, $options);
    }

    public function findPublished(Query $query)
    {
        return $query->where([
            'status' => 1
        ]);
    }

    public function findSlug(Query $query, $options = [])
    {
        if(preg_match('/[a-f0-9]+/', $options['crc'])){
            $options['crc'] = hexdec($options['crc']);
        }
        return $query->where([
            '`slug` LIKE ' => '%' . $options['slug'] . '%',
            'CRC32(`id`)' => $options['crc']
        ]);
    }

    public function findId(Query $query, $options = [])
    {
        return $query->where(['id' => $options['id']]);
    }

    public function findUnprocessed(Query $query, $options = [])
    {
        return $query
            ->matching('Orders', function (Query $q) {
                return $q
                    ->where(['ItemsOrders.ordered IS NULL'])
                    ->where(['Orders.paid IS NOT NULL']);
            });
    }
}
