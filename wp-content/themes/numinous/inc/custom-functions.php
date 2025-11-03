<?php
/**
 * Numinous Custom Functions
 *
 * @package Numinous
 */

if ( ! function_exists( 'numinous_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function numinous_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Numinous, use a find and replace
	 * to change 'numinous' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'numinous', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'numinous' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-list',
		'gallery',
		'caption',
	) );
    
    /*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'link',
        'image',
		'quote',
        'video'
	) );
    
	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'numinous_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
    
    /** Custom Image Sizes */
    add_image_size( 'numinous-recent-post', 81, 76, true);
    add_image_size( 'numinous-slider', 480, 363, true);
    add_image_size( 'numinous-without-sidebar', 1170, 410, true);
    add_image_size( 'numinous-with-sidebar', 750, 410, true);
    add_image_size( 'numinous-featured-big', 960, 539, true);
    add_image_size( 'numinous-featured-img', 480, 270,true);
    add_image_size( 'numinous-top-news', 555, 494,true);
    add_image_size( 'numinous-more-news', 265, 186,true);
    add_image_size( 'numinous-single-col', 360, 197,true);
    add_image_size( 'numinous-most-viewed', 292, 160,true);
    add_image_size( 'numinous-related-post', 235, 129,true);
    
    /** Custom Logo */
    add_theme_support( 'custom-logo', array(    	
    	'header-text' => array( 'site-title', 'site-description' ),
    ) );

    remove_theme_support( 'widgets-block-editor' );
    
}
endif;
add_action( 'after_setup_theme', 'numinous_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function numinous_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'numinous_content_width', 750 );
}
add_action( 'after_setup_theme', 'numinous_content_width', 0 );

/**
* Adjust content_width value according to template.
*
* @return void
*/
function numinous_template_redirect_content_width() {

	// Full Width in the absence of sidebar.
	if( is_page() ){
	   $sidebar_layout = numinous_sidebar_layout();
       if( ( $sidebar_layout == 'no-sidebar' ) || ! ( is_active_sidebar( 'right-sidebar' ) ) ) $GLOBALS['content_width'] = 1170;
        
	}elseif ( ! ( is_active_sidebar( 'right-sidebar' ) ) ) {
		$GLOBALS['content_width'] = 1170;
	}

}
add_action( 'template_redirect', 'numinous_template_redirect_content_width' );

/**
 * Enqueue scripts and styles.
 */
function numinous_scripts() {
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    
    if( get_theme_mod( 'ed_localgoogle_fonts',false ) && ! is_customize_preview() && ! is_admin() ){
        if ( get_theme_mod( 'ed_preload_local_fonts',false ) ) {
			numinous_load_preload_local_fonts( numinous_get_webfont_url( numinous_fonts_url() ) );
        }
        wp_enqueue_style( 'numinous-google-fonts', numinous_get_webfont_url( numinous_fonts_url() ) );
    }else{
      wp_enqueue_style( 'numinous-google-fonts', numinous_fonts_url() );
    }

    wp_enqueue_style( 'owl-carousel', get_template_directory_uri(). '/css' . $build . '/owl.carousel' . $suffix . '.css'  );
    wp_enqueue_style( 'ticker-style', get_template_directory_uri(). '/css' . $build . '/ticker-style' . $suffix . '.css' );    
	wp_enqueue_style( 'numinous-style', get_stylesheet_uri(), array(), NUMINOUS_THEME_VERSION );
    
    wp_enqueue_script( 'all', get_template_directory_uri() . '/js' . $build . '/all' . $suffix . '.js', array( 'jquery' ), '6.1.1', true );
    wp_enqueue_script( 'v4-shims', get_template_directory_uri() . '/js' . $build . '/v4-shims' . $suffix . '.js', array( 'jquery' ), '6.1.1', true );

    if( numinous_is_woocommerce_activated() ) 
    wp_enqueue_style( 'numinous-woocommerce-style', get_template_directory_uri(). '/css' . $build . '/woocommerce' . $suffix . '.css', array(), NUMINOUS_THEME_VERSION );
    
    wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js' . $build . '/owl.carousel' . $suffix . '.js', array('jquery'), '2.2.1', true );
    wp_enqueue_script( 'owlcarousel2-a11ylayer', get_template_directory_uri() . '/js' . $build . '/owlcarousel2-a11ylayer' . $suffix . '.js', array('owl-carousel'), '0.2.1', true );
    wp_enqueue_script( 'jquery-ticker', get_template_directory_uri() . '/js' . $build . '/jquery.ticker' . $suffix . '.js', array('jquery'), NUMINOUS_THEME_VERSION, true );
    wp_enqueue_script( 'numinous-modal-accessibility', get_template_directory_uri() . '/js' . $build . '/modal-accessibility' . $suffix . '.js', array( 'jquery' ), NUMINOUS_THEME_VERSION, true );
    wp_enqueue_script( 'numinous-custom', get_template_directory_uri() . '/js' . $build . '/custom' . $suffix . '.js', array('jquery'), NUMINOUS_THEME_VERSION, true );
    
	$slider_auto    = get_theme_mod( 'numinous_slider_auto' );
    $slider_loop    = get_theme_mod( 'numinous_slider_loop' );
    $slider_control = get_theme_mod( 'numinous_slider_control', '1' );
    
    $array = array(
		'auto'    => esc_attr( $slider_auto ),
		'loop'    => esc_attr( $slider_loop ),
        'control' => esc_attr( $slider_control ),
        'rtl'     => is_rtl(),     
		);
    wp_localize_script( 'numinous-custom', 'numinous_data', $array );
    
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'numinous_scripts' );

if( ! function_exists( 'numinous_admin_scripts' ) ) :
/**
 * Enqueue admin scripts and styles.
*/
function numinous_admin_scripts(){
    wp_enqueue_style( 'numinous-admin', get_template_directory_uri() . '/inc/css/admin.css', '', NUMINOUS_THEME_VERSION );
}
endif; 
add_action( 'admin_enqueue_scripts', 'numinous_admin_scripts' );

/**
 * Flush out the transients used in numinous_categorized_blog.
 */
function numinous_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'numinous_categories' );
}
add_action( 'edit_category', 'numinous_category_transient_flusher' );
add_action( 'save_post',     'numinous_category_transient_flusher' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function numinous_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
    
    // Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
		$classes[] = 'custom-background-color';
	}
    
    if( !( is_active_sidebar( 'right-sidebar' ) ) ) {
        $classes[] = 'full-width'; 
    }
    
    if( is_page() ){
        $sidebar_layout = numinous_sidebar_layout();
        if( $sidebar_layout == 'no-sidebar' )
        $classes[] = 'full-width';
    }
    
    if( numinous_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() || 'product' === get_post_type() ) && ! is_active_sidebar( 'shop-sidebar' ) ){
        $classes[] = 'full-width';
    }
    
	return $classes;
}
add_filter( 'body_class', 'numinous_body_classes' );

if ( ! function_exists( 'numinous_excerpt_more' ) ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
 */
function numinous_excerpt_more( $more ) {
	return is_admin() ? $more : ' &hellip; ';
}
endif;
add_filter( 'excerpt_more', 'numinous_excerpt_more' );

if ( ! function_exists( 'numinous_excerpt_length' ) ) :
/**
 * Changes the default 55 character in excerpt 
*/
function numinous_excerpt_length( $length ) {
	return is_admin() ? $length : get_theme_mod( 'numinous_excerpt_char', 20 );
}
endif;
add_filter( 'excerpt_length', 'numinous_excerpt_length', 999 );

if( ! function_exists( 'numinous_change_comment_form_default_fields' ) ) :
/**
 * Change Comment form default fields i.e. author, email & url.
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function numinous_change_comment_form_default_fields( $fields ){    
    // get the current commenter if available
    $commenter = wp_get_current_commenter();
 
    // core functionality
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $required = ( $req ? " required" : '' );
    $author   = ( $req ? __( 'Name*', 'numinous' ) : __( 'Name', 'numinous' ) );
    $email    = ( $req ? __( 'Email*', 'numinous' ) : __( 'Email', 'numinous' ) );
 
    // Change just the author field
    $fields['author'] = '<p class="comment-form-author"><label class="screen-reader-text" for="author">' . esc_html__( 'Name', 'numinous' ) . '<span class="required">*</span></label><input id="author" name="author" placeholder="' . esc_attr( $author ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $required . ' /></p>';
    
    $fields['email'] = '<p class="comment-form-email"><label class="screen-reader-text" for="email">' . esc_html__( 'Email', 'numinous' ) . '<span class="required">*</span></label><input id="email" name="email" placeholder="' . esc_attr( $email ) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . $required. ' /></p>';
    
    $fields['url'] = '<p class="comment-form-url"><label class="screen-reader-text" for="url">' . esc_html__( 'Website', 'numinous' ) . '</label><input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'numinous' ) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'; 
    
    return $fields;    
}
endif;
add_filter( 'comment_form_default_fields', 'numinous_change_comment_form_default_fields' );

if( ! function_exists( 'numinous_change_comment_form_defaults' ) ) :
/**
 * Change Comment Form defaults
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function numinous_change_comment_form_defaults( $defaults ){    
    $defaults['comment_field'] = '<p class="comment-form-comment"><label class="screen-reader-text" for="comment">' . esc_html__( 'Comment', 'numinous' ) . '</label><textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'numinous' ) . '" cols="45" rows="8" aria-required="true" required></textarea></p>';
    
    return $defaults;    
}
endif;
add_filter( 'comment_form_defaults', 'numinous_change_comment_form_defaults' );

if( ! function_exists( 'numinous_exclude_posts' ) ) :
/**
 * Function to exclude sticky post from main query
*/
function numinous_exclude_posts( $query ){    
    $cat = get_theme_mod( 'numinous_breaking_news_cat' );
    
    if ( ! is_admin() && $query->is_home() && $query->is_main_query() && $cat ) {
        $query->set( 'category__not_in', $cat );
    }    
}
endif;
add_filter( 'pre_get_posts', 'numinous_exclude_posts' );

if( ! function_exists( 'numinous_admin_notice' ) ) :
/**
 * Addmin notice for getting started page
*/
function numinous_admin_notice(){
    global $pagenow;
    $theme_args      = wp_get_theme();
    $meta            = get_option( 'numinous_admin_notice' );
    $name            = $theme_args->__get( 'Name' );
    $current_screen  = get_current_screen();
    $dismissnonce    = wp_create_nonce( 'numinous_admin_notice' );
    
    if( 'themes.php' == $pagenow && !$meta ){
        
        if( $current_screen->id !== 'dashboard' && $current_screen->id !== 'themes' ){
            return;
        }

        if( is_network_admin() ){
            return;
        }

        if( ! current_user_can( 'manage_options' ) ){
            return;
        } ?>

        <div class="welcome-message notice notice-info">
            <div class="notice-wrapper">
                <div class="notice-text">
                    <h3><?php esc_html_e( 'Congratulations!', 'numinous' ); ?></h3>
                    <p><?php printf( __( '%1$s is now installed and ready to use. Click below to see theme documentation, plugins to install and other details to get started.', 'numinous' ), esc_html( $name ) ) ; ?></p>
                    <p><a href="<?php echo esc_url( admin_url( 'themes.php?page=numinous-getting-started' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Go to the getting started.', 'numinous' ); ?></a></p>
                    <p class="dismiss-link"><strong><a href="?numinous_admin_notice=1&_wpnonce=<?php echo esc_attr( $dismissnonce ); ?>"><?php esc_html_e( 'Dismiss', 'numinous' ); ?></a></strong></p>
                </div>
            </div>
        </div>
    <?php }
}
endif;
add_action( 'admin_notices', 'numinous_admin_notice' );

if( ! function_exists( 'numinous_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function numinous_update_admin_notice(){

    if (!current_user_can('manage_options')) {
        return;
    }

     // Bail if the nonce doesn't check out
     if ( ( isset( $_GET['numinous_admin_notice'] ) && $_GET['numinous_admin_notice'] = '1' ) && wp_verify_nonce( $_GET['_wpnonce'], 'numinous_admin_notice' ) ) {
        update_option( 'numinous_admin_notice', true );
    }

}
endif;
add_action( 'admin_init', 'numinous_update_admin_notice' );