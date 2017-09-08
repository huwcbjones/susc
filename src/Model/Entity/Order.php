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
 * @property User $user
 * @property Item[] $items
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

    protected function _getIsPaid()
    {
        return $this->paid != null;
    }

    protected function _getOrderedLeft()
    {
        $count = 0;
        foreach ($this->items as $item) {
            if ($item->_joinData->ordered == null) $count++;
        }
        return $count;
    }

    protected function _getIsAllOrdered()
    {
        foreach ($this->items as $item) {
            if ($item->_joinData->ordered == null) return false;
        }
        return true;
    }

    protected function _getArrivedLeft()
    {
        $count = 0;
        foreach ($this->items as $item) {
            if ($item->_joinData->arrived == null) $count++;
        }
        return $count;
    }

    protected function _getIsAllArrived()
    {
        foreach ($this->items as $item) {
            if ($item->_joinData->arrived == null) return false;
        }
        return true;
    }

    protected function _getCollectedLeft()
    {
        $count = 0;
        foreach ($this->items as $item) {
            if ($item->_joinData->collected == null) $count++;
        }
        return $count;
    }

    protected function _getIsAllCollected()
    {
        foreach ($this->items as $item) {
            if ($item->_joinData->collected == null) return false;
        }
        return true;
    }

    public function getPaidStatusIcon()
    {
        return '<span class="text-' . ($this->is_paid ? 'success' : 'danger') . ' glyphicon glyphicon-' . ($this->is_paid ? 'ok' : 'remove') . '-sign"></span>';
    }

    public function getOrderedStatusIcon()
    {
        if($this->is_all_ordered){
            return '<span class="text-success glyphicon glyphicon-ok-sign"></span>';
        }
        if($this->ordered_left == count($this->items)){
            return '<span class="text-danger glyphicon glyphicon-remove-sign"></span>';
        }
        return '<span class="text-warning glyphicon glyphicon-hourglass"></span>';
    }

    public function getArrivedStatusIcon()
    {
        if($this->is_all_arrived){
            return '<span class="text-success glyphicon glyphicon-ok-sign"></span>';
        }
        if($this->arrived_left == count($this->items)){
            return '<span class="text-danger glyphicon glyphicon-remove-sign"></span>';
        }
        return '<span class="text-warning glyphicon glyphicon-hourglass"></span>';
    }

    public function getCollectedStatusIcon()
    {
        if($this->is_all_collected){
            return '<span class="text-success glyphicon glyphicon-ok-sign"></span>';
        }
        if($this->collected_left == count($this->items)){
            return '<span class="text-danger glyphicon glyphicon-remove-sign"></span>';
        }
        return '<span class="text-warning glyphicon glyphicon-hourglass"></span>';
    }

    protected function _getStatus()
    {
        if ($this->is_all_collected) {
            return 'Collected';
        }
        if ($this->is_all_ordered) {
            return 'Ordered';
        }
        if ($this->is_paid) {
            return 'Waiting for order';
        }
        return 'Waiting for payment';
    }
}
