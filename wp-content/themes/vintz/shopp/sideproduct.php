<?php if (shopp('product','found')): ?>
	<div class="sideproduct">
	<a href="<?php shopp('product','url'); ?>"><?php shopp('product','coverimage','width=210&fit=crop&quality=100&class=product-image'); ?></a>
	
	<h3><a href="<?php shopp('product','url'); ?>"><?php shopp('product','name'); ?></a></h3>

	<?php if (shopp('product','onsale')): ?>
		<p class="original price"><?php shopp('product','price'); ?></p>
		<p class="sale price"><big><?php shopp('product','saleprice'); ?></big></p>
	<?php else: ?>
		<p class="price"><big><?php shopp('product','price'); ?></big></p>
	<?php endif; ?>
	</div>
<?php endif; ?>