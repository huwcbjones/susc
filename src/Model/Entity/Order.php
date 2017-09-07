<?php

namespace SUSC\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\I18n\Time;
use Cake\ORM\Entity;

/**
 * KitOrder Entity
 *
 * @property int $id
 * @property string $user_id
 * @property string $payment
 * @property float $total
 * @property string $formattedTotal
 * @property string $paymentMethod
 * @property string $status
 * @property FrozenTime $placed
 * @property Time $paid
 * @property Time $ordered
 * @property Time $collected
 * @property bool $is_paid
 * @property bool $is_ordered
 * @property bool $is_collected
 *
 * @property \SUSC\Model\Entity\User $user
 * @property \SUSC\Model\Entity\ItemsOrder[] $items_order
 */
class Order extends Entity
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

    protected function _getFormattedTotal()
    {
        return sprintf("£%.2f", $this->total);
    }

    protected function _getPaymentMethod()
    {
        switch ($this->payment) {
            case 'bat':
                return 'Bank Account Transfer';
            case 'cash':
                return 'Cash';
        }
    }

    protected function _getIsPaid(){
        return $this->paid != null;
    }
    protected function _getIsOrdered(){
        return $this->ordered != null;
    }
    protected function _getIsCollected(){
        return $this->collected != null;
    }

    protected function _getStatus()
    {
        if($this->is_collected){
            return 'Collected';
        }
        if($this->is_ordered){
            return 'Ordered';
        }
        if($this->is_paid) {
            return 'Waiting for order';
        }
        return 'Waiting for payment';
    }
}
