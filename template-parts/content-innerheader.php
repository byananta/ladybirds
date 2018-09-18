<?php
//echo get_post_type();
?>

<section class="lb-innerheader">
  <div class="container">
    <div class="row align-items-center">
      <!-- <div class="col">
        <?php if (get_post_type() === 'page'): ?>
        <?php   the_title('<h5 class="page-title">','</h5>'); ?>
        <?php endif; ?>

        <?php
        if (get_post_type() === 'post'){
          if (is_singular()) {
            the_title('<h4 class="page-title">','</h4>');
          }elseif (is_archive()) {
            the_archive_title( '<h4 class="page-title">', '</h4>' );
          }elseif (is_home()) {
            echo '<h4 class="page-title">Blog</h4>';
          }
        }
        ?>
      </div> -->
      <div class="col">
        <div class="lb-breadcrumb">
          <?php ladybirds_get_breadcrumb(); ?>
        </div>
      </div>
    </div>
  </div>
</section>
