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
    if ( is_admin() || is_user_logged_in() || is_feed() || is_preview() || wp_doing_ajax() || wp_is_json_request() ) {
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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="image" href="https://laboon.vn/wp-content/uploads/2021/09/bg_slide_h2.jpg" fetchpriority="high">
<link rel="preload" as="image" href="https://laboon.vn/wp-content/uploads/2025/06/cover-copy1_1.webp" type="image/webp" fetchpriority="high">
<style>
/* Skeleton and Spinner for Swiper lazy load */
img[data-src]:not([src]), img.swiper-lazy:not(.swiper-lazy-loaded) {
    opacity: 0 !important;
    visibility: hidden !important;
}
/* Prevent stacking: hide all slides except the first one before Swiper initializes */
.swiper-container:not(.swiper-initialized) .swiper-slide:not(:first-child),
.swiper:not(.swiper-initialized) .swiper-slide:not(:first-child) {
    display: none !important;
}
.swiper-container:not(.swiper-initialized),
.swiper:not(.swiper-initialized) {
    overflow: hidden !important;
}
.swiper-slide-inner {
    position: relative;
    min-height: 400px; /* Adjust based on typical banner height */
    background-color: #f0f0f0; /* Skeleton background */
    display: flex;
    align-items: center;
    justify-content: center;
}
.swiper-lazy-preloader {
    width: 42px;
    height: 42px;
    position: absolute;
    left: 50%;
    top: 50%;
    margin-left: -21px;
    margin-top: -21px;
    z-index: 10;
    transform-origin: 50%;
    animation: swiper-preloader-spin 1s infinite linear;
    box-sizing: border-box;
    border: 4px solid #046181; /* Laboon Blue */
    border-radius: 50%;
    border-top-color: transparent;
}
@keyframes swiper-preloader-spin {
    100% { transform: rotate(360deg); }
}
</style>
<?php
}

add_action( 'wp_enqueue_scripts', 'kababi_child_dequeue_unused_ova_events_assets', 100 );
function kababi_child_dequeue_unused_ova_events_assets() {
    if ( is_admin() || kababi_child_page_uses_ova_events() ) {
        return;
    }

    $styles = array(
        'fontawesome',
        'elegant_font',
        'select2',
        'calendar',
        'event-frontend',
    );

    $scripts = array(
        'script-elementor-event',
        'event-frontend-js',
        'select2',
        'calendar',
        'popper',
        'tooltip',
    );

    foreach ( $styles as $handle ) {
        wp_dequeue_style( $handle );
        wp_deregister_style( $handle );
    }

    foreach ( $scripts as $handle ) {
        wp_dequeue_script( $handle );
        wp_deregister_script( $handle );
    }
}

add_action( 'wp_enqueue_scripts', 'kababi_child_dequeue_empty_animation_styles', 101 );
function kababi_child_dequeue_empty_animation_styles() {
    $handles = array(
        'e-animation-ova-move-up',
        'e-animation-ova-move-down',
        'e-animation-ova-move-left',
        'e-animation-ova-move-right',
        'e-animation-ova-scale-up',
        'e-animation-ova-flip',
        'e-animation-ova-helix',
        'e-animation-ova-popup',
    );

    foreach ( $handles as $handle ) {
        wp_dequeue_style( $handle );
        wp_deregister_style( $handle );
    }
}

function kababi_child_page_uses_ova_events() {
    if ( is_singular( 'event' ) || is_post_type_archive( 'event' ) || is_tax( array( 'event_cat', 'event_tag' ) ) ) {
        return true;
    }

    if ( ! is_singular() ) {
        return false;
    }

    $post = get_post();

    if ( ! $post || empty( $post->post_content ) ) {
        return false;
    }

    $shortcodes = array(
        'ovaev_calendar',
        'ovaev_fullcalendar',
        'ovaev_slide',
        'ovaev_slide_ajax',
        'ovaev_search_ajax',
        'ovaev_shortcode_tabs',
        'ovaev_shortcode_related',
        'ovaev_shortcode_share',
        'ovaev_shortcode_categories',
        'ovaev_shortcode_content',
        'ovaev_shortcode_navigation',
        'ovaev_shortcode_time',
        'ovaev_shortcode_tags',
        'ovaev_shortcode_date',
        'ovaev_shortcode_location',
        'ovaev_shortcode_thumbnail',
        'ovaev_shortcode_title',
    );

    foreach ( $shortcodes as $shortcode ) {
        if ( has_shortcode( $post->post_content, $shortcode ) ) {
            return true;
        }
    }

    return false;
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

    $html = $processor->get_updated_html();
    $html = kababi_child_add_font_display_swap( $html );
    return kababi_child_defer_non_critical_scripts( $html );
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

function kababi_child_add_font_display_swap( $html ) {
    return preg_replace_callback(
        '/(fonts\.googleapis\.com\/css2?\?[^"\'\s>]*)/i',
        function ( $m ) {
            if ( false === stripos( $m[1], 'display=' ) ) {
                return $m[1] . '&display=swap';
            }
            return $m[1];
        },
        $html
    );
}

function kababi_child_defer_non_critical_scripts( $html ) {
    $zalo_original = '<script src="https://sp.zalo.me/plugins/sdk.js"></script>';
    $zalo_lazy     = '<script id="laboon-zalo-lazy">'
        . '(function(){var d=!1;function l(){if(!d){d=!0;var s=document.createElement("script");'
        . 's.src="https://sp.zalo.me/plugins/sdk.js";document.body.appendChild(s);}'
        . '}["scroll","mousemove","touchstart","click","keydown"].forEach(function(e){'
        . 'window.addEventListener(e,l,{once:!0,passive:!0})});'
        . 'window.addEventListener("load",function(){setTimeout(l,4000)});})()';

    return str_replace( $zalo_original, $zalo_lazy, $html );
}

add_filter( 'script_loader_tag', 'kababi_child_selective_defer_scripts', 10, 3 );
function kababi_child_selective_defer_scripts( $tag, $handle, $src ) {
    if ( is_admin() || is_user_logged_in() ) {
        return $tag;
    }

    $no_defer_handles = array(
        'jquery-core',
        'jquery-migrate',
        'jquery',
        'masonry',
        'imagesloaded',
        'jquery-masonry',
        'gallery',
        'tp-tools',
        'revmin',
        'swiper',
        'elementor-frontend',
    );

    if ( in_array( $handle, $no_defer_handles, true ) || false !== strpos( $handle, 'revslider' ) ) {
        return $tag;
    }

    if ( false !== strpos( $tag, ' defer' ) || false !== strpos( $tag, ' async' ) ) {
        return $tag;
    }

    if ( false === strpos( $tag, ' src=' ) ) {
        return $tag;
    }

    return str_replace( ' src=', ' defer src=', $tag );
}

/**
 * Phase 01B: Additional PageSpeed optimizations.
 */

// 1.5 – Force font-display:swap on Elementor-loaded Google Fonts.
add_filter( 'elementor/frontend/google_font_url', 'kababi_child_elementor_font_swap' );
function kababi_child_elementor_font_swap( $url ) {
    if ( false === strpos( $url, 'display=' ) ) {
        $url .= '&display=swap';
    }
    return $url;
}

// 1.6 – Async load non-critical CSS to eliminate render blocking.
add_filter( 'style_loader_tag', 'kababi_child_async_noncritical_css', 10, 4 );
function kababi_child_async_noncritical_css( $html, $handle, $href, $media ) {
    if ( is_admin() || is_user_logged_in() ) {
        return $html;
    }

    // Keep critical CSS loading normally (above-the-fold).
    $critical_handles = array(
        'kababi-style',
        'child-style',
        'elementor-frontend',
        'elementor-common',
        'elementor-global',
        'elementor-post-',
        'google-fonts-',
        'e-animations',
    );

    foreach ( $critical_handles as $prefix ) {
        if ( 0 === strpos( $handle, $prefix ) || $handle === $prefix ) {
            return $html;
        }
    }

    // Convert non-critical CSS to async loading pattern.
    if ( false !== strpos( $html, "media='all'" ) ) {
        return str_replace(
            "media='all'",
            "media='print' onload=\"this.media='all'\"",
            $html
        );
    }

    return $html;
}

// 1.7 – Dequeue RevSlider assets on non-homepage (only used there).
add_action( 'wp_enqueue_scripts', 'kababi_child_dequeue_revslider_off_home', 102 );
function kababi_child_dequeue_revslider_off_home() {
    if ( is_front_page() || is_admin() || is_user_logged_in() ) {
        return;
    }

    // Dequeue all RevSlider CSS and JS on pages that don't use it.
    global $wp_styles, $wp_scripts;

    if ( ! empty( $wp_styles->registered ) ) {
        foreach ( $wp_styles->registered as $handle => $style ) {
            if ( false !== strpos( $handle, 'rs-plugin' ) || false !== strpos( $handle, 'revslider' ) || false !== strpos( $handle, 'rev-slide' ) ) {
                wp_dequeue_style( $handle );
            }
        }
    }

    if ( ! empty( $wp_scripts->registered ) ) {
        foreach ( $wp_scripts->registered as $handle => $script ) {
            if ( false !== strpos( $handle, 'tp-tools' ) || false !== strpos( $handle, 'revmin' ) || false !== strpos( $handle, 'revslider' ) || false !== strpos( $handle, 'rev-slide' ) ) {
                wp_dequeue_script( $handle );
            }
        }
    }
}

// 1.8 – Dequeue unused Roboto Slab font (loaded but not used on any element).
add_action( 'wp_enqueue_scripts', 'kababi_child_dequeue_unused_fonts', 102 );
function kababi_child_dequeue_unused_fonts() {
    if ( is_admin() || is_user_logged_in() ) {
        return;
    }

    global $wp_styles;

    if ( empty( $wp_styles->registered ) ) {
        return;
    }

    foreach ( $wp_styles->registered as $handle => $style ) {
        if ( ! empty( $style->src ) && false !== strpos( $style->src, 'roboto-slab' ) ) {
            wp_dequeue_style( $handle );
            break;
        }
    }
}

// Include custom shortcodes
require_once get_stylesheet_directory() . '/includes/shortcode-stores.php';

/**
 * Custom Posts Per Page for Blog/Archive
 */
add_action( 'pre_get_posts', 'laboon_custom_posts_per_page' );
function laboon_custom_posts_per_page( $query ) {
    if ( !is_admin() && $query->is_main_query() && (is_home() || is_archive() || is_category()) ) {
        $query->set( 'posts_per_page', 9 );
    }
}

/**
 * Convert Elementor Category Grid to Swiper Slider on Mobile/Tablet
 */
add_action( 'wp_footer', 'laboon_mobile_category_slider', 99 );
function laboon_mobile_category_slider() {
    if ( is_front_page() ) {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth <= 1024) {
                var section = document.querySelector('.elementor-element-eafa95b .elementor-container');
                if (!section) return;

                var categories = section.querySelectorAll('.elementor-widget-kababi_elementor_menu-category');
                if (categories.length === 0) return;

                // Create Swiper structure
                var swiperContainer = document.createElement('div');
                swiperContainer.className = 'swiper laboon-mobile-cat-slider'; 
                swiperContainer.classList.add('swiper-container'); // For backward compatibility with older elementor swiper

                var swiperWrapper = document.createElement('div');
                swiperWrapper.className = 'swiper-wrapper';

                categories.forEach(function(cat) {
                    var slide = document.createElement('div');
                    slide.className = 'swiper-slide';
                    slide.appendChild(cat);
                    swiperWrapper.appendChild(slide);
                });

                swiperContainer.appendChild(swiperWrapper);

                // Add pagination & navigation
                var pagination = document.createElement('div');
                pagination.className = 'swiper-pagination';
                swiperContainer.appendChild(pagination);

                var prevBtn = document.createElement('div');
                prevBtn.className = 'swiper-button-prev';
                swiperContainer.appendChild(prevBtn);

                var nextBtn = document.createElement('div');
                nextBtn.className = 'swiper-button-next';
                swiperContainer.appendChild(nextBtn);

                // Replace the old columns with the new slider
                section.innerHTML = '';
                section.appendChild(swiperContainer);

                // Init Swiper after making sure it's loaded by Elementor
                var initSlider = setInterval(function() {
                    if (typeof Swiper !== 'undefined') {
                        clearInterval(initSlider);
                        new Swiper('.laboon-mobile-cat-slider', {
                            effect: 'coverflow',
                            grabCursor: true,
                            centeredSlides: true,
                            slidesPerView: 'auto',
                            loop: true,
                            coverflowEffect: {
                                rotate: 0,
                                stretch: -30, // Pulls side slides slightly under the center slide
                                depth: 100, // Scales down the side slides
                                modifier: 1,
                                slideShadows: false,
                            },
                            pagination: {
                                el: '.swiper-pagination',
                                clickable: true,
                            },
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            },
                        });
                    }
                }, 100);
            }
        });
        </script>
        <?php
    }
}

