<?php
namespace SUSC\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProcessedOrders Model
 *
 * @property \SUSC\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \SUSC\Model\Table\ItemsOrdersTable|\Cake\ORM\Association\BelongsToMany $ItemsOrders
 *
 * @method \SUSC\Model\Entity\ProcessedOrder get($primaryKey, $options = [])
 * @method \SUSC\Model\Entity\ProcessedOrder newEntity($data = null, array $options = [])
 * @method \SUSC\Model\Entity\ProcessedOrder[] newEntities(array $data, array $options = [])
 * @method \SUSC\Model\Entity\ProcessedOrder|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SUSC\Model\Entity\ProcessedOrder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SUSC\Model\Entity\ProcessedOrder[] patchEntities($entities, array $data, array $options = [])
 * @method \SUSC\Model\Entity\ProcessedOrder findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProcessedOrdersTable extends Table
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

        $this->setTable('processed_orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('ItemsOrders', [
            'foreignKey' => 'processed_order_id'
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
            ->boolean('is_ordered')
            ->allowEmpty('is_ordered');

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

    public function findAssoc(Query $query, $options = []){
        return $query->contain(['ItemsOrders' => ['Orders' => 'Users', 'Items']]);
    }


}
