# Changelog — plg_system_fgstripcomments

## 2.0.0 – 2026-08-02
- **Breaking:** renamed the plugin to "FG Strip Comments", the first of
  the FG series of Joomla extensions. The technical element changed from
  `stripcomments` to `fgstripcomments` (folder, PHP namespace, language
  file names, update feed) to avoid any future collision with another
  developer's plugin using the same element name.
- Because the element name changed, this is **not** a smooth in-place
  update from 1.x — Joomla will install it as a new, separate plugin.
  If a 1.x version is already installed somewhere, uninstall it first,
  then install 2.0.0.
- GitHub repository renamed accordingly to `plg_system_fgstripcomments`.

## 1.6.1 – 2026-08-02
- Added the required GPL license header comment to all PHP files
  (`services/provider.php`, `src/Extension/StripComments.php`) — required
  by the JED Checker / Joomla Extensions Directory submission rules.

## 1.6.0 – 2026-08-01
- Added Joomla Update System support (`<updateservers>` in the manifest,
  plus a Joomla-format `updates.xml` feed) — required by the Joomla
  Extensions Directory for all listings submitted after 10 Jan 2017.

## 1.5.0 – 2026-07-28
- In "Whole page" scope (`scope=all`), markers are no longer removed
  inside `<script>` and `<style>` blocks — those are now always left
  untouched (implemented via a PCRE `(*SKIP)(*FAIL)` pattern, with no
  performance cost).

## 1.4.0 – 2026-07-28
- Added Slovak localization (sk-SK) for the plugin settings and description.

## 1.3.0
- "Titles only" scope extended to also cover link text (`<a>`) — this
  catches menu items and breadcrumbs, not just headings and `<title>`.

## 1.2.0
- Added a "Scope" parameter (Whole page / Titles only – headings and
  `<title>`).

## 1.1.0
- Behavior change: instead of stripping HTML comments, the plugin now
  strips custom marker tags `{-- ... --}` (matching the original BIGSHOT
  behavior). Delimiters are configurable.

## 1.0.0
- Initial release — strips HTML comments from the rendered output via
  `onAfterRender`.
