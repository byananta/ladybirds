<?php
class LB_Post_Slider extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'lb_post_slider',
			'description' => 'Post Slider',
		);
		parent::__construct( 'lb_post_slider', __('LB Post Slider', 'ladybirds'), $widget_ops );
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

    $posts_per_page = !empty($instance['posts_per_page']) ? $instance['posts_per_page'] : 5;
    $lb_recent_posts = new WP_Query(array(
      'post_type' => 'post',
      'post_status' => array('publish'),
      'posts_per_page' => $posts_per_page,
      'cat' => $instance['category'],
      'order'=>'DESC',
    ));
    $min_height = !empty($instance['height'])? (int)$instance['height'].'px':'';
    $posts_per_slide = !empty($instance['posts_per_slide'])? (int)$instance['posts_per_slide']:'';
    $autoplay = ($instance['autoplay'] == 'on')? 1:0;
		?>

    <?php if ($lb_recent_posts->have_posts()): ?>
      <section class="lb-post-slider" data-slick='{"slidesToShow": <?php echo $posts_per_slide; ?>, "autoplay": <?php echo $autoplay; ?>}'>
      <?php while ($lb_recent_posts->have_posts()): $lb_recent_posts->the_post(); ?>

        <article class="lb-post-slider-item" style="min-height:<?php echo $min_height; ?>; background-image:url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>');">
          <div class="lb-post-slider-content">
            <div class="post-category">
              <?php ladybirds_post_categories(); ?>
            </div>
            <a href="<?php echo get_the_permalink(); ?>">
              <h4 class="post-title"><?php echo get_the_title(); ?></h4>
            </a>
						<?php if ($instance['hide_meta'] != 'on'): ?>
							<div class="entry-meta">
								<?php ladybirds_posted_by(); ?>
								<?php ladybirds_posted_on(); ?>
							</div>
						<?php endif; ?>
          </div>
        </article>

      <?php endwhile; ?>
    </section>
    <?php endif; wp_reset_postdata(); ?>


    <?php
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
    $posts_per_page = ! empty( $instance['posts_per_page'] ) ? $instance['posts_per_page'] : 5;
    $posts_per_slide = ! empty( $instance['posts_per_slide'] ) ? $instance['posts_per_slide'] : 3;
    $height = ! empty( $instance['height'] ) ? $instance['height'] : 500;
    $category = ! empty( $instance['category'] ) ? $instance['category'] : '';
    $categories = get_categories();
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
      <label for="<?php echo $this->get_field_id( 'category' ); ?>">Select Category:</label>

      <select
      class="widefat"
      id="<?php echo $this->get_field_id( 'category' ); ?>"
      name="<?php echo $this->get_field_name( 'category' ); ?>">
        <option value="">All</option>
        <?php
          foreach ($categories as $key => $cat):
          $selected = ($cat->term_id == $category)? 'selected="selected"' : '';
        ?>
          <option value="<?php echo $cat->term_id; ?>" <?php echo $selected; ?>><?php echo $cat->name; ?></option>
        <?php endforeach; ?>
      </select>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>">Number of Posts:</label>
      <input
      type="number"
      class="tiny-text"
      min="1"
      step="1"
      size="3"
      id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"
      name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>"
      value="<?php echo esc_attr( $posts_per_page ); ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'posts_per_slide' ); ?>">Posts Per Slider:</label>
      <input
      type="number"
      class="tiny-text"
      min="1"
      step="1"
      size="3"
      id="<?php echo $this->get_field_id( 'posts_per_slide' ); ?>"
      name="<?php echo $this->get_field_name( 'posts_per_slide' ); ?>"
      value="<?php echo esc_attr( $posts_per_slide ); ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'height' ); ?>">Height:</label>
      <input
      type="number"
      class=""
      min="1"
      step="1"
      size="3"
      id="<?php echo $this->get_field_id( 'height' ); ?>"
      name="<?php echo $this->get_field_name( 'height' ); ?>"
      value="<?php echo esc_attr( $height ); ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'autoplay' ); ?>">Autoplay:</label>
      <input
      type="checkbox"
      class="checkbox"
      id="<?php echo $this->get_field_id( 'autoplay' ); ?>"
      name="<?php echo $this->get_field_name( 'autoplay' ); ?>"
      <?php checked( $instance[ 'autoplay' ], 'on' ); ?>
       />
    </p>

		<p>
      <label for="<?php echo $this->get_field_id( 'hide_meta' ); ?>">Hide Post Meta:</label>
      <input
      type="checkbox"
      class="checkbox"
      id="<?php echo $this->get_field_id( 'hide_meta' ); ?>"
      name="<?php echo $this->get_field_name( 'hide_meta' ); ?>"
      <?php checked( $instance[ 'hide_meta' ], 'on' ); ?>
       />
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
    $instance[ 'posts_per_page' ] = strip_tags( $new_instance[ 'posts_per_page' ] );
    $instance[ 'posts_per_slide' ] = strip_tags( $new_instance[ 'posts_per_slide' ] );
    $instance[ 'height' ] = strip_tags( $new_instance[ 'height' ] );
		$instance[ 'autoplay' ] = strip_tags( $new_instance[ 'autoplay' ] );
    $instance[ 'hide_meta' ] = strip_tags( $new_instance[ 'hide_meta' ] );
    $instance[ 'category' ] = strip_tags( $new_instance[ 'category' ] );
    return $instance;
	}
}

add_action( 'widgets_init', function(){
	register_widget( 'LB_Post_Slider' );
});
