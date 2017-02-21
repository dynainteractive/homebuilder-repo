<!-- sidebar -->
<aside class="sidebar" role="complementary">
	
	<div class="row aligncenter">
		<?php
		if( have_rows('social_media', 'option') ):
			while ( have_rows('social_media', 'option') ) : the_row();
		?>
		<a href="<?php the_sub_field('link'); ?>" target="outside"><img src="<?php the_sub_field('icon'); ?>" /></a>
		<?php
  				endwhile;
    	endif;
		?>
	</div>

	
	<div class="sidebar-widget">
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-1')) ?>
	</div>

</aside>
<!-- /sidebar -->
