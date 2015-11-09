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
#        echo '<!-- Got post id = ' . $postid . ' -->' . "\n";

        # TODO IS this approach worth considering?
        # $postcats = get_term_by('id', $postid, 'category');
        # $posttags = get_term_by('id', $postid, 'post_tag');

        $posttags = get_the_tags($postid);
        $postcats = wp_get_post_categories($postid);

        
        // We all start with nothing:
        $tags = array();
        $cats = array();


        // First, read the cookies for categories and tags:
        if (isset($_COOKIE['cookiepress-cats'])) {
#            echo '<!-- Existing cookie contents for categories:' . "\n";
            $j = json_decode(stripslashes($_COOKIE['cookiepress-cats']), true);
            foreach ($j as $k => $v) {
#                echo '  cat: ' . $k . ' = ' . $v . "\n";
                $cats[$k] = $v;
            }
#            echo '-->' . "\n";
        }

        if (isset($_COOKIE['cookiepress-tags'])) {
#            echo '<!-- Existing cookie contents for tags:' . "\n";
            $j = json_decode(stripslashes($_COOKIE['cookiepress-tags']), true);
            foreach ($j as $k => $v) {
#                echo '  tag: ' . $k . ' = ' . $v . "\n";
                $tags[$k] = $v;
            }
#            echo '-->' . "\n";
        }


        if ($postcats) {
            foreach($postcats as $cat_id) {
                $cat = get_category($cat_id);
                $cats[$cat_id]++;
            }
        } else {
#            echo '  <!-- NO CATS!! -->' . "\n";
        }
        $cats = json_encode($cats);
#        echo '<!-- Cookie for categories will now contain:' . "\n";
#        echo '  ' . $cats . "\n-->\n\n";

        if ($posttags) {
            foreach($posttags as $pt) {
                $pt_id = $pt->term_id;
                $tags[$pt_id]++;
            }
        } else {
#            echo '  <!-- NO TAGS!! -->' . "\n";
        }
        $tags = json_encode($tags);
#        echo '<!-- Cookie for tags will now contain:' . "\n";
#        echo '  ' . $tags . "\n-->\n\n";



        // Update or set cookie
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
