<?php

namespace SUSC\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * Membership Entity
 *
 * @property string $id
 * @property string $user_id
 * @property int $student_id
 * @property string $soton_id
 * @property string $name
 * @property \Cake\I18n\FrozenDate $date_of_birth
 * @property string $membership_type_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $paid
 * @property string $payment_method
 * @property boolean $is_paid
 * @property boolean $is_valid
 *
 * @property \SUSC\Model\Entity\User $user
 * @property \SUSC\Model\Entity\MembershipType $membership_type
 */
class Membership extends Entity
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

    public function getStatusIcon()
    {
        if ($this->is_valid && $this->is_paid) {
            return '<span class="text-success glyphicon glyphicon-ok-sign"></span>';
        } else {
            return '<span class="text-danger glyphicon glyphicon-remove-sign"></span>';
        }
    }

    public function getValidStatusIcon()
    {
        return '<span class="text-' . ($this->is_valid ? 'success' : 'danger') . ' glyphicon glyphicon-' . ($this->is_valid ? 'ok' : 'remove') . '-sign"></span>';
    }

    public function getPaidStatusIcon()
    {
        return '<span class="text-' . ($this->is_paid ? 'success' : 'danger') . ' glyphicon glyphicon-' . ($this->is_paid ? 'ok' : 'remove') . '-sign"></span>';
    }

    protected function _getIsPaid()
    {
        return $this->paid !== null;
    }

    protected function _getIsValid()
    {
        $now = new FrozenTime();
        return $now->between($this->membership_type->valid_from, $this->membership_type->valid_to);
    }

    protected function _getPayment()
    {
        switch ($this->payment_method) {
            case 'bat':
                return 'Bank Account Transfer';
            case 'cash':
                return 'Cash';
        }
    }
}
