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
use Cake\Routing\Route\DashedRoute;
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
    Router::prefix('admin', function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    });

    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login'], ['_name' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout'], ['_name' => 'logout']);
    $routes->connect('/register', ['controller' => 'Users', 'action' => 'register'], ['_name' => 'register']);
    $routes->connect('/user/profile', ['controller' => 'Users', 'action' => 'profile'], ['_name' => 'profile']);
    $routes->connect('/user/profile/password', ['controller' => 'Users', 'action' => 'password'], ['_name' => 'change_password']);
    $routes->connect('/user/profile/email', ['controller' => 'Users', 'action' => 'email'], ['_name' => 'change_email']);

    // Connect News
    $routes->connect('/news', ['controller' => 'News'], ['_name' => 'news']);
    $routes->connect('/news/:year',
        ['controller' => 'News', 'action' => 'index'],
        ['pass' => ['year'],
            'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
        ]
    );
    $routes->connect('/news/:year/:month',
        ['controller' => 'News', 'action' => 'index'],
        [
            'pass' => ['year', 'month'],
            'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
            'month' => '0[1-9]|1[012]',
            '_name' => 'NewsMonthIndex'
        ]
    );
    $routes->connect('/news/:year/:month/:day',
        ['controller' => 'News', 'action' => 'index'],
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
            'pass' => ['year', 'month', 'day', 'slug'],
            'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
            'month' => '0[1-9]|1[012]',
            'day' => '0[1-9]|[12][0-9]|3[01]',
            'slug' => '[A-z0-9\-]+'
        ]
    );

    // Connect Training
    $routes->connect('/training', ['controller' => 'Pages', 'action' => 'training'], ['_name' => 'training']);
    $routes->connect('/training/competition', ['controller' => 'Pages', 'action' => 'training', 'competition'], ['_name' => 'training_comp']);
    $routes->connect('/training/recreational', ['controller' => 'Pages', 'action' => 'training', 'recreation'], ['_name' => 'training_rec']);
    $routes->connect('/training/facilities', ['controller' => 'Pages', 'action' => 'training', 'facilities'], ['_name' => 'training_facilities']);

    // Connect Fixtures
    $routes->connect('/fixtures', ['controller' => 'Fixtures'], ['_name' => 'fixtures']);
    $routes->connect('/fixtures/calendar', ['controller' => 'Fixtures', 'action' => 'calendar'], ['_name' => 'fixture_calendar']);
    $routes->connect('/fixtures/:year/:slug',
        ['controller' => 'Fixtures', 'action' => 'view'],
        [
            'pass' => ['year', 'slug'],
            'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
            'slug' => '[A-z0-9\-]+'
        ]
    );

    // Connect Socials
    $routes->connect('/socials', ['controller' => 'Socials'], ['_name' => 'socials']);
    $routes->connect('/socials/:year',
        ['controller' => 'Socials', 'action' => 'index'],
        [
            'pass' => ['year'],
            'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
        ]
    );
    $routes->connect('/socials/:year/:month/',
        ['controller' => 'Socials', 'action' => 'index'],
        [
            'pass' => ['year', 'month'],
            'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
            'month' => '0[1-9]|1[012]',
            '_name' => 'SocialsMonthIndex'
        ]
    );
    $routes->connect('/socials/:year/:month/:day',
        ['controller' => 'Socials', 'action' => 'index'],
        [
            'pass' => ['year', 'month', 'day'],
            'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
            'month' => '0[1-9]|1[012]',
            'day' => '0[1-9]|[12][0-9]|3[01]'
        ]
    );
    $routes->connect('/socials/:year/:month/:day/:slug',
        ['controller' => 'Socials', 'action' => 'view'],
        [
            'pass' => ['year', 'month', 'day', 'slug'],
            'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
            'month' => '0[1-9]|1[012]',
            'day' => '0[1-9]|[12][0-9]|3[01]',
            'slug' => '[A-z0-9\-]+'
        ]
    );

    // Connect Galleries
    $routes->connect('/gallery',
        ['controller' => 'Galleries', 'action' => 'index'], ['_name' => 'gallery']
    );
    Router::scope('/gallery/thumb', function (RouteBuilder $routes) {
        $routes->extensions(['jpg']);
        $routes->connect('/:thumbid',
            ['controller' => 'Galleries', 'action' => 'thumbnail'],
            [
                '_name' => 'thumbnail',
                'pass' => ['thumbid'],
                'thumbid' => '[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}'
            ]
        );

    });


    // Connect About
    $routes->connect('/about/club', ['controller' => 'About', 'action' => 'club'], ['_name' => 'about']);
    $routes->redirect('/about', ['controller' => 'About', 'action' => 'club']);
    $routes->connect('/about/contact', ['controller' => 'About', 'action' => 'contact'], ['_name' => 'contact']);
    $routes->connect('/about/coaches', ['controller' => 'About', 'action' => 'coaches'], ['_name' => 'coaches']);
    $routes->connect('/about/committee', ['controller' => 'About', 'action' => 'committee'], ['_name' => 'committee']);

    Router::scope('/sitemap', function (RouteBuilder $routes) {
        $routes->extensions(['xml']);
        $routes->connect('/', ['controller' => 'Sitemaps'], ['_name' => 'sitemap']);
        $routes->fallbacks('DashedRoute');
    });
    Router::scope('/robots', function (RouteBuilder $routes) {
        $routes->extensions(['txt']);
        $routes->connect('/', ['controller' => 'Sitemaps', 'action' => 'robots']);
        $routes->fallbacks('DashedRoute');
    });

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
