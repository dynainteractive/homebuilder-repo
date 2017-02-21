<?php /* Template Name: BDX Page Template */ ini_set('max_execution_time', 300); ?>
<?php
	function cleanstring($thisString,$len = 0,$cdata = 1) {  
		$thisString = strip_tags($thisString, "<li><ul>");
		$thisString = str_replace("&amp;", " and ",$thisString);
		$thisString = str_replace("&nbsp;", " ",$thisString);
		$thisString = str_replace("&rsquo;", "'",$thisString);
		$thisString = str_replace(" </li>", ", ",$thisString);
		$thisString = str_replace("</li>", ", ",$thisString);
		$thisString = str_replace("</ul>", " and more!",$thisString);
		$thisString = strip_tags($thisString);
		$thisString = str_replace("\r","", $thisString);    
		$thisString = str_replace("\n\n","\n", $thisString);    
		$thisString = str_replace("\n\n","\n", $thisString);
		$thisString = str_replace("\n\n","\n", $thisString);
		$thisString = str_replace("\n, \n",",\n", $thisString);
		$thisString = htmlentities($thisString);
		$thisString = trim($thisString);
		if ($len > 0 && strlen($thisString) > $len) {
			$thisString = substr($thisString,0,$len);
			$thisString = substr($thisString,0,strrpos($thisString,"\n")) . "...";
		}
		if ($cdata == 1)
			return "<![CDATA[\n" . $thisString . "\n]]>";
		else
			return $thisString;
	}
echo '<'.'?xml version="1.0" encoding="utf-8"'.'?'.">\n";
?>
<Builders DateGenerated="<?php echo date(DATE_ATOM)?>">
<Corporation>
	<CorporateBuilderNumber>1</CorporateBuilderNumber>
	<CorporateState>NC</CorporateState>
	<CorporateName>CORP LEVEL HOMES</CorporateName>
	<Builder>
		<BuilderNumber>DIV LEVEL HOMES</BuilderNumber>
		<BrandName>Level Homes</BrandName>
		<BrandLogo_Med ReferenceType="URL">http://www.levelhomeslifestyle.com/wp-content/themes/creatingwow-homebuilder/images/template/logo.png</BrandLogo_Med>
		<BrandLogo_Sm ReferenceType="URL">http://www.levelhomeslifestyle.com/wp-content/themes/creatingwow-homebuilder/images/template/logo.png</BrandLogo_Sm>
		<ReportingName>Level Homes</ReportingName>
		<DefaultLeadsEmail LeadsPerMessage="1">jweaver@levelnc.com</DefaultLeadsEmail>
		<BuilderWebsite>http://www.levelhomeslifestyle.com</BuilderWebsite>
<?php 
$i = 1;
$args['post_type'] = "communities";
$args['showposts'] = -1;
$args['orderby'] = "title";
$args['order'] = "ASC";

query_posts( $args ); 

global $wp_query;
$num_rows = $wp_query->found_posts; 

while (have_posts()) : the_post(); 
	$comm_id = get_the_ID();
	$comm_name = get_field('community_name');
	$address = get_field('address');
	$city = get_field('city');
	$state = get_field('state');
	$zip = get_field('zip_code');
	$lat_long = get_field('lat_long');
	
	$price_range = get_field('price_range');
	$overview = get_field('overview');
	$directions = get_field('directions');
	$office_hours = get_field('office_hours');

   	$minprice = "0";
   	$maxprice = "0";
   	
   	//Community Contact
   	if( have_rows('community_contact') ): 
   		$count=0;
   		while ($count < 1 && have_rows('community_contact') ) : the_row();
   			$contact_name = get_sub_field('contact_name');
   			$contact_phone = get_sub_field('contact_phone');
   			$contact_email = get_sub_field('contact_email');
   		$count++; 
   		endwhile;
   	endif;
?>
		
		<Subdivision Status="Active" ShareWithRealtors="1" PriceLow="<?php if(empty($minprice)) echo '0'; else echo $minprice; ?>" PriceHigh="<?php if(empty($maxprice)) echo '0'; else  echo $maxprice; ?>" SqftLow="0" SqftHigh="0">
			<SubdivisionNumber><?php echo $comm_id; ?></SubdivisionNumber>
			<SubdivisionName><?php echo $comm_name; ?></SubdivisionName>
			<MarketingChannel>NewHomeSource</MarketingChannel>
			<MarketingChannel>Move</MarketingChannel>	
			<SubLeadsEmail LeadsPerMessage="1"><?php echo $contact_email; ?></SubLeadsEmail>
			<BuildOnYourLot>0</BuildOnYourLot>
			<CommunityStyle>MasterPlanned</CommunityStyle>
			<SalesOffice>
				<Agent><?php echo $contact_name; ?></Agent>
				<Address OutOfCommunity="0">
					<Street1><?php echo $address; ?></Street1>
					<City><?php echo $city; ?></City>
					<State><?php echo $state; ?></State>
					<ZIP><?php echo $zip; ?></ZIP>
					<Country>USA</Country>
					<?php
					$array = explode(',', $lat_long);
					?>
					<Geocode>
						<Latitude><?php echo $array[0]; ?></Latitude>
						<Longitude><?php echo $array[1]; ?></Longitude>
					</Geocode>
				</Address>			
				<?php
					$phone = $contact_phone;
					if (!empty($phone)) $phoneSplit = strpos(',',$phone);
					if ($phoneSplit > 0) $phone = substr($phone,0,$phoneSplit);
				?>	
				<Phone>
				        <AreaCode><?php echo substr(preg_replace("/[^0-9]/","",$phone),0,3)?></AreaCode>
						<Prefix><?php echo substr(preg_replace("/[^0-9]/","",$phone),3,3)?></Prefix>
						<Suffix><?php echo substr(preg_replace("/[^0-9]/","",$phone),-4)?></Suffix>
				</Phone>
				<Email><?php echo $contact_email; ?></Email>
			</SalesOffice>
			<DrivingDirections><?php echo cleanstring($directions) ?></DrivingDirections>
			<SubDescription><?php echo cleanstring($overview,1400) ?></SubDescription>
			<?php $pos = 0; ?>
			<SubImage Type="SubdivisionBanner" SequencePosition="<?php echo (++$pos); ?>" ReferenceType="URL"><?php $image = get_field('listing_image'); echo $image['sizes'][ 'listing' ]; ?></SubImage>
			<?php 
            $images = get_field('community_images');
            if( $images ):
                foreach( $images as $image ): ?>
                <SubImage Type="Standard" SequencePosition="<?php echo (++$pos); ?>" ReferenceType="URL"><?php echo $image['url']; ?></SubImage>
                <?php endforeach;
            endif; ?>
			<SubWebsite><?php the_permalink(); ?></SubWebsite>
			
			<?php
			//LOAD FLOOR PLANS
			$args = array( 'post_type' => 'floorplans', 'showposts' => -1, 'orderby' => 'title', 'order' => 'ASC', 'meta_query' => array( array( 'key' => 'community', 'value' => '"' . $comm_id . '"', 'compare' => 'LIKE' ) ) );
			$plans = get_posts($args);
			$totalplans = 1;
			$prevCat = null;
			
			//START PLAN LOOP
			if( $plans ):
				foreach( $plans as $plan ):

					//CHECK PRICING
					if( have_rows('floor_plan_prices') ):
					    while ( have_rows('floor_plan_prices') ) : the_row();
					    	$fp = get_sub_field('floor_plan');
							if($plan->ID == $fp) {
								$price = get_sub_field('price');
							}
					    endwhile;
					else : 
						$price = get_field('price', $plan->ID);
						if (empty($price) OR $price=='0') { $price = "0"; }
					endif;
				?>
				
                <?php 
                	$plan_name = get_field('plan_name', $plan->ID);
                	$sqft = get_field('sqft', $plan->ID);
                	$beds = get_field('beds', $plan->ID);
                	$baths = get_field('baths', $plan->ID);
                	$garage = get_field('garage', $plan->ID);
                	$overview = get_field('overview', $plan->ID);
                	$link = get_permalink( $plan->ID );
                	// thumbnail
					$image = get_field('listing_image', $plan->ID);
					$thumb = $image['sizes'][ 'listing' ];
                ?>             
                <Plan Type="SingleFamily">
					<PlanNumber><?php echo $comm_id."-".$plan->ID; ?></PlanNumber>
					<PlanName><?php echo $plan_name; ?></PlanName>
					<BasePrice><?php echo $price; ?></BasePrice>
					<BaseSqft><?php echo $sqft; ?></BaseSqft>
					<Stories><?php echo '1'; ?></Stories>
					<Baths><?php echo floor($baths); ?></Baths>
					<?php if (strpos($baths, '.5') !== false) { echo "<HalfBaths>1</HalfBaths>"; } ?>	
					<Bedrooms MasterBedLocation="Down"><?php echo $beds; ?></Bedrooms>
					<Garage><?php echo $garage; ?></Garage>
					<Description><?php echo cleanstring($overview,1400); ?></Description>
					<PlanImages>
					
					<?php
					$pos = 0; 
					//LOAD ELEVATIONS
	                $images = get_field('elevations', $plan->ID);
	                if( $images ):
	                foreach( $images as $image ): ?>
	                <?php endforeach; endif; ?>
						<ElevationImage SequencePosition="<?php echo (++$pos); ?>" ReferenceType="URL" Title="<?php echo $pos; ?>"><?php echo $image['url']; ?></ElevationImage>
					
					<?php	
					//LOAD FLOOR PLAN IMAGES
					$images = get_field('floor_plans', $plan->ID);
					if( $images ):
					foreach( $images as $image ): ?>
				    	<FloorPlanImage SequencePosition="<?php echo (++$pos); ?>" ReferenceType="URL"><?php echo $image['url']; ?></FloorPlanImage>
				    <?php endforeach; endif; ?>
						
				<?php if( get_field('virtual_tour', $plan->ID) ): ?><VirtualTour><?php the_field('virtual_tour', $plan->ID); ?></VirtualTour><?php endif; ?>

				</PlanImages>
				<EnvisionDesignCenter><?php echo $link; ?></EnvisionDesignCenter>
               
			<?php 

			//LOAD AVAILABLE HOMES
			$homes = get_posts(array(
				'post_type' => 'homes',
				'showposts' => -1,
				'meta_query' => array(
					array(
						'key' => 'community',
						'value' => '"' . $comm_id . '"',
						'compare' => 'LIKE'
					),
					array(
						'key' => 'floor_plan',
						'value' => '"' . $plan->ID . '"',
						'compare' => 'LIKE'
					)
				)
			));
			$totalspec = 0;
			
			if( $homes ):
				foreach( $homes as $home ):
               
               	$price = get_field('price', $home->ID);
				if (empty($price) OR $price=='0') { $price = "0"; }
				
				$address = get_field('address', $home->ID);
				$city = get_field('city', $home->ID);
				$state = get_field('state', $home->ID);
				$zip = get_field('zip_code', $home->ID);
				$beds = get_field('beds', $home->ID);
				$baths = get_field('baths', $home->ID);
				$garage = get_field('garage', $home->ID);
				$sqft = get_field('sqft', $home->ID);
				$overview = get_field('overview', $home->ID);
				$lat_long = get_field('lat_long', $home->ID);
	?>
				<Spec Type="SingleFamily">
					<SpecNumber><?php echo $comm_id."-".$home->ID; ?></SpecNumber>
					<SpecAddress>
						<SpecStreet1><?php echo $address; ?></SpecStreet1>
						<SpecCity><?php echo $city; ?></SpecCity>
						<SpecState><?php echo $state; ?></SpecState>
						<SpecZIP><?php echo $zip; ?></SpecZIP>
						<SpecCountry>USA</SpecCountry>
						<?php
						$array = explode(',', $lat_long);
						if(!empty($lat_long)) {
						?>
						<SpecGeocode>
							<SpecLatitude><?php echo $array[0]; ?></SpecLatitude>
							<SpecLongitude><?php echo $array[1]; ?></SpecLongitude>
						</SpecGeocode>
						<?php } ?>
					</SpecAddress>
					<SpecPrice><?php echo $price; ?></SpecPrice>
					<SpecSqft><?php echo $sqft; ?></SpecSqft>
					<SpecStories><?php echo "1"; ?></SpecStories>
					<SpecBaths><?php echo floor($baths); ?></SpecBaths>
					<?php if (strpos($baths, '.5') !== false) { echo "<SpecHalfBaths>1</SpecHalfBaths>"; } ?>	
					<SpecBedrooms MasterBedLocation="Down"><?php echo $beds; ?></SpecBedrooms>
					<SpecGarage><?php echo $garage; ?></SpecGarage>
					<SpecDescription><?php echo cleanstring($overview,1400)?></SpecDescription>
					<SpecImages>
					
					<?php 
					$pos = 0;
					//LOAD HOME IMAGES
	                $images = get_field('home_images', $home->ID);
	                if( $images ):
	                foreach( $images as $image ): ?>
	                	<SpecElevationImage SequencePosition="<?php echo (++$pos); ?>" ReferenceType="URL" Title="<?php echo $pos; ?>"><?php echo $image['url']; ?></SpecElevationImage>		
	                <?php endforeach; endif; ?>
	                
	                 <?php 
	                 //LOAD FLOOR PLANS
					 $images = get_field('floor_plans', $home->ID);
					 if( $images ):
					 foreach( $images as $image ): ?>
				     	<SpecElevationImage SequencePosition="<?php echo (++$pos); ?>" ReferenceType="URL" Title="<?php echo $pos; ?>"><?php echo $image['url']; ?></SpecElevationImage>
					 <?php endforeach; endif; ?>
		
					 </SpecImages>
					 <?php /*<SpecWebsite><?php the_permalink(); ?></SpecWebsite> */?>
				</Spec>
<?php		
			$totalspec++;
			endforeach;
		endif;
		//END HOME LOOP 
?>			
				<SpecCount><?php echo $totalspec; ?></SpecCount>	
			</Plan>
<?php
			$totalplans++;
			endforeach; 
		endif;
		//END PLAN LOOP 
?>
				
			
			<PlanCount><?php echo $totalplans; ?></PlanCount>
		</Subdivision>
<?php endwhile; ?>
		<SubsCount><?php echo $num_rows; ?></SubsCount>
	</Builder>
</Corporation>
</Builders>
