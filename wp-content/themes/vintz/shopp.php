<?php
/**
 * Page Template File
 *
 * @package	   	WordPress
 * @subpackage	Sprachkonstrukt2 Theme
 * @author     	Ruben Deyhle <ruben@sprachkonstrukt.de>
 * @url		   	http://sprachkonstrukt2.deyhle-webdesign.com
 */ 
 
get_header();


if (have_posts()) : 
	while (have_posts()) : the_post(); ?>
		
				<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<h1><a href="<?php echo get_permalink() ?>" rel="bookmark" title=" <?php the_title(); ?>"><?php the_title(); ?></a></h1>
	
					<?php the_content(); ?>
	
		
					<p class="entry_pages">		
						<?php wp_link_pages(array('before' => '<strong>'.__( 'Pages:', 'sprachkonstrukt' ).':</strong> ', 'after' => '', 'next_or_number' => 'number')); ?>
					</p>  				
					
<?php endwhile; endif; ?>
				</article>

<?php get_footer(); ?>
