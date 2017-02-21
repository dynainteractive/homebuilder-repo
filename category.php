<?php get_header(); ?>

<!-- TITLE
================================================== -->
<div class="title block">
	<div class="container">
		
		<div class="w100 columns">
			<h1><?php blog_title(); ?></h1>
		</div>
		
	</div><!-- container -->
</div>

<!-- Body
================================================== -->
<div class="content block">
	<div class="container">
		
		<div class="w70 columns">

			<h1><?php _e( 'Categories for ', 'html5blank' ); single_cat_title(); ?></h1>

			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>

		</div>

		<div class="w30 columns">	
					
			<?php get_sidebar(); ?>

		</div>

	</div><!-- container -->
</div>

<?php get_footer(); ?>
