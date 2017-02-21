<?php
function alt_featured($id) {
	$floorplan = get_field('floor_plan', $id);
	if( $floorplan ): foreach( $floorplan as $fp ):
		echo '<img src="'.get_field('listing_image', $fp->ID).'" />';
	
	endforeach; endif;
}


function alt_main() {
	$floorplan = get_field('floor_plan');
	if( $floorplan ): foreach( $floorplan as $fp ):
 
		$images = get_field('elevations', $fp->ID);
		
		if( $images ): foreach( $images as $image ):
			echo '<img src="'.$image['url'].'" alt="'.$image['alt'].'" />';
		endforeach; endif;
	
	endforeach; endif;
 
}
 
 
function alt_gallery() {
	
	$floorplan = get_field('floor_plan');
	if( $floorplan ): foreach( $floorplan as $fp ):
 
		$images = get_field('elevations', $fp->ID);
		
		if( $images ): foreach( $images as $image ):
			echo '<div class="w33 columns"><a href="'.$image['url'].'"><img src="'.$image['sizes']['thumbnail'].'" alt="'.$image['alt'].'" /></a></div>';
		endforeach; endif;
	
	endforeach; endif;
 
}
 
 
function alt_fp() {
	
	$floorplan = get_field('floor_plan');
	if( $floorplan ): foreach( $floorplan as $fp ):
 
		$images = get_field('floor_plans', $fp->ID);
		
		if( $images ): foreach( $images as $image ):
			echo '<div class="w33 columns"><a href="'.$image['url'].'"><img src="'.$image['sizes']['thumbnail'].'" alt="'.$image['alt'].'" /></a></div>';
		endforeach; endif;
	
	endforeach; endif;	
	
}
 
?>
