<?php

namespace SUSC\Model\Entity;

use Cake\I18n\Time;
use Cake\ORM\Entity;

/**
 * KitItemsOrder Entity
 *
 * @property string $id
 * @property int $order_id
 * @property string $kit_id
 * @property string $size
 * @property int $quantity
 * @property string $additional_info
 * @property float $price
 * @property string $formattedPrice
 * @property float $subtotal
 * @property string $formattedSubtotal
 * @property Time $ordered
 * @property Time $arrived
 * @property Time $collected
 * @property boolean $isOrdered
 * @property boolean $isArrived
 * @property boolean $isCollected
 *
 * @property \SUSC\Model\Entity\Order $order
 * @property \SUSC\Model\Entity\Item $item
 */
class ItemsOrder extends Entity
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
        'id' => false,
        'order_id' => false,
        'kit_id' => false
    ];

    protected function _getFormattedPrice()
    {
        return sprintf("£%.2f", $this->price);
    }

    protected function _getFormattedSubtotal()
    {
        return sprintf("£%.2f", $this->subtotal);
    }

    protected function _getIsArrived()
    {
        return $this->arrived != null;
    }

    protected function _getIsCollected()
    {
        return $this->collected != null;
    }

    protected function _getIsOrdered()
    {
        return $this->ordered != null;
    }
}
