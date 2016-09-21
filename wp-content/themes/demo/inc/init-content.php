<?php
foreach (scandir(dirname(__FILE__) . '/content') as $filename) {
    $path = dirname(__FILE__) . '/content' . '/' . $filename;
    if (is_file($path)) {
        require $path;
    }
}

require_once ("ml-slider/ml-slider.php");

global $slider;
$slider = new MetaSliderPlugin();

function get_slider ($id) {
    global $slider;
    /**
     * need check post type - continue...
     */
    $slider = get_post( $id );

    // check the slider is published and the ID is correct
    if ( ! $slider || $slider->post_status != 'publish' || $slider->post_type != 'ml-slider' ) {
        return "<!-- meta slider {$atts['id']} not found -->";
    }

    // lets go
    $this->set_slider( $id, $atts );
    $this->slider->enqueue_scripts();

    return $this->slider->render_public_slides();
}