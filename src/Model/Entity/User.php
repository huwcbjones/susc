<?php

namespace SUSC\Model\Entity;


use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property string $id
 * @property string $gid
 * @property string $email_address
 * @property string $first_name
 * @property string $last_name
 * @property FrozenTime $activation_date
 * @property string|resource $password
 * @property bool $is_active
 * @property bool $is_enable
 * @property bool $change_password
 * @property FrozenTime $created
 * @property FrozenTime $modified
 *
 * @property Group $group
 * @property Article[] $articles
 * @property Acl[] $acls
 */
class User extends Entity
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

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _getFullname()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }

    protected function _getPassword($password)
    {
        if (is_string($password)) return $password;
        return stream_get_contents($password);
    }

    protected function _getAcls($acls){
        // Convert numeric indexed array to Acl ID indexed array
        $acls = array_column($acls, null, 'id');

        // Merge User acls with group acls
        return array_merge($acls, $this->group->acls);
    }
}
