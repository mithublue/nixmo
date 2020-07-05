<?php
include_once dirname(__FILE__).'/helpers.blade.php';

foreach ( glob(dirname(__FILE__).'/Classes/*.php') as $filename) {
    include $filename;
}


//include routes
include_once dirname(__FILE__) . '/routes.php';

//code
include_once dirname(__FILE__) . '/functions.blade.php';

//control validation codes
include_once dirname(__FILE__) . '/validation.php';

//code to control fillable form fields
include_once dirname(__FILE__) . '/fillables.php';

//include plugin files
foreach ( glob( dirname(__FILE__).'/Content/plugins/*' ) as $dir ) {
    include $dir.'/init.php';
}