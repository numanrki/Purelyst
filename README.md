# Purelyst WordPress Theme

<p align="center">
  <img src="https://img.shields.io/badge/Version-1.0.22-blue?style=flat-square" alt="Version">
  <img src="https://img.shields.io/badge/WordPress-6.0%2B-blue?style=flat-square&logo=wordpress" alt="WordPress">
  <img src="https://img.shields.io/badge/PHP-7.4%2B-purple?style=flat-square&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/License-GPL--2.0%2B-green?style=flat-square" alt="License">
  <img src="https://img.shields.io/badge/Core_Web_Vitals-Passed-brightgreen?style=flat-square" alt="Core Web Vitals">
</p>

<p align="center">
  A minimalist, performance-optimized WordPress theme dedicated to clarity, design, and intentional living.
</p>

---

## 🌟 Overview

**Purelyst** is an open-source, modern WordPress theme designed for bloggers, writers, and content creators who value simplicity, readability, and blazing-fast performance. Built with Core Web Vitals in mind, it delivers an exceptional user experience while maintaining a beautiful, contemporary aesthetic.

## ✨ Features

### Design & UX
- 🎨 **Clean, Minimalist Design** - Focus on content with elegant typography and generous whitespace
- 📱 **Fully Responsive** - Optimized layouts for desktop, tablet, and mobile devices
- 🌙 **Dark Mode Support** - Automatic dark mode based on system preferences
- 🖼️ **Hero Section** - Stunning featured post showcase on homepage
- 📰 **CSS Grid Layout** - Modern grid-based article cards

### Performance
- ⚡ **Core Web Vitals Optimized** - Excellent LCP, FCP, CLS, and TBT scores
- 🚀 **Critical CSS Inlining** - Above-the-fold styles render instantly
- 🔄 **Lazy Loading** - Images load on-demand for faster initial page load
- 📦 **Minimal Dependencies** - No bloated frameworks or libraries
- 🗜️ **Optimized Assets** - Deferred scripts and async stylesheets

### Customization
- 🎛️ **Admin Settings Panel** - Comprehensive theme options with live preview
- 🎨 **WordPress Customizer** - Easy visual customization
- 🔤 **Typography Options** - Choose from multiple font families and weights
- 🌈 **Color Customization** - Primary, accent, and background color controls
- 📝 **Read More Button** - Customizable button text and colors

### Developer Friendly
- ♿ **Accessibility Ready** - WCAG compliant with proper ARIA labels and skip links
- 🌍 **Translation Ready** - Full internationalization (i18n) support
- 🔍 **SEO Optimized** - Clean, semantic HTML structure
- 📋 **Well Documented** - Clear code comments and documentation
- 🧩 **Hooks & Filters** - Extensible via WordPress actions and filters

## 📊 Core Web Vitals Performance

Tested on Google PageSpeed Insights (Mobile - Slow 4G throttling):

| Metric | Score | Status |
|--------|-------|--------|
| **Performance** | 92+ | 🟢 Good |
| **LCP** (Largest Contentful Paint) | < 2.5s | 🟢 Good |
| **FCP** (First Contentful Paint) | < 2.5s | 🟢 Good |
| **CLS** (Cumulative Layout Shift) | 0 | 🟢 Good |
| **TBT** (Total Blocking Time) | 0ms | 🟢 Good |

### Performance Optimizations Included:
- Preconnect hints for Google Fonts
- Critical font preloading
- Deferred JavaScript loading
- Conditional block library CSS removal
- Responsive images with srcset
- Explicit image dimensions for CLS prevention
- `fetchpriority="high"` for LCP images

## 🚀 Installation

### From WordPress Admin
1. Download the theme zip file from [GitHub Releases](https://github.com/numanrki/Purelyst/releases)
2. Go to **WordPress Admin → Appearance → Themes**
3. Click **"Add New" → "Upload Theme"**
4. Choose the downloaded zip file and click **"Install Now"**
5. Activate the theme

### From GitHub
```bash
cd wp-content/themes/
git clone https://github.com/numanrki/Purelyst.git
```

## ⚙️ Configuration

### Theme Settings Panel
Navigate to **Appearance → Purelyst** to access:

| Tab | Options |
|-----|---------|
| **General** | Logo, Favicon, Site Identity |
| **Customize** | Read More Button, Author Box |
| **Typography** | Font Family, Weights, Line Height |
| **Colors** | Primary, Accent, Background, Text |
| **Footer** | Copyright, Tagline, Social Links |

### Customizer Options
Navigate to **Appearance → Customize** to configure:

- **Hero Section** - Featured post selection and badge text
- **Sidebar Settings** - Author widget configuration
- **Newsletter Widget** - Email signup form
- **Header Settings** - Search toggle, Subscribe button
- **Social Links** - Social media profile URLs

### Menu Locations

| Location | Description |
|----------|-------------|
| **Primary Menu** | Main navigation in header |
| **Footer Explore** | First footer column menu |
| **Footer Company** | Second footer column menu |

### Widget Areas

| Area | Location |
|------|----------|
| **Sidebar** | Single post sidebar |
| **Footer Widget Area** | Footer section |

## 📁 Theme Structure

```
purelyst/
├── 📁 assets/
│   ├── 📁 css/
│   │   ├── admin-style.css      # Admin panel styles
│   │   └── editor-style.css     # Block editor styles
│   ├── 📁 images/
│   │   └── placeholder.svg      # Placeholder image
│   └── 📁 js/
│       ├── admin.js             # Admin panel scripts
│       ├── customizer.js        # Live preview scripts
│       └── main.js              # Frontend scripts
├── 📁 inc/
│   ├── admin-settings.php       # Admin settings panel
│   ├── customizer.php           # Customizer options
│   └── template-tags.php        # Template helper functions
├── 📁 template-parts/
│   ├── content-card.php         # Article card template
│   └── content-none.php         # No content template
├── 404.php                      # 404 error page
├── archive.php                  # Archive template
├── comments.php                 # Comments template
├── footer.php                   # Footer template
├── front-page.php               # Homepage template
├── functions.php                # Theme functions
├── header.php                   # Header template
├── index.php                    # Main template
├── page.php                     # Page template
├── search.php                   # Search results
├── searchform.php               # Search form
├── sidebar.php                  # Sidebar template
├── sidebar-single.php           # Single post sidebar
├── single.php                   # Single post template
├── style.css                    # Main stylesheet
└── theme.json                   # Block editor config
```

## 📋 Requirements

| Requirement | Version |
|-------------|---------|
| WordPress | 6.0 or higher |
| PHP | 7.4 or higher |
| Tested up to | WordPress 6.7 |

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📜 Changelog

### Version 1.0.22 (Current)
- ⚡ Performance optimizations for Core Web Vitals
- 🔧 Critical CSS inlining
- 🖼️ LCP image preloading
- 📦 Conditional block library CSS removal
- 🔄 Deferred JavaScript loading
- 🎨 Author box moved to post content
- ✨ Admin settings panel improvements

### Version 1.0.0
- 🎉 Initial release

## 👤 Author

**Numan Rasheed**

- WordPress.org: [@numanrki](https://profiles.wordpress.org/numanrki/)
- GitHub: [@numanrki](https://github.com/numanrki)
- Twitter: [@numanrki](https://twitter.com/numanrki)

## 📄 License

This project is licensed under the **GNU General Public License v2 or later**.

See [LICENSE](http://www.gnu.org/licenses/gpl-2.0.html) for more information.

---

<p align="center">
  Made with ❤️ for the WordPress community
</p>

<p align="center">
  ⭐ Star this repository if you find it helpful!
</p>

## Changelog

### 1.0.0
- Initial release
