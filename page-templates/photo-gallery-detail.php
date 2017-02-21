<!-- TITLE
================================================== -->
<div class="title block">
	<div class="container">
		
		<div class="w100 columns">
			<h1>Photo Gallery</h1>
		</div>
		
	</div><!-- container -->
</div>


<!-- Body
================================================== -->
<div class="content block">
	<div class="container">
		
		<div class="w70 columns">
			<h1><?php the_field('gallery_title'); ?></h1>	      		
	      	
	      	<?php if(get_field('gallery_description')):?><p><?php the_field('gallery_description'); ?></p><?php endif; ?>
	      	
      		<br class="clear">
      		
      		<?php
			$images = get_field('photos');
			
			if( $images ): ?>
		        <?php foreach( $images as $image ): ?>
		            <div class="w25 columns">
		                <a href="<?php echo $image['url']; ?>" class="fancybox" rel="show">
		                     <img src="<?php echo $image['sizes']['listing']; ?>" class="scale pic add-bottom" alt="<?php echo $image['alt']; ?>" />
		                </a>
		            </div>
		        <?php endforeach; ?>
			<?php endif; ?>
	      		
		</div>
		
		<div class="w30 columns" id="sidebar">
			
			<p><a href="javascript:window.history.back();"><strong>Back to Galleries &raquo;</strong></a></p>
			
			<div class="row">
			<?php
		        $i = 1;
				$args['post_type'] = "gallery";
				$args['showposts'] = -1;
		        $args['orderby'] = "title";
		        $args['order'] = "ASC";
				
				query_posts( $args ); ?>
				<h2>Photo Gallery</h2>
				<ul class="sub-nav">
				<?php while (have_posts()) : the_post(); ?>
			    	<li><a href="<?php the_permalink(); ?>"><?php the_field('gallery_title'); ?></a></li>
				<?php endwhile; ?>
				</ul>
			</div>

		</div>

	</div><!-- container -->
</div>


<?php get_footer(); ?>
