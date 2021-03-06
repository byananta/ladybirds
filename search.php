<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package ladybirds
 */

get_header();
get_template_part( 'template-parts/content', 'innerheader' );
?>

	<section id="primary" class="content-area container">
		<div class="row">
			<main id="main" class="site-main col-lg-8 col-md-12">

			<?php if ( have_posts() ) : ?>
				
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'search' );

				endwhile;

				the_posts_pagination(array(
					'prev_text' => __( '&#8592;', 'ladybirds' ),
    			'next_text' => __( '	&#8594;', 'ladybirds' )
				));

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

			</main><!-- #main -->
			<?php get_sidebar(); ?>
		</div>
	</section><!-- #primary -->

<?php

get_footer();
