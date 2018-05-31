<?php
/**
 * Single Event Meta (Details) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @package TribeEventsCalendar
 */


$time_format = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
$date_format = 'F d, Y';
$day_format = 'l';
$time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );

$start_datetime = tribe_get_start_date();
$start_day = tribe_get_start_date( null, false, $day_format );
$start_date = tribe_get_start_date( null, false, $date_format );
$start_time = tribe_get_start_date( null, false, $time_format );
$start_ts = tribe_get_start_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$end_datetime = tribe_get_end_date();
$end_date = tribe_get_display_end_date( null, false, $date_format );
$end_time = tribe_get_end_date( null, false, $time_format );
$end_ts = tribe_get_end_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$time_formatted = null;
if ( $start_time == $end_time ) {
	$time_formatted = esc_html( $start_time );
} else {
	$time_formatted = esc_html( $start_time . $time_range_separator . $end_time );
}

$event_id = Tribe__Main::post_id_helper();

/**
 * Returns a formatted time for a single event
 *
 * @var string Formatted time string
 * @var int Event post id
 */
$time_formatted = apply_filters( 'tribe_events_single_event_time_formatted', $time_formatted, $event_id );

/**
 * Returns the title of the "Time" section of event details
 *
 * @var string Time title
 * @var int Event post id
 */
$time_title = apply_filters( 'tribe_events_single_event_time_title', __( 'Time:', 'the-events-calendar' ), $event_id );

$cost = tribe_get_formatted_cost();
$website = tribe_get_event_website_link();
?>

<div class="tribe-events-meta-group tribe-events-meta-group-details">
	<h3 class="tribe-events-single-section-title"> <?php esc_html_e( 'Details', 'the-events-calendar' ) ?> </h3>
	<dl>

    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-3">
            <span class="tribe-events-start-datetime published dtstart" title="<?php esc_attr_e( $start_ts ) ?>"> <?php esc_html_e( $start_day ) ?> </span>
            <span class="tribe-events-start-datetime published dtstart" title="<?php esc_attr_e( $start_ts ) ?>"> <?php esc_html_e( $start_date ) ?> </span>
            <span class="tribe-events-start-datetime published dtstart" title="<?php esc_attr_e( $start_ts ) ?>"> <?php esc_html_e( $time_formatted ) ?> </span>
        </div>
        <div class="col-md-5 col-sm-5"></div>
        <div class="col-md-4 col-sm-4"></div>
      </div>
    </div>

		<?php
		// Event Cost
		if ( ! empty( $cost ) ) : ?>

			<dt> <?php esc_html_e( 'Cost:', 'the-events-calendar' ) ?> </dt>
			<dd class="tribe-events-event-cost"> <?php esc_html_e( $cost ); ?> </dd>
		<?php endif ?>

		<?php do_action( 'tribe_events_single_meta_details_section_end' ) ?>
	</dl>
</div>
