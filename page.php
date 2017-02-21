<?php get_header(); ?>

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
		
		<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
		

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<?php the_content(); ?>
			
			<?php edit_post_link(); ?>

		<?php endwhile; ?>

		<?php else: ?>

			<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

		<?php endif; ?>


	</div><!-- container -->
</div>





<?php get_footer(); ?>
