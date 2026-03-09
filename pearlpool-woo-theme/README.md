# PearlPool WooCommerce Theme

A modern WooCommerce theme inspired by [pearlpool.ru](https://pearlpool.ru/) with automatic setup, navigation menu, widgets, and demo data importer.

## Features

- **Modern Navigation**: Clean, responsive navigation similar to pearlpool.ru
- **Automatic Setup**: Pages, menus, and widgets are created automatically on theme activation
- **Demo Importer**: One-click button in admin panel to import demo content
- **WooCommerce Ready**: Full WooCommerce integration with custom styling
- **Responsive Design**: Mobile-first, works on all devices
- **SEO Optimized**: Proper HTML5 structure and schema markup
- **Performance**: Lightweight and fast loading

## Installation

1. Download the theme folder `pearlpool-woo-theme`
2. Upload to `/wp-content/themes/` directory
3. Activate the theme from WordPress Admin > Appearance > Themes

## Automatic Setup

Upon theme activation, the following will be created automatically:

### Pages
- Home (set as front page)
- Shop (set as WooCommerce shop page)
- About Us
- Delivery & Payment
- Warranty
- Contacts
- Blog

### Menus
- Primary Menu (header navigation)
- Footer Menu
- Mobile Menu

### Widgets
- Footer Widget Areas (3 columns)
- Shop Sidebar with product categories and price filter
- Main Sidebar

### Settings
- WooCommerce currency set to RUB
- Product display settings configured
- Image sizes optimized

## Demo Importer

Access the demo importer from:
**WordPress Admin > Appearance > Demo Importer**

Click the "📦 Import Demo Content" button to populate your site with sample content.

## Customization

### Colors
Edit CSS variables in `style.css`:
```css
:root {
    --color-primary: #0066cc;
    --color-secondary: #f5f5f5;
    /* ... */
}
```

### Logo
Go to **Appearance > Customize > Site Identity** to upload your logo.

### Menus
Go to **Appearance > Menus** to customize navigation.

### Widgets
Go to **Appearance > Widgets** to manage widget areas.

## Template Files

```
pearlpool-woo-theme/
├── functions.php           # Theme functions and features
├── style.css               # Main stylesheet
├── header.php              # Header template
├── footer.php              # Footer template
├── index.php               # Main template
├── front-page.php          # Front page template
├── sidebar.php             # Sidebar template
├── 404.php                 # 404 error page
├── search.php              # Search results
├── css/
│   └── custom.css          # Additional styles
├── js/
│   └── scripts.js          # JavaScript functionality
├── inc/
│   ├── class-demo-importer.php  # Demo importer class
│   ├── template-functions.php   # Template helper functions
│   └── woocommerce-functions.php # WooCommerce customizations
└── images/                 # Theme images
```

## Requirements

- WordPress 5.8 or higher
- PHP 7.4 or higher
- WooCommerce plugin

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

## Changelog

### Version 1.0.0
- Initial release
- Automatic page, menu, and widget creation
- Demo importer functionality
- WooCommerce integration
- Responsive design

## License

This theme is licensed under the GNU General Public License v2 or later.

## Support

For support and questions, please contact the theme developer.

---

Made with ❤️ for WooCommerce stores
