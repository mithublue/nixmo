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

         $this->post_types[ $args['post_type'] ] = $args;

         $capabilities = $args['capability'];
         $route_name = [
           'index' => $args['slug'].'.index',
           'create' => $args['slug'].'.create',
           'edit' => $args['slug'].'.edit',
           'store' => $args['slug'].'.store',
           'update' => $args['slug'].'.update',
           'delete' => $args['slug'].'.delete',
         ];

         //add menu and submenu page
        AdminMenu::instance()->add_menu_page( $args['label']['plural'], $capabilities['browse'], 'admin/'.$args['slug'], function () {
            return 'Admin\\PostsController@index';
        }, $route_name['index'] );
        AdminMenu::instance()->add_submenu_page( $route_name['index'], 'Create '.$args['label']['singular'], $capabilities['browse'], 'admin/'.$args['slug'].'/create', function () {
            return 'Admin\\PostsController@create';
        }, $route_name['create']);

         //register routes
        $routes = [
            [
                'method' => 'post',
                'slug' => 'admin/posts',
                'callback' => function(){
                    return 'Admin\\PostsController@store';
                },
                'name' => 'posts.store',
                'is_admin' => true,
                'middleware' => '',
                'permission' => ['create', \App\Post::class]
            ],
            [
                'method' => 'get',
                'slug' => 'admin/posts/{id}',
                'callback' => function(){
                    return 'Admin\\PostsController@edit';
                },
                'name' => 'posts.read',
                'is_admin' => true,
                'middleware' => '',
                'permission' => ['read', \App\Post::class]
            ],
            [
                'method' => 'get',
                'slug' => 'admin/posts/edit/{id}',
                'callback' => function(){
                    return 'Admin\\PostsController@edit';
                },
                'name' => 'posts.edit',
                'is_admin' => true,
                'middleware' => '',
                'permission' => ['edit', \App\Post::class]
            ],
            [
                'method' => 'patch',
                'slug' => 'admin/posts/edit/{id}',
                'callback' => function(){
                    return 'Admin\\PostsController@update';
                },
                'name' => 'posts.update',
                'is_admin' => true,
                'middleware' => '',
                'permission' => ['edit', \App\Post::class]
            ],
            [
                'method' => 'delete',
                'slug' => 'admin/posts/delete/{id}',
                'callback' => function(){
                    return 'Admin\\PostsController@destroy';
                },
                'name' => 'posts.destroy',
                'is_admin' => true,
                'middleware' => '',
                'permission' => ['delete', \App\Post::class]
            ]
        ];
        Router::instance()->register_routes( $routes );
    }
}

function PostTytpe() {
    return PostType::instance();
}

PostTytpe();