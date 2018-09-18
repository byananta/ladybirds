<?php
//echo get_post_type();
?>

<section class="lb-innerheader">
  <div class="container">
    <div class="row">
      <div class="col">
        <?php if (get_post_type() === 'page'): ?>
        <?php   the_title('<h5 class="page-title">','</h5>'); ?>
        <?php endif; ?>

        <?php
        if (get_post_type() === 'post'){
          if (is_singular()) {
            the_title('<h5 class="page-title">','</h5>');
          }
        }
        ?>
      </div>
      <div class="col">
        Pattanayak
      </div>
    </div>
  </div>
</section>
