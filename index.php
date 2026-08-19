<?php
/**
 * The main template file.
 *
 * WordPress uses front-page.php for the homepage.
 * This file acts as the fallback for all other pages.
 *
 * @package Toposel_Ecommerce
 */

get_header();
?>

<main>
  <?php
  if ( have_posts() ) :
      while ( have_posts() ) : the_post();
          the_content();
      endwhile;
  endif;
  ?>
</main>

<?php get_footer(); ?>
