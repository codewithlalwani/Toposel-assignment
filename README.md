# Toposel E-commerce WordPress Theme

A mobile-first e-commerce WordPress theme built for the Toposel assignment.

## Requirements

- A local WordPress installation (Local, XAMPP, MAMP, or similar)
- PHP and MySQL versions supported by your WordPress installation
- WordPress admin access
- WooCommerce (recommended for displaying real products)
- Advanced Custom Fields / ACF (optional for editing homepage content)

No `npm install` or frontend build command is required.

## Run the theme locally with Local

1. Open **Local** and create a new WordPress site, or start an existing site.

2. Open the site's folder from Local and go to:

   ```text
   app/public/wp-content/themes/
   ```

3. Clone this repository inside the `themes` directory:

   ```bash
   git clone https://github.com/codewithlalwani/Toposel-assignment.git toposel-ecommerce
   ```

   If you already downloaded the repository, copy its entire folder into the `themes` directory instead.

4. In Local, click **Start site**, then click **WP Admin**.

5. In the WordPress dashboard, go to **Appearance > Themes** and activate **Toposel E-commerce**.

6. Open the site's home URL. WordPress automatically uses `front-page.php` for the homepage.

## Optional plugin setup

### WooCommerce

To display products from WordPress instead of the included demo products:

1. Go to **Plugins > Add New Plugin**.
2. Search for **WooCommerce**, install it, and activate it.
3. Complete the WooCommerce setup wizard.
4. Go to **Products > Add New** and add products with images, regular prices, sale prices, and ratings.

The homepage displays up to four published products. Until products are available, it shows the theme's demo product cards.

### Advanced Custom Fields (ACF)

ACF is optional. The theme works with default content when it is not installed.

After installing and activating ACF, create fields matching the field names used by the theme:

- `hero_heading`
- `hero_subheading`
- `hero_button_text`
- `hero_button_link`
- `hero_image`
- `brand_logos`
- `new_arrivals_title`
- `new_arrivals_category`

## Troubleshooting

- **Theme is not listed:** Confirm the folder containing `style.css` is directly inside `wp-content/themes/` and is not nested inside another folder.
- **Old styles are showing:** Hard-refresh the browser or clear the Local/WordPress cache.
- **Products are not showing:** Confirm WooCommerce is active and the products are published.
- **Homepage is not showing:** Go to **Settings > Reading** and check the homepage setting. The theme's `front-page.php` should be used for the site front page.

## Theme structure

```text
toposel-ecommerce/
├── assets/images/   Theme images and brand logos
├── footer.php       Site footer
├── front-page.php   Homepage template
├── functions.php    Theme setup and WordPress integrations
├── header.php       Site header
├── index.php        Default WordPress template
└── style.css        Theme metadata and styles
```
