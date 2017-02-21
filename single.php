<?php session_start(); ?>

<?php get_header(); ?>
<?php if ( 'communities' == get_post_type() ) : ?>
	<?php include('page-templates/community-detail.php'); ?>
	
<?php elseif ( 'floorplans' == get_post_type() ) : ?>
	<?php include('page-templates/plan-detail.php'); ?>

<?php elseif ( 'homes' == get_post_type() ) : ?>
	<?php include('page-templates/home-detail.php'); ?>
	
<?php elseif ( 'gallery' == get_post_type() ) : ?>
	<?php include('page-templates/photo-gallery-detail.php'); ?>

<?php else : ?>
	<?php include('page-templates/single-post.php'); ?>
	
<?php endif; ?>

<?php get_footer(); ?>