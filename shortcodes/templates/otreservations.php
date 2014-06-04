<div class="pixcode  pixcode--otreservations  otreservations  <?php echo $class ?>">
	<div class="otreservation-title-wrapper">
		<h4 class="otreservations-title"><?php echo $title ?></h4>
		<span class="otreservations-subtitle"><?php _e( 'Powered by OpenTable', 'pixcodes' ) ?></span>
	</div>
	<?php if (!empty($rid) && intval($rid)) : ?>
	<form method="get" class="otw-widget-form" action="http://www.opentable.com/restaurant-search.aspx" target="_blank">
		<div class="otw-wrapper">
			<div class="otw-date-li otw-input-wrap">
				<label for="date-otreservations"><?php echo (!empty($labels) ? __( 'Date', 'pixcodes' ) : '<i class="icon-calendar"></i>') ?></label>
				<input id="date-otreservations" name="startDate" class="otw-reservation-date" type="text" value="" autocomplete="off">
			</div>
			<div class="otw-time-wrap otw-input-wrap">
				<label for="time-otreservations"><?php echo (!empty($labels) ? __( 'Time', 'pixcodes' ) : '<i class="icon-clock-o"></i>') ?></label>
				<select id="time-otreservations" name="ResTime" class="otw-reservation-time selectpicker">
					<?php
					//Time Loop
					$inc = 30 * 60;
					$start = ( strtotime( '6AM' ) ); // 6  AM
					$end = ( strtotime( '11:59PM' ) ); // 10 PM


					for ( $i = $start; $i <= $end; $i += $inc ) {
						// to the standart format
						$time      = date( 'g:i a', $i );
						$timeValue = date( 'g:ia', $i );
						$default   = "7:00pm";
						echo "<option value=\"$timeValue\" " . ( ( $timeValue == $default ) ? ' selected="selected" ' : "" ) . ">$time</option>" . PHP_EOL;
					}

					?>
				</select>

			</div>
			<div class="otw-party-size-wrap otw-input-wrap">
				<label for="party-otreservations"><?php echo (!empty($labels) ? __( 'Party Size', 'pixcodes' ) : '<i class="icon-user"></i>') ?></label>
				<select id="party-otreservations" name="partySize" class="otw-party-size-select selectpicker">
					<option value="1">1 Person</option>
					<option value="2" selected="selected">2 People</option>
					<option value="3">3 People</option>
					<option value="4">4 People</option>
					<option value="5">5 People</option>
					<option value="6">6 People</option>
					<option value="7">7 People</option>
					<option value="8">8 People</option>
					<option value="9">9 People</option>
					<option value="10">10 People</option>
				</select>

			</div>

			<div class="otw-button-wrap">
				<input type="submit" class="otreservations-submit" value="<?php _e( 'Find a Table', 'pixcodes' ); ?>" />
			</div>
			<input type="hidden" name="RestaurantID" class="RestaurantID" value="<?php echo $rid; ?>">
			<input type="hidden" name="rid" class="rid" value="<?php echo $rid; ?>">
			<input type="hidden" name="GeoID" class="GeoID" value="15">
			<input type="hidden" name="txtDateFormat" class="txtDateFormat" value="MM/dd/yyyy">
			<input type="hidden" name="RestaurantReferralID" class="RestaurantReferralID" value="<?php echo $rid; ?>">
		</div>
	</form>
	<?php else : ?>
		<span class="otreservations-error"><?php _e('You need to provide us with a valid numeric OpenTable restaurant ID.', 'pixcodes') ?></span>
	<?php endif; ?>
</div>