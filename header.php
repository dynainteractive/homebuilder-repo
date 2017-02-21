<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  	================================================== -->
	<meta charset="utf-8">
	<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
	<meta name="author" content="Level Homes">

	<!-- Mobile Specific Metas
  	================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="/wp-content/themes/creatingwow-homebuilder/images/favicon.ico">
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
	
	<!-- CSS & Scripts
  	================================================== -->
  	<script src="https://use.typekit.net/pgf1bcz.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>
	
	<?php wp_head(); ?>

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>

<body <?php body_class(); ?>>


<!-- Header
================================================== -->
<div class="header block">
	<div class="container">
	
		<div class="w100 columns">
			<!--Logo-->
            <div class="logo">
                <a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/media/logo.png" width="193" height="102" /></a>
            </div>
         
        	<!--Utility-->
        	<?php utl_nav(); ?>
                    
            <!--Navigation-->
			<div class="menu">
				<?php nav(); ?>
			
				<a class="toggle-nav" href="#">&#9776;</a>
			</div>
		</div>
		
	</div><!-- container -->
</div>	


