<?php
namespace SUSC\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SUSC\Model\Entity\KitItemsOrder;

/**
 * KitItemsOrders Model
 *
 * @property KitOrdersTable|BelongsTo $KitOrders
 * @property KitItemsTable|BelongsTo $KitItems
 *
 * @method KitItemsOrder get($primaryKey, $options = [])
 * @method KitItemsOrder newEntity($data = null, array $options = [])
 * @method KitItemsOrder[] newEntities(array $data, array $options = [])
 * @method KitItemsOrder|bool save(EntityInterface $entity, $options = [])
 * @method KitItemsOrder patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method KitItemsOrder[] patchEntities($entities, array $data, array $options = [])
 * @method KitItemsOrder findOrCreate($search, callable $callback = null, $options = [])
 */
class KitItemsOrdersTable extends Table
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

        $this->setTable('kit_items_orders');
        $this->setPrimaryKey('id');

        $this->belongsTo('KitOrders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER'
        ])->setBindingKey('id');
        $this->belongsTo('KitItems', [
            'foreignKey' => 'kit_id',
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
            ->requirePresence('size', 'create')
            ->notEmpty('size');

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
        $rules->add($rules->existsIn(['order_id'], 'KitOrders'));
        $rules->add($rules->existsIn(['kit_id'], 'KitItems'));

        return $rules;
    }
}
