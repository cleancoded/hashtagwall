<?php
/*
* Helper functions
* Author JD-A
*/

function dd(){
    array_map(function($x) {
    	if(function_exists('dump')){
        	dump($x); 
    	}else{
    		echo "<pre>"; var_dump($x); echo "</pre>";
    	}
    }, func_get_args());
    die;
}

function _dd(){
    array_map(function($x) {
    	if(function_exists('dump')){
        	dump($x); 
    	}else{
    		echo "<pre>"; var_dump($x); echo "</pre>";
    	}
    }, func_get_args());
}


// Create a helper function for easy SDK access.
function HW_fs() {
    global $HW_fs;

    if ( ! isset( $HW_fs ) ) {
        $HW_fs = fs_dynamic_init( array(
            'id'                  => '2928',
            'slug'                => 'hashtag-wall',
            'type'                => 'plugin',
            'public_key'          => 'pk_ea5ff0ffde1ea7c93bcd8c081f67a',
            'is_premium'          => true,
            // If your plugin is a serviceware, set this option to false.
            'has_premium_version' => true,
            'has_addons'          => false,
            'has_paid_plans'      => true,
            'trial'               => array(
                'days'               => 14,
                'is_require_payment' => false,
            ),
            'menu'                => array(
                'slug'           => 'hashtag-wall',
                'override_exact' => true,
                // 'parent'         => array(
                //     'slug' => 'options-general.php',
                // ),
            ),
            // Set the SDK to work in a sandbox mode (for development & testing).
            // IMPORTANT: MAKE SURE TO REMOVE SECRET KEY BEFORE DEPLOYMENT.
            'secret_key'          => 'sk_+~7lG7*:v]v8-KCo%Sk$#LcOV8QVN',
        ) );
    }

    return $HW_fs;
}

