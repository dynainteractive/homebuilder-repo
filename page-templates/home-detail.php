<?php 
//SET COMMUNITY
$community = get_field('community_link');
$comm_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_type='communities' AND post_title = %s",$community));

//SET FLOOR PLAN
$floorplan = get_field('floor_plan'); 

include('includes/alt-images.php');

//SET PRICE
$price = get_field('price'); 
if (!empty($price)) { $price = '$'.number_format($price); } else { $price = 'CALL FOR PRICE'; } 
?>


<!-- TITLE
================================================== -->
<div class="title block">
	<div class="container">
		
		<div class="w100 columns">
			<h1><span><?php the_field('city'); ?>, <?php the_field('state'); ?></span>
			<?php if( $community ): foreach( $community as $comm ): the_field('community_name', $comm->ID);  endforeach; endif; ?></h1>
		</div>
		
	</div><!-- container -->
</div>
		

<!-- Body
================================================== -->
<div class="content block" style="padding-top:10px;">
	<div class="container">
	
		<div class="w100 columns no-pad row">
			<script src="http://malsup.github.io/jquery.cycle2.carousel.js"></script>
			<div class="main-pic cycle-slideshow" data-cycle-fx="carousel" data-cycle-slides="> a">
		
				<?php 
		        $images = get_field('home_images');
		        if( $images ):
		        foreach( $images as $image ): ?>
		        <a href="<?php echo $image['url']; ?>" rel="group1"><img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
		        <?php endforeach;
		        else : 
		        	alt_main();
		        endif; ?>
		
			</div>
			
        </div>
        
        
        <br class="clear" /><br />
		
		<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
		
		<div class="row">
	        <!--Home Details-->
			<div class="w50 columns">
				<h1><?php the_field('address'); ?><span class="font18"><?php the_field('city'); ?>, <?php the_field('state'); ?></span></h1>
				
				<h2 class="bold"><?php echo $price; ?></h2>
	
				<p>
		           	<?php the_field('beds'); ?> Beds &nbsp;/&nbsp;
		           	<?php the_field('baths'); ?> Baths &nbsp;/&nbsp;
		           	<?php the_field('garage'); ?> Car Garage 
		           	<br />
		           	<?php the_field('sqft'); ?> SqFt &nbsp;/&nbsp;
		           	Timeframe: <?php the_field('timeline'); ?>
		           	<br />
		           	Floorplan: <?php if( $floorplan ): foreach( $floorplan as $fp ): ?> <a href="<?php echo get_permalink($fp->ID); ?>"><?php the_field('plan_name', $fp->ID); ?></a><?php endforeach; endif; ?>
		        </p>
	           	
	           	<br class="clear" />
			
				<a href="#fancyboxID-2" class="fancybox-inline btn">Mortgage Calculator</a>
				<?php if( get_field('brochure_pdf') ): ?><a href="<?php the_field('brochure_pdf'); ?>" target="outside" rel="nofollow" class="btn">Download PDF</a><?php endif; ?>
				<a href="#fancyboxID-1" class="fancybox-inline btn alt">Request Information</a>
			</div>
			
			<!--Map-->
			<div class="w50 columns">
				<?php 
				include('includes/map.php');
				$map = get_field('map');
				
				if( !empty($map) ):
				?>
				<div class="acf-map">
					<div class="marker" data-lat="<?php echo $map['lat']; ?>" data-lng="<?php echo $map['lng']; ?>"></div>
				</div>
				<?php endif; ?>
			</div>
		</div>
		
		<div class="row">
			<!--Overview-->
			<?php if(get_field('overview')):?>
			<div class="w50 columns">
				<?php the_field('overview'); ?>
			</div>
			<?php endif; ?>
	            
	        <!--Floor Plans-->   
	        <div class="w50 columns">
	        <?php 
			$images = get_field('floor_plans');
			if( $images ):
				foreach( $images as $image ): ?>
			    <a href="<?php echo $image['url']; ?>" rel="group2"><img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
			<?php endforeach; endif;  ?>
	        </div>	
	    </div>
	
		
		<!--Pop Up Blocks-->
		<div style="display:none" class="fancybox-hidden"><div id="fancyboxID-1" class="hentry" style="max-width:460px;width:100%">
			<h2 style="text-align:center;">Request Information</h2>
			<?php echo do_shortcode('[contact-form-7 id="466" title="Community/Home Contact"]'); ?>
		</div></div>
		
		<div style="display:none" class="fancybox-hidden"><div id="fancyboxID-2" class="hentry" style="max-width:460px;width:100%">
			<h2 style="text-align:center;">Monthly Payment Calculator</h2>
			<iframe scrolling="no" src="http://www.zillow.com/mortgage/MortgageCalculatorWidgetLarge.htm?" width="100%" frameborder="0" height="700px"></iframe>
		</div></div>
		
        
	</div><!-- container -->
</div>
        
<!--Community Contact & Social Share-->
<div class="gray-box block">
	<div class="container">
		
		<div class="w50 columns">	
				<?php if( have_rows('community_contact', $comm_id) ):?>
					<?php while ( have_rows('community_contact', $comm_id) ) : the_row(); ?>
					 <div class="w40 columns alpha">
					 	<img src="<?php the_sub_field('contact_photo'); ?>" />
					 </div>
					 <div class="w60 columns omega">
						 <h3 class="remove-bottom"><?php the_sub_field('contact_name'); ?></h3>
						 <small><?php the_sub_field('contact_title'); ?></small>
						 <hr class="half-bottom" />
				         <p><?php the_sub_field('contact_phone'); ?><br /><a href="mailto:<?php the_sub_field('contact_email'); ?>"><?php the_field('contact_email'); ?></a></p>
					</div>
					<?php endwhile;?> 
				<?php endif; ?>
		</div>
		
		<div class="w50 columns">
			<h1>Share with a Friend</h1>
			
			<a href="https://twitter.com/intent/tweet?text=Sharing this great home by TimberCraft Homes: <?php echo get_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/media/share-twitter.png" width="70" height="70" /></a>
			<a href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink(); ?>" target="outside"><img src="<?php echo get_template_directory_uri(); ?>/images/media/share-facebook.png" width="70" height="70" /></a>
			<a href="https://www.linkedin.com/cws/share?url=<?php echo get_permalink(); ?>" target="outside"><img src="<?php echo get_template_directory_uri(); ?>/images/media/share-linkedin.png" width="70" height="70" /></a>
			<a href="http://pinterest.com/pin/create/button/?url=<?php echo get_permalink(); ?>&description=TimberCraft Homes : <?php the_field('address'); ?>" data-pin-do="buttonPin" data-pin-custom="true" target="outside"><img src="<?php echo get_template_directory_uri(); ?>/images/media/share-pinterest.png" width="70" height="70" /></a>
			<a href="mailto:?body=Sharing this great home by TimberCraft Homes: <?php echo get_permalink(); ?>" target="outside"><img src="<?php echo get_template_directory_uri(); ?>/images/media/share-mail.png" width="70" height="70" /></a>
		</div>
			
	</div><!-- container -->
</div>

