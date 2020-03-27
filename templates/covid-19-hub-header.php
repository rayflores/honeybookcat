<?php
/**
 * COVID-19 Hub Header Block
 * 
 * @package HoneyBook
 * @author Ray Flores
 * @version 1.0
 * @license GPL 2.0+
 **/
$header_title = get_field( 'header_title' );
$header_title_description = get_field( 'header_title_description' );

?>
<div class="term-bar">
  <div class="container">
    <h1 class="term-title"><?php echo $header_title; ?></h1>
    <div class="term-desc">
      <div class="term-description">
          <p><?php echo $header_title_description; ?></p>
      </div>		
    </div>
  </div>
</div>
