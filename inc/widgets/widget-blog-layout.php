<?php
class LB_Blog_Layout extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'lb_blog_layout',
			'description' => 'Blog Layout',
		);
		parent::__construct( 'lb_blog_layout', __('LB Blog Layout', 'ladybirds'), $widget_ops );
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

      <?php
        if ($instance['layout'] == 'list') {
          echo $this->get_list_layout($lb_posts);
        }elseif ($instance['layout'] == 'grid') {
          echo $this->get_grid_layout($lb_posts);
        }

      ?>
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
      <label for="<?php echo $this->get_field_id( 'layout' ); ?>">Layout Type:</label>
      <select
      class="widefat"
      id="<?php echo $this->get_field_id( 'layout' ); ?>"
      name="<?php echo $this->get_field_name( 'layout' ); ?>">
        <?php
          $layouts = array(
            'list' => 'List',
            'grid' => 'grid',
          );

          foreach ($layouts as $layout_slug => $layout_name) {
            $selected = ($layout_slug == $instance['layout'])? ' selected="selected"': '';
            echo '<option value="'.$layout_slug.'"'.$selected.'>'.$layout_name.'</option>';
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
    $instance[ 'layout' ] = strip_tags( $new_instance[ 'layout' ] );
    $instance[ 'posts_per_page' ] = strip_tags( $new_instance[ 'posts_per_page' ] );
    return $instance;
	}

  public function get_list_layout($lb_posts){

    ob_start();
    ?>
    <?php while ($lb_posts->have_posts()): $lb_posts->the_post(); ?>
    <article class="row lb-post-type-list">

      <?php if (has_post_thumbnail()): ?>
        <div class="col-md-4">
          <div class="post-thumbnail">
            <a href="<?php echo get_the_permalink(); ?>">
              <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" data-lbimg="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php echo get_the_title(); ?>">
            </a>
          </div>
        </div>
      <?php endif; ?>

      <?php
        $col = (has_post_thumbnail())? 'col-md-8' : 'col-md-12';
      ?>
      <div class="<?php echo $col; ?>">
        <div class="entry-header">
          <a href="<?php echo get_the_permalink(); ?>">
            <?php the_title('<h4 class="entry-title">', '</h4>'); ?>
          </a>
          <div class="entry-meta d-flex align-items-center">
            <?php ladybirds_posted_by(); ?>
            <?php ladybirds_posted_on(); ?>
          </div>
        </div>

        <div class="entry-content">
          <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
        </div>
      </div>
    </article>
    <?php endwhile; ?>
    <?php
    $output_string = ob_get_contents();
	  ob_end_clean();
	  return $output_string;
  }

  public function get_grid_layout($lb_posts){
    ob_start();
    ?>
    <div class="row">
      <?php while ($lb_posts->have_posts()): $lb_posts->the_post(); ?>
      <div class="col-md-6 ">
        <article class="lb-post-type-grid">
          <?php if (has_post_thumbnail()): ?>
            <div class="post-thumbnail">
              <a href="<?php echo get_the_permalink(); ?>">
                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" data-lbimg="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php echo get_the_title(); ?>">
              </a>
            </div>
          <?php endif; ?>

          <div class="entry-header">
            <a href="<?php echo get_the_permalink(); ?>">
              <?php the_title('<h4 class="entry-title">', '</h4>'); ?>
            </a>
            <div class="entry-meta d-flex align-items-center">
              <?php ladybirds_posted_by(); ?>
              <?php ladybirds_posted_on(); ?>
            </div>
          </div>

          <div class="entry-content">
            <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
          </div>
        </article>

      </div>
      <?php endwhile; ?>
    </div>
    <?php

    $output_string = ob_get_contents();
	  ob_end_clean();
	  return $output_string;
  }
}


add_action( 'widgets_init', function(){
	register_widget( 'LB_Blog_Layout' );
});
