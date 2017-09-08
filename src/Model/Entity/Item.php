<?php

namespace SUSC\Model\Entity;

use Cake\ORM\Entity;
use huwcbjones\markdown\GithubMarkdownExtended;

/**
 * Item Entity
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property boolean $image
 * @property string $imagePath
 * @property string $formatted_price
 * @property float $price
 * @property string $description
 * @property string $sizes
 * @property string[] $sizeList
 * @property ItemsOrder[] $_joinData;
 * @property boolean $status
 * @property boolean $additional_info
 * @property string $additional_info_description
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Item extends Entity
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
        'created' => false,
        'modified' => false,
        'slug' => false,
        'id' => false
    ];

    protected function _getRenderedDescription()
    {
        $parser = new GithubMarkdownExtended();
        return $parser->parse($this->description);
    }

    protected function _getRenderedAdditionalDescription(){
        $parser = new GithubMarkdownExtended();
        return $parser->parse($this->additional_info_description);
    }

    protected function _getImagePath()
    {
        if (!$this->image) {
            return '/images/no_image.png';
        }
        return '/images/store/kit/' . $this->id . '.jpg';
    }

    protected function _getSizeList()
    {
        if (trim($this->sizes) == '') {
            return null;
        }

        $sizes = str_getcsv($this->sizes);
        $size_array = [];
        foreach($sizes as $size){
            $size_array[$size] = $size;
        }
        return $size_array;
    }

    protected function _getFormattedPrice()
    {
        return sprintf("£%.2f", $this->price);
    }

    public function displayAdditionalInformation($additionalInfo)
    {
        if (!$this->additional_info) {
            return '[None Required]';
        } elseif ($additionalInfo == '') {
            return '[None Provided]';
        } else {
            return $additionalInfo;
        }
    }
}
