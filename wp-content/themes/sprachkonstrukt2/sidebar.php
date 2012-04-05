<?php
/**
 * Template for the main sidebar to the right
 *
 * @package	   	WordPress
 * @subpackage	Sprachkonstrukt2 Theme
 * @author     	Ruben Deyhle <ruben@sprachkonstrukt.de>
 * @url		   	http://sprachkonstrukt2.deyhle-webdesign.com
 */ ?>
		
		
		<aside>
		<ul id="sidebar">
			<?php if ( dynamic_sidebar('Sidebar') ) : else : ?>
				
				<?php sprachkonstrukt_archive_widget() ?>
				
				
			<li id="tag_cloud" class="widget widget_tag_cloud">
				<h2 class="widgettitle"><?php _e('Tags', 'sprachkonstrukt'); ?></h2>
				<div class="tagcloud">
					<?php wp_tag_cloud(); ?>
				</div> 
			</li> 
		
			
			<li id="meta" class="widget widget_meta">
				<h2 class="widgettitle"><?php _e( 'Meta', 'sprachkonstrukt' ); ?></h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</li>	
				
			<?php endif; ?> 
		</ul>
		</aside>
