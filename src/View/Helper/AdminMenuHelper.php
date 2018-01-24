<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

/**
 * Author: huw
 * Since: 18/01/2018
 *
 */

namespace SUSC\View\Helper;


use Cake\View\Helper\HtmlHelper;
use Cake\View\StringTemplateTrait;

/**
 * Class MenuHelper
 * @package SUSC\View\Helper
 *
 * @property HtmlHelper $Html
 */
class AdminMenuHelper extends MenuHelper
{
    use StringTemplateTrait;

    /**
     * Default helper config
     *
     * @var array
     */
    protected $_defaultConfig = [
        'templates' => [
            'ul' => '<ul{{attrs}}>{{content}}</ul>',
            'li' => '<li{{attrs}}>{{content}}</li>',
            'js' => '<script type="text/javascript">{{content}}</script>'
        ]
    ];

    public function end($options = [])
    {
        $options = $this->templater()->addClass($options, 'nav');

        $content = '';
        if ($this->_menuHeader != null) {
            $endOptions = $options;
            extract($this->_menuHeader);
            $this->_buffer = $this->_menu($title, $url, $acl, $attrs, $options) . $this->_buffer;
            $options = $endOptions;

            $content = $this->formatTemplate('ul', [
                'attrs' => $this->templater()->formatAttributes($options),
                'content' => $this->_buffer
            ]);
        }


        $this->_menuID = '';
        $this->_menuOpen = false;
        $this->_menuHeader = null;
        $this->_buffer = '';

        return $content;
    }

    public function _menu($title, $url, $acl, $attrs, $options = [])
    {
        if ($this->_currentHeaderIsActive && (!array_key_exists('class', $attrs) || strpos($attrs['class'], 'active') === false)) {
            $attrs = $this->addClass($attrs, 'active');

        }
        if ($this->_numberOfItems != 0) {
            $options = $this->addClass($options, 'expando');
            $url = '#';
            $this->_generateMenuScript();
        }

        return $this->_item($title, $url, $acl, $attrs, $options, true);
    }

    protected function _generateMenuScript()
    {
        if ($this->_menuID == '') return;

        $script = '$(function () {$("#' . $this->_menuID . '").click(function(){toggleMenu("' . $this->_menuID . '")});});';
        $this->_View->append('postscript', $this->formatTemplate('js', ['content' => $script]));
    }

    protected function _item($title, $url, $acl = null, $attrs = [], $options = [], $menuHeader = false)
    {
        $options += [
            'fuzzy' => false
        ];

        if (is_array($acl)) {
            $hasAccess = false;
            foreach ($acl as $a) {
                if ($this->_hasAccess($a)) {
                    $hasAccess = true;
                    break;
                }
            }
            if (!$hasAccess) return '';
        } else {
            if (!$this->_hasAccess($acl)) return '';
        }

        if ($this->_isActive($url, $options) && (!array_key_exists('class', $attrs) || strpos($attrs['class'], 'active') === false)) {
            $attrs = $this->addClass($attrs, 'active');
        }

        if (!$menuHeader) {
            if (!$this->_currentHeaderIsActive) {
                $attrs = $this->addClass($attrs, ['item-hidden']);
            }
            $attrs = $this->addClass($attrs, $this->_menuID);
            $attrs = $this->addClass($attrs, 'admin-menu-item');
            $this->_numberOfItems++;
        }

        return $this->formatTemplate('li', [
            'attrs' => $this->templater()->formatAttributes($attrs),
            'content' => $this->Html->link($title, $url, $options)
        ]);
    }
}