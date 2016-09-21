<!DOCTYPE html>
<html  <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BUNTINGTON Public Schools</title>

	<!-- Styles -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,700,800" rel="stylesheet" type="text/css"><!-- Google web fonts -->
	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"><!-- font-awesome -->
	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/js/dropdown-menu/dropdown-menu.css" rel="stylesheet" type="text/css"><!-- dropdown-menu -->
	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"><!-- Bootstrap -->
	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/js/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css"><!-- Fancybox -->
	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/s/audioplayer/audioplayer.css" rel="stylesheet" type="text/css"><!-- Audioplayer -->
	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/style.css" rel="stylesheet" type="text/css"><!-- theme styles -->
	<?php wp_head(); ?>
</head>

<body role="document">
<?php
global $slider;
var_dump($slider); ?>
<!-- device test, don't remove. javascript needed! -->
<span class="visible-xs"></span><span class="visible-sm"></span><span class="visible-md"></span><span class="visible-lg"></span>
<!-- device test end -->

<div id="k-head" class="container"><!-- container + head wrapper -->

	<div class="row"><!-- row -->

		<nav class="k-functional-navig"><!-- functional navig -->
			<?php get_normal_menu() ?>
		</nav><!-- functional navig end -->

		<div class="col-lg-12">

			<div id="k-site-logo" class="pull-left"><!-- site logo -->

				<h1 class="k-logo">
					<?php twentyfifteen_the_custom_logo(); ?>
				</h1>

				<a id="mobile-nav-switch" href="#drop-down-left"><span class="alter-menu-icon"></span></a><!-- alternative menu button -->

			</div><!-- site logo end -->

			<nav id="k-menu" class="k-main-navig"><!-- main navig -->
<!--				xxxx-->
				<?php get_walker_menu() ?>
<!--				xxxx-->
			</nav><!-- main navig end -->

		</div>

	</div><!-- row end -->

</div><!-- container + head wrapper end -->

<div id="k-body"><!-- content wrapper -->

	<div class="container"><!-- container -->

		<div class="row"><!-- row -->

			<div id="k-top-search" class="col-lg-12 clearfix"><!-- top search -->
				<?php get_search_form_cus() ?>
			</div><!-- top search end -->

			<div class="k-breadcrumbs col-lg-12 clearfix"><!-- breadcrumbs -->
				<?php the_breadcrumb(); ?>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active">Page Example</li>
				</ol>

			</div><!-- breadcrumbs end -->

		</div><!-- row end -->