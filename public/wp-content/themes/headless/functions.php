<?php

/**
 * Removes admin bar likns
 */
function removeAdminBarLinks() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('view-site');
    $wp_admin_bar->remove_menu('site-name');
}

add_action('wp_before_admin_bar_render', 'removeAdminBarLinks');

/**
 * Removes action rows
 */
function removeActionRows( $actions )
{
    unset( $actions['view'] );
    return $actions;
}

add_filter( 'post_row_actions', 'removeActionRows', 10, 1 );
add_filter( 'page_row_actions', 'removeActionRows', 10, 1 );

/**
 * Get ACF to return null for no data and not false
 * This also helps with GraphQL
 */
function nullify_empty($value, $post_id, $field)
{
    if (empty($value)) {
        return null;
    }

    return $value;
}

add_filter('acf/format_value/type=image', 'nullify_empty', 100, 3);
add_filter('acf/format_value/type=relationship', 'nullify_empty', 100, 3);
add_filter('acf/format_value/type=gallery', 'nullify_empty', 100, 3); 
add_filter('acf/format_value/type=repeater', 'nullify_empty', 100, 3);
