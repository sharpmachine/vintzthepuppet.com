<?php
/**
 * Theme Header
 *
 * @package	   	WordPress
 * @subpackage	Sprachkonstrukt2 Theme
 * @author     	Ruben Deyhle <ruben@sprachkonstrukt.de>
 * @url		   	http://sprachkonstrukt2.deyhle-webdesign.com
 */
 ?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta http-equiv="X-UA-Compatible" content="chrome=1" /> <!-- use Google Chrome Frame -->
		
		<title><?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;
	
		wp_title( '|', true, 'right' );
	
		// Add the blog name.
		bloginfo( 'name' );
	
		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";
	
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'sprachkonstrukt'), max( $paged, $page ) );
	
		?></title>
		
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/style.css" type="text/css" media="all" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/fonts/fonts.css" media="screen">
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo home_url(); ?>/favicon.ico" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?> <!-- enable Threaded Comments-->
		
		<!-- use modernizr for enabling html5 elements in old browsers -->
		<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr-1.6.min.js"></script>
		
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
	
	<?php
$header_image = get_header_image();
if(!empty($header_image)):
?><header style="background-image: url('<?php echo $header_image; ?>')">
<?php else: ?>
<header>
<?php endif; ?>

<?php if (get_header_textcolor() == "blank") { 
			$sprachkonstrukt_header_hide = ' style="display:none;"';
			$sprachkonstrukt_header_textcolor = ""; 
		} else { 
			$sprachkonstrukt_header_hide = "";
			$sprachkonstrukt_header_textcolor = ' style="color: #'.get_header_textcolor().' !important;"';
		 }?>

			<hgroup<?php echo $sprachkonstrukt_header_hide; ?>>
				<h1><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php bloginfo('template_directory'); ?>/images/logo3.png" width="886" height="199" alt="Logo"></a></h2>
			</hgroup>
			
		</header>
		
		<?php wp_nav_menu( array( 'container' => 'nav', 'fallback_cb' => 'sprachkonstrukt_menu', 'theme_location' => 'primary', 'depth' => 1 ) ); ?>
		
		<div id="page">
			<div id="content">