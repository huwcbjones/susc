<?php
namespace SUSC\Model\Entity;

use Cake\ORM\Entity;
use huwcbjones\markdown\GithubMarkdownExtended;

/**
 * Squad Entity
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $renderedDescription
 *
 * @property \SUSC\Model\Entity\BunfightSignup[] $bunfight_signups
 * @property \SUSC\Model\Entity\TrainingSession[] $training_sessions
 */
class Squad extends Entity
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
        'name' => true,
        'slug' => true,
        'description' => true,
        'bunfight_signups' => true
    ];

    protected function _getRenderedDescription() {
        $parser = new GithubMarkdownExtended();
        return $parser->parse($this->description);
    }
}
