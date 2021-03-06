<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ladybirds
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if (is_singular()): ?>
		<?php ladybirds_post_thumbnail(); ?>
	<?php endif; ?>

	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta d-flex align-items-center">
				<?php
				ladybirds_posted_by();
				ladybirds_posted_on();
				ladybirds_post_comment_count();
				ladybirds_post_categories();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if (!is_singular()): ?>
		<?php ladybirds_post_thumbnail(); ?>
	<?php endif; ?>

	<div class="entry-content">
		<?php
			if (is_singular()) {
				the_content( sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'ladybirds' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ladybirds' ),
					'after'  => '</div>',
				) );
			}else {
				the_excerpt();
			}
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php ladybirds_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
