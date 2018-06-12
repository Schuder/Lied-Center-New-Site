<?php
/**
 * Please see single-event.php in this directory for detailed instructions on how to use and modify these templates.
 *
 * Override this template in your own theme by creating a file at:
 *
 *     [your-theme]/tribe-events/month/tooltip.php
 * @version 4.4
 */
?>

<script type="text/html" id="tribe_tmpl_tooltip">
	<div id="tribe-events-tooltip-[[=eventId]]" class="tribe-events-tooltip">
	
		[[ if(imageTooltipSrc.length) { ]]
		<div class="tribe-events-tooltip-thumb">
			<img src="[[=imageTooltipSrc]]" alt="[[=title]]" />
		</div>
		[[ } ]]
		
		<span class="tribe-events-tooltip-title">[[=raw title]]</span>

		<div class="tribe-events-event-body">
			<div class="tribe-event-duration">
				<abbr class="tribe-events-abbr tribe-event-date-start">[[=dateDisplay]] </abbr>
			</div>
  		<a href="[[=ticket_link]]">
        <div class="tribe-events-tooltip-flag">
          <div>
            <span>Buy Tickets</span>
          </div>
        </div>
      </a>
      <a href="[[=event_link]]" class="tribe-events-tooltip-learnmore">Learn More</a>

		</div>
	</div>
</script>

<script type="text/html" id="tribe_tmpl_tooltip_featured">
	<div id="tribe-events-tooltip-[[=eventId]]" class="tribe-events-tooltip tribe-event-featured">
		[[ if(imageTooltipSrc.length) { ]]
			<div class="tribe-events-event-thumb">
				<img src="[[=imageTooltipSrc]]" alt="[[=title]]" />
			</div>
		[[ } ]]

		<h4 class="entry-title summary">[[=raw title]]</h4>

		<div class="tribe-events-event-body">
			<div class="tribe-event-duration">
				<abbr class="tribe-events-abbr tribe-event-date-start">[[=dateDisplay]] </abbr>
			</div>

			[[ if(excerpt.length) { ]]
			<div class="tribe-event-description">[[=raw excerpt]]</div>
			[[ } ]]
			<span class="tribe-events-arrow"></span>
		</div>
	</div>
</script>
