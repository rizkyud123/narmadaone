<?php
/**
 * Numinous functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Numinous
 */

$numinous_theme_data = wp_get_theme();
if( ! defined( 'NUMINOUS_THEME_VERSION' ) ) define( 'NUMINOUS_THEME_VERSION', $numinous_theme_data->get( 'Version' ) );
if( ! defined( 'NUMINOUS_THEME_NAME' ) ) define( 'NUMINOUS_THEME_NAME', $numinous_theme_data->get( 'Name' ) );
if( ! defined( 'NUMINOUS_THEME_TEXTDOMAIN' ) ) define( 'NUMINOUS_THEME_TEXTDOMAIN', $numinous_theme_data->get( 'TextDomain' ) );

/**
 * Implement Local Font Method functions.
 */
require get_template_directory() . '/inc/class-webfont-loader.php';

/**
 * Implement the Custom functions.
 */
require get_template_directory() . '/inc/custom-functions.php';

/**
 * Custom template functions for this theme.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/widgets/widgets.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Metabox for Sidebar Layoute
*/
require get_template_directory() . '/inc/metabox.php';

/**
 * Getting Started
*/
require get_template_directory() . '/inc/getting-started/getting-started.php';

/**
 * Woocommerce Functions
*/
if( numinous_is_woocommerce_activated() ) 
require get_template_directory() . '/inc/woocommerce-functions.php';

/**
* Recommended Plugins
*/
require_once get_template_directory() . '/inc/tgmpa/recommended-plugins.php';