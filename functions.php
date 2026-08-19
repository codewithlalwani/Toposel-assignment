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

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'toposel-ecommerce' ),
    ) );

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
// HOMEPAGE CUSTOMIZER SETTINGS
// ========================================
function toposel_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'toposel_homepage', array(
        'title'       => __( 'Homepage Content', 'toposel-ecommerce' ),
        'description' => __( 'Edit the announcement, hero and New Arrivals text.', 'toposel-ecommerce' ),
        'priority'    => 30,
    ) );

    $fields = array(
        'announcement_bar_text' => array( 'Announcement text', 'Sign up and get 20% off to your first order. Sign Up Now', 'textarea' ),
        'hero_heading'          => array( 'Hero heading', 'FIND CLOTHES THAT MATCHES YOUR STYLE', 'textarea' ),
        'hero_subheading'       => array( 'Hero description', 'Browse through our diverse range of meticulously crafted garments, designed to bring out your individuality and cater to your sense of style.', 'textarea' ),
        'hero_button_text'      => array( 'Hero button text', 'Shop Now', 'text' ),
        'hero_button_link'      => array( 'Hero button link', '#', 'url' ),
        'stat_one_number'       => array( 'First statistic number', '200+', 'text' ),
        'stat_one_label'        => array( 'First statistic label', 'International Brands', 'text' ),
        'stat_two_number'       => array( 'Second statistic number', '2,000+', 'text' ),
        'stat_two_label'        => array( 'Second statistic label', 'High-Quality Products', 'text' ),
        'stat_three_number'     => array( 'Third statistic number', '30,000+', 'text' ),
        'stat_three_label'      => array( 'Third statistic label', 'Happy Customers', 'text' ),
        'new_arrivals_title'    => array( 'New Arrivals heading', 'NEW ARRIVALS', 'text' ),
    );

    foreach ( $fields as $id => $field ) {
        $wp_customize->add_setting( $id, array(
            'default'           => $field[1],
            'sanitize_callback' => 'url' === $field[2] ? 'esc_url_raw' : 'sanitize_textarea_field',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( $id, array(
            'label'   => __( $field[0], 'toposel-ecommerce' ),
            'section' => 'toposel_homepage',
            'type'    => $field[2],
        ) );
    }

    $wp_customize->add_setting( 'hero_image', array( 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'hero_image', array(
        'label'     => __( 'Hero image', 'toposel-ecommerce' ),
        'section'   => 'toposel_homepage',
        'mime_type' => 'image',
    ) ) );
}
add_action( 'customize_register', 'toposel_customize_register' );

// ========================================
// ACF HOMEPAGE SETTINGS
// ========================================
function toposel_register_acf_homepage_settings() {
    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    acf_add_options_page( array(
        'page_title' => 'Homepage Settings',
        'menu_title' => 'Homepage Settings',
        'menu_slug'  => 'homepage-settings',
        'capability' => 'edit_posts',
        'icon_url'   => 'dashicons-admin-home',
        'position'   => 2,
    ));

    if ( function_exists( 'acf_add_local_field_group' ) ) {
        acf_add_local_field_group( array(
            'key'    => 'group_toposel_homepage_hero',
            'title'  => 'Hero Section',
            'fields' => array(
                array(
                    'key'           => 'field_toposel_hero_heading',
                    'label'         => 'Hero Heading',
                    'name'          => 'hero_heading',
                    'type'          => 'text',
                    'instructions'  => 'Enter the main heading displayed in the homepage hero section.',
                    'required'      => 0,
                    'default_value' => 'FIND CLOTHES THAT MATCHES YOUR STYLE',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param'    => 'options_page',
                        'operator' => '==',
                        'value'    => 'homepage-settings',
                    ),
                ),
            ),
        ));
    }
}
add_action( 'acf/init', 'toposel_register_acf_homepage_settings' );

function toposel_primary_menu_fallback() {
    echo '<ul class="menu">';
    echo '<li><a href="#">' . esc_html__( 'Shop', 'toposel-ecommerce' ) . '</a></li>';
    echo '<li><a href="#">' . esc_html__( 'On Sale', 'toposel-ecommerce' ) . '</a></li>';
    echo '<li><a href="#">' . esc_html__( 'New Arrivals', 'toposel-ecommerce' ) . '</a></li>';
    echo '<li><a href="#">' . esc_html__( 'Brands', 'toposel-ecommerce' ) . '</a></li>';
    echo '</ul>';
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
