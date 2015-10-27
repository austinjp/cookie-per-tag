<?php
  /*
    Plugin Name: Cookie Tag
    Plugin URI: http://example.com
    Description: Plugin for tracking tag views using a cookie
    Author: Austin Plunkett
    Version: 0.0.1
    Author URI: http://example.com
  */

function cookietag_get_tags_set_cookie() {
  // TODO Get cookie if it exists
  $posttags = get_the_tags();
  if ($posttags) {
    foreach($posttags as $tag) {
      // TODO generate cookie to update or set
    }
    // TODO update or set cookie
  }
}

function cookietag_admin() {
  include('cookietag_admin.php');
}

function cookietag_admin_actions() {
  add_options_page("Cookie Tag", "Cookie Tag", 1, "Cookie Tag", "cookietag_admin");
}
add_action('admin_menu', 'cookietag_admin_actions');

?>
