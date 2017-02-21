<?php 
$postid = get_the_ID(); 
$_SESSION['referer'] = $postid;

//QUERY FLOOR PLANS
$plans = get_posts(array( 'post_type' => 'floorplans', 'showposts' => -1, 'orderby' => 'title', 'order' => 'ASC', 'meta_query' => array( array( 'key' => 'community', 'value' => '"' . get_the_ID() . '"', 'compare' => 'LIKE' ) ) ));

//QUERY AVAILABLE HOMES
$homes = get_posts(array( 'post_type' => 'homes', 'showposts' => -1, 'meta_query' => array( array( 'key' => 'community_link', 'value' => get_field('community_name') ) ) ));

//QUERY MODEL HOMES
$models = get_posts(array( 'post_type' => 'homes', 'showposts' => -1, 'meta_query' => array( array( 'key' => 'community_link', 'value' => get_field('community_name') ), array( 'key' => 'status', 'value' => 'Model' ) ) ));
?>


<!-- TITLE
================================================== -->
<div class="title block">
	<div class="container">
		
		<div class="w100 columns">
			<h1><span><?php the_field('city'); ?>, <?php the_field('state'); ?></span>
			<?php the_field('community_name'); ?></h1>
		</div>
		
	</div><!-- container -->
</div>


<!-- Body
================================================== -->
<div class="content block" style="padding-top:10px;">
	<div class="container">
	
		<div class="w100 columns no-pad row">
            <div class="main-pic cycle-slideshow" data-cycle-slides="> a">
            <?php 
            $images = get_field('community_images');
            if( $images ):
                foreach( $images as $image ): ?>
                <a href="<?php echo $image['url']; ?>"><img src="<?php echo $image['sizes']['main']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
                <?php endforeach;
            endif; ?>
            </div>
        </div>
        
        <div class="w70 columns">
        	<?php if(get_field('overview')): ?>	
				<h1>Community Overview</h1>	
				<?php the_field('overview'); ?>
			<?php endif; ?>
		</div>
		
		<div class="w30 columns">
			<iframe width="100%" height="250" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA2Msc7JV9WP6UQNQG8neUWqm87otIN0eU &q=<?php the_field('address'); ?>,<?php the_field('city'); ?>,<?php the_field('state'); ?>,<?php the_field('zip_code'); ?>,<?php the_field('lat_long'); ?>"></iframe>
		</div>
		
		<br class="clear" />
		
	</div><!-- container -->
</div>  
        

<!-- Community Navigation
================================================== -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript">
function showPanel(intPanel) {
	$('.tab').removeClass('on');
	$('#tab' + intPanel).addClass('on');
	
	$('.sec').hide();
	$('#sec' + intPanel).show();
	
	$('#sec' + intPanel).css({"visibility": "visible", "height": "auto"});
}

</script>

<ul class="comm-nav">
	<?php if($plans): ?><li class="tab on" id="tab1"><a href="#" onclick="showPanel(1); return false;">Home Designs</a></li><?php endif; ?>
	<?php if($homes): ?><li class="tab" id="tab2"><a href="#" onclick="showPanel(2); return false;">Available Homes</a></li><?php endif; ?>
	<?php if($models): ?><li class="tab" id="tab3"><a href="#" onclick="showPanel(3); return false;">Model Homes</a></li><?php endif; ?>
	<?php if(get_field('site_plan')): ?><li class="tab" id="tab4"><a href="#" onclick="showPanel(4); return false;">Site Plan</a></li><?php endif; ?>
    <?php if(get_field('local_area')): ?><li class="tab" id="tab5"><a href="#" onclick="showPanel(5); return false;">Local Area</a></li><?php endif; ?>
    <?php if(get_field('amenities')): ?><li class="tab" id="tab6"><a href="#" onclick="showPanel(6); return false;">Amenities</a></li><?php endif; ?>
    <li class="tab" id="tab7"><a href="#fancyboxID-1" class="fancybox-inline">Request Information</a></li>
</ul>
        
<!-- Body
================================================== -->
<div class="content block" style="padding-top:0;">
	<div class="container">
	
		<div class="w100 columns">
			<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
						
			<div class="sec" id="sec1" style="display:block;">
				<h1>Home Designs</h1>
				<?php	
				$count = 1;
				//START PLAN LOOP
				if( $plans ):
				foreach( $plans as $plan ):
					// GET LISTING IMAGE
					$image = get_field('listing_image', $plan->ID);
					$thumb = $image['sizes'][ 'listing' ];

					//CHECK PRICING
					if( have_rows('floor_plan_prices') ):
					    while ( have_rows('floor_plan_prices') ) : the_row();
					    	$fp = get_sub_field('floor_plan');
							if($plan->ID == $fp) {
								$price = '$'.number_format(get_sub_field('price'));
								break;
							} else {
								$price = get_field('price', $plan->ID);
								if (empty($price) OR $price=='0') { $price = "Call For Price"; }
								else { $price = '$'.number_format($price); }
							}
					    endwhile;
					else : 
						$price = get_field('price', $plan->ID);
						if (empty($price) OR $price=='0') { $price = "Call For Price"; }
						else { $price = '$'.number_format($price); }
					endif;
				?>
				
                <?php if($count%3==1) { ?><div class="row"><?php } ?>                
                <div class="w33 columns home-listing">
                	<?php 
					
					?>
                    <a href="<?php echo get_permalink( $plan->ID ); ?>"><img src="<?php echo $thumb; ?>" class="half-bottom" /></a>

                	<h2 class="font18 blue semi remove-bottom"><?php the_field('plan_name', $plan->ID); ?></h2>
                    <p class="half-bottom font14"><?php the_field('beds', $plan->ID); ?> Beds &nbsp;/&nbsp; <?php the_field('baths', $plan->ID); ?> Baths &nbsp;/&nbsp; <?php the_field('garage', $plan->ID); ?> Car &nbsp;/&nbsp; <?php the_field('sqft', $plan->ID); ?> SqFt</p>
                    <div class="aligncenter"><a href="<?php echo get_permalink( $plan->ID ); ?>" class="btn">View Design</a></div>
                </div>
                <?php if($count%3==0) { echo '</div>'; } $count++; ?>
				<?php endforeach; else: ?>
                <p>Sorry, there are currently no floor designs available, check back soon.</p>
				<?php endif; 
				if ($count%3 != 1) echo "</div>";
				//END PLAN LOOP 
				?>
			</div>
			
			<div class="sec" id="sec2">
				<h1>Available Homes</h1>
				
				<?php
				include('includes/alt-images.php');

				$count = 1; 
				//QUERY AVAILABLE HOMES
				if( $homes ):
				foreach( $homes as $home ): 
					//GET LISTING IMAGE
					$image = get_field('listing_image', $home->ID);
					$thumb = $image['sizes'][ 'listing' ];
					
					//CHECK PRICING
					$price = get_field('price', $home->ID);
					if (empty($price) OR $price=='0') { $price = "Call For Price"; }
					else { $price = '$'.number_format($price); }
				?>
				
                <?php if($count%3==1) { ?><div class="row"><?php } ?>
                <div class="w33 columns home-listing">
					<div class="pic">
                   		<a href="<?php echo get_permalink( $home->ID ); ?>"><?php if(get_field('listing_image', $home->ID)) { ?><img src="<?php echo $thumb; ?>" class="half-bottom" /><?php } else { alt_featured($home->ID); }?></a>
                   		<?php if(get_field('status', $home->ID) == 'Sold'):?><div class="sold-banner">Sold</div><?php endif; ?>
                		<?php if(get_field('status', $home->ID) == 'Pending'):?><div class="pending-banner">Pending</div><?php endif; ?>
                   	</div>

                    <h2 class="font18 blue semi remove-bottom"><?php the_field('address', $home->ID); ?></a></h2>
                    <div class="w50 columns alpha">
                    	<?php the_field('city', $home->ID); ?>, <?php the_field('state', $home->ID); ?>
                    </div>
                    <div class="w50 columns omega alignright">
                    	Timeframe: <?php the_field('status', $home->ID); ?>
                    </div>
                    <br class="clear" />
                    <p><strong><?php echo $price; ?></strong> &nbsp;/&nbsp; <?php the_field('beds', $home->ID); ?> Beds &nbsp;/&nbsp; <?php the_field('baths', $home->ID); ?> Baths &nbsp;/&nbsp; <?php the_field('garage', $home->ID); ?> Car &nbsp;/&nbsp; <?php the_field('sqft', $home->ID); ?> SqFt</p>
                    <div class="aligncenter"><a href="<?php echo get_permalink( $home->ID ); ?>" class="btn">View Home</a></div>
                </div>
				<?php if($count%3==0) { echo '</div>'; } $count++; ?>
                <?php endforeach; else: ?>
                <p>Sorry, there are currently no available homes, check back soon.</p>
				<?php endif; 
				if ($count%3 != 1) echo "</div>";  
				//END HOME LOOP 
				?>
			</div>
			
			<div class="sec" id="sec3">
                <h1>Model Home</h1>
                
                <?php
                $count = 1; 
                if( $models ):
                foreach( $models as $model ): 
                	//CHECK PRICING
                	$price = get_field('price', $model->ID);
					if (empty($price) OR $price=='0') { $price = "Call For Price"; }
					else { $price = '$'.number_format($price); }
					
					//GET LISTING IMAGE
					$image = get_field('listing_image', $model->ID);
					$thumb = $image['sizes'][ 'listing' ];
                ?>
                
                <?php if($count%3==1) { ?><div class="row"><?php } ?>
                <div class="w33 columns home-listing">
                   	<?php 
					
					?>
					<div class="pic">
                   		<a href="<?php echo get_permalink( $model->ID ); ?>"><?php if(get_field('listing_image', $model->ID)) { ?><img src="<?php echo $thumb; ?>" class="half-bottom" /><?php } else { alt_featured($model->ID); }?></a>
                   	</div>

                    <h2 class="font18 blue semi remove-bottom"><?php the_field('address', $model->ID); ?></a></h2>
                    <?php the_field('city', $model->ID); ?>, <?php the_field('state', $model->ID); ?>
                    <br class="clear" />
                    <p><strong><?php echo $price; ?></strong> &nbsp;/&nbsp; <?php the_field('beds', $model->ID); ?> Beds &nbsp;/&nbsp; <?php the_field('baths', $model->ID); ?> Baths &nbsp;/&nbsp; <?php the_field('garage', $model->ID); ?> Car &nbsp;/&nbsp; <?php the_field('sqft', $model->ID); ?> SqFt</p>
                    <div class="aligncenter"><a href="<?php echo get_permalink( $model->ID ); ?>" class="btn">View Home</a></div>
                </div>
				<?php if($count%3==0) { echo '</div>'; } $count++; ?>
                <?php endforeach; else: ?>
                <p>Sorry, there are currently no model homes, check back soon.</p>
				<?php endif; 
				if ($count%3 != 1) echo "</div>";
				//END MODEL LOOP  
				?>
           </div>
			
			<div class="sec" id="sec4" style="display:block; visibility:hidden; height:0;">
				<h1>Site Plan</h1>
				<?php the_field('site_plan'); ?>
				
				<script>
				$( ".trigger" ).click(function() {
					$(".trigger").hide();
					$(".reveal").css({"visibility": "visible", "height": "auto"});
					return false;
				});
				</script>
			</div>
            
            <div class="sec" id="sec5">
                <h1>Local Area</h1>
                
                <?php the_field('local_area'); ?>
                    
           	</div>
           
           	<div class="sec" id="sec6">
            	<h1>Amenities</h1>
                
                <?php the_field('amenities'); ?>
                    
			</div>
           
           	<div style="display:none" class="fancybox-hidden"><div id="fancyboxID-1" class="hentry" style="max-width:460px;width:100%">
				<h2 style="text-align:center;">Request Information</h2>
				<?php echo do_shortcode('[contact-form-7 id="143" title="Community/Home Contact"]'); ?>
			</div></div>
           
    	</div>
	
	</div><!-- container -->
</div>  


<div class="gray-box block">
	<div class="container">
		
		<div class="w50 columns">
			
			<?php 
			//COMMUNITY CONTACT
			if( have_rows('community_contact') ):?>
				<?php while ( have_rows('community_contact') ) : the_row(); ?>
				 <div class="w40 columns alpha">
				 	<img src="<?php the_sub_field('contact_photo'); ?>" />
				 </div>
				 <div class="w60 columns omega">
					 <h3 class="remove-bottom"><?php the_sub_field('contact_name'); ?></h3>
					 <small><?php the_sub_field('contact_title'); ?></small>
					 <hr class="half-bottom" />
			         <p><?php the_sub_field('contact_phone'); ?><br /><a href="mailto:<?php the_field('contact_email'); ?>"><?php the_field('contact_email'); ?></a></p>
				</div>
				<?php endwhile;?> 
			<?php endif; ?>
				
		</div>
		
		<div class="w50 columns">
			<h1>Share with a Friend</h1>
			
			<a href="https://twitter.com/intent/tweet?text=Sharing this great community: <?php echo get_permalink(); ?>" target="outside"><img src="<?php echo get_template_directory_uri(); ?>/images/media/share-twitter.png" width="70" height="70" /></a>
			<a href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink(); ?>" target="outside"><img src="<?php echo get_template_directory_uri(); ?>/images/media/share-facebook.png" width="70" height="70" /></a>
			<a href="https://www.linkedin.com/cws/share?url=<?php echo get_permalink(); ?>" target="outside"><img src="<?php echo get_template_directory_uri(); ?>/images/media/share-linkedin.png" width="70" height="70" /></a>
			<a href="http://pinterest.com/pin/create/button/?url=<?php echo get_permalink(); ?>&description=<?php the_field('community_name'); ?>" data-pin-do="buttonPin" data-pin-custom="true" target="outside"><img src="<?php echo get_template_directory_uri(); ?>/images/media/share-pinterest.png" width="70" height="70" /></a>
			<a href="mailto:?body=Sharing this great community by TimberCraft Homes: <?php echo get_permalink(); ?>" target="outside"><img src="<?php echo get_template_directory_uri(); ?>/images/media/share-mail.png" width="70" height="70" /></a>
		</div>
			
	</div><!-- container -->
</div>