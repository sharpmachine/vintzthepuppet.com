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
		&copy;<?php echo date ('Y'); ?> <?php bloginfo('name'); ?> | <a href="<?php bloginfo('url'); ?>/privacy-policy">Privacy Policy</a> | <a href="<?php bloginfo('url'); ?>/terms-conditions">Terms &amp; Conditions</a>
	</footer>
	<?php wp_footer(); ?>
</body>
</html>

