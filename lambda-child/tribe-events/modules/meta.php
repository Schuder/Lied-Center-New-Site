<?php
/**
 * Single Event Meta Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta.php
 *
 * @package TribeEventsCalendar
 */

$time_format = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
$date_format = 'M d';
$day_format = 'l';
$time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );

$start_datetime = new DateTime(tribe_get_start_date(null, false, $date_format));
$start_datetime->setTime(0,0,0);

$now = new DateTime();
$now->setTime(0,0,0);

$is_past_event = false;

$start_day = tribe_get_start_date( null, false, $day_format );
$start_date = tribe_get_start_date( null, false, $date_format );
$start_time = tribe_get_start_date( null, false, $time_format );
$start_ts = tribe_get_start_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

if ($start_datetime < $now) {
	$is_past_event = true;
}

$end_datetime = tribe_get_end_date();
$end_date = tribe_get_display_end_date( null, false, $date_format );
$end_time = tribe_get_end_date( null, false, $time_format );
$end_ts = tribe_get_end_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$time_formatted = null;
if ( $start_time == $end_time ) {
	$time_formatted = esc_html( $start_time );
} else {
	$time_formatted = esc_html( $start_time /* . $time_range_separator . $end_time */);
}

$event_id = Tribe__Main::post_id_helper();

$venue = tribe_get_venue();
$phone = tribe_get_phone();
$address = tribe_get_address();
$website = tribe_get_venue_website_link();

$cost = tribe_get_event_meta( $event_id, '_EventCost', false );


do_action( 'tribe_events_single_meta_before' );

do_action( 'tribe_events_single_event_meta_primary_section_start' );
?>

<div class="primary well tribe-events-meta-container">
	<div class="row tribe-events-meta">
		<div class="col-md-12">
			<div class="col-md-4 col-sm-4">
			  <div class="tribe-events-flag">
			  	<div>
			  		<span class="tribe-events-day"> <?php esc_html_e( $start_day ) ?> </span>
			  		<span class="tribe-events-date"><?php esc_html_e( $start_date ) ?></span>
			  		<span class="tribe-events-time"> <?php esc_html_e( $time_formatted ) ?> </span>
			  	</div>
			  </div>
			  <!--
				<h1 class="tribe-events-day"> <?php esc_html_e( $start_day ) ?> </h1>
				<h4 class="tribe-events-date"> <?php esc_html_e( $start_date ) ?> </h4>
				<span class="tribe-events-time"> <?php esc_html_e( $time_formatted ) ?> </span>
				-->
			</div>
			<div class="col-md-5 col-sm-5">
				<span class="tribe-events-map-marker"><i class="fa fa-users"></i></span>
				<h4 class="tribe-events-venue-name"> <?php esc_html_e( $venue ) ?> </h4>
				<span class="tribe-events-venue-address"> <?php esc_html_e( $address ) ?> </span>
				<span class="tribe-events-venue-directions"><a href="https://goo.gl/maps/w5drNq9mBPs" target="_blank">Get Directions ></a></span>
			</div>
			<div class="col-md-3 col-sm-3">
				<a class="tribe-events-ticket" href="<?php ($is_past_event ? esc_html_e('https://ticketweb.lss.ku.edu/Online/default.asp') : esc_html_e( $website )) ?>" target="-blank"><i class="fa fa-ticket fa-lg"></i>&nbsp;<?php ($is_past_event ? esc_html_e('Past Event') : esc_html_e('Buy Tickets Online')) ?></a>
				<div class="tribe-events-ticket-disclaimer">$5 fee applied to online orders </div>
				<!--<a class="tribe-events-ticket" href="<?php esc_html_e( $website ) ?>" target="-blank"><i class="fa fa-ticket fa-lg"></i><?php esc_html_e( implode(" ", $cost) ) ?></a> -->
			</div>
		</div>
	</div>
</div>

<?php
do_action( 'tribe_events_single_event_meta_primary_section_end' );

do_action( 'tribe_events_single_meta_after' );
?>
