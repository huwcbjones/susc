<?php

namespace SUSC\Model\Entity;


use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;
use DateTime;

/**
 * User Entity
 *
 * @property string $id
 * @property string $gid
 * @property string $email_address
 * @property string $first_name
 * @property string $last_name
 * @property string $full_name
 * @property string $activation_code
 * @property string $reset_code
 * @property string $new_email
 * @property string $new_email_code
 * @property FrozenTime $activation_date
 * @property FrozenTime $reset_code_date
 * @property FrozenTime $new_email_code_date
 * @property string|resource $password
 * @property bool $is_active
 * @property bool $is_enable
 * @property bool $is_change_password
 * @property FrozenTime $created
 * @property FrozenTime $modified
 *
 * @property Group $group
 * @property Article[] $articles
 * @property Acl[] $acls
 * @property KitOrder[] $orders
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
        'id' => false,
        'email_address' => false,
        'users_acls' => true,
        'activation_code' => false,
        'reset_code' => false,
        'new_email_code' => false,
        '*' => true
    ];

    protected $_effectiveAcls = null;

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
        'activation_code',
        'reset_code',
        'new_email_code'
    ];

    public function isChangePassword()
    {
        return $this->is_change_password;
    }

    /**
     * Returns whether a user is active or not
     *
     * If a user is not activated, or is disabled, this method will return false
     * @return bool
     */
    public function isActive()
    {
        return $this->isEnabled() && $this->isActivated() && $this->group->isEnabled();
    }

    /**
     * Returns whether or not a user is enabled
     * @return bool
     */
    public function isEnabled()
    {
        return $this->is_enable;
    }

    /**
     * Returns whether a user has activated their account or not
     * @return bool
     */
    public function isActivated()
    {
        return $this->is_active;
    }

    /**
     * Returns whether or not a user is authorised for an ACL
     * @param $acl string to test
     * @return bool
     */
    public function isAuthorised($acl)
    {
        /** @var array|Acl $acls */
        $acls = $this->getEffectiveAcls();
        $acl_array = explode('.', $acl);
        $count = 1;
        foreach ($acl_array as $bit) {
            // Wildcard checking
            if ($bit == '*') {

                // If no nodes in this ACL, return false
                if (count($acls) == 0) return false;

                // We are at the end of the acl
                if ($count == count($acl_array)) {
                    // Return true if there are elements in this acl
                    return count($acls) != 0;
                }
            }

            // Normal Checking
            if (!array_key_exists($bit, $acls)) {
                // If the current bit doesn't exist in this acl, return false
                return false;
            }

            // Updated acl reference
            $acls = &$acls[$bit];


            if ($count == count($acl_array)) {
                // Since we are at the end of the acl
                // Return whether or not the acl exists ('_' index)
                return array_key_exists('_', $acls);
            }

            $count++;
        }
    }

    public function getEffectiveAcls()
    {
        if ($this->_effectiveAcls != null) return $this->_effectiveAcls;
        $this->_effectiveAcls = array_merge_recursive(Acl::splattify($this->acls), $this->group->getEffectiveAcls());
        return $this->_effectiveAcls;
    }

    /**
     * Gets whether or not the reset password code is still valid (not expired)
     * @return bool
     */
    public function isResetPasswordValid()
    {
        if ($this->reset_code_date == null) return false;
        return (new DateTime()) < $this->reset_code_date->addHours(3);
    }

    /**
     * Gets whether or the user is trying to reset their password
     * @return bool
     */
    public function isResettingPassword()
    {
        return ($this->reset_code_date !== null);
    }


    /**
     * Gets whether or not the change email code is still valid (not expired)
     * @return bool
     */
    public function isChangeEmailValid()
    {
        if ($this->new_email_code_date == null) return false;
        return (new DateTime()) < $this->new_email_code_date->addHours(3);
    }

    /**
     * Gets whether or not the user is trying to change their email
     * @return bool
     */
    public function isChangingEmail()
    {
        return ($this->new_email_code_date !== null);
    }

    protected function _getFull_name()
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
        if ($password == null) return null;
        if (is_string($password)) return $password;
        return stream_get_contents($password);
    }
}
