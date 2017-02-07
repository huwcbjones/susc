<?php
namespace SUSC\Model\Entity;

use Cake\ORM\Entity;

/**
 * Committee Entity
 *
 * @property string $id
 * @property string $name
 * @property int $position
 * @property string $role
 * @property string $image
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property bool $published
 */
class Committee extends Entity
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
