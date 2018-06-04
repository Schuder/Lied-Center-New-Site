<?php
/**
 * Child Theme functions loads the main theme class and extra options
 *
 * @package Omega Child
 * @subpackage Child
 * @since 1.3
 *
 * @copyright (c) 2013 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.0
 */

/**
 * Loads a child css script
 *
 * @return void
 * @author
 **/
 
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

function oxy_load_child_scripts() {
    wp_enqueue_style( THEME_SHORT . '-child-theme' , get_stylesheet_directory_uri() . '/style.css', array( THEME_SHORT . '-theme' ), false, 'all' );
}

/* Webmaster Kerry
 * Added Code 1/26/2018
 *
 * Adds a Revolution Slider picker to the back-end event editor
 *
*/
function add_meta_boxes_lied_events($post) {
	add_meta_box( 'meta_box_event_slider', __( 'Revolution Slider', 'lied_events' ), 'build_meta_box_event_slider', 'tribe_events', 'side', 'low' );
	add_meta_box( 'meta_box_event_secondary_bar', __( 'Secondary Bar', 'lied_events2' ), 'build_meta_box_secondary_bar', 'tribe_events', 'normal', 'low' );
}

function build_meta_box_event_slider($post){
	wp_nonce_field( basename( __FILE__ ), 'meta_box_nonce_event_slider' );
	
	
	if(shortcode_exists("rev_slider")){
		echo '<select name="event_slider">';
		$current_event_slider = get_post_meta( $post->ID, '_event_slider', true );
	 
		$slider = new RevSlider();
		$revolution_sliders = $slider->getArrSliders();
	 
		echo "<option value=''>--- Revolution Sliders ---</option>";
		foreach ( $revolution_sliders as $revolution_slider ) {
			$checked="";
			$alias = $revolution_slider->getAlias();
			$title = $revolution_slider->getTitle();
			if($alias==$current_event_slider) $checked="selected";
			echo "<option value='".$alias."' $checked>".$title."</option>";
		}

		echo '</select>';
	}
	
}

function build_meta_box_secondary_bar($post){
	wp_nonce_field( basename( __FILE__ ), 'meta_box_nonce_secondary_bar' );
	
	$current_left_title = get_post_meta( $post->ID, '_left_title', true );
	$current_left_url = get_post_meta( $post->ID, '_left_url', true );
	$current_right_title = get_post_meta( $post->ID, '_right_title', true );
	$current_right_url = get_post_meta( $post->ID, '_right_url', true );
	
	echo "<div style='width: 25%; float: left;'><label>Left Title: </label></div>";
	echo "<div style='width: 75%;'><input type='text' name='left_title' value='".$current_left_title."'/></div>";
	
	echo "<div style='width: 25%; float: left;'><label>Left URL: </label></div>";
	echo "<div style='width: 75%;'><input type='text' name='left_url' value='".$current_left_url."'/></div>";
	
	echo "<div style='width: 25%; float: left;'><label>Right Title: </label></div>";
	echo "<div style='width: 75%;'><input type='text' name='right_title' value='".$current_right_title."'/></div>";
	
	echo "<div style='width: 25%; float: left;'><label>Right URL: </label></div>";
	echo "<div style='width: 75%;'><input type='text' name='right_url' value='".$current_right_url."'/></div>";

	
}

function save_meta_boxes_event_slider ($post_id) {

	if ( !isset( $_POST['meta_box_nonce_event_slider'] ) || !wp_verify_nonce( $_POST['meta_box_nonce_event_slider'], basename( __FILE__ ) ) ){
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
	
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}
	
	if ( isset( $_REQUEST['event_slider'] ) ) {
		update_post_meta( $post_id, '_event_slider', sanitize_text_field( $_POST['event_slider'] ) );
	}
	
}

function save_meta_boxes_secondary_bar ($post_id) {

	if ( !isset( $_POST['meta_box_nonce_secondary_bar'] ) || !wp_verify_nonce( $_POST['meta_box_nonce_secondary_bar'], basename( __FILE__ ) ) ){
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
	
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}
	
	if ( isset( $_REQUEST['left_title'] ) ) {
		update_post_meta( $post_id, '_left_title', sanitize_text_field( $_POST['left_title'] ) );
	}
	
	if ( isset( $_REQUEST['left_url'] ) ) {
		update_post_meta( $post_id, '_left_url', sanitize_text_field( $_POST['left_url'] ) );
	}
	
	if ( isset( $_REQUEST['right_title'] ) ) {
		update_post_meta( $post_id, '_right_title', sanitize_text_field( $_POST['right_title'] ) );
	}
	
	if ( isset( $_REQUEST['right_url'] ) ) {
		update_post_meta( $post_id, '_right_url', sanitize_text_field( $_POST['right_url'] ) );
	}
	
}

add_action( 'wp_enqueue_scripts', 'oxy_load_child_scripts');
add_action( 'add_meta_boxes', 'add_meta_boxes_lied_events' );
add_action( 'save_post', 'save_meta_boxes_event_slider');
add_action( 'save_post', 'save_meta_boxes_secondary_bar');



/* Webmaster Kerry
 * Added Code ??/??/2018
 *
 * Adds custom sidebars to widgets.
 *
*/
function register_widgets_lied() {

	register_sidebar( array(
		'name'          => 'Ticket Office',
		'id'            => 'ticket_office',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<strong>',
		'after_title'   => '</strong>',
	) );
	
	register_sidebar( array(
		'name'          => 'Performance Day',
		'id'            => 'performance_day',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<strong>',
		'after_title'   => '</strong>',
	) );

	register_sidebar( array(
		'name'          => 'Event Link Set',
		'id'            => 'event_link_set',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<strong>',
		'after_title'   => '</strong>',
	) );
	

}
add_action( 'widgets_init', 'register_widgets_lied' );


/* Webmaster Kerry
 * Added Code 5/29/2018
 *
 * Customize Image Gallery
 *
*/
add_theme_support( 'post-thumbnails' );
add_image_size( 'event-gallery', 300, 200, true );

add_filter( 'image_size_names_choose', 'custom_image_sizes' );
 
function custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'event-gallery' => __( 'Event Gallery' ),
    ) );
}

add_filter('post_gallery','customFormatGallery',10,2);

function customFormatGallery($string,$attr){

    /**$output = "<br />
              <h3 class=\"tribe-events-title\">
              <div class=\"tribe-events-title-border\"><i class=\"fa fa-camera\" aria-hidden=\"true\"></i>&nbsp;Photos</div>
              </h3>
              <div id=\"container\">";
    $posts = get_posts(array('include' => $attr['ids'],'post_type' => 'attachment'));

    foreach($posts as $imagePost){
        $imgurl = wp_get_attachment_url($imagePost->ID);
        $output .= '<img class=\"event-gallery\" src="'.$imgurl.'"></img>';
        $output .= wp_get_attachment_image( $imagePost->ID, 'event-gallery');
    }

    $output .= "</div>";**/
    
    /** Make both thumbnail and full size image embed in page, display none on the fullsize and make it so on hover the thumnbnail dissappears and the fullsize appears with transition**/

    return $output;
    
}

/**
 * Example override of the blogquote shortcode
 *
 * @return void
 * @author
 **/
/*function oxy_shortcode_blockquote( $atts, $content ) {
    extract( shortcode_atts( array(
        'who'                    => '',
        'cite'                   => '',
        'align'                  => 'left',
        'text_color'             => 'text-normal',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 20,
        'margin_bottom'          => 20,
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0'
    ), $atts ) );

    if ($align == 'left') {
        $align_class = 'text-left';
    }
    else if ($align == 'right') {
        $align_class = 'text-right';
    }
    else {
        $align_class = 'text-center';
    }
    $classes = array();
    $classes[] = $extra_classes;
    $classes[] = $align_class;
    $classes[] = $text_color;
    $classes[] = 'element-top-' . $margin_top;
    $classes[] = 'element-bottom-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    // override here
    $content = 'This is and example of how to override the code';
    $who = 'Morris Onions';

    ob_start();
    include( locate_template( 'partials/shortcodes/blockquote.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}*/