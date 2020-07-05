<?php

/**
 * @param $hook
 * @param array ...$arg
 */
function do_action( $hook, ...$arg ) {
    global $nixmo_filters;
    $args = func_get_args();
    call_user_func_array( 'apply_filters', $args );
}

/**
 * @param $hook
 * @param array ...$arg
 * @return mixed
 */
function apply_filters( $hook, ...$arg ) {
    global $nixmo_filters;
    $args = func_get_args();
    unset($args[0]);
    $return = null;

    if( isset( $args[1] ) ) {
        $return = $args[1];
    }


    if( isset( $nixmo_filters[$hook] ) ) {
        foreach ( $nixmo_filters[$hook] as $priority => $action_set ) {
            $action = $action_set[0];
            $arg_count = $action_set[1];
            $args = array_splice( $args, 0, $arg_count );
            $return = call_user_func_array( $action, $args );
        }
    }
    return $return;
}

/**
 * @param $hook
 * @param $action
 * @param int $prioity
 * @param $arg_count
 */
function add_action( $hook, $action, $prioity = 10, $arg_count ) {
    global $nixmo_filters;
    if( !isset( $nixmo_filters[$hook] ) ) $nixmo_filters[$hook] = [];
    array_splice( $nixmo_filters[$hook], $prioity, 0, [ [ $action, $arg_count ] ] );
}


/**
 * @param $hook
 * @param $action
 * @param int $prioity
 * @param $arg_count
 */
function add_filter( $hook, $action, $prioity = 10, $arg_count ) {
    global $nixmo_filters;
    if( !isset( $nixmo_filters[$hook] ) ) $nixmo_filters[$hook] = [];
    array_splice( $nixmo_filters[$hook], $prioity, 0, [ [ $action, $arg_count ] ] );
}


/**
 * Generate admin menu
 *
 * @param bool $echo
 * @return mixed
 */
function generate_admin_menu( $echo = true ) {
    global $nixmo_admin_menu;
    $admin_menu = apply_filters( 'nixmo_admin_menu', $nixmo_admin_menu );

    if( !$echo ) return $admin_menu; ?>
    <ul>
        <?php foreach ( $admin_menu as $k => $item ) { ?>
            <?php if( \Illuminate\Support\Facades\Auth::user()->can( $item['permission'] ) ): ?>
                <li>
                    <a href="<?php echo $item['route']; ?>"><?php echo $item['label']; ?></a>
                    <?php if( isset( $item['subitems'] ) ) {
                        ?>
                        <ul>
                            <?php foreach ( $item['subitems'] as $k => $subitem ) : ?>
                                <?php if( \Illuminate\Support\Facades\Auth::user()->can( $item['permission'] ) ): ?>
                                    <li><a href="<?php echo $subitem['route']; ?>"><?php echo $subitem['label']; ?></a></li>
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

function register_admin_menu( $item ) {
    global $nixmo_admin_menu;
}