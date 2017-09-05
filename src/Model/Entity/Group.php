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

    public function getEffectiveAcls()
    {
        if ($this->parent === null) return $this->acls;

        // Merge parent group acls with this group's acls
        /** @var Group $parent */
        $parent = TableRegistry::get('Groups')->get($this->parent);
        return array_merge_recursive($this->acls, $parent->getEffectiveAcls());
    }

    protected function _getAcls($acls)
    {
        return Acl::splattify($acls);
    }

    protected function _getParentName()
    {
        return TableRegistry::get('Groups')->get($this->parent)->name;
    }
}
