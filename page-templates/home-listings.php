<?php /* Template Name: Home Listings */ get_header(); ?>

<!-- TITLE
================================================== -->
<div class="title block">
	<div class="container">
		
		<div class="w100 columns">
			<h1><span>Home Builder</span><?php the_title(); ?></h1>
		</div>
		
	</div><!-- container -->
</div>


<!-- Body
================================================== -->
<div class="content block">
	<div class="container">
		
		<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
		
		<div class="w100 columns">
			<?php include("includes/search-bar2.php"); ?>
		</div>
		
		<br class="clear" />
				
	    <?php
	    include('includes/alt-images.php');
	    $count = 1;
	    $prevCat = null;
    
    	if($_POST['search'] == 'true') {
	   		//QUERY CUSTOM SEARCH
	    	$args['post_type'] = "homes";
	    	$args['showposts'] = -1;
	    	$args['meta_key'] = 'community_link';
	    	$args['order'] = ASC;
	   		$args['orderby'] = 'meta_value';
	   	   	    
	    	if( $_POST['comm_name'] != 0 ) {
	        	$comm_name = $_POST['comm_name'];
	        	$args['meta_query'][] = array(
	            	'key' => 'community_link',
	            	'value' => $comm_name
	        	);
	    	}
	    
			if( $_POST['sqft_range'] != 0 ) {
		        $sqft_range = $_POST['sqft_range'];
		        list($string1, $string2) = explode(',', $sqft_range);
		        $args['meta_query'][] = array(
		            'key' => 'sqft',
		            'value' => array($string1, $string2),
		            'compare' => 'BETWEEN',
		            'type' => 'numeric'
		        );
		    }
	    
		    if( $_POST['min_beds'] != 0 ) {
		        $args['meta_query'][] = array(
		            'key' => 'beds',
		            'value' => $_POST['min_beds'],
		            'compare' => '>='
		        );
		    }
	    
		    if( $_POST['min_baths'] != 0 ) {
		        $args['meta_query'][] = array(
		            'key' => 'baths',
		            'value' => $_POST['min_baths'],
		            'compare' => '>='
		        );
		    }
		    
		    if( $_POST['min_garage'] != 0 ) {
		        $args['meta_query'][] = array(
		            'key' => 'garage',
		            'value' => $_POST['min_garage'],
		            'compare' => '>='
		        );
		    }
		    
		    $loop = new WP_Query( $args );
	    
	    	if(empty($loop)) { echo '<div class="w100 columns aligncenter"><h3 class="blue">Sorry, your search produced no available homes.  Please refine your search.</h3></div>'; }
		} 
	
		else if($_POST['search'] != 'true') { 
		
		    $args = array(
				'post_type' => 'homes',
				'showposts'	=> -1,
				'meta_key' 	=> 'community_link',
				'orderby'	=> 'meta_value',
				'order'		=> ASC
			);
			$loop = new WP_Query( $args );
    	} 
    	?>

    	<?php while ($loop->have_posts()) : $loop->the_post(); 
    	
    	$cat = get_field('community_link'); 
		
		// set community id
		$comm_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_type='communities' AND post_title = %s",$cat));
		
		if ($cat != $prevCat) {  
			if(($count==3) OR ($count%3 != 1)) { echo "</div>"; }
			$count=1;
			echo '<h1 class="remove-bottom">'.$cat.'</h1>';
			echo "<p>".get_field('city', $comm_id).", ".get_field('state', $comm_id)." &nbsp; <small>(<a href=\"".get_permalink($comm_id)."\" style=\"text-decoration:none;\">view community</a>)</small></p>"; 
		}
		?>
    
    	<?php if($count%3==1) { ?><div class="row"><?php } ?>
        <div class="w33 columns home-listing">
        	<?php 
			// thumbnail
			$image = get_field('listing_image');
			$thumb = $image['sizes'][ 'listing' ];
			$width = $image['sizes'][ 'listing-width' ];
			$height = $image['sizes'][ 'listing-height' ];
			
			// price
			$price = get_field('price');
			if (empty($price) OR $price=='0') { $price = "Call For Price"; }
			else { $price = '$'.number_format($price); }
			?>
            <div class="pic">
                <a href="<?php the_permalink(); ?>"><?php if(get_field('listing_image')) { ?><img src="<?php echo $thumb; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" /><?php } else { alt_featured($post->ID); }?></a>
                <?php if(get_field('status') == 'Sold'):?><div class="sold-banner">Sold</div><?php endif; ?>
                <?php if(get_field('status') == 'Pending'):?><div class="pending-banner">Pending</div><?php endif; ?>
            </div>
            
            <h2 class="font18 semi blue remove-bottom"><a href="<?php the_permalink(); ?>"><?php the_field('address'); ?></a></h2>
            <p class="half-bottom"><?php the_field('city'); ?>, <?php the_field('state'); ?></p>
            <p class="half-bottom"><strong><?php echo $price; ?></strong> - <?php the_field('beds'); ?> Beds &nbsp;/&nbsp; <?php the_field('baths'); ?> Baths &nbsp;/&nbsp; <?php the_field('garage'); ?> Car &nbsp;/&nbsp; <?php the_field('sqft'); ?> SqFt</p>
            <div class="aligncenter"><a href="<?php the_permalink(); ?>" class="btn">View Home</a></div>
        </div>
    	<?php if($count%3==0) { echo '</div>'; } $count++; $prevCat = $cat; ?>
    	
    	<?php endwhile; if ($count%3 != 1) echo "</div>"; ?>
    	
	</div><!-- container -->
</div>

<?php get_footer(); ?>
