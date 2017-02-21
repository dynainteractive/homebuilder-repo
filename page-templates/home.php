<?php /* Template Name: Home Page Template */ get_header(); ?>


<!-- Slideshow
================================================== -->
<div class="slideshow block">

	<div class="slideshow-text">
		<?php the_field('slideshow_text'); ?>
	</div>
	
	<?php 
	$images = get_field('slideshow');
	if($images): ?>
    <div class="cycle-slideshow">
        <div class="cycle-pager"></div>
		
		<?php foreach($images as $image): ?>
		<img src="<?php echo $image['url']; ?>" />
		<?php endforeach; ?>
    </div>   
	<?php else : ?>
	<img src="<?php echo get_template_directory_uri(); ?>/images/slides/slide01.jpg" />
	<?php endif; ?>
</div>
		

<!-- Call to Action
================================================== -->
<div class="cta block">
	<div class="container">
		
	<?php if( have_rows('call_to_action') ): ?>
		<?php while ( have_rows('call_to_action') ) : the_row(); ?>
			<div class="w50 columns">
				<a href="<?php the_sub_field('link'); ?>"><img src="<?php the_sub_field('image'); ?>" class="pic" /></a>
				<h2><a href="<?php the_sub_field('link'); ?>"><?php the_sub_field('title'); ?></a></h2>
				<p><?php the_sub_field('text'); ?></p>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>	

	</div><!-- container -->
</div>


<!-- Body
================================================== -->
<div class="content block">
	<div class="container">
		
		<div class="w80 columns offset-by-w10 aligncenter">
            <?php the_field('content'); ?>
		</div>

	</div><!-- container -->
</div>


<!-- Map
================================================== -->
<div class="map block">
    <ul class="map-nav">
        <?php
		$args['post_type'] = "communities";
		$args['showposts'] = -1;
        $args['orderby'] = "title";
        $args['order'] = "ASC";
		
        $num = 1;
		query_posts( $args ); ?>
		<?php while (have_posts()) : the_post(); ?>
		<li><a href="<?php the_permalink(); ?>"><?php the_field('community_name'); ?><span><?php the_field('city'); ?>, <?php the_field('state'); ?></span></a></li>
		<?php $num++; endwhile; ?>	
		<?php wp_reset_query(); ?>	
    </ul>
	
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script>
		function initialize() {
		  var myLatlng = new google.maps.LatLng(35.4822,-97.5350);
		  var mapOptions = {
		    zoom: 10,
		    center: myLatlng,
            scrollwheel: false,
		    mapTypeId: google.maps.MapTypeId.ROADMAP
		  }
		  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		
		<?php
		$args['post_type'] = "communities";
		$args['showposts'] = -1;
        $args['orderby'] = "title";
        $args['order'] = "ASC";
		
        $num = 1;
		query_posts( $args ); ?>
		
		<?php while (have_posts()) : the_post(); $number = $num++; ?>		
		 var contentString<?php echo $number; ?> = '<div style="width:200px; height:160px; padding-top:15px; text-align:center;">'+
            '<h4 class="remove-bottom">'+"<?php the_field('community_name'); ?>"+'</h4>'+
            '<p class="aligncenter">'+"<?php the_field('city'); ?>, <?php the_field('state'); ?>"+'<br />'+
            '<strong>'+"<?php the_field('price_range'); ?>"+'<br />'+
			'<a href="<?php the_permalink(); ?>" class="bold orange">View Community &raquo;</a></p>'+
            '</div>';
          var infowindow<?php echo $number; ?> = new google.maps.InfoWindow({ content: contentString<?php echo $number; ?> });
		  var marker<?php echo $number; ?> = new google.maps.Marker({
		      position: new google.maps.LatLng(<?php the_field('lat_long'); ?>),
		      map: map,
              title: "<?php the_field('community_name'); ?>",
		      animation: google.maps.Animation.DROP,
		      icon: '<?php echo get_template_directory_uri(); ?>/images/pins/pin<?php echo $number; ?>.png'
		  });
          google.maps.event.addListener(marker<?php echo $number; ?>, 'click', function() { infowindow<?php echo $number; ?>.open(map,marker<?php echo $number; ?>); });
		<?php endwhile; ?>	
		<?php wp_reset_query(); ?>	
		}
		
		google.maps.event.addDomListener(window, 'load', initialize);

    </script>
    
    <div id="map-canvas" style="width:100%; height:470px;"></div>
</div>


<!-- Body
================================================== -->
<div class="content block">
	<div class="container">
		
		<div class="w60 columns">
            <h1>Hear From our Customers</h1>
            <p>We love our customers and our customers love us.  See what a few of them had to say about their home buying process.</p>
            <p class="aligncenter"><a href="http://70.32.92.191/~timbercraft/testimonials/" class="btn">View Testimonials</a></p>
            
            <?php if( have_rows('testimonials', 'options') ): ?> 
			<div class="cycle-slideshow" data-cycle-slides="> blockquote"  >
			<?php while ( have_rows('testimonials', 'options') ) : the_row(); ?>
			<blockquote><?php the_sub_field('testimonial'); ?></blockquote>
			<?php endwhile; ?>
			</div>
			<?php endif; ?>
			
			<?php the_field('testimonial_block', 'options'); ?>
		</div>
		
		<div class="w40 columns">
			<img src="<?php echo get_template_directory_uri(); ?>/images/temp/pic-test.jpg" class="border-left" />
		</div>

	</div><!-- container -->
</div>


<?php get_footer(); ?>
