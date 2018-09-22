<?php
class LB_Recent_Post_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'lb_recent_post_widget',
			'description' => 'Recent posts widget',
		);
		parent::__construct( 'lb_recent_post_widget', __('LB Recent Posts Widget', 'ladybirds'), $widget_ops );
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
		?>

    <?php if ($lb_recent_posts->have_posts()): ?>
      <div class="lb-recent-post-list">
      <?php while ($lb_recent_posts->have_posts()): $lb_recent_posts->the_post(); ?>

        <article class="lb-cat-item">
          <?php if (has_post_thumbnail()): ?>
            <div class="lb-post-thumb">
              <a href="<?php echo get_the_permalink(); ?>">
                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>" alt="<?php echo get_the_title(); ?>">
              </a>
            </div>
          <?php endif; ?>

          <div class="lb-post-desc">
            <h5 class="post-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
            <?php ladybirds_posted_on(); ?>
          </div>
        </article>

      <?php endwhile; ?>
      </div>
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
    $instance[ 'category' ] = strip_tags( $new_instance[ 'category' ] );
    return $instance;
	}
}

add_action( 'widgets_init', function(){
	register_widget( 'LB_Recent_Post_Widget' );
});
