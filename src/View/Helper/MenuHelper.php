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
use Cake\View\Helper\UrlHelper;
use Cake\View\StringTemplateTrait;
use Cake\View\View;
use SUSC\Model\Entity\User;

/**
 * Class MenuHelper
 * @package SUSC\View\Helper
 *
 * @property HtmlHelper $Html
 * @property UrlHelper $Url
 */
class MenuHelper extends Helper
{
    use StringTemplateTrait;

    /**
     * List of helpers used by this helper
     *
     * @var array
     */
    public $helpers = ['Html', 'Url'];

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

    protected $_menuHeader = null;
    protected $_menuOpen = false;
    protected $_menuID = '';
    protected $_buffer = '';
    protected $_numberOfItems = 0;

    /**
     * Default helper config
     *
     * @var array
     */
    protected $_defaultConfig = [
        'templates' => [
            'ul' => '<ul class="dropdown-menu">{{content}}</ul>',
            'li' => '<li{{attrs}}>{{content}}</li>',
            'menu-li' => '<li{{attrs}}>{{link}}{{content}}</li>',
            'js' => '<script type="text/javascript">{{content}}</script>'
        ]
    ];

    protected $_currentHeaderIsActive = false;

    public function __construct(View $View, array $config = [])
    {
        parent::__construct($View, $config);

        $this->_currentUser = $this->_View->get('currentUser');
        $this->_currentURL = Router::normalize($this->request->getUri()->getPath());
    }

    public function startMenu($title, $url, $acl = null, $attrs = [], $options = [])
    {
        if ($this->_menuOpen) {
            trigger_error('Menu is already open.', E_USER_NOTICE);
        } else {
            $this->_numberOfItems = 0;
            $this->_buffer = '';
            $this->_menuOpen = true;
            $this->_menuID = '';
        }

        if ($acl !== null) {
            $options += [
                'fuzzy' => true
            ];
        }

        $this->_currentHeaderIsActive = $this->_isActive($url, $options);

        if (array_key_exists('id', $options)) {
            $this->_menuID = $options['id'];
        } else {
            $this->_menuID = strtolower(Text::slug($title));
            $options['id'] = $this->_menuID;
        }

        $this->_menuHeader = compact('title', 'url', 'acl', 'attrs', 'options');
        return $this;
    }

    /**
     * Returns whether a url is active
     * Defaults to exact url match
     *
     * @param array|mixed $url url to check
     * @param array|mixed $options
     *
     * @return bool True if url is active
     */
    protected function _isActive($url, $options = [])
    {
        $url = $this->Url->build($url);
        if (array_key_exists('fuzzy', $options) && $options['fuzzy']) {
            return strpos($this->_currentURL, $url) !== false;
        } else {
            return $url === $this->_currentURL;
        }
    }

    public function startMenuMap($title, $map, $attrs = [], $options = [])
    {
        if ($this->_menuOpen) {
            trigger_error('Menu is already open.', E_USER_NOTICE);
        } else {
            $this->_buffer = '';
            $this->_menuOpen = true;
        }

        if (!array_key_exists('fuzzy', $options)) {
            $options['fuzzy'] = true;
        }

        $this->_currentHeaderIsActive = false;
        $menuUrl = null;
        $menuAcl = null;
        foreach ($map as $acl => $url) {
            if ($menuUrl == null && $this->_hasAccess($acl)) {
                $menuAcl = $acl;
                $menuUrl = $url;
            }
            if (!$this->_currentHeaderIsActive && $this->_isActive($url, $options)) {
                $this->_currentHeaderIsActive = true;
            }
        }

        $acl = $menuAcl;
        $url = $menuUrl;

        $this->_menuID = strtolower(Text::slug($title));
        $options['id'] = $this->_menuID;

        if ($menuAcl !== null && $menuUrl !== null) {
            $this->_menuHeader = compact('title', 'url', 'acl', 'attrs', 'options');
        }

        return $this;
    }

    protected function _hasAccess($acl)
    {
        if ($acl == null) return true;
        if ($this->_currentUser !== null) return $this->_currentUser->hasAccessTo($acl);

        return TableRegistry::get('acls')->isPublic($acl);
    }

    public function end($options = [])
    {
        $content = '';
        if ($this->_menuHeader != null) {
            extract($this->_menuHeader);
            $content = $this->_menu($title, $url, $acl, $attrs, $options);
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
            $attrs = $this->addClass($attrs, 'dropdown');
            $options = $this->addClass($options, 'dropdown-toggle');
            $options['data-toggle'] = 'dropdown';
            $url = '#';

            unset($options['fuzzy']);
            return $this->formatTemplate('menu-li', [
                'attrs' => $this->templater()->formatAttributes($attrs),
                'link' => $this->Html->link($title, $url, $options),
                'content' => $this->formatTemplate('ul', [
                    'content' => $this->_buffer
                ])
            ]);
        } else {
            return $this->_item($title, $url, $acl, $attrs, $options, true);
        }
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
                $attrs = $this->addClass($attrs, 'item-hidden');
            }
            $attrs = $this->addClass($attrs, $this->_menuID);
            $this->_numberOfItems++;
        }
        return $this->formatTemplate('li', [
            'attrs' => $this->templater()->formatAttributes($attrs),
            'content' => $this->Html->link($title, $url, $options)
        ]);
    }

    public function separator($acl = null)
    {
        $attrs = [
            'role' => 'separator',
            'class' => 'divider'
        ];
        if($this->_menuOpen){
            $attrs = $this->templater()->addClass($attrs, $this->_menuID);
        }
        $separator = $this->formatTemplate('li', [
            'content' => '',
            'attrs' => $this->templater()->formatAttributes($attrs)
        ]);

        if (is_array($acl)) {
            $hasAccess = false;
            foreach ($acl as $a) {
                if ($this->_hasAccess($a)) {
                    $hasAccess = true;
                    break;
                }
            }
            if (!$hasAccess) $separator = '';
        } else {
            if (!$this->_hasAccess($acl)) $separator = '';
        }

        if ($this->_menuOpen) {
            $this->_buffer .= $separator;
            return $this;
        } else {
            return $separator;
        }
    }

    public function item($title, $url, $acl = null, $attrs = [], $options = [])
    {
        if ($this->_menuOpen) {
            if ($this->_menuID != '') {
                $attrs += ['id' => $this->_menuID];
            }
            $this->_buffer .= $this->_item($title, $url, $acl, $attrs, $options);
            return $this;
        } else {
            return $this->_item($title, $url, $acl, $attrs, $options);
        }
    }
}