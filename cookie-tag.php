<?php
/*
  Plugin Name: Cookie Tag
  Plugin URI: http://example.com
  Description: Plugin for tracking tag views using a cookie
  Author: Austin Plunkett
  Version: 0.0.1
  Author URI: http://example.com
*/

register_activation_hook(__FILE__,'cookietag_activate');
register_uninstall_hook(__FILE__,'cookietag_remove');

add_action('admin_init','register_my_settings');


function cookietag_activate() {
    if (false == get_option('cookietag_data')) { add_option('cookietag_data'); }
}


function cookietag_remove() { delete_option('cookietag_data'); }


function cookietag_get_tags_set_cookie() {
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

function cookietag_admin() {
    include('cookietag_admin.php');
}

function cookietag_admin_actions() {
    add_options_page("Cookie Tag", "Cookie Tag", 1, "cookietag_options", "cookietag_admin");
}
add_action('admin_menu', 'cookietag_admin_actions');


/*
if ( ! function_exists('register_my_settings') ) {
    function register_my_settings() {
        register_setting('cookietag_options','cookietag_data');
    }
}
*/

?>
