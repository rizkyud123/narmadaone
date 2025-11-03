<?php
/**
 * Content for review section in admin area.
 */
?>
<div id="cv-review" style="display:none">
    <h2 class="cv-admin-title">
        <?php esc_html_e( 'Give a review & motivate us', 'wp-blog-post-layouts' ); ?>
    </h2>
    <div class="cv-admin-img">
        <img src="<?php echo esc_url( plugins_url( 'includes/assets/images/review-img.jpg', dirname(__DIR__) ) ); ?>">
    </div>
    <h2><?php esc_html_e( 'Send us your Feedback', 'wp-blog-post-layouts' ); ?></h2>
    <div class="cv-admin-fields">
        <p><?php esc_html_e( 'Please let us know about your experience with Blog Post Layout so far. We love to hear positive things but we`re also thankful for the negatives. Your feedback will alert us to problems and help us improve our WP Blog Post Layouts.
            Are you happy with us? Would you mind taking a moment to leave us a rating? It will only take a minute. We look forward to receiving feedback from you to make WP Blog Post Layouts even more useful for you and others.', 'wp-blog-post-layouts' ); ?></p>
        <p><a class="button-primary" href="https://wordpress.org/support/plugin/wp-blog-post-layouts/reviews/?filter=5" target="_blank"><?php esc_html_e( 'Review Plugin', 'wp-blog-post-layouts' ); ?></a></p>
        <em class="cv-note"><?php esc_html_e( 'Thanks for choosing WP Blog Post Layouts', 'wp-blog-post-layouts' ); ?></em>
    </div>
</div><!-- .cv-review -->