<?php
namespace SUSC\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Time;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property string $id
 * @property string $email_address
 * @property string $first_name
 * @property string $last_name
 * @property Time $activation_date
 * @property string $password
 * @property bool $is_active
 * @property bool $is_enable
 * @property bool $change_password
 * @property Time $created
 * @property Time $modified
 * @property string $fullname
 *
 * @property \App\Model\Entity\Article[] $articles
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

    protected function _getFullname(){
        return $this->first_name . ' ' . $this->last_name;
    }

    protected function _setPassword($password){
        if(strlen($password) > 0){
            return (new DefaultPasswordHasher)->hash($password);
        }
    }

    protected function _getPassword($password){
        return stream_get_contents($password);
    }
}
