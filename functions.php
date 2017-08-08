<?php
  function tpldir() {
    echo get_template_directory_uri();
  }

  function user() {
    return wp_get_current_user();
  }

  add_theme_support('post-thumbnails');

  function inhuman_query($type, $page = null) {
    $query = array(
      'post_type' => array('post', 'inhuman_screenshot'),
      'meta_query'  => array(
        array(
          'key' => 'inhuman_meta_status',
          'value' => 'publish'
        ),
        array(
          'relation' => 'OR',
          array(
            'key' => 'inhuman_meta_featured',
            'compare' => 'NOT EXISTS',
            'value' => ''
          ),
          array(
            'key' => 'inhuman_meta_featured',
            'value' => ''
          )
        )
      )
    );

    switch ($type) {
      case "popular":
        $query['meta_key'] = 'inhuman_meta_total_like_count';
        $query['orderby'] = 'meta_value_num';
        break;
      case "funny":
        $query['meta_key'] = 'inhuman_meta_like_funny_count';
        $query['orderby'] = 'meta_value_num';
        break;
      case "angry":
        $query['meta_key'] = 'inhuman_meta_like_angry_count';
        $query['orderby'] = 'meta_value_num';
        break;
      case "sad":
        $query['meta_key'] = 'inhuman_meta_like_sad_count';
        $query['orderby'] = 'meta_value_num';
        break;
      case "huh":
        $query['meta_key'] = 'inhuman_meta_like_huh_count';
        $query['orderby'] = 'meta_value_num';
        break;
      default:
        break;
    }

    if ($page) {
      $query['paged'] = $page;
    }

    return $query;
  }

  function add_query_vars_filter($vars){
    $vars[] = "e";
    return $vars;
  }
  add_filter('query_vars', 'add_query_vars_filter');

  //
  // Server-side variables to make available to JS
  //
  function inhuman_setup_js_vars() {
    $vars = array(
      'post_id' => get_the_ID(),
      'base_uri' => get_template_directory_uri(),
      'ajax_url' => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('inhuman-ads-nonce'),
      'user_display_name' => wp_get_current_user()->display_name
    );
    wp_localize_script('front', 'php_data', $vars);
    wp_localize_script('post', 'php_data', $vars);
  }

  //
  // Enqueue JS & CSS
  //
  function inhuman_enqueue_styles() {
    $tpldir = get_bloginfo('template_directory');
    wp_enqueue_style('default', $tpldir . '/styles/main.css');
    wp_enqueue_style('sidr', $tpldir . '/vendor/sidr/dist/stylesheets/jquery.sidr.bare.css' );
    wp_enqueue_style('buttons', $tpldir . '/vendor/buttons/css/buttons.css' );
    wp_enqueue_style('font-awesome', $tpldir . '/vendor/font-awesome/css/font-awesome.css' );
  }
  function inhuman_enqueue_scripts() {
    $tpldir = get_bloginfo('template_directory');
    wp_register_script('jquery', $tpldir . '/vendor/jquery/dist/jquery.min.js');
    wp_register_script('sidr', $tpldir . '/vendor/sidr/dist/jquery.sidr.min.js', array('jquery'));
    wp_register_script('dim-bg', $tpldir . '/vendor/jquery-dim-background/jquery.dim-background.min.js', array('jquery'));
    wp_register_script('jquery-isotope', $tpldir . '/vendor/isotope/dist/isotope.pkgd.min.js', array('jquery'));
    wp_register_script('jquery-docsize', $tpldir . '/vendor/jquery.documentsize/dist/jquery.documentsize.min.js', array('jquery'));
    wp_register_script('jquery-isinview', $tpldir . '/vendor/jquery.isinview/dist/jquery.isinview.min.js', array('jquery', 'jquery-docsize'));
    wp_register_script('sidebar', $tpldir . '/js/sidebar.js', array('jquery', 'sidr', 'dim-bg'));
    wp_register_script('front', $tpldir . '/js/front.js', array('jquery', 'jquery-isotope', 'jquery-isinview', 'sidebar'));
    wp_register_script('post', $tpldir . '/js/post.js', array('jquery', 'sidebar'));

    if (is_single()) {
      wp_enqueue_script('post');
    } else {
      wp_enqueue_script('front');
    }

    inhuman_setup_js_vars();
  }
  add_action('wp_enqueue_scripts', 'inhuman_enqueue_styles');
  add_action('wp_enqueue_scripts', 'inhuman_enqueue_scripts');

  //
  // AJAX Pagination
  //
  function load_more() {
    ob_start();

    $loop = new WP_Query(inhuman_query('popular', esc_attr($_POST['page'])));
    if($loop->have_posts()): while($loop->have_posts()): $loop->the_post();
    get_template_part('card', get_post_format());
	  endwhile; endif; wp_reset_postdata();

	  $data = ob_get_clean();
    wp_send_json_success($data);

    wp_die();
  }
  add_action('wp_ajax_ajax_load_more', 'load_more' );
  add_action('wp_ajax_nopriv_ajax_load_more', 'load_more' );

?>
