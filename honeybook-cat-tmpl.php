<?php
/*
* Plugin Name: HoneyBook Category Template
* Plugin URI: https://rayflores.com/plugins/honeybook/
* Description: 
* Author: rayflores
* Author URI: https://rayflores.com
* Version: 1.0
*
* Copyright: © 2004-2018
* License: GNU General Public License v3.0
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
function honeybook_category_template() {
  return HB_Cat_Tmpl::get_instance();
}

// fire it up!
add_action( 'plugins_loaded', 'honeybook_category_template' );

class HB_Cat_Tmpl {
  /**
  * @var $instance single instance of this plugin 
  */
  protected static $instance;

  /**
  * @var $hb_cat_tmpl
  * Unique Identifier
  */
  protected $hb_cat_tmpl;

  /**
   * Template tracked
   */
  protected $templates;
  
  public function __construct() {
    add_filter( 'theme_page_templates', array( $this, 'add_category_template' ) );
    add_filter( 'wp_insert_post_data', array( $this, 'register_template' ) );
    add_filter( 'template_include', array( $this, 'view_template' ) );
    $this->templates = array(
        'risingtide-coronavirus.php' => 'Coronavirus',
    );
  }
  
  public function add_category_template( $post_templates ){
    $post_templates = array_merge( $post_templates, $this->templates );
    return $post_templates;
  }
  
  public function register_template( $atts ){
    $cache_key = 'page_template-' . md5( get_theme_root() . '/' . get_stylesheet() );
    
    $templates = wp_get_theme()->get_page_templates();
    if ( empty( $templates ) ){
      $templates = array();
    }
    
    wp_cache_delete( $cache_key, 'themes' );
    
    $templates = array_merge( $templates, $this->templates );
    
    wp_cache_add( $cache_key, $templates, 'themes', 1800 );
    
    return $atts;
  }
  
  public function view_template( $template ){
    global $post;
    
    if ( !$post ){
      return $template;
    }
    
    // default if not defined
    if ( !isset( $this->templates[ get_post_meta( $post->ID, '_wp_page_template', true ) ] ) ) {
      return $template;
    }
    
    $file = plugin_dir_path( __FILE__ ) . get_post_meta( $post->ID, '_wp_page_template', true );
    
    if ( file_exists( $file ) ){
      return $file;
    } else {
      echo $file;
    }
    
    return $template;
  }
  
  public function hooks() {
  }

  /**
   * Main Class Instance, ensures only one instance is/can be loaded
   *
   * @return \HB_Cat_Tmpl
   * @see honeybook_category_template()
   * @since 1.0.0
   */
  public static function get_instance() {
    if ( is_null( self::$instance ) ) {
      self::$instance = new self();
      self::$instance -> hooks();
        }
  }
} // end class