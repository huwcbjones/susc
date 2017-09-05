<?php

namespace SUSC\Model\Entity;

use Cake\Core\Exception\Exception;
use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;


/**
 * Group Entity
 *
 * @property string $id
 * @property string $name
 * @property FrozenTime $created
 * @property FrozenTime $modified
 * @property string $description
 * @property bool $is_enable
 * @property null|string|Group $parent
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

    protected $_effectiveAcls = null;

    protected $_parentObject = null;

    public function getEffectiveAcls()
    {
        if ($this->_effectiveAcls !== null) return $this->_effectiveAcls;
        if ($this->parent === null) return Acl::splattify($this->acls);

        // Merge parent group acls with this group's acls
        $this->_effectiveAcls = array_merge_recursive(Acl::splattify($this->acls), $this->parent->getEffectiveAcls());
        return $this->_effectiveAcls;
    }

    public function isEnabled()
    {
        return $this->is_enable !== "0";
    }

    protected function _getParent($parent)
    {
        if ($parent == null) return null;
        if ($this->_parentObject != null) return $this->_parentObject;
        /** @var Group $parent */
        try {
            if (!is_string($parent)) {
                $parent = $parent->id;
            }
            $this->_parentObject = TableRegistry::get('Groups' )->get($parent);
            return $this->_parentObject;
        } catch (Exception $ex) {
            return null;
        }
    }
}
