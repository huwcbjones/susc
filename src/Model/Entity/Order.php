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
 * @property int $ordered_left
 * @property int $arrived_left
 * @property int $collected_left
 * @property bool $is_paid
 * @property bool $is_all_ordered
 * @property bool $is_all_arrived
 * @property bool $is_all_collected
 *
 * @property User $user
 * @property ItemsOrder[] $items_orders
 * @property ItemsOrder[] $items
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

    protected $orderedCount = null;
    protected $arrivedCount = null;
    protected $collectedCount = null;

    public function getPaidStatusIcon()
    {
        return '<span class="text-' . ($this->is_paid ? 'success' : 'danger') . ' glyphicon glyphicon-' . ($this->is_paid ? 'ok' : 'remove') . '-sign"></span>';
    }

    public function getOrderedStatusIcon()
    {
        if ($this->is_all_ordered) {
            return '<span class="text-success glyphicon glyphicon-ok-sign"></span>';
        }
        if ($this->ordered_left == count($this->items)) {
            return '<span class="text-danger glyphicon glyphicon-remove-sign"></span>';
        }
        return '<span class="text-warning glyphicon glyphicon-hourglass"></span>';
    }

    public function getArrivedStatusIcon()
    {
        if ($this->is_all_arrived) {
            return '<span class="text-success glyphicon glyphicon-ok-sign"></span>';
        }
        if ($this->arrived_left == count($this->items)) {
            return '<span class="text-danger glyphicon glyphicon-remove-sign"></span>';
        }
        return '<span class="text-warning glyphicon glyphicon-hourglass"></span>';
    }

    public function getCollectedStatusIcon()
    {
        if ($this->is_all_collected) {
            return '<span class="text-success glyphicon glyphicon-ok-sign"></span>';
        }
        if ($this->collected_left == count($this->items)) {
            return '<span class="text-danger glyphicon glyphicon-remove-sign"></span>';
        }
        return '<span class="text-warning glyphicon glyphicon-hourglass"></span>';
    }

    protected function _getItems()
    {
        return $this->items_orders;
    }

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
        if ($this->orderedCount == null) $this->_countStats();
        return count($this->items) - $this->orderedCount;
    }

    protected function _countStats()
    {
        $ordered = $arrived = $collected = 0;

        foreach ($this->items as $item) {
            if ($item->is_ordered) $ordered++;
            if ($item->is_arrived) $arrived++;
            if ($item->is_collected) $collected++;
        }
        $this->orderedCount = $ordered;
        $this->arrivedCount = $arrived;
        $this->collectedCount = $collected;
    }

    protected function _getIsAllOrdered()
    {
        return $this->ordered_left == 0;
    }

    protected function _getArrivedLeft()
    {
        if ($this->arrivedCount == null) $this->_countStats();
        return count($this->items) - $this->arrivedCount;
    }

    protected function _getIsAllArrived()
    {
        return $this->arrived_left == 0;
    }

    protected function _getCollectedLeft()
    {
        if ($this->collectedCount == null) $this->_countStats();
        return count($this->items) - $this->collectedCount;
    }

    protected function _getIsAllCollected()
    {
        return $this->collected_left == 0;
    }

    protected function _getStatus()
    {
        if ($this->is_all_collected) {
            return 'Collected';
        }
        if($this->is_all_arrived){
            return 'Waiting for collection';
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
