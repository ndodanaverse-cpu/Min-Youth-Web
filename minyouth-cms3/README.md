# Ministry of Youth — Admin / CMS

This adds a PHP + MySQL admin system to the website, with two account
types — **Editor** and **Sub Editor** — for managing News, Gallery,
Resources, and Departments without touching code.

## What was added

```
admin/                 Admin panel (login, dashboard, content forms)
config/database.php    Database connection settings — edit this first
includes/              Shared PHP helpers (auth, uploads, CSRF, etc.)
database/schema.sql     Database schema + starter accounts + seed content
uploads/               Where uploaded images/documents are stored
index.php, about.php, contact.php
                        Public entry pages
news.php, gallery.php, resources.php, departments.php, article.php
                        The public pages, now pulling published content
                        from the database instead of hardcoded HTML
```

`index.php`, `about.php`, and `contact.php` are the public entry pages. Home,
About, and Contact Us now run through PHP so they participate in the same
server-side language and shared navigation flow as the other public pages.
All public pages load `assets/js/site-nav.js`, which owns the shared desktop
and mobile navigation markup. Update that file when changing public navigation
so the change is reflected consistently across the site.

Static HTML UI copies are generated from the PHP pages. PHP remains the source
of truth; after CMS content changes, `includes/functions.php` runs
`static-export.php` to refresh the HTML copies automatically. To rebuild them
manually from the project directory, run:

```bash
php static-export.php
```

The exporter writes `index.html`, `about.html`, `contact.html`,
`departments.html`, `gallery.html`, `news.html`, and `resources.html`. It also
creates an `article-<slug>.html` file for each published news article. These
files provide a static front-end/UI copy while PHP remains available for
database-backed actions and live content.

For static hosting, upload the generated `.html` files, the `assets/` folder,
and the root `.htaccess` file. That `.htaccess` sets `index.html` as the
directory homepage, so the hosted root does not try to load `index.php`.

The public language selector is a dropdown in the navigation and chatbot. It
lists Zimbabwe's 15 requested spoken languages: Chewa, Chibarwe, English,
Kalanga, Koisan, Nambya, Ndau, Ndebele, Shangani, Shona, Sotho, Tonga,
Tswana, Venda, and Xhosa. Sign language is intentionally excluded.

The selector currently stores the selected language and routes the page through
the shared PHP language layer. Only English, Shona, and Ndebele dictionaries
currently exist, so the other languages fall back to English until dictionaries
or a translation service are connected.

## 1. Requirements

- PHP 8.0+ with the `pdo_mysql` extension
- MySQL 5.7+ or MariaDB 10.3+
- Any standard web host/server with Apache or Nginx + PHP-FPM (this also
  runs fine on shared hosting such as cPanel), **or XAMPP/WAMP/MAMP for
  local testing**

## 2. Quick start on XAMPP (local testing)

1. Copy the `minyouth-cms3` folder into `C:\xampp\htdocs\` (or your XAMPP
  `htdocs` path). If it is inside a parent `Website` folder, use that folder
  in the local URL as shown below.
2. Start **Apache** and **MySQL** from the XAMPP control panel.
3. Open `http://localhost/phpmyadmin`, click **Import**, choose
   `database/schema.sql`, and run it. This creates the `minyouth_cms`
   database with all tables and starter accounts.
4. `config/database.php` is already set up for XAMPP's defaults
   (`root` user, no password) — no changes needed for local testing.
5. Visit `http://localhost/minyouth-cms3/admin/login.php` and sign in (see
  starter accounts below). For this workspace, use
  `http://localhost/Website/minyouth-cms3/admin/login.php`.

The public home page is `index.php` and the About page is `about.php`.
The old `.html` entry-page URLs were replaced during the PHP migration.

> **Note:** if your XAMPP MySQL root account *does* have a password,
> or you're on a different local stack, update the database environment
> variables `MINYOUTH_DB_HOST`, `MINYOUTH_DB_PORT`, `MINYOUTH_DB_NAME`,
> `MINYOUTH_DB_USER`, and `MINYOUTH_DB_PASS` to match. This keeps production
> credentials out of the codebase.

## 3. Install on a real web host

1. **Upload all files** to your web server (e.g. into `public_html`).
2. **Create a database and database user** through your host's control
   panel (cPanel → MySQL Databases, or `CREATE USER`/`GRANT` if you have
   shell access) — see the optional `CREATE USER` block at the top of
   `database/schema.sql`.
3. **Import the schema**:
   ```bash
   mysql -u youruser -p yourdatabase < database/schema.sql
   ```
   This creates all tables and two starter accounts (see below), plus
   the site's existing 12 departments already published.
4. **Edit `config/database.php`** with your real database host, name,
   username and password (replace the XAMPP `root`/no-password defaults).
5. **Make `uploads/` writable** by the web server, e.g.:
   ```bash
   chmod -R 755 uploads
   ```
6. Visit `https://yourdomain/admin/login.php` and sign in.

## 4. Starter accounts — change these passwords immediately

| Username    | Password        | Role       |
|-------------|-----------------|------------|
| `editor`    | `Editor@2026`   | Editor     |
| `subeditor` | `SubEditor@2026`| Sub Editor |

Sign in and use **My Profile → Change password** right away. An Editor
can also create additional accounts from **Users**.

## 5. How the two roles work

Every piece of content (News, Gallery, Resources, Departments) moves
through a simple workflow: **Draft → Pending → Published** (or
**Rejected**, sent back with feedback).

**Sub Editor**
- Can create new content and edit their own items, as long as those
  items are not yet published.
- Cannot publish directly — instead they **submit for review**, which
  puts the item in the "Pending" queue.
- Cannot delete content or manage user accounts.

**Editor**
- Full control: can create, edit, **publish**, **reject** (with a
  reason sent back to the author), **unpublish**, and **delete** any
  item, in any section.
- Can create and deactivate accounts under **Users** (both Editors and
  Sub Editors). There must always be at least one active Editor.

Only content with status **Published** appears on the public site.

## 6. Scope notes / assumptions made

- **Departments**: the admin manages the department *directory* shown
  on `departments.php` (name, group, description, icon, image, and a
  link). The deeper, individual department pages under
  `assets/departments/department-dedicated-pages/` were left as-is —
  they're full bespoke pages outside a simple admin form. The `link_url`
  field on a department can point to one of these pages, or anywhere else.
- **News categories**: the original design showed different tag colours
  (News/Gallery/Update/Partnerships) per article. To keep the admin form
  simple, all admin-published articles show a single "News" tag. Let me
  know if you'd like per-article tagging added back.
- **Gallery categories** are limited to the five categories already
  wired into the public page's filter strip (Exhibitions, National
  Youth Day, VTC, YSZ, Videos) so filtering keeps working correctly.

## 7. Security notes

- Passwords are hashed with PHP's `password_hash()` (bcrypt).
- All admin forms are protected with CSRF tokens.
- Every permission check (publish/delete/edit/manage users) is enforced
  **server-side**, not just hidden in the UI.
- `config/.htaccess` and `uploads/.htaccess` block direct access to the
  database config and stop PHP files from executing inside `uploads/`
  (Apache only — if you're on Nginx, add equivalent rules, or ask me).
- Change the two starter passwords and the `DB_PASS` placeholder before
  going live.

## 8. If something doesn't connect

If pages show a database connection error, double check:
- `config/database.php` has the correct host/name/user/password
- The database user has privileges on the database (`GRANT ALL ...`)
- The `uploads/` folder exists and is writable

**"Access denied for user ... (using password: YES)"** — this means the
MySQL user in `config/database.php` doesn't exist or the password is
wrong. `database/schema.sql` only creates the *database and tables*,
not a MySQL login. On XAMPP, the simplest fix is to leave
`config/database.php` on its default `root` / no-password — that's
XAMPP's standard account. On a real host, create the user yourself
(via phpMyAdmin or the `CREATE USER` block in `schema.sql`) and make
sure `config/database.php` matches exactly.

## Multi-lingual support (English / ChiShona / isiNdebele)

Fifteen languages are available in the language selector. Visitors switch
between them using the language controls in the navigation bar. The interface
and content use English as a fallback until an editorial translation exists.
The selected language is remembered in a browser cookie for a year.

**What gets translated automatically:**
Navigation, buttons, section headings, empty-state messages, and all
other interface chrome — from the string files in `lang/en.php`,
`lang/sn.php`, `lang/nd.php`.

**What Editors translate manually (via Admin → Translations):**
The actual content — article titles/excerpts/bodies, department names and
descriptions, gallery captions, resource titles — because those are written
by staff and need human translation. Editors and Chief Editors can add
Shona and Ndebele versions for any published item from the Translations
page in the admin panel. The workflow accepts all 15 configured languages.

Automatic translation uses the local Go Free Translate API in
`free-translate-api-main/`. Start that service with `go run main.go`; it listens
on `http://127.0.0.1:8000`. The website sends each value as `{ "text": "...",
"to": "..." }` to `/translate`. Set `FREE_TRANSLATE_API_URL` only when the API
is hosted at a different address.

**Adding a 4th language:**
Create `lang/xx.php` with all the same keys as `lang/en.php`, add `'xx'`
to the `SUPPORTED_LANGS` array in `includes/lang.php`, and add it to the
switcher map in the same function.

## AI Chatbot (Anthropic Claude)

A floating chat bubble appears on every public page (the green Ministry
branding icon, bottom-right). The chatbot:

- Answers visitor questions about ministry programmes, VTCs, the Youth
  Empowerment Fund, National Youth Service, contact details, etc.
- Automatically responds in whichever language the visitor writes in
  (English, ChiShona, isiNdebele, or any other language).
- Has real-time context: it reads published Departments and recent News
  from the database when building its answers.

**To activate the chatbot:**
1. Get an Anthropic API key from https://console.anthropic.com
2. Sign in to the admin panel as **Chief Editor**
3. Go to **Admin → Chatbot Settings**
4. Paste your API key and click Save
5. The chatbot becomes live immediately on all public pages

The Chief Editor can also customise the per-language welcome message,
change the Claude model, and enable or disable the widget entirely from
the same settings page.
