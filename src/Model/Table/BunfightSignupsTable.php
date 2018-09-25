<?php
namespace SUSC\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SUSC\Model\Entity\BunfightSignup;

/**
 * BunfightSignups Model
 *
 * @property BunfightsTable|BelongsTo $Bunfights
 * @property BunfightSessionsTable|BelongsTo $BunfightSessions
 * @property SquadsTable|BelongsToMany $Squads
 *
 * @method BunfightSignup get($primaryKey, $options = [])
 * @method BunfightSignup newEntity($data = null, array $options = [])
 * @method BunfightSignup[] newEntities(array $data, array $options = [])
 * @method BunfightSignup|bool save(EntityInterface $entity, $options = [])
 * @method BunfightSignup patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method BunfightSignup[] patchEntities($entities, array $data, array $options = [])
 * @method BunfightSignup findOrCreate($search, callable $callback = null, $options = [])
 */
class BunfightSignupsTable extends Table
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

        $this->setTable('bunfight_signups');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Bunfights', [
            'foreignKey' => 'bunfight_id'
        ]);
        $this->belongsTo('BunfightSessions', [
            'foreignKey' => 'bunfight_session_id'
        ]);
        $this->belongsToMany('Squads', [
            'foreignKey' => 'bunfight_signup_id',
            'targetForeignKey' => 'squad_id',
            'joinTable' => 'bunfight_signups_squads'
        ]);


        $this->addBehavior('CounterCache', [
            'BunfightSessions' => ['signups_count']
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
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name');

        $validator
            ->scalar('email_address')
            ->maxLength('email_address', 255)
            ->requirePresence('email_address', 'create')
            ->notEmpty('email_address');

        $validator
            ->integer('graduation_year')
            ->allowEmpty('graduation_year');

        $validator
            ->boolean('consent_to_emails')
            ->allowEmpty('consent_to_emails');

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
        $rules->add($rules->existsIn(['squad_id'], 'Squads'));
        $rules->add($rules->existsIn(['bunfight_id'], 'Bunfights'));
        $rules->add($rules->existsIn(['bunfight_session_id'], 'BunfightSessions'));

        return $rules;
    }

    public function findSignup(Query $query, $options=[]){
        return $query->where([
            "email_address" => $options["email"],
            "bunfight_id" => $options["bunfight"]
        ]);
    }

}
