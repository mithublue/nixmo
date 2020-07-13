<?php

namespace App\Includes\Classes;

/**
 * Class Meta
 * @package App\Includes\Classes
 */
class Meta {

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     */
    private static $_instance = null;
    protected $metaboxes = [];

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
     * @return Meta An instance of the class.
     */
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

    public function __construct() {
        add_action( 'render_metaboxes', [ $this, 'render_metaboxes' ], 10, 2);
    }


    /**
     * Add metabox to the array
     *
     * @param string $id
     * @param null $title
     * @param null $callback
     * @param array $screen
     * @param null $context
     * @param string $pririty
     * @param array $callback_args
     */
    public function add_metabox( $id = '', $title = null, $callback = null, $screen = [], $context = 'advanced', $pririty = 'default', $callback_args = [] ) {
        $metabox_arg = [
            'id' => $id,
            'title' => $title,
            'callback' => $callback,
            'screen' => $screen,
            'context' => $context,
            'priority' => $pririty,
            'callback_args' => $callback_args
        ];

        $this->metaboxes[$context][$id] = $metabox_arg;
    }

    /**
     * Render metaboxes with data
     *
     * @param $context
     */
    public function render_metaboxes( $context, $item  ) {

        if( !isset( $this->metaboxes[$context] ) ) return;
        $metaboxes = $this->metaboxes[$context];

        foreach ( $metaboxes as $id => $metabox ) {
            ?>
            <div id="<?php echo $id; ?>">
                <div>
                    <h4><?php echo $metabox['title']; ?></h4>
                    <?php $metabox['callback']( $item ); ?>
                </div>
            </div>
        <?php
        }
    }

    /**
     * Update or set meta for an item
     *
     * @param string $module post_type, user, term, comment
     * @param $item_id
     * @param $meta_key
     * @param $meta_value
     */
    public function update_meta( $module = 'post_type', $item, $meta_key, $meta_value ) {
        if( !is_int( $item ) ) {
            $item->setMeta( $meta_key, $meta_value );
        }
    }

}