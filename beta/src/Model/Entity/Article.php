<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;
use cebe\markdown\GithubMarkdown;

/**
 * News Entity.
 *
 * @property int $id
 * @property string $title
 * @property int $author
 * @property string $content
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $start
 * @property \Cake\I18n\Time $end
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

    protected function _getSlug()
    {
        $id_url = $this->title;
        $id_url = strtolower($id_url);
        return Text::slug($id_url);
    }

    protected function _getContent($content)
    {
        $parser = new GithubMarkdown();
        return $parser->parse($content);
    }
}
