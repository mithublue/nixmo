<?php

namespace App\Includes\Classes;

use App\Post;

class Taxonomy {

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     */
    private static $_instance = null;
    public $taxonomies = [];

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
     * @return Taxonomy An instance of the class.
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
     * Register new taxonomy
     *
     * @param array $args
     */
    public function register_taxonomy( $tax, $post_type, $args = [] ) {
        $args = array_merge( [
            'hierarchical'          => false,
            'labels'                => [
                'singular' => '',
                'plural' => ''
            ],
            //'show_ui'               => true,
            //'show_admin_column'     => true,
            //'update_count_callback' => '_update_post_term_count',
            //'query_var'             => true,
            //'rewrite'               => array( 'slug' => 'writer' ),
            'capability' => [
                'browse' => ['browse', Post::class],
                'read' => ['read', Post::class],
                'create' => ['create', Post::class],
                'edit' => ['edit', Post::class],
                'delete' => ['delete', Post::class],
            ],
        ], $args );

        $this->taxonomies[$post_type] = $args;
        $capabilities = $args['capability'];
        $slug_part = 'admin/taxonomies/'.$tax;
        $route_name = [
            'browse' => 'tax.'.$tax.'.browse',
            'read' => 'tax.'.$tax.'.read',
            'create' => 'tax.'.$tax.'.create',
            'edit' => 'tax.'.$tax.'.edit',
            'store' => 'tax.'.$tax.'.store',
            'update' => 'tax.'.$tax.'.update',
            'delete' => 'tax.'.$tax.'.delete',
        ];

        //add menu and submenu page
        /*AdminMenu::instance()->add_menu_page( $args['label']['plural'], $capabilities['browse'], 'admin/'.$args['slug'].'/'.$args['post_type'], function () {
            return 'Admin\\PostsController@index';
        }, $route_name['browse'] );*/
        AdminMenu::instance()->add_submenu_page( PostType::instance()->get_post_type_routes( $post_type, 'browse' ), $args['labels']['singular'], $capabilities['browse'], $slug_part, function () {
            return 'Admin\\TaxonomiesController@index';
        }, $route_name['browse']);

        //register routes
        $routes = [
            [
                'method' => 'post',
                'slug' => $slug_part,
                'callback' => function(){
                    return 'Admin\\TaxonomiesController@store';
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
                    return 'Admin\\TaxonomiesController@show';
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
                    return 'Admin\\TaxonomiesController@edit';
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
                    return 'Admin\\TaxonomiesController@update';
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
                    return 'Admin\\TaxonomiesController@destroy';
                },
                'name' => $route_name['delete'],
                'is_admin' => true,
                'middleware' => '',
                'permission' => ['delete', \App\Post::class]
            ]
        ];
        Router::instance()->register_routes( $routes );
    }
}

function Taxonomy() {
    return Taxonomy::instance();
}

Taxonomy();