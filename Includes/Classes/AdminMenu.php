<?php

namespace App\Includes\Classes;

/**
 * Admin menu class
 *
 * Class AdminMenu
 */
class AdminMenu {

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     */
    private static $_instance = null;
    protected $admin_menu = [];

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
     * @return AdminMenu An instance of the class.
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
     * @param array $item
     */
    public function register_menu_item( $item = [] ) {
        $default = [
            'route' => '',
            'label' => '',
            'permission' => '',
            'subitems' => [],
            'name' => ''
        ];
        $item = array_merge( $default, $item );
        $this->admin_menu[$item['name']] = array_merge( $default, $item );
    }

    /**
     * Register a submenu item to an
     * already registered menu item
     *
     * @param $parent_route_name
     * @param array $item
     */
    public function register_submenu_item( $parent_route_name, $item = [] ) {
        $default = [
            'route' => '',
            'label' => '',
            'permission' => '',
            'submenu' => [],
            'name' => ''
        ];

        $item = array_merge( $default, $item );
        if ( !isset( $this->admin_menu[$parent_route_name] ) ) return;
        $this->admin_menu[$parent_route_name]['submenu'][$item['name']] = $item;
    }

    /**
     * @param bool $echo
     * @return mixed
     */
    public function generate_menu( $echo = true ) {
        $admin_menu = $this->admin_menu;
        if( !$echo ) return $admin_menu;
        ?>
        <ul>
            <?php foreach ( $admin_menu as $k => $item ) {
                ?>
                <?php if( \Illuminate\Support\Facades\Auth::user()->can( $item['permission'] ) ): ?>
                    <li>
                        <a href="<?php echo route( $item['name'] ); ?>"><?php echo $item['label']; ?></a>
                        <?php if( isset( $item['submenu'] ) ) {
                            ?>
                            <ul>
                                <?php foreach ( $item['submenu'] as $k => $subitem ) : ?>
                                    <?php if( \Illuminate\Support\Facades\Auth::user()->can( $item['permission'] ) ): ?>
                                        <li><a href="<?php echo route( $subitem['name'] ); ?>"><?php echo $subitem['label']; ?></a></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                            <?php
                        } ?>
                    </li>
                <?php endif; ?>
            <?php } ?>
        </ul>
        <?php
    }

    /**
     * Create menu  item in admin menu
     *
     * @param $menu_title
     * @param $page_title
     * @param $capability
     * @param $slug
     * @param $callback
     */
    public function add_menu_page( $menu_title, $capability, $slug, $callback, $route_name = '' ) {
        //add menu item to route
        $item = [
            'method' => 'get',
            'slug' => $slug,
            'callback' => $callback,
            'name' => $route_name ? $route_name : $slug,
            'is_admin' => true,
            'middleware' => '',
            'permission' => $capability
        ];
        Router::instance()->register_route( $item );

        //register menu
        $args = [
            'route' => $route_name ? $route_name : $slug,
            'label' => $menu_title,
            'permission' => $capability,
            'submenu' => [],
            'name' => $route_name ? $route_name : $slug
        ];

        $this->register_menu_item( $args );
    }

    /**
     * Build a submenu to an already
     * registerd admin menu
     *
     * @param $parent_route_name
     * @param $menu_title
     * @param $capability
     * @param $slug
     * @param $callback
     * @param string $route_name
     */
    public function add_submenu_page( $parent_route_name, $menu_title, $capability, $slug, $callback, $route_name = '' ) {
        //add menu item to route
        $item = [
            'method' => 'get',
            'slug' => $slug,
            'callback' => $callback,
            'name' => $route_name ? $route_name : $slug,
            'is_admin' => true,
            'middleware' => '',
            'permission' => $capability
        ];
        Router::instance()->register_route( $item );

        //register menu
        $args = [
            'route' => $route_name ? $route_name : $slug,
            'label' => $menu_title,
            'permission' => $capability,
            'submenu' => [],
            'name' => $route_name ? $route_name : $slug
        ];

        $this->register_submenu_item( $parent_route_name, $args );
    }

}

function AdminMenu() {
    return AdminMenu::instance();
}

AdminMenu();