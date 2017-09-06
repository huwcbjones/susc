<?php
namespace SUSC\Model\Entity;

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
 * @property float $subtotal
 * @property \Cake\I18n\FrozenTime $collected
 *
 * @property \SUSC\Model\Entity\KitOrder $kit_order
 * @property \SUSC\Model\Entity\KitItem $kit_item
 */
class KitItemsOrder extends Entity
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
}
