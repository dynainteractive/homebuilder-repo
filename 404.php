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

		        <h1><?php _e( 'Whoops, page not found.', 'html5blank' ); ?></h1>
				<h2>
					<a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'html5blank' ); ?></a>
				</h2>

		</div>

		<div class="w30 columns aligncenter">	
					
			<?php get_sidebar(); ?>

		</div>

	</div><!-- container -->
</div>

<?php get_footer(); ?>
