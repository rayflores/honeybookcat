<?php
/**
 * COVID-19 Hub Posts Section Block
 *
 * @package HoneyBook
 * @author Ray Flores
 * @version 1.0
 * @license GPL 2.0+
 **/

$section_title = get_field( 'section_title' ); // text
$get_posts_from = get_field( 'get_posts_from' ); // taxonomy/category
$category_link = get_field( 'category_link' ); // link url to category
$category_link_text = get_field( 'category_link_text' ); // if link url -> text for link

$sidebar = 'none';
$column_class = 'grid-item';
$image_size = '520';
wp_reset_query(); 
if ( $section_title ) : ?>
<div class="hub-posts">
    <h3 class="section-title" style="text-align: center;"><?php echo $section_title; ?></h3>
<?php 
endif; 

if ( $get_posts_from ) : 
$cats = implode( ', ', $get_posts_from );
$args = array( 
        'posts_per_page' => 3,
        'category' => array( $cats ),
        'post_type' => 'post',
        'order' => 'DESC',
        'orderby' => 'date'
);
$query = get_posts( $args );
 
?>
  <?php
  if ( $query ) : ?>
    <div class="posts-wrapper grid-wrapper">
    <?php 
      foreach ( $query as $post ) :  setup_postdata( $post );
    ?>
     <div class="<?php echo esc_attr( $column_class ); ?>">
       <article id="post-<?php echo $post->ID ?>" <?php post_class( 'post post-grid' ); ?>>
       <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
        <div class="entry-media">
            <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" style="background:url('	<?=get_the_post_thumbnail_url($post->ID,array( 520,520 ) ); ?>') no-repeat;">

            </a>
        </div>
      <?php endif; ?>

        <header class="entry-header">
          <?php if ( get_post_type( $post->ID ) == 'post' && ! hummingbird_get_option( 'hummingbird_disable_post_category', false ) ) : ?>
              <div class="entry-meta">
                  <?php $categories = get_the_category( $post->ID ); ?>
                  <span class="categories">
                    <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>"><?php echo esc_html( $categories[0]->name ); ?></a>
                  </span>
              </div>
          <?php endif; ?>

          <?php echo '<h2 class="entry-title" style="margin-top:0;"><a href="' . esc_url( get_permalink( $post->ID ) ) . '" rel="bookmark">' . $post->post_title . '</a></h2>'; ?>
        </header>

        <div class="entry-content">
          <p><?php echo wp_trim_words( $post->post_content, 11, NULL ); ?></p>
        </div>

      <?php if ( get_post_type( $post->ID ) == 'post' ) : ?>
        <footer class="entry-footer clearfix">
          <a class="entry-date" href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>">
            <?php echo sprintf( '<time datetime="%1$s">%2$s</time>', esc_attr( get_the_date( 'F j, Y', $post->ID ) ), esc_html( get_the_date( 'F j, Y', $post->ID ) ) ); ?>
          </a>
        </footer>
      <?php endif; ?>
        </article>
     </div>
<?php endforeach; ?>
  <?php 
      if ( $category_link ) : ?>
      <div class="category-link">
          <a href="<?php echo esc_url( get_category_link( $category_link ) ); ?>"><?php echo $category_link_text; ?></a>
      </div>
      <?php endif; ?>
  <?php endif; ?>
<?php wp_reset_query(); ?>
<?php endif; ?>
    </div>
</div>
