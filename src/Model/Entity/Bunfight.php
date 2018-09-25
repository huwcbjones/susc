<?php
namespace SUSC\Model\Entity;

use Cake\ORM\Entity;
use huwcbjones\markdown\GithubMarkdownExtended;

/**
 * Bunfight Entity
 *
 * @property string $id
 * @property string $description
 * @property string $renderedDescription
 * @property string $name
 *
 * @property BunfightSession[] $bunfight_sessions
 * @property BunfightSignup[] $bunfight_signups
 */
class Bunfight extends Entity
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
        'description' => true,
        'name' => true,
        'bunfight_sessions' => true,
        'bunfight_signups' => true
    ];

    protected function _getRenderedDescription()
    {
        $parser = new GithubMarkdownExtended();
        return $parser->parse($this->description);
    }
}
