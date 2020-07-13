<?php
/**
 * Code regaring fillable fields
 * will be here
 */

//example
add_filter( 'model-fillable_fields', function ( $fillable, $class ) {
    if( $class == \App\User::class ) {
        //code
    }
    return $fillable;
}, 10, 2 );

/**
 * Set meta filleable for test field. Without it
 * the custom meta field won't be saved
 */
add_filter( 'model-metaFillable_fields', function ( $metaFillable, $class ) {
    if( $class == \App\Post::class ) {
        //code
        array_push( $metaFillable, 'test');
    }
    return $metaFillable;
}, 10, 2 );