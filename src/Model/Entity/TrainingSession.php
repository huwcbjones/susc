<?php
namespace SUSC\Model\Entity;

use Cake\ORM\Entity;

/**
 * TrainingSession Entity
 *
 * @property string $id
 * @property string $squads_id
 * @property int $day
 * @property string $dayStr
 * @property \Cake\I18n\FrozenTime $start
 * @property \Cake\I18n\FrozenTime $finish
 * @property string $location
 * @property string $notes
 *
 * @property \SUSC\Model\Entity\Squad $squad
 */
class TrainingSession extends Entity
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
        'squads_id' => true,
        'day' => true,
        'start' => true,
        'finish' => true,
        'location' => true,
        'notes' => true,
        'squad' => true
    ];

    protected function _getDayStr(){
        return date('l', strtotime("Sunday +{$this->day} days"));
    }
}
