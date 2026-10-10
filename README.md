# OGP WordPress Theme

OGP is a lightweight, fast, and SEO-optimized video streaming theme built for web series, movies, dramas, and TV shows.

---

## Requirements

- WordPress: 5.6 or higher (Tested up to 6.7)
- PHP: 7.4 or higher
- Database: MySQL 5.6+ or MariaDB 10.1+

---

## Post-Activation Setup

Follow these steps immediately after activating the theme on a new WordPress site:

### 1. Install Required Plugins

The theme uses Yet Another Related Posts Plugin (YARPP) to power the related videos section on single post pages.

1. Go to the WordPress Admin dashboard.
2. An admin notice will appear stating that the theme recommends YARPP.
3. Click **Install & Activate YARPP** (or **Activate YARPP** if already installed).
4. Related videos will automatically populate on single video pages based on categories and taxonomy matches.

### 2. Create Directory Pages

The theme includes four custom page templates that provide searchable, sortable directories for your content:

| Page Name | Template Name | Template File | Purpose |
| :--- | :--- | :--- | :--- |
| OTT / Categories | All OTT | `all-categories.php` | Searchable directory of all OTT categories with video counts |
| Series | All Series | `all-series.php` | Searchable directory of all web series terms with live filtering |
| Models / Actresses | All Models | `all-models.php` | Searchable directory of all models and cast members |
| Tags | All Tags | `all-tags.php` | Searchable list of all post tags |

**How to create these pages:**
1. Navigate to **Pages > Add New**.
2. Enter the title (e.g., `OTT`, `Series`, `Models`, or `Tags`).
3. Under **Page Attributes > Template**, select the corresponding template.
4. Click **Publish**.

### 3. Configure Navigation Menus

The theme provides two menu locations:

1. **Primary Menu (`menu-1`)**:
   - Displays in the main header below the search bar.
   - Features responsive horizontal touch scrolling for mobile devices.
   - Recommended items: Links to the homepage, `OTT`, `Series`, `Models`, and `Tags` pages.
2. **Footer Menu (`footer`)**:
   - Displays in the bottom bar next to the copyright notice.
   - Recommended items: `Home`, `Privacy Policy`, `DMCA`, `Contact`.

**Setup:**
1. Go to **Appearance > Menus**.
2. Create or edit your menus and assign them to **Primary** and **Footer Menu** under **Display location**.
3. Save changes.

### 4. Configure the Footer Widget Area

The footer description area is widget-ready:

1. Go to **Appearance > Widgets**.
2. Locate the **Footer Content** widget area.
3. Add a **Paragraph** or **Custom HTML** block containing your site introduction, disclaimer, or legal notices.
4. Save the widget. The content will render above the copyright footer bar.

---

## Publishing Content

When adding or editing a video post under **Posts > Add New**, configure the following:

- **Video Details (Meta Box)**:
  - **Video URL**: Enter the raw stream URL (e.g., MP4 file URL). The theme saves the exact URL without stripping spaces or modifying encoded characters.
  - **Duration**: Enter the runtime (e.g., `25` or `83`).
- **Featured Image**: Set a 16:9 thumbnail. This is used on homepage cards, archive grids, and as the video player poster.
- **Series Taxonomy**: Assign the post to a series term.
- **Model Taxonomy**: Tag the models or actors featured in the video.
- **Category**: Select the OTT platform or main content category.

---

## File Structure

```text
ogp/
├── 404.php                 # Animated SVG 404 page with buttonless search
├── all-categories.php      # Custom page template: All OTT platforms
├── all-models.php          # Custom page template: All Models/Actresses
├── all-series.php          # Custom page template: All Series
├── all-tags.php            # Custom page template: All Tags
├── archive.php             # Unified archive template (Categories, Taxonomies, Tags)
├── footer.php              # Site footer with dynamic widget area
├── functions.php           # Core theme functions, meta boxes, and PUC setup
├── header.php              # Header with logo, search bar, and primary navigation
├── inc/
│   └── plugin-update-checker/  # GitHub update checker library (v5.4)
├── index.php               # Homepage template
├── main.js                 # Frontend scripts
├── page.php                # Standard page template
├── search.php              # Search results template
├── single.php              # Single video post with HTML5 player
├── style.css               # Main stylesheet (Unified dark theme & CSS Grid)
└── template-parts/
    ├── related.php         # Related videos section (YARPP integration)
    └── videos.php          # Responsive video card markup
```

---

## License

This theme is licensed under the GNU General Public License v2 or later.
