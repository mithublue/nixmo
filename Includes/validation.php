<?php
/**
 * This is the place where code regarding validations,
 * rolewise validateions etc
 * are made
 */

//example
add_filter( 'ctrl_validate_store_request', function ( $rules, $request, $class ) {
    if( $class == \App\Http\Controllers\Admin\PostsController::class ) {
        //code
    }
    return $rules;
}, 10, 3 );

