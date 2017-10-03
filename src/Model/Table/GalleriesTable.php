<?php
namespace SUSC\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SUSC\Model\Entity\Gallery;

/**
 * Galleries Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Images
 * @property
 *
 * @method Gallery get($primaryKey, $options = [])
 * @method Gallery newEntity($data = null, array $options = [])
 * @method Gallery[] newEntities(array $data, array $options = [])
 * @method Gallery|bool save(EntityInterface $entity, $options = [])
 * @method Gallery patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Gallery[] patchEntities($entities, array $data, array $options = [])
 * @method Gallery findOrCreate($search, callable $callback = null, $options = [])
 *
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GalleriesTable extends Table
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

        $this->setTable('galleries');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ThumbnailImage', [
            'className' => 'images',
            'foreignKey' => 'thumbnail_id'
        ]);
        $this->belongsToMany('Images', [
            'foreignKey' => 'gallery_id',
            'targetForeignKey' => 'image_id',
            'joinTable' => 'galleries_images',
            'sort' => ['display' => 'ASC']
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
            ->boolean('status')
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
        $rules->add($rules->existsIn(['thumbnail_id'], 'Images'));

        return $rules;
    }

    public function find($type = 'all', $options = [])
    {
        return parent::find($type, $options)->contain(['Images']);
    }

    public function findHome(Query $query, $options = [])
    {
        return $query->where(['id' => 'a59b681c-f393-11e6-bffe-0050569388dc']);
    }

    public function findGallery(Query $query, $options = [])
    {
        return $query
            ->contain(['Images'])
            ->contain(['ThumbnailImage'])
            ->where(['`Galleries`.`id` !=' => 'a59b681c-f393-11e6-bffe-0050569388dc', ['Galleries.status' => 1]])
            ->order(['`Galleries`.`created`' => 'ASC']);
    }

    public function findPublished(Query $query)
    {
        return $query->where(['`Galleries`.`status`' => true]);
    }
}
