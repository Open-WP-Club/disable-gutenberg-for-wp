# Disable Gutenberg for WP

Enable or disable Gutenberg editor for specific post types in WordPress. Perfect for sites where you want to use Classic Editor for selected content while keeping Gutenberg for others.

![WordPress Plugin](https://img.shields.io/badge/WordPress-%3E%3D6.0-blue.svg)
![PHP Version](https://img.shields.io/badge/PHP-%3E%3D7.4-8892BF.svg)
![License](https://img.shields.io/badge/license-GPL--2.0%2B-green.svg)

## Features

- ✅ **Selective Control**: Disable Gutenberg editor for selected post types
- 🎨 **Modern UI**: Clean, intuitive admin interface with toggle switches
- 🔒 **Smart Defaults**: Excludes Media (attachment) post type automatically
- ⚡ **Lightweight**: Minimal performance impact
- 🎯 **Custom Post Types**: Works seamlessly with custom post types
- ♿ **Accessible**: Built following WordPress accessibility standards
- 🌐 **Translation Ready**: Fully internationalized and ready for translation
- 🔐 **Secure**: Follows WordPress security best practices with proper sanitization and nonces

## Requirements

- WordPress 6.0 or higher
- PHP 7.4 or higher

## Installation

### From GitHub

1. Download the latest release or clone this repository:
   ```bash
   git clone https://github.com/Open-WP-Club/disable-gutenberg-for-wp.git
   ```

2. Upload the `disable-gutenberg-for-wp` folder to your `/wp-content/plugins/` directory

3. Activate the plugin through the 'Plugins' menu in WordPress

4. Navigate to **Disable Gutenberg** in the WordPress admin menu

### Manual Installation

1. Download the plugin files
2. Create a folder named `disable-gutenberg-for-wp` in `/wp-content/plugins/`
3. Upload all plugin files to this folder
4. Activate the plugin via the 'Plugins' menu in WordPress

## Usage

1. After activation, go to **Disable Gutenberg** in your WordPress admin menu

2. You'll see a list of all public post types on your site

3. Toggle the switch for any post type where you want to disable Gutenberg:
   - **Toggle ON** (blue) = Gutenberg is disabled, Classic Editor will be used
   - **Toggle OFF** (gray) = Gutenberg remains enabled

4. Click **Save Changes**

5. The selected post types will now use the Classic Editor while others continue using Gutenberg

## Screenshots

### Admin Settings Page
The clean, modern interface allows you to easily toggle Gutenberg on/off for each post type.

### Toggle Controls
Simple toggle switches make it easy to enable or disable Gutenberg for specific post types.

## How It Works

The plugin uses WordPress's built-in `use_block_editor_for_post_type` filter to selectively disable the block editor for chosen post types. This approach:

- ✅ Is officially supported by WordPress
- ✅ Works reliably across WordPress versions
- ✅ Doesn't require any theme modifications
- ✅ Is completely reversible

## Technical Details

### Architecture

The plugin follows WordPress coding standards and modern PHP practices:

- **Object-Oriented Design**: Built using a singleton pattern
- **WordPress Settings API**: Proper integration with WordPress settings
- **Security First**: All inputs sanitized, outputs escaped, capabilities checked
- **Namespaced CSS**: All styles are prefixed to avoid conflicts
- **Hook-Based**: Uses WordPress action and filter hooks

### File Structure

```
disable-gutenberg-for-wp/
├── disable-gutenberg-for-wp.php  # Main plugin file
├── README.md                      # This file
├── assets/
│   └── css/
│       └── admin-style.css        # Admin UI styles
└── includes/
    └── admin-page.php             # Admin page template
```

### Filters

The plugin provides filters for developers:

#### `dgwp_disabled_post_types`
Filter the array of disabled post types.

```php
add_filter( 'dgwp_disabled_post_types', function( $disabled_post_types ) {
    // Always disable Gutenberg for 'book' post type
    $disabled_post_types[] = 'book';
    return $disabled_post_types;
} );
```

## Frequently Asked Questions

### Does this plugin install Classic Editor?

No, this plugin does not install the Classic Editor plugin. It simply disables Gutenberg for selected post types, which causes WordPress to fall back to the classic editing experience. For the full Classic Editor plugin experience, you may want to install the official Classic Editor plugin alongside this one.

### What happens to my existing Gutenberg content?

Your existing content remains unchanged. If you later re-enable Gutenberg for a post type, all block content will work normally.

### Does this work with custom post types?

Yes! The plugin automatically detects all public post types, including custom ones registered by themes and plugins.

### Why is the Media/Attachment post type not shown?

The Media (attachment) post type is excluded by default as it doesn't use the standard editor interface.

### Can I programmatically control which post types are disabled?

Yes, you can use the `dgwp_disabled_post_types` filter in your theme or custom plugin.

### Is this plugin compatible with multisite?

Yes, the plugin works on multisite installations. It needs to be activated per site, and each site can have its own configuration.

## Compatibility

- ✅ WordPress 6.0+
- ✅ PHP 7.4+
- ✅ Multisite compatible
- ✅ Works with all themes
- ✅ Compatible with popular page builders
- ✅ Translation ready

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

### Development Setup

1. Clone the repository
2. Make your changes
3. Test with multiple WordPress versions
4. Submit a pull request

### Coding Standards

This plugin follows:
- WordPress Coding Standards
- PHP_CodeSniffer rules
- WordPress Accessibility Standards

## Support

If you encounter any issues or have questions:

1. Check the [FAQ section](#frequently-asked-questions)
2. Search existing [GitHub Issues](https://github.com/Open-WP-Club/disable-gutenberg-for-wp/issues)
3. Create a new issue with detailed information about your problem

## Changelog

### 1.0.0 - 2025-01-05
- Initial release
- Core functionality to disable Gutenberg per post type
- Modern admin interface with toggle switches
- WordPress Settings API integration
- Translation ready
- Accessibility compliant

## License

This plugin is licensed under the GPL v2 or later.

```
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
```

## Credits

Developed and maintained by [Open WP Club](https://github.com/Open-WP-Club).

## Author

**Open WP Club**
- GitHub: [@Open-WP-Club](https://github.com/Open-WP-Club)

---

Made with ❤️ for the WordPress community