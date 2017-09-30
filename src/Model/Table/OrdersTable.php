<?php

namespace SUSC\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SUSC\Model\Entity\Order;

/**
 * KitOrders Model
 *
 * @property UsersTable|BelongsTo $Users
 * @property ItemsOrdersTable|BelongsTo $KitItemsOrders
 *
 * @method Order get($primaryKey, $options = [])
 * @method Order newEntity($data = null, array $options = [])
 * @method Order[] newEntities(array $data, array $options = [])
 * @method Order|bool save(EntityInterface $entity, $options = [])
 * @method Order patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Order[] patchEntities($entities, array $data, array $options = [])
 * @method Order findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdersTable extends Table
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

        $this->setTable('orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('ItemsOrders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER'
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
            ->allowEmpty('payment');

        $validator
            ->decimal('total')
            ->allowEmpty('total');

        $validator
            ->requirePresence('date_ordered', 'create')
            ->notEmpty('date_ordered');

        $validator
            ->dateTime('paid_date')
            ->allowEmpty('paid_date');

        $validator
            ->boolean('is_paid')
            ->allowEmpty('is_paid');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    public function find($type = 'all', $options = [])
    {
        return parent::find($type, $options);
    }

    public function findUser(Query $query, array $options = [])
    {
        return $query->where(['user_id' => $options['user_id']])->contain(['ItemsOrders' => ['ProcessedOrders', 'Items'], 'Users']);
    }

    public function findID(Query $query, array $options = []){
        return $query->where(['Orders.id' => $options['id']])->contain(['ItemsOrders' => ['ProcessedOrders', 'Items'], 'Users']);
    }
}
