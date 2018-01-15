<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 */

namespace SUSC\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;
use huwcbjones\markdown\GithubMarkdownExtended;

/**
 * MembershipType Entity
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property float $price
 * @property string $description
 * @property bool $is_enable
 * @property \Cake\I18n\FrozenTime|null $valid_from
 * @property \Cake\I18n\FrozenTime|null $valid_to
 * @property string $valid_from_string
 * @property string $valid_to_string
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property string $rendered_description
 * @property string $formatted_price
 *
 * @property \SUSC\Model\Entity\Membership[] $memberships
 */
class MembershipType extends Entity
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
        'slug' => false,
        'created' => false,
        'modified' => false,
        'id' => false
    ];

    protected function _setValidFrom($data)
    {
        if ($data === '') {
            return null;
        }

        return $data;
    }

    protected function _getValidFrom($valid_from)
    {
        if ($valid_from === null) {
            return null;
        } else if ($valid_from instanceof FrozenTime) {
            return $valid_from;
        }
        return new FrozenTime($valid_from);
    }
    protected function _getValidFromString(){
        return $this->valid_from == null ? '' : $this->valid_from->format('d F Y');
    }

    protected function _setValidTo($data)
    {
        if ($data === '') {
            return null;
        }

        return $data;
    }

    protected function _getValidTo($valid_to)
    {
        if ($valid_to === null) {
            return null;
        } elseif ($valid_to instanceof FrozenTime) {
            return $valid_to;
        }
        return new FrozenTime($valid_to);
    }

    protected function _getValidToString(){
        return $this->valid_to == null ? '' : $this->valid_to->format('d F Y');
    }

    protected function _getRenderedDescription()
    {
        $parser = new GithubMarkdownExtended();
        return $parser->parse($this->description);
    }

    public function getStatusIcon()
    {
        if ($this->is_enable) {
            return '<span class="text-success glyphicon glyphicon-ok-sign"></span>';
        } else {
            return '<span class="text-danger glyphicon glyphicon-remove-sign"></span>';
        }
    }

    protected function _getFormattedPrice()
    {
        return sprintf("£%.2f", $this->price);
    }

}
