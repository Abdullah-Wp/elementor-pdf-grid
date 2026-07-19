# Elementor PDF Grid Widget

Elementor PDF Grid Widget displays selected PDF documents in a responsive grid with titles, descriptions, thumbnails, and extensive Elementor style controls.

## Features

- Repeater-based PDF document list.
- Custom thumbnail support.
- Automatic first-page thumbnails when WordPress and ImageMagick generate them.
- Local WordPress document icon fallback.
- Responsive columns and gaps.
- Text-above or text-below layouts.
- Border, radius, shadow, typography, color, filter, and hover controls.
- PDFs open in a new tab with safe link attributes.

## Requirements

- WordPress 6.0 or newer.
- PHP 7.4 or newer.
- Elementor.
- Optional ImageMagick support for automatic PDF preview images.

## Installation

1. Download the latest release ZIP.
2. In WordPress, open **Plugins > Add New > Upload Plugin**.
3. Upload and activate the plugin.
4. Edit a page with Elementor.
5. Add **PDF Grid** and configure documents in the repeater.

## PDF thumbnails

WordPress can generate an image from the first page of an uploaded PDF when the server's image-processing stack supports PDF previews. If no generated image is available, select a custom thumbnail. Otherwise, the plugin uses WordPress's local document icon and makes no request to a placeholder service.

## Development

Run syntax checks with:

```text
php -l elementor-pdf-grid.php
php -l widgets/class-pdf-grid-widget.php
```

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).
