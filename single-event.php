<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */
 	wp_enqueue_style('single_custom_event', get_stylesheet_directory_uri() . '/styles/events/event.css');

	if ( ! defined( 'ABSPATH' ) ) {
		die( '-1' );
	}
	
	if ( is_null( $event_id ) ) {
			$event_id = get_the_ID();
		}
		
	//images
	$thumbnail =  get_the_post_thumbnail($post->ID);

	//Secondary title
	$secondary_title = get_field(secondary_title);
	
	//bgimage
	$bg_image = get_field('header_background_image');
	
	if ($bg_image == false){
		$bg_image = get_stylesheet_directory_uri() . '/images/background_events.jpg';
	} 
	
	//date time
	$date = tribe_get_start_time ( $event_id, 'd. F');
	$end_hour = tribe_get_end_time ( $event_id);
	$start_hour = tribe_get_start_time ( $event_id);	

	// events categories
	$term_list = wp_get_post_terms( $event_id, Tribe__Events__Main::TAXONOMY );
	$categories;
	
	$i = 0;
    $len = count($term_list);
    foreach( $term_list as $term_single ) {
    	$categories .= $term_single->name;
    	if ($i != $len - 1) { $categories .= " | " ; }
	    $i++;
    }
		
	//organizers
	$organizers = tribe_get_organizer_ids($id);
	
	//speakers
	$speakers = get_field('speakers');
	
	//timezone
	$event_timezone = get_post_meta( $event_id, '_EventTimezone', true );
	
	//aditional fields
	$additional_fields = tribe_get_custom_fields();
	
	//location
	$location = get_field(location);
	
	//$venue_name = tribe_get_venue($event_id);
	
	$venue_name;
	foreach (tribe_get_venue_details($event_id) as $venue){
		$venue_name .= $venue;
	} 
	
	//Map
	$map_url = tribe_events_get_map_view_basic_embed_url();
	
	
	//RSVP 
	$rsvp = do_shortcode('[tribe_tickets_rsvp post_id="' . $event_id . '"]');
	
	
?>



<div id="main-content">
    <article id="post-6290" class="post-6290 page type-page status-publish hentry">
        <div class="entry-content">
            <div class="et-l et-l--post">
                <div class="et_builder_inner_content et_pb_gutters3">



 
                    <div class="et_pb_section et_pb_section_0 et_pb_with_background et_section_regular" style="background-image: url(<?php echo $bg_image ?>)!important; background-size: cover;">
		                    
                        <div class="et_pb_row et_pb_row_0">
                            <div class="et_pb_column et_pb_column_4_4 et_pb_column_0  et_pb_css_mix_blend_mode_passthrough et-last-child">
                                <div class="et_pb_module et_pb_blurb et_pb_blurb_0 et_clickable  et_pb_text_align_left  et_pb_blurb_position_top et_pb_bg_layout_dark">
                                    <div class="et_pb_blurb_content">
                                        <div class="et_pb_blurb_container">
	                                        
                                            <h1 class="et_pb_module_header">
	                                            <a href="#">
		                                            <?php the_title() ?> 
		                                        </a>
		                                    </h1>
		                                    
                                            <div class="et_pb_blurb_description">
                                                <p>
	                                                
	                                                <?php echo $date ?> / <?php echo $start_hour ?> 
													<br>
													<?php echo $categories;	?> 
													<br>
													<?php if (tribe_get_cost()) { ?>
														Price:  <?php 
																if ( tribe_get_cost() ) : 
																	echo tribe_get_cost( null, true );
																endif; 
															?>
													<?php } ?>
													
												</p>
                                            </div>
                                        </div>
                                    </div> <!-- .et_pb_blurb_content -->
                                </div> <!-- .et_pb_blurb -->
                                <div class="et_pb_button_module_wrapper et_pb_button_0_wrapper et_pb_button_alignment_center et_pb_module ">
                                    <?php if ($rsvp != ""){ ?>
	                                    <a class="et_pb_button et_pb_button_0 et_pb_bg_layout_dark"
                                        href="#rsvp">RSVP</a>
                                    <?php } ?>
                                    
                                </div>
                            </div> <!-- .et_pb_column -->
                        </div> <!-- .et_pb_row -->
                    </div> <!-- .et_pb_section -->



                    <div class="et_pb_section et_pb_section_1 et_section_regular">
                        <div class="et_pb_row et_pb_row_1 et_pb_equal_columns">
                            <div class="et_pb_column et_pb_column_2_5 et_pb_column_1  et_pb_css_mix_blend_mode_passthrough">
                                <div class="et_pb_with_border et_pb_module et_pb_text et_pb_text_0  et_pb_text_align_left et_pb_bg_layout_light">


                                    <div class="et_pb_text_inner">
                                        <h2>Event details</h2>
                                        
                                        <?php if ($date){?>
	                                        <p><strong>Date:</strong> <?php echo $date ?></p>
                                        <?php } ?>
                                        
                                        <?php if ($start_hour || $start_hour){?>
                                        	<p><strong>Schedule:</strong> <?php echo $start_hour . " | " . $end_hour; ?></p>
                                        <?php } ?>
                                        
                                        <?php if ($event_timezone){?>
                                        	<p><strong>Timezone:</strong> <?php echo $event_timezone ?>
                                        <?php } ?>
                                        
                                        <?php if ($categories){?>
                                        	<p><strong>Event Type:</strong> 
	                                        <?php echo $categories;	?> 		                                 
	                                    	</p>
                                        <?php } ?>
                                        
                                        <?php if ($organizers){?>
                                        	<p><strong>Organizer:</strong>
		                                        <?php
			                                        foreach($organizers as $organizerId) {
													  echo tribe_get_organizer($organizerId);
													}
												?>
											</p>
                                        <?php } ?>
                                        
                                        
                                        <p>
	                                        
	                                        <?php 
		                                        
/*
		                                        if($venue_name === " ") {
	                                            	echo "venue empty";
	                                        	} else {
		                                        	if ($location == "") {
			                                        	echo '<span><strong>Place:</strong>';
														echo $venue_name;  	
		                                        	}
	                                        	}
	                                        	
	                                        	var_dump($location);
	                                        	var_dump($venue_name);
*/

	                                        	if($venue_name === " ") {
	                                            	echo '<span><strong>Place:</strong>';
													echo $location;
	                                        	} else {
		                                        	if ($location == "") {
			                                        	echo '<span><strong>Place:</strong>';
														echo $venue_name;  	
		                                        	}
	                                        	}
	                                        	


	                                        ?>
                                        	</span>
                                        </p>
                                    </div>
                                </div> <!-- .et_pb_text -->
                            </div> <!-- .et_pb_column -->
                            <div class="et_pb_column et_pb_column_3_5 et_pb_column_2  et_pb_css_mix_blend_mode_passthrough et-last-child">


                                <div class="et_pb_module et_pb_text et_pb_text_1  et_pb_text_align_left et_pb_bg_layout_light">


                                    <div class="et_pb_text_inner">
	                                    
                                        <?php if ($secondary_title){?>
	                                        <h2 style="text-align: left;">
	                                        	<?php echo $secondary_title ?>
	                                    	</h2>
                                        <?php } ?>
                                        
	                                    
                                        <p><?php the_content(); ?> </p>
                                    </div>
                                </div> <!-- .et_pb_text -->
                            </div> <!-- .et_pb_column -->


                        </div> <!-- .et_pb_row -->
                    </div> <!-- .et_pb_section -->



					<!-- ################ SPEAKERS ################################# -->

					<?php if ($speakers != NULL){ ?> 
                    <div class="et_pb_section et_pb_section_2 et_section_regular">
                        <div class="et_pb_row et_pb_row_2">
                            <div class="et_pb_column et_pb_column_4_4 et_pb_column_3  et_pb_css_mix_blend_mode_passthrough et-last-child">
                                <div class="et_pb_module et_pb_text et_pb_text_2  et_pb_text_align_left et_pb_bg_layout_light">
                                    <div class="et_pb_text_inner">
                                        <h2>Speaker</h2>
                                    </div>
                                </div> <!-- .et_pb_text -->
                            </div> <!-- .et_pb_column -->
                        </div> <!-- .et_pb_row -->
                        
                        
                        
                        	<?php          
	                        if( have_rows('speakers') ):

						 	// loop through the rows of data
						    while ( have_rows('speakers') ) : the_row();
						    	$user = get_sub_field('speaker');
							?>						
								<div class="et_pb_row et_pb_row_3">
									
									
		                            <div class="et_pb_column et_pb_column_2_5 et_pb_column_4  et_pb_css_mix_blend_mode_passthrough">
		                                <div class="et_pb_module et_pb_image et_pb_image_0">
		                                    <span class="et_pb_image_wrap speaker_avatar">
		                                    
		                                    <?php echo $user[user_avatar]; ?>
		                                    </span>
		                                </div>
		                            </div> <!-- .et_pb_column -->
		                            
		                            <div class="et_pb_column et_pb_column_3_5 et_pb_column_5  et_pb_css_mix_blend_mode_passthrough et-last-child">
		                                <div class="et_pb_module et_pb_text et_pb_text_3  et_pb_text_align_left et_pb_bg_layout_light">
			                                    <div class="et_pb_text_inner">
		                                        <h4><?php echo $user[user_firstname] . " " . $user[user_lastname] ?> </h4>
		                                        <h5><?php the_sub_field('speaker_role'); ?></h5>
												<!-- <p><em>Executive coach, speaker and writer.</em></p> -->
		                                        <p><?php echo $user[user_description]; ?></p>
		                                    </div>
		                                </div> <!-- .et_pb_text -->
		                            </div> <!-- .et_pb_column -->
		                            
		                            
		                        </div> <!-- .et_pb_row -->
						<?php 
						    endwhile;
							else :
							    // no rows found
							endif;
						?>
                    </div> 
					<?php } ?>
					<!-- ################ END SPEAKERS ################################# -->


					<?php if($map_url) {?>
                    <div class="et_pb_section et_pb_section_4 et_section_regular">
                        <div class="et_pb_row et_pb_row_6">
                            <div class="et_pb_column et_pb_column_4_4 et_pb_column_12  et_pb_css_mix_blend_mode_passthrough et-last-child">


                                <div class="et_pb_module et_pb_text et_pb_text_10  et_pb_text_align_left et_pb_bg_layout_light">


                                    <div class="et_pb_text_inner">
                                        <h2>Location</h2>
                                    </div>
                                </div> <!-- .et_pb_text -->
                            </div> <!-- .et_pb_column -->


                        </div> <!-- .et_pb_row -->
                        <div class="et_pb_row et_pb_row_7">
                            <div class="et_pb_column et_pb_column_4_4 et_pb_column_13  et_pb_css_mix_blend_mode_passthrough et-last-child" style=" margin-bottom: 0px; overflow: hidden;">

                                <div class="et_pb_module et_pb_map_0 et_pb_map_container" style="margin-bottom: -20px;">

											<iframe src="<?php echo $map_url ?>" 
											width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0">
											</iframe>

                                </div>
                            </div>
                        </div> <!-- .et_pb_row -->


                    </div> <!-- .et_pb_section map -->
                    <?php } ?>
                    
                    <div class="et_pb_section et_pb_section_5 et_pb_with_background et_section_regular">

                        <div class="et_pb_row et_pb_row_8">
	                        
	                        
                            <div class="et_pb_column et_pb_column_1_2 et_pb_column_14  et_pb_css_mix_blend_mode_passthrough">

                                <div class="et_pb_module et_pb_image et_pb_image_1">

                                    <span class="et_pb_image_wrap ">
                                    	<?php echo $thumbnail;?> 
                                    </span>
                                </div>
                            </div> <!-- .et_pb_column -->
                            
                            <div class="et_pb_column et_pb_column_1_2 et_pb_column_15  et_pb_css_mix_blend_mode_passthrough et-last-child">

                                <div class="et_pb_module et_pb_blurb et_pb_blurb_1 et_clickable et_pb_text_align_left et_pb_blurb_position_top et_pb_bg_layout_dark">

                                    <div class="et_pb_blurb_content">

                                        <div class="et_pb_blurb_container">
	                                        <?php if ($rsvp != ""){ ?>
			                                    <h1 class="et_pb_module_header">
	                                            	<a href="#rsvp">Join the event</a>
                                            	</h1>
		                                    <?php } ?>
                                          

                                        </div>
                                    </div> <!-- .et_pb_blurb_content -->
                                </div> <!-- .et_pb_blurb -->
                                
                                <div class="et_pb_module et_pb_blurb et_pb_blurb_2 et_clickable  et_pb_text_align_left  et_pb_blurb_position_top et_pb_bg_layout_dark">

                                    <div class="et_pb_blurb_content">

                                        <div class="et_pb_blurb_container">
                                            <h1 class="et_pb_module_header">
	                                        <a href="#rsvp">
	                                            <?php the_title() ?> </a>
	                                        </h1>
                                            <div class="et_pb_blurb_description">
                                                <p><?php echo $date ?> / <?php echo $start_hour ?> <br> <?php echo $categories;	?> </p>
                                            </div>
                                        </div>
                                    </div> <!-- .et_pb_blurb_content -->
                                </div> <!-- .et_pb_blurb -->
                                <div class="et_pb_button_module_wrapper et_pb_button_1_wrapper et_pb_button_alignment_center et_pb_module ">
                                    <?php if ($rsvp != ""){ ?>
			                                    <a class="et_pb_button et_pb_button_1 et_pb_bg_layout_light" href="#rsvp">RSVP</a>
		                            <?php } ?>
                                </div>
                            </div> <!-- .et_pb_column -->
                            
                        </div> <!-- .et_pb_row -->
                        
                    </div> <!-- .et_pb_section -->
                    
                    
                    
                </div><!-- .et_builder_inner_content -->
            </div><!-- .et-l -->
        </div> <!-- .entry-content -->


    </article> <!-- .et_pb_post -->



</div>


<!-- Popup --> 
<div class="popup_outer_wrap type-popup position-center-center" style="z-index: 100001;">
    <div id="rsvp" class="et_pb_section et_pb_section_6 popup et_section_regular with-close is-open" style="display: block; max-width: 500px;">
        <div class="et_pb_row et_pb_row_9">
            <div class="et_pb_column et_pb_column_4_4 et_pb_column_16  et_pb_css_mix_blend_mode_passthrough et-last-child">
                <div class="et_pb_module et_pb_text et_pb_text_11  et_pb_text_align_left et_pb_bg_layout_light">

					<?php echo $rsvp; ?>

                </div>
                <!-- .et_pb_text -->
            </div>
            <!-- .et_pb_column -->
        </div>
        <!-- .et_pb_row -->
        <span class="evr-close_wrap"><a href="#close" class="evr-close">×</a></span>
    </div>
</div>




