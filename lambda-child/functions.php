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
	echo "<tr><td></td><td><small>Leave blank to display a default message.</small></td></tr>";
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
 * Added Code 6/22/2018
 *
 * Customize How titles display on calendar views, taken from Tribe Events docs.
 *
*/


function tribe_alter_event_archive_titles ( $original_recipe_title, $depth ) {
	// Modify the titles here
	// Some of these include %1$s and %2$s, these will be replaced with relevant dates
	$title_upcoming =   'Upcoming Events'; // List View: Upcoming events
	$title_past =       'Past Events'; // List view: Past events
	$title_range =      'Events for %1$s - %2$s'; // List view: range of dates being viewed
	$title_month =      '%1$s'; // Month View, %1$s = the name of the month
	$title_day =        'Events for %1$s'; // Day View, %1$s = the day
	$title_all =        'All events for %s'; // showing all recurrences of an event, %s = event title
	$title_week =       'Events for week of %s'; // Week view
	// Don't modify anything below this unless you know what it does
	global $wp_query;
	$tribe_ecp = Tribe__Events__Main::instance();
	$date_format = apply_filters( 'tribe_events_pro_page_title_date_format', tribe_get_date_format( true ) );
	// Default Title
	$title = $title_upcoming;
	// If there's a date selected in the tribe bar, show the date range of the currently showing events
	if ( isset( $_REQUEST['tribe-bar-date'] ) && $wp_query->have_posts() ) {
		if ( $wp_query->get( 'paged' ) > 1 ) {
			// if we're on page 1, show the selected tribe-bar-date as the first date in the range
			$first_event_date = tribe_get_start_date( $wp_query->posts[0], false );
		} else {
			//otherwise show the start date of the first event in the results
			$first_event_date = tribe_event_format_date( $_REQUEST['tribe-bar-date'], false );
		}
		$last_event_date = tribe_get_end_date( $wp_query->posts[ count( $wp_query->posts ) - 1 ], false );
		$title = sprintf( $title_range, $first_event_date, $last_event_date );
	} elseif ( tribe_is_past() ) {
		$title = $title_past;
	}
	// Month view title
	if ( tribe_is_month() ) {
		$title = sprintf(
			$title_month,
			date_i18n( tribe_get_option( 'monthAndYearFormat', 'F Y' ), strtotime( tribe_get_month_view_date() ) )
		);
	}
	// Day view title
	if ( tribe_is_day() ) {
		$title = sprintf(
			$title_day,
			date_i18n( tribe_get_date_format( true ), strtotime( $wp_query->get( 'start_date' ) ) )
		);
	}
	// All recurrences of an event
	if ( function_exists('tribe_is_showing_all') && tribe_is_showing_all() ) {
		$title = sprintf( $title_all, get_the_title() );
	}
	// Week view title
	if ( function_exists('tribe_is_week') && tribe_is_week() ) {
		$title = sprintf(
			$title_week,
			date_i18n( $date_format, strtotime( tribe_get_first_week_day( $wp_query->get( 'start_date' ) ) ) )
		);
	}
	if ( is_tax( $tribe_ecp->get_event_taxonomy() ) && $depth ) {
		$cat = get_queried_object();
		$title = '<a href="' . esc_url( tribe_get_events_link() ) . '">' . $title . '</a>';
		$title .= ' &#8250; ' . $cat->name;
	}
	return $title;
}
add_filter( 'tribe_get_events_title', 'tribe_alter_event_archive_titles', 11, 2 );


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


function teccc_change_html ($html) {
$html = 'HTML string';
$dom = new DOMDocument();
$dom->loadHTML($html);
  
echo gettype($html).$html;
}

add_filter( 'teccc_legend_html', 'teccc_change_html');



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