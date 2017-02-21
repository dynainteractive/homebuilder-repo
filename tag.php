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

			<h1><?php _e( 'Tag Archive: ', 'html5blank' ); echo single_tag_title('', false); ?></h1>

			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>

		</div>

		<div class="w30 columns">	
					
			<?php get_sidebar(); ?>

		</div>

	</div><!-- container -->
</div>

<?php get_footer(); ?>
