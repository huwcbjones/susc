<?php
/**
 * Author: Huw
 * Since: 30/06/2016
 */

namespace SUSC\Model\Table;

use App\Model\Entity\Article;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Class ArticlesTable
 * @package SUSC\Model\Table
 */
class ArticlesTable extends Table
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

        $this->belongsTo('Users', [
            'joinType' => 'LEFT',
        ]);
        $this->setTable('articles');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
        $this->setEntityClass('App\Model\Entity\Article');

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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->integer('author')
            ->requirePresence('author', 'create')
            ->notEmpty('author');

        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content');

        $validator
            ->dateTime('start')
            ->allowEmpty('start');

        $validator
            ->dateTime('end')
            ->allowEmpty('end');

        $validator
            ->integer('hits')
            ->allowEmpty('hits');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }

    public function findNews(Query $query)
    {
        return $query->where(['category' => 'news']);
    }

    public function find($type = 'all', $options = [])
    {
        return parent::find($type, $options)->contain(['Users']);
    }

    public function findFixtures(Query $query)
    {
        return $query->where(['category' => 'fixtures']);
    }

    public function findSocials(Query $query)
    {
        return $query->where(['category' => 'socials']);
    }

    public function findPublished(Query $query)
    {
        return $query->where(['status' => true]);
    }

    public function findId(Query $query, array $options)
    {
        return $query->where(['id' => $options[0]]);
    }

    public function findYear(Query $query, array $options)
    {
        return $query->where(['YEAR(`Articles`.`created`)' => $options['year']]);
    }

    public function findMonth(Query $query, array $options)
    {
        return $query->where(['MONTH(`Articles`.`created`)' => $options['month']]);
    }

    public function findDay(Query $query, array $options)
    {
        return $query->where(['DAY(`Articles`.`created`)' => $options['day']]);
    }

    public function findArticle(Query $query, array $options)
    {
        return $this->findDate($this->findSlug($query, $options), $options);
    }

    public function findDate(Query $query, array $options)
    {
        if (key_exists('day', $options) && $options['day'] != null) {
            $query = $query->where([
                'DAY(`Articles`.`created`)' => $options['day']
            ]);
        }
        if (key_exists('month', $options) && $options['month'] != null) {
            $query = $query->where([
                'MONTH(`Articles`.`created`)' => $options['month']
            ]);
        }
        if (key_exists('year', $options) && $options['year'] != null) {
            $query = $query->where([
                'YEAR(`Articles`.`created`)' => $options['year']
            ]);
        }
        return $query;
    }

    public function findSlug(Query $query, array $options)
    {
        return $query->where(['slug' => $options['slug']]);
    }

    public function generateHash(Query $query)
    {
        $results = $query->all();
        $hash = '';
        foreach ($results as $result) {
            $hash .= $result->modified;
        }
        return md5($hash);
    }

    public function getLastModified($category = null)
    {
        if($category === null) {
            $query = $this->find('published');
        } else {
            $query = $this->find($category);
        }
        $query = $query->select(['status', 'created', 'modified', 'lastmod' => $query->func()->max('`Articles`.`modified`')]);
        if ($query->count() == 0) return strtotime('1970-01-01 00:00');

        /** @var Article $last_mod */
        $last_mod = $query->first();
        return $last_mod->modified;
    }

    public function getSitemap()
    {
        $query = $this->find('published');
        return $query->select([
            'category',
            'slug',
            'created',
            'modified',
            'rank' => '`Articles`.`hits` / TIMESTAMPDIFF(HOUR, `Articles`.`created`, NOW())'
        ])->order(['rank' => 'DESC']);
    }
}
