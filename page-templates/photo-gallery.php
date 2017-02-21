<?php /* Template Name: Photo Gallery */ get_header(); ?>


<!-- TITLE
================================================== -->
<div class="title block">
	<div class="container">
		
		<div class="w100 columns">
			<h1><?php the_title(); ?></h1>
		</div>
		
	</div><!-- container -->
</div>


<!-- Body
================================================== -->
<div class="content block">
	<div class="container">
		
		<div class="w100 columns">
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>

				<?php the_content(); ?>

				<br class="clear">
				
			<?php endwhile; ?>
	
			<?php else: ?>
	
				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
	
			<?php endif; ?>
				
				<?php
		        $i = 1;
				$args['post_type'] = "gallery";
				$args['showposts'] = -1;
		        $args['orderby'] = "title";
		        $args['order'] = "ASC";
				
				query_posts( $args ); ?>
				
				<?php while (have_posts()) : the_post(); ?>
				
				<?php 
					// thumbnail
					$image = get_field('listing_image');
					$thumb = $image['sizes'][ 'listing' ];
				?>
					<?php if($i%3==1): ?><div class="row aligncenter"><?php endif; ?>
						<div class="w33 columns aligncenter">
							<h3><?php the_field('gallery_title'); ?></h3>
							<p><a href="<?php the_permalink(); ?>"><img  class="scale pic add-bottom" src="<?php echo $thumb; ?>" alt=""></a></p>
						</div>
					<?php if($i%3==0): ?></div><?php endif; $i++; ?>
				<?php endwhile; ?>
				<?php if ($i%3 != 1) echo "</div>"; ?>
	
				<?php edit_post_link(); ?>
		</div>

	</div><!-- container -->
</div>


<?php get_footer(); ?>
