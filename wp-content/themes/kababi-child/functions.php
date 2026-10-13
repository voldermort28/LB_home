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

        // Add missing or empty alt attribute for Google Image SEO
        $alt = $processor->get_attribute( 'alt' );
        if ( null === $alt || '' === trim( (string) $alt ) ) {
            $processor->set_attribute( 'alt', 'Trà Sữa Laboon' );
        }

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
    
    // Placeholder button: visually identical to Zalo button, 0 JS/network overhead on page load.
    // Loads the full SDK immediately upon click, or in background after window 'load' + idle.
    $zalo_placeholder = '<div id="laboon-zalo-placeholder" class="laboon-zalo-placeholder" title="Chat Zalo với Trà Sữa Laboon" aria-label="Chat Zalo" role="button" tabindex="0">'
        . '<svg viewBox="0 0 50 50" width="56" height="56">'
        . '<path fill="#0068FF" d="M22.78 0.17h4.42c6.07 0 9.61.89 12.76 2.58 3.15 1.69 5.63 4.15 7.3 7.3 1.69 3.15 2.58 6.69 2.58 12.76v4.4c0 6.07-.89 9.61-2.58 12.76-1.69 3.15-4.15 5.63-7.3 7.3-3.15 1.69-6.69 2.58-12.76 2.58h-4.4c-6.07 0-9.61-.89-12.76-2.58-3.15-1.69-5.63-4.15-7.3-7.3-1.69-3.15-2.58-6.69-2.58-12.76v-4.4c0-6.07.89-9.61 2.58-12.76 1.69-3.15 4.15-5.63 7.3-7.3C13.17 1.06 16.73.17 22.78.17z"/>'
        . '<path fill="#fff" d="M7.78 43.59c2.32.26 5.23-.4 7.29-1.4 8.95 4.95 22.95 4.71 31.42-.71.33-.49.64-1 .92-1.53 1.69-3.16 2.59-6.72 2.59-12.81v-4.41c0-6.09-.9-9.65-2.59-12.81-1.67-3.16-4.17-5.63-7.33-7.32C36.93.9 33.37 0 27.28 0h-4.43c-5.19 0-8.55.65-11.38 1.9-.15.14-.3.28-.45.42-8.3 8-8.93 25.34-1.89 34.76.01.01.02.03.03.04 1.08 1.6.04 4.4-1.6 6.03-.26.25-.17.4.23.44z"/>'
        . '<path fill="#0068FF" d="M20.56 17h-9.72v2.09h6.75l-6.65 8.24c-.21.31-.36.59-.36 1.24v.53h9.17c.46 0 .84-.38.84-.83v-1.12h-7.09l6.25-7.85c.1-.11.27-.32.34-.42l.04-.06c.36-.53.44-.98.44-1.53V17zm12.38 12.09h1.38V17h-2.08v11.39c0 .38.3.7.7.7zm-7.13-9.4c-2.61 0-4.74 2.12-4.74 4.74s2.12 4.74 4.74 4.74 4.74-2.12 4.74-4.74c.02-2.62-2.11-4.74-4.74-4.74zm0 7.53c-1.54 0-2.79-1.25-2.79-2.79s1.25-2.79 2.79-2.79 2.79 1.25 2.79 2.79-1.23 2.79-2.79 2.79zm14.67-7.6c-2.63 0-4.78 2.14-4.78 4.78s2.14 4.78 4.78 4.78 4.78-2.14 4.78-4.78-2.14-4.78-4.78-4.78zm0 7.6c-1.55 0-2.8-1.25-2.8-2.8s1.25-2.8 2.8-2.8 2.8 1.25 2.8 2.8-1.25 2.8-2.8 2.8zm-11.03 1.88h1.12V19.96h-1.95v8.32c0 .44.38.82.83.82z"/>'
        . '</svg>'
        . '</div>'
        . '<style>'
        . '.laboon-zalo-placeholder{position:fixed;bottom:24px;right:24px;z-index:9999;width:56px;height:56px;cursor:pointer;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 14px rgba(0,104,255,0.4);transition:transform .25s ease,box-shadow .25s ease;animation:laboonZaloPulse 2.5s infinite;user-select:none}'
        . '.laboon-zalo-placeholder:hover{transform:scale(1.08);box-shadow:0 6px 20px rgba(0,104,255,0.6)}'
        . '.laboon-zalo-placeholder svg{width:100%;height:100%;display:block;border-radius:50%}'
        . '@keyframes laboonZaloPulse{0%,100%{transform:scale(1)}50%{transform:scale(1.06)}}'
        . '@media(max-width:768px){.laboon-zalo-placeholder{bottom:84px;right:16px}}'
        . 'body.lmb-drawer-open .laboon-zalo-placeholder{display:none!important}'
        . '</style>';

    $zalo_lazy = $zalo_placeholder . '<script id="laboon-zalo-lazy">'
        . '(function(){'
        . 'var loaded=!1;'
        . 'function loadZalo(){'
        . '  if(loaded)return;'
        . '  loaded=!0;'
        . '  var p=document.getElementById("laboon-zalo-placeholder");'
        . '  if(p){p.style.display="none";}'
        . '  var s=document.createElement("script");'
        . '  s.src="https://sp.zalo.me/plugins/sdk.js";'
        . '  s.async=!0;'
        . '  document.body.appendChild(s);'
        . '}'
        . 'var placeholder=document.getElementById("laboon-zalo-placeholder");'
        . 'if(placeholder){'
        . '  placeholder.addEventListener("click",loadZalo,{once:!0});'
        . '  placeholder.addEventListener("touchstart",loadZalo,{once:!0,passive:!0});'
        . '}'
        . 'function deferLoad(){'
        . '  if("requestIdleCallback" in window){'
        . '    requestIdleCallback(function(){setTimeout(loadZalo,3000);},{timeout:8000});'
        . '  } else {'
        . '    setTimeout(loadZalo,5000);'
        . '  }'
        . '}'
        . 'if(document.readyState==="complete"){'
        . '  deferLoad();'
        . '} else {'
        . '  window.addEventListener("load",deferLoad,{once:!0});'
        . '}'
        . '})()</script>';

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
        'elementor-webpack-runtime',
        'elementor-frontend-modules',
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

// Include Mobile Sticky Conversion Bar (Strategy 04: Mobile CRO)
require_once get_stylesheet_directory() . '/includes/mobile-cta-bar.php';

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

                // Init Swiper after making sure it's loaded by Elementor AND container has width
                var initSlider = setInterval(function() {
                    if (typeof Swiper !== 'undefined' && swiperContainer.offsetWidth > 0) {
                        clearInterval(initSlider);
                        new Swiper('.laboon-mobile-cat-slider', {
                            effect: 'coverflow',
                            grabCursor: true,
                            centeredSlides: true,
                            slidesPerView: 'auto',
                            loop: true,
                            loopedSlides: categories.length,
                            loopAdditionalSlides: categories.length, // Ensure extra clones for safety
                            watchSlidesProgress: true, // Fix visibility tracking
                            observer: true,
                            observeParents: true,
                            coverflowEffect: {
                                rotate: 0,
                                stretch: 0, // 0 stretch + depth automatically creates the ~10% overlap nicely
                                depth: 250, // Pushes side slides back, making them smaller and overlap
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

/**
 * =========================================================================
 * Phase SEO: Comprehensive SEO Enhancements for Laboon
 * =========================================================================
 */

// 1. Exclude internal template post types from Yoast SEO XML Sitemap
add_filter( 'wpseo_sitemap_exclude_post_type', 'laboon_seo_exclude_post_types_from_sitemap', 10, 2 );
function laboon_seo_exclude_post_types_from_sitemap( $exclude, $post_type ) {
    $excluded_types = array(
        'ova_framework_hf_el',
        'elementor_library',
        'event',
    );
    if ( in_array( $post_type, $excluded_types, true ) ) {
        return true;
    }
    return $exclude;
}

// 2. Set OpenGraph locale to Vietnamese vi_VN
add_filter( 'wpseo_locale', function( $locale ) {
    return 'vi_VN';
} );

// 3. Optimized SEO Title fallbacks
add_filter( 'wpseo_title', 'laboon_seo_optimized_titles' );
function laboon_seo_optimized_titles( $title ) {
    if ( is_front_page() ) {
        return 'Trà Sữa Laboon - Trà Sữa Pha Máy Đậm Vị & Cà Phê TP.HCM';
    }
    if ( is_page( 'menu' ) || is_page( 6286 ) ) {
        return 'Menu Trà Sữa & Cà Phê Laboon | Đặt Món Online';
    }
    if ( is_page( 'cua-hang' ) || is_page( 1642 ) ) {
        return 'Hệ Thống Chi Nhánh Cửa Hàng - Trà Sữa Laboon TP.HCM';
    }
    if ( is_page( 'tin-tuc' ) || is_home() || is_page( 44 ) ) {
        return 'Tin Tức & Khuyến Mãi - Trà Sữa Laboon';
    }
    return $title;
}

// 4. Optimized Meta Description fallbacks for pages with empty description
add_filter( 'wpseo_metadesc', 'laboon_seo_optimized_descriptions' );
function laboon_seo_optimized_descriptions( $desc ) {
    if ( ! empty( $desc ) ) {
        return $desc;
    }
    if ( is_page( 'menu' ) || is_page( 6286 ) ) {
        return 'Khám phá Menu Trà Sữa Laboon: Trà sữa kem trứng khè, trà Oolong sen vàng macchiato, cà phê muối, trà trái cây tươi mát. Giao hàng tận nơi nhanh chóng!';
    }
    if ( is_page( 'cua-hang' ) || is_page( 1642 ) ) {
        return 'Hệ thống cửa hàng Trà Sữa Laboon tại TP.HCM: Quận 1, Quận 4, Quận 7. Xem địa chỉ, chỉ đường, số điện thoại hotline và giờ mở cửa chi tiết.';
    }
    if ( is_page( 'tin-tuc' ) || is_home() || is_page( 44 ) ) {
        return 'Tin tức mới nhất, chương trình khuyến mãi và các món mới từ Trà Sữa Laboon. Cập nhật các ưu đãi độc quyền dành cho khách hàng.';
    }
    return $desc;
}

// 5. Inject SEO H1 on Homepage
add_action( 'wp_body_open', 'laboon_seo_homepage_h1', 1 );
function laboon_seo_homepage_h1() {
    if ( is_front_page() ) {
        echo '<h1 class="screen-reader-text" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;">Trà Sữa Laboon - Trà Sữa Pha Máy &amp; Trà Trái Cây Tươi Ngon TP.HCM</h1>' . "\n";
    }
}

// 6. LocalBusiness / CafeOrCoffeeShop Schema JSON-LD for All 3 Branches
add_action( 'wp_head', 'laboon_seo_local_business_schema', 1 );
function laboon_seo_local_business_schema() {
    if ( ! is_front_page() && ! is_page( 'cua-hang' ) && ! is_singular( 'store' ) ) {
        return;
    }

    $schema = array(
        '@context'      => 'https://schema.org',
        '@type'         => 'CafeOrCoffeeShop',
        '@id'           => 'https://laboon.vn/#organization',
        'name'          => 'Trà Sữa Laboon',
        'url'           => 'https://laboon.vn',
        'logo'          => 'https://laboon.vn/wp-content/uploads/2025/07/cropped-favicon_2_Artboard-11-192x192.webp',
        'image'         => 'https://laboon.vn/wp-content/uploads/2025/06/thumbnail_Artboard-1@2x_1.png',
        'description'   => 'Trà Sữa Laboon chuyên Trà Sữa pha máy đậm vị, trà trái cây tươi ngon và cà phê chất lượng cao.',
        'telephone'     => '0962463086',
        'email'         => 'contact@laboon.vn',
        'priceRange'    => '25.000đ - 65.000đ',
        'servesCuisine' => array( 'Milk Tea', 'Fruit Tea', 'Coffee', 'Beverages' ),
        'hasMenu'       => 'https://laboon.vn/menu/',
        'sameAs'        => array(
            'https://www.facebook.com/trasualaboon',
        ),
        'department'    => array(
            array(
                '@type'                     => 'CafeOrCoffeeShop',
                'name'                      => 'Trà Sữa Laboon - Chi nhánh Quận 1 (233/3 Nguyễn Trãi)',
                'address'                   => array(
                    '@type'           => 'PostalAddress',
                    'streetAddress'   => '233/3 Nguyễn Trãi, Phường Cầu Ông Lãnh',
                    'addressLocality' => 'Quận 1',
                    'addressRegion'   => 'TP. Hồ Chí Minh',
                    'addressCountry'  => 'VN',
                ),
                'telephone'                 => '0962463086',
                'openingHoursSpecification' => array(
                    '@type'     => 'OpeningHoursSpecification',
                    'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ),
                    'opens'     => '08:00',
                    'closes'    => '22:00',
                ),
            ),
            array(
                '@type'                     => 'CafeOrCoffeeShop',
                'name'                      => 'Trà Sữa Laboon - Chi nhánh Quận 4 (246 Khánh Hội)',
                'address'                   => array(
                    '@type'           => 'PostalAddress',
                    'streetAddress'   => '246 Khánh Hội, Phường 6',
                    'addressLocality' => 'Quận 4',
                    'addressRegion'   => 'TP. Hồ Chí Minh',
                    'addressCountry'  => 'VN',
                ),
                'telephone'                 => '0962463086',
                'openingHoursSpecification' => array(
                    '@type'     => 'OpeningHoursSpecification',
                    'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ),
                    'opens'     => '08:00',
                    'closes'    => '22:30',
                ),
            ),
            array(
                '@type'                     => 'CafeOrCoffeeShop',
                'name'                      => 'Trà Sữa Laboon - Chi nhánh Quận 7 (79 Đường số 17)',
                'address'                   => array(
                    '@type'           => 'PostalAddress',
                    'streetAddress'   => '79 Đường số 17, Phường Tân Quy',
                    'addressLocality' => 'Quận 7',
                    'addressRegion'   => 'TP. Hồ Chí Minh',
                    'addressCountry'  => 'VN',
                ),
                'telephone'                 => '0962463086',
                'openingHoursSpecification' => array(
                    '@type'     => 'OpeningHoursSpecification',
                    'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ),
                    'opens'     => '08:00',
                    'closes'    => '22:30',
                ),
            ),
        ),
    );

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}

/**
 * Exclude logged-in users / Admins from GTM & WPCode analytics tracking
 */
add_filter( 'disable_ihaf_header', 'laboon_disable_tracking_for_logged_in_users' );
add_filter( 'disable_ihaf_body', 'laboon_disable_tracking_for_logged_in_users' );
function laboon_disable_tracking_for_logged_in_users( $disable ) {
    if ( is_user_logged_in() ) {
        return true;
    }
    return $disable;
}

add_filter( 'wpcode_snippet_output', function( $snippet_code, $snippet ) {
    if ( is_user_logged_in() ) {
        if ( is_string( $snippet_code ) && ( false !== stripos( $snippet_code, 'googletagmanager.com' ) || false !== stripos( $snippet_code, 'gtag(' ) ) ) {
            return '';
        }
    }
    return $snippet_code;
}, 10, 2 );

