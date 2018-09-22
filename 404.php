<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package ladybirds
 */

get_header();
get_template_part( 'template-parts/content', 'innerheader' );
?>

	<div id="primary" class="content-area container">
		<div class="row">
			<main id="main" class="site-main col-lg-8 col-md-12">

				<section class="error-404 not-found">
					<?php dynamic_sidebar( 'lb-404-page-widget' ); ?>
				</section><!-- .error-404 -->

			</main><!-- #main -->
			<?php get_sidebar(); ?>
		</div>
	</div><!-- #primary -->

<?php
get_footer();
