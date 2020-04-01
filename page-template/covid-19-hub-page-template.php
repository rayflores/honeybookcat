<?php
/**
 * Template Name: COVID-19 Hub
 */
$sidebar = hummingbird_get_option( 'hummingbird_sidebar', 'right' );
$column_classes = hummingbird_column_classes( $sidebar );
$wrapper_class = 'posts-wrapper';
$wrapper_class .= hummingbird_is_layout( 'grids' ) ? ' grid-wrapper' : '';
$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'full' )[0];
$link = get_field('link');
$description = get_field( 'description', $post->ID );
?>

<?php get_header(); ?>
<div class="term-bar">
  <div class="container">
    <div class="pillar-box">
      <div class="pillar-box-content">
        <h1 class="hub-title-small"><?php the_title(); ?></h1>
        <p class="hub-description"><?php echo strip_tags( $description ); ?></p>

      </div>
    </div>
  </div>
</div>
<div class="site-content">
  <div class="container">
    <div class="<?php echo esc_attr( $column_classes[0] ); ?>">
      <div class="content-area">
        <main class="site-main">

          <?php if ( have_posts() ) : ?>
          
          <div class="<?php echo esc_attr( $wrapper_class ); ?>">
            <?php while ( have_posts() ) : the_post(); 
              the_content(); 
              endwhile; ?>
          </div>
  
<?php endif; ?>
        </main>
      </div>
    </div>
      <?php get_template_part( 'template-parts/mailing_list'); ?>
  </div>
</div>
<?php

get_footer(); 
