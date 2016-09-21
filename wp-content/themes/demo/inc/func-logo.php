<?php
/*
 * Enable support for custom logo.
 *
 * @since Twenty Fifteen 1.5
 */
add_theme_support( 'custom-logo', array(
    'height'      => 120,
    'width'       => 166,
    'flex-height' => true,
) );


if ( ! function_exists( 'twentyfifteen_the_custom_logo' ) ) :
    /**
     * Displays the optional custom logo.
     *
     * Does nothing if the custom logo is not available.
     *
     * @since Twenty Fifteen 1.5
     */
    function twentyfifteen_the_custom_logo() {
        if ( function_exists( 'the_custom_logo' ) ) {
            the_custom_logo();
        }
    }
endif;
/**
 * Determines whether the site has a custom logo.
 *
 * @since 4.5.0
 *
 * @param int $blog_id Optional. ID of the blog in question. Default is the ID of the current blog.
 * @return bool Whether the site has a custom logo or not.
 */
function has_custom_logo( $blog_id = 0 ) {
    if ( is_multisite() && (int) $blog_id !== get_current_blog_id() ) {
        switch_to_blog( $blog_id );
    }

    $custom_logo_id = get_theme_mod( 'custom_logo' );

    if ( is_multisite() && ms_is_switched() ) {
        restore_current_blog();
    }

    return (bool) $custom_logo_id;
}

/**
 * Returns a custom logo, linked to home.
 *
 * @since 4.5.0
 *
 * @param int $blog_id Optional. ID of the blog in question. Default is the ID of the current blog.
 * @return string Custom logo markup.
 */
function get_custom_logo( $blog_id = 0 ) {
    $html = '';

    if ( is_multisite() && (int) $blog_id !== get_current_blog_id() ) {
        switch_to_blog( $blog_id );
    }

    $custom_logo_id = get_theme_mod( 'custom_logo' );

    // We have a logo. Logo is go.
    if ( $custom_logo_id ) {
        $html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
            esc_url( home_url( '/' ) ),
            wp_get_attachment_image( $custom_logo_id, 'full', false, array(
                'class'    => 'img-responsive',
                'itemprop' => 'logo',
            ) )
        );
    }

    // If no logo is set but we're in the Customizer, leave a placeholder (needed for the live preview).
    elseif ( is_customize_preview() ) {
        $html = sprintf( '<a href="%1$s" class="custom-logo-link" style="display:none;"><img class="custom-logo"/></a>',
            esc_url( home_url( '/' ) )
        );
    }

    if ( is_multisite() && ms_is_switched() ) {
        restore_current_blog();
    }

    /**
     * Filters the custom logo output.
     *
     * @since 4.5.0
     * @since 4.6.0 Added the `$blog_id` parameter.
     *
     * @param string $html    Custom logo HTML output.
     * @param int    $blog_id ID of the blog to get the custom logo for.
     */
    return apply_filters( 'get_custom_logo', $html, $blog_id );
}

/**
 * Displays a custom logo, linked to home.
 *
 * @since 4.5.0
 *
 * @param int $blog_id Optional. ID of the blog in question. Default is the ID of the current blog.
 */
function the_custom_logo( $blog_id = 0 ) {
    echo get_custom_logo( $blog_id );
}
