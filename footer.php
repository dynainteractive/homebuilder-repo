


<!-- Extra
================================================== -->
<div class="extra block">
	<div class="container">
		
		<div class="w70 columns">
			<h1>News & Events</h1>
		<?php
		$posts = get_posts ("showposts=2");
		if ($posts) :
		  foreach ($posts as $post):
		    setup_postdata($post); 
		?>
	        <div class="row">
	            <div class="post">
	                <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
	                <?php alt_wp_excerpt('alt_wp_index'); ?>
	            </div>
	        </div>
		<?php 
			endforeach;
		endif;
		wp_reset_query();
		?>
			<div class="aligncenter"><a href="<?php echo home_url(); ?>/our-blog" class="btn">View All Posts</a></div>
		</div>
        
        <div class="w30 columns border">
        	<h2>Stay Connected</h2>
        	
        	<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=643185362463324";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			
			<div class="fb-page add-bottom" data-href="https://www.facebook.com/PAGENAMEHERE" data-tabs="timeline" data-height="220" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/PAGENAMEHERE"><a href="https://www.facebook.com/PAGENAMEHERE">PAGENAMEHERE</a></blockquote></div></div>
        	
        	<?php if(get_field('newsletter', 'options')): ?>
        		<?php the_field('newsletter', 'options'); ?>
        	<?php endif; ?>
        	
        	<br class="clear" />
        	
			<ul class="social-icons">
				<?php if( have_rows('social_media', 'options') ): while ( have_rows('social_media', 'options') ) : the_row(); ?>
				<li><a href="<?php the_sub_field('link'); ?>" target="outside"><img src="<?php the_sub_field('icon'); ?>" style="height:25px; width:auto;" /></a></li>
				<?php endwhile; endif; ?>
			</ul>
        </div>

    </div><!-- container -->
</div>


<!-- Footer
================================================== -->
<div class="footer block">
	<div class="container">
		
		<div class="w100 columns aligncenter">
			
			<?php nav(); ?>
			
			<br class="clear" />
			
			<?php the_field('footer', 'options'); ?>
			
			
			<ul class="inline">
				<?php if( have_rows('affiliate_logos', 'options') ): while ( have_rows('affiliate_logos', 'options') ) : the_row(); ?>
				<li><a href="<?php the_sub_field('link'); ?>" target="outside"><img src="<?php the_sub_field('logo'); ?>" style="height:65px; width:auto;" /></a></li>
				<?php endwhile; endif; ?>
			</ul>
		</div>
		
	</div><!-- container -->
</div>

<?php wp_footer(); ?>

<!-- analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-39580808-1', 'auto');
  ga('send', 'pageview');

</script>

<script type="text/javascript" async  data-pin-hover="true" src="//assets.pinterest.com/js/pinit.js"></script>

</body>
</html>

