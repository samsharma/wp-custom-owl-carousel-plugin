<?php
/*
    Plugin Name: Custom owl Carousel
    Description: Simple implementation of Custom owl Carousel into WordPress
    Author: Metacube
    Version: 6.0
*/
if(!defined('ABSPATH')){
  header("location:/.home_url()");
  //die("Can't access");
}



function coc_post() {
  $COClabels = array(
    'name'               => _x( 'Home Page Sider', 'post type general name' ),
    'singular_name'      => _x( 'Home page sider', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'Home page sider' ),
    'add_new_item'       => __( 'Add New','Home page sider' ),
    'edit_item'          => __( 'Edit', 'Home page sider'),
    'new_item'           => __( 'New', 'Home page sider' ),
    'all_items'          => __( 'All','Home page sider' ),
    'view_item'          => __( 'View product' ),
    'search_items'       => __( 'Search', 'Home page sider' ),
    'not_found'          => __( 'No Home page sider found' ),
    'not_found_in_trash' => __( 'No Home page sider found in the Trash' ), 
    'parent_item_colon'  => __('Parent Home page sider'),
    'menu_name'          => 'Home Page Sider',
  );
  $supports = array(
    'title'               => 'title',
    'thumbnail'           => 'thumbnail',
    'description'         => 'description',
    'editor'              => 'editor',
    'custom-fields'       => 'custom-fields'
    
  );
  $args = array(
    'labels'          => $COClabels,
    'public'          => true,
      'supports'      => $supports,
      'menu_position' => 35,
      
  );
  register_post_type('np_images', $args);
}
add_action('init', 'coc_post', 0);








  //front view

  function COC_function($type='COC_function') {
    $args = array(
        'post_type' => 'np_images',
        'posts_per_page' => 5,
        'post_content' => 'title'
    );
    $result = '<div class="owl-carousel owl-theme">';
   
 
    //the loop
    $loop = new WP_Query($args);
    while ($loop->have_posts()) {
        $loop->the_post();
        $result .= '<div class="slider-row"><div class="img-box">';
        $the_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $type);
        $result .='<img title="'.get_the_title().'" src="' . $the_url[0] . '" data-thumb="' . $the_url[0] . '" alt=""/></div>';
        $result .='<div class="banner-box-title"><div class="inner-tite">'. get_the_content().'</div></div>';
        $result .= '</div>';
    }
  
    $result .='</div>';
    return $result;
}

add_shortcode('COC-shortcode', 'COC_function');




/// style and js //////

function my_COC_custom_scripts(){
  //js
  $path_script = plugins_url('style/js/COC-main.js', __FILE__);
  $path_script_main = plugins_url('style/js/owl.carousel.min.js', __FILE__);
  $dep_script = array('jquery');
  $ver_script = filemtime(plugin_dir_path(__FILE__).'style/js/COC-main.js');
  $ver_script_mian = filemtime(plugin_dir_path(__FILE__).'style/js/owl.carousel.min.js');
  wp_enqueue_script('my-COC-owl-carousel-min-js', $path_script_main, $dep_script, $ver_script_mian, true);
  wp_enqueue_script('my-COC-custom-js', $path_script, $dep_script, $ver_script, true);
  
  

  //css
  $path_css = plugins_url('style/css/COC-style.css', __FILE__);
  $ver_css = filemtime(plugin_dir_path(__FILE__).'style/css/COC-style.css');

  $path_css_mian = plugins_url('style/css/owl.carousel.min.css', __FILE__);
  $ver_css_main = filemtime(plugin_dir_path(__FILE__).'style/css/owl.carousel.min.css');

  

  wp_enqueue_style('my-COC-owl-carousel-min-custom-css', $path_css_mian, $ver_css_main, );
  wp_enqueue_style('my-COC-custom-css', $path_css, $ver_css, );


  }
  

  add_action('wp_enqueue_scripts','my_COC_custom_scripts'); // load for back-end



?>