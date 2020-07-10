<?php

namespace App\Includes\Classes;

use App\Http\Controllers\Admin\PostsController;
use App\Post;

/**
 * Class PostType
 * @package App\Includes\Classes
 */
class PostType {

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     */
    private static $_instance = null;
    public $post_types = [];

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
     * @return PostType An instance of the class.
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
     * Register new post type
     *
     * @param array $args
     */
    public function register_post_type( $args = [] ) {
         $args = array_merge( [
             'post_type' => 'post',
             'post_status' => 'publish', //private, draft, trash
             'capability' => [
                 'browse' => ['browse', Post::class],
                 'read' => ['read', Post::class],
                 'create' => ['create', Post::class],
                 'edit' => ['edit', Post::class],
                 'delete' => ['delete', Post::class],
             ],
             'slug' => 'posts',
             'label' => [
                 'singular' => ( 'app.Post'),
                 'plural' => ( 'app.Posts')
             ],
             'show_in_menu' => true
         ], $args );

         //override for noe
        $args['slug'] = 'posts';
        $capabilities = $args['capability'];
        $route_name = [
            'browse' => 'posts.'.$args['post_type'].'.browse',
            'read' => 'posts.'.$args['post_type'].'.read',
            'create' => 'posts.'.$args['post_type'].'.create',
            'edit' => 'posts.'.$args['post_type'].'.edit',
            'store' => 'posts.'.$args['post_type'].'.store',
            'update' => 'posts.'.$args['post_type'].'.update',
            'delete' => 'posts.'.$args['post_type'].'.delete',
        ];
        $args['route_names'] = $route_name;
        $this->post_types[ $args['post_type'] ] = $args;

         //add menu and submenu page
        AdminMenu::instance()->add_menu_page( $args['label']['plural'], $capabilities['browse'], 'admin/'.$args['slug'].'/'.$args['post_type'], function () {
            return 'Admin\\PostsController@index';
        }, $route_name['browse'] );
        AdminMenu::instance()->add_submenu_page( $route_name['browse'], 'Create '.$args['label']['singular'], $capabilities['browse'], 'admin/'.$args['slug'].'/'.$args['post_type'].'/create', function () {
            return 'Admin\\PostsController@create';
        }, $route_name['create']);

         //register routes
        $slug_part = 'admin/posts/'.$args['post_type'];
        $routes = [
            [
                'method' => 'post',
                'slug' => $slug_part,
                'callback' => function(){
                    return 'Admin\\PostsController@store';
                },
                'name' => $route_name['store'],
                'is_admin' => true,
                'middleware' => '',
                'permission' => ['create', \App\Post::class]
            ],
            [
                'method' => 'get',
                'slug' => $slug_part.'/{id}',
                'callback' => function(){
                    return 'Admin\\PostsController@show';
                },
                'name' => $route_name['read'],
                'is_admin' => true,
                'middleware' => '',
                'permission' => ['read', \App\Post::class]
            ],
            [
                'method' => 'get',
                'slug' => $slug_part.'/edit/{id}',
                'callback' => function(){
                    return 'Admin\\PostsController@edit';
                },
                'name' => $route_name['edit'],
                'is_admin' => true,
                'middleware' => '',
                'permission' => ['edit', \App\Post::class]
            ],
            [
                'method' => 'patch',
                'slug' => $slug_part.'/edit/{id}',
                'callback' => function(){
                    return 'Admin\\PostsController@update';
                },
                'name' => $route_name['update'],
                'is_admin' => true,
                'middleware' => '',
                'permission' => ['edit', \App\Post::class]
            ],
            [
                'method' => 'delete',
                'slug' => $slug_part.'/delete/{id}',
                'callback' => function(){
                    return 'Admin\\PostsController@destroy';
                },
                'name' => $route_name['delete'],
                'is_admin' => true,
                'middleware' => '',
                'permission' => ['delete', \App\Post::class]
            ]
        ];
        Router::instance()->register_routes( $routes );
    }

    /**
     * @param $model
     * @param string $post_type
     * @return mixed
     */
    public function get_model( $model, $post_type = 'post' ) {
        return $model::where( 'post_type', $post_type );
    }

    /**
     * Return post type based on the name
     *
     * @param $post_type
     * @return bool|mixed
     */
    public function get_post_type( $post_type ) {
        if( isset( $this->post_types[$post_type] ) ) {
            return $this->post_types[$post_type];
        }
        return false;
    }

    /**
     * Return specific route of post type
     *
     * @param null $post_type
     * @param null $action
     * @return bool
     */
    public function get_post_type_routes( $post_type = null, $action = null ) {
        if( isset( $this->post_types[$post_type] ) ) {
            if( $action && isset( $this->post_types[$post_type]['route_names'][$action] ) ) {
                return $this->post_types[$post_type]['route_names'][$action];
            } elseif ( !$action ) {
                return $this->post_types[$post_type]['route_names'];
            }
        }
        return false;
    }
}

function PostTytpe() {
    return PostType::instance();
}

PostTytpe();