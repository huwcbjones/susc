<?php

namespace SUSC\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;


/**
 * Session Entity
 *
 * @property string $id
 * @property string $user_id
 * @property string $validator
 * @property string $ip
 * @property FrozenTime $expires
 *
 * @property User $user
 */
class Session extends Entity
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
        'user_id' => true,
        'validator' => true,
        'expires' => true,
        'user' => true
    ];

    protected function _setIp($ip)
    {
        return inet_pton($ip);
    }

    protected function _getIp($ip)
    {
        if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6)) return $ip;
        return inet_ntop($ip);
    }

    public function validateSession($sessionKey)
    {
        return hash_equals($this->validator, hash('sha512', $sessionKey));
    }

    public function regenerate()
    {
        $this->expires = new \DateTime('+1 month');
        $key = bin2hex(random_bytes(64));
        $this->validator = hash('sha512', $key);
        return $key;
    }
}
