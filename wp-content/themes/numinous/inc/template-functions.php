<?php
/**
 * Custom template function for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Numinous
 */

if( ! function_exists( 'numinous_doctype_cb' ) ) :
/**
 * Doctype Declaration
 * 
 * @since 1.0.1
*/
function numinous_doctype_cb(){
    ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <?php
}
endif;
add_action( 'numinous_doctype', 'numinous_doctype_cb' );

if( ! function_exists( 'numinous_head' ) ) :
/**
 * Before wp_head
 * 
 * @since 1.0.1
*/
function numinous_head(){
    ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php
}
endif;
add_action( 'numinous_before_wp_head', 'numinous_head' );

if( ! function_exists( 'numinous_page_start' ) ) :
/**
 * Page Start
 * 
 * @since 1.0.1
*/
function numinous_page_start(){
    ?>
    <div id="page" class="site">
         <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content (Press Enter)', 'numinous' ); ?></a>
    <?php
}
endif;
add_action( 'numinous_before_header', 'numinous_page_start', 20 );

if( ! function_exists( 'numinous_top_header' ) ) :
/**
 * Top Header
 * 
 * @since 1.0.1
*/
function numinous_top_header(){    
    if( get_theme_mod( 'numinous_breaking_news_cat' ) || get_theme_mod( 'numinous_ed_social' ) ){?>
        <section class="page-top">
    		<div class="container">    			
                <?php
                    /**
                     * Top Header
                     * 
                     * @hooked numinous_breaking_news - 20
                     * @hooked numinous_social_icon   - 30
                    */
                    do_action( 'numinous_top_header' );
                ?>                
    		</div>
    	</section>
    <?php
    }
}
endif;
add_action( 'numinous_before_header', 'numinous_top_header', 30 );

if( ! function_exists( 'numinous_breaking_news' ) ) :
/**
 * Breaking News
 * 
 * @since 1.0.1
*/
function numinous_breaking_news(){    
    $breaking_news_cat   = get_theme_mod( 'numinous_breaking_news_cat' ); //from customizer
    $breaking_news_label = get_theme_mod( 'numinous_breaking_news_label', __( 'Breaking News', 'numinous' ) ); //from customizer
    
    if( $breaking_news_label ){
        $label = $breaking_news_label;
    }else{
        $cat   = get_category( $breaking_news_cat );
        $label = $cat->name;
    }
    
    if( $breaking_news_cat ){
        $args = array(
            'post_type'           => 'post', 
            'cat'                 => $breaking_news_cat,
            'post_status'         => 'publish',
            'posts_per_page'      => -1,
            'ignore_sticky_posts' => true 
        );
        $breaking_qry = new WP_Query( $args );
        
        if( $breaking_qry->have_posts() ){
        ?>
            <a href="<?php echo esc_url( get_category_link( $breaking_news_cat ) ); ?>" class="breaking-news-link"><?php echo esc_html( $label ); ?></a>
            <div class="newsticker-wrapper">
                <ul id="news-ticker">
                <?php 
                    while( $breaking_qry->have_posts() ){
                        $breaking_qry->the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
                    <?php
                    } 
                    wp_reset_postdata();   
                ?>
                </ul>
            </div>
        <?php
        }        
    }
}
endif;
add_action( 'numinous_top_header', 'numinous_breaking_news', 20  );

if( ! function_exists( 'numinous_social_icon' ) ) :
/**
 * Social Links in Header
*/
function numinous_social_icon(){
    if( get_theme_mod( 'numinous_ed_social' ) ) numinous_get_social_links();    
}
endif;
add_action( 'numinous_top_header', 'numinous_social_icon', 30  );

if( ! function_exists( 'numinous_header_start' ) ) :
/**
 * Header Start
 * 
 * @since 1.0.1
*/
function numinous_header_start(){
    ?>
    <header id="masthead" class="site-header" role="banner" itemscope itemtype="https://schema.org/WPHeader">
    <?php 
}
endif;
add_action( 'numinous_header', 'numinous_header_start', 20 );

if( ! function_exists( 'numinous_header_top' ) ) :
/**
 * Header Top
 * 
 * @since 1.0.1
*/
function numinous_header_top(){
    $ed_header_ad = get_theme_mod( 'numinous_ed_header_ad' ); //from customizer
    $ad_img       = get_theme_mod( 'numinous_header_ad' ); //from customizer
    $ad_link      = get_theme_mod( 'numinous_header_ad_link' ); //from customizer
    $ad_image     = wp_get_attachment_image_src( $ad_img, 'full' );
    $target       = get_theme_mod( 'numinous_open_link_diff_tab', '1' ) ? 'target="_blank"' : ''
    ?>
    <div class="header-t">
		<div class="container">
			
            <div class="site-branding" itemscope itemtype="https://schema.org/Organization">
                <?php 
			        if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                        the_custom_logo();
                    } 
                ?>
				<?php if ( is_front_page() ) : ?>
                    <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
                <?php else : ?>
                    <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
                <?php endif;
    			$description = get_bloginfo( 'description', 'display' );
    			if ( $description || is_customize_preview() ) : ?>
    				<p class="site-description" itemprop="description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
    			<?php
    			endif; ?>
            </div><!-- .site-branding -->
            
            <?php if( $ed_header_ad && $ad_img ){ ?>
            <div class="ad">
				<?php if( $ad_link ) echo '<a href="' . esc_url( $ad_link ) . '" ' . $target . '>'; ?>
                    <img src="<?php echo esc_url( $ad_image[0] ); ?>"  />
                <?php if( $ad_link ) echo '</a>'; ?>
			</div>
            <?php } ?>
		</div>
	</div>
    <?php
}
endif;
add_action( 'numinous_header', 'numinous_header_top', 30 );

if( ! function_exists( 'numinous_header_bottom' ) ) :
/**
 * Header Bottom
 * 
 * @since 1.0.1
*/
function numinous_header_bottom(){
    
    $ed_search_form = get_theme_mod( 'numinous_ed_search_form', '1' );
    ?>
    <div class="header-b">
		<div class="container">
			<button id="mobile-header" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".close-main-nav-toggle">
		    	<span></span>
                <span></span>
                <span></span>
			</button>

            <div class="mobile-menu-wrapper">
                <nav id="mobile-site-navigation" class="main-navigation mobile-navigation">        
                    <div class="primary-menu-list main-menu-modal cover-modal" data-modal-target-string=".main-menu-modal">
                        <button class="close close-main-nav-toggle" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".main-menu-modal"></button>
                        <div class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'numinous' ); ?>">
                            <?php
                                wp_nav_menu( array(
                                    'theme_location' => 'primary',
                                    'menu_id'        => 'mobile-primary-menu',
                                    'menu_class'     => 'nav-menu main-menu-modal',
                                ) );
                            ?>
                        </div>
                    </div>
                </nav><!-- #mobile-site-navigation -->
            </div>

			<nav id="site-navigation" class="main-navigation" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
			</nav>
            
            <?php if( $ed_search_form ){ ?>
                <div class="form-section">
                    <button id="search-btn" class="search-btn" data-toggle-target=".header-search-modal" data-toggle-body-class="showing-search-modal" aria-expanded="false" data-set-focus=".header-search-modal .search-field">
                        <i class="fa fa-search"></i>
                    </button>

                    <div class="form-holder search header-searh-wrap header-search-modal cover-modal" data-modal-target-string=".header-search-modal">
                        <div>
                            <?php get_search_form(); ?>
                            <button class="btn-form-close" data-toggle-target=".header-search-modal" data-toggle-body-class="showing-search-modal" aria-expanded="false" data-set-focus=".header-search-modal"></button>
                        </div>
                    </div>
                </div><!-- .form-section --><!-- 

			<div class="form-section">
				<a href="javascript:void(0);" id="search-btn"><i class="fa fa-search"></i></a>
				<div class="example">
                <?php //get_search_form(); ?>
                </div>
			</div> -->
            <?php } ?>
		</div>
	</div>
    <?php
}
endif;
add_action( 'numinous_header', 'numinous_header_bottom', 40 );

if( ! function_exists( 'numinous_header_end' ) ) :
/**
 * Header End
 * 
 * @since 1.0.1
*/
function numinous_header_end(){
    ?>
    </header>
    <?php
}
endif;
add_action( 'numinous_header', 'numinous_header_end', 100 );

if( ! function_exists( 'numinous_featured_section' ) ) :
/**
 * Featured Section
 * 
 * @since 1.0.1
*/
function numinous_featured_section(){
    
    $featured_post_one        = get_theme_mod( 'numinous_featured_post_one' ); // from customizer
    $featured_post_two        = get_theme_mod( 'numinous_featured_post_two' ); // from customizer
    $featured_post_three      = get_theme_mod( 'numinous_featured_post_three' ); // from customizer
    $featured_post_four       = get_theme_mod( 'numinous_featured_post_four' ); // from customizer
    $featured_post_five       = get_theme_mod( 'numinous_featured_post_five' ); // from customizer    
    $ed_featured_post_home    = get_theme_mod( 'numinous_ed_featured_post_section_home' ); // from customizer
    $ed_featured_post_archive = get_theme_mod( 'numinous_ed_featured_post_section_archive' ); // from customizer
    
    $featured_posts = array( $featured_post_two, $featured_post_three, $featured_post_four, $featured_post_five );
    $featured_posts = array_diff( array_unique( $featured_posts ), array('') );
    
    if( $featured_post_one && $featured_posts && ( ( is_page_template( 'template-home.php' ) && $ed_featured_post_home ) || ( is_front_page() && !is_home() && $ed_featured_post_home ) || ( is_archive() && $ed_featured_post_archive ) ) ){
    ?>
    <!-- These section are for home page only -->
    <section class="featured-category">
		<?php 
        if( $featured_post_one ){ 
            $featured_qry = new WP_Query( "p=$featured_post_one" );  
            if( $featured_qry->have_posts() ){
                while( $featured_qry->have_posts() ){
                    $featured_qry->the_post();
                    ?>
                    <div class="col-1 single">
                        <div class="image-holder">
            				<a href="<?php the_permalink(); ?>">
                                <?php 
                                if( has_post_thumbnail() ){
                                    the_post_thumbnail( 'numinous-featured-big', array( 'itemprop' => 'image' ) );
                                }else{
                                    numinous_get_fallback_svg( 'numinous-featured-big' );
                                } ?>
                            </a>
            				<div class="text-holder">
            					<?php numinous_colored_category(); ?>
            					<header class="entry-header">
            						<h2 class="entry-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
            						<div class="entry-meta">
            							<span><?php echo esc_html( sprintf( _x( '%s ago', '%s = human-readable time difference', 'numinous' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ) ); ?></span>
            						</div>
            					</header>
            				</div>
            			</div>
            		</div>
                    <?php
                }
                wp_reset_postdata();
            }            
        } 
        ?>
        
        <?php 
        if( $featured_posts ){
            $args = array(
                'post_type'           => 'post',
                'posts_per_page'      => -1,
                'post_status'         => 'publish',
                'post__in'            => $featured_posts,
                'orderby'             => 'post__in',
                'ignore_sticky_posts' => true
            );
            
            $feature_qry = new WP_Query( $args );
            if( $feature_qry->have_posts() ){
                ?>
                <div class="col-1">
                    <ul>
                    <?php
                    while( $feature_qry->have_posts() ){
                        $feature_qry->the_post();
                        ?>
                        <li>
        					<div class="image-holder">
        						<a href="<?php the_permalink(); ?>">
                                    <?php 
                                    if( has_post_thumbnail() ){
                                        the_post_thumbnail( 'numinous-featured-img', array( 'itemprop' => 'image' ) );
                                    }else{
                                        numinous_get_fallback_svg( 'numinous-featured-img' );
                                    } ?>
                                </a>
        						<div class="text-holder">
        							<?php numinous_colored_category(); ?>
        							<header class="entry-header">
        								<h2 class="entry-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
        								<div class="entry-meta">
        									<span><?php echo esc_html( sprintf( _x( '%s ago', '%s = human-readable time difference', 'numinous' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ) ); ?></span>
        								</div>
        							</header>
        						</div>
        					</div>
        				</li>
                        <?php
                    }
                    wp_reset_postdata();
                    ?>
                    </ul>
                </div>
            <?php
            }
            
        }
        ?>
	</section>
    <!-- These section are for home page only -->
    <?php
    }
}
endif;
add_action( 'numinous_after_header', 'numinous_featured_section', 20 );

if( ! function_exists( 'numinous_top_news_section' ) ) :
/**
 * Top News Section
 * 
 * @since 1.0.1
*/
function numinous_top_news_section(){
    $top_news_title = get_theme_mod( 'numinous_top_news_label', __( 'Top News', 'numinous' ) ); //from customizer
    $top_news_one   = get_theme_mod( 'numinous_top_news_one' ); //from customizer
    $top_news_two   = get_theme_mod( 'numinous_top_news_two' ); //from customizer
    $top_news_three = get_theme_mod( 'numinous_top_news_three' ); //from customizer
    $top_news_four  = get_theme_mod( 'numinous_top_news_four' ); //from customizer
    $ed_topnews_sec = get_theme_mod( 'numinous_ed_top_news_section' ); //from customizer
    
    $top_news_posts = array( $top_news_two, $top_news_three, $top_news_four );
    $top_news_posts = array_diff( array_unique( $top_news_posts ), array('') );
    
    if( $ed_topnews_sec && $top_news_one && $top_news_posts && ( is_page_template( 'template-home.php' ) || ( is_front_page() && !is_home() ) ) ){        
    ?>
    <section class="top-news">
		<div class="container">
			
            <?php if( $top_news_title ){ ?>
            <h2 class="section-title"><?php echo esc_html( $top_news_title ); ?></h2>
			<?php } ?>
            
            <div class="row">
				<?php
                if( $top_news_one ){
                    $top_news_qry = new WP_Query( "p=$top_news_one" );
                    if( $top_news_qry->have_posts() ){
                        while( $top_news_qry->have_posts() ){
                            $top_news_qry->the_post();
                            ?>
                            <div class="col-1">
            					<article class="post">
            						<div class="image-holder">
            							<a href="<?php the_permalink(); ?>" class="post-thumbnail">
                                            <?php 
                                            if ( has_post_thumbnail() ) {
                                                the_post_thumbnail( 'numinous-top-news', array( 'itemprop' => 'image' ) );
                                            }else{
                                                numinous_get_fallback_svg( 'numinous-top-news' );
                                            } ?>                                                
                                        </a>
            							<?php numinous_colored_category(); ?>
            						</div>
                                    
            						<header class="entry-header">
            							<h3 class="entry-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
            						</header>
            						
                                    <?php numinous_meta( true, false, true );?>
                                    
            					</article>
            				</div>
                            <?php
                        }
                        wp_reset_postdata();
                    }                    
                }
                ?>
                
				<?php
                if( $top_news_posts ){
                    $args = array(
                        'post_type'           => 'post',
                        'posts_per_page'      => -1,
                        'post_status'         => 'publish',
                        'post__in'            => $top_news_posts,
                        'orderby'             => 'post__in',
                        'ignore_sticky_posts' => true
                    );
                    
                    $news_qry = new WP_Query( $args );
                    
                    if( $news_qry->have_posts() ){
                    ?>
                        <div class="col-1 lists">
					       <ul>
                            <?php
                            while( $news_qry->have_posts() ){
                                $news_qry->the_post();
                                ?>
                                <li>
        							<article class="post">
        								<a href="<?php the_permalink(); ?>" class="post-thumbnail">
                                            <?php 
                                            if ( has_post_thumbnail() ) {
                                                the_post_thumbnail( 'numinous-more-news', array( 'itemprop' => 'image' ) ); 
                                            }else{
                                                numinous_get_fallback_svg( 'numinous-more-news' );
                                            } ?>
                                        </a>
        								<div class="right-text">
        									<?php numinous_colored_category(); ?>
        									
                                            <header class="entry-header">
        										<h3 class="entry-title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h3>
        									</header>
        									
                                            <div class="entry-content">
        										<?php the_excerpt(); ?>
        									</div>
        									
                                            <?php numinous_meta( true, false, true );?>
                                            
        								</div>
        							</article>
        						</li>
                                <?php
                            }
                            wp_reset_postdata();
                            ?>
                            </ul>
				        </div>
                    <?php
                    }                     
                }
                ?>
			</div>
		</div>
	</section><!-- These section are for home page only -->
    <?php
    }
}
endif;
add_action( 'numinous_after_header', 'numinous_top_news_section', 30 );

if( ! function_exists( 'numinous_page_header' ) ) :
/**
 * Page Header for inner pages
 * 
 * @since 1.0.1
*/
function numinous_page_header(){    
    if( ! is_front_page() && ! is_page_template( 'template-home.php' ) ){
    ?>
    <!-- Page Header for inner pages only -->
    <div class="page-header">
		<div class="container">
			<?php
            
            if( is_home() ) {
                echo '<h1 class="page-title" itemprop="headline">';
                single_post_title();
                echo '</h1>'; 
            }
            
            if( is_singular() ) the_title( '<h1 class="page-title" itemprop="headline">', '</h1>' ); //For Page, Post & Attachment
            
            if( is_search() ){ //For Search ?>            
        		<h1 class="page-title" itemprop="headline">
                    <?php printf( esc_html__( 'Search Results for %s', 'numinous' ), get_search_query() ); ?>
        		</h1>
            <?php
            }
            
            if( is_404() ) echo '<h1 class="page-title" itemprop="headline">' . esc_html__( '404 Error - Page not Found', 'numinous' ) . '</h1>'; //For 404
            
            /**
             * Breadcrumb
             * 
             * @hooked numinous_breadcrumb
            */
            do_action( 'numinous_breadcrumb' );
            ?>
		</div>
	</div>
    <?php
    }
}
endif;
add_action( 'numinous_before_content', 'numinous_page_header', 20 );

if( ! function_exists( 'numinous_breadcrumb' ) ) :
/**
 * Numinous Breadcrumb
*/
function numinous_breadcrumb() {    
    global $post;
    
    $post_page   = get_option( 'page_for_posts' ); //The ID of the page that displays posts.
    $show_front  = get_option( 'show_on_front' ); //What to show on the front page
    $showCurrent = get_theme_mod( 'numinous_ed_current', '1' ); // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $delimiter   = get_theme_mod( 'numinous_breadcrumb_separator', __( '>', 'numinous' ) ); // delimiter between crumbs
    $home        = get_theme_mod( 'numinous_breadcrumb_home_text', __( 'Home', 'numinous' ) ); // text for the 'Home' link
    $before      = '<span class="current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">'; // tag before the current crumb
    $after       = '</span>'; // tag after the current crumb
      
    $depth = 1; 
    if( get_theme_mod( 'numinous_ed_breadcrumb' ) ){   
        echo '<div id="crumbs" itemscope itemtype="https://schema.org/BreadcrumbList"><span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . esc_url( home_url() ) . '" class="home_crumb"><span itemprop="name">' . esc_html( $home ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
            if( is_home() && ! is_front_page() ){            
                $depth = 2;
                if( $showCurrent ) echo $before . '<span itemprop="name">' . esc_html( single_post_title( '', false ) ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;          
            }elseif( is_category() ){            
                $depth = 2;
                $thisCat = get_category( get_query_var( 'cat' ), false );
                if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                    $p = get_post( $post_page );
                    echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_permalink( $post_page ) ) . '"><span itemprop="name">' . esc_html( $p->post_title ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                    $depth ++;  
                }

                if ( $thisCat->parent != 0 ) {
                    $parent_categories = get_category_parents( $thisCat->parent, false, ',' );
                    $parent_categories = explode( ',', $parent_categories );

                    foreach ( $parent_categories as $parent_term ) {
                        $parent_obj = get_term_by( 'name', $parent_term, 'category' );
                        if( is_object( $parent_obj ) ){
                            $term_url    = get_term_link( $parent_obj->term_id );
                            $term_name   = $parent_obj->name;
                            echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                            $depth ++;
                        }
                    }
                }

                if( $showCurrent ) echo $before . '<span itemprop="name">' .  esc_html( single_cat_title( '', false ) ) . '</span><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;

            }elseif( is_tag() ){            
                $queried_object = get_queried_object();
                $depth = 2;

                if( $showCurrent ) echo $before . '<span itemprop="name">' . esc_html( single_tag_title( '', false ) ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;    
            }elseif( is_author() ){            
                $depth = 2;
                global $author;
                $userdata = get_userdata( $author );
                if( $showCurrent ) echo $before . '<span itemprop="name">' . esc_html( $userdata->display_name ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;  
            }elseif( is_day() ){            
                $depth = 2;
                echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'numinous' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'numinous' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                $depth ++;
                echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'numinous' ) ), get_the_time( __( 'm', 'numinous' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'F', 'numinous' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                $depth ++;
                if( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_time( __( 'd', 'numinous' ) ) ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
                 
            }elseif( is_month() ){            
                $depth = 2;
                echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'numinous' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'numinous' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                $depth++;
                if( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_time( __( 'F', 'numinous' ) ) ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;      
            }elseif( is_year() ){            
                $depth = 2;
                if( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_time( __( 'Y', 'numinous' ) ) ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after; 
            }elseif( is_single() && !is_attachment() ) {
                //For Woocommerce single product            
                if( numinous_is_woocommerce_activated() && 'product' === get_post_type() ){ 
                    if ( wc_get_page_id( 'shop' ) ) { 
                        //Displaying Shop link in woocommerce archive page
                        $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                        if ( ! $_name ) {
                            $product_post_type = get_post_type_object( 'product' );
                            $_name = $product_post_type->labels->singular_name;
                        }
                        echo ' <a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $_name) . '</span></a> ' . '<span class="separator">' . $delimiter . '</span>';
                    }
                
                    if ( $terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ) {
                        $main_term = apply_filters( 'woocommerce_breadcrumb_main_term', $terms[0], $terms );
                        $ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
                        $ancestors = array_reverse( $ancestors );

                        foreach ( $ancestors as $ancestor ) {
                            $ancestor = get_term( $ancestor, 'product_cat' );    
                            if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                                echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="' . esc_url( get_term_link( $ancestor ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $ancestor->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                                $depth++;
                            }
                        }
                        echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="' . esc_url( get_term_link( $main_term ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $main_term->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                    }
                
                    if( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_title() ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
                                   
                }else{ 
                    //For Post                
                    $cat_object       = get_the_category();
                    $potential_parent = 0;
                    $depth            = 2;
                    
                    if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                        $p = get_post( $post_page );
                        echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="' . esc_url( get_permalink( $post_page ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $p->post_title ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';  
                        $depth++;
                    }
                    
                    if( is_array( $cat_object ) ){ //Getting category hierarchy if any
            
                        //Now try to find the deepest term of those that we know of
                        $use_term = key( $cat_object );
                        foreach( $cat_object as $key => $object ){
                            //Can't use the next($cat_object) trick since order is unknown
                            if( $object->parent > 0  && ( $potential_parent === 0 || $object->parent === $potential_parent ) ){
                                $use_term = $key;
                                $potential_parent = $object->term_id;
                            }
                        }
                        
                        $cat = $cat_object[$use_term];
                  
                        $cats = get_category_parents( $cat, false, ',' );
                        $cats = explode( ',', $cats );

                        foreach ( $cats as $cat ) {
                            $cat_obj = get_term_by( 'name', $cat, 'category' );
                            if( is_object( $cat_obj ) ){
                                $term_url    = get_term_link( $cat_obj->term_id );
                                $term_name   = $cat_obj->name;
                                echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                                $depth ++;
                            }
                        }
                    }
        
                    if ( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_title() ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
                                 
                }        
            }elseif( is_page() ){            
                $depth = 2;
                if( $post->post_parent ){            
                    global $post;
                    $depth = 2;
                    $parent_id  = $post->post_parent;
                    $breadcrumbs = array();
                    
                    while( $parent_id ){
                        $current_page  = get_post( $parent_id );
                        $breadcrumbs[] = $current_page->ID;
                        $parent_id     = $current_page->post_parent;
                    }
                    $breadcrumbs = array_reverse( $breadcrumbs );
                    for ( $i = 0; $i < count( $breadcrumbs); $i++ ){
                        echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="' . esc_url( get_permalink( $breadcrumbs[$i] ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $breadcrumbs[$i] ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /></span>';
                        if ( $i != count( $breadcrumbs ) - 1 ) echo ' <span class="separator">' . esc_html( $delimiter ) . '</span> ';
                        $depth++;
                    }

                    if ( $showCurrent ) echo ' <span class="separator">' . esc_html( $delimiter ) . '</span> ' . $before .'<span itemprop="name">'. esc_html( get_the_title() ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" /></span>'. $after;      
                }else{
                    if ( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_title() ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after; 
                }
            }elseif( is_search() ){            
                $depth = 2;
                if( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html__( 'Search Results for "', 'numinous' ) . esc_html( get_search_query() ) . esc_html__( '"', 'numinous' ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;      
            }elseif( numinous_is_woocommerce_activated() && ( is_product_category() || is_product_tag() ) ){ 
                //For Woocommerce archive page        
                $depth = 2;
                if ( wc_get_page_id( 'shop' ) ) { 
                    //Displaying Shop link in woocommerce archive page
                    $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                    if ( ! $_name ) {
                        $product_post_type = get_post_type_object( 'product' );
                        $_name = $product_post_type->labels->singular_name;
                    }
                    echo ' <a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $_name) . '</span></a> ' . '<span class="separator">' . $delimiter . '</span>';
                }
                $current_term = $GLOBALS['wp_query']->get_queried_object();
                if( is_product_category() ){
                    $ancestors = get_ancestors( $current_term->term_id, 'product_cat' );
                    $ancestors = array_reverse( $ancestors );
                    foreach ( $ancestors as $ancestor ) {
                        $ancestor = get_term( $ancestor, 'product_cat' );    
                        if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                            echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="' . esc_url( get_term_link( $ancestor ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $ancestor->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                            $depth ++;
                        }
                    }
                }           
                if( $showCurrent ) echo $before . '<span itemprop="name">' . esc_html( $current_term->name ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;           
            }elseif( numinous_is_woocommerce_activated() && is_shop() ){ //Shop Archive page
                $depth = 2;
                if ( get_option( 'page_on_front' ) == wc_get_page_id( 'shop' ) ) {
                    return;
                }
                $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                $shop_url = wc_get_page_id( 'shop' ) && wc_get_page_id( 'shop' ) > 0  ? get_the_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop' );
        
                if ( ! $_name ) {
                    $product_post_type = get_post_type_object( 'product' );
                    $_name = $product_post_type->labels->singular_name;
                }
                if( $showCurrent ) echo $before . '<span itemprop="name">' . esc_html( $_name ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;                    
            }elseif( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {            
                $depth = 2;
                $post_type = get_post_type_object(get_post_type());
                if( get_query_var('paged') ){
                    echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $post_type->label ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />';
                    echo ' <span class="separator">' . $delimiter . '</span></span> ' . $before . sprintf( __('Page %s', 'numinous'), get_query_var('paged') ) . $after;
                }elseif( is_archive() ){
                    echo $before .'<a itemprop="item" href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '"><span itemprop="name">'. esc_html( $post_type->label ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
                }else{
                    echo $before .'<a itemprop="item" href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '"><span itemprop="name">'. esc_html( $post_type->label ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
                }              
            }elseif( is_attachment() ){            
                $depth  = 2;
                $parent = get_post( $post->post_parent );
                $cat    = get_the_category( $parent->ID );
                if( $cat ){
                    $cat = $cat[0];
                    echo get_category_parents( $cat, TRUE, ' <span class="separator">' . $delimiter . '</span> ');
                    echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="' . esc_url( get_permalink( $parent ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $parent->post_title ) . '<span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . ' <span class="separator">' . $delimiter . '</span></span>';
                }
                if( $showCurrent ) echo $before .'<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">'. esc_html( get_the_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;   
            }elseif ( is_404() ){
                if( $showCurrent ) echo $before . esc_html__( '404 Error - Page not Found', 'numinous' ) . $after;
            }
            if( get_query_var('paged') ) echo __( ' (Page', 'numinous' ) . ' ' . get_query_var('paged') . __( ')', 'numinous' );        
            echo '</div>';
    }
}
endif;
add_action( 'numinous_breadcrumb', 'numinous_breadcrumb' );

if( ! function_exists( 'numinous_content_start' ) ) :
/**
 * Content Start
 * 
 * @since 1.0.1
*/
function numinous_content_start(){
    $class = is_404() ? 'not-found' : 'row' ;
    ?>
    <div id="content" class="site-content">
        <div class="container">
            <div class="<?php echo esc_attr( $class ); ?>">
    <?php
}
endif;
add_action( 'numinous_content', 'numinous_content_start' );

if( ! function_exists( 'numinous_page_content_image' ) ) :
/**
 * Page Featured Image
 * 
 * @since 1.0.1
*/
function numinous_page_content_image(){
    $sidebar_layout = numinous_sidebar_layout();
    if( has_post_thumbnail() )
    ( is_active_sidebar( 'right-sidebar' ) && ( $sidebar_layout == 'right-sidebar' ) ) ? the_post_thumbnail( 'numinous-with-sidebar', array( 'itemprop' => 'image' ) ) : the_post_thumbnail( 'numinous-without-sidebar', array( 'itemprop' => 'image' ) );    
}
endif;
add_action( 'numinous_before_page_entry_content', 'numinous_page_content_image' );

if( ! function_exists( 'numinous_post_content_image' ) ) :
/**
 * Post Featured Image
 * 
 * @since 1.0.1
*/
function numinous_post_content_image(){    
    if( is_archive() ){
        echo '<a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';
            if( has_post_thumbnail() ){
                the_post_thumbnail( 'numinous-more-news', array( 'itemprop' => 'image' ) );  
            }else{
                numinous_get_fallback_svg( 'numinous-more-news' );
            } 
        echo '</a>';
    }else{
        if( ! is_single() && has_post_thumbnail() ) echo '<a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';
            is_active_sidebar( 'right-sidebar' ) ? the_post_thumbnail( 'numinous-with-sidebar', array( 'itemprop' => 'image' ) ) : the_post_thumbnail( 'numinous-without-sidebar', array( 'itemprop' => 'image' ) ); 
        if( ! is_single() && has_post_thumbnail() ) echo '</a>';       
    }            
}
endif;
add_action( 'numinous_before_post_entry_content', 'numinous_post_content_image', 10 );
add_action( 'numinous_before_search_entry_summary', 'numinous_post_content_image', 10 );
add_action( 'numinous_before_archive_entry_content', 'numinous_post_content_image', 10 );

if( ! function_exists( 'numinous_post_entry_header' ) ) :
/**
 * Post Entry Header
 * 
 * @since 1.0.1
*/
function numinous_post_entry_header(){ ?>
    <header class="entry-header">
		<?php
            if( ! is_single() ) the_title( '<h2 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            
            if ( 'post' === get_post_type() ){ 
                is_archive() ? numinous_meta( true, true ) : numinous_meta( true, true, true ); 
            } 
        ?>
	</header><!-- .entry-header -->
    <?php
}
endif;
add_action( 'numinous_before_post_entry_content', 'numinous_post_entry_header', 20 );
add_action( 'numinous_before_search_entry_summary', 'numinous_post_entry_header', 20 );
add_action( 'numinous_before_archive_entry_content', 'numinous_post_entry_header', 20 );

if( ! function_exists( 'numinous_post_author' ) ) :
/**
 * Author Bio
 * 
 * @since 1.0.1
*/
function numinous_post_author(){
    if( get_the_author_meta( 'description' ) ){
    ?>
    <div class="author-section">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 105 ); ?>
        <div class="text">
			<span class="name"><?php esc_html_e( 'About Admin', 'numinous' ); ?></span>
			<?php echo wpautop( esc_html( get_the_author_meta( 'description' ) ) ); ?>
		</div>
	</div>
    <?php  
    }  
}
endif;
add_action( 'numinous_after_post_content', 'numinous_post_author', 10 );

if( ! function_exists( 'numinous_related_post' ) ) :
/**
 * Similar/related post
 * 
 * @since 1.0.1
*/
function numinous_related_post(){
    global $post;
    
    $related_post_tax = get_theme_mod( 'numinous_related_taxonomy', 'cat' ); // from customizer
 
    $args = array(
        'post_type'             => 'post',
        'post_status'           => 'publish',
        'posts_per_page'        => 3,
        'ignore_sticky_posts'   => true,
        'post__not_in'          => array( $post->ID ),
        'orderby'               => 'rand'
    );
    
    if( $related_post_tax == 'cat' ){
       $cats = get_the_category( $post->ID );
        if( $cats ){
            $c = array();
            foreach( $cats as $cat ){
                $c[] = $cat->term_id; 
            }
            $args['category__in'] = $c;
            
            $qry = new WP_Query( $args );
            
            if( $qry->have_posts() ){
            ?>
            <section class="similar-posts">
        		<h5><?php esc_html_e( 'Similar Posts', 'numinous' ); ?></h5>
        		<div class="row">
                <?php 
                while( $qry->have_posts() ){
                    $qry->the_post();
                    ?>
        			<article class="post">
        				<a href="<?php the_permalink(); ?>" class="post-thumbnail">
                            <?php 
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'numinous-related-post', array( 'itemprop' => 'image' ) ); 
                            }else{
                                numinous_get_fallback_svg( 'numinous-related-post' );
                            } ?>
                        </a>
        				<header class="entry-header">
        					<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        					<?php numinous_meta( true, true );?>                            
        				</header>
        			</article>
                    <?php
                }
                wp_reset_postdata();                
                ?>
        		</div>
        	</section>
            <?php
            }
        }
    }elseif( $related_post_tax == 'tag' ){
        $tags = get_the_tags( $post->ID );
        if( $tags ){
            $t = array();
            foreach( $tags as $tag ){
                $t[] = $tag->term_id;
            }
            $args['tag__in'] = $t;    
        
            $qry = new WP_Query( $args );
            
            if( $qry->have_posts() ){
            ?>
            <section class="similar-posts">
        		<h5><?php esc_html_e( 'Similar Posts', 'numinous' ); ?></h5>
        		<div class="row">
                <?php 
                while( $qry->have_posts() ){
                    $qry->the_post();
                    ?>
        			<article class="post">
        				<a href="<?php the_permalink(); ?>" class="post-thumbnail">
                            <?php 
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'numinous-related-post', array( 'itemprop' => 'image' ) ); 
                            }else{
                                numinous_get_fallback_svg( 'numinous-related-post' );
                            } ?>
                                
                        </a>
        				<header class="entry-header">
        					<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        					<?php numinous_meta( true, true );?>                            
        				</header>
        			</article>
                    <?php
                }
                wp_reset_postdata(); 
                ?>
        		</div>
        	</section>
            <?php
            }
        }
    }
}
endif;
add_action( 'numinous_after_post_content', 'numinous_related_post', 20 );

if( ! function_exists( 'numinous_get_search_section' ) ) :
/**
 * Search Header and search form 
 * 
 * @since 1.0.1
*/
function numinous_get_search_section(){
    global $wp_query;
    ?>
    <section class="form-section">
		<span><?php printf( esc_html__( 'Showing %s results', 'numinous' ), $wp_query->found_posts ); ?></span>
		<?php get_search_form(); ?>
	</section>
    <?php
}
endif;
add_action( 'numinous_before_search_content', 'numinous_get_search_section' );

if( ! function_exists( 'numinous_get_comment_section' ) ) :
/**
 * Comment template
 * 
 * @since 1.0.1
*/
function numinous_get_comment_section(){
    // If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
}
endif;
add_action( 'numinous_comment', 'numinous_get_comment_section' );

if( ! function_exists( 'numinous_two_col_double_cat_content' ) ) :
/**
 * Category Section One/Two
*/
function numinous_two_col_double_cat_content(){
    $first_cat  = get_theme_mod( 'numinous_category_one' ); //from customizer
    $second_cat = get_theme_mod( 'numinous_category_two' ); //from customizer
    if( $first_cat && $second_cat ){
        echo '<div class="row">';        
        numinous_get_home_catpost( $first_cat, 'world-section', 2, 'numinous-single-col', 'numinous-recent-post' );
        numinous_get_home_catpost( $second_cat, 'fashion-section', 2, 'numinous-single-col','numinous-recent-post' );    
        echo '</div>';
    }
}
endif;
add_action( 'numinous_home_page', 'numinous_two_col_double_cat_content', 10 );

if( ! function_exists( 'numinous_big_img_single_cat_content' ) ) :
/**
 * Category Section Three
*/
function numinous_big_img_single_cat_content(){
    $third_cat = get_theme_mod( 'numinous_category_three' ); //from customizer
    
    if( $third_cat ){
        numinous_get_home_catpost( $third_cat, 'health-section', 3, 'numinous-with-sidebar', 'numinous-more-news' );
    }
}
endif;
add_action( 'numinous_home_page', 'numinous_big_img_single_cat_content', 20 );

if( ! function_exists( 'numinous_two_col_single_cat_content' ) ) :
/**
 * Category Section Four
*/
function numinous_two_col_single_cat_content(){
    $fourth_cat = get_theme_mod( 'numinous_category_four' ); //from customizer
    
    if( $fourth_cat ){
        numinous_get_home_catpost( $fourth_cat, 'sport-section', 4, 'numinous-single-col', 'numinous-recent-post' );
    }    
}
endif;
add_action( 'numinous_home_page', 'numinous_two_col_single_cat_content', 30 );

if( ! function_exists( 'numinous_more_news_content' ) ) :
/**
 * Category Section Five
*/
function numinous_more_news_content(){
    $fifth_cat = get_theme_mod( 'numinous_category_five' ); //from customizer
    
    if( $fifth_cat ){
        numinous_get_home_catpost( $fifth_cat, 'more-news-section', 5, false, 'numinous-more-news' );
    }    
}
endif;
add_action( 'numinous_home_page', 'numinous_more_news_content', 40 );

if( ! function_exists( 'numinous_content_end' ) ) :
/**
 * Content End
 * 
 * @since 1.0.1
*/
function numinous_content_end(){
    ?>
            </div><!-- .row/not-found -->
        </div><!-- .container -->
    </div><!-- #content -->
    <?php
}
endif;
add_action( 'numinous_after_content', 'numinous_content_end', 20 );

if( ! function_exists( 'numinous_bottom_ad' ) ) :
/**
 * Bottom Ad place
 * 
 * @since 1.0.1
*/
function numinous_bottom_ad(){    
    $ed_footer_ad = get_theme_mod( 'numinous_ed_footer_ad' ); //from customizer
    $ad_img       = get_theme_mod( 'numinous_footer_ad' ); //from customizer
    $ad_link      = get_theme_mod( 'numinous_footer_ad_link' ); //from customizer
    $ad_image     = wp_get_attachment_image_src( $ad_img, 'full' );
    $target       = get_theme_mod( 'numinous_open_link_diff_tab', '1' ) ? 'target="_blank"' : '';
    
    if( $ed_footer_ad && $ad_img && is_front_page() ){
    ?>
        <section class="section-advertisement">
    		<div class="container">
    			<?php if( $ad_link ) echo '<a href="' . esc_url( $ad_link ) . '"' . $target . '>'; ?>
                    <img src="<?php echo esc_url( $ad_image[0] ); ?>" />
                <?php if( $ad_link ) echo '</a>'; ?>
    		</div>
    	</section>
    <?php    
    }
}
endif;
add_action( 'numinous_before_footer', 'numinous_bottom_ad', 10 );

if( ! function_exists( 'numinous_slider' ) ) :
/**
 * Bottom Slider
 * 
 * @since 1.0.1
*/
function numinous_slider(){
    $ed_slider    = get_theme_mod( 'numinous_ed_slider' );
    $ed_caption   = get_theme_mod( 'numinous_slider_caption', '1' );
    $slider_one   = get_theme_mod( 'numinous_slider_post_one' ); //From Customizer
    $slider_two   = get_theme_mod( 'numinous_slider_post_two' ); //From Customizer
    $slider_three = get_theme_mod( 'numinous_slider_post_three' ); //From Customizer
    $slider_four  = get_theme_mod( 'numinous_slider_post_four' ); //From Customizer
    $slider_five  = get_theme_mod( 'numinous_slider_post_five' ); //From Customizer
    $slider_six   = get_theme_mod( 'numinous_slider_post_six' ); //From Customizer
    $slider_seven = get_theme_mod( 'numinous_slider_post_seven' ); //From Customizer
    
    $slider_posts = array( $slider_one, $slider_two, $slider_three, $slider_four, $slider_five, $slider_six, $slider_seven );
    $slider_posts = array_diff( array_unique( $slider_posts ), array('') );
    
    if( $ed_slider && $slider_posts && ( is_page_template( 'template-home.php' ) || ( is_front_page() && !is_home() ) ) ){
        
        $args = array(
            'post_type'           => 'post',
            'posts_per_page'      => -1,
            'post_status'         => 'publish',
            'post__in'            => $slider_posts,
            'orderby'             => 'post__in',
            'ignore_sticky_posts' => true
        );
        
        $slider_qry = new WP_Query( $args );
        
        if( $slider_qry->have_posts() ){
        ?>
            <section class="slider-section">
                <ul id="lightSlider" class="owl-carousel">        
                <?php
                while( $slider_qry->have_posts() ){
                    $slider_qry->the_post();
                    if( has_post_thumbnail() ){
                    ?>
                    <li>
        		      	<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'numinous-slider', array( 'itemprop' => 'image' ) ); ?></a>
        		      	<?php if( $ed_caption ){ ?>
                        <div class="text-holder">
        		      		<?php numinous_colored_category(); ?>
        		      		<header class="entry-header">
        		      			<h2 class="entry-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
        		      			<div class="entry-meta">
        		      				<span><?php echo esc_html( sprintf( _x( '%s ago', '%s = human-readable time difference', 'numinous' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ) ); ?></span>
        		      			</div>
        		      		</header>
        		     	</div>
                        <?php } ?>
        		    </li>             
                    <?php    
                    }
                }
                wp_reset_postdata();     
                ?>
                </ul>
            </section>
            <?php
        }               
    }    
}
endif;
add_action( 'numinous_before_footer', 'numinous_slider', 20 );

if( ! function_exists( 'numinous_footer_start' ) ) :
/**
 * Footer Start
 * 
 * @since 1.0.1
*/
function numinous_footer_start(){
    ?>
    <footer id="colophon" class="site-footer" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
    <?php
}
endif;
add_action( 'numinous_footer', 'numinous_footer_start', 20 );

if( ! function_exists( 'numinous_footer_top' ) ) :
/**
 * Footer Top
 * 
 * @since 1.0.1
*/
function numinous_footer_top(){    
    if( is_active_sidebar( 'footer-one' ) || is_active_sidebar( 'footer-two' ) || is_active_sidebar( 'footer-three' ) ){
    ?>
    <div class="footer-t">
		<div class="container">
			<div class="row">
				<?php if( is_active_sidebar( 'footer-one' ) ){ ?>
					<div class="column">
					   <?php dynamic_sidebar( 'footer-one' ); ?>	
					</div>
                <?php } ?>
				
                <?php if( is_active_sidebar( 'footer-two' ) ){ ?>
                    <div class="column">
					   <?php dynamic_sidebar( 'footer-two' ); ?>	
					</div>
                <?php } ?>
                
                <?php if( is_active_sidebar( 'footer-three' ) ){ ?>
                    <div class="column">
					   <?php dynamic_sidebar( 'footer-three' ); ?>	
					</div>
                <?php } ?>
			</div>
		</div>
	</div>
    <?php 
    }   
}
endif;
add_action( 'numinous_footer', 'numinous_footer_top', 30 );

if( ! function_exists( 'numinous_footer_bottom' ) ) :
/**
 * Footer Bottom
 * 
 * @since 1.0.1 
*/
function numinous_footer_bottom(){
    $copyright_text = get_theme_mod( 'numinous_footer_copyright_text' );
    ?>
    <div class="footer-b">
		<div class="container">
			<div class="site-info">
				<span class="copyright">
                    <?php
                    if( $copyright_text ){
                        echo wp_kses_post( $copyright_text );
                    }else{
                        echo esc_html__( '&copy; Copyright ', 'numinous' ) . date_i18n( esc_html__( 'Y', 'numinous' ) ); ?> 
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>.
                    <?php } ?>
                </span>
				<span class="by">
                <?php esc_html_e( 'Numinous | Developed By ', 'numinous' ); ?>
                <a href="<?php echo esc_url( 'https://rarathemes.com/' ); ?>" rel="nofollow" target="_blank"><?php echo esc_html__( 'Rara Theme', 'numinous' ); ?></a>.
                <?php printf( esc_html__( 'Powered by %s', 'numinous' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'numinous' ) ) .'" target="_blank">WordPress</a>' ); ?>.
                <?php
                if ( function_exists( 'the_privacy_policy_link' ) ) {
                    the_privacy_policy_link();
                }
                ?>
                </span>
			</div>
		</div>
	</div>
    <?php
}
endif;
add_action( 'numinous_footer', 'numinous_footer_bottom', 40 );

if( ! function_exists( 'numinous_footer_end' ) ) :
/**
 * Footer End
 * 
 * @since 1.0.1 
*/
function numinous_footer_end(){
    ?>
    </footer><!-- #colophon -->
    <div class="overlay"></div>
    <?php
}
endif;
add_action( 'numinous_footer', 'numinous_footer_end', 50 );

if( ! function_exists( 'numinous_page_end' ) ) :
/**
 * Page End
 * 
 * @since 1.0.1
*/
function numinous_page_end(){
    ?>
    </div><!-- #page -->
    <?php
}
endif;
add_action( 'numinous_after_footer', 'numinous_page_end', 20 );