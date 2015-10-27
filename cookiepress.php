<?php
/*
  Plugin Name: CookiePress
  Plugin URI: http://example.com
  Description: Plugin for tracking tag views using a cookie
  Author: Austin Plunkett
  Version: 0.0.1
  Author URI: http://example.com
*/

register_activation_hook(__FILE__,'cookiepress_activate');
register_uninstall_hook(__FILE__,'cookiepress_remove');

add_action('admin_init','register_my_settings');


function cookiepress_activate() {
    if (false == get_option('cookiepress_data')) { add_option('cookiepress_data'); }
}


function cookiepress_remove() { delete_option('cookiepress_data'); }


function cookiepress_get_tags_set_cookie() {
    // TODO Get cookie if it exists

    global $wp_query; 
    $postid = $wp_query->post->ID;
    echo '<!-- Got post id = ' . $postid . ' -->' . "\n";

    $posttags = get_the_tags($postid);
    $postcats = wp_get_post_categories($postid);

    $test = '';

    if ($posttags) {
        foreach($posttags as $tag) {
            // TODO generate cookie to update or set
            $test = $test . '|' . $tag;
            echo '  <!-- tag: ' . $tag . ' -->' . "\n";
        }
    } else {
        echo '  <!-- NO TAGS!! -->' . "\n";
    }

    $test = '';

    if ($postcats) {
        foreach($postcats as $c) {
            $cat = get_category($c);
            $test = $test . '|' . $cat->name;
            echo '  <!-- cat: ' . $cat->name . ' -->' . "\n";
        }
    } else {
        echo '  <!-- NO CATS!! -->' . "\n";
    }
    
    // TODO update or set cookie

}

function cookiepress_admin() {
    include('cookiepress_admin.php');
}

function cookiepress_admin_actions() {
    add_options_page("CookiePress", "CookiePress", 1, "cookiepress_options", "cookiepress_admin");
}
add_action('admin_menu', 'cookiepress_admin_actions');


/*
if ( ! function_exists('register_my_settings') ) {
    function register_my_settings() {
        register_setting('cookiepress_options','cookiepress_data');
    }
}
*/

?>
