<?php
namespace SUSC\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SUSC\Model\Entity\StaticContent;

/**
 * Static Model
 *
 * @method StaticContent get($primaryKey, $options = [])
 * @method StaticContent newEntity($data = null, array $options = [])
 * @method StaticContent[] newEntities(array $data, array $options = [])
 * @method StaticContent|bool save(EntityInterface $entity, $options = [])
 * @method StaticContent patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method StaticContent[] patchEntities($entities, array $data, array $options = [])
 * @method StaticContent findOrCreate($search, callable $callback = null, $options = [])
 */
class StaticContentTable extends Table
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

        $this->setTable('static_content');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->requirePresence('key', 'create')
            ->notEmpty('key')
            ->add('key', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('value', 'create')
            ->notEmpty('value');

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
        $rules->add($rules->isUnique(['key']));

        return $rules;
    }

    public function findKey(Query $query, $options = []){
        return $query->where(['key' => $options['key']]);
    }

    public function findClub(Query $query){
        return $query->where(['key' => 'about_club'])->limit(1);
    }

    public function findContact(Query $query){
        return $query->where(['key' => 'contact_us'])->limit(1);
    }

    public function findTraining(Query $query, $options){
        return $query->where(['key' => 'training_' . $options['section']])->limit(1);
    }

    public function findFixtures(Query $query){
        return $query->where(['key' => 'fixtures'])->limit(1);
    }

    public function findKitTerms(Query $query){
        return $query->where(['key' => 'kit_terms'])->limit(1);
    }
}
