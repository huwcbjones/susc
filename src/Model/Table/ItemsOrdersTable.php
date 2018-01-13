<?php

namespace SUSC\Model\Table;

use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SUSC\Model\Entity\ItemsOrder;

/**
 * ItemsOrders Model
 *
 * @property OrdersTable|BelongsTo $Orders
 * @property ItemsTable|BelongsTo $Items
 * @property |\Cake\ORM\Association\BelongsToMany $ProcessedOrders
 *
 * @method ItemsOrder get($primaryKey, $options = [])
 * @method ItemsOrder newEntity($data = null, array $options = [])
 * @method ItemsOrder[] newEntities(array $data, array $options = [])
 * @method ItemsOrder|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method ItemsOrder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method ItemsOrder[] patchEntities($entities, array $data, array $options = [])
 * @method ItemsOrder findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemsOrdersTable extends Table
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

        $this->setTable('items_orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ProcessedOrders', [
            'foreignKey' => 'processed_order_id',
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
            ->requirePresence('size', 'create')
            ->allowEmpty('size');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

        $validator
            ->allowEmpty('additional_info');

        $validator
            ->decimal('price')
            ->requirePresence('price', 'create')
            ->notEmpty('price');

        $validator
            ->decimal('subtotal')
            ->requirePresence('subtotal', 'create')
            ->notEmpty('subtotal');

        $validator
            ->dateTime('collected')
            ->allowEmpty('collected');

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
        $rules->add($rules->existsIn(['order_id'], 'Orders'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));

        return $rules;
    }

    public function find($type = 'all', $options = [])
    {
        return parent::find($type, $options);
    }

    public function findAssoc(Query $query, $options = [])
    {
        return $query->contain(['ItemsOrders']);
    }

    public function findID(Query $query, $options = [])
    {
        return $query
            ->contain(['Items', 'Orders' => ['Users']])
            ->where(['ItemsOrders.id' => $options['id']]);
    }

    public function findItemId(Query $query, $options = [])
    {
        return $query
            ->contain(['Items'])
            ->where(['Items.id' => $options['id']]);
    }

    public function findUnprocessed(Query $query, $options = [])
    {
        if (array_key_exists('itemIDs', $options)) {
            $query = $query->contain('Items')
                ->where([
                    'Items.id IN' => $options['itemIDs']
                ]);
        }
        return $query
            ->contain(['Orders'])
            ->where([
                'Orders.paid IS NOT NULL',
                'processed_order_id IS NULL',
                ['Orders.is_cancelled' => false]
            ]);
    }

    public function findBatch(Query $query, $options = [])
    {
        if (array_key_exists('processed_order_id', $options)) {
            $id = $options['processed_order_id'];
        } else {
            $id = $options['id'];
        }

        return $query
            ->contain(['ProcessedOrders', 'Orders' => 'Users', 'Items'])
            ->where(['processed_order_id' => $id]);
    }

    public function findCollections(Query $query, $options = [])
    {
        $query = $query
            ->contain([
                'Items',
                'Orders' => ['Users'],
                'ProcessedOrders'
            ])
            ->where([
                '`collected` IS ' => null,
                'ProcessedOrders.arrived IS NOT' => null,
                'Orders.is_cancelled' => false
            ]);
        if (array_key_exists('user_id', $options)) {
            $query = $query->where(['Orders.user_id' => $options['user_id']]);
        }

        return $query;
    }
}
