<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('DashedRoute');

Router::scope('/', function (RouteBuilder $routes) {
    // Connect Home (/)
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'home'], ['_name' => 'home']);

    // Connect Admin pages
    Router::prefix('admin', function ($routes) {
        $routes->fallbacks('DashedRoute');
    });

    // Connect News
    $routes->connect('/news', ['controller' => 'News'], ['_name' => 'news']);
    $routes->connect('/news/:year/',
        ['controller' => 'News', 'action' => 'viewYear'],
        ['pass' => ['year'],
            'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
        ]
    );
    $routes->connect('/news/:year/:month/',
        ['controller' => 'News', 'action' => 'viewMonth'],
        [
            'pass' => ['year', 'month'],
            'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
            'month' => '0[1-9]|1[012]',
        ]
    );
    $routes->connect('/news/:year/:month/:day/',
        ['controller' => 'News', 'action' => 'viewDay'],
        [
            'pass' => ['year', 'month', 'day'],
            'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
            'month' => '0[1-9]|1[012]',
            'day' => '0[1-9]|[12][0-9]|3[01]',
        ]
    );
    $routes->connect('/news/:year/:month/:day/:slug',
        ['controller' => 'News', 'action' => 'view'],
        [
            'pass' => ['slug'],
            'slug' => '[A-z0-9\-]+'
        ]
    );
    $routes->connect('/news/:slug',
        ['controller' => 'News', 'action' => 'view'],
        [
            'pass' => ['slug'],
            'slug' => '[A-z0-9\-]+'
        ]
    );

    // Connect Training
    $routes->connect('/training', ['controller' => 'Pages', 'action' => 'training'], ['_name' => 'training']);
    $routes->connect('/training/comp', ['controller' => 'Pages', 'action' => 'training', 'competition'], ['_name' => 'training_comp']);
    $routes->connect('/training/rec', ['controller' => 'Pages', 'action' => 'training', 'recreation'], ['_name' => 'training_rec']);
    $routes->connect('/training/facilities', ['controller' => 'Pages', 'action' => 'training', 'facilities'], ['_name' => 'training_facilities']);

    // Connect Fixtures
    $routes->connect('/fixtures', ['controller' => 'Fixtures'], ['_name' => 'fixtures']);
    $routes->connect('/fixtures/calendar', ['controller' => 'Fixtures', 'action' => 'calendar'], ['_name' => 'fixture_calendar']);
    $routes->connect('/fixtures/:slug',
        ['controller' => 'Fixtures', 'action' => 'view'],
        [
            'pass' => ['slug'],
            'slug' => '[A-z0-9\-]+'
        ]
    );

    // Connect Socials
    $routes->connect('/socials', ['controller' => 'Socials'], ['_name' => 'socials']);
    $routes->connect('/socials/:year/:month/',
        ['controller' => 'Socials', 'action' => 'viewMonth'],
        [
            'pass' => ['year', 'month'],
            'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
            'month' => '0[1-9]|1[012]',
        ]
    );
    $routes->connect('/socials/:slug',
        ['controller' => 'Socials', 'action' => 'viewSocial'],
        [
            'pass' => ['slug'],
            'slug' => '[A-z0-9\-]+'
        ]
    );

    // Connect Galleries
    $routes->connect('/galleries',
        ['controller' => 'Galleries', 'action' => 'index'], ['_name' => 'galleries']
    );
    $routes->connect('/galleries/thumb/:thumbid',
        ['controller' => 'Galleries', 'action' => 'thumbnail'], [
            '_name' => 'thumbnail',
            'pass' => ['thumbid'],
            'thumbid' => '[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}\.(png|gif|jp(e|)g)'
        ]
    );

    // Connect About
    $routes->connect('/about/club', ['controller' => 'About', 'action' => 'club'], ['_name' => 'about']);
    $routes->redirect('/about', ['controller' => 'About', 'action' => 'club']);
    $routes->connect('/about/coaches', ['controller' => 'About', 'action' => 'coaches']);
    $routes->connect('/about/committee', ['controller' => 'About', 'action' => 'committee']);

    // Connect Contact Us
    $routes->connect('/contact', ['controller' => 'Pages', 'action' => 'contact'], ['_name' => 'contact']);

    // Connect CakeDC/Users for easy user management
    /*Router::prefix('users', function ($routes) {
        Router::plugin('CakeDC/Users', ['path' => '/'], function($routes){
            $routes->fallbacks('DashedRoute');
        });
    });*/


    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks('DashedRoute');
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
