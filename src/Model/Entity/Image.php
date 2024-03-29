<?php

namespace SUSC\Model\Entity;

use Cake\ORM\Entity;

/**
 * Image Entity
 *
 * @property string $id
 * @property string $title
 * @property string $extension
 * @property string $copyright
 * @property string $path
 * @property string $full_path
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property bool $status
 *
 * @property \SUSC\Model\Entity\Gallery[] $galleries
 */
class Image extends Entity
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

    protected function _getPath()
    {
        return '/images/store/' . $this->id . '.' . $this->extension;
    }

    protected function _getFullPath()
    {
        return WWW_ROOT . 'images' . DS . 'store' . DS . $this->id . '.' . $this->extension;
    }
}
