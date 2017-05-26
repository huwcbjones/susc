<?php

namespace SUSC\Model\Entity;

use Cake\ORM\Entity;
use huwcbjones\markdown\GithubMarkdownExtended;

/**
 * Kit Entity
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string $image
 * @property float $price
 * @property string $description
 * @property string $sizes
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $status
 */
class Kit extends Entity
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

    protected function _getDescription($description)
    {
        require_once(ROOT . DS . "vendor" . DS . "huwcbjones" . DS . "markdown" . DS . "GithubMarkdownExtended.php");
        $parser = new GithubMarkdownExtended();
        return $parser->parse($description);
    }

    protected function _getImagePath()
    {
        if ($this->image == null) {
            return '/images/no_image.png';
        }
        return '/images/kit/' . $this->id . '.jpg';
    }

    protected function _getSizeList()
    {
        if (trim($this->sizes) == '') {
            return null;
        }

        return str_getcsv($this->sizes);
    }
}
