<div class="row">
	<ul class="col c12 pagination">
		<?php if($paged > 1) { ?>
			<li class="prev"><a href="<?php echo get_pagenum_link($paged - 1); ?>">Previous</a></li>
		<?php } ?>

        <?php for ($i=1; $i <= $pages; $i++) { ?>
            <?php if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) { ?>
                <?php if( $paged == $i ) { ?>
                    <li class="active"><a><?php echo $i; ?></a></li>
                <?php } else { ?>
                    <li><a href="<?php echo get_pagenum_link($i); ?>"><?php echo $i; ?></a></li>
                <?php } ?>
            <?php } ?>
        <?php } ?>

        <?php if ($paged < $pages) { ?>
			<li class="next"><a href="<?php echo get_pagenum_link($paged + 1); ?>">Next</a></li>
		<?php } ?>
	</ul>
</div>