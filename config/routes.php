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

    $routes->connect('/admin', ['controller' => 'Admin', 'action' => 'index'], ['_name' => 'admin']);

    // Connect Admin pages
    $routes->prefix('admin', function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    });

    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login'], ['_name' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout'], ['_name' => 'logout']);
    $routes->connect('/register', ['controller' => 'Users', 'action' => 'register'], ['_name' => 'register']);
    $routes->connect('/activate', ['controller' => 'Users', 'action' => 'activateAccount'], ['_name' => 'activate']);
    $routes->connect('/reset', ['controller' => 'Users', 'action' => 'forgotPassword'], ['_name' => 'reset']);
    $routes->connect('/reset/:reset_code',
        ['controller' => 'Users', 'action' => 'resetPassword'],
        [
            'pass' => ['reset_code'],
            'reset_code' => '[\da-f]{80}',
            '_name' => 'reset_password'
        ]
    );
    $routes->scope('/user/profile', ['controller' => 'Users'], function (RouteBuilder $routes) {
        $routes->connect('/', ['action' => 'profile'], ['_name' => 'profile']);
        $routes->connect('/password', ['action' => 'changePassword'], ['_name' => 'change_password']);
        $routes->connect('/email', ['action' => 'changeEmail'], ['_name' => 'change_email']);
    });

    $routes->connect('/verify/:email_code',
        ['controller' => 'Users', 'action' => 'verifyEmailChange'],
        [
            'pass' => ['email_code'],
            'reset_code' => '[\da-f]{80}',
            '_name' => 'verify_email'
        ]
    );

    // Connect News
    $routes->scope('/news', ['controller' => 'News'], function (RouteBuilder $routes) {
        $routes->connect('/', [], ['_name' => 'news']);
        $routes->connect('/:year',
            ['action' => 'index'],
            ['pass' => ['year'],
                'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
            ]
        );
        $routes->connect('/:year/:month',
            ['action' => 'index'],
            [
                'pass' => ['year', 'month'],
                'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
                'month' => '0[1-9]|1[012]',
                '_name' => 'NewsMonthIndex'
            ]
        );
        $routes->connect('/:year/:month/:day',
            ['action' => 'index'],
            [
                'pass' => ['year', 'month', 'day'],
                'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
                'month' => '0[1-9]|1[012]',
                'day' => '0[1-9]|[12][0-9]|3[01]',
            ]
        );
        $routes->connect('/:year/:month/:day/:slug',
            ['action' => 'view'],
            [
                'pass' => ['year', 'month', 'day', 'slug'],
                'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
                'month' => '0[1-9]|1[012]',
                'day' => '0[1-9]|[12][0-9]|3[01]',
                'slug' => '[A-z0-9\-]+'
            ]
        );
    });

    // Connect Training
    $routes->scope('/training', ['controller' => 'Pages'], function (RouteBuilder $routes) {
        $routes->connect('/', ['action' => 'training'], ['_name' => 'training']);
        $routes->connect('/competition', ['action' => 'training', 'competition'], ['_name' => 'training_comp']);
        $routes->connect('/recreational', ['action' => 'training', 'recreation'], ['_name' => 'training_rec']);
        $routes->connect('/facilities', ['action' => 'training', 'facilities'], ['_name' => 'training_facilities']);
    });

    // Connect Fixtures
    $routes->scope('/fixtures', ['controller' => 'Fixtures'], function (RouteBuilder $routes) {
        $routes->connect('/', [], ['_name' => 'fixtures']);
        $routes->connect('/calendar', ['action' => 'calendar'], ['_name' => 'fixture_calendar']);
        $routes->connect('/:year/:slug',
            ['action' => 'view'],
            [
                'pass' => ['year', 'slug'],
                'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
                'slug' => '[A-z0-9\-]+'
            ]
        );
    });

    // Connect Socials
    $routes->scope('/socials', ['controller' => 'Socials'], function (RouteBuilder $routes) {
        $routes->connect('/', [], ['_name' => 'socials']);
        $routes->connect('/:year',
            ['action' => 'index'],
            [
                'pass' => ['year'],
                'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
            ]
        );
        $routes->connect('/:year/:month/',
            ['action' => 'index'],
            [
                'pass' => ['year', 'month'],
                'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
                'month' => '0[1-9]|1[012]',
                '_name' => 'SocialsMonthIndex'
            ]
        );
        $routes->connect('/:year/:month/:day',
            ['action' => 'index'],
            [
                'pass' => ['year', 'month', 'day'],
                'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
                'month' => '0[1-9]|1[012]',
                'day' => '0[1-9]|[12][0-9]|3[01]'
            ]
        );
        $routes->connect('/:year/:month/:day/:slug',
            ['action' => 'view'],
            [
                'pass' => ['year', 'month', 'day', 'slug'],
                'year' => '[12][0-9]{3}', // This *will* break in 3000-01-01, if we make it that far
                'month' => '0[1-9]|1[012]',
                'day' => '0[1-9]|[12][0-9]|3[01]',
                'slug' => '[A-z0-9\-]+'
            ]
        );
    });

    // Connect Galleries
    $routes->connect('/gallery',
        ['controller' => 'Galleries', 'action' => 'index'], ['_name' => 'gallery']
    );
    $routes->scope('/gallery/thumb', function (RouteBuilder $routes) {
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

    // Connect Kit
    $routes->scope('/kit', ['controller' => 'Kit'], function (RouteBuilder $routes) {
        $routes->connect('/', ['action' => 'index'], ['_name' => 'kit']);
        $routes->connect('/basket', ['action' => 'basket'], ['_name' => 'basket']);
        $routes->connect('/pay', ['action' => 'pay'], ['_name' => 'pay']);
        $routes->connect('/order', ['action' => 'orders'], ['_name' => 'order']);
        $routes->connect('/order/success', ['action' => 'order_complete'], ['_name' => 'order_complete']);
        $routes->connect('/order/:orderid',
            ['action' => 'vieworder'],
            [
                'pass' => ['orderid'],
                'slug' => '[0-9]+'
            ]
        );
        $routes->connect('/item/:slug',
            ['action' => 'view'],
            [
                'pass' => ['slug'],
                'slug' => '[A-z0-9\-]+',
                '_name' => 'kit_item'
            ]
        );
    });


    // Connect About
    $routes->scope('/about', ['controller' => 'About'], function (RouteBuilder $routes) {
        $routes->redirect('/', ['action' => 'club']);
        $routes->connect('/club', ['action' => 'club'], ['_name' => 'about']);
        $routes->connect('/contact', ['action' => 'contact'], ['_name' => 'contact']);
        $routes->connect('/coaches', ['action' => 'coaches'], ['_name' => 'coaches']);
        $routes->connect('/committee', ['action' => 'committee'], ['_name' => 'committee']);
    });


    $routes->scope('/sitemap', function (RouteBuilder $routes) {
        $routes->extensions(['xml']);
        $routes->connect('/', ['controller' => 'Sitemaps'], ['_name' => 'sitemap']);
        $routes->fallbacks('DashedRoute');
    });
    $routes->scope('/robots', function (RouteBuilder $routes) {
        $routes->extensions(['txt']);
        $routes->connect('/', ['controller' => 'Sitemaps', 'action' => 'robots']);
        $routes->fallbacks('DashedRoute');
    });

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
