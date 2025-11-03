<?php
/**
 * Numinous Theme Customizer.
 *
 * @package Numinous
 */
function numinous_modify_sections( $wp_customize ){
	if ( version_compare( get_bloginfo('version'),'4.9', '>=') ) {
        $wp_customize->get_section( 'static_front_page' )->title = __( 'Static Front Page', 'numinous' );
    }
}
add_action( 'customize_register', 'numinous_modify_sections' );


$numinous_settings = array( 'default', 'header', 'home', 'breadcrumb', 'slider', 'ads', 'social', 'catcolor', 'post', 'info', 'footer' );

foreach( $numinous_settings as $setting ){
    require get_template_directory() . '/inc/customizer/' . $setting . '.php';
}

function numinous_pro_is_home_template(){
    return ( is_page_template( 'template-home.php' ) || ( is_front_page() && ! is_home() ) ) ? true : false;
}

/**
 * Sanitization Functions
*/
require get_template_directory() . '/inc/customizer/sanitization-functions.php';

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function numinous_customize_preview_js() {
	$build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'numinous_customizer', get_template_directory_uri() . '/js' . $build . '/customizer' . $suffix . '.js', array( 'customize-preview' ), NUMINOUS_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'numinous_customize_preview_js' );

/**
 * Enqueue Scripts for customize controls
*/
function numinous_customizer_scripts() {
    $array = array(
        'ajax_url'   => admin_url( 'admin-ajax.php' ),
    	'flushit'    => __( 'Successfully Flushed!','numinous' ),
    	'nonce'      => wp_create_nonce('ajax-nonce')
    );
	wp_enqueue_style( 'numinous-customize-style',get_template_directory_uri().'/inc/css/customize.css','',NUMINOUS_THEME_VERSION );    
    wp_enqueue_script( 'numinous-admin-js', get_template_directory_uri().'/inc/js/admin.js', array( 'jquery' ), '', true );

    wp_localize_script( 'numinous-admin-js', 'numinous_customizer_cdata', $array );
}
add_action( 'customize_controls_enqueue_scripts', 'numinous_customizer_scripts' );