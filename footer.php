<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ladybirds
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<?php dynamic_sidebar( 'lb-footer-widget-1' ); ?>
				</div>

				<div class="col-md-4">
					<?php dynamic_sidebar( 'lb-footer-widget-2' ); ?>
				</div>

				<div class="col-md-4">
					<?php dynamic_sidebar( 'lb-footer-widget-3' ); ?>
				</div>

			</div>
		</div>

		<section class="lb-copyright-footer">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?php dynamic_sidebar( 'lb-copyright-footer-widget' ); ?>
					</div>
				</div>
			</div>
		</section>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
