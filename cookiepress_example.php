<?php
require_once(dirname(__FILE__) . '/../../../wp-load.php');
?>
<html>
  <head>
    <style>
      table, td { border: 1px solid grey; }
      table { border-spacing: 0; border-collapse: collapse; }
      td { padding: 3px; }
      thead { background-color: silver; font-weight: bold; }
    </style>
  </head>
  <body>
    <h2>CookiePress example</h2>

    <p>
      Categories:
    </p>
    <p>
      <table>
        <thead>
          <tr>
	        <td>ID</td>
	        <td>Name</td>
	        <td>Number of views</td>
          </tr>
        </thead>
        <tbody>

<?php
$cats = array();
if (isset($_COOKIE['cookiepress-cats'])) {
    $j = json_decode(stripslashes($_COOKIE['cookiepress-cats']), true);
    foreach ($j as $k => $v) {
        $cats[$k] = $v;
        echo '<tr>' . "\n";
        echo '<td>' . $k . '</td>' . "\n";
        $name = get_cat_name($k);
        echo '<td>' . $name . '</td>' . "\n";
        echo '<td>' . $v . '</td>' . "\n";
        echo '</tr>' . "\n";
    }
} else {
    echo '<tr><td colspan="3">No categories found!</td></tr>' . "\n";
}

?>
        </tb>
      </table>
    </p>

    <p>
      Tags:
    </p>
    <p>
      <table>
        <thead>
          <tr>
	        <td>ID</td>
	        <td>Name</td>
	        <td>Number of views</td>
          </tr>
        </thead>
        <tbody>

<?php
$tags = array();
if (isset($_COOKIE['cookiepress-tags'])) {
    $j = json_decode(stripslashes($_COOKIE['cookiepress-tags']), true);
    foreach ($j as $k => $v) {
        $tags[$k] = $v;
        echo '<tr>' . "\n";
        echo '<td>' . $k . '</td>' . "\n";
        $name = get_tag($k)->name;
        echo '<td>' . $name . '</td>' . "\n";
        echo '<td>' . $v . '</td>' . "\n";
        echo '</tr>' . "\n";
    }
} else {
    echo '<tr><td colspan="3">No tags found!</td></tr>' . "\n";
}

?>
        </tb>
      </table>
    </p>

  </body>
</html>

