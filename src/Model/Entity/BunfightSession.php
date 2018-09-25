<?php

namespace SUSC\Model\Entity;

use Cake\ORM\Entity;

/**
 * BunfightSession Entity
 *
 * @property string $id
 * @property \Cake\I18n\FrozenTime $start
 * @property \Cake\I18n\FrozenTime $finish
 * @property int $signups_count
 * @property int $capacity
 * @property int $totalCapacity
 * @property int $progress
 * @property int $oversubscribe_percentage
 * @property string $bunfight_id
 * @property string $progressStatus
 * @property bool $isFull
 *
 * @property \SUSC\Model\Entity\Bunfight $bunfight
 * @property \SUSC\Model\Entity\BunfightSignup[] $bunfight_signups
 */
class BunfightSession extends Entity
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
        'start' => true,
        'finish' => true,
        'capacity' => true,
        'oversubscribe_percentage' => true,
        'bunfight_id' => true,
        'bunfight' => true,
        'bunfight_signups' => true
    ];

    protected function _getTotalCapacity()
    {
        return $this->capacity + $this->capacity * ($this->oversubscribe_percentage / 100);
    }

    protected function _getProgress()
    {
        $signups = $this->signups_count;
        if ($this->signups_count >= $this->totalCapacity) $signups = $this->totalCapacity;
        return ceil(100 * ($signups / $this->totalCapacity));
    }

    protected function _getProgressStatus()
    {
        if ($this->signups_count >= $this->totalCapacity) {
            return 'danger';
        } elseif ($this->signups_count >= $this->capacity) {
            return 'warning';
        } else {
            return 'success';
        }
    }

    protected function _getIsFull()
    {
        return $this->signups_count >= $this->totalCapacity;
    }
}
