<?php
namespace SUSC\Model\Entity;

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
}
