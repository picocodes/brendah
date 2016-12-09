<?php
/**
 * The template part for displaying content
 *
 * @package Brendah
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		
		<?php
			//Categories
			if ( 'post' === get_post_type() ) {
				
				$categories_list = get_the_category_list( _x( ' / ', 'Used between list items, there is a space after the foward slash.', 'brendah' ) );
				if ( $categories_list ) {
					printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
						_x( 'Categories', 'Used before category names.', 'brendah' ),
						$categories_list
					);
				}
			}
		?>
		
	</header><!-- .entry-header -->

	<?php brendah_post_thumbnail(); ?>
	
	<div class="entry-meta">
		<?php brendah_entry_meta(); ?>
	</div>
	<div class="entry-content">
		<?php
		
		the_excerpt(  );
			
		//Takes care of multi-page posts
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'brendah' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'brendah' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">	
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'brendah' ),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
