<?php

namespace App\Includes\Classes;

use Illuminate\Support\Facades\Route;

class Router {

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     */
    private static $_instance = null;
    public $routes = [];

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     *
     * @access public
     * @static
     *
     * @return Router An instance of the class.
     */
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

    public function __construct() {
    }

    /**
     * Regiter single route
     *
     * @param array $route
     */
    public function register_route( $route = [] ) {
        $route = array_merge([
            'method' => 'get',
            'slug' => '',
            'callback' => function(){},
            'name' => '',
            'is_admin' => true,
            'middleware' => '',
            'permission' => []
        ],$route);
        $this->routes[$route['name'] ? $route['name'] : $route['slug'] ] = $route;
    }

    /**
     * Register multiple routes
     *
     * @param array $rotues
     */
    public function register_routes( $rotues = [] ) {
        foreach ( $rotues as $k => $rotue ) {
            $this->register_route( $rotue );
        }
    }

    /**
     * Build registered routes
     */
    public function build_routes() {
        //build admin routes
        add_action( 'admin_web_routes-web.php', function () {

            foreach ( $this->routes as $route_name => $route ) {
                if( !$route['is_admin'] ) continue;
                //if( !can( $route['capability']  ) ) continue;
                $method = $route['method'];
                Route::$method( $route['slug'], $route['callback']() )->name( $route_name );
            }
        },10, 1 );

        //build general routes
        add_action( 'public_web_routes-web.php', function () {
            //dd($this->routes);
            foreach ( $this->routes as $route_name => $route ) {
                if( $route['is_admin'] ) continue;
                //if( !can( $route['capability']  ) ) continue;
                $method = $route['method'];
                Router::$method( $route['slug'], $route['callback']() )->name( $route_name );
            }
        },10, 1 );
    }

    /**
     * @param null $action
     * @param null $id
     * @param null $module
     * @param null $post_type
     * @return string
     */
    public function get_route( $action = null, $id = null, $module = null, $post_type = null ) {
        $route_item = null;
        if( $module && $post_type ) {
            $action = !$action ? 'browse' : $action;
            switch ( $module ) {
                case 'post_type':
                    if( isset( $this->routes['posts.'.$post_type.'.'.$action ] ) )
                        $route_item = $this->routes['posts.'.$post_type.'.'.$action ];
                    break;
                default:
                    break;
            }
        }

        $args = [];

        if( $id ) {
            $args['id'] = $id;
        }

        $route = route( $route_item['name'], $args);
        return $route;
    }
}

function Router() {
    Router::instance()->build_routes();
    return Router::instance();
}

Router();