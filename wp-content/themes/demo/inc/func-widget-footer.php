<?php
function demo_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Footer Col 1', 'vega' ),
        'id'            => 'footer_1',
        'description'   => __( 'Add widgets here to appear in the first column of the footer.', 'vega' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="title-widget">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer Col 2', 'vega' ),
        'id'            => 'footer_2',
        'description'   => __( 'Add widgets here to appear in the second column of the footer.', 'vega' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="title-widget">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer Col 3', 'vega' ),
        'id'            => 'footer_3',
        'description'   => __( 'Add widgets here to appear in the third column of the footer.', 'vega' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="title-widget">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer Col 4', 'vega' ),
        'id'            => 'footer_4',
        'description'   => __( 'Add widgets here to appear in the fourth column of the footer.', 'vega' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="title-widget">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'demo_widgets_init' );

if ( ! function_exists( 'demon_wp_get_col_class' ) ) :
    function demon_wp_get_col_class($n){
        switch($n){
            case 1: return 'col-md-12'; break;
            case 2: return 'col-md-6'; break;
            case 3: return 'col-md-4'; break;
            case 4: return 'col-md-3'; break;
        }
    }
endif;


function get_demo_widget() {
    ?>
    <?php

    if ( is_active_sidebar( 'footer_1' ) || is_active_sidebar( 'footer_2' ) || is_active_sidebar( 'footer_3' ) || is_active_sidebar( 'footer_4' ) ) { ?>
        <!-- ========== Footer Widgets ========== -->
        <div id="k-footer">
            <div class="container">
                <div class="row no-gutter">
                    <?php
                    $i=0;
                    if(is_active_sidebar( 'footer_1' )) $i++;
                    if(is_active_sidebar( 'footer_2' )) $i++;
                    if(is_active_sidebar( 'footer_3' )) $i++;
                    if(is_active_sidebar( 'footer_4' )) $i++;
                    $class = demon_wp_get_col_class($i);
                    ?>
                    <?php if ( is_active_sidebar( 'footer_1' ) ) : ?>
                        <!-- Footer Col 1 -->
                        <div class="<?php echo $class ?> footer-widget footer-widget-col-1 wow">
                            <?php dynamic_sidebar( 'footer_1' ); ?>
                        </div>
                        <!-- /Footer Col 1 -->
                    <?php endif; ?>

                    <?php if ( is_active_sidebar( 'footer_2' ) ) : ?>
                        <!-- Footer Col 2 -->
                        <div class="<?php echo $class ?> footer-widget footer-widget-col-2 wow">
                            <?php dynamic_sidebar( 'footer_2' ); ?>
                        </div>
                        <!-- /Footer Col 2 -->
                    <?php endif; ?>

                    <?php if ( is_active_sidebar( 'footer_3' ) ) : ?>
                        <!-- Footer Col 3 -->
                        <div class="<?php echo $class ?> footer-widget footer-widget-col-3 wow" >
                            <?php dynamic_sidebar( 'footer_3' ); ?>
                        </div>
                        <!-- /Footer Col 3 -->
                    <?php endif; ?>

                    <?php if ( is_active_sidebar( 'footer_4' ) ) : ?>
                        <!-- Footer Col 4 -->
                        <div class="<?php echo $class ?> footer-widget footer-widget-col-4 wow" >
                            <?php dynamic_sidebar( 'footer_4' ); ?>
                        </div>
                        <!-- /Footer Col 4 -->
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <!-- ========== /Footer Widgets ========== -->
    <?php }
    else {
        //set default
    }
    ?>

    <?php
}

/**
 * Core class used to implement a Pages widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class WP_Widget_Address extends WP_Widget {

    /**
     * Sets up a new Pages widget instance.
     *
     * @since 2.8.0
     * @access public
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'col-padded col-naked',
            'description' => __( 'A list of your site&#8217;s Pages.' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( 'Address', __( 'Address' ), $widget_ops );
    }

    /**
     * Outputs the content for the current Pages widget instance.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Pages widget instance.
     */
    public function widget( $args, $instance ) {
        /**
         * Filters the widget title.
         *
         * @since 2.6.0
         *
         * @param string $title    The widget title. Default 'Pages'.
         * @param array  $instance An array of the widget's settings.
         * @param mixed  $id_base  The widget ID.
         */
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Pages' ) : $instance['title'], $instance, $this->id_base );

        $sortby = empty( $instance['sortby'] ) ? 'menu_order' : $instance['sortby'];
        $exclude = empty( $instance['exclude'] ) ? '' : $instance['exclude'];

        if ( $sortby == 'menu_order' )
            $sortby = 'menu_order, post_title';

        /**
         * Filters the arguments for the Pages widget.
         *
         * @since 2.8.0
         *
         * @see wp_list_pages()
         *
         * @param array $args An array of arguments to retrieve the pages list.
         */
        $out = wp_list_pages( apply_filters( 'widget_pages_args', array(
            'title_li'    => '',
            'echo'        => 0,
            'sort_column' => $sortby,
            'exclude'     => $exclude
        ) ) );

        if ( ! empty( $out ) ) {
            echo $args['before_widget'];
            if ( $title ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }
            ?>
            <div class="demo-address">
                <?php if($instance['name_address']) ?>
                <h2 class="title-median m-contact-subject" itemprop="name"><?= $instance['name_address'] ?></h2>

                <div class="m-contact-address" class="address">
                <?php if($instance['address_1']) ?>
                    <span class="m-contact-street" itemprop="street-address"><?= $instance['address_1'] ?></span>
                <?php if($instance['address_2']) ?>
                    <span class="m-contact-city-region"><span class="m-contact-city" itemprop="locality"><?= $instance['address_2'] ?></span></span>
                <?php if($instance['address_3']) ?>
                    <span class="m-contact-zip-country"><span class="m-contact-zip" itemprop="postal-code"><?= $instance['address_3'] ?></span></span>
                </div>

                <div class="m-contact-tel-fax">
                <?php if($instance['tel']) ?>
                    <span class="m-contact-tel">Tel: <span itemprop="tel"><?= $instance['tel'] ?></span></span>
                <?php if($instance['fax']) ?>
                    <span class="m-contact-fax">Fax: <span itemprop="fax"><?= $instance['fax'] ?></span></span>
                </div>

            </div>
            <?php
            echo $args['after_widget'];
        }
    }

    /**
     * Handles updating settings for the current Pages widget instance.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Updated settings to save.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['name_address'] = sanitize_text_field( $new_instance['name_address'] );
        $instance['address_1'] = sanitize_text_field( $new_instance['address_1'] );
        $instance['address_2'] = sanitize_text_field( $new_instance['address_2'] );
        $instance['address_3'] = sanitize_text_field( $new_instance['address_3'] );
        $instance['tel'] = sanitize_text_field( $new_instance['tel'] );
        $instance['fax'] = sanitize_text_field( $new_instance['fax'] );

        return $instance;
    }

    /**
     * Outputs the settings form for the Pages widget.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $instance Current settings.
     */
    public function form( $instance ) {
        //Defaults
        //$instance = wp_parse_args( (array) $instance, array( 'name_address' => 'address_1', 'address_2' => '', 'address_3' => '') );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'name_address' ) ); ?>"><?php _e( 'Name Address:' ); ?></label>
            <input type="text" value="<?php echo esc_attr( $instance['name_address'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name_address' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'name_address' ) ); ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'address_1' ) ); ?>"><?php _e( 'address_1:' ); ?></label>
            <input type="text" value="<?php echo esc_attr( $instance['address_1'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address_1' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'address_1' ) ); ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'address_2' ) ); ?>"><?php _e( 'address_2:' ); ?></label>
            <input type="text" value="<?php echo esc_attr( $instance['address_2'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address_2' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'address_2' ) ); ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'address_3' ) ); ?>"><?php _e( 'address_3:' ); ?></label>
            <input type="text" value="<?php echo esc_attr( $instance['address_3'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address_3' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'address_3' ) ); ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'tel' ) ); ?>"><?php _e( 'TEL:' ); ?></label>
            <input type="text" value="<?php echo esc_attr( $instance['tel'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tel' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'tel' ) ); ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'fax' ) ); ?>"><?php _e( 'FAX:' ); ?></label>
            <input type="text" value="<?php echo esc_attr( $instance['fax'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'fax' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'fax' ) ); ?>" class="widefat" />
        </p>
        <?php
    }

}

function myplugin_register_widgets() {
    register_widget( 'WP_Widget_Address' );
}

add_action( 'widgets_init', 'myplugin_register_widgets' );
