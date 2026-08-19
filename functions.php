<?php
/**
 * Toposel E-commerce Theme Functions
 *
 * @package Toposel_Ecommerce
 */

// ========================================
// THEME SETUP
// ========================================
function toposel_theme_setup() {
    // Add title tag support
    add_theme_support( 'title-tag' );

    // Add post thumbnail support
    add_theme_support( 'post-thumbnails' );

    // WooCommerce support
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // HTML5 support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action( 'after_setup_theme', 'toposel_theme_setup' );

// ========================================
// ENQUEUE STYLES & FONTS
// ========================================
function toposel_enqueue_assets() {
    // Google Fonts — Satoshi via Fontsource / Inter as fallback
    wp_enqueue_style(
        'toposel-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'toposel-style',
        get_stylesheet_uri(),
        array( 'toposel-google-fonts' ),
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'toposel_enqueue_assets' );

// ========================================
// ACF OPTIONS PAGE
// ========================================
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( array(
        'page_title' => 'Homepage Settings',
        'menu_title' => 'Homepage Settings',
        'menu_slug'  => 'homepage-settings',
        'capability' => 'edit_posts',
        'icon_url'   => 'dashicons-admin-home',
        'position'   => 2,
    ));
}

// ========================================
// HELPER: Generate Star Rating SVGs
// ========================================
function toposel_render_stars( $rating ) {
    $output = '<div class="product-card__stars">';
    for ( $i = 1; $i <= 5; $i++ ) {
        if ( $i <= floor( $rating ) ) {
            // Full star
            $output .= '<svg class="star-filled" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        } elseif ( $i - 0.5 <= $rating ) {
            // Half star
            $output .= '<svg class="star-half" viewBox="0 0 24 24" fill="currentColor"><defs><linearGradient id="half' . $i . '"><stop offset="50%" stop-color="#FFC633"/><stop offset="50%" stop-color="#d4d4d4"/></linearGradient></defs><path fill="url(#half' . $i . ')" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        } else {
            // Empty star
            $output .= '<svg class="star-empty" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        }
    }
    $output .= '</div>';
    return $output;
}

// ========================================
// ALLOW SVG UPLOADS
// ========================================
function toposel_allow_svg( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'toposel_allow_svg' );
