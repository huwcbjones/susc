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
 * @property \Cake\I18n\FrozenTime $ordered
 * @property \Cake\I18n\FrozenTime $arrived
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
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

    protected function _getItemCount(){
        if($this->items_orders === null) return 0;
        return count($this->items_orders);
    }
    protected function _getTotal(){
        if($this->items_orders === null) return 0;
        $total = 0;
        foreach($this->items_orders as $item){
            $total += $item->subtotal;
        }
        return $total;
    }

    protected function _getFormattedTotal()
    {
        return sprintf("£%.2f", $this->total);
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

    protected function _getIsOrdered()
    {
        return $this->ordered != null;
    }

    protected function _getIsArrived()
    {
        return $this->arrived != null;
    }
}
