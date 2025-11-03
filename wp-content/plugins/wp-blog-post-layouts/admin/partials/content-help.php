<?php
/**
 * Content for help section in admin area.
 */
?>
<div id="cv-help" style="display:none">
    
    <h2 class="cv-admin-title">
        <?php esc_html_e( 'Do you need any help related to our plugin ?', 'wp-blog-post-layouts' ); ?>
    </h2>
    <div class="cv-admin-img">
        <img src="<?php echo esc_url( plugins_url( 'includes/assets/images/support-img.jpg', dirname(__DIR__) ) ); ?>">
    </div>
    <div class="cv-admin-box-wrapper">

        <div class="cv-admin-fields">
            <?php esc_html_e( 'Our documentation gives all the necessary detailed information to get you started. It provides an elaborated overview on plugin features, how to use those features and how to troubleshoot errors.', 'wp-blog-post-layouts' ); ?>
            <div class="cv-main-btn">
                <a class="button-primary" href="https://docs.codevibrant.com/plugins/blog-post-layouts/" target="_blank"><?php esc_html_e( 'Documentation', 'wp-blog-post-layouts' ); ?></a>
            </div>
        </div><!-- .cv-admin-fields -->

        <div class="cv-admin-fields">
            <?php esc_html_e( 'Our TeamSupport specialists are standing by to better understand your customer support needs and solve your problem for you. We aim to provide professional technical support  24/7 to satisfy your need and wish. We also offer support via email and social media.', 'wp-blog-post-layouts' ); ?>
            <div class="cv-main-btn">
                <a class="button-primary" href="https://wordpress.org/support/plugin/wp-blog-post-layouts/" target="_blank"><?php esc_html_e( 'Support', 'wp-blog-post-layouts' ); ?></a>
            </div>
        </div><!-- .cv-admin-fields -->

        <div class="cv-admin-fields">
            <?php esc_html_e( 'Here are our some plugin related latest blogs.', 'wp-blog-post-layouts' ); ?>
            <div class="cv-main-btn">
                <a class="button-primary" href="https://wpallresources.com/" target="_blank"><?php esc_html_e( 'Wpallresources', 'wp-blog-post-layouts' ); ?></a>
            </div>
        </div><!-- .cv-admin-fields -->

    </div><!-- .cv-admin-box-wrapper -->

</div><!-- .cv-help -->