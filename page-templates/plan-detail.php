<?php 
$referer = $_SESSION['referer'];
$postid = get_the_ID(); 
$community = get_field('community'); 

if (!empty($referer)) {
	//echo $referer;
	if( have_rows('floor_plan_prices', $referer) ):
	    while ( have_rows('floor_plan_prices', $referer) ) : the_row();
	    	$fp = get_sub_field('floor_plan');
			if($postid == $fp) {
				$price = '$'.number_format(get_sub_field('price'));
				$custo = 1;
				break;
			} else { $custo = 0; }
	    endwhile;
	else : 
		$custo = 0;
	endif;
} 

if(empty($referer) OR ($custo == 0)) {
	$price = get_field('price'); 
	if (!empty($price)) { $price = '$'.number_format($price); } else { $price = 'CALL FOR PRICE'; } 
}
?>

<!-- TITLE
================================================== -->
<div class="title block">
	<div class="container">
		
		<div class="w100 columns">
			<h1>Home Designs</h1>
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
            $images = get_field('elevations');
            if( $images ):
                foreach( $images as $image ): ?>
                <a href="<?php echo $image['url']; ?>"><img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
                <?php endforeach;
            endif; ?>
            </div>
        </div>
        
        

        
		<div class="row">
        
	        <!--Home Details-->
			<div class="w50 columns">
				<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
				
				<h1><?php the_field('plan_name'); ?></h1>
	            <h3 class="bold"><?php echo $price; ?></h3>
	            
	            <p><?php the_field('beds'); ?> Beds &nbsp;&nbsp;/&nbsp;&nbsp;
	            <?php the_field('baths'); ?> Baths &nbsp;&nbsp;/&nbsp;&nbsp;
	            <?php the_field('garage'); ?> Car Garage <br />
	            <?php the_field('sqft'); ?> SqFt
	            <?php if(!empty($referer)) { echo '&nbsp;/&nbsp; <a href="'.get_permalink($referer).'">'.get_the_title($referer).'</a>'; } ?>
	            </p>
	            
	            <div class="aligncenter">
	            	<a href="#fancyboxID-1" class="fancybox-inline btn alt">Request Information</a>
	            
		            <?php if( get_field('brochure_pdf') ): ?>
		            <a href="<?php the_field('brochure_pdf'); ?>" class="btn" target="outside" rel="nofollow">Download PDF</a>
		            <?php endif; ?>
		       	</div>
	        </div>
	        
	        <!--Floor Plans-->
	        <div class="w50 columns">
	        	<?php 
					$images = get_field('floor_plans');
					if( $images ):
					foreach( $images as $image ): ?>
				    <div class="w50 columns"><a href="<?php echo $image['url']; ?>" rel="group1"><img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" /></a></div>
				    <?php endforeach;
				    else :
				    	alt_fp();
			   	 	endif; ?>
	        </div>
        </div>
        
        <?php if(get_field('overview')) { ?>
        <div class="w100 columns">
        	<?php the_field('overview'); ?>
        </div>
        <?php } ?>
        
		
		<!--Popup Block-->
		<div style="display:none" class="fancybox-hidden"><div id="fancyboxID-1" class="hentry" style="max-width:460px;width:100%">
			<h2 style="text-align:center;">Request Information</h2>
			<?php echo do_shortcode('[contact-form-7 id="466" title="Community/Home Contact"]'); ?>
		</div>
		
        
        <br class="clear" /><br />
                
	</div><!-- container -->
</div>


<br /><br />


<div class="gray-box block">
	<div class="container">
		
		<div class="w50 columns">
			<?php  if( !empty($referer) ) { ?>
			<?php if( have_rows('community_contact', $referer) ):?>
				<?php while ( have_rows('community_contact', $referer) ) : the_row(); ?>
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
			<?php  } ?>
				
		</div>
		
		<div class="w50 columns">
			<h1>Share with a Friend</h1>
			
			<a href="https://twitter.com/intent/tweet?text=Sharing this great home by TimberCraft Homes: <?php echo get_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/media/share-twitter.png" width="70" height="70" /></a>
			<a href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink(); ?>" target="outside"><img src="<?php echo get_template_directory_uri(); ?>/images/media/share-facebook.png" width="70" height="70" /></a>
			<a href="https://www.linkedin.com/cws/share?url=<?php echo get_permalink(); ?>" target="outside"><img src="<?php echo get_template_directory_uri(); ?>/images/media/share-linkedin.png" width="70" height="70" /></a>
			<a href="http://pinterest.com/pin/create/button/?url=<?php echo get_permalink(); ?>&description=TimberCraft Homes : <?php the_field('plan_name'); ?>" data-pin-do="buttonPin" data-pin-custom="true" target="outside"><img src="<?php echo get_template_directory_uri(); ?>/images/media/share-pinterest.png" width="70" height="70" /></a>
			<a href="mailto:?body=Sharing this great home by TimberCraft Homes: <?php echo get_permalink(); ?>" target="outside"><img src="<?php echo get_template_directory_uri(); ?>/images/media/share-mail.png" width="70" height="70" /></a>
		</div>
			
	</div><!-- container -->
</div>

