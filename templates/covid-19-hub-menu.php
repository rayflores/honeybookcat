<?php

/**
 * COVID-19 Hub Menu Block
 *
 * @package HoneyBook
 * @author Ray Flores
 * @version 1.0
 * @license GPL 2.0+
 **/
$menu = get_field( 'hub_navigation_selector' );

$args = array( 'menu' => $menu);
wp_nav_menu( $args );
?>
