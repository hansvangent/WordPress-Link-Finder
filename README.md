# WordPress Bitly Link Finder
A WordPress tool to help you find and manage Bitly shortened URLs within your WordPress content. 

Bitly is making changes to its free plan, and it’s not great news for business owners that have bit.ly links in their content.

Starting next month, free Bitly links and QR codes will include a preview page before redirecting users to the actual destination. That preview page may include advertising,(so we all know thats legal speech for: it will most definitely have ads) This all means an extra step,potential distractions, and a drop in click-through rates.

So pay for a paid account or use another service.

This little tool helps you find all the bit.ly links in your WordPress content, so you can update them before they affect your visitors.

## Why This Tool?
Starting March 2025, Bitly will show interstitial ads before redirecting users when using free-tier shortened links. This means:
- Users will see ads before reaching your content
- Potential drop-off in click-through rates
- Degraded user experience
- Impact on analytics tracking

## Features
- **Easy to Use:** Simple interface under the WordPress Tools menu
- **Comprehensive Search:** Scans all posts, pages, and custom post types
- **Multiple Domain Support:** Finds links from:
  - bit.ly
  - bitly.com
  - j.mp
- **Detailed Results:** Shows:
  - Post title
  - Post status (published, draft, etc.)
  - Link context (surrounding content)
  - Bitly link
  - Quick edit access
- **Context Preview:** See how the link is used in your content

## Quick Start

1. Add the file to your WordPress theme's directory.
2. Add the class to your theme's `functions.php`:

```php
require_once get_template_directory() . '/inc/usergrowth-find-bitly.php';
new FindBitlyLinks();
```

If you're using a child theme use the following code:

```php
require_once get_stylesheet_directory() . '/inc/usergrowth-find-bitly.php';
new FindBitlyLinks();
```

## Usage
1. Go to Tools > Find Bitly Links in your WordPress admin
2. Click the "Find Bitly Links" button
3. View the results table showing:
   - Post title
   - Post status
   - Context where the link appears
   - Bitly link
   - Edit button for quick access to the post
  
## Not using WordPress? Use Screaming Frog

If you’re not on WordPress you can also use Screaming Frog to find all your Bitly links on your site.

In Screaming Frog, you can quickly find all instances of Bitly links on your website by following these steps:

 1. Crawl your website – Enter your domain and start the crawl.
 2. Use the Search function – Go to “Internal” → “Search” (Ctrl + F on Windows / Cmd + F on Mac).
 3. Enter the search term – Type bit.ly, bitly.com, or j.mp and select “Contains” to find all occurrences.
 4. Review the results – This will show all pages where these short URLs are present.
 5. Export the data – Use the “Export” button if you need to replace or update the links.

Alternatively, you can use the “Custom Search” feature under Configuration → Custom → Search, add bit.ly, bitly.com, and j.mp as search terms, and rerun the crawl for a detailed extraction.

## Get Help

- Reach out on [Twitter](https://twitter.com/jcvangent)
- Reach out on [Threads](https://www.threads.net/@jcvangent)
- Open an [issue on GitHub](https://github.com/hansvangent/WordPress-Bitly-Link-Finder/issues/new)

## Contribute

#### Issues

For a bug report, bug fix, or a suggestion, please feel free to open an issue.

#### Pull request

Pull requests are always welcome, and I'll do my best to do reviews as quickly as possible.
