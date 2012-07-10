<?php
/**
* Template Name: Storefront
 */
?> 
<?php get_header(); ?>
	<h1><a href="<?php bloginfo('url'); ?>">The Store</a></h1>
	<div id="shopp" class="grid">	<div class="category">

		<ul class="views"><li>Views: </li><li><button type="button" class="grid"></button></li><li><button type="button" class="list"></button></li></ul><br \> 


		<ul class="products">
			<li class="row"><ul>

<?php query_posts("post_type=catalog") ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
	

								<li class="product">
					<div class="frame">
					<a href="<?php the_field('ibethel_url') ?>">
						
						<img src="<?php the_field('upload_an_image') ?>" alt="<?php the_title() ?>" width="72" height="96">
						
						</a>
						<div class="details">
						<h4 class="name"><a href="<?php the_field('ibethel_url') ?>"><?php the_title() ?></a></h4>
						<p class="price"><?php the_field('price') ?></p>
						<a href="<?php the_field('ibethel_url') ?>" class="button">Buy it now at iBethel</a>

						
						</div>

					</div>
				</li>
	

				
<?php endwhile; ?>
<div class="clear"></div>
<div class="seth">
	<a href="http://store.ibethel.org/index.php?manufacturers_id=63" class="button">See all Seth's products</a>
</div>
<?php else: ?>
	<!-- no posts found -->
<?php endif; ?>
				</ul></li>
	</ul>



	</div>
</div>	


<?php get_footer(); ?>
