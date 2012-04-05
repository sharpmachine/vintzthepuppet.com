<?php
/**
 * Template for displaying the footer
 *
 * @package	   	WordPress
 * @subpackage	Sprachkonstrukt2 Theme
 * @author     	Ruben Deyhle <ruben@sprachkonstrukt.de>
 * @url		   	http://sprachkonstrukt2.deyhle-webdesign.com
 */ ?>
		
		</div>
		
		<?php 
		// creating social button menu on the left
		wp_nav_menu( array( 'container' => 'ul',  'menu_class' => 'socialbuttons', 'fallback_cb' => 'sprachkonstrukt_socialbuttons', 'theme_location' => 'social', 'depth' => 1 ) );  
		?>
		<?php
		// creating main sidebar on the right
		?>
		
		<?php get_sidebar(); ?>
		
		<div id="finished" ></div>
	</div>
		
	<footer id="footer">	
		<?php _e('This website is powered by', 'sprachkonstrukt'); ?> <a href="http://wordpress.org/" rel="generator">Wordpress</a> <?php _e('using the', 'sprachkonstrukt'); ?> <a href="http://sprachkonstrukt2.deyhle-webdesign.com">Sprachkonstrukt2</a> <?php _e('Theme', 'sprachkonstrukt'); ?>.
	</footer>
	<?php wp_footer(); ?>
</body>
</html>

