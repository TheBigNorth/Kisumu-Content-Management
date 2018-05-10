<?php

/**
 * Redirects the url to the subfolder that the WordPress core has been moved to
 */
add_filter('network_admin_url', function($url, $path) {
    $networkPath = str_replace( '/wp-admin/', WP_ADMIN_DIR . '/wp-admin/', $url );
    return $networkPath;
}, 10, 2);
