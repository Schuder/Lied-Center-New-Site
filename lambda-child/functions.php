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
	add_meta_box( 'meta_box_event_slider', __( 'Revolution Slider', 'lied_events' ), 'build_meta_box_event_slider', 'page', 'side', 'low' );
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
	
	$current_is_bar_enabled = get_post_meta( $post->ID, '_is_bar_enabled', true );
	$current_left_title = get_post_meta( $post->ID, '_left_title', true );
	$current_left_url = get_post_meta( $post->ID, '_left_url', true );
	$current_right_title = get_post_meta( $post->ID, '_right_title', true );
	$current_right_url = get_post_meta( $post->ID, '_right_url', true );
	$checked = '';
	
	if ($current_is_bar_enabled=='on') {
	  $checked='checked';
	}
	
	echo "<div style='width: 25%; float: left;'><label>Enabled: </label></div>";
	echo "<div style='width: 75%; margin-bottom: 6px;'><input type='checkbox' name='is_bar_enabled' ".$checked."/></div>";
	
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
	
	if ( isset( $_REQUEST['is_bar_enabled'] ) ) {
		update_post_meta( $post_id, '_is_bar_enabled', 'on' );
	}
	else {
	  update_post_meta( $post_id, '_is_bar_enabled', 'off' );
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
 * Added Code 06/13/2018
 *
 * Inserts new meta fields to Tribe Events meta box on event admin page
 *
*/

function add_meta_boxes_tribe_events($post) {

  add_meta_box( 'meta_box_tribe_events', __( 'Event Ticket', 'lied_events3' ), 'build_meta_box_tribe_events', 'tribe_events', 'side', 'low' );


	
}

function build_meta_box_tribe_events($post){

  wp_nonce_field( basename( __FILE__ ), 'meta_box_nonce_tribe_events' );
  
	$current_is_ticket_enabled = get_post_meta( $post->ID, '_is_ticket_enabled', true );
	$current_ticket_msg = get_post_meta( $post->ID, '_ticket_msg', true );
	
	$checked = '';
	
	if ($current_is_ticket_enabled=='on') {
	  $checked='checked';
	}
  
 	echo "<table id='event_ticket' class='eventtable'><tbody>";
	echo "<tr><td class='tribe-table-field-label'>Free Event: </td>";
	echo "<td><input type='checkbox' name='is_ticket_enabled' ".$checked."/></td></tr>";
	echo "<tr><td class='tribe-table-field-label'>Message: </td>";
	echo "<td><input type='text' name='ticket_msg'  value='".$current_ticket_msg."' /></td></tr>";
	echo "<tr><td></td><td><small>Leave blank to display default 'Get Tickets' text.</small></td></tr>";
	echo "</tbody></table>";

}

function save_meta_boxes_tribe_events ($post_id) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
	
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}
	
	if ( isset( $_REQUEST['is_ticket_enabled'] ) ) {
		update_post_meta( $post_id, '_is_ticket_enabled', 'on' );
	}
	else {
	  update_post_meta( $post_id, '_is_ticket_enabled', 'off' );
	}
	
	if ( isset( $_REQUEST['ticket_msg'] ) ) {
		update_post_meta( $post_id, '_ticket_msg', sanitize_text_field( $_POST['ticket_msg'] ) );
	}
	
}


add_action( 'add_meta_boxes', 'add_meta_boxes_tribe_events' );
add_action( 'save_post', 'save_meta_boxes_tribe_events');






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

/* Webmaster Kerry
 * Added Code 6/8/2018
 *
 * Add Shit to Event Excerpt in Calendar
 *
*/
 
function tribe_add_view_event_link_before_excerpt( $excerpt ) {
     
     $permalink = get_permalink( get_the_ID() );
     $ticket_link = tribe_get_event_meta( tribe_get_venue_id( get_the_ID() ), '_VenueURL', true );
 
    return '<a href="'.$ticket_link.'">Buy Tickets</a><br>';
}

/*add_filter( 'tribe_events_get_the_excerpt', 'tribe_add_view_event_link_before_excerpt' );*/

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