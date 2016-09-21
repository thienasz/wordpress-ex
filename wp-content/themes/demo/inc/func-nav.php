<?php
// This theme uses wp_nav_menus() in two locations.
register_nav_menus( array(
    'top-menu' => 'For top menu',
    'main-menu' => 'For main menu',
) );

function get_normal_menu($name = "top-menu") {
     if ( has_nav_menu( $name ) ) :
        // Social links navigation menu.
         wp_nav_menu( array(
             'theme_location' => $name,
             'depth'          => 1,
             'menu_class'   => 'list-inline pull-right', //ul
             'container'      => '' //nav
         ) );
     endif;
}
require_once('wp_bootstrap_navwalker.php');
function get_walker_menu($name = "main-menu") {
    if ( has_nav_menu( $name ) ) :
        wp_nav_menu( array(
                'menu'              => $name,
                'depth'             => 3,
                'container'         => '',
                'container_class'   => 'k-main-navig',
                'menu_class'        => 'k-dropdown-menu',
                'menu_id'           => 'drop-down-left',
                'walker'            => new wp_cus_navwalker())
        );
    endif;
}