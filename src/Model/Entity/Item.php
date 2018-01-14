<?php

namespace SUSC\Model\Entity;

use Cake\Collection\CollectionInterface;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use DateTime;
use huwcbjones\markdown\GithubMarkdownExtended;

/**
 * Item Entity
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string $crc
 * @property boolean $image
 * @property string $imagePath
 * @property string $formattedPrice
 * @property float $price
 * @property string $description
 * @property string $renderedDescription
 * @property string $sizes
 * @property string $orderString
 * @property boolean $hasSize
 * @property string[] $sizeList
 * @property boolean $hasColour
 * @property string $colours
 * @property string[] $colourList
 * @property string[] $quantityList
 * @property ItemsOrder $_joinData;
 * @property ItemsOrder[]|CollectionInterface $items_orders
 * @property boolean $status Enabled or Disabled
 * @property boolean $isAvailableToOrder
 * @property boolean $instock In-Stock or Out of Stock
 * @property boolean $additional_info
 * @property string $additional_info_description
 * @property string $renderedAdditionalDescription
 * @property Time $from Display From
 * @property Time $until Display Until
 * @property Time $created Date created
 * @property Time $modified Date last modified
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
        'id' => false,
        'image' => false,
        'from' => false,
        'until' => false
    ];

    protected function _getCrc(){
        return dechex(crc32($this->id));
    }

    protected function _getRenderedDescription()
    {
        $parser = new GithubMarkdownExtended();
        return $parser->parse($this->description);
    }

    protected function _getRenderedAdditionalDescription()
    {
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
            $size_array[trim($size)] = trim($size);
        }
        return $size_array;
    }

    protected function _getColourList()
    {
        if (trim($this->colours) == '') {
            return null;
        }

        $colours = str_getcsv($this->colours);
        $colour_array = [];
        foreach($colours as $colour){
            $colour_array[trim($colour)] = trim($colour);
        }
        return $colour_array;
    }

    protected function _getQuantityList()
    {
        $range = range(1, 9);
        return array_combine($range, $range);
    }

    protected function _getHasSize(){
        return trim($this->sizes) != '';
    }

    protected function _getHasColour(){
        return trim($this->colours) != '';
    }

    protected function _getFormattedPrice()
    {
        return sprintf("£%.2f", $this->price);
    }

    public function displayAdditionalInformation($additionalInfo)
    {
        if (!$this->additional_info) {
            return '-';
        } elseif ($additionalInfo == '') {
            return '[None Provided]';
        } else {
            return $additionalInfo;
        }
    }

    protected function _getOrderString()
    {
        if (!$this->instock) {
            return 'This item is <strong>not</strong> currently available to order!';
        }
        $now = new DateTime();

        if ($this->from !== null && $this->from > $now) {
            return 'This item is will be available to order <strong>after</strong> ' . $now->format('d/m/Y') . '.';
        } else if ($this->from === null && $this->until !== null && $this->until <= $now) {
            return 'This item is <strong>not</strong> currently available to order!';
        } else if ($this->until <= $now || $this->from > $now) {
            return 'This item is <strong>not</strong> currently available to order!';
        }
        return 'This item is available to order!';
    }

    protected function _getIsAvailableToOrder()
    {
        $now = new DateTime();
        if ($this->from === null && $this->until === null) {
            return $this->instock;
        } else if ($this->from === null && $this->until !== null) {
            return $this->until > $now;
        } else if ($this->from !== null && $this->until === null) {
            return $this->from <= $now;
        } else {
            return $this->until >= $now && $this->from < $now;
        }
    }

    public function displayColour($colour)
    {
        if (!$this->hasColour) {
            return '-';
        } else {
            return $colour;
        }
    }

    public function displaySize($size)
    {
        if (!$this->hasSize) {
            return '-';
        } else {
            return $size;
        }
    }
}
