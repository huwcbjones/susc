<?php

namespace SUSC\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * ItemsOrder Entity
 *
 * @property string $id
 * @property int $order_id
 * @property string $item_id
 * @property string $size
 * @property string colour
 * @property int $quantity
 * @property string $additional_info
 * @property float $price
 * @property float $subtotal
 * @property string $formattedPrice
 * @property string $formattedSubtotal
 * @property boolean $is_ordered
 * @property boolean $is_arrived
 * @property boolean $is_collected
 * @property int $processed_order_id
 * @property ProcessedOrder $processed_order
 * @property FrozenTime $arrived
 * @property FrozenTime $collected
 * @property string $collected_date
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
        'id' => false
    ];

    protected function _getCollectedDate(){
        if($this->collected === null) return "-";
        $collected = new FrozenTime($this->collected);
        return $collected->i18nFormat( null,  'Europe/London', 'en-GB');
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
        if ($this->is_collected) {
            return '<span class="text-success glyphicon glyphicon-ok-sign"></span>';
        } else {
            return '<span class="text-danger glyphicon glyphicon-remove-sign"></span>';
        }
    }

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
        if ($this->processed_order === null) return null;
        return $this->processed_order->is_arrived;
    }

    protected function _getIsCollected()
    {
        return $this->collected != null;
    }

    protected function _getIsOrdered()
    {
        if ($this->processed_order === null) return null;
        return $this->processed_order->is_ordered;
    }
}
