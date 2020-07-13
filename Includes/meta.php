<?php
\App\Includes\Classes\Meta::instance()->add_metabox( 'test-meta', 'Test Meta', 'test_add_meta', 'post', 'normal', 'high', []);
function test_add_meta( $item ) {
    ?>
    <label for="">Test</label>
    <input type="text"
           name="test"
           value="<?php echo $item->getMeta('test'); ?>">
<?php
}