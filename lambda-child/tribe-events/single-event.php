<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.3
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = get_the_ID();
$event_slider = get_post_meta($event_id, _event_slider, true);
$left_title = get_post_meta($event_id, _left_title, true);
$left_url = get_post_meta($event_id, _left_url, true);
$right_title = get_post_meta($event_id, _right_title, true);
$right_url = get_post_meta($event_id, _right_url, true);
$cost = tribe_get_event_meta( $event_id, '_EventCost', false );

$sponsor = tribe_get_organizer( $event_id);
$sponsor_url = tribe_get_organizer_link( $event_id );
$sponsor_id = tribe_get_organizer_id($event_id);
$sponsor_post = get_post($sponsor_id);
$sponsor_img = $sponsor_post->post_content;

$start_datetime = new DateTime(tribe_get_start_date(null, false, $date_format));
$start_datetime->setTime(0,0,0);

$now = new DateTime();
$now->setTime(0,0,0);

$is_past_event = false;

if ($start_datetime < $now) {
	$is_past_event = true;
}


?>
<?php putRevSlider($event_slider) ?>
<div class="tribe-events-secondary-bar">
	
</div>
<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
<?php tribe_get_template_part( 'modules/meta' ); ?>
<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
<div id="tribe-events-content" class="tribe-events-single">

	<!-- Notices -->
	<?php ($is_past_event ? tribe_the_notices() : null ) ?>
	
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-9">
				
				<h1 class="tribe-events-title">
				  <?php the_title( '<div class="tribe-events-title-border">', '</div>' ); ?>
				</h1>
				  
				<!-- Event header -->
				<div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>

					<!-- .tribe-events-sub-nav -->
				</div>
				<!-- #tribe-events-header -->
				  
				<?php while ( have_posts() ) :  the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<!-- Event featured image, but exclude link -->
						<!-- <?php echo tribe_event_featured_image( $event_id, 'full', false ); ?> -->
						
							
						<!-- Event content -->
						<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
						<div class="tribe-events-single-event-description tribe-events-content">
							<?php the_content(); ?>
        			
        			<!-- Auto Generate Event Sponsor Into Page
        			<div class="tribe-events-sponsor">
        			  <strong>Event Sponsor:</strong>
        			  <a href="<?php esc_html_e($sponsor_url) ?>" target="_blank"><?php echo $sponsor_img ?></a>
        			 </div>
        			-->
						</div>
						<!-- .tribe-events-single-event-description -->
						<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
				  
					</div> <!-- #post-x -->
			</div>
			<div class="col-md-3 well" >

        <?php if ($is_past_event) { ?>
        
          <!--<h2 class="tribe-events-info-title">Sorry You Missed The Show!</h2>-->
          <div>
          	<a class="tribe-events-info-ticket event-disabled" href="https://ticketweb.lss.ku.edu/Online/default.asp" target="-blank">See Upcoming Events ></a>
          </div>
          
          
        <?php } else { ?>
        
          <!--<h2 class="tribe-events-info-title">Coming To The Show?</h2>-->
          <div>
			<a class="tribe-events-info-ticket" href="<?php esc_html_e( $website ) ?>" target="-blank">Get Tickets ></a>
            <div class="tribe-events-cost"><i class="fa fa-ticket fa-lg"></i>&nbsp;<?php esc_html_e( implode(" ", $cost) ) ?></div>
          </div>
          
        <?php } ?>

				<br />
				<?php if(dynamic_sidebar('ticket_office')) : else : endif; ?>
				<br />
				<?php if(dynamic_sidebar('performance_day')) : else : endif; ?>
				<br />
				<?php if(dynamic_sidebar('event_link_set')) : else : endif; ?>
			</div>
		</div>
	</div>
	
		<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; ?>

	<!-- Event footer -->
	<div id="tribe-events-footer">
		<!-- Navigation -->
		<!-- .tribe-events-sub-nav -->
	</div>
	<!-- #tribe-events-footer -->

</div><!-- #tribe-events-content -->
