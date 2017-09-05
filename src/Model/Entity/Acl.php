<?php

namespace SUSC\Model\Entity;

use Cake\ORM\Entity;

/**
 * Acl Entity
 *
 * @property string $id
 * @property string $description
 *
 * @property \SUSC\Model\Entity\Group[] $groups
 * @property \SUSC\Model\Entity\User[] $users
 */
class Acl extends Entity
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

    public static function splattify($acls)
    {
        if ($acls == null) {
            return [];
        }

        // Convert numeric indexed array to Acl ID indexed array
        $new_acls = array();
        /** @var Acl $acl */
        foreach ($acls as $acl) {
            $id = explode('.', $acl->id);
            $head = &$new_acls;
            foreach ($id as $bit) {
                if (!array_key_exists($bit, $head)) {
                    $head[$bit] = array();
                }

                $head = &$head[$bit];
            }

            $head['_'] = $acl;
        }
        return $new_acls;
    }

    public static function hasAcl(array $acls, Acl $test)
    {
        $acl_array = explode('.', $test->id);

        $head = &$acls;
        foreach ($acl_array as $bit) {
            if (array_key_exists($bit, $head)) {
                $head = &$head[$bit];
            } else {
                return false;
            }
        }
        return array_key_exists('_', $head);
    }
}
