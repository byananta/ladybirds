<?php
/**
* Template Name: Home Page
*/
get_header();
?>
<section class="home">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <?php dynamic_sidebar( 'lb-home-page-full-width' ); ?>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8 col-md-12">
        <?php dynamic_sidebar( 'lb-home-page-main' ); ?>
      </div>

      <div class="col-lg-4 col-md-12">
        <?php dynamic_sidebar( 'lb-home-page-sidebar' ); ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
