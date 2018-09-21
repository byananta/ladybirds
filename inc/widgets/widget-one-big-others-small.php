<?php
class LB_One_Big_Others_Small_Layout extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'one_big_others_small_layout',
			'description' => 'One big others small blog layout.',
		);
		parent::__construct( 'one_big_others_small_layout', __('LB One Big Others Small Layout', 'ladybirds'), $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
    echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

    $posts_per_page = $instance['posts_per_page'];
    $lb_posts = new WP_Query(array(
      'post_type' => 'post',
      'post_status' => array('publish'),
      'posts_per_page' => $posts_per_page,
      'cat' => $instance['category'],
      'order'=>'DESC',
    ));

    ?>

    <?php if ($lb_posts->have_posts()): ?>

    <div class="row">
      <?php
        $count = 1;
        while ($lb_posts->have_posts()): $lb_posts->the_post();
      ?>

      <?php if ($count == 1): ?>
        <div class="col-md-5">
          <article class="lb-post-type-column">
            <?php if (has_post_thumbnail()): ?>
              <div class="post-thumbnail">
                <a href="<?php echo get_the_permalink(); ?>">
                  <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" data-lbimg="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php echo get_the_title(); ?>">
                </a>
              </div>
            <?php endif; ?>

            <div class="entry-header">
              <a href="<?php echo get_the_permalink(); ?>">
                <?php the_title('<h5 class="entry-title">', '</h5>'); ?>
              </a>
              <div class="entry-meta d-flex align-items-center">
                <?php ladybirds_posted_by(); ?>
                <?php ladybirds_posted_on(); ?>
              </div>
            </div>
          </article>
        </div>
      <?php else: ?>

      <?php if ($count == 2){echo '<div class="col-md-7">';} ?>
        <article class="lb-post-type-list-thumb">
          <?php if (has_post_thumbnail()): ?>
            <div class="post-thumbnail">
              <a href="<?php echo get_the_permalink(); ?>">
                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>" alt="<?php echo get_the_title(); ?>">
              </a>
            </div>
          <?php endif; ?>

          <div class="entry-header">
            <a href="<?php echo get_the_permalink(); ?>">
              <?php the_title('<h5 class="entry-title">', '</h5>'); ?>
            </a>
            <div class="entry-meta d-flex align-items-center">
              <?php ladybirds_posted_by(); ?>
              <?php ladybirds_posted_on(); ?>
            </div>
          </div>
        </article>
      <?php if ($count == $posts_per_page){echo '</div>';} ?>
      <?php endif; ?>
    <?php $count++; endwhile; ?>
    </div>
  <?php endif; ?>

    <?php
    wp_reset_postdata();






    echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$posts_per_page = ! empty( $instance['posts_per_page'] ) ? $instance['posts_per_page'] : 4;
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
      <input
      type="text"
      class="widefat"
      id="<?php echo $this->get_field_id( 'title' ); ?>"
      name="<?php echo $this->get_field_name( 'title' ); ?>"
      value="<?php echo esc_attr( $title ); ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'category' ); ?>">Category:</label>
      <select
      class="widefat"
      id="<?php echo $this->get_field_id( 'category' ); ?>"
      name="<?php echo $this->get_field_name( 'category' ); ?>">
        <option value="">All</option>
        <?php
          $categories = get_categories();

          foreach ($categories as $category) {
            $selected = ($category->term_id == $instance['category'])? ' selected="selected"': '';
            echo '<option value="'.$category->term_id.'"'.$selected.'>'.$category->name.'</option>';
          }
        ?>
      </select>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>">Posts Per Page:</label>
      <input
      type="number"
      class="tiny-text"
      min="1"
      step="1"
      size="3"
      autocomplete="off"
      id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"
      name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>"
      value="<?php echo esc_attr( $posts_per_page); ?>" />
    </p>







    <?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
    $instance[ 'category' ] = strip_tags( $new_instance[ 'category' ] );
    $instance[ 'posts_per_page' ] = strip_tags( $new_instance[ 'posts_per_page' ] );
    return $instance;
	}
}


add_action( 'widgets_init', function(){
	register_widget( 'LB_One_Big_Others_Small_Layout' );
});
