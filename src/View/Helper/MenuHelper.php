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


use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Cake\View\Helper;
use Cake\View\Helper\HtmlHelper;
use Cake\View\StringTemplateTrait;
use Cake\View\View;
use SUSC\Model\Entity\User;

/**
 * Class MenuHelper
 * @package SUSC\View\Helper
 *
 * @property HtmlHelper $Html
 */
class MenuHelper extends Helper
{
    use StringTemplateTrait;

    /**
     * List of helpers used by this helper
     *
     * @var array
     */
    public $helpers = ['Html'];

    /**
     * Reference to the Response object
     *
     * @var \Cake\Http\Response
     */
    public $response;

    /**
     * Currently logged in user
     *
     * @var User|null
     */
    protected $_currentUser = null;


    /**
     * Current URL
     *
     * @var string
     */
    protected $_currentURL = '/';

    protected $_menuOpen = false;
    protected $_menuID = '';
    protected $_buffer = '';

    /**
     * Default helper config
     *
     * @var array
     */
    protected $_defaultConfig = [
        'templates' => [
            'ul' => '<ul{{attrs}}>{{content}}</ul>',
            'li' => '<li{{attrs}}>{{content}}</li>'
        ]
    ];

    protected $_currentHeaderIsActive = false;

    public function __construct(View $View, array $config = [])
    {
        parent::__construct($View, $config);

        $this->_currentUser = $this->_View->get('currentUser');
        $this->_currentURL = Router::normalize($this->request->getRequestTarget());
    }

    public function startMenu($title, $url, $acl = null, $attrs = [], $options = [])
    {
        if ($this->_menuOpen) {
            trigger_error('Menu is already open.', E_USER_NOTICE);
        } else {
            $this->_buffer = '';
            $this->_menuOpen = true;
        }

        $options += [
            'fuzzy' => true
        ];

        $this->_currentHeaderIsActive = $this->_isActive($url, $options['fuzzy']);

        $this->_menu($title, $url, $acl, $attrs, $options);

        return $this;
    }

    /**
     * Returns whether a url is active
     * Defaults to exact url match
     *
     * @param array|mixed $url url to check
     * @param bool $fuzzy If true, will do a fuzzy match (not exact)
     *
     * @return bool True if url is active
     */
    protected function _isActive($url, $fuzzy = false)
    {
        $url = Router::url($url);
        if ($fuzzy) {
            return strpos($this->_currentURL, $url) !== false;
        } else {
            return $url === $this->_currentURL;
        }
    }

    public function _menu($title, $url, $acl, $attrs, $options = [])
    {

        if ($this->_currentHeaderIsActive) {
            $options = $this->addClass($options, 'active');
        } else {
            $url = '#';
        }
        $this->_menuID = strtolower(Text::slug($title));
        $options['id'] = $this->_menuID;

        $this->_buffer .= $this->_item($title, $url, $acl, $attrs, $options, true);
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

        if ($this->_isActive($url, $options['fuzzy'])) {
            $attrs = $this->addClass($attrs, 'active');
        }

        if (!$menuHeader) {
            if (!$this->_currentHeaderIsActive) {
                $attrs = $this->addClass($attrs, 'item-hidden');
            }

            $attrs = $this->addClass($attrs, $this->_menuID);
        }

        return $this->formatTemplate('li', [
            'attrs' => $this->templater()->formatAttributes($attrs),
            'content' => $this->Html->link($title, $url, $options)
        ]);
    }

    protected function _hasAccess($acl)
    {
        if ($this->_currentUser !== null) return $this->_currentUser->hasAccessTo($acl);

        return TableRegistry::get('acls')->isPublic($acl);
    }

    public function startMenuMap($title, $map, $attrs = [], $options = [])
    {
        if ($this->_menuOpen) {
            trigger_error('Menu is already open.', E_USER_NOTICE);
        } else {
            $this->_buffer = '';
            $this->_menuOpen = true;
        }

        $this->_currentHeaderIsActive = false;
        $menuUrl = null;
        $menuAcl = null;
        foreach ($map as $acl => $url) {
            if (!$this->_currentHeaderIsActive && $this->_isActive($url, true)) {
                $this->_currentHeaderIsActive = true;
            }
            if ($menuUrl == null && $this->_hasAccess($acl)) {
                $menuAcl = $acl;
                $menuUrl = $url;
            }
        }

        $this->_menu($title, $menuUrl, $menuAcl, $attrs, $options);

        return $this;
    }

    public function end($options = [])
    {
        $options += [
            'class' => ['nav nav-sidebar']
        ];

        $content = '';
        if (trim($this->_buffer) !== '') {
            $content = $this->formatTemplate('ul', [
                'attrs' => $this->templater()->formatAttributes($options),
                'content' => $this->_buffer
            ]);
        }


        $this->_menuID = '';
        $this->_menuOpen = false;
        $this->_buffer = '';

        return $content;
    }

    public function item($title, $url, $acl = null, $attrs = [], $options = [])
    {
        if ($this->_menuOpen) {
            $this->_buffer .= $this->_item($title, $url, $acl, $attrs, $options);
            return $this;
        } else {
            return $this->_item($title, $url, $acl, $attrs, $options);
        }
    }
}