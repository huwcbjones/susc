<?php

namespace SUSC\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProcessedOrder Entity
 *
 * @property string $id
 * @property string $user_id
 * @property bool $is_ordered
 * @property bool $is_arrived
 * @property float $total
 * @property string $order_date
 * @property string $arrived_date
 * @property string $formatted_total
 * @property integer $item_count
 * @property string $status
 * @property \Cake\I18n\FrozenTime $ordered
 * @property \Cake\I18n\FrozenTime $arrived
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property integer $collected_left
 * @property boolean $is_all_collected
 *
 * @property \SUSC\Model\Entity\User $user
 * @property \SUSC\Model\Entity\ItemsOrder[] $items_orders
 */
class ProcessedOrder extends Entity
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

    protected $collectedCount = null;
    protected $itemCount = null;
    protected $total = null;

    protected function _getItemCount(){
        if($this->itemCount == null) $this->_countStats();
        return $this->itemCount;
    }
    protected function _getTotal(){
        if($this->total == null) $this->_countStats();
        return $this->total;
    }

    protected function _getFormattedTotal()
    {
        return sprintf("£%.2f", $this->total);
    }

    protected function _getOrderDate(){
        if($this->ordered === null) return "-";
        return $this->ordered->i18nFormat( null,  'Europe/London', 'en-GB');
    }

    protected function _getArrivedDate(){
        if($this->arrived === null) return "-";
        return $this->arrived->i18nFormat( null,  'Europe/London', 'en-GB');
    }

    public function getOrderedStatusIcon()
    {
        if ($this->is_ordered) {
            return '<span class="text-success glyphicon glyphicon-ok-sign"></span>';
        } else {
            return '<span class="text-danger glyphicon glyphicon-remove-sign"></span>';
        }
    }

    public function getArrivedStatusIcon()
    {
        if ($this->is_arrived) {
            return '<span class="text-success glyphicon glyphicon-ok-sign"></span>';
        } else {
            return '<span class="text-danger glyphicon glyphicon-remove-sign"></span>';
        }
    }

    public function getCollectedStatusIcon()
    {
        if ($this->is_all_collected) {
            return '<span class="text-success glyphicon glyphicon-ok-sign"></span>';
        }
        if ($this->collected_left == count($this->items_orders)) {
            return '<span class="text-danger glyphicon glyphicon-remove-sign"></span>';
        }
        return '<span class="text-warning glyphicon glyphicon-hourglass"></span>';
    }

    protected function _getIsOrdered()
    {
        return $this->ordered != null;
    }

    protected function _getIsArrived()
    {
        return $this->arrived != null;
    }

    protected function _getOrderedLeft()
    {
        return ($this->is_ordered) ? 0 : $this->item_count;
    }

    protected function _countStats()
    {
        $collected = 0;
        $total = 0;

        foreach ($this->items_orders as $item) {
            if ($item->is_collected) $collected++;
            $total += $item->subtotal;
        }
        $this->collectedCount = $collected;
        $this->total = $total;
        $this->itemCount = count($this->items_orders);
    }

    protected function _getCollectedLeft()
    {
        if ($this->collectedCount == null) $this->_countStats();
        return $this->item_count - $this->collectedCount;
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
        if($this->is_arrived){
            return 'Waiting for collection';
        }
        if ($this->is_ordered) {
            return 'Ordered';
        }
        return 'Waiting for order';
    }
}
