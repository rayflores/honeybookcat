<?php
/**
 * COVID-19 Hub Featured Post Block
 *
 * @package HoneyBook
 * @author Ray Flores
 * @version 1.0
 * @license GPL 2.0+
 **/
$featured_post = get_field( 'featured_post' ); // post Object
$post = $featured_post;
setup_postdata( $post );
$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array('220','220'), true );
$thumbnail_url = $thumbnail_url[0];
?>
<div class="featured-block big-featured">
    <article class="featured-post-single">
        <div class="featured-inner">
            <div class="featured-content">
                <h3 class="entry-title">
                  <?php the_title(); ?>
                </h3>
                <p class="entry-description">
                  <?php the_excerpt(); ?>
                </p>
                <a href="<?php the_permalink(); ?>" target="_blank">
                  <?php the_title(); ?>
                </a>
            </div>
        </div>
        <div class="img">
            <img src="<?php echo $thumbnail_url; ?>" alt="<?php the_title(); ?>">
        </div>
    </article>
</div>