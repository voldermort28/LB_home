<?php
/**
 * Setup kababi Child Theme's textdomain.
 *
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function kababi_child_theme_setup() {
	load_child_theme_textdomain( 'kababi-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'kababi_child_theme_setup' );


add_action( 'wp_enqueue_scripts', 'kababi_enqueue_styles' );
function kababi_enqueue_styles() {
    $parenthandle = 'kababi-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') // this only works if you have Version in the style header
    );
}

add_action( 'template_redirect', 'kababi_child_buffer_lazy_images', 1 );
function kababi_child_buffer_lazy_images() {
    if ( is_admin() || is_feed() || is_preview() || wp_doing_ajax() || wp_is_json_request() ) {
        return;
    }

    ob_start( 'kababi_child_apply_lazy_images' );
}

add_action( 'wp_head', 'kababi_child_preload_first_visit_assets', 1 );
function kababi_child_preload_first_visit_assets() {
    if ( ! is_front_page() ) {
        return;
    }
    ?>
<link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>
<link rel="preconnect" href="https://sp.zalo.me" crossorigin>
<link rel="preload" as="image" href="https://laboon.vn/wp-content/uploads/2021/09/bg_slide_h2.jpg" fetchpriority="high">
<link rel="preload" as="image" href="https://laboon.vn/wp-content/uploads/2025/06/cover-copy1_1.webp" type="image/webp" fetchpriority="high">
<?php
}

function kababi_child_apply_lazy_images( $html ) {
    if ( ! class_exists( 'WP_HTML_Tag_Processor' ) || false === stripos( $html, '<img' ) ) {
        return $html;
    }

    $processor        = new WP_HTML_Tag_Processor( $html );
    $image_index      = 0;
    $eager_image_skip = is_front_page() ? 6 : 3;

    while ( $processor->next_tag( 'img' ) ) {
        $image_index++;

        if ( ! kababi_child_should_lazy_load_image( $processor, $image_index, $eager_image_skip ) ) {
            continue;
        }

        $processor->set_attribute( 'loading', 'lazy' );

        if ( ! $processor->get_attribute( 'decoding' ) ) {
            $processor->set_attribute( 'decoding', 'async' );
        }
    }

    return kababi_child_defer_non_critical_scripts( $processor->get_updated_html() );
}

function kababi_child_should_lazy_load_image( $processor, $image_index, $eager_image_skip ) {
    if ( $processor->get_attribute( 'loading' ) || $processor->get_attribute( 'data-lazyload' ) || $processor->get_attribute( 'fetchpriority' ) ) {
        return false;
    }

    $src   = (string) $processor->get_attribute( 'src' );
    $class = (string) $processor->get_attribute( 'class' );

    if ( $image_index <= $eager_image_skip ) {
        return false;
    }

    $excluded_patterns = array(
        'rev-slidebg',
        'rs-lazyload',
        'tp-rs-img',
        'web_logo1',
        'custom-logo',
        'site-logo',
    );

    foreach ( $excluded_patterns as $pattern ) {
        if ( false !== stripos( $class, $pattern ) || false !== stripos( $src, $pattern ) ) {
            return false;
        }
    }

    return true;
}

function kababi_child_defer_non_critical_scripts( $html ) {
    return str_replace(
        '<script src="https://sp.zalo.me/plugins/sdk.js"></script>',
        '<script src="https://sp.zalo.me/plugins/sdk.js" defer></script>',
        $html
    );
}
