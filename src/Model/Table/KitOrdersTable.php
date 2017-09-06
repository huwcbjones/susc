<?php

namespace SUSC\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SUSC\Model\Entity\KitOrder;

/**
 * KitOrders Model
 *
 * @property UsersTable|BelongsTo $Users
 * @property KitItemsOrdersTable|BelongsTo $KitItemsOrders
 *
 * @method KitOrder get($primaryKey, $options = [])
 * @method KitOrder newEntity($data = null, array $options = [])
 * @method KitOrder[] newEntities(array $data, array $options = [])
 * @method KitOrder|bool save(EntityInterface $entity, $options = [])
 * @method KitOrder patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method KitOrder[] patchEntities($entities, array $data, array $options = [])
 * @method KitOrder findOrCreate($search, callable $callback = null, $options = [])
 */
class KitOrdersTable extends Table
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

        $this->setTable('kit_orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsToMany('KitItems', [
            'through' => 'KitItemsOrders'
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

    public function findUser(Query $query, array $options = [])
    {
        return $query->where(['user_id' => $options['user_id']]);
    }
}
