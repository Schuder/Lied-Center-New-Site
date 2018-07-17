<?php
/**
 * Month View Content Template
 * The content template for the month view of events. This template is also used for
 * the response that is returned on month view ajax requests.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/month/content.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

<div class="col-md-9">
  
  <div id="tribe-events-content" class="tribe-events-month">
  
  	<!-- Month Title -->
  	<?php do_action( 'tribe_events_befosre_the_title' ) ?>
  	<h2 class="tribe-events-page-title"><?php tribe_events_title() ?></h2>
  	<?php do_action( 'tribe_events_after_the_title' ) ?>
  
  	<!-- Month Header -->
  	<?php do_action( 'tribe_events_before_header' ) ?>
  	<div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
  
  	</div>
  	<!-- #tribe-events-header -->
  	<?php do_action( 'tribe_events_after_header' ) ?>
  	<div class="tribe-events-nav">
    	<span >
        <?php tribe_events_the_previous_month_link(); ?>
      </span>
      
      <span>
        <?php tribe_events_the_next_month_link(); ?>
      </span>
    </div>
  	<!-- Month Grid -->
  	<?php tribe_get_template_part( 'month/loop', 'grid' ) ?>
  
  	<!-- Month Footer -->
  	<?php do_action( 'tribe_events_before_footer' ) ?>
  	<div id="tribe-events-footer">
  
  	</div>
  	<!-- #tribe-events-footer -->
  
  	<?php tribe_get_template_part( 'month/mobile' ); ?>
  	<?php tribe_get_template_part( 'month/tooltip' ); ?>
  
  </div>
  
  
</div>
<div class="col-md-3 well calendar-sidebar">
  <?php if(dynamic_sidebar('ticket_office')) : else : endif; ?>
  <br />
  <?php if(dynamic_sidebar('performance_day')) : else : endif; ?>
  <br />
  <?php if(dynamic_sidebar('event_link_set')) : else : endif; ?>
</div>

<!-- #tribe-events-content -->
