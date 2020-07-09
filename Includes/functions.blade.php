<?php
//post
$args = [
    'post_type' => 'post',
    'post_status' => 'publish', //private, draft, trash
    'capability' => [
        'browse' => ['browse', \App\Post::class],
        'read' => ['read', \App\Post::class],
        'create' => ['create', \App\Post::class],
        'edit' => ['edit', \App\Post::class],
        'delete' => ['delete', \App\Post::class],
    ],
    'slug' => 'posts',
    'label' => [
        'singular' => ( 'app.Post'),
        'plural' => ( 'app.Posts')
    ],
    'show_in_menu' => true
];
\App\Includes\Classes\PostType::instance()->register_post_type( $args );

//page
$args = [
    'post_type' => 'page',
    'post_status' => 'publish', //private, draft, trash
    'capability' => [
        'browse' => ['browse', \App\Post::class],
        'read' => ['read',\App\Post::class],
        'create' => ['create',\App\Post::class],
        'edit' => ['edit',\App\Post::class],
        'delete' => ['delete',\App\Post::class],
    ],
    'slug' => 'pages',
    'label' => [
        'singular' => ( 'app.Page'),
        'plural' => ( 'app.Pages')
    ],
    'show_in_menu' => true
];
\App\Includes\Classes\PostType::instance()->register_post_type( $args );

/*\App\Includes\Classes\AdminMenu::instance()->add_menu_page( 'Posts', ['browse_posts', \App\Post::class], 'admin/posts', function () {
    return 'Admin\\PostsController@index';
}, 'posts.index');
\App\Includes\Classes\AdminMenu::instance()->add_submenu_page( 'posts.index', 'Add Post', ['create', \App\Post::class], 'admin/posts/create', function () {
    return 'Admin\\PostsController@create';
}, 'posts.create');*/
\App\Includes\Classes\Router()->register_routes([
    /*[
        'method' => 'post',
        'slug' => 'admin/posts',
        'callback' => function(){
            return 'Admin\\PostsController@store';
        },
        'name' => 'posts.store',
        'is_admin' => true,
        'middleware' => '',
        'permission' => ['create', \App\Post::class]
    ],*/
    /*[
        'method' => 'get',
        'slug' => 'admin/posts/{id}',
        'callback' => function(){
            return 'Admin\\PostsController@edit';
        },
        'name' => 'posts.read',
        'is_admin' => true,
        'middleware' => '',
        'permission' => ['read', \App\Post::class]
    ],*/
    /*[
        'method' => 'get',
        'slug' => 'admin/posts/edit/{id}',
        'callback' => function(){
            return 'Admin\\PostsController@edit';
        },
        'name' => 'posts.edit',
        'is_admin' => true,
        'middleware' => '',
        'permission' => ['edit', \App\Post::class]
    ],*/
    /*[
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
    ]*/
]);