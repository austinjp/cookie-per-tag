<?php
/*
  Plugin Name: CookiePress
  Plugin URI: http://github.com/austinjp/cookiepress
  Description: Plugin for tracking tag views using a cookie
  Author: Austin Plunkett
  Version: 0.0.1
  Author URI: http://github.com/austinjp
*/

register_activation_hook(__FILE__,'cookiepress_activate');
register_uninstall_hook(__FILE__,'cookiepress_remove');

add_action('admin_init','register_my_settings');


function cookiepress_activate() {
    if (false == get_option('cookiepress_data')) { add_option('cookiepress_data'); }
}


function cookiepress_remove() { delete_option('cookiepress_data'); }


function cookiepress_get_tags_set_cookie() {

    global $wp_query; 
    $postid = $wp_query->post->ID;

    if ($postid) {
        echo '<!-- Got post id = ' . $postid . ' -->' . "\n";
        
        $posttags = get_the_tags($postid);
        $postcats = wp_get_post_categories($postid);
        
        // TODO Get cookie if it exists
        $tags = array(
            "tag1" => 1,
            "tag2" => 99,
            "tag3" => 0
        );

        if ($posttags) {
            foreach($posttags as $tag) {
                $tags[$tag]++;
                echo '  <!-- tag: ' . $tags[$tag] . ' -->' . "\n";
            }
        } else {
            echo '  <!-- NO TAGS!! -->' . "\n";
        }
        $tags = json_encode($tags);


        // TODO Complete this chunk:
        $cats = array();
        if (isset($_COOKIE['cookiepress-cats'])) {
            $j = json_decode(stripslashes($_COOKIE['cookiepress-cats']), true);
            foreach ($j as $k => $v) {
                echo '    <!-- Cookie:tag: ' . $k . ' = ' . $v . ' -->' . "\n";
            }
        }


        if ($postcats) {
            foreach($postcats as $c) {
                $cat = get_category($c);
                $cats[$cat->name]++; // TODO Use ID not name
                echo '  <!-- cat: ' . $cat->name . ' -->' . "\n";
            }
        } else {
            echo '  <!-- NO CATS!! -->' . "\n";
        }
        $cats = json_encode($cats);

        // TODO update or set cookie
        setcookie(
            'cookiepress-tags',
            $tags,
            time()+360,
            COOKIEPATH,
            COOKIE_DOMAIN
        );
        setcookie(
            'cookiepress-cats',
            $cats,
            time()+360,
            COOKIEPATH,
            COOKIE_DOMAIN
        );

    } // if $postid

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
