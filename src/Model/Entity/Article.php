<?php
namespace SUSC\Model\Entity;

use Cake\I18n\Time;
use Cake\ORM\Entity;
use huwcbjones\markdown\GithubMarkdownExtended;

/**
 * News Entity.
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int $author
 * @property User $user
 * @property string $content
 * @property Time $created
 * @property Time $modified
 * @property Time $start
 * @property Time $end
 * @property int $hits
 * @property bool $status
 */
class Article extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];



    protected function _getContent($content)
    {
        $parser = new GithubMarkdownExtended();
        return $parser->parse($content);
    }

    protected function _getAuthorName(){
        if (is_null($this->user)) {
            return 'SUSC';
        } else {
            return $this->user->full_name;
        }
    }

    public function incrementHits(){
        $lastModified = $this->modified;
        $this->hits++;
        $this->modified = $lastModified;
    }
}
