<?php
$image = get_field( 'event_image' );
$image_src = wp_get_attachment_image_src( $image['ID'], 'large' );
$event_title = get_field( 'event_title' );
$event_description = get_field( 'event_description' );
$event_link = get_field( 'event_registration_link' );
$event_link_text = get_field ( 'event_registration_link_text' );
?>
<div class="featured-block big-featured event">
    <article class="featured-post-single">
        <div class="featured-inner">
          <?php if ( $image ) : ?>
          <div class="img">
              <img src="<?php echo $image_src[0]; ?>" alt="<?php echo $event_title; ?>">
          </div>
          <?php endif; ?>
          <div class="featured-content">
            <h3 class="entry-title">
              <?php echo $event_title; ?>
            </h3>
            <p class="entry-description">
              <?php echo $event_description; ?>
            </p>
            <?php if ( $event_link ) : ?>
            <a href="<?php echo $event_link; ?>" target="_blank">
              <?php echo $event_link_text; ?>
            </a>
            <?php endif; ?>
          </div>
        </div>
    </article>
</div>
