<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package ladybirds
 */

if ( ! function_exists( 'ladybirds_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function ladybirds_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( ' %s', 'post date', 'ladybirds' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on"><i class="fa fa-calendar"></i>' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'ladybirds_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function ladybirds_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( ' %s', 'post author', 'ladybirds' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		$author_avatar = '<a class="url fn n d-inline-flex" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_avatar(get_the_author_meta( 'ID' ), 30) . '</a>';
		echo '<span class="byline post-author d-flex align-items-center"> '. $author_avatar . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'ladybirds_post_categories' )) {
	function ladybirds_post_categories(){
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'ladybirds' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links"><i class="fa fa-folder fa-rotate-270"></i>' . esc_html__( ' %1$s', 'ladybirds' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}
		}
	}
}

if (!function_exists('ladybirds_post_comment_count')) {
	function ladybirds_post_comment_count(){
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link"><i class="fa fa-comments"></i> ';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'ladybirds' ),
						array(
							'span' => array(
								'class' => array('ap'),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}
	}
}

if ( ! function_exists( 'ladybirds_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function ladybirds_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( '', 'list item separator', 'ladybirds' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<div class="tags-links"><span class="tag-title">TAGS</span>' . esc_html__( ' %1$s', 'ladybirds' ) . '</div>', $tags_list ); // WPCS: XSS OK.
			}
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'ladybirds' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'ladybirds_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function ladybirds_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php
				$thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
				$full_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
				?>
				<img src="<?php echo $thumbnail_url; ?>" alt="<?php echo get_the_title(); ?>" data-lbimg="<?php echo $full_url; ?>">
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail img-hover" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			$thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
			$full_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
			?>
			<img src="<?php echo $thumbnail_url; ?>" alt="<?php echo get_the_title(); ?>" data-lbimg="<?php echo $full_url; ?>">
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

if (! function_exists( 'ladybirds_get_breadcrumb' )) {

	function ladybirds_get_breadcrumb() {
		include('breadcrumb.php');
		breadcrumb_trail(array(
			'show_browse'     => false,
			'network' => true
		));
	}

}
