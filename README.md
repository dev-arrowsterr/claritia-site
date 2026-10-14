# Claritia site theme

The custom WordPress theme for tryclaritia.com. Hostinger deploys the `main` branch to
`public_html/wp-content/themes/claritia`.

It is a port of the Next.js homepage in the app repo (`src/app/page.tsx`). The page looks the same,
uses the same words, and sends every button to the same place. It is plain PHP, HTML and CSS.
There is no build step, no page builder and no JavaScript.

## How it is built

```
style.css            theme header (WordPress needs it)
functions.php        settings, CSS loading, <head> tags (description, canonical, share tags, icons)
header.php           top bar, shared by every page
footer.php           footer, shared by every page
index.php            blog list, search results, archives
single.php           one blog post
page.php             a plain page written in the WordPress editor
404.php              page not found
assets/base.css      brand tokens, reset, logo, tags, buttons, header, footer
assets/brand/        favicon, icon, apple touch icon, share image (og-image.png)
pages/home/          the homepage: home.php and home.css
blog/                blog list, post and page parts, blog.css (also styles the 404)
inc/plans.php        the plans, for the pricing cards and /pricing.md
inc/parts.php        logo, status tags and icons
inc/text.php         serves /llms.txt and /pricing.md, sends old app links to the app
inc/deploy.php       clears the Hostinger cache after each deploy
```

The front page always uses `pages/home`, whatever is set in Settings → Reading.

## How to edit

- **Homepage words**: `pages/home/home.php`. Lists (steps, stats, cards) sit at the top of the file.
- **Homepage look**: `pages/home/home.css`. Colors and shared pieces are in `assets/base.css`.
- **Top bar and footer links**: the `$nav` list in `header.php` and the `$cols` list in `footer.php`.
- **Prices and plan limits**: `CL_PLANS` in `inc/plans.php`. It matches `src/lib/plans.ts` in the app.
  Change both together. The homepage cards and /pricing.md update from it.
- **/llms.txt**: `cl_llms_txt()` in `inc/text.php`. It matches `src/app/llms.txt/route.ts` in the app.
- **App address, contact email, company name**: `CL_APP`, `CL_EMAIL` and `CL_COMPANY` in `functions.php`.
- **Description and share tags**: `CL_DESCRIPTION` and `cl_head()` in `functions.php`.
  If an SEO plugin (Yoast, Rank Math, AIOSEO, SEOPress) is active, it prints these tags instead.

Sizes follow the app. The page font size is 14px, so `1rem` is 14px. Breakpoints are 640px, 768px and 1024px.
Follow `docs/brand.md` in the app repo: square boxes, 6px corners on buttons and fields, square tags,
no shadows on cards, no gradients, no emoji.

## Pages that need no WordPress page

| Path | What it serves |
|---|---|
| `/llms.txt` | A short guide to Claritia for AI tools (`text/plain`) |
| `/pricing.md` | The plans as a Markdown table (`text/markdown`) |
| `/tests`, `/runs`, `/settings` and the other app paths | A 308 redirect to the same path on app.tryclaritia.com |

These work because WordPress's standard `.htaccess` sends any path that isn't a real file to `index.php`.
The app redirect only runs when WordPress has no page at that path. The list is `CL_APP_PATHS` in `inc/text.php`.

The Next.js site had no Privacy or Terms pages and no links to them, so this theme has none either.
When they are written, add them the same way as the Arrowsterr theme does (`inc/legal.php` there).

## Hostinger setup

1. **Create the site.** In hPanel, go to Websites → Add website → WordPress, and pick tryclaritia.com.
   Finish the WordPress install and sign in to `tryclaritia.com/wp-admin`.
2. **Connect this repo.** In hPanel, open the site, then Advanced → Git.
   - Repository: this repo's GitHub address. For a private repo, add the deploy key hPanel shows to the repo
     (GitHub → Settings → Deploy keys).
   - Branch: `main`.
   - Install path: `public_html/wp-content/themes/claritia`. The folder must be empty, so delete it first if it exists.
   - Create, then press Deploy. Turn on auto deployment and add the webhook URL hPanel gives you to the
     GitHub repo (Settings → Webhooks), so each push to `main` deploys.
3. **Turn on the theme.** In wp-admin, go to Appearance → Themes and activate Claritia.
4. **Set the front page.** Settings → Reading. Either choice works, because the theme always shows the
   homepage at `/`. To keep a blog, create an empty page called "Blog" and pick "A static page", with any
   page as the homepage and "Blog" as the posts page.
5. **Set the addresses.** Settings → General: WordPress Address and Site Address are both `https://tryclaritia.com`.
   WordPress then sends `www.tryclaritia.com` to `tryclaritia.com`.
6. **Permalinks.** Settings → Permalinks: pick "Post name" and save. This writes the `.htaccess` that
   /llms.txt and /pricing.md need.
7. **Check.** Open `/`, `/llms.txt`, `/pricing.md` and `/tests` (it should land on app.tryclaritia.com/tests).
   If you see an old page, purge the cache in hPanel (Performance → Cache Manager). After that the theme
   clears it on each deploy (`inc/deploy.php`).

## DNS

The DNS for tryclaritia.com is managed in Hostinger (hPanel → Domains → tryclaritia.com → DNS).

- `tryclaritia.com` and `www.tryclaritia.com` point to Hostinger. Until this site is live they still point
  to Render (the old Next.js site). To switch, replace those two Render records with the ones hPanel gives
  for the website (an A record for `@` and a CNAME for `www`).
- `app.tryclaritia.com` points to the app on Fly.io (a CNAME to `claritia-web.fly.dev`). Leave it as it is.
- Leave the Resend records for the test inboxes (`inbox.tryclaritia.com`) as they are.

Once `tryclaritia.com` points here, visits to it never reach the Next.js app, so the app needs no change.
The app keeps its own copy of /llms.txt and /pricing.md on app.tryclaritia.com.

## Running cost

| Item | Beta (50 teams) | Growth (500 teams) |
|---|---|---|
| Hostinger WordPress hosting | Already paid with the Hostinger plan that hosts arrowsterr.com, if it has a free site slot (check) | Same (check) |
| Google Fonts, no tracking, no paid plugins | $0 | $0 |
| Total added to the monthly bill | $0 if a site slot is free (check) | $0 (check) |

The site makes no AI calls.
