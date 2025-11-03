<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Numinous
 */

if ( ! function_exists( 'numinous_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date
 */
function numinous_posted_on() {	
	printf( '<span class="posted-on"><i class="fa fa-calendar" aria-hidden="true"></i><a href="%1$s" rel="bookmark"><time class="entry-date published updated" datetime="%2$s">%3$s</time></a></span>', esc_url( get_permalink() ), esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date( 'j M Y' ) ) );
}
endif;

if( ! function_exists( 'numinous_posted_by' ) ) :
/**
 * Post posted by
*/
function numinous_posted_by(){    
    printf( '<span class="byline author vcard" itemprop="author" itemscope itemtype="https://schema.org/Person"><i class="fa fa-user" aria-hidden="true"></i><a class="url fn n" href="%1$s">%2$s</a></span>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ) );    
}
endif;

if( ! function_exists( 'numinous_comment_count' ) ) :
/**
 * Post Comment count
*/
function numinous_comment_count(){
    if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo '<span class="comment"><i class="fa fa-comment" aria-hidden="true"></i>';
		comments_popup_link( esc_html__( 'Leave a comment', 'numinous' ), esc_html__( '1 Comment', 'numinous' ), esc_html__( '% Comments', 'numinous' ) );
		echo '</span>';
    }
}
endif;

if( ! function_exists( 'numinous_meta' ) ) :
/**
 * Post Meta Data
*/
function numinous_meta( $date = false, $author = false, $comment = false ){
    if( $date || $comment || $author ){
        echo '<div class="entry-meta">';
        if( $date ) numinous_posted_on();
        if( $author ) numinous_posted_by();
        if( $comment ) numinous_comment_count();            
        echo '</div>';
    }
}
endif;

if( ! function_exists( 'numinous_colored_category' ) ) :
/**
 * Colored category
*/
function numinous_colored_category(){
    $output = '';
    // Hide category for pages.
	if ( 'post' === get_post_type() ) {		
		$categories_list = get_the_category();
		if ( $categories_list ) {
            $output .= '<span class="category">';
                foreach( $categories_list as $category ){
                $color_code = get_theme_mod( 'numinous_category_color_' . $category->term_id );
                    if ( $color_code ) {
                       $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" style="background:' . esc_attr( $color_code ) . '" rel="category tag">'. esc_html( $category->cat_name ) .'</a>';
                    }else{
                       $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '"  rel="category tag">' . esc_html( $category->cat_name ) . '</a>';
                    }
                }
            $output .='</span>';
            echo $output;         
		}
	}
}
endif;

if ( ! function_exists( 'numinous_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the.
 */
function numinous_entry_footer() {	
	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'numinous' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Return sidebar layouts for pages
*/
function numinous_sidebar_layout(){
    global $post;
    
    if( get_post_meta( $post->ID, 'numinous_sidebar_layout', true ) ){
        return get_post_meta( $post->ID, 'numinous_sidebar_layout', true );    
    }else{
        return 'right-sidebar';
    }
}

if( ! function_exists( 'numinous_comment' ) ):
/**
 * Callback function for Comment List
 * 
 * @link https://codex.wordpress.org/Function_Reference/wp_list_comments 
 */
function numinous_comment( $comment, $args, $depth ) {
    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
?>
    <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body" itemscope itemtype="https://schema.org/UserComments">
    <?php endif; ?>
    
    <footer class="comment-meta">
        <div class="comment-author vcard">
        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        <?php printf( '<b class="fn" itemprop="creator" itemscope itemtype="https://schema.org/Person">%s</b>', get_comment_author_link() ); ?>
        </div>
        
        <?php if ( $comment->comment_approved == '0' ) : ?>
            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'numinous' ); ?></em>
            <br />
        <?php endif; ?>
    
        <div class="comment-metadata commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
            <?php
                printf( '%1$s', esc_html( get_comment_date() ) ); ?></a><?php edit_comment_link( __( 'Edit', 
                'numinous' ), '  ', '' );
            ?>
        </div>
    </footer>
    
    <div class="comment-content">
       <?php comment_text(); ?>
    </div>
    
    <div class="reply">
    <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div>
    
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php
}
endif;

if( ! function_exists( 'numinous_get_home_catpost' ) ) :
/**
 * Helper function to retrieve category listing in home page.
*/
function numinous_get_home_catpost( $cat_id, $class, $paged, $img_size_one, $img_size_two ){
    
    if( $cat_id ){
    $single_qry = new WP_Query( "post_type=post&posts_per_page=1&cat=$cat_id" );
    $cat = get_category( $single_qry->query_vars['cat'] );
    ?>
    <section class="<?php echo esc_attr( $class ); ?>">
		<h2 class="section-title"><a href="<?php echo esc_url( get_category_link( $cat_id ) ); ?>"><?php echo esc_html( $cat->name ); ?></a></h2>
		<?php 
        if( $single_qry->have_posts() && $class !== 'more-news-section' ){
            while( $single_qry->have_posts() ){
                $single_qry->the_post();
                if( $class === 'sport-section' ) echo '<div class="col-1">';
                ?>
                <article class="post">
                	<a href="<?php the_permalink(); ?>" class="post-thumbnail">
                        <?php 
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail( esc_attr( $img_size_one ), array( 'itemprop' => 'image' ) ); 
                        }else{
                            numinous_get_fallback_svg( $img_size_one );
                        } 
                        ?>
                            
                    </a>
                	<header class="entry-header">
                		<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                		<?php numinous_meta( true, true ); ?>
                	</header>
                	<div class="entry-content">
                		<?php the_excerpt(); ?>
                	</div>
                	<?php
                    if( $class === 'world-section' || $class === 'fashion-section' ){
                        numinous_meta( false, false, true );
                    }
                    ?>
                </article>        
                <?php
                if( $class === 'sport-section' ) echo '</div>';
            }
            wp_reset_postdata();
        }
                
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $paged,
            'cat' => $cat_id,            
        );
        if( $class !== 'more-news-section' ){
            $args['offset'] = 1;
        }
        
        $second_qry = new WP_Query( $args );
        if( $second_qry->have_posts()){
            if( $class === 'sport-section' ) echo '<div class="col-1 lists">';
            echo '<ul>';
            while( $second_qry->have_posts() ){
                $second_qry->the_post();
                ?>
                <li>
    				<article class="post">
    					<a href="<?php the_permalink(); ?>" class="post-thumbnail">
                            <?php 
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( esc_attr( $img_size_two ), array( 'itemprop' => 'image' ) ); 
                            }else{
                                numinous_get_fallback_svg( $img_size_two );
                            } ?>
                                
                        </a>
    					<header class="entry-header">
    						<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    						<?php numinous_meta( true, true ); ?>                            
    					</header>
                        <?php if( $class === 'health-section' || $class === 'more-news-section' ){ ?>
                            <div class="entry-content">
                        		<?php the_excerpt(); ?>
                        	</div>
                        <?php } ?>
    				</article>
    			</li>
                <?php
            }
            wp_reset_postdata();
            echo '</ul>';
            if( $class === 'sport-section' ) echo '</div>';
        }
        ?>
	</section>
    <?php 
    }       
}
endif;

if( ! function_exists( 'numinous_pagination' ) ) :
/**
 * Pagination
*/
function numinous_pagination(){    
    if( is_single() ){
        the_post_navigation();
    }else{
        the_posts_pagination( array(
            'prev_next'          => false,
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'numinous' ) . ' </span>',
         ) );
    }    
}
endif;

if( ! function_exists( 'numinous_get_social_links' ) ) :
/**
 * Get Social Links
*/
function numinous_get_social_links(){
    $facebook  = get_theme_mod( 'numinous_facebook' );
    $twitter   = get_theme_mod( 'numinous_twitter' );
    $pinterest = get_theme_mod( 'numinous_pinterest' );
    $linkedin  = get_theme_mod( 'numinous_linkedin' );
    $gplus     = get_theme_mod( 'numinous_gplus' );
    $instagram = get_theme_mod( 'numinous_instagram' );
    $youtube   = get_theme_mod( 'numinous_youtube' );
    $ok        = get_theme_mod( 'numinous_odnoklassniki' );
    $vk        = get_theme_mod( 'numinous_vk' );
    $xing      = get_theme_mod( 'numinous_xing' );
    $tiktok    = get_theme_mod( 'numinous_tiktok' );
    
    if( $facebook || $twitter || $pinterest || $linkedin || $gplus || $instagram || $youtube || $ok || $vk || $xing || $tiktok ){
    ?>
    <ul class="social-media">
		<?php if( $facebook ){ ?>
            <li><a href="<?php echo esc_url( $facebook ); ?>" target="_blank" title="<?php esc_attr_e( 'Facebook', 'numinous' );?>"><i class="fa fa-facebook"></i></a></li>
		<?php } if( $twitter ){ ?>
            <li><a href="<?php echo esc_url( $twitter ); ?>" target="_blank" title="<?php esc_attr_e( 'Twitter', 'numinous' );?>"><i class="fa fa-twitter"></i></a></li>
        <?php } if( $pinterest ){ ?>
            <li><a href="<?php echo esc_url( $pinterest ); ?>" target="_blank" title="<?php esc_attr_e( 'Pinterest', 'numinous' );?>"><i class="fa fa-pinterest"></i></a></li>
		<?php } if( $linkedin ){ ?>
            <li><a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" title="<?php esc_attr_e( 'LinkedIn', 'numinous' );?>"><i class="fa fa-linkedin"></i></a></li>
        <?php } if( $gplus ){ ?>
            <li><a href="<?php echo esc_url( $gplus ); ?>" target="_blank" title="<?php esc_attr_e( 'Google Plus', 'numinous' );?>"><i class="fa fa-google-plus"></i></a></li>
        <?php } if( $instagram ){ ?>
            <li><a href="<?php echo esc_url( $instagram ); ?>" target="_blank" title="<?php esc_attr_e( 'Instagram', 'numinous' );?>"><i class="fa fa-instagram"></i></a></li>
		<?php } if( $youtube ){ ?>
            <li><a href="<?php echo esc_url( $youtube ); ?>" target="_blank" title="<?php esc_attr_e( 'YouTube', 'numinous' );?>"><i class="fa fa-youtube"></i></a></li>
        <?php } if( $ok ){?>
            <li><a href="<?php echo esc_url( $ok );?>" target="_blank" title="<?php esc_attr_e( 'OK', 'numinous' ); ?>"><i class="fa fa-odnoklassniki"></i></a></li>
		<?php } if( $vk ){?>
            <li><a href="<?php echo esc_url( $vk );?>" target="_blank" title="<?php esc_attr_e( 'VK', 'numinous' ); ?>"><i class="fa fa-vk"></i></a></li>
		<?php } if( $xing ){?>
            <li><a href="<?php echo esc_url( $xing );?>" target="_blank" title="<?php esc_attr_e( 'Xing', 'numinous' ); ?>"><i class="fa fa-xing"></i></a></li>
        <?php } if( $tiktok ){?>
            <li><a href="<?php echo esc_url( $tiktok );?>" target="_blank" title="<?php esc_attr_e( 'Tiktok', 'numinous' ); ?>"><i class="fab fa-tiktok"></i></a></li>
        <?php } ?>
	</ul>
    <?php
    }
}
endif;

/**
 * Query WooCommerce activation
 */
function numinous_is_woocommerce_activated() {
	return class_exists( 'woocommerce' ) ? true : false;
}

if( ! function_exists( 'numinous_escape_text_tags' ) ) :
/**
 * Remove new line tags from string
 *
 * @param $text
 * @return string
 */
function numinous_escape_text_tags( $text ) {
    return (string) str_replace( array( "\r", "\n" ), '', strip_tags( $text ) );
}
endif;

if( ! function_exists( 'wp_body_open' ) ) :
/**
 * Fire the wp_body_open action.
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
*/
function wp_body_open() {
	/**
	 * Triggered after the opening <body> tag.
    */
	do_action( 'wp_body_open' );
}
endif;

if( ! function_exists( 'numinous_get_image_sizes' ) ) :
/**
 * Get information about available image sizes
 */
function numinous_get_image_sizes( $size = '' ) {
 
    global $_wp_additional_image_sizes;
 
    $sizes = array();
    $get_intermediate_image_sizes = get_intermediate_image_sizes();
 
    // Create the full array with sizes and crop info
    foreach( $get_intermediate_image_sizes as $_size ) {
        if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array( 
                'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
            );
        }
    } 
    // Get only 1 size if found
    if ( $size ) {
        if( isset( $sizes[ $size ] ) ) {
            return $sizes[ $size ];
        } else {
            return false;
        }
    }
    return $sizes;
}
endif;

if ( ! function_exists( 'numinous_get_fallback_svg' ) ) :    
/**
 * Get Fallback SVG
*/
function numinous_get_fallback_svg( $post_thumbnail ) {
    if( ! $post_thumbnail ){
        return;
    }
    
    $image_size = numinous_get_image_sizes( $post_thumbnail );
     
    if( $image_size ){ ?>
        <div class="svg-holder">
             <svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr( $image_size['width'] ); ?> <?php echo esc_attr( $image_size['height'] ); ?>" preserveAspectRatio="none">
                    <rect width="<?php echo esc_attr( $image_size['width'] ); ?>" height="<?php echo esc_attr( $image_size['height'] ); ?>" style="fill:#dedede;"></rect>
            </svg>
        </div>
        <?php
    }
}
endif;

if( ! function_exists( 'numinous_fonts_url' ) ) :
/**
 * Register custom fonts.
 */
function numinous_fonts_url() {
    $fonts_url = '';

    /*
    * translators: If there are characters in your language that are not supported
    * by Roboto, translate this to 'off'. Do not translate into your own language.
    */
    $roboto = _x( 'on', 'Roboto font: on or off', 'numinous' );

    if ( 'off' !== $roboto ) {
        $font_families = array();

        $font_families[] = 'Roboto:400,700';

        $query_args = array(
            'family'  => urlencode( implode( '|', $font_families ) ),
            'display' => urlencode( 'fallback' ),
        );

        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }

    return esc_url( $fonts_url );
}
endif;

if( ! function_exists( 'numinous_load_preload_local_fonts') ) :
/**
 * Get the file preloads.
 *
 * @param string $url    The URL of the remote webfont.
 * @param string $format The font-format. If you need to support IE, change this to "woff".
 */
function numinous_load_preload_local_fonts( $url, $format = 'woff2' ) {

    // Check if cached font files data preset present or not. Basically avoiding 'numinous_WebFont_Loader' class rendering.
    $local_font_files = get_site_option( 'numinous_local_font_files', false );

    if ( is_array( $local_font_files ) && ! empty( $local_font_files ) ) {
        $font_format = apply_filters( 'numinous_local_google_fonts_format', $format );
        foreach ( $local_font_files as $key => $local_font ) {
            if ( $local_font ) {
                echo '<link rel="preload" href="' . esc_url( $local_font ) . '" as="font" type="font/' . esc_attr( $font_format ) . '" crossorigin>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }	
        }
        return;
    }

    // Now preload font data after processing it, as we didn't get stored data.
    $font = numinous_webfont_loader_instance( $url );
    $font->set_font_format( $format );
    $font->preload_local_fonts();
}
endif;

if( ! function_exists( 'numinous_flush_local_google_fonts' ) ){
    /**
     * Ajax Callback for flushing the local font
     */
    function numinous_flush_local_google_fonts() {
        $WebFontLoader = new Numinous_WebFont_Loader();
        //deleting the fonts folder using ajax
        $WebFontLoader->delete_fonts_folder();
        die();
    }
}
add_action( 'wp_ajax_flush_local_google_fonts', 'numinous_flush_local_google_fonts' );
add_action( 'wp_ajax_nopriv_flush_local_google_fonts', 'numinous_flush_local_google_fonts' );