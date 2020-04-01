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
   * HB_Cat_Tmpl settings var
   */
  var $settings;
  
  public function __construct() {
    $this->templates = array();
    add_filter( 'theme_page_templates', array( $this, 'add_new_template' ) );
    add_filter( 'wp_insert_post_data', array( $this, 'register_project_templates' ) );
    add_filter( 'template_include', array( $this, 'view_project_template') );
    $this->templates = array( 'covid-19-hub-page-template.php' => 'COVID-19 Hub' );
    add_action( 'acf/init', array( $this, 'honeybook_register_blocks' ) );
    add_action( 'acf/include_field_types', array( $this, 'include_menu_selector_field' ) );
    add_action( 'acf/register_fields', array( $this, 'include_menu_selector_field' ) );
    
  }
  public function include_menu_selector_field(){
   include_once( 'fields/class-honeybook-acf-field-menu-selector-v5.php' );
  }
  public function honeybook_register_blocks(){
    if ( ! function_exists( 'acf_register_block_type' ) )
      return;
    
    acf_register_block_type( array(
            'name' => 'covid-19-hub-posts',
            'title' => __( 'Covid-19 Hub Posts', 'honeybook' ),
            'render_template' => plugin_dir_path( __FILE__ ) . 'templates/covid-19-hub-posts.php',
            'category' => 'common',
            'icon' => 'sos',
            'mode' => 'auto',
            'keywords' => array( 'covid', '19', 'posts', 'section', 'hub' )
        )
    );
    acf_register_block_type( array(
            'name' => 'covid-19-hub-featured',
            'title' => __( 'Covid-19 Hub Featured', 'honeybook' ),
            'render_template' => plugin_dir_path( __FILE__ ) . 'templates/covid-19-hub-featured.php',
            'category' => 'common',
            'icon' => 'sos',
            'mode' => 'auto',
            'keywords' => array( 'covid', '19', 'posts', 'featured', 'hub' )
        )
    );
    acf_register_block_type( array(
            'name' => 'covid-19-hub-featured-event',
            'title' => __( 'Covid-19 Hub Featured Event', 'honeybook' ),
            'render_template' => plugin_dir_path( __FILE__ ) . 'templates/covid-19-hub-featured-event.php',
            'category' => 'common',
            'icon' => 'sos',
            'mode' => 'auto',
            'keywords' => array( 'covid', '19', 'posts', 'featured', 'hub', 'event' )
        )
    );
    acf_register_block_type( array(
            'name' => 'covid-19-hub-nav',
            'title' => __( 'Covid-19 Hub Menu', 'honeybook' ),
            'render_template' => plugin_dir_path( __FILE__ ) . 'templates/covid-19-hub-menu.php',
            'category' => 'common',
            'icon' => 'sos',
            'mode' => 'auto',
            'keywords' => array( 'covid', '19', 'posts', 'featured', 'hub' ),
        )
    );
    
  }
  public function add_new_template( $posts_templates ) {
    $posts_templates = array_merge( $posts_templates, $this->templates );
    return $posts_templates;
  }
  public function register_project_templates( $atts ) {
    
    $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
    
    $templates = wp_get_theme()->get_page_templates();
    if ( empty( $templates ) ) {
      $templates = array();
    }
    
    wp_cache_delete( $cache_key , 'themes');
    
    $templates = array_merge( $templates, $this->templates );

    wp_cache_add( $cache_key, $templates, 'themes', 1800 );

    return $atts;

  }
  public function view_project_template( $template ) {
    global $post;

    if ( ! $post ) {
      return $template;
    }

    if ( !isset( $this->templates[get_post_meta(
            $post->ID, '_wp_page_template', true
        )] ) ) {
      return $template;
    }

    $file = plugin_dir_path(__FILE__). 'page-template/' . get_post_meta(
            $post->ID, '_wp_page_template', true
        );

    if ( file_exists( $file ) ) {
      return $file;
    } else {
      echo $file;
    }

    return $template;

  }
  public function styles_scripts(){
    wp_enqueue_style( 'covid-19-hub-styles', plugins_url('/css/covid-19-hub.css', __FILE__ ), array(), time() );
  }
  public function hooks() {
    
    add_action( 'wp_enqueue_scripts', array( $this, 'styles_scripts' ) );
    
    if( function_exists('acf_add_local_field_group') ):

      acf_add_local_field_group(array(
          'key' => 'group_5e7e10bada547',
          'title' => 'Covid-19 Featured Post',
          'fields' => array(
              array(
                  'key' => 'field_5e7e10c78661f',
                  'label' => 'Featured Post',
                  'name' => 'featured_post',
                  'type' => 'post_object',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => 0,
                  'wrapper' => array(
                      'width' => '',
                      'class' => '',
                      'id' => '',
                  ),
                  'post_type' => array(
                      0 => 'post',
                  ),
                  'taxonomy' => '',
                  'allow_null' => 0,
                  'multiple' => 0,
                  'return_format' => 'object',
                  'ui' => 1,
              ),
          ),
          'location' => array(
              array(
                  array(
                      'param' => 'block',
                      'operator' => '==',
                      'value' => 'acf/covid-19-hub-featured',
                  ),
              ),
          ),
          'menu_order' => 0,
          'position' => 'normal',
          'style' => 'default',
          'label_placement' => 'top',
          'instruction_placement' => 'label',
          'hide_on_screen' => '',
          'active' => true,
          'description' => '',
      ));

      acf_add_local_field_group(array(
          'key' => 'group_5e7def5ca5200',
          'title' => 'Covid-19 Hub Header Fields',
          'fields' => array(
              array(
                  'key' => 'field_5e7dffbee6f8d',
                  'label' => 'Header Title',
                  'name' => 'header_title',
                  'type' => 'text',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => 0,
                  'wrapper' => array(
                      'width' => '',
                      'class' => '',
                      'id' => '',
                  ),
                  'default_value' => '',
                  'placeholder' => '',
                  'prepend' => '',
                  'append' => '',
                  'maxlength' => '',
              ),
              array(
                  'key' => 'field_5e7dffcbe6f8e',
                  'label' => 'Header Title Description',
                  'name' => 'header_title_description',
                  'type' => 'wysiwyg',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => 0,
                  'wrapper' => array(
                      'width' => '',
                      'class' => '',
                      'id' => '',
                  ),
                  'default_value' => '',
                  'tabs' => 'all',
                  'toolbar' => 'full',
                  'media_upload' => 0,
                  'delay' => 0,
              ),
          ),
          'location' => array(
              array(
                  array(
                      'param' => 'block',
                      'operator' => '==',
                      'value' => 'acf/covid-19-hub-header',
                  ),
              ),
          ),
          'menu_order' => 0,
          'position' => 'normal',
          'style' => 'default',
          'label_placement' => 'top',
          'instruction_placement' => 'label',
          'hide_on_screen' => '',
          'active' => true,
          'description' => '',
      ));

      acf_add_local_field_group(array(
          'key' => 'group_5e7e0f8ba12c0',
          'title' => 'Covid-19 Posts Section Fields',
          'fields' => array(
              array(
                  'key' => 'field_5e7e0fa3ebaba',
                  'label' => 'Section Title',
                  'name' => 'section_title',
                  'type' => 'text',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => 0,
                  'wrapper' => array(
                      'width' => '',
                      'class' => '',
                      'id' => '',
                  ),
                  'default_value' => '',
                  'placeholder' => '',
                  'prepend' => '',
                  'append' => '',
                  'maxlength' => '',
              ),
              array(
                  'key' => 'field_5e7e0fc1ebabb',
                  'label' => 'Get Posts From',
                  'name' => 'get_posts_from',
                  'type' => 'taxonomy',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => 0,
                  'wrapper' => array(
                      'width' => '',
                      'class' => '',
                      'id' => '',
                  ),
                  'taxonomy' => 'category',
                  'field_type' => 'multi_select',
                  'allow_null' => 0,
                  'add_term' => 0,
                  'save_terms' => 0,
                  'load_terms' => 0,
                  'return_format' => 'id',
                  'multiple' => 0,
              ),
              array(
                  'key' => 'field_5e7e1053ebabc',
                  'label' => 'Category Link',
                  'name' => 'category_link',
                  'type' => 'taxonomy',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => 0,
                  'wrapper' => array(
                      'width' => '',
                      'class' => '',
                      'id' => '',
                  ),
                  'taxonomy' => 'category',
                  'field_type' => 'select',
                  'allow_null' => 1,
                  'add_term' => 0,
                  'save_terms' => 0,
                  'load_terms' => 0,
                  'return_format' => 'id',
                  'multiple' => 0,
              ),
              array(
                  'key' => 'field_5e7e108bebabd',
                  'label' => 'Category Link Text',
                  'name' => 'category_link_text',
                  'type' => 'text',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => array(
                      array(
                          array(
                              'field' => 'field_5e7e1053ebabc',
                              'operator' => '!=empty',
                          ),
                      ),
                  ),
                  'wrapper' => array(
                      'width' => '',
                      'class' => '',
                      'id' => '',
                  ),
                  'default_value' => '',
                  'placeholder' => '',
                  'prepend' => '',
                  'append' => '',
                  'maxlength' => '',
              ),
          ),
          'location' => array(
              array(
                  array(
                      'param' => 'block',
                      'operator' => '==',
                      'value' => 'acf/covid-19-hub-posts',
                  ),
              ),
          ),
          'menu_order' => 0,
          'position' => 'normal',
          'style' => 'default',
          'label_placement' => 'top',
          'instruction_placement' => 'label',
          'hide_on_screen' => '',
          'active' => true,
          'description' => '',
      ));
      acf_add_local_field_group(array(
          'key' => 'group_5e7e566988b3e',
          'title' => 'Navs',
          'fields' => array(
              array(
                  'key' => 'field_5e7e566c4ce9d',
                  'label' => 'Hub Navigation Selector',
                  'name' => 'hub_navigation_selector',
                  'type' => 'nav_menu',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => 0,
                  'wrapper' => array(
                      'width' => '',
                      'class' => '',
                      'id' => '',
                  ),
                  'save_format' => 'id',
                  'container' => 'div',
                  'allow_null' => 1,
              ),
          ),
          'location' => array(
              array(
                  array(
                      'param' => 'block',
                      'operator' => '==',
                      'value' => 'acf/covid-19-hub-nav',
                  ),
              ),
          ),
          'menu_order' => 0,
          'position' => 'normal',
          'style' => 'default',
          'label_placement' => 'top',
          'instruction_placement' => 'label',
          'hide_on_screen' => '',
          'active' => true,
          'description' => '',
      ));
      acf_add_local_field_group(array(
          'key' => 'group_5e85006e40d2b',
          'title' => 'Covid-19 Hub Event Fields',
          'fields' => array(
              array(
                  'key' => 'field_5e850075a4d67',
                  'label' => 'Event Image',
                  'name' => 'event_image',
                  'type' => 'image',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => 0,
                  'wrapper' => array(
                      'width' => '',
                      'class' => '',
                      'id' => '',
                  ),
                  'return_format' => 'array',
                  'preview_size' => 'large',
                  'library' => 'all',
                  'min_width' => '',
                  'min_height' => '',
                  'min_size' => '',
                  'max_width' => '',
                  'max_height' => '',
                  'max_size' => '',
                  'mime_types' => '',
              ),
              array(
                  'key' => 'field_5e85009aa4d68',
                  'label' => 'Event Title',
                  'name' => 'event_title',
                  'type' => 'text',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => 0,
                  'wrapper' => array(
                      'width' => '',
                      'class' => '',
                      'id' => '',
                  ),
                  'default_value' => '',
                  'placeholder' => '',
                  'prepend' => '',
                  'append' => '',
                  'maxlength' => '',
              ),
              array(
                  'key' => 'field_5e8500a8a4d69',
                  'label' => 'Event Description',
                  'name' => 'event_description',
                  'type' => 'wysiwyg',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => 0,
                  'wrapper' => array(
                      'width' => '',
                      'class' => '',
                      'id' => '',
                  ),
                  'default_value' => '',
                  'tabs' => 'all',
                  'toolbar' => 'full',
                  'media_upload' => 0,
                  'delay' => 0,
              ),
              array(
                  'key' => 'field_5e8500c3a4d6a',
                  'label' => 'Event Registration Link',
                  'name' => 'event_registration_link',
                  'type' => 'url',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => 0,
                  'wrapper' => array(
                      'width' => '',
                      'class' => '',
                      'id' => '',
                  ),
                  'default_value' => '',
                  'placeholder' => '',
              ),
              array(
                  'key' => 'field_5e8500d4a4d6b',
                  'label' => 'Event Registration Link Text',
                  'name' => 'event_registration_link_text',
                  'type' => 'text',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => 0,
                  'wrapper' => array(
                      'width' => '',
                      'class' => '',
                      'id' => '',
                  ),
                  'default_value' => '',
                  'placeholder' => '',
                  'prepend' => '',
                  'append' => '',
                  'maxlength' => '',
              ),
          ),
          'location' => array(
              array(
                  array(
                      'param' => 'block',
                      'operator' => '==',
                      'value' => 'acf/covid-19-hub-featured-event',
                  ),
              ),
          ),
          'menu_order' => 0,
          'position' => 'normal',
          'style' => 'default',
          'label_placement' => 'top',
          'instruction_placement' => 'label',
          'hide_on_screen' => '',
          'active' => true,
          'description' => '',
      ));

    endif;
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