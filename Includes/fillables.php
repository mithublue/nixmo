<?php
/**
 * Code regaring fillable fields
 * will be here
 */

//example
add_filter( 'model_form_fillable_fields', function ( $fillable, $class ) {
    if( $class == \App\User::class ) {
        //code
    }
    return $fillable;
}, 10, 2 );