<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Shop the latest fashion trends. Find clothes that match your style at SHOP.CO">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
// ── Announcement Bar ──
$announcement = '';
if ( function_exists( 'get_field' ) ) {
    $announcement = get_field( 'announcement_bar_text', 'option' );
}
if ( ! $announcement ) {
    $announcement = 'Sign up and get 20% off to your first order. <a href="#">Sign Up Now</a>';
}
?>
<div class="announcement-bar" id="announcement-bar">
  <p class="announcement-bar__text"><?php echo wp_kses_post( $announcement ); ?></p>
  <button class="announcement-bar__close" aria-label="Close announcement" onclick="document.getElementById('announcement-bar').style.display='none'">✕</button>
</div>

<?php // ── Header ── ?>
<header class="site-header">
  <div class="site-header__left">
    <button class="site-header__menu-toggle" aria-label="Open menu">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__logo">SHOP.CO</a>
  </div>
  <div class="site-header__actions">
    <a href="#" aria-label="Search">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    </a>
    <a href="<?php echo esc_url( function_exists('wc_get_cart_url') ? wc_get_cart_url() : '#' ); ?>" aria-label="Cart">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
    </a>
    <a href="<?php echo esc_url( function_exists('wc_get_account_endpoint_url') ? wc_get_page_permalink('myaccount') : '#' ); ?>" aria-label="Account">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    </a>
  </div>
</header>
