<?php
function get_search_form_cus( $echo = true ) {
    /**
     * Fires before the search form is retrieved, at the start of get_search_form().
     *
     * @since 2.7.0 as 'get_search_form' action.
     * @since 3.6.0
     *
     * @link https://core.trac.wordpress.org/ticket/19321
     */
    do_action( 'pre_get_search_form' );

    $format = current_theme_supports( 'html5', 'search-form' ) ? 'html5' : 'xhtml';

    /**
     * Filters the HTML format of the search form.
     *
     * @since 3.6.0
     *
     * @param string $format The type of markup to use in the search form.
     *                       Accepts 'html5', 'xhtml'.
     */
    $format = apply_filters( 'search_form_format', $format );

    $search_form_template = locate_template( 'searchform.php' );
    if ( '' != $search_form_template ) {
        ob_start();
        require( $search_form_template );
        $form = ob_get_clean();
    } else {
        if ( 'html5' == $format ) {
            $form = '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '" id="top-searchform"  role="search">
                        <div class="input-group">
                            <input type="search"  value="' . get_search_query() . '" name="s"  id="sitesearch" class="search-field form-control" autocomplete="off" placeholder="Type in keyword(s) then hit Enter on keyboard" />
                        </div>
                    </form>';
        } else {
            $form = '<form role="search" method="get" class="searchform" action="' . esc_url( home_url( '/' ) ) . '" id="top-searchform"  role="search">
                        <div class="input-group">
                            <input type="text"  value="' . get_search_query() . '" name="s"  id="s" class="search-field form-control" autocomplete="off" placeholder="Type in keyword(s) then hit Enter on keyboard" />
                        </div>
                    </form>';
        }

        $form .= '<div id="bt-toggle-search" class="search-icon text-center"><i class="s-open fa fa-search"></i><i class="s-close fa fa-times"></i></div>';
    }

    /**
     * Filters the HTML output of the search form.
     *
     * @since 2.7.0
     *
     * @param string $form The search form HTML output.
     */
    $result = apply_filters( 'get_search_form', $form );

    if ( null === $result )
        $result = $form;

    if ( $echo )
        echo $result;
    else
        return $result;
}