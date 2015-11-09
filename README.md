# CookiePress

A Wordpress plugin that uses cookies to track the tags and categories that users view when they browse posts.

## Installation

```bash
wget https://raw.githubusercontent.com/austinjp/cookiepress/master/cookiepress.php -O- > /path/to/wordpress/wp-content/plugins
```

Then enable the plugin in the Wordpress plugins console.

To start setting cookies, try adding something like the following into your theme's `header.php` file after the `<head>` tag:

```php
<!-- begin cookiepress -->
<?php
    if(function_exists('cookiepress')) {
        cookiepress();
    }
?>
<!-- end cookiepress -->

```