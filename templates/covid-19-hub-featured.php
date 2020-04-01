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
$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', true );
$thumbnail_url = $thumbnail_url[0];
?>
<div class="featured-block big-featured">
    <article class="featured-post-single">
        <div class="featured-inner">
            <div class="featured-content">
                <h3 class="entry-title">
                  <?php echo $post->post_title; ?>
                </h3>
                <p class="entry-description">
                  <?php echo $post->post_excerpt; ?>
                </p>
                <a href="<?php echo get_permalink( $post ); ?>" target="_blank">
                  READ MORE
                </a>
            </div>
        </div>
        <div class="img">
            <img src="<?php echo $thumbnail_url; ?>" alt="<?php echo $post->post_title; ?>">
        </div>
    </article>
</div>