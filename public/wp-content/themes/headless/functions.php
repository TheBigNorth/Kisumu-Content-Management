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