<?php
/**
 * Template Name: Front Page
 *
 * The homepage template — renders the mobile-first e-commerce layout.
 *
 * @package Toposel_Ecommerce
 */

get_header();
?>

<?php
// ========================================
// HERO SECTION
// ========================================
$hero_heading  = '';
$hero_sub      = '';
$hero_btn_text = '';
$hero_btn_link = '';
$hero_image    = '';

if ( function_exists( 'get_field' ) ) {
    $hero_heading  = get_field( 'hero_heading' );
    $hero_sub      = get_field( 'hero_subheading' );
    $hero_btn_text = get_field( 'hero_button_text' );
    $hero_btn_link = get_field( 'hero_button_link' );
    $hero_image    = get_field( 'hero_image' );
}

// Fallback defaults (matches the Figma design)
if ( ! $hero_heading )  $hero_heading  = 'FIND CLOTHES THAT MATCHES YOUR STYLE';
if ( ! $hero_sub )      $hero_sub      = 'Browse through our diverse range of meticulously crafted garments, designed to bring out your individuality and cater to your sense of style.';
if ( ! $hero_btn_text ) $hero_btn_text = 'Shop Now';
if ( ! $hero_btn_link ) $hero_btn_link = '#';
?>

<section class="hero">
  <div class="hero__content">
    <h1 class="hero__heading"><?php echo esc_html( $hero_heading ); ?></h1>
    <p class="hero__subheading"><?php echo esc_html( $hero_sub ); ?></p>
    <a href="<?php echo esc_url( $hero_btn_link ); ?>" class="hero__button">
      <?php echo esc_html( $hero_btn_text ); ?>
    </a>

    <!-- Stats -->
    <div class="hero__stats">
      <div class="hero__stat">
        <span class="hero__stat-number">200+</span>
        <span class="hero__stat-label">International Brands</span>
      </div>
      <div class="hero__stat">
        <span class="hero__stat-number">2,000+</span>
        <span class="hero__stat-label">High-Quality Products</span>
      </div>
      <div class="hero__stat">
        <span class="hero__stat-number">30,000+</span>
        <span class="hero__stat-label">Happy Customers</span>
      </div>
    </div>
  </div>

  <!-- Hero Image -->
  <div class="hero__image">
    <?php if ( $hero_image && is_array( $hero_image ) ) : ?>
      <img src="<?php echo esc_url( $hero_image['url'] ); ?>"
           alt="<?php echo esc_attr( $hero_image['alt'] ?? 'Hero Banner' ); ?>">
    <?php else : ?>
      <!-- Placeholder — replace with your hero image via ACF -->
      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/Rectangle2.svg' ); ?>"
           alt="Hero Banner">
    <?php endif; ?>

    <!-- Decorative stars -->
    <svg class="hero__star hero__star--large" viewBox="0 0 56 56" fill="none">
      <path d="M28 0L33.5 22.5L56 28L33.5 33.5L28 56L22.5 33.5L0 28L22.5 22.5L28 0Z" fill="#000000"/>
    </svg>
    <svg class="hero__star hero__star--small" viewBox="0 0 36 36" fill="none">
      <path d="M18 0L21.5 14.5L36 18L21.5 21.5L18 36L14.5 21.5L0 18L14.5 14.5L18 0Z" fill="#000000"/>
    </svg>
  </div>
</section>

<?php
// ========================================
// BRAND LOGOS BAR
// ========================================
?>
<section class="brand-bar">
  <?php
  $has_acf_brands = false;
  if ( function_exists( 'have_rows' ) && have_rows( 'brand_logos' ) ) :
      $has_acf_brands = true;
      while ( have_rows( 'brand_logos' ) ) : the_row();
          $logo = get_sub_field( 'brand_logo' );
          $name = get_sub_field( 'brand_name' );
          if ( $logo ) :
  ?>
    <img class="brand-bar__logo"
         src="<?php echo esc_url( $logo['url'] ); ?>"
         alt="<?php echo esc_attr( $name ); ?>">
  <?php
          endif;
      endwhile;
  endif;

  // Fallback: show SVG text logos if no ACF data
  if ( ! $has_acf_brands ) :
  ?>
    <img class="brand-bar__logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/versace.svg' ); ?>" alt="Versace">
    <img class="brand-bar__logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/zara.svg' ); ?>" alt="Zara">
    <img class="brand-bar__logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/gucci.svg' ); ?>" alt="Gucci">
    <img class="brand-bar__logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/prada.svg' ); ?>" alt="Prada">
    <img class="brand-bar__logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/calvinklein.svg' ); ?>" alt="Calvin Klein">
  <?php endif; ?>
</section>

<?php
// ========================================
// NEW ARRIVALS
// ========================================
$na_title = '';
$na_category = '';

if ( function_exists( 'get_field' ) ) {
    $na_title    = get_field( 'new_arrivals_title' );
    $na_category = get_field( 'new_arrivals_category' );
}

if ( ! $na_title ) $na_title = 'NEW ARRIVALS';

// Build WooCommerce product query
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => 4,
    'post_status'    => 'publish',
);

if ( $na_category ) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $na_category,
        ),
    );
}

$products = new WP_Query( $args );
?>

<section class="new-arrivals">
  <h2 class="new-arrivals__title"><?php echo esc_html( $na_title ); ?></h2>

  <?php if ( $products->have_posts() ) : ?>
    <div class="new-arrivals__grid">
      <?php while ( $products->have_posts() ) : $products->the_post();
        global $product;
        $rating       = $product ? $product->get_average_rating() : 0;
        $price_html   = $product ? $product->get_price_html() : '';
        $regular      = $product ? $product->get_regular_price() : '';
        $sale         = $product ? $product->get_sale_price() : '';
      ?>
        <div class="product-card">
          <div class="product-card__image">
            <?php if ( has_post_thumbnail() ) : ?>
              <?php the_post_thumbnail( 'medium' ); ?>
            <?php else : ?>
              <img src="<?php echo esc_url( wc_placeholder_img_src( 'medium' ) ); ?>" alt="<?php the_title_attribute(); ?>">
            <?php endif; ?>
          </div>

          <h3 class="product-card__name"><?php the_title(); ?></h3>

          <div class="product-card__rating">
            <?php echo toposel_render_stars( floatval( $rating ) ); ?>
            <span class="product-card__rating-text"><?php echo esc_html( $rating ); ?>/5</span>
          </div>

          <div class="product-card__price">
            <?php if ( $sale ) : ?>
              <span class="product-card__current-price">$<?php echo esc_html( $sale ); ?></span>
              <span class="product-card__original-price">$<?php echo esc_html( $regular ); ?></span>
              <?php
                $discount = round( ( ( $regular - $sale ) / $regular ) * 100 );
              ?>
              <span class="product-card__discount">-<?php echo esc_html( $discount ); ?>%</span>
            <?php else : ?>
              <span class="product-card__current-price">$<?php echo esc_html( $regular ); ?></span>
            <?php endif; ?>
          </div>
        </div>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>

    <div class="view-all">
      <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="view-all__button">View All</a>
    </div>

  <?php else : ?>
    <!-- Fallback: hardcoded product cards for preview before WooCommerce products are added -->
    <div class="new-arrivals__grid">
      <div class="product-card">
        <div class="product-card__image">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/product1.svg' ); ?>" alt="T-shirt with Tape Details">
        </div>
        <h3 class="product-card__name">T-shirt with Tape Details</h3>
        <div class="product-card__rating">
          <?php echo toposel_render_stars( 4.5 ); ?>
          <span class="product-card__rating-text">4.5/5</span>
        </div>
        <div class="product-card__price">
          <span class="product-card__current-price">$120</span>
        </div>
      </div>

      <div class="product-card">
        <div class="product-card__image">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/product2.svg' ); ?>" alt="Skinny Fit Jeans">
        </div>
        <h3 class="product-card__name">Skinny Fit Jeans</h3>
        <div class="product-card__rating">
          <?php echo toposel_render_stars( 3.5 ); ?>
          <span class="product-card__rating-text">3.5/5</span>
        </div>
        <div class="product-card__price">
          <span class="product-card__current-price">$240</span>
          <span class="product-card__original-price">$260</span>
          <span class="product-card__discount">-20%</span>
        </div>
      </div>
    </div>

    <div class="view-all">
      <a href="#" class="view-all__button">View All</a>
    </div>
  <?php endif; ?>
</section>

<?php get_footer(); ?>
