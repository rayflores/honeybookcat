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

if ( $section_title ) :
?>
<div class="term-bar">
  <div class="container">
    <h1 class="term-title"><?php echo $section_title; ?></h1>
  </div>
</div>
<?php 
endif; 

if ( $get_posts_from ) : 
$cats = implode( ',', $get_posts_from );
$args = array( 
        'posts_per_page' => 3,
        'category__and' => array( $cats )
);
$query = new WP_Query( $args );
?>
  <?php
  if ( $query->have_posts() ) : ?>
    <div class="posts-wrapper grid-wrapper">
    <?php while ( $query->have_posts() ) : $query->the_post();
      $thumb_id = get_post_thumbnail_id();
      $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
      $thumb_url = $thumb_url_array[0];
    ?>
        <div class="grid-item">
            <article id="post-<?php echo get_the_ID(); ?>" class="post post-grid post-<?php echo get_the_ID(); ?> type-post status-publish format-standard has-post-thumbnail hentry">
                <div class="entry-media">
                    <a href="<?php the_permalink(); ?>" style="background:url('<?php echo $thumb_url ?>') no-repeat;">

                    </a>
                </div>
            </article>
        </div>
    <style>
        article.post.post-grid .entry-media > a {
            height: 100%;
            width: 100%;
            display: block;
            background-size: cover !important;
            background-position: center center !important;
        }
    </style>
   <?php endwhile;
  endif;
  ?>
  <?php   print_r( $get_posts_from );  ?>

<?php
endif;
?>

  <div class="grid-item">
    
      <div class="entry-media">
        <a href="https://www.honeybook.com/risingtide/cvhub/?p=22982" style="background:url('	https://www.honeybook.com/risingtide/cvhub/wp-content/uploads/2020/01/139-520x400.jpg') no-repeat;">

        </a>
      </div>

      <header class="entry-header">
        <div class="entry-meta">
          <span class="categories"><a href="https://www.honeybook.com/risingtide/cvhub/?cat=11" rel="category">Community</a></span>				</div>

        <h2 class="entry-title"><a href="https://www.honeybook.com/risingtide/cvhub/?p=22982" rel="bookmark">Rising Tide Road Trip Recap Pt. 1</a></h2>		</header>

      <div class="entry-content">
        <p>When we decided to host the #RisingTideRoadTrip back in December led...</p>		</div>

      <footer class="entry-footer clearfix">

        <a class="entry-date" href="https://www.honeybook.com/risingtide/cvhub/?p=22982">
          <time datetime="2020-01-29T05:06:00-05:00">January 29, 2020</time>    </a>


      </footer>
    </article>
  </div>
</div>