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
 * @property boolean $is_enable
 * @property string $parent_id
 * @property null|Group $parent
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

    protected function _getIsEnable($is_enable){
        return $is_enable;
    }

    public function isEnabled()
    {
        if($this->parent == null) return $this->is_enable;
        return $this->is_enable && $this->parent->isEnabled();
    }

    protected function _getParent()
    {
        if ($this->parent_id == null) return null;
        if ($this->_parentObject != null) return $this->_parentObject;
        /** @var Group $parent */
        try {
            $this->_parentObject = TableRegistry::get('Groups' )->get($this->parent_id);
            return $this->_parentObject;
        } catch (Exception $ex) {
            return null;
        }
    }
}
