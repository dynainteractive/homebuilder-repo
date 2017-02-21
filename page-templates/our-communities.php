<?php /* Template Name: Communities Listings */ get_header(); ?>


<!-- TITLE
================================================== -->
<div class="title block">
	<div class="container">
		
		<div class="w100 columns">
			<h1><?php the_title(); ?></h1>
		</div>
		
	</div><!-- container -->
</div>


<!-- Map
================================================== -->
<div class="map block">
	<?php 
	function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
	?>
    
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script>
		function initialize() {
		  var myLatlng = new google.maps.LatLng(28.5383,-81.3792);
		  var mapOptions = {
		    zoom: 10,
		    center: myLatlng,
            scrollwheel: false,
            styles: [{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2e5d4"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{"featureType":"road","elementType":"all","stylers":[{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]}],
           	<?php echo(isMobile()) ? 'draggable: false,' : ''; ?>
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
		  var contentString<?php echo $number; ?> = '<div style="width:200px; height:150px; padding-top:25px; text-align:center;">'+
            '<div class="blue font20">'+"<?php the_field('community_name'); ?>"+'</div>'+
            '<p class="aligncenter" style="line-height:18px;">'+"<?php the_field('city'); ?>, <?php the_field('state'); ?>"+'<br />'+
            '<strong>'+"<?php the_field('price_range'); ?>"+'<br />'+
			'<a href="<?php the_permalink(); ?>" class="green bold">View Community &raquo;</a>'+
            '</div>';
          var infowindow<?php echo $number; ?> = new google.maps.InfoWindow({ content: contentString<?php echo $number; ?> });
		  var marker<?php echo $number; ?> = new google.maps.Marker({
		      position: new google.maps.LatLng(<?php $location=get_field('map'); echo $location['lat'].', '.$location['lng']; ?>),
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
    
    <div id="map-canvas" style="width:100%; height:450px;"></div>

</div>


<!-- Body
================================================== -->
<div class="content block" id="comm-listings">
	<div class="container">
        
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
		
		<?php
        $i = 1;
		$args['post_type'] = "communities";
		$args['showposts'] = -1;
        $args['orderby'] = "title";
        $args['order'] = "ASC";
		
		query_posts( $args ); ?>
		
		<?php while (have_posts()) : the_post(); ?>
		
		<div class="row comm-listing">
			<div class="w50 columns">
				<?php 
				// thumbnail
				$image = get_field('listing_image');
				$url = $image['url'];
				$thumb = $image['sizes'][ 'listing' ];
				?>
				<img src="<?php echo $thumb; ?>" />
			</div>
			
			<div class="w50 columns">
				<h1><?php the_field('community_name'); ?></h1>
				<p class="half-bottom"><strong><?php the_field('city'); ?>, <?php the_field('state'); ?> -</strong> <?php the_field('price_range'); ?></p>
				
				<?php the_field('teaser'); ?>
				
				<div class="aligncenter"><a href="<?php the_permalink(); ?>" class="btn">View Community</a></div>
			</div>
		</div>
		<?php endwhile; ?>

	</div><!-- container -->
</div>


<?php get_footer(); ?>
