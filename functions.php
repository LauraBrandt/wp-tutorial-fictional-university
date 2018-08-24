<?php

  function university_files() {
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('custom_google_fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('university_main_styles', get_stylesheet_uri());
    
    wp_enqueue_script('main_university_javascript', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
  }

  add_action('wp_enqueue_scripts', 'university_files');


  function university_features() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
    // register_nav_menu('header-menu-location', 'Header Menu Location');
    // register_nav_menu('footer-location-1', 'Footer Location 1');
    // register_nav_menu('footer-location-2', 'Footer Location 2');
  }

  add_action('after_setup_theme', 'university_features');


  function university_adjust_queries($query) {
    if (!is_admin() and $query->is_main_query()) {
      if (is_post_type_archive('program')) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
      }

      if (is_post_type_archive('event')) {
        $today = date('Ymd');
      
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
          array( 
            'key' =>  'event_date', 
            'compare' => '>=', 
            'value' => $today,
            'type' => 'numeric'
          )
        ));
      }
    
    }
  }

  add_action('pre_get_posts', 'university_adjust_queries');

?>