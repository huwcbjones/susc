<?php
namespace SUSC\Model\Entity;

use Cake\I18n\Time;
use Cake\ORM\Entity;

/**
 * RegistrationCode Entity
 *
 * @property string $id
 * @property \Cake\I18n\FrozenTime $valid_from
 * @property \Cake\I18n\FrozenTime $valid_to
 * @property string $group_id
 *
 * @property \SUSC\Model\Entity\Group $group
 */
class RegistrationCode extends Entity
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
        'id' => false
    ];

    public function isValid(){
        if($this->valid_from == null && $this->valid_to == null ) return true;

        $now = Time::now();

        if($this->valid_from != null && $this->valid_to == null) {
            return $this->valid_from <= $now;
        }

        if($this->valid_from == null && $this->valid_to != null) {
            return $now < $this->valid_to;
        }


        return ($this->valid_from <= $now) && ($now < $this->valid_to);
    }
}
