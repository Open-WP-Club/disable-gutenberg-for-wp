# Disable Gutenberg for WP

Enable or disable Gutenberg editor for specific post types in WordPress. Perfect for sites where you want to use Classic Editor for selected content while keeping Gutenberg for others.

## Features

- Disable Gutenberg editor for selected post types
- Minimal performance impact
- Works seamlessly with custom post types

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

4. Navigate to **Tools > Disable Gutenberg** in the WordPress admin menu

### Manual Installation

1. Download the plugin files
2. Create a folder named `disable-gutenberg-for-wp` in `/wp-content/plugins/`
3. Upload all plugin files to this folder
4. Activate the plugin via the 'Plugins' menu in WordPress

## Usage

1. After activation, go to **Tools > Disable Gutenberg** in your WordPress admin menu

2. You'll see a list of all public post types on your site

3. Toggle the switch for any post type where you want to disable Gutenberg

4. Click Save Changes

5. The selected post types will now use the Classic Editor while others continue using Gutenberg

## How It Works

The plugin uses WordPress's built-in `use_block_editor_for_post_type` filter to selectively disable the block editor for chosen post types. This approach:

- Is officially supported by WordPress
- Works reliably across WordPress versions
- Doesn't require any theme modifications
- Is completely reversible

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

- WordPress 6.0+
- PHP 7.4+
- Multisite compatible
- Works with all themes
- Compatible with popular page builders
- Translation ready

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.
