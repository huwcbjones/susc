<?php
namespace SUSC\Model\Entity;

use Cake\ORM\Entity;

/**
 * KitOrder Entity
 *
 * @property int $id
 * @property string $user_id
 * @property string $payment
 * @property float $total
 * @property \Cake\I18n\Time $date_ordered
 * @property \Cake\I18n\FrozenTime $paid_date
 * @property bool $is_paid
 *
 * @property \SUSC\Model\Entity\User $user
 * @property \SUSC\Model\Entity\KitItemsOrder[] $kit_items_order
 */
class KitOrder extends Entity
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
}
