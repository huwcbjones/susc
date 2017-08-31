<?php

namespace SUSC\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Group Entity
 *
 * @property string $id
 * @property string $name
 * @property null|string $parent
 *
 * @property Acl[] $acls
 */
class Group extends Entity
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

    protected function _getAcls($acls)
    {
        // Convert numeric indexed array to Acl ID indexed array
        $new_acls = array();
        /** @var Acl $acl */
        foreach($acls as $acl) {
            //if($this->name == 'Member') var_dump($acl);
            $id = explode('.', $acl->id);
            $head = &$new_acls;
            foreach($id as $bit) {
                if(!array_key_exists($bit, $head)){
                    $head[$bit] = array();
                }
                $head = &$head[$bit];
            }
            $head['_'] = $acl;
        }

        $acls = $new_acls;

        if ($this->parent === null) return $acls;

        // Merge parent group acls with this group's acls
        /** @var Group $parent */
        $parent = TableRegistry::get('Groups')->get($this->parent);

        return array_merge($acls, $parent->acls);
    }

    protected function _getParentName()
    {
        return TableRegistry::get('Groups')->get($this->parent)->name;
    }
}
