<?php session_start(); unset($_SESSION['referer']); ?>
<?php /* Template Name: Plan Listings */ get_header(); ?>


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
			<?php include("includes/search-bar.php"); ?>
		</div>
		
		
		<div class="w100 columns" id="home-designs">
			<?php
	        $count = 1;
	        $prevID = null;
	
	        if($_POST['search'] == 'true') {
	            //QUERY CUSTOM SEARCH
	            $args['post_type'] = "floorplans";
	            $args['showposts'] = -1;
	            $args['order'] = ASC;
	            
	            
	            if( !empty($_POST['plan_select']) ) {
	                $args['meta_query'][] = array(
	                    'key' => 'plan_name',
	                    'value' => $_POST['plan_select']
	                );
	                $args['orderby'] = 'title';
	            }
	           
	            
	            if( $_POST['comm_name'] != 0 ) {
	                $comm_name = $_POST['comm_name'];
	                $args['meta_query'][] = array(
	                    'key' => 'community',
	                    'value' => '"' . $comm_name . '"',
	                    'compare' => 'LIKE'
	                );
	                $args['orderby'] = 'title';
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
	                $args['meta_key'] = 'sqft';
	                $args['orderby'] = 'meta_value';
	            }
	            
	            if( $_POST['min_beds'] != 0 ) {
	                $args['meta_query'][] = array(
	                    'key' => 'beds',
	                    'value' => $_POST['min_beds'],
	                    'compare' => '>='
	                );
	                $args['meta_key'] = 'beds';
	                $args['orderby'] = 'meta_value';
	            }
	            
	            if( $_POST['min_baths'] != 0 ) {
	                $args['meta_query'][] = array(
	                    'key' => 'baths',
	                    'value' => $_POST['min_baths'],
	                    'compare' => '>='
	                );
	                $args['meta_key'] = 'baths';
	                $args['orderby'] = 'meta_value';
	            }
	            
	            if( $_POST['min_garage'] != 0 ) {
	                $args['meta_query'][] = array(
	                    'key' => 'garage',
	                    'value' => $_POST['min_garage'],
	                    'compare' => '>='
	                );
	                $args['meta_key'] = 'garage';
	                $args['orderby'] = 'meta_value';
	            }
	            
	            $plans = query_posts($args);
	            
	            if(empty($plans)) { echo '<div class="w100 columns aligncenter"><h3 class="blue">Sorry, your search produced no available homes.  Please refine your search.</h3></div>'; }
	        } else {
	            //QUERY ALL PLANS
	            $args['post_type'] = "floorplans";
				$args['showposts'] = -1;
	            $args['orderby'] = "title";
	            $args['order'] = "ASC";
				
				query_posts( $args );
	        }
			//main loop
			while (have_posts()) : the_post(); ?>
			
			<?php if($count%3==1) { ?><div class="row"><?php } ?>
                <div class="w33 columns">
                	<?php 
					// thumbnail
					$image = get_field('listing_image');
					$thumb = $image['sizes'][ 'listing' ];
					
					//price check	
					$price = get_field('price');
					if (empty($price) OR $price=='0') { $price = "Call For Price"; }
					else { $price = '<span class="font12">Starting from</span> $'.number_format($price); }
					?>
                    <a href="<?php the_permalink(); ?>"><img src="<?php echo $thumb; ?>" class="add-bottom" /></a>

                   	<h2 class="font18 blue semi"><a href="<?php the_permalink(); ?>"><?php the_field('plan_name'); ?></a></h2>
                    <p class="half-bottom font16 bold"><?php echo $price; ?></p>
                    <p class="half-bottom font14"><?php the_field('beds'); ?> Beds &nbsp;/&nbsp; <?php the_field('baths'); ?> Baths &nbsp;/&nbsp; <?php the_field('garage'); ?> Car &nbsp;/&nbsp; <?php the_field('sqft'); ?> SqFt</p>
        			<div class="aligncenter"><a href="<?php the_permalink(); ?>" class="btn blue">View Design</a></div>
                </div>
            <?php 
            if($count%3==0) { echo '</div>'; } $count++;

            endwhile;
            //end main loop
            if ($count%3 != 1) echo "</div>";
            ?>
            
		</div>
		
		<div class="pagination"></div>

	</div><!-- container -->
</div>

<?php get_footer(); ?>
